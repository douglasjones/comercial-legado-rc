#!/usr/bin/env php
<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Este script deve ser executado via CLI.\n");
    exit(1);
}

ini_set('memory_limit', '1024M');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$rootDir = dirname(__DIR__);
$defaultFile = $rootDir . '/data/carteira atualizada.xlsx';
$defaultEnv = $rootDir . '/.env';

$options = getopt('', array(
    'file::',
    'env::',
    'db-host::',
    'db-port::',
    'db-name::',
    'db-user::',
    'db-pass::',
    'mailing::',
    'operadora::',
    'usuario-id::',
    'conta-id::',
    'polo-id::',
    'limit::',
    'dry-run',
    'help'
));

if (isset($options['help'])) {
    echo "Uso:\n";
    echo "  php scripts/import_carteira_atualizada.php [--dry-run] [--limit=100]\n\n";
    echo "Opcoes:\n";
    echo "  --file=ARQUIVO_XLSX        Arquivo de entrada. Padrao: data/carteira atualizada.xlsx\n";
    echo "  --env=ARQUIVO_ENV          Arquivo .env do projeto. Padrao: .env\n";
    echo "  --db-host=HOST             Host do MySQL. Padrao: 127.0.0.1\n";
    echo "  --db-port=PORTA            Porta do MySQL. Padrao: 3307\n";
    echo "  --db-name=NOME             Banco de dados\n";
    echo "  --db-user=USUARIO          Usuario do banco\n";
    echo "  --db-pass=SENHA            Senha do banco\n";
    echo "  --mailing=NOME             Nome do mailing a ser usado/criado. Padrao: Carga atualizada\n";
    echo "  --operadora=NOME           Operadora alvo. Padrao: Claro\n";
    echo "  --usuario-id=ID            Usuario para auditoria e criacao. Padrao: 2\n";
    echo "  --conta-id=ID              Conta padrao para novos leads/mailing. Padrao: 1\n";
    echo "  --polo-id=ID               Polo padrao para novos leads/mailing. Padrao: 1\n";
    echo "  --limit=NUM                Limita a quantidade de linhas processadas\n";
    echo "  --dry-run                  Processa sem gravar no banco\n";
    exit(0);
}

$envPath = isset($options['env']) ? (string)$options['env'] : $defaultEnv;
$env = file_exists($envPath) ? parse_ini_file($envPath, false, INI_SCANNER_RAW) : array();
if ($env === false) {
    fwrite(STDERR, "Falha ao ler o arquivo .env em {$envPath}\n");
    exit(1);
}

$filePath = isset($options['file']) ? (string)$options['file'] : $defaultFile;
if (!is_file($filePath)) {
    fwrite(STDERR, "Arquivo XLSX nao encontrado: {$filePath}\n");
    exit(1);
}

$dbHost = (string)($options['db-host'] ?? ($env['DB_HOST'] ?? '127.0.0.1'));
if ($dbHost === 'db' || $dbHost === '') {
    $dbHost = '127.0.0.1';
}
$dbPort = (int)($options['db-port'] ?? 3307);
$dbName = (string)($options['db-name'] ?? ($env['DB_NAME'] ?? 'wwgepr_crm_antigo'));
$dbUser = (string)($options['db-user'] ?? ($env['DB_USER'] ?? 'crm_user'));
$dbPass = (string)($options['db-pass'] ?? ($env['DB_PASS'] ?? ''));
$mailingName = trim((string)($options['mailing'] ?? 'carteira atualizada'));
$operatorName = trim((string)($options['operadora'] ?? 'Claro'));
$defaultUserId = (int)($options['usuario-id'] ?? 2);
$defaultAccountId = (int)($options['conta-id'] ?? 1);
$defaultPoloId = (int)($options['polo-id'] ?? 1);
$limit = isset($options['limit']) ? (int)$options['limit'] : 0;
$dryRun = array_key_exists('dry-run', $options);

$stats = array(
    'rows_total' => 0,
    'rows_processed' => 0,
    'rows_skipped_no_cnpj' => 0,
    'leads_created' => 0,
    'leads_updated' => 0,
    'lead_ops_created' => 0,
    'lead_ops_updated' => 0,
    'contacts_created' => 0,
    'phones_created' => 0,
    'addresses_created' => 0,
    'mailings_created' => 0,
    'classifications_created' => 0,
);

function normalizeDigits($value): string
{
    return preg_replace('/\D+/', '', (string)$value);
}

function isPlaceholder($value): bool
{
    $normalized = trim((string)$value);
    if ($normalized === '') {
        return true;
    }
    $upper = mb_strtoupper($normalized, 'UTF-8');
    return in_array($upper, array('0', '-3', 'NULO', 'NULL', 'N/A', 'NAO INFORMADO'), true);
}

function cleanText($value): ?string
{
    $value = trim((string)$value);
    if (isPlaceholder($value)) {
        return null;
    }
    return preg_replace('/\s+/', ' ', $value);
}

function formatCnpj($value): string
{
    $digits = normalizeDigits($value);
    if (strlen($digits) === 14) {
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $digits);
    }
    return $digits;
}

function normalizePhoneDigits($value): ?string
{
    $digits = normalizeDigits($value);
    if ($digits === '' || preg_match('/^0+$/', $digits)) {
        return null;
    }
    if (strlen($digits) < 10) {
        return null;
    }
    if (strlen($digits) > 11) {
        $digits = substr($digits, 0, 11);
    }
    return $digits;
}

function phoneParts(?string $digits): array
{
    if ($digits === null) {
        return array(null, null);
    }
    return array(substr($digits, 0, 2), substr($digits, 2));
}

function formatPhoneForContato(?string $digits): ?string
{
    if ($digits === null) {
        return null;
    }
    $ddd = substr($digits, 0, 2);
    $number = substr($digits, 2);
    return '(' . $ddd . ') ' . $number;
}

function parseDateValue($value): ?string
{
    $value = trim((string)$value);
    if (isPlaceholder($value)) {
        return null;
    }
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
        return $value;
    }
    if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
        $parts = explode('/', $value);
        return sprintf('%04d-%02d-%02d', (int)$parts[2], (int)$parts[1], (int)$parts[0]);
    }
    if (is_numeric($value)) {
        $days = (int)$value;
        if ($days > 0) {
            $base = new DateTime('1899-12-30');
            $base->modify('+' . $days . ' days');
            return $base->format('Y-m-d');
        }
    }
    return null;
}

function truncateText(?string $value, int $limit): ?string
{
    if ($value === null) {
        return null;
    }
    if (mb_strlen($value, 'UTF-8') <= $limit) {
        return $value;
    }
    return mb_substr($value, 0, $limit, 'UTF-8');
}

function xlsxCellValue(SimpleXMLElement $cell, array $sharedStrings): string
{
    $type = (string)$cell['t'];
    if ($type === 's') {
        $index = (int)$cell->v;
        return $sharedStrings[$index] ?? '';
    }
    if ($type === 'inlineStr') {
        return isset($cell->is->t) ? (string)$cell->is->t : '';
    }
    return isset($cell->v) ? (string)$cell->v : '';
}

function columnLetters(string $cellRef): string
{
    return preg_replace('/\d+/', '', $cellRef);
}

function loadWorkbookRows(string $xlsxPath): array
{
    $zip = new ZipArchive();
    if ($zip->open($xlsxPath) !== true) {
        throw new RuntimeException('Nao foi possivel abrir o XLSX.');
    }

    $sharedStrings = array();
    $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
    if ($sharedXml !== false) {
        $shared = simplexml_load_string($sharedXml);
        if ($shared !== false) {
            foreach ($shared->si as $si) {
                $text = '';
                if (isset($si->t)) {
                    $text .= (string)$si->t;
                } elseif (isset($si->r)) {
                    foreach ($si->r as $run) {
                        $text .= (string)$run->t;
                    }
                }
                $sharedStrings[] = $text;
            }
        }
    }

    $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
    $zip->close();
    if ($sheetXml === false) {
        throw new RuntimeException('Planilha sheet1.xml nao encontrada no XLSX.');
    }

    $sheet = simplexml_load_string($sheetXml);
    if ($sheet === false || !isset($sheet->sheetData)) {
        throw new RuntimeException('Nao foi possivel interpretar a planilha.');
    }

    $rows = array();
    foreach ($sheet->sheetData->row as $row) {
        $currentRow = array();
        foreach ($row->c as $cell) {
            $column = columnLetters((string)$cell['r']);
            $currentRow[$column] = trim(xlsxCellValue($cell, $sharedStrings));
        }
        $rows[] = $currentRow;
    }

    if (count($rows) < 2) {
        throw new RuntimeException('A planilha nao possui dados suficientes.');
    }

    $headerRow = $rows[0];
    $headers = array();
    foreach ($headerRow as $column => $label) {
        $headers[$column] = trim($label);
    }

    $normalizedRows = array();
    for ($i = 1; $i < count($rows); $i++) {
        $record = array();
        foreach ($headers as $column => $label) {
            $record[$label] = isset($rows[$i][$column]) ? trim($rows[$i][$column]) : '';
        }
        $normalizedRows[] = $record;
    }

    return $normalizedRows;
}

function fetchAllAssoc(mysqli $db, string $sql): array
{
    $result = $db->query($sql);
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $result->free();
    return $rows;
}

function ensureMailing(mysqli $db, string $mailingName, int $contaId, int $poloId, int $usuarioId, array &$stats, bool $dryRun): array
{
    $normalizedName = mb_strtolower(trim($mailingName), 'UTF-8');
    $aliases = array_unique(array_filter(array(
        $normalizedName,
        'carteira atualizada',
        'carga atualizada',
    )));

    $placeholders = implode(',', array_fill(0, count($aliases), '?'));
    $types = str_repeat('s', count($aliases));
    $sql = 'SELECT pk, ds_mailing, contas_pk, polos_pk
              FROM mailing
             WHERE LOWER(TRIM(ds_mailing)) IN (' . $placeholders . ')
             ORDER BY pk ASC
             LIMIT 1';
    $stmt = $db->prepare($sql);
    $bindValues = array($types);
    foreach ($aliases as $index => $alias) {
        $bindValues[] = &$aliases[$index];
    }
    call_user_func_array(array($stmt, 'bind_param'), $bindValues);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing = $result->fetch_assoc();
    $stmt->close();

    if ($existing) {
        return array((int)$existing['pk'], (int)$existing['contas_pk'], (int)$existing['polos_pk']);
    }

    if ($dryRun) {
        $stats['mailings_created']++;
        return array(0, $contaId, $poloId);
    }

    $stmt = $db->prepare(
        'INSERT INTO mailing (dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk, ds_mailing, ic_status, contas_pk, polos_pk)
         VALUES (NOW(), ?, NOW(), ?, ?, 1, ?, ?)'
    );
    $stmt->bind_param('iisii', $usuarioId, $usuarioId, $mailingName, $contaId, $poloId);
    $stmt->execute();
    $mailingPk = (int)$stmt->insert_id;
    $stmt->close();

    $stats['mailings_created']++;
    return array($mailingPk, $contaId, $poloId);
}

function ensureOperator(mysqli $db, string $operatorName): int
{
    $stmt = $db->prepare('SELECT pk FROM operadores WHERE ds_operador = ? LIMIT 1');
    $stmt->bind_param('s', $operatorName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        throw new RuntimeException("Operadora '{$operatorName}' nao encontrada.");
    }

    return (int)$row['pk'];
}

function ensureClassification(mysqli $db, int $operatorPk, string $classification, int $usuarioId, array &$stats, bool $dryRun): int
{
    static $cache = array();
    $cacheKey = $operatorPk . '|' . $classification;
    if (isset($cache[$cacheKey])) {
        return $cache[$cacheKey];
    }

    $stmt = $db->prepare('SELECT pk FROM classificacao_operadoras WHERE operadoras_pk = ? AND ds_classificacao = ? LIMIT 1');
    $stmt->bind_param('is', $operatorPk, $classification);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        $cache[$cacheKey] = (int)$row['pk'];
        return $cache[$cacheKey];
    }

    if ($dryRun) {
        $stats['classifications_created']++;
        $cache[$cacheKey] = 0;
        return 0;
    }

    $stmt = $db->prepare(
        'INSERT INTO classificacao_operadoras (dt_cadastro, ds_classificacao, operadoras_pk)
         VALUES (NOW(), ?, ?)'
    );
    $stmt->bind_param('si', $classification, $operatorPk);
    $stmt->execute();
    $pk = (int)$stmt->insert_id;
    $stmt->close();

    $stats['classifications_created']++;
    $cache[$cacheKey] = $pk;
    return $pk;
}

try {
    $rows = loadWorkbookRows($filePath);
    $stats['rows_total'] = count($rows);

    $db = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    $db->set_charset('utf8');
    $db->autocommit(false);

    $operatorPk = ensureOperator($db, $operatorName);
    list($mailingPk, $mailingContaPk, $mailingPoloPk) = ensureMailing(
        $db,
        $mailingName,
        $defaultAccountId,
        $defaultPoloId,
        $defaultUserId,
        $stats,
        $dryRun
    );

    $leads = array();
    foreach (fetchAllAssoc(
        $db,
        "SELECT pk, contas_pk, polos_pk, mailing_pk, ds_lead, ds_razao_social, ds_cpf_cnpj, ic_cliente
           FROM leads"
    ) as $leadRow) {
        $digits = normalizeDigits($leadRow['ds_cpf_cnpj']);
        if ($digits !== '') {
            $leads[$digits] = $leadRow;
        }
    }

    $leadOperators = array();
    foreach (fetchAllAssoc(
        $db,
        "SELECT pk, leads_pk, operador_pk, classificacao_pk, tempo_contrato_pk, ds_qtde_voz, ds_qtde_dados, ic_cliente
           FROM leads_operadoras
          WHERE operador_pk = " . (int)$operatorPk . "
          ORDER BY pk ASC"
    ) as $leadOpRow) {
        $leadPk = (int)$leadOpRow['leads_pk'];
        if (!isset($leadOperators[$leadPk])) {
            $leadOperators[$leadPk] = $leadOpRow;
        }
    }

    $contactsByLead = array();
    foreach (fetchAllAssoc($db, "SELECT pk, leads_pk, ds_contato, ds_tel, ds_cel FROM contatos") as $contactRow) {
        $leadPk = (int)$contactRow['leads_pk'];
        $key = mb_strtoupper(trim((string)$contactRow['ds_contato']), 'UTF-8') . '|' . normalizeDigits($contactRow['ds_tel'] . $contactRow['ds_cel']);
        $contactsByLead[$leadPk][$key] = true;
    }

    $phonesByLead = array();
    foreach (fetchAllAssoc($db, "SELECT pk, leads_pk, ds_ddd, ds_tel FROM telefones") as $phoneRow) {
        $leadPk = (int)$phoneRow['leads_pk'];
        $key = normalizeDigits($phoneRow['ds_ddd'] . $phoneRow['ds_tel']);
        if ($key !== '') {
            $phonesByLead[$leadPk][$key] = true;
        }
    }

    $addressesByLead = array();
    foreach (fetchAllAssoc($db, "SELECT pk, leads_pk, ds_cep, ds_endereco, ds_numero, ds_complemento, ds_bairro, ds_cidade, ds_uf FROM enderecos") as $addressRow) {
        $leadPk = (int)$addressRow['leads_pk'];
        $key = mb_strtoupper(
            trim((string)$addressRow['ds_cep']) . '|' .
            trim((string)$addressRow['ds_endereco']) . '|' .
            trim((string)$addressRow['ds_numero']) . '|' .
            trim((string)$addressRow['ds_complemento']) . '|' .
            trim((string)$addressRow['ds_bairro']) . '|' .
            trim((string)$addressRow['ds_cidade']) . '|' .
            trim((string)$addressRow['ds_uf']),
            'UTF-8'
        );
        $addressesByLead[$leadPk][$key] = true;
    }

    $insertLeadStmt = $db->prepare(
        'INSERT INTO leads (
            dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk,
            tipo_pessoa_pk, ds_lead, ds_razao_social, ds_cpf_cnpj, ic_cliente, mailing_pk, contas_pk, polos_pk
        ) VALUES (NOW(), ?, NOW(), ?, "PJ", ?, ?, ?, ?, ?, ?, ?)'
    );
    $updateLeadStmt = $db->prepare(
        'UPDATE leads
            SET dt_ult_atualizacao = NOW(),
                usuario_ult_atualizacao_pk = ?,
                ds_lead = ?,
                ds_razao_social = ?,
                ds_cpf_cnpj = ?,
                ic_cliente = ?,
                mailing_pk = COALESCE(mailing_pk, ?)
          WHERE pk = ?'
    );
    $insertLeadOperatorStmt = $db->prepare(
        'INSERT INTO leads_operadoras (
            dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk,
            operador_pk, leads_pk, ic_cliente, ic_base, dt_ativacao, dt_vencimento,
            ds_custo_atual, ds_qtde_voz, ds_qtde_dados, ic_status, classificacao_pk, tempo_contrato_pk
        ) VALUES (NOW(), ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $updateLeadOperatorStmt = $db->prepare(
        'UPDATE leads_operadoras
            SET dt_ult_atualizacao = NOW(),
                usuario_ult_atualizacao_pk = ?,
                ic_cliente = ?,
                dt_ativacao = COALESCE(?, dt_ativacao),
                dt_vencimento = COALESCE(?, dt_vencimento),
                ds_qtde_voz = ?,
                ds_qtde_dados = ?,
                classificacao_pk = ?,
                tempo_contrato_pk = ?,
                ic_status = 1
          WHERE pk = ?'
    );
    $insertContatoStmt = $db->prepare(
        'INSERT INTO contatos (
            dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk,
            ds_contato, ds_tel, cargos_pk, leads_pk, polos_pk, contas_pk
        ) VALUES (NOW(), ?, NOW(), ?, ?, ?, NULL, ?, ?, ?)'
    );
    $insertTelefoneStmt = $db->prepare(
        'INSERT INTO telefones (
            dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk,
            tipo_telefone_pk, ds_ddd, ds_tel, ic_status, leads_pk, contas_pk, polos_pk
        ) VALUES (NOW(), ?, NOW(), ?, ?, ?, ?, 1, ?, ?, ?)'
    );
    $insertEnderecoStmt = $db->prepare(
        'INSERT INTO enderecos (
            dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk,
            tipo_endereco_pk, ds_cep, ds_endereco, ds_numero, ds_complemento, ds_bairro, ds_cidade, ds_uf,
            leads_pk, contas_pk, polos_pk
        ) VALUES (NOW(), ?, NOW(), ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $processedRows = 0;
    foreach ($rows as $row) {
        if ($limit > 0 && $processedRows >= $limit) {
            break;
        }

        $cnpjDigits = normalizeDigits($row['CNPJ'] ?? '');
        if ($cnpjDigits === '') {
            $stats['rows_skipped_no_cnpj']++;
            continue;
        }

        $processedRows++;
        $stats['rows_processed']++;

        $formattedCnpj = formatCnpj($cnpjDigits);
        $leadName = truncateText(cleanText($row['RAZAO_SOCIAL'] ?? ''), 100);
        $contactName = truncateText(cleanText($row['NOME_ADM'] ?? ''), 45);
        $phoneDigits = normalizePhoneDigits($row['TEL_CONTATO'] ?? '');
        $classificationCode = truncateText(cleanText($row['CLASSIFICACAO'] ?? ''), 45);
        $addressCep = truncateText(cleanText($row['NUM_CEP'] ?? ''), 12);
        $addressStreet = truncateText(cleanText($row['DSC_ENDERECO'] ?? ''), 150);
        $addressNumber = truncateText(cleanText($row['NUM_EDERECO_COMPL'] ?? ''), 10);
        $addressComplement = truncateText(cleanText($row['DSC_COMPLEMENTO'] ?? ''), 45);
        $addressDistrict = truncateText(cleanText($row['DSC_BAIRRO'] ?? ''), 100);
        $addressCity = truncateText(cleanText($row['DSC_CIDADE'] ?? ''), 100);
        $addressUf = truncateText(cleanText($row['SGL_ESTADO'] ?? ''), 2);
        $dtAtivacao = parseDateValue($row['DT_INSTALACAO_BL'] ?? '');

        $icCliente = ((string)($row['CLIENTE_NET'] ?? '') === '1') ? 1 : 2;
        $qtdeVoz = max(0, (int)($row['Voz'] ?? 0));
        $qtdeDados = max(0, (int)($row['QTD_M2M'] ?? 0));
        $tempoContrato = max(0, (int)($row['TEMP_VOZ'] ?? 0));
        $tempoContrato = $tempoContrato > 0 ? $tempoContrato : null;

        $classificationPk = null;
        if ($classificationCode !== null) {
            $classificationPk = ensureClassification($db, $operatorPk, $classificationCode, $defaultUserId, $stats, $dryRun);
        }

        $leadPk = null;
        $leadContaPk = $mailingContaPk ?: $defaultAccountId;
        $leadPoloPk = $mailingPoloPk ?: $defaultPoloId;

        if (isset($leads[$cnpjDigits])) {
            $leadPk = (int)$leads[$cnpjDigits]['pk'];
            $leadContaPk = (int)$leads[$cnpjDigits]['contas_pk'];
            $leadPoloPk = (int)$leads[$cnpjDigits]['polos_pk'];

            if (!$dryRun) {
                $updateLeadStmt->bind_param(
                    'isssiii',
                    $defaultUserId,
                    $leadName,
                    $leadName,
                    $formattedCnpj,
                    $icCliente,
                    $mailingPk,
                    $leadPk
                );
                $updateLeadStmt->execute();
            }
            $stats['leads_updated']++;
        } else {
            if (!$dryRun) {
                $insertLeadStmt->bind_param(
                    'iisssiiii',
                    $defaultUserId,
                    $defaultUserId,
                    $leadName,
                    $leadName,
                    $formattedCnpj,
                    $icCliente,
                    $mailingPk,
                    $leadContaPk,
                    $leadPoloPk
                );
                $insertLeadStmt->execute();
                $leadPk = (int)$insertLeadStmt->insert_id;
            } else {
                $leadPk = -$processedRows;
            }

            $leads[$cnpjDigits] = array(
                'pk' => $leadPk,
                'contas_pk' => $leadContaPk,
                'polos_pk' => $leadPoloPk,
                'mailing_pk' => $mailingPk,
            );
            $stats['leads_created']++;
        }

        if ($leadPk === null) {
            continue;
        }

        if (!isset($leadOperators[$leadPk])) {
            if (!$dryRun) {
                $icBase = null;
                $dtVencimento = null;
                $custoAtual = 0.0;
                $icStatus = 1;
                $insertLeadOperatorStmt->bind_param(
                    'iiiiiissdiiiii',
                    $defaultUserId,
                    $defaultUserId,
                    $operatorPk,
                    $leadPk,
                    $icCliente,
                    $icBase,
                    $dtAtivacao,
                    $dtVencimento,
                    $custoAtual,
                    $qtdeVoz,
                    $qtdeDados,
                    $icStatus,
                    $classificationPk,
                    $tempoContrato
                );
                $insertLeadOperatorStmt->execute();
                $leadOperatorPk = (int)$insertLeadOperatorStmt->insert_id;
            } else {
                $leadOperatorPk = -$processedRows;
            }

            $leadOperators[$leadPk] = array(
                'pk' => $leadOperatorPk,
            );
            $stats['lead_ops_created']++;
        } else {
            $leadOperatorPk = (int)$leadOperators[$leadPk]['pk'];
            if (!$dryRun) {
                $dtVencimento = null;
                $updateLeadOperatorStmt->bind_param(
                    'iissiiiii',
                    $defaultUserId,
                    $icCliente,
                    $dtAtivacao,
                    $dtVencimento,
                    $qtdeVoz,
                    $qtdeDados,
                    $classificationPk,
                    $tempoContrato,
                    $leadOperatorPk
                );
                $updateLeadOperatorStmt->execute();
            }
            $stats['lead_ops_updated']++;
        }

        if ($contactName !== null) {
            $contactKey = mb_strtoupper($contactName, 'UTF-8') . '|' . normalizeDigits((string)formatPhoneForContato($phoneDigits));
            if (!isset($contactsByLead[$leadPk][$contactKey])) {
                if (!$dryRun) {
                    $contactPhone = formatPhoneForContato($phoneDigits);
                    $insertContatoStmt->bind_param(
                        'iissiii',
                        $defaultUserId,
                        $defaultUserId,
                        $contactName,
                        $contactPhone,
                        $leadPk,
                        $leadPoloPk,
                        $leadContaPk
                    );
                    $insertContatoStmt->execute();
                }
                $contactsByLead[$leadPk][$contactKey] = true;
                $stats['contacts_created']++;
            }
        }

        if ($phoneDigits !== null) {
            $phoneKey = $phoneDigits;
            if (!isset($phonesByLead[$leadPk][$phoneKey])) {
                if (!$dryRun) {
                    list($ddd, $phoneNumber) = phoneParts($phoneDigits);
                    $tipoTelefonePk = strlen($phoneDigits) >= 11 ? 2 : 1;
                    $insertTelefoneStmt->bind_param(
                        'iiissiii',
                        $defaultUserId,
                        $defaultUserId,
                        $tipoTelefonePk,
                        $ddd,
                        $phoneNumber,
                        $leadPk,
                        $leadContaPk,
                        $leadPoloPk
                    );
                    $insertTelefoneStmt->execute();
                }
                $phonesByLead[$leadPk][$phoneKey] = true;
                $stats['phones_created']++;
            }
        }

        if ($addressCep !== null && $addressStreet !== null && $addressNumber !== null && $addressDistrict !== null && $addressCity !== null && $addressUf !== null) {
            $addressKey = mb_strtoupper(
                $addressCep . '|' . $addressStreet . '|' . $addressNumber . '|' . (string)$addressComplement . '|' . $addressDistrict . '|' . $addressCity . '|' . $addressUf,
                'UTF-8'
            );
            if (!isset($addressesByLead[$leadPk][$addressKey])) {
                if (!$dryRun) {
                    $insertEnderecoStmt->bind_param(
                        'iissssssiiii',
                        $defaultUserId,
                        $defaultUserId,
                        $addressCep,
                        $addressStreet,
                        $addressNumber,
                        $addressComplement,
                        $addressDistrict,
                        $addressCity,
                        $addressUf,
                        $leadPk,
                        $leadContaPk,
                        $leadPoloPk
                    );
                    $insertEnderecoStmt->execute();
                }
                $addressesByLead[$leadPk][$addressKey] = true;
                $stats['addresses_created']++;
            }
        }

        if (!$dryRun && ($processedRows % 500) === 0) {
            $db->commit();
        }
    }

    if ($dryRun) {
        $db->rollback();
    } else {
        $db->commit();
    }

    echo "Importacao concluida.\n";
    foreach ($stats as $key => $value) {
        echo str_pad($key, 26, ' ') . ": {$value}\n";
    }
    echo "dry_run" . str_repeat(' ', 19) . ': ' . ($dryRun ? 'sim' : 'nao') . "\n";
    echo "operadora" . str_repeat(' ', 17) . ": {$operatorName}\n";
    echo "mailing" . str_repeat(' ', 19) . ": {$mailingName}\n";
} catch (Throwable $e) {
    if (isset($db) && $db instanceof mysqli) {
        try {
            $db->rollback();
        } catch (Throwable $ignored) {
        }
    }
    fwrite(STDERR, "Erro: " . $e->getMessage() . "\n");
    exit(1);
}
