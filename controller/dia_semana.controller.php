<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/dia_semana.dao.php";
include_once "../model/dia_semana.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_dia_semana = $arrRequest['ds_dia_semana'];


$dia_semanadao = new dia_semanadao();
$dia_semanadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $dia_semana = $dia_semanadao->carregarPorPk($pk);
        if($dia_semana->getpk()>0){
            
            $dia_semanadao->excluir($dia_semana);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'dia_semana nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $dia_semana = $dia_semanadao->carregarPorPk($pk);
        $dia_semana->setds_dia_semana($ds_dia_semana);

        
        $pk = $dia_semanadao->salvar($dia_semana);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $dia_semanadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_dia_semana"=>$query[$i]['ds_dia_semana']
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
        $query = $dia_semanadao->listar_por_ds_dia_semana($ds_dia_semana);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_dia_semana"=>$query[$i]['ds_dia_semana']
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
        $query = $dia_semanadao->listar_por_ds_dia_semana($ds_dia_semana);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_dia_semana"=>$query[$i]['ds_dia_semana'],

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

$dia_semanadao = null;

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
