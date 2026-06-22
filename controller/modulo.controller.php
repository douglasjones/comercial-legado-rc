 <? error_reporting(0);

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/modulo.dao.php";
include_once "../model/modulo.class.php";

$job = $_REQUEST['job'];
$token = $_REQUEST['token'];

$modulodao = new modulodao();
$modulodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        $pk = $_REQUEST['pk'];
        $modulo = $modulodao->carregarPorPk($pk);
        if($modulo->getpk()>0){
            
            $modulodao->excluir($modulo);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'modulo nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $pk = $_REQUEST['pk'];
        $ds_modulo = $_REQUEST['ds_modulo'];
        $ds_dominio = $_REQUEST['ds_dominio'];
        $polos_pk = $_REQUEST['polos_pk'];

        
        $modulo = $modulodao->carregarPorPk($pk);
        $modulo->setds_modulo($ds_modulo);
        $modulo->setds_dominio($ds_dominio);
        $modulo->setpolos_pk($polos_pk);

        
        $pk = $modulodao->salvar($modulo);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $pk = $_REQUEST['pk'];
        $query = $modulodao->listarPorPk($pk);
        
        for($i = 0; $i < count($query); $i++){
            
            $mysql_data[] = array(
                "pk" => $query[$i]["pk"],
                "ds_modulo"=>$query[$i]['ds_modulo'],
                "polos_pk"=>$query[$i]['polos_pk'],
                "ds_dominio"=>$query[$i]['ds_dominio']
            );
        }

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $modulodao->listar_por_ds_modulo($ds_modulo);
        
        $result  = 'success';
        $message = 'query success';

        for($i = 0; $i < count($query); $i++){
            
            $mysql_data[] = array(
                "pk" => $query[$i]["pk"],
                "ds_modulo"=>$query[$i]['ds_modulo'],
                "ds_dominio"=>$query[$i]['ds_dominio']
            );
        }
        
        break;
    }
    case 'listarDataTable':{
        
        $ds_modulo = $_REQUEST['ds_modulo'];
        $polos_pk = $_REQUEST['polos_pk'];
        $resultado = "";
        $query = $modulodao->listar_por_ds_modulo($ds_modulo,$polos_pk);
        
        $result  = 'success';
        $message = 'query success';
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_modulo"=>$query[$i]['ds_modulo'],
                    "t_ds_dominio"=>$query[$i]['ds_dominio']
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

$modulodao = null;

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
