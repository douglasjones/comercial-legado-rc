<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/plano.dao.php";
include_once "../model/plano.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_plano = $arrRequest['ds_plano'];
$vl_plano = $arrRequest['vl_plano'];
$segmentos_pk = $arrRequest['segmentos_pk'];
$ic_status = $arrRequest['ic_status'];


$planodao = new planodao();
$planodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $plano = $planodao->carregarPorPk($pk);
        if($plano->getpk()>0){
            
            $planodao->excluir($plano);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'plano nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $plano = $planodao->carregarPorPk($pk);
        $plano->setds_plano($ds_plano);
        $plano->setvl_plano($vl_plano);
        $plano->setsegmentos_pk($segmentos_pk);
        $plano->setic_status($ic_status);

        
        $pk = $planodao->salvar($plano);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $planodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_plano"=>$query[$i]['ds_plano'],
                    "vl_plano"=>$query[$i]['vl_plano'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $planodao->listar_por_ds_plano($ds_plano);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_plano"=>$query[$i]['ds_plano'],
                    "vl_plano"=>$query[$i]['vl_plano'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $planodao->listar_por_ds_plano($ds_plano);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_plano"=>$query[$i]['ds_plano'],
                    "t_vl_plano"=>$query[$i]['vl_plano'],
                    "t_segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "t_ic_status"=>$query[$i]['ic_status'],

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

$planodao = null;

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
