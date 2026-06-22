<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";

include_once "../model/processo.dao.php";
include_once "../model/processo.class.php";

include_once "../model/processo_default.dao.php";
include_once "../model/processo_default.class.php";

include_once "../model/contrato.class.php";
include_once "../model/contrato.dao.php";

include_once "../model/contrato_item.class.php";
include_once "../model/contrato_item.dao.php";


include_once "../model/processo_default_etapa.dao.php";
include_once "../model/processo_default_etapa.class.php";

include_once "../model/agenda_visita.dao.php";
include_once "../model/agenda_visita.class.php";

include_once "../model/proposta.dao.php";
include_once "../model/proposta.class.php";

include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$leads_pk = $arrRequest['leads_pk'];
$polos_pk = $arrRequest['polos_pk'];
$motivo_cancelamento_processo_pk = $arrRequest['motivo_cancelamento_processo_pk'];
$ds_motivo_cancelamento = $arrRequest['ds_motivo_cancelamento'];
$processos_cancelamento_pk = $arrRequest['processos_cancelamento_pk'];


$contratodao = new contratodao();
$contratodao->setToken($token);

$contrato_itemdao = new contrato_itemdao();
$contrato_itemdao->setToken($token); 

$processodao = new processodao();
$processodao->setToken($token); 

$processo_defaultdao = new processo_defaultdao();
$processo_defaultdao->setToken($token); 

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token); 

$agenda_visitadao = new agenda_visitadao();
$agenda_visitadao->setToken($token); 

$propostadao = new propostadao();
$propostadao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $processo= $processodao->carregarPorPk($pk);
        $contrato = $contratodao->listar_contrato_lead_processo($leads_pk,$pk);
        $agenda = $agenda_visitadao->listar_agenda_visita_lead_processo($leads_pk,$pk);
        $proposta = $propostadao->listar_proposta_lead_processo($leads_pk,$pk);
       
        
        
        
        if(count($contrato) > 0){
            for($i = 0; $i < count($contrato); $i++){
                $contrato_itemdao->excluirPorContrato($contrato[$i]['pk']);
            }
        }
        
        if(count($agenda) > 0){
            for($i = 0; $i < count($agenda); $i++){
                $agenda_visitadao->excluirResponsavelPk($agenda[$i]['pk']);
            }
        }
        if(count($proposta) > 0){
            for($i = 0; $i < count($proposta); $i++){
                $propostadao->excluirItemPropostaPk($proposta[$i]['pk']);
            }
        }
        
        if($processo->getpk()>0){
            $query = $processodao->listarEtapasPorPk($processo->getpk());
            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $ocorrencia = $ocorrenciadao->listar_ocorrencia_processo_lead($leads_pk,$query[$i]["pk"]);
                   
                    if(count($ocorrencia) > 0){
                        for($j = 0; $j < count($ocorrencia); $j++){
                            $ocorrenciadao->excluirRetornos($ocorrencia[$j]['pk']);
                        }
                    }
                    
                    
                    $processodao->excluirContratos($query[$i]["pk"]);
                    $processodao->excluirAgenda($query[$i]["pk"]);
                    $processodao->excluirPropostas($query[$i]["pk"]);
                    $processodao->excluirOcorrencias($query[$i]["pk"]);
                }
            }
            $processodao->excluirProcessosEtapasPk($processo->getpk());
            $processodao->excluir($processo);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'processo nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        if($motivo_cancelamento_processo_pk!=""){
               
            $processo = $processodao->carregarPorPk($processos_cancelamento_pk);
            $processo->setleads_pk($leads_pk);
            $processo->setmotivo_cancelamento_processo_pk($motivo_cancelamento_processo_pk);
            $processo->setds_motivo_cancelamento($ds_motivo_cancelamento);
            $processo->setpolos_pk($polos_pk);
            
            
            $processo_pk = $processodao->salvar($processo);
            $mysql_data[] = array(
                "pk" => $processo_pk
            );
            
           }
           else{
               
                $processo_default= $processo_defaultdao->carregarPorPk($pk);
        
                if($processo_default->getpk()>0){

                        $processo = $processodao->carregarPorPk("");
                        $processo->setds_processo($processo_default->getds_processo_default());

                        $processo->setprocessos_default_pk($processo_default->getpk());
                        $processo->setleads_pk($leads_pk);
                        $processo->setmotivo_cancelamento_processo_pk($motivo_cancelamento_processo_pk);
                        $processo->setds_motivo_cancelamento($ds_motivo_cancelamento);
                        $processo->setpolos_pk($polos_pk);

                        $processo_pk = $processodao->salvar($processo);
                        $mysql_data[] = array(
                            "pk" => $processo_pk,
                            "processos_default_pk" => $processo_default->getpk()
                        );

                }       
           }
       
        
        
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $processodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo"=>$query[$i]['ds_processo'],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "tipo_pessoa_pk"=>$query[$i]['tipo_pessoa_pk'],
                    "ds_classificacao_processo"=>$query[$i]['ds_classificacao_processo'],
                    "ds_polo"=>$query[$i]['ds_polo'],
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
    case 'listarEtapas':{
        $pk = $_REQUEST['pk'];
        $resultado = "";
        $query = $processodao->listarEtapasPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "etapas"=>$query[$i]['etapas'],
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
    case 'listarEtapasLeads':{
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $processodao->listarEtapasPorLeadsPk($leads_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "etapas"=>$query[$i]['etapas'],
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
        $query = $processodao->listar_por_ds_processo($ds_processo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo"=>$query[$i]['ds_processo'],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "leads_pk"=>$query[$i]['leads_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarProcessoLead':{
        $resultado = "";
        
        if($leads_pk!=""){
            $query = $processodao->listarPorLeadsPk($leads_pk);
        
            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
 
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "t_pk" => $query[$i]["pk"],
                        "t_ds_processo"=>$query[$i]['ds_processo'],
                        "processos_default_pk"=>$query[$i]['processos_default_pk'],
                        "t_ds_classificacao"=>$query[$i]['ds_classificacao'],
                        "t_dt_inicio"=>$query[$i]['dt_inicio'],
                        "t_dt_fim"=>$query[$i]['dt_fim'],
                        "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                        "leads_pk"=>$query[$i]['leads_pk']
                    );
                }
            }
            else{
                $mysql_data = [];
            }
        }
        else{
            $mysql_data = [];
        }		
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $processodao->listar_por_ds_processo($ds_processo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_processo"=>$query[$i]['ds_processo'],
                    "processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],

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
}

$processodao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
