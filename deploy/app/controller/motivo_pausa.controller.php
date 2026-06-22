<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/motivo_pausa.dao.php";
include_once "../model/motivo_pausa.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_motivo_pausa = $arrRequest['ds_motivo_pausa'];


$motivo_pausadao = new motivo_pausadao();
$motivo_pausadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $motivo_pausa = $motivo_pausadao->carregarPorPk($pk);
        if($motivo_pausa->getpk()>0){
            
            $motivo_pausadao->excluir($motivo_pausa);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'motivo_pausa nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $motivo_pausa = $motivo_pausadao->carregarPorPk($pk);
        $motivo_pausa->setds_motivo_pausa($ds_motivo_pausa);

        
        $pk = $motivo_pausadao->salvar($motivo_pausa);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $motivo_pausadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_motivo_pausa"=>$query[$i]['ds_motivo_pausa']
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
        $query = $motivo_pausadao->listar_por_ds_motivo_pausa($ds_motivo_pausa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_motivo_pausa"=>$query[$i]['ds_motivo_pausa']
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
        $query = $motivo_pausadao->listar_por_ds_motivo_pausa($ds_motivo_pausa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_motivo_pausa"=>$query[$i]['ds_motivo_pausa'],

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

$motivo_pausadao = null;

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
