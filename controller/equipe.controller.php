<? error_reporting(0);

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/equipe.dao.php";
include_once "../model/equipe.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_equipe = $arrRequest['ds_equipe'];
$polos_pk = $arrRequest['polos_pk'];


$equipedao = new equipedao();
$equipedao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $equipe = $equipedao->carregarPorPk($pk);
        if($equipe->getpk()>0){
            
            $equipedao->excluirEquipeUsuario($equipe->getpk());
            $equipedao->excluir($equipe);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'equipe nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $equipes_usuarios = $_REQUEST['equipes_usuarios'];
        
        if($equipes_usuarios != "")
            $arrEquipesUsuariosPk = json_decode ($equipes_usuarios, true);
        $equipe = $equipedao->carregarPorPk($pk);
        $equipe->setds_equipe($ds_equipe);
        $equipe->setpolos_pk($polos_pk);

        
        $pk = $equipedao->salvar($equipe);
        
        if($pk>0){
            $equipes_pk = $pk;
        }
        else{
            $equipes_pk = $equipe->getpk();
        }
        $equipedao->excluirEquipeUsuario($equipes_pk);
        if(count($arrEquipesUsuariosPk) > 0){
            
            for($i = 0; $i < count($arrEquipesUsuariosPk); $i++){
                
                $equipedao->adicionarEquipesUsuarios($equipes_pk, $arrEquipesUsuariosPk[$i]['usuarios_pk'],$arrEquipesUsuariosPk[$i]['ic_bko'],$arrEquipesUsuariosPk[$i]['ic_supervisor']);
            }
        }
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $equipedao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_equipe"=>$query[$i]['ds_equipe'],
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
        $query = $equipedao->listar_por_ds_equipe($ds_equipe,$polos_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_equipe"=>$query[$i]['ds_equipe']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarTodosConta':{
        
        $resultado = "";
        $query = $equipedao->listar_por_conta();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_equipe"=>$query[$i]['ds_equipe']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listarEquipesUsuarios':{
        
        $resultado = "";
        $result  = 'success';
        $message = 'query success';
        if($pk!=""){
            $query = $equipedao->listar_usuarios_equipe($pk);
        
            

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "t_usuarios_pk"=>$query[$i]['usuarios_pk'],
                        "t_ic_bko"=>$query[$i]['ic_bko'],
                        "t_ic_supervisor"=>$query[$i]['ic_supervisor']
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
    case 'listarEquipesCalendario':{
        
        $resultado = "";
        $result  = 'success';
        $message = 'query success';
            $query = $equipedao->listar_usuarios_equipe_calendario($token);
        
            

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "t_usuarios_pk"=>$query[$i]['usuarios_pk'],
                        "t_ic_bko"=>$query[$i]['ic_bko'],
                        "ds_equipe"=>$query[$i]['ds_equipe'],
                        "t_ic_supervisor"=>$query[$i]['ic_supervisor']
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
        $query = $equipedao->listar_por_ds_equipe($ds_equipe,$polos_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_equipe"=>$query[$i]['ds_equipe'],

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

$equipedao = null;

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
