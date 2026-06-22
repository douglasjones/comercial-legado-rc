<?php
set_time_limit(6000000);
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/lead.dao.php";
include_once "../model/lead.class.php";
include_once "../model/contato.dao.php";
include_once "../model/contato.class.php";
include_once "../model/lead_responsavel.dao.php";
include_once "../model/lead_responsavel.class.php";

// Limpa os dados para garantir caracteres válidos
function cleanDataForJSON($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = cleanDataForJSON($value);
        }
        return $data;
    } else {
        return is_string($data) ? mb_convert_encoding($data, 'UTF-8', 'auto') : $data;
    }
}
include_once "../model/endereco.dao.php";
include_once "../model/endereco.class.php";
include_once "../model/telefone.dao.php";
include_once "../model/telefone.class.php";
include_once "../model/lead_operador.dao.php";
include_once "../model/lead_operador.class.php";

include_once "../model/retorno.dao.php";
include_once "../model/retorno.class.php";

include_once "../model/tipo_ocorrencia.dao.php";
include_once "../model/tipo_ocorrencia.class.php";

include_once "../model/operador.dao.php";
include_once "../model/operador.class.php";

include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

include_once "../model/usuario.dao.php";
include_once "../model/usuario.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_pessoa_pk = $arrRequest['tipo_pessoa_pk'];
$ds_lead = $arrRequest['ds_lead'];
$ds_razao_social = $arrRequest['ds_razao_social'];
$ds_cpf_cnpj = $arrRequest['ds_cpf_cnpj'];
$ds_ie = $arrRequest['ds_ie'];
$ds_rg = $arrRequest['ds_rg'];
$ds_cnae = $arrRequest['ds_cnae'];
$ic_cliente = $arrRequest['ic_cliente'];
$ds_obs = $arrRequest['ds_obs'];
$ds_site = $arrRequest['ds_site'];
$mailing_pk = $arrRequest['mailing_pk'];
$contas_pk = $arrRequest['contas_pk'];
$polos_pk = $arrRequest['polos_pk'];

$contatos_pk = $_REQUEST['contatos_pk'];
$responsavel_pk = $_REQUEST['responsavel_pk'];
$endereco_pk = $_REQUEST['endereco_pk'];
$telefone_pk = $_REQUEST['telefone_pk'];
$lead_operador = $_REQUEST['lead_operador'];
$ciclo_uso = $_REQUEST['ciclo_uso'];
$ds_log = $_REQUEST['ds_log'];

$leaddao = new leaddao();
$leaddao->setToken($token);

$contatodao = new contatodao();
$contatodao->setToken($token);

$enderecodao = new enderecodao();
$enderecodao->setToken($token);

$telefonedao = new telefonedao();
$telefonedao->setToken($token);

$lead_responsaveldao = new lead_responsaveldao();
$lead_responsaveldao->setToken($token);

$lead_operadordao = new lead_operadordao();
$lead_operadordao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token); 

$retornodao = new retornodao();
$retornodao->setToken($token); 

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token);

$operadordao = new operadordao();
$operadordao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token);

$usuariodao = new usuariodao();
$usuariodao->setToken($token);

verificarLogin($token);

switch($job){

    case 'excluir':{

        $resultdo = "";

        $lead = $leaddao->carregarPorPk($pk);
        if($lead->getpk()>0){
            $enderecodao->excluirPorLead($lead->getpk());
            $lead_responsaveldao->excluirPorLead($lead->getpk());
            $contatodao->excluirPorLead($lead->getpk());
            $telefonedao->excluirPorLead($lead->getpk());
            $ocorrencia = $leaddao->listarPorOcorrenciaLeadPk($lead->getpk());
			if(count($ocorrencia) > 0){
				for($i = 0; $i < count($ocorrencia); $i++){
					$leaddao->excluirRetorno($ocorrencia[$i]['pk']);
				}
			}

			$leaddao->excluirOcorrencia($lead->getpk());
			$leaddao->excluirProcesso($lead->getpk());
			$leaddao->excluirDocumento($lead->getpk());
			$leaddao->excluirAgendas($lead->getpk());
            $leaddao->excluirProposta($lead->getpk());


            $leaddao->excluir($lead);

            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'lead nao encontrado';
        }
        break;
    }
    case 'salvar':{

        if(trim($ds_cpf_cnpj)==""){
            $result  = 'error';
            $message = 'Por favor, informe CPF/CNPJ.';
            break;
        }

        $queryDuplicado = $leaddao->listarCpfCnpjDuplicado($ds_cpf_cnpj, $pk);
        if(count($queryDuplicado) > 0){
            $result  = 'error';
            $message = 'Ja existe um lead cadastrado com este CPF/CNPJ.';
            $mysql_data = array();
            break;
        }

        if($contatos_pk != "")
            $arrContatosLead = json_decode ($contatos_pk, true);

        if($responsavel_pk != "")
            $arrResponsavelLead = json_decode ($responsavel_pk, true);

        if($endereco_pk != "")
            $arrEnderecoLead = json_decode ($endereco_pk, true);

        if($telefone_pk != "")
            $arrTelefoneLead = json_decode ($telefone_pk, true);

        if($lead_operador != "")
            $arrLeadOperador = json_decode ($lead_operador, true);

 

        $lead = $leaddao->carregarPorPk($pk);
        $lead->settipo_pessoa_pk($tipo_pessoa_pk);
        $lead->setds_lead($ds_lead);
        $lead->setds_razao_social($ds_razao_social);
        $lead->setds_cpf_cnpj($ds_cpf_cnpj);
        $lead->setds_ie($ds_ie);
        $lead->setds_rg($ds_rg);
        $lead->setds_cnae($ds_cnae);
        $lead->setic_cliente($ic_cliente);
        $lead->setds_obs($ds_obs);
        $lead->setds_site($ds_site);
        $lead->setmailing_pk($mailing_pk);
        $lead->setpolos_pk($polos_pk);
        $lead->setciclo_uso($ciclo_uso);
        $lead->setds_log($ds_log);


        $pk = $leaddao->salvar($lead);

        if($pk!=""){
            $leads_pk = $pk;
        }
        else{
            $leads_pk = $lead->getpk();
        }

        //CONTATO
        if(count($arrContatosLead) > 0){
            for($i = 0; $i < count($arrContatosLead); $i++){


                $contato = $contatodao->carregarPorPk($arrContatosLead[$i]['contatos_pk']);

                $contato->setds_contato($arrContatosLead[$i]['ds_contato']);
                $contato->setds_cel($arrContatosLead[$i]['ds_cel']);
                $contato->setic_whatsapp($arrContatosLead[$i]['ic_whatsapp']);
                $contato->setds_email($arrContatosLead[$i]['ds_email']);
                $contato->setds_tel($arrContatosLead[$i]['ds_tel_contato']);
                $contato->setcargos_pk($arrContatosLead[$i]['cargos_pk']);
                $contato->setpolos_pk($polos_pk);
                $contato->setleads_pk($leads_pk);
                $contatos_pk = $contatodao->salvar($contato);

            }
        }

        //RESPONSAVEL
        if(count($arrResponsavelLead) > 0){

            for($i = 0; $i < count($arrResponsavelLead); $i++){

                $lead_responsavel = $lead_responsaveldao->carregarPorPk($arrResponsavelLead[$i]['lead_responsavel_pk']);

                $lead_responsavel->setgrupos_pk($arrResponsavelLead[$i]['grupos_pk']);
                $lead_responsavel->setusuarios_pk($arrResponsavelLead[$i]['usuarios_pk']);
                $lead_responsavel->setpolos_pk($polos_pk);
                $lead_responsavel->setleads_pk($leads_pk);
                $lead_responsavel_pk = $lead_responsaveldao->salvar($lead_responsavel);

            }
        }

        //ENDERECO
        if(count($arrEnderecoLead) > 0){
            for($i = 0; $i < count($arrEnderecoLead); $i++){


                $endereco = $enderecodao->carregarPorPk($arrEnderecoLead[$i]['lead_endereco_pk']);

                $endereco->setds_cep($arrEnderecoLead[$i]['ds_cep']);
                $endereco->setds_endereco($arrEnderecoLead[$i]['ds_endereco']);
                $endereco->setds_numero($arrEnderecoLead[$i]['ds_numero']);
                $endereco->setds_complemento($arrEnderecoLead[$i]['ds_complemento']);
                $endereco->setds_bairro($arrEnderecoLead[$i]['ds_bairro']);
                $endereco->setds_cidade($arrEnderecoLead[$i]['ds_cidade']);
                $endereco->setds_uf($arrEnderecoLead[$i]['ds_uf']);
                $endereco->settipo_endereco_pk($arrEnderecoLead[$i]['tipo_endereco_pk']);
                $endereco->setpolos_pk($polos_pk);
                $endereco->setleads_pk($leads_pk);
                $endereco_pk = $enderecodao->salvar($endereco);

            }
        }
        //TELEFONE
        if(count($arrTelefoneLead) > 0){
            for($i = 0; $i < count($arrTelefoneLead); $i++){

                $telefone = $telefonedao->carregarPorPk($arrTelefoneLead[$i]['lead_telefone_pk']);

                $telefone->setds_tel($arrTelefoneLead[$i]['ds_tel']);
                $telefone->setic_status($arrTelefoneLead[$i]['ic_status']);
                $telefone->settipo_telefone_pk($arrTelefoneLead[$i]['tipo_telefone_pk']);
                $telefone->setpolos_pk($polos_pk);
                $telefone->setleads_pk($leads_pk);
                $telefone_pk = $telefonedao->salvar($telefone);

            }
        }
        //LEAD OPERADOR
        if(count($arrLeadOperador) > 0){
            for($i = 0; $i < count($arrLeadOperador); $i++){

                if($arrLeadOperador[$i]['dt_ativacao']!="" ||$arrLeadOperador[$i]['dt_vencimento']!="" ){
                    $ds_operador = $operadordao->listarPorPk($arrLeadOperador[$i]['operador_pk']);
                    $querytipo_ocorrencia = $tipo_ocorrenciadao->listarTipoOcOportunidadeFutura();
                    
                    $ocorrencia = $ocorrenciadao->carregarPorPk("");
                    $ocorrencia->setds_ocorrencia("Oportunidade Futura - ".$ds_operador[0]['ds_operador']);
                    $ocorrencia->settipos_ocorrencias_pk($querytipo_ocorrencia[0]['pk']);
                    $ocorrencia->setdt_fechamento(2);
                    $ocorrencia->setleads_pk($leads_pk);

                    $ocorrencia_pk = $ocorrenciadao->salvar($ocorrencia); 

                    if($arrLeadOperador[$i]['dt_vencimento']!=""){
                        $dt_retorno = date('d/m/Y', strtotime('-60 days', strtotime(str_replace("/","-",$arrLeadOperador[$i]['dt_vencimento']))));
                    }
                    else if($arrLeadOperador[$i]['dt_ativacao']!=""){

                        $dt_retorno = date('d/m/Y', strtotime('-60 days', strtotime(str_replace("/","-",$arrLeadOperador[$i]['dt_ativacao']))));
                    }
                   
                    $retorno = $retornodao->carregarPorPk("");            
                    if($dt_retorno!=""){
                        $retorno->setdt_retorno(DataYMD($dt_retorno)." 00:00:00");
                    }		

                    $retorno->setds_retorno("Oportunidade Futura - ".$ds_operador[0]['ds_operador']);
                    $retorno->setocorrencias_pk($ocorrencia_pk);  

                    $retornos_pk = $retornodao->salvar($retorno);

                }


                $lead_operador = $lead_operadordao->carregarPorPk($arrLeadOperador[$i]['lead_operador_pk']);
                $lead_operador->setoperador_pk($arrLeadOperador[$i]['operador_pk']);
                $lead_operador->setleads_pk($leads_pk);
                $lead_operador->setic_cliente($arrLeadOperador[$i]['ic_cliente']);
                $lead_operador->setic_base($arrLeadOperador[$i]['ic_base']);
                if($arrLeadOperador[$i]['dt_ativacao']!=""){
                    $lead_operador->setdt_ativacao(DataYMD($arrLeadOperador[$i]['dt_ativacao']));
                }
                if($arrLeadOperador[$i]['dt_vencimento']!=""){
                    $lead_operador->setdt_vencimento(DataYMD($arrLeadOperador[$i]['dt_vencimento']));
                }
               
                if($arrLeadOperador[$i]['ds_custo_atual']!="" && $arrLeadOperador[$i]['ds_custo_atual']!="NaN"){
                    $lead_operador->setds_custo_atual($arrLeadOperador[$i]['ds_custo_atual']);
                }
                else{
                    $lead_operador->setds_custo_atual("0.00");
                }
                
                $lead_operador->setds_qtde_voz($arrLeadOperador[$i]['ds_qtde_voz']);
                $lead_operador->setds_qtde_dados($arrLeadOperador[$i]['ds_qtde_dados']);
                $lead_operador->setic_status($arrLeadOperador[$i]['ic_status']);
                $lead_operador->setclassificacao_pk($arrLeadOperador[$i]['classificacao_pk']);
                $lead_operador->settempo_contrato_pk($arrLeadOperador[$i]['tempo_contrato_pk']);

                $lead_operador_pk = $lead_operadordao->salvar($lead_operador);



            }
        }



        $mysql_data[] = array(
                "pk" => $leads_pk
            );

        $result  = 'success';
        $message = 'Registro salvo com sucesso.';

        break;
    }
    case 'listarPk':{

        $resultado = "";
        $query = $leaddao->listarPorPk($pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_pessoa_pk"=>$query[$i]['tipo_pessoa_pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_ie"=>$query[$i]['ds_ie'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_cnae"=>$query[$i]['ds_cnae'],
                    "ic_cliente"=>$query[$i]['ic_cliente'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "mailing_pk"=>$query[$i]['mailing_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ds_cliente"=>$query[$i]['ds_cliente'],
                    "ds_polo"=>$query[$i]['ds_polo'],
                    "ds_mailing"=>$query[$i]['ds_mailing'],
                    "ciclo_uso"=>$query[$i]['ciclo_uso'],
                    "ds_log"=>$query[$i]['ds_log'],
                    "polos_pk"=>$query[$i]['polos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        break;
    }
    case 'listarStatusSemInteresse':{

        $resultado = "";
        $query = $leaddao->listarStatusSemInteresse($pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "registro" => $query[$i]["registro"],
                );
            }
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        break;
    }
    case 'listarStatusContactado':{

        $resultado = "";
        $query = $leaddao->listarStatusContactado($pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "registro" => $query[$i]["registro"],
                );
            }
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        break;
    }
    case 'listarCarteiraLeadStatus':{

        
        $membro_equipe_pk = $_REQUEST['membro_equipe_pk'];
        $resultado = "";
        $query = $leaddao->listarStatusContactadoDashboard($membro_equipe_pk);
        $query = $leaddao->listarStatusNaoContactadoDashboard($membro_equipe_pk);
        $query = $leaddao->listarStatusSemInteresseDashboard($membro_equipe_pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "registro" => $query[$i]["registro"],
                );
            }
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        break;
    }
    case 'listarStatusNaoContactado':{

        $resultado = "";
        $query = $leaddao->listarStatusNaoContactado($pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "registro" => $query[$i]["registro"],
                );
            }
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        break;
    }
    case 'listarStatus':{

        $resultado = "";
        $query = $leaddao->listarStatus($pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "registro" => $query[$i]["registro"],
                    "ds_classificacao_processo" => $query[$i]["ds_classificacao_processo"]
                );
            }
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        break;
    }
    case 'listarPkSubMenu':{

        $resultado = "";
        $query = $leaddao->listarPkSubMenu($pk);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_pessoa_pk"=>$query[$i]['tipo_pessoa_pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ciclo_uso"=>$query[$i]['ciclo_uso'],
                    "ds_log"=>$query[$i]['ds_log'],
                    "ds_polo"=>$query[$i]['ds_polo']
                );
            }
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        break;
    }
    case 'listarTodos':{
        
        $resultado = "";
        $query = $leaddao->listarTodos();

        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_pessoa_pk"=>$query[$i]['tipo_pessoa_pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_ie"=>$query[$i]['ds_ie'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_cnae"=>$query[$i]['ds_cnae'],
                    "ic_cliente"=>$query[$i]['ic_cliente'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "mailing_pk"=>$query[$i]['mailing_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ciclo_uso"=>$query[$i]['ciclo_uso'],
                    "ds_log"=>$query[$i]['ds_log'],
                    "polos_pk"=>$query[$i]['polos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }


        break;
    }
    case 'listarDataTable':{
        $pk = $_REQUEST['pk'];
        $ds_lead = $_REQUEST['ds_lead'];
        $polos_pk= $_REQUEST['polos_pk'];
        $ds_razao_social= $_REQUEST['ds_razao_social'];
        $tipo_pessoa_pk= $_REQUEST['tipo_pessoa_pk'];
        $mailing_pk= $_REQUEST['mailing_pk'];
        $ds_processo_pk= $_REQUEST['ds_processo_pk'];
        $processo_default_pk= $_REQUEST['processo_default_pk'];
        $ic_cliente= $_REQUEST['ic_cliente'];
        $responsavel_pk= $_REQUEST['usuarios_pk'];
        $grupos_pk= $_REQUEST['grupos_pk'];
        $equipes_pk= $_REQUEST['equipes_pk'];
        
        $status_processo_pk= $_REQUEST['status_processo_pk'];
        $operador_pk= $_REQUEST['operador_pk'];
        
        
        $ds_cidade= $_REQUEST['ds_cidade'];
        
        $dt_ativacao_ini = $_REQUEST['dt_ativacao_ini'];
        $dt_ativacao_fim = $_REQUEST['dt_ativacao_fim'];
        $dt_vencimento_ini = $_REQUEST['dt_vencimento_ini'];
        $dt_vencimento_fim = $_REQUEST['dt_vencimento_fim'];
        $qtde_linhas_ini = $_REQUEST['qtde_linhas_ini'];
        $qtde_linhas_fim = $_REQUEST['qtde_linhas_fim'];
        $classificacao_operador_pk = $_REQUEST['classificacao_operador_pk'];
        $ds_cpf_cnpj = $_REQUEST['ds_cpf_cnpj'];
        $tempo_contrato_pk = $_REQUEST['tempo_contrato_pk'];
        $ciclo_uso = $_REQUEST['ciclo_uso'];
        $ds_log = $_REQUEST['ds_log'];
        $dt_transf_ini = $_REQUEST['dt_transf_ini'];
        $dt_transf_fim = $_REQUEST['dt_transf_fim'];
        $dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
        $dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];
        
        $qtde_ult_oc = $_REQUEST['qtde_ult_oc'];
        

        $resultado = "";
        $query = $leaddao->listarLeadsRes($token,
                $pk,
                $ds_lead,
                $polos_pk,
                $ds_razao_social,
                $tipo_pessoa_pk,
                $mailing_pk,
                $ds_processo_pk,
                $processo_default_pk,
                $ic_cliente,
                $responsavel_pk,
                $grupos_pk,
                $equipes_pk,
                $status_processo_pk,
                $operador_pk,
                $qtde_linhas_ini,
                $qtde_linhas_fim,
                $dt_ativacao_ini,
                $dt_ativacao_fim,
                $dt_vencimento_ini,
                $dt_vencimento_fim,
                $classificacao_operador_pk,
                $ds_cpf_cnpj,
                $tempo_contrato_pk,
                $ciclo_uso,
                $ds_log,
                $ds_cidade,
                $dt_transf_ini,
                $dt_transf_fim,
                $dt_cadastro_ini,
                $dt_cadastro_fim,
                $qtde_ult_oc);
        $result  = 'success';
        $message = 'query success';
        if(count($query) > 0){

            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>str_replace("'"," ",$query[$i]['ds_lead']),
                    "t_ds_classificacao_processo"=>$query[$i]['classificacao_processo_pk'],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],
                    "t_ds_qtde_voz"=>$query[$i]['ds_qtde_voz'],
                    "t_tempo_contrato_pk"=>$query[$i]['tempo_contrato_pk'],
                    "t_qtde_dias"=>$query[$i]['qtde_dias'],
                    "t_ultcontato"=>$query[$i]['ultcontato'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                              "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }

        break;
    }
    case 'listarLeadPesquisa':{

        $pesquisar= $_REQUEST['pesquisar'];

        $resultado = "";

        $query = $leaddao->listarLeadPesquisa($pesquisar,$token);
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
					"t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_ds_classificacao_processo"=>$query[$i]['ds_classificacao_processo'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }

        break;
    }
    case 'RelListarLead':{

        $leads_pk=$_REQUEST['leads_pk'];
        $ds_lead = $_REQUEST['ds_lead'];
        $polos_pk = $_REQUEST['polos_pk'];
        $grupo_pk = $_REQUEST['grupos_pk'];
        $responsavel_pk = $_REQUEST['responsavel_pk'];
        $equipes_pk = $_REQUEST['equipes_pk'];


        $resultado = "";

        $query = $leaddao->relListarLead($leads_pk,$ds_lead,$polos_pk,$grupo_pk,$responsavel_pk,$equipes_pk,$token);
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_ds_classificacao_processo"=>$query[$i]['ds_classificacao_processo'],
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }

        break;
    }

    case 'listarContatoLead':{
        $leads_pk = $_REQUEST['leads_pk'];

        $resultado = "";
        if($leads_pk!=""){

            $query = $contatodao->carregarPorLeadsPk($leads_pk);
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_contato"=>$query[$i]['ds_contato'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ds_whatsapp"=>$query[$i]['ds_whatsapp'],
                    "t_ic_whatsapp"=>$query[$i]['ic_whatsapp'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],
                    "t_cargos_pk"=>$query[$i]['cargos_pk'],
                    "t_ds_cargos_pk"=>$query[$i]['ds_cargos_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }

        break;

    }
    case 'listarCPF':{
        $ds_cnpj_cpf = $_REQUEST['ds_cpf_cnpj'];
        $pkIgnorar = $_REQUEST['pk'];

        $resultado = "";
        if($ds_cnpj_cpf!=""){
            $query = $leaddao->listarCpfCnpjDuplicado($ds_cnpj_cpf, $pkIgnorar);
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }

        break;

    }
    default:{
        break;
    }
    
    case 'listarCarteiraLeadStatusSupervisor':{

        
        $membro_equipe_pk = $_REQUEST['membro_equipe_pk'];
        
        
        
        $query_usuario = $usuariodao->listar_membro_equipe($membro_equipe_pk);
        
        $resultado = "";
        $result  = 'success';
        $message = 'query success';

        if(count($query_usuario) > 0){
            for($i = 0; $i < count($query_usuario); $i++){
                
                $query_contactado = $leaddao->listarStatusContactadoDashboard($query_usuario[$i]['pk']);
                $query_nao_contactado = $leaddao->listarStatusNaoContactadoDashboard($query_usuario[$i]['pk']);
                $query_sem_interesse = $leaddao->listarStatusSemInteresseDashboard($query_usuario[$i]['pk']);
                $query_25 = $leaddao->listarStatus25Dashboard($query_usuario[$i]['pk']);
                $query_50 = $leaddao->listarStatus50Dashboard($query_usuario[$i]['pk']);
                $query_75 = $leaddao->listarStatus75Dashboard($query_usuario[$i]['pk']);
                $query_80 = $leaddao->listarStatus80Dashboard($query_usuario[$i]['pk']);
                $query_90 = $leaddao->listarStatus90Dashboard($query_usuario[$i]['pk']);
                $query_Cliente = $leaddao->listarStatusClienteDashboard($query_usuario[$i]['pk']);
                
                
                
                
                
                $mysql_data[] = array(
                    "ds_usuario" => $query_usuario[$i]['ds_usuario'],
                    "qtde_nao_contactado" => $query_nao_contactado[0]['registro'],
                    "qtde_contactado" => count($query_contactado),
                    "qtde_sem_interesse" => $query_sem_interesse[0]['registro'],
                    "qtde_25" => $query_25[0]['registro'],
                    "qtde_50" => $query_50[0]['registro'],
                    "qtde_75" => $query_75[0]['registro'],
                    "qtde_80" => $query_80[0]['registro'],
                    "qtde_90" => $query_90[0]['registro'],
                    "qtde_cliente" => $query_cliente[0]['registro'],
                );
            }
        }
        else{
            $mysql_data = [];
        }


        $result  = 'success';
        $message = 'query success';

        break;
    }


}

$leaddao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Limpar qualquer buffer de saída anterior
if (ob_get_level()) {
    ob_clean();
}

// Convert PHP array to JSON array
header('Content-Type: application/json; charset=utf-8');
$data = cleanDataForJSON($data);
$json_data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

// Verificar se o JSON é válido antes de enviar
if ($json_data === false) {
    // Em caso de erro no JSON, retornar um JSON de erro
    $error_json = json_encode([
        "result" => "error",
        "message" => "JSON encoding failed: " . json_last_error_msg(),
        "data" => []
    ]);
    echo $error_json;
} else {
    echo $json_data;
}


?>
