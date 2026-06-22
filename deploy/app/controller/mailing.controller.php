<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/mailing.dao.php";
include_once "../model/mailing.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_mailing = $arrRequest['ds_mailing'];
$ic_status = $arrRequest['ic_status'];
$contas_pk = $arrRequest['contas_pk'];
$polos_pk = $arrRequest['polos_pk'];


$mailingdao = new mailingdao();
$mailingdao->setToken($token); 

$result = 'error';
$message = 'Requisição inválida.';
$mysql_data = array();

verificarLogin($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $mailing = $mailingdao->carregarPorPk($pk);
        if($mailing->getpk()>0){
            
            $mailingdao->excluir($mailing);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'mailing nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $mailing = $mailingdao->carregarPorPk($pk);
        $mailing->setds_mailing($ds_mailing);
        $mailing->setic_status($ic_status);
        $mailing->setpolos_pk($polos_pk);

        
        $pk = $mailingdao->salvar($mailing);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $mailingdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_mailing"=>$query[$i]['ds_mailing'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "contas_pk"=>$query[$i]['contas_pk'],
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
    case 'listarTodos':{
        
        $resultado = "";
        $query = $mailingdao->listar_por_ds_mailing($ds_mailing);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_mailing"=>$query[$i]['ds_mailing'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "polos_pk"=>$query[$i]['polos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorContasPk':{
        
        $resultado = "";
        $query = $mailingdao->listar_mailing_conta($ds_mailing);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_mailing"=>$query[$i]['ds_mailing'],
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
        
        $polos_pk = $_REQUEST['polos_pk'];
        $ds_mailing = $_REQUEST['ds_mailing'];
        $ic_status = $_REQUEST['ic_status'];
        $resultado = "";
        $query = $mailingdao->listar_por_ds_mailing($ds_mailing,$ic_status,$polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_mailing"=>$query[$i]['ds_mailing'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_contas_pk"=>$query[$i]['contas_pk'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_ds_status"=>$query[$i]['ds_status'],

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

$mailingdao = null;

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
