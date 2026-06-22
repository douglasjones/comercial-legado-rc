# Analise da carga da planilha `data/carteira atualizada.xlsx`

## Resumo

- Arquivo analisado: `data/carteira atualizada.xlsx`
- Aba encontrada: `Planilha1`
- Total de linhas de dados: `36.644`
- Total de colunas: `52` (`A` ate `AZ`)
- Banco local atual:
  - `leads`: `37.072` registros
  - `leads` por `ds_cpf_cnpj` distinto: `37.066`

## Estrutura da planilha

Cabecalhos encontrados:

`CNPJ`, `RAZAO_SOCIAL`, `SEGM`, `COORDENADOR`, `TERRITORIO`, `GC`, `NOME_ADM`, `TEL_CONTATO`, `Endereco`, `CLASSIFICACAO`, `Voz`, `BL_VOZ`, `QTD_BL`, `QTD_M2M`, `TEMP_BL`, `TEMP_M2M`, `TEMP_VOZ`, `CLIENTE_NET`, `POSSUI_NET_TXT`, `POSSUI_MOVEL`, `INAD`, `PU_M1`, `Multa`, `PROBLEMAS_TECNICOS`, `Rede`, `REDE_COBERTURA`, `Faturamento`, `VALID_RENOVACAO`, `CLUSTER_PME`, `CLUSTER_CHURN`, `CLUSTER_MESES_ULT_COTACAO`, `CLUSTER_TEMP_CONTRATO_VOZ`, `LINHAS_SILENTES`, `DT_INSTALACAO_BL`, `CANAL_VENDA_BL`, `CLUSTER FIXA`, `Linhas Totais`, `DSC_GRUPO`, `DSC_SUBGRUPO`, `DSC_PORTE_EMPRESA`, `DSC_SITUACAO_CADASTRAL`, `FLAG_MEI`, `PRE_APROV_MOVEL`, `PRE_APRV_FIXA`, `NUM_CEP`, `DSC_ENDERECO`, `NUM_EDERECO_COMPL`, `DSC_COMPLEMENTO`, `DSC_BAIRRO`, `DSC_CIDADE`, `SGL_ESTADO`, `NR_ANO_MES`

## Qualidade dos dados

Campos principais:

- `CNPJ`: `36.644` preenchidos, `36.641` distintos
- Duplicidades por `CNPJ`: `3` chaves repetidas
- `RAZAO_SOCIAL`: `36.644` preenchidos
- `NOME_ADM`: contem o literal `Nulo` em `2.918` linhas
- `TEL_CONTATO`: `5.066` linhas com valor `0`
- `CLIENTE_NET`: `31.944` com `0`, `4.700` com `1`
- `POSSUI_MOVEL`: vazio em `100%` das linhas
- `INAD`: preenchido em `902` linhas

Campos de endereco:

- `NUM_CEP`: `7.152` com `0` e `701` com `-3`
- `DSC_ENDERECO`: `7.152` com `0` e `705` com `-3`
- `NUM_EDERECO_COMPL`: `7.162` com `0` e `708` com `-3`
- `DSC_COMPLEMENTO`: `17.435` com `-3` e `7.152` com `0`
- `DSC_BAIRRO`: `7.152` com `0` e `707` com `-3`
- `DSC_CIDADE`: `7.152` com `0` e `702` com `-3`
- `SGL_ESTADO`: `7.152` com `0` e `701` com `-3`

Leitura pratica:

- a planilha mistura dados validos com marcadores de ausencia (`0`, `-3`, `Nulo`)
- o CNPJ parece ser a melhor chave de deduplicacao e atualizacao
- ha muitos registros sem endereco confiavel
- ha um unico telefone principal por linha, sem DDD separado

## Mapeamento sugerido para o banco

### Tabela `leads`

Mapeamento direto sugerido:

- `ds_cpf_cnpj` <= `CNPJ`
- `ds_razao_social` <= `RAZAO_SOCIAL`
- `ds_lead` <= `RAZAO_SOCIAL` ou nome comercial derivado
- `ds_obs` <= consolidacao dos campos comerciais nao estruturados
- `ds_log` <= resumo curto de segmentacao
- `ciclo_uso` <= opcional, derivado de clusters/renovacao

Campos fixos/operacionais que precisam ser definidos na carga:

- `tipo_pessoa_pk`: provavelmente juridica
- `ic_cliente`: derivar de `CLIENTE_NET` (`1` => cliente, `0` => nao cliente)
- `mailing_pk`: deve ser escolhido/criado antes da carga
- `polos_pk`: deve ser escolhido antes da carga
- `contas_pk`: vem do contexto do sistema
- `usuario_*`: vem do usuario executor

### Tabela `telefones`

Mapeamento sugerido:

- `ds_ddd` + `ds_tel` <= `TEL_CONTATO`
- `tipo_telefone_pk`: provavelmente `1` fixo por padrao
- ignorar quando `TEL_CONTATO` for `0` ou invalido

Observacao:

- o importador atual do sistema espera telefone em outro formato e faz parsing por mascara; esta planilha precisara de normalizacao propria

### Tabela `contatos`

Mapeamento possivel:

- `ds_contato` <= `NOME_ADM`
- `ds_tel` ou `ds_cel` <= `TEL_CONTATO`

Regra sugerida:

- nao criar contato quando `NOME_ADM` for `Nulo`, vazio, `0` ou `-3`

### Tabela `enderecos`

Mapeamento sugerido:

- `ds_cep` <= `NUM_CEP`
- `ds_endereco` <= `DSC_ENDERECO`
- `ds_numero` <= `NUM_EDERECO_COMPL`
- `ds_complemento` <= `DSC_COMPLEMENTO`
- `ds_bairro` <= `DSC_BAIRRO`
- `ds_cidade` <= `DSC_CIDADE`
- `ds_uf` <= `SGL_ESTADO`

Regra sugerida:

- nao inserir endereco quando os campos vierem como `0` ou `-3`

## Campos sem coluna nativa clara no CRM

Esses campos hoje nao tem destino estruturado obvio nas tabelas principais:

- `SEGM`
- `COORDENADOR`
- `TERRITORIO`
- `GC`
- `CLASSIFICACAO`
- `Voz`
- `BL_VOZ`
- `QTD_BL`
- `QTD_M2M`
- `TEMP_BL`
- `TEMP_M2M`
- `TEMP_VOZ`
- `POSSUI_NET_TXT`
- `POSSUI_MOVEL`
- `INAD`
- `PU_M1`
- `Multa`
- `PROBLEMAS_TECNICOS`
- `Rede`
- `REDE_COBERTURA`
- `Faturamento`
- `VALID_RENOVACAO`
- `CLUSTER_PME`
- `CLUSTER_CHURN`
- `CLUSTER_MESES_ULT_COTACAO`
- `CLUSTER_TEMP_CONTRATO_VOZ`
- `LINHAS_SILENTES`
- `DT_INSTALACAO_BL`
- `CANAL_VENDA_BL`
- `CLUSTER FIXA`
- `Linhas Totais`
- `DSC_GRUPO`
- `DSC_SUBGRUPO`
- `DSC_PORTE_EMPRESA`
- `DSC_SITUACAO_CADASTRAL`
- `FLAG_MEI`
- `PRE_APROV_MOVEL`
- `PRE_APRV_FIXA`
- `NR_ANO_MES`

Opcao mais segura sem alterar schema:

- consolidar esses campos em `leads.ds_obs` em formato legivel

## Risco com o importador atual

O fluxo atual em `model/carga_lead.dao.php`:

- le apenas `CSV`
- espera cabecalhos completamente diferentes da planilha atual
- faz `insert` direto em `leads`, `telefones`, `contatos` e `enderecos`
- nao faz deduplicacao por `CNPJ`
- nao faz estrategia de `update`

Conclusao:

- a planilha `carteira atualizada.xlsx` nao entra no importador atual sem adaptacao

## Estrategia recomendada para implementacao

### Opcao recomendada

Criar uma rotina especifica para este layout:

1. ler `xlsx`
2. normalizar `0`, `-3`, `Nulo` e vazios
3. usar `CNPJ` como chave de busca
4. fazer `upsert` em `leads`
5. atualizar/inserir telefone principal
6. atualizar/inserir contato administrativo
7. atualizar/inserir endereco apenas quando valido
8. gravar os campos comerciais extras em `ds_obs`
9. registrar `mailing_pk`, `polos_pk`, `responsavel` e `grupo`

### Regra de deduplicacao sugerida

- chave principal: `CNPJ`
- se o `CNPJ` ja existir:
  - atualizar dados cadastrais
  - nao duplicar telefone/endereco identicos
- se nao existir:
  - criar lead completo

## Proximo passo tecnico

Implementar um importador novo para `xlsx` ou um conversor interno `xlsx -> csv normalizado` antes da carga.
