<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/transferencia_lead.dao.php";

include_once "../model/lead_responsavel.dao.php";
include_once "../model/lead_responsavel.class.php";

include_once "../model/tipo_ocorrencia.dao.php";
include_once "../model/tipo_ocorrencia.class.php";

include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$ds_cep = $arrRequest['ds_cep'];

$transferencia_leaddao = new transferencia_leaddao();
$transferencia_leaddao->setToken($token);

$lead_responsaveldao = new lead_responsaveldao();
$lead_responsaveldao->setToken($token); 

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token); 

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token); 




switch($job){ 
    case 'listarQtdeLead':{
        $polos_pk = $_REQUEST['polos_pk'];
        $ds_razao_social = $_REQUEST['ds_razao_social'];
        $ic_status_1 = $_REQUEST['ic_status_1'];
        $ic_status_2 = $_REQUEST['ic_status_2'];
        $ic_status_3 = $_REQUEST['ic_status_3'];
        $ic_status_4 = $_REQUEST['ic_status_4'];
        $grupos_pk = $_REQUEST['grupos_pk'];
        $usuarios_pk = $_REQUEST['usuarios_pk'];
        $tipo_pessoa_pk = $_REQUEST['tipo_pessoa_pk'];
        $mailing_pk= $_REQUEST['mailing_pk'];
        $operador_pk = $_REQUEST['operador_pk'];
        $classificacao_operador_pk = $_REQUEST['classificacao_operador_pk'];
        $tempo_contrato_pk = $_REQUEST['tempo_contrato_pk'];
        $qtde_linhas_ini = $_REQUEST['qtde_linhas_ini'];
        $qtde_linhas_fim = $_REQUEST['qtde_linhas_fim'];
        
        $resultado = "";
        $query = $transferencia_leaddao->listarQtdeLead($polos_pk,$ds_razao_social,$ic_status_1,$ic_status_2,$ic_status_3,$ic_status_4,$grupos_pk,$usuarios_pk,$tipo_pessoa_pk,$mailing_pk,$operador_pk,$classificacao_operador_pk,$tempo_contrato_pk,$qtde_linhas_ini,$qtde_linhas_fim);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "qtde_registros" => $query[$i]["qtde_registros"],
                    "ds_classificacao"=>$query[$i]['ds_classificacao']
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
    case 'transferirLead':{
        $polos_pk = $_REQUEST['polos_pk'];
        $ds_razao_social = $_REQUEST['ds_razao_social'];
        $ic_status_1 = $_REQUEST['ic_status_1'];
        $ic_status_2 = $_REQUEST['ic_status_2'];
        $ic_status_3 = $_REQUEST['ic_status_3'];
        $ic_status_4 = $_REQUEST['ic_status_4'];
        $grupos_pk = $_REQUEST['grupos_pk'];
        $usuarios_pk = $_REQUEST['usuarios_pk'];
        $tipo_pessoa_pk = $_REQUEST['tipo_pessoa_pk'];
        $mailing_pk= $_REQUEST['mailing_pk'];
        $operador_pk = $_REQUEST['operador_pk'];
        $classificacao_operador_pk = $_REQUEST['classificacao_operador_pk'];
        $tempo_contrato_pk = $_REQUEST['tempo_contrato_pk'];
        $qtde_linhas_ini = $_REQUEST['qtde_linhas_ini'];
        $qtde_linhas_fim = $_REQUEST['qtde_linhas_fim'];
        $total_transferencia= $_REQUEST['total_transferencia'];
        
        $responsavel_pk = $_REQUEST['responsavel_pk'];
        $grupo_responsavel = $_REQUEST['grupo_responsavel'];
        
        $resultado = "";
        $query = $transferencia_leaddao->TransferirLead($polos_pk,$ds_razao_social,$ic_status_1,$ic_status_2,$ic_status_3,$ic_status_4,$grupos_pk,$usuarios_pk,$tipo_pessoa_pk,$mailing_pk,$operador_pk,$classificacao_operador_pk,$tempo_contrato_pk,$qtde_linhas_ini,$qtde_linhas_fim,$total_transferencia);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $query1 = $tipo_ocorrenciadao->listarTipoOcTransferencia();
        
                //GERA OCORRENCIA
                if($query1[0]['pk']!=""){
                    $ocorrencia = $ocorrenciadao->carregarPorPk('');
                    $ocorrencia->setds_ocorrencia("Transferência de Lead");
                    $ocorrencia->settipos_ocorrencias_pk($query1[0]['pk']);
                    $ocorrencia->setleads_pk($query[$i]['pk']);
                    $ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);

                }
                
                
                $lead_responsavel = $lead_responsaveldao->carregarPorPk($query[$i]['lead_responsavel_pk']);
                $lead_responsavel->setgrupos_pk($grupo_responsavel);
                $lead_responsavel->setusuarios_pk($responsavel_pk);
                $lead_responsavel->setpolos_pk($polos_pk);
                $lead_responsavel->setleads_pk($query[$i]['pk']);
                $lead_responsavel_pk = $lead_responsaveldao->salvar($lead_responsavel);
                
                
                 
                 
            }
        }
        
        
        
			

        $result  = 'success';
        $message = 'query success';
        
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
