<?
set_time_limit(6000000);
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/migrar.dao.php";

require_once "../model/processo.dao.php";
require_once "../model/processo.class.php";

require_once "../model/processo_default_etapa.dao.php";
require_once "../model/processo_default_etapa.class.php";

require_once "../model/ocorrencia.dao.php";
require_once "../model/ocorrencia.class.php";

require_once "../model/tipo_ocorrencia.dao.php";
require_once "../model/tipo_ocorrencia.class.php";

require_once "../model/lead.dao.php";
require_once "../model/lead.class.php";

require_once "../model/proposta.dao.php";
require_once "../model/proposta.class.php";

require_once "../model/contrato.dao.php";
require_once "../model/contrato.class.php";

require_once "../model/operador.dao.php";
require_once "../model/operador.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];

$migrardao = new migrardao();
$migrardao->setToken($token);


$processodao = new processodao();
$processodao->setToken($token);

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token);

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token);

$leaddao = new leaddao();
$leaddao->setToken($token);

$propostadao = new propostadao();
$propostadao->setToken($token);

$contratodao = new contratodao();
$contratodao->setToken($token); 

$operadordao = new operadordao();
$operadordao->setToken($token); 


$conecta = mysql_connect('localhost', 'root', '123456') or print (mysql_error());
mysql_select_db('gepros_old_edm', $conecta) or print(mysql_error());

switch($job){
    case 'salvar':{
        //USUARIOS
        $sql = "select ui.CodUsuarioInterno,ANY_VALUE(ui.Nome) as Nome,ANY_VALUE(ui.Login) as Login,ANY_VALUE(ui.Senha) as Senha,ANY_VALUE(guiui.CodGrupoUsuarioInterno) as CodGrupoUsuarioInterno from usuariosinternos ui";
        $sql.="        inner join gruposusuariosinternos_usuariosinternos guiui on ui.CodUsuarioInterno = guiui.CodUsuarioInterno";
        $sql.="        where ui.Desativado = -1 ";
        $sql.="        group by ui.CodUsuarioInterno";
        $result_query_usuario = mysql_query($sql, $conecta);
        while($consulta = mysql_fetch_array($result_query_usuario)){
        //grupos_pk old cadastrado a mão
        $query = $migrardao->consultarGrupo($consulta['CodGrupoUsuarioInterno']);

            if(count($query) > 0){
                $usuarios_pk = $migrardao->salvarUsuario($consulta['CodUsuarioInterno'],utf8_encode($consulta['Nome']),$consulta['Login'],"gepros",$query[0]['pk']);
                $migrardao->salvarPoloUsuario($usuarios_pk);
            }
            else{
                //SE NÃO LOCALIZAR O GRUPO CADASTRA COMO TELEMARKETING
                $usuarios_pk = $migrardao->salvarUsuario($consulta['CodUsuarioInterno'],utf8_encode($consulta['Nome']),$consulta['Login'],"gepros",6);
                $migrardao->salvarPoloUsuario($usuarios_pk);
            }

        }
        mysql_free_result($result_query_usuario);
        mysql_close($conecta); 
        



        $result  = 'success';
        $message = 'Registro salvo com sucesso.';

        break;
    }
    case 'salvarLead':{
           
        //LEAD
        $sql = "SELECT ";
        $sql.="       l.CodLead,";
        $sql.="       l.RazaoSocial,";
        $sql.="       l.CNPJ_CPF,";
        $sql.="       l.ddd,";
        $sql.="       l.tel,";
        $sql.="       l.Endereco,";
        $sql.="       l.Numero,";
        $sql.="       l.Complemento,";
        $sql.="       l.Bairro,";
        $sql.="       l.Cep,";
        $sql.="       l.cidade,";
        $sql.="       l.uf,";
        $sql.="       l.CodGerenteConta ,";
        $sql.="       l.CodAtendente,";
        $sql.="       l.CodStatusClassificacaoLead,";
        $sql.="       l.tipo_pessoa";
        $sql.="        FROM leads l";
        //$sql.="      limit 10";
        $result = mysql_query($sql, $conecta);
        while($consulta = mysql_fetch_array($result)) {

            //VERIFICA O COD GERENTE ANTIGO PARA CADASTRAR
            if($consulta['CodGerenteConta']!= "" || $consulta['CodGerenteConta']!=null){
                $query_consultor = $migrardao->consultarUsuario($consulta['CodGerenteConta']);


                //CASO O USUARIO NÃO EXISTA, PEGA PARA O USUARIO MIGRAÇÃO
                if($query_consultor[0]['pk']==""){
                    //usuario migracao
                    $cod_consultor = 226;
                }
                else{
                    $cod_consultor = $query_consultor[0]['pk'];
                }
                //CASO O GRUPO NÃO EXISTA, PEGA PARA O GRUPO USUARIO MIGRAÇÃO
                if($query_consultor[0]['grupos_pk']==""){
                    //usuario migracao
                    $cod_consultor_grupo = 1;
                }
                else{
                    $cod_consultor_grupo = $query_consultor[0]['grupos_pk'];
                }
            }



            //CASO O USUARIO NÃO EXISTA, PEGA PARA O USUARIO MIGRAÇÃO
            if($consulta['CodAtendente']!= "" || $consulta['CodAtendente']!=null){
                $query_atendente = $migrardao->consultarUsuario($consulta['CodAtendente']);
                if($query_atendente[0]['pk']==""){
                    //usuario migracao
                    $cod_atendente = 226;
                }
                else{
                    $cod_atendente = $query_atendente[0]['pk'];
                }

                //CASO O GRUPO NÃO EXISTA, PEGA PARA O GRUPO USUARIO MIGRAÇÃO
                if($query_atendente[0]['grupos_pk']==""){
                    //usuario migracao
                    $cod_atendente_grupo = 1;
                }
                else{
                    $cod_atendente_grupo = $query_atendente[0]['grupos_pk'];
                }
            }


            if($consulta['CodStatusClassificacaoLead']==15){
                $cliente_lead = 1;
            }
            else{
                $cliente_lead = 2;
            }

            //SALVA O LEAD
            if($consulta['tipo_pessoa']==null || $consulta['tipo_pessoa']!=""){
                $leads_pk = $migrardao->salvarLead("PJ",utf8_encode($consulta['RazaoSocial']),utf8_encode($consulta['RazaoSocial']),$consulta['CNPJ_CPF'],$cliente_lead,$consulta['CodLead']);
            }
            else{
                $leads_pk = $migrardao->salvarLead($consulta['tipo_pessoa'],utf8_encode($consulta['RazaoSocial']),utf8_encode($consulta['RazaoSocial']),$consulta['CNPJ_CPF'],$cliente_lead,$consulta['CodLead']);
            }

            //VERIFICA SE EXISTE ALGUM RESPONSAVEL PARA CADASTRO
            if(count($cod_consultor)> 0){
                $migrardao->salvarResponsavel($cod_consultor,$cod_consultor_grupo,$leads_pk);
            }
            if(count($cod_atendente)> 0){
                $migrardao->salvarResponsavel($cod_atendente,$cod_atendente_grupo,$leads_pk);
            }


            //CADASTRA O TELEFONE DO LEAD
            if($consulta['tel']!=null || $consulta['tel']!=""){
                $migrardao->salvarTelefoneLead($consulta['ddd'],$consulta['tel'],$leads_pk);
            }
            //CADASTRA O ENDEREÇO DO LEAD
            if($consulta['Cep']!=null || $consulta['Cep']!=""){
                $migrardao->salvarEnderecoLead($consulta['Cep'],utf8_encode($consulta['Endereco']),$consulta['Numero'],utf8_encode($consulta['Complemento']),utf8_encode($consulta['Bairro']),utf8_encode($consulta['cidade']),$consulta['uf'],$leads_pk);
            }


            //VERIFICA SE EXISTE ALGUM CONTATO PARA SER CADASTRADO
            $sql1="";
            $sql1.="select cl.NomeContato,cl.CodContatoLead,";
            $sql1.="       concat('(',cl.DDD_Fone,')',cl.Fone)ds_tel,";
            $sql1.="       concat('(',cl.DDD_Cel,')',cl.Cel)ds_cel,";
            $sql1.="       cl.Email";
            $sql1.="        FROM contatoslead cl";
            $sql1.="        where cl.CodLead = ".$consulta['CodLead'];

            $result1 = mysql_query($sql1, $conecta);
            while($consulta1 = mysql_fetch_array($result1)) {

                //CASO EXISTA, FAZ O CADASTRO DO CONTATO DO LEAD
                if($consulta1['NomeContato']!=null || $consulta1['NomeContato']!=""){

                    $migrardao->salvarContatoLead(utf8_encode($consulta1['NomeContato']),$consulta1['ds_cel'],$consulta1['Email'],$consulta1['ds_tel'],$leads_pk,$consulta1['CodContatoLead']);
                }


            }

            mysql_free_result($result1);

            //PEGA AS INFORMAÇÕES DAS OPERADORAS
            $sql2="";
            $sql2.="SELECT ";
            $sql2.="            nlca.vl_custo_atual";
            $sql2.="        FROM leads l";
            $sql2.="                inner JOIN n_leads_custo_atual nlca ON l.CodLead = nlca.leads_pk";
            $sql2.="        WHERE l.codLead = ".$consulta['CodLead'];
            $result2 = mysql_query($sql2, $conecta);
            $row_custo = mysql_fetch_array($result2);
                $vl_custo_atual = "";
                $vl_custo_atual = $row_custo['vl_custo_atual'];

            mysql_free_result($result2);

            $sql2="";
            $sql2.="SELECT ";
            $sql2.="            nlda.dt_ativacao";
            $sql2.="        FROM leads l";
            $sql2.="                inner JOIN n_leads_dados_ativacao nlda ON l.CodLead = nlda.leads_pk";
            $sql2.="        WHERE l.codLead = ".$consulta['CodLead'];
            $result3 = mysql_query($sql2, $conecta);
            $row_dt_ativacao = mysql_fetch_array($result3);
                $dt_ativacao = "";
                $dt_ativacao = $row_dt_ativacao['dt_ativacao'];

            mysql_free_result($result3);

            $sql2="";
            $sql2.="SELECT ";
            $sql2.="            nldb.lead_cliente_base";
            $sql2.="        FROM leads l";
            $sql2.="                inner JOIN n_leads_dados_base nldb ON l.CodLead = nldb.leads_pk";
            $sql2.="        WHERE l.codLead = ".$consulta['CodLead'];
            $result4 = mysql_query($sql2, $conecta);
            $row_lead_cliente_base = mysql_fetch_array($result4);
                $lead_cliente_base = "";
                $lead_cliente_base = $row_lead_cliente_base['lead_cliente_base'];

            mysql_free_result($result4);



            $sql2="";
            $sql2.="SELECT ";
            $sql2.="            nldcl.classificacao_operadora_pk";
            $sql2.="        FROM leads l";
            $sql2.="                inner JOIN n_leads_dados_classificacao nldcl ON l.CodLead = nldcl.leads_pk";
            $sql2.="        WHERE l.codLead = ".$consulta['CodLead'];
            $result5 = mysql_query($sql2, $conecta);
            $row_classificacao_operadora_pk = mysql_fetch_array($result5);
                $classificacao_operadora_pk = "";
                $classificacao_operadora_pk = $row_classificacao_operadora_pk['classificacao_operadora_pk'];

            mysql_free_result($result5);



            $sql2="";
            $sql2.="SELECT ";
            $sql2.="            nldv.dt_vencimento";
            $sql2.="        FROM leads l";
            $sql2.="                inner JOIN n_leads_dados_vencimento nldv ON l.CodLead = nldv.leads_pk";
            $sql2.="        WHERE l.codLead = ".$consulta['CodLead'];
            $result7 = mysql_query($sql2, $conecta);
            $row_dt_vencimento = mysql_fetch_array($result7);
                $dt_vencimento = "";
                $dt_vencimento = $row_dt_vencimento['dt_vencimento'];

            mysql_free_result($result7);


            $sql2="";
            $sql2.="SELECT ";
            $sql2.="            nlqd.qtde_dados,";
            $sql2.="            nlqd.operadora_pk";
            $sql2.="        FROM leads l";
            $sql2.="                inner JOIN n_leads_qtde_dados nlqd ON l.CodLead = nlqd.leads_pk";
            $sql2.="        WHERE l.codLead = ".$consulta['CodLead'];
            $result8 = mysql_query($sql2, $conecta);
            $row_qtde_dados = mysql_fetch_array($result8);
                $qtde_dados[$row_qtde_dados['operadora_pk']] = "";
                $qtde_dados[$row_qtde_dados['operadora_pk']] = $row_qtde_dados['qtde_dados'];

            mysql_free_result($result8);


            $sql2="";
            $sql2.="SELECT ";
            $sql2.="            nlqv.qtde_voz,";
            $sql2.="            nlqv.operadora_pk";
            $sql2.="        FROM leads l";
            $sql2.="                inner JOIN n_leads_qtde_voz nlqv ON l.CodLead = nlqv.leads_pk";
            $sql2.="        WHERE nlqv.leads_pk = ".$consulta['CodLead'];
            $result9 = mysql_query($sql2, $conecta);

            while($row_qtde_voz = mysql_fetch_array($result9)){
                $qtde_voz[$row_qtde_dados['operadora_pk']] = "";
                $qtde_voz[$row_qtde_voz['operadora_pk']] = $row_qtde_voz['qtde_voz'];

            }

            mysql_free_result($result9);



            $sql2="";
            $sql2.="SELECT ";
            $sql2.="            nldc.lead_cliente,";
            $sql2.="            nldc.operadora_pk";
            $sql2.="        FROM leads l";
            $sql2.="                inner JOIN n_leads_dados_cliente nldc ON l.CodLead = nldc.leads_pk ";
            $sql2.="        WHERE l.codLead = ".$consulta['CodLead'];

            $result6 = mysql_query($sql2, $conecta);
            while($row = mysql_fetch_array($result6)){
                $lead_cliente = "";
                $operadora_pk_old = "";
                $lead_cliente = $row['lead_cliente'];
                $operadora_pk_old = $row['operadora_pk'];

                //FAZ O CADASTRO DAS OPERADORAS
                if($operadora_pk_old!=""){
                    //operadores_pk old cadastrado a mão
                    $query_operadora = $migrardao->consultarOperadora($operadora_pk_old);

                    $migrardao->salvarOperadoras($query_operadora[0]['pk'],$leads_pk,$lead_cliente,$lead_cliente_base,$dt_ativacao,$dt_vencimento,$vl_custo_atual,$qtde_voz[$operadora_pk_old],$qtde_dados[$operadora_pk_old],1,$classificacao_operadora_pk);

                }
            }
            mysql_free_result($result6);



            $sql2="";
            $sql2.="select ";
            $sql2.="        Descricao,";
            $sql2.="        DataCadastro,";
            $sql2.="        DataFechamento,";
            $sql2.="        CodUsuarioInterno,";
            $sql2.="        agendadopara,";
            $sql2.="        dt_retorno,";
            $sql2.="        dt_retorno_fechamento,";
            $sql2.="        dsc_retorno";
            $sql2.="        from ocorrenciaslead";
            $sql2.="        where CodLead = ".$consulta['CodLead'];
            $result10 = mysql_query($sql2, $conecta);
            while($row_ocorrencias = mysql_fetch_array($result10)){

                //VERIFICA O COD USUARIO CADASTRO ANTIGO PARA CADASTRAR
                if($row_ocorrencias['CodUsuarioInterno']!= "" || $row_ocorrencias['CodUsuarioInterno']!=null){
                    $query_usuario_cadastro = $migrardao->consultarUsuario($row_ocorrencias['CodUsuarioInterno']);
                    //CASO O USUARIO NÃO EXISTA, PEGA PARA O USUARIO MIGRAÇÃO
                    if($query_usuario_cadastro[0]['pk']==""){
                        //usuario migracao
                        $usuario_cadastro_ocorrencia = 226;
                    }
                    else{
                        $usuario_cadastro_ocorrencia = $query_usuario_cadastro[0]['pk'];
                    }
                }
                //VERIFICA O COD USUARIO CADASTRO ANTIGO PARA CADASTRAR
                if($row_ocorrencias['agendadopara']!= "" || $row_ocorrencias['agendadopara']!=null){
                    $query_agendado_para = $migrardao->consultarUsuario($row_ocorrencias['agendadopara']);
                    //CASO O USUARIO NÃO EXISTA, PEGA PARA O USUARIO MIGRAÇÃO
                    if($query_agendado_para[0]['pk']==""){
                        //usuario migracao
                        $usuario_agendado_para = 226;
                    }
                    else{
                        $usuario_agendado_para = $query_agendado_para[0]['pk'];
                    }
                }

                //TIPO OCORRENCIA MIGRACAO
                $tipo_ocorrencia_pk = 17;

                //CADASTRA A OCORRENCIA
                $ocorrencias_pk = $migrardao->salvarOcorrencia(utf8_encode($row_ocorrencias['Descricao']), $tipo_ocorrencia_pk, $row_ocorrencias['DataFechamento'], $leads_pk, $row_ocorrencias['DataCadastro'], $usuario_cadastro_ocorrencia,"");

                //CADASTRA O RETORNO SE EXISTIR
                if($row_ocorrencias['dt_retorno']!=""){
                    $retornos_pk = $migrardao->salvarRetorno($row_ocorrencias['dt_retorno'], $usuario_agendado_para, utf8_encode($row_ocorrencias['dsc_retorno']), $ocorrencias_pk, $row_ocorrencias['dt_retorno_fechamento'],"");
                }
                //SE O LEAD FOR SEM INTERESSE
                if($consulta['CodStatusClassificacaoLead']==1){
                    //PEGA O TIPO DE OCORRENCIA SEM INTERESSE
                    $tipo_ocorrencia_sem_interesse_pk = $migrardao->consultarTipoOcorrencia("Sem Interesse");
                    //PEGA O MOTIVO DO SEM INTERESSE
                    $motivo_sem_interesse_pk = $migrardao->consultarMotivoSemInteresse("Migração");

                    $ocorrencias_sem_interesse_pk = $migrardao->salvarOcorrencia(utf8_encode($row_ocorrencias['Descricao']), $tipo_ocorrencia_sem_interesse_pk[0]['pk'], $row_ocorrencias['DataFechamento'], $leads_pk, $row_ocorrencias['DataCadastro'], $usuario_cadastro_ocorrencia,$motivo_sem_interesse_pk[0]['pk']);

                }


            }
            mysql_free_result($result10);



            //DOCUMENTOS
            $sql2="";
            $sql2.="select ds_nome_documento,";
            $sql2.="       ds_documento,";
            $sql2.="       codusuariointerno";
            $sql2.="  from documentos";
            $sql2.="       where codlead = ".$consulta['CodLead'];
            $result13 = mysql_query($sql2, $conecta);
            while($row_documentos = mysql_fetch_array($result13)){
                  $ds_documento_diretorio = "";

                  $ds_documento_diretorio = str_replace("doc/", "", $row_documentos['ds_nome_documento']);

                  $query_usuario_cadastro_doc = $migrardao->consultarUsuario($row_documentos['codusuariointerno']);

                  if($query_usuario_cadastro_doc[0]['pk']==""){
                        //usuario migracao
                        $usuario_cadastro_doc = 226;
                    }
                    else{
                        $usuario_cadastro_doc = $query_usuario_cadastro_doc[0]['pk'];
                    }

                    $documentos_pk = $migrardao->salvarDocumentos($ds_documento_diretorio, $row_documentos['ds_documento'],$usuario_cadastro_doc,$leads_pk);
            }
            mysql_free_result($result13);


            if($consulta['CodStatusClassificacaoLead']!=2 && $consulta['CodStatusClassificacaoLead']!=3){
                //CADASTRO PROCESSO
                $processos_pk = $migrardao->salvarProcessos($leads_pk);


                $processos_etapas_pk = $migrardao->pegarProcessoEtapa($processos_pk);


                //AGENDAMENTO
                $sql2="";
                $sql2.="SELECT ";
                $sql2.="            CodAgendaLead,";
                $sql2.="            CodUsuarioInterno,";
                $sql2.="            AgendadoPara,";
                $sql2.="            DataCadastro,";
                $sql2.="            DataHorario,";
                $sql2.="            DataCancelamento,";
                $sql2.="            Descricao,";
                $sql2.="            CodStatus,";
                $sql2.="            CodContatoLead,";
                $sql2.="            cep,";
                $sql2.="            endereco,";
                $sql2.="            numero,";
                $sql2.="            bairro,";
                $sql2.="            complemento,";
                $sql2.="            cidade,";
                $sql2.="            uf";
                $sql2.="        FROM agendaslead";
                $sql2.="        where CodLead = ".$consulta['CodLead'];
                $result11 = mysql_query($sql2, $conecta);
                while($row_agendas = mysql_fetch_array($result11)){

                    //VERIFICA O COD USUARIO CADASTRO ANTIGO PARA CADASTRAR
                    if($row_agendas['CodUsuarioInterno']!= "" || $row_agendas['CodUsuarioInterno']!=null){
                        $query_usuario_cadastro = $migrardao->consultarUsuario($row_agendas['CodUsuarioInterno']);
                        //CASO O USUARIO NÃO EXISTA, PEGA PARA O USUARIO MIGRAÇÃO
                        if($query_usuario_cadastro[0]['pk']==""){
                            //usuario migracao
                            $usuario_cadastro_agenda = 226;
                        }
                        else{
                            $usuario_cadastro_agenda = $query_usuario_cadastro[0]['pk'];
                        }
                    }
                    //VERIFICA O COD USUARIO CADASTRO ANTIGO PARA CADASTRAR
                    if($row_agendas['AgendadoPara']!= "" || $row_agendas['AgendadoPara']!=null){
                        $query_agendado_para = $migrardao->consultarUsuario($row_agendas['AgendadoPara']);
                        //CASO O USUARIO NÃO EXISTA, PEGA PARA O USUARIO MIGRAÇÃO
                        if($query_agendado_para[0]['pk']==""){
                            //usuario migracao
                            $usuario_agendado_para = 226;
                        }
                        else{
                            $usuario_agendado_para = $query_agendado_para[0]['pk'];
                        }
                    }

                    //VERIFICA O COD CONTATO CADASTRO ANTIGO PARA CADASTRAR
                    if($row_agendas['CodContatoLead']!= "" || $row_agendas['CodContatoLead']!=null){
                        $query_contato = $migrardao->consultarContatos($row_agendas['CodContatoLead']);

                        $ds_contato = $query_contato[0]['ds_contato'];
                        $ds_tel = $query_contato[0]['ds_tel'];
                        $ds_cel = $query_contato[0]['ds_cel'];
                    }

                    //CADASTRA A AGENDA
                    $agendas_vistia_pk = $migrardao->salvarAgenda($row_agendas['DataHorario'],
                            utf8_encode($row_agendas['endereco']),
                            utf8_encode($row_agendas['numero']),
                            utf8_encode($row_agendas['complemento']),
                            $row_agendas['cep'],
                            utf8_encode($row_agendas['bairro']),
                            utf8_encode($row_agendas['cidade']),
                            $row_agendas['uf'],
                            utf8_encode($row_agendas['Descricao']),
                            $row_agendas['CodStatus'],
                            $row_agendas['DataCancelamento'],
                            $processos_etapas_pk,
                            $row_agendas['CodStatus'],
                            utf8_encode($ds_contato),
                            $ds_tel,
                            $ds_cel,
                            $row_agendas['DataCadastro'],
                            $row_agendas['CodAgendaLead'],
                            $usuario_cadastro_agenda,
                            $leads_pk);


                    //SE TIVER UM AGENDAMENTO PEGA CADASTRA CLASSIFICACAO (STATUS)
                    if($agendas_vistia_pk!=""){
                        if($processos_pk!=""){

                            $query = $processodao->carregarClassificacaoProcesso($processos_pk);
                            if($query[0]['classificacao_processo_pk']!=null){
                                 $classificacao_processo = $query[0]['classificacao_processo_pk'];
                            }
                            else{
                                 $classificacao_processo = 0;
                            }

                            //PEGA O NOME DO PROCESSO ETAPA
                            $arrDsProcessoEtapa= explode(". ","Agendas de Visita");

                            //ATUALIZA A CLASSIFICAÇÃO DA ETAPA DO PROCESSO
                            //Pega a classificação atual do processo
                            $query1 = $processo_default_etapadao->listarPorPk($processos_pk,$arrDsProcessoEtapa[1]);
                            $classificacao_processo_etapa = $query1[0]['classificacao_processo_etapa_pk'];

                            //UPD DA CLASSIFICACAO DO PROCESSO
                            if($classificacao_processo < $classificacao_processo_etapa){
                                $processodao->updClassificacao($processos_pk,$classificacao_processo_etapa);
                            }


                            //GERA OCORRENCIA
                            if($query1[0]['tipos_ocorrencias_pk']!=""){
                                $querytipo_ocorrencia = $tipo_ocorrenciadao->listarPorPk($query1[0]['tipos_ocorrencias_pk']);
                                $ocorrencia = $ocorrenciadao->carregarPorPk('');
                                $ocorrencia->setds_ocorrencia("Agenda Visita");
                                $ocorrencia->settipos_ocorrencias_pk($query1[0]['tipos_ocorrencias_pk']);
                                $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
                                $ocorrencia->setdt_fechamento($querytipo_ocorrencia[0]['ic_fechar_ocorrencia_auto']);
                                $ocorrencia->setleads_pk($leads_pk);
                                $gera_oc = $ocorrenciadao->salvar($ocorrencia);

                            }
                        }
                    }



                    //AGENDA RESPONSAVEL
                    $sql2="";
                    $sql2.="SELECT CodGerenteConta";
                    $sql2.="        FROM agendagerenteconta";
                    $sql2.="        where CodAgendaLead = ".$row_agendas['CodAgendaLead'];
                    $result12 = mysql_query($sql2, $conecta);
                    while($row_responsavel = mysql_fetch_array($result12)){

                        if($row_responsavel['CodGerenteConta']!= "" || $row_responsavel['CodGerenteConta']!=null){
                            $query_responsavel = $migrardao->consultarUsuario($row_responsavel['CodGerenteConta']);

                            //CASO O USUARIO NÃO EXISTA, PEGA PARA O USUARIO MIGRAÇÃO
                            if($query_responsavel[0]['pk']==""){
                                //usuario migracao
                                $responsavel_agenda_pk = 226;
                            }
                            else{
                                $responsavel_agenda_pk = $query_responsavel[0]['pk'];
                            }

                            $agenda_responsavel = $migrardao->salvarResponsavelAgenda($responsavel_agenda_pk, $agendas_vistia_pk);

                        }


                    }
                    mysql_free_result($result12);
                }
                mysql_free_result($result11);
            }



        }
        mysql_free_result($result);
        mysql_close($conecta);



        $result  = 'success';
        $message = 'Registro salvo com sucesso.';

        break;
    }
    default:{
        break;
    }
}

$dia_semanadao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = html_entity_decode(json_encode($data));
echo $json_data;


?>
