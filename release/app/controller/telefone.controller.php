<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/telefone.dao.php";
include_once "../model/telefone.class.php";

header('Content-Type: application/json; charset=utf-8');

$arrRequest = tratar_request();

$job = isset($arrRequest['job']) ? $arrRequest['job'] : "";
$token = isset($arrRequest['token']) ? $arrRequest['token'] : "";
$pk = isset($arrRequest['pk']) ? $arrRequest['pk'] : "";
$tipo_telefone_pk = isset($arrRequest['tipo_telefone_pk']) ? $arrRequest['tipo_telefone_pk'] : "";
$ds_tel = isset($arrRequest['ds_tel']) ? $arrRequest['ds_tel'] : "";
$ds_ddd = isset($arrRequest['ds_ddd']) ? $arrRequest['ds_ddd'] : "";
$ic_status = isset($arrRequest['ic_status']) ? $arrRequest['ic_status'] : "";
$leads_pk = isset($arrRequest['leads_pk']) ? $arrRequest['leads_pk'] : "";
$contas_pk = isset($arrRequest['contas_pk']) ? $arrRequest['contas_pk'] : "";
$polos_pk = isset($arrRequest['polos_pk']) ? $arrRequest['polos_pk'] : "";

$result = "error";
$message = "";
$mysql_data = [];


$telefonedao = new telefonedao();
$telefonedao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $telefone = $telefonedao->carregarPorPk($pk);
        if($telefone->getpk()>0){
            
            $telefonedao->excluir($telefone);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'telefone nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $telefone = $telefonedao->carregarPorPk($pk);
        $telefone->settipo_telefone_pk($tipo_telefone_pk);
        $telefone->setds_tel($ds_tel);
        $telefone->setds_ddd($ds_ddd);
        $telefone->setic_status($ic_status);
        $telefone->setleads_pk($leads_pk);
        $telefone->setcontas_pk($contas_pk);
        $telefone->setpolos_pk($polos_pk);

        
        $pk = $telefonedao->salvar($telefone);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $telefonedao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_telefone_pk"=>$query[$i]['tipo_telefone_pk'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "leads_pk"=>$query[$i]['leads_pk'],
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
    case 'listarPorLead':{
        if($leads_pk==""){
            $leads_pk = 0;
        }

        $resultado = "";
        $query = $telefonedao->listarPorLeadPk($leads_pk);
        
        if(count($query) > 0){
         
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_telefone_pk"=>$query[$i]['tipo_telefone_pk'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ds_tipo_telefone"=>$query[$i]['ds_tipo_telefone'],
                    "ds_ddd_tel"=>$query[$i]['ds_ddd_tel'],
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
        $query = $telefonedao->listar_por_tipo_telefone_pk($tipo_telefone_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_telefone_pk"=>$query[$i]['tipo_telefone_pk'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "leads_pk"=>$query[$i]['leads_pk'],
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
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $telefonedao->listar_por_tipo_telefone_pk($tipo_telefone_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_tipo_telefone_pk"=>$query[$i]['tipo_telefone_pk'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],
                    "t_ds_ddd"=>$query[$i]['ds_ddd'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contas_pk"=>$query[$i]['contas_pk'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],

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

$telefonedao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
if ($json_data === false) {
    error_log("JSON encode error in telefone.controller.php: " . json_last_error_msg());
    $json_data = json_encode([
        "result" => "error",
        "message" => "json_encode_failed",
        "data" => []
    ]);
}
echo $json_data;


?>
