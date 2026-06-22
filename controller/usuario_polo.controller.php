<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/usuario_polo.dao.php";
include_once "../model/usuario_polo.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$polos_pk = $arrRequest['polos_pk'];
$usuarios_pk = $arrRequest['usuarios_pk'];
$ic_status = $arrRequest['ic_status'];


$usuario_polodao = new usuario_polodao();
$usuario_polodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $usuario_polo = $usuario_polodao->carregarPorPk($pk);
        if($usuario_polo->getpk()>0){
            
            $usuario_polodao->excluir($usuario_polo);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'usuario_polo nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $usuario_polo = $usuario_polodao->carregarPorPk($pk);
        $usuario_polo->setpolos_pk($polos_pk);
        $usuario_polo->setusuarios_pk($usuarios_pk);
        $usuario_polo->setic_status($ic_status);

        
        $pk = $usuario_polodao->salvar($usuario_polo);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $usuario_polodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "usuarios_pk"=>$query[$i]['usuarios_pk'],
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
        $query = $usuario_polodao->listar_por_polos_pk($polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "usuarios_pk"=>$query[$i]['usuarios_pk'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }		
        
        break;
    }
    case 'listarPolosUsuario':{
        
        $resultado = "";
        if($usuarios_pk==""){
            $mysql_data = [];
        }
        else{
            $query = $usuario_polodao->listar_polos_por_usuario($polos_pk,$usuarios_pk);
        }
        
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "ds_polo"=>$query[$i]['ds_polo'],
                    "usuarios_pk"=>$query[$i]['usuarios_pk'],
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
        $query = $usuario_polodao->listar_por_polos_pk($polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_usuarios_pk"=>$query[$i]['usuarios_pk'],
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

$usuario_polodao = null;

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
