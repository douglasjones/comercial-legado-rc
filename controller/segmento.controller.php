<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/segmento.dao.php";
include_once "../model/segmento.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_segmento = $arrRequest['ds_segmento'];
$ic_status = $arrRequest['ic_status'];


$segmentodao = new segmentodao();
$segmentodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $segmento = $segmentodao->carregarPorPk($pk);
        if($segmento->getpk()>0){
            
            $segmentodao->excluir($segmento);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'segmento nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $segmento = $segmentodao->carregarPorPk($pk);
        $segmento->setds_segmento($ds_segmento);
        $segmento->setic_status($ic_status);

        
        $pk = $segmentodao->salvar($segmento);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $segmentodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_segmento"=>$query[$i]['ds_segmento'],
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
        $query = $segmentodao->listar_por_ds_segmento($ds_segmento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_segmento"=>$query[$i]['ds_segmento'],
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
        $query = $segmentodao->listar_por_ds_segmento($ds_segmento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_segmento"=>$query[$i]['ds_segmento'],
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

$segmentodao = null;

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
