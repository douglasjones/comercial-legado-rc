<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/processo_default_etapa.dao.php";
include_once "../model/processo_default_etapa.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_processo_default_etapas = $arrRequest['ds_processo_default_etapa'];
$n_ordem_etapa = $arrRequest['n_ordem_etapa'];
$processos_default_pk = $arrRequest['processos_default_pk'];


$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $processo_default_etapa = $processo_default_etapadao->carregarPorPk($pk);
        if($processo_default_etapa->getpk()>0){
            
            $processo_default_etapadao->excluir($processo_default_etapa);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'processo_default_etapa nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $processo_default_etapa = $processo_default_etapadao->carregarPorPk($pk);
        $processo_default_etapa->setds_processo_default_etapa($ds_processo_default_etapa);
        $processo_default_etapa->setn_ordem_etapa($n_ordem_etapa);
        $processo_default_etapa->setprocessos_default_pk($processos_default_pk);

        
        $pk = $processo_default_etapadao->salvar($processo_default_etapa);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $processo_default_etapadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo_default_etapa"=>$query[$i]['ds_processo_default_etapa'],
                    "n_ordem_etapa"=>$query[$i]['n_ordem_etapa'],
                    "processos_default_pk"=>$query[$i]['processos_default_pk']
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
    case 'listarProcessoDefaultPk':{
        $processo_default_pk = $_REQUEST['processo_default_pk'];
        $resultado = "";
        
        if($processo_default_pk!=""){
            $query = $processo_default_etapadao->listar_por_processo_default_pk($processo_default_pk);
        }
        else{
            $mysql_data = [];
        }
        
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "t_ds_processo_default_etapa"=>$query[$i]['ds_processo_default_etapa'],
                    "t_n_ordem_etapa"=>$query[$i]['n_ordem_etapa'],
                    "t_processos_default_pk"=>$query[$i]['processos_default_pk'],
                    "t_tipo_ocorrencia_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    
                    "t_ic_ev_email_responsavel"=>$query[$i]['ic_ev_email_responsavel'],
                    "t_ic_ev_email_lead"=>$query[$i]['ic_ev_email_lead'],
                    "t_email_saida_grupos_pk"=>$query[$i]['email_saida_grupos_pk'],
                    "t_ds_email_saida"=>$query[$i]['ds_email_saida'],
                    "t_classificacao_processo_etapa_pk"=>$query[$i]['classificacao_processo_etapa_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $processo_default_etapadao->listar_por_ds_processo_default_etapas($ds_processo_default_etapas);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_processo_default_etapas"=>$query[$i]['ds_processo_default_etapa'],
                    "t_n_ordem_etapa"=>$query[$i]['n_ordem_etapa'],
                    "t_processos_default_pk"=>$query[$i]['processos_default_pk'],

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

$processo_default_etapadao = null;

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
