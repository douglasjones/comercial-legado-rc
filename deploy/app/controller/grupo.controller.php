<? error_reporting(0);

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/grupo.dao.php";
include_once "../model/grupo.class.php";

$job = $_REQUEST['job'];
$token = $_REQUEST['token'];

$grupodao = new grupodao();
$grupodao->setToken($token);

switch($job){

    case 'excluir':{
        
        $pk = $_REQUEST['pk'];
        $grupo = $grupodao->carregarPorPk($pk);
        if($grupo->getpk()>0){
            
            $grupodao->excluir($grupo);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'grupo nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $pk = $_REQUEST['pk'];
        $ds_grupo = $_REQUEST['ds_grupo'];
        $polos_pk = $_REQUEST['polos_pk'];
        
        $grupos_modulos_pk = $_REQUEST['grupos_modulos_pk'];
        
        if($grupos_modulos_pk != "")
            $arrGruposModulosPk = json_decode ($grupos_modulos_pk, true);

        $grupo = $grupodao->carregarPorPk($pk);
        $grupo->setds_grupo($ds_grupo);
        $grupo->setpolos_pk($polos_pk);

        $pk = $grupodao->salvar($grupo);
                
        $grupodao->excluirGruposModulosPk($pk);
        
        if(count($arrGruposModulosPk) > 0){
            for($i = 0; $i < count($arrGruposModulosPk); $i++){
                $grupodao->adicionarGruposModulos($pk, $arrGruposModulosPk[$i]['modulos_pk'], $arrGruposModulosPk[$i]["ic_ins"], $arrGruposModulosPk[$i]["ic_upd"], $arrGruposModulosPk[$i]["ic_del"], $arrGruposModulosPk[$i]["ic_cons"]);
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
        
        $pk = $_REQUEST['pk'];
        $query = $grupodao->listarPorPk($pk);
        
        for($i = 0; $i < count($query); $i++){
            
            $mysql_data[] = array(
                "pk" => $query[$i]["pk"],
                "polos_pk" => $query[$i]["polos_pk"],
                "ds_grupo"=>$query[$i]['ds_grupo']
            );
        }

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $query = $grupodao->listar_grupos_permissa($ds_grupo,$polos_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        for($i = 0; $i < count($query); $i++){
            
            $mysql_data[] = array(
                "pk" => $query[$i]["pk"],
                "ds_grupo"=>$query[$i]['ds_grupo']
            );
        }
        
        break;
    }
    case 'listarGruposCadUsuario':{
        
        $query = $grupodao->listar_grupos_cad_usuario($ds_grupo,$polos_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        for($i = 0; $i < count($query); $i++){
            
            $mysql_data[] = array(
                "pk" => $query[$i]["pk"],
                "ds_grupo"=>$query[$i]['ds_grupo']
            );
        }
        
        break;
    }
    case 'listarDataTable':{
        
        $ds_grupo = $_REQUEST['ds_grupo'];
        $polos_pk = $_REQUEST['polos_pk'];
        $query = $grupodao->listar_por_ds_grupo($ds_grupo,$polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_grupo"=>$query[$i]['ds_grupo']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarPermissoesGrupo':{
        
        $pk = $_REQUEST['pk'];

        $result  = 'success';
        $message = 'query success';

        if($pk > 0){
            $query = $grupodao->listar_permissoes($pk);
        }
        else{
            $mysql_data = [];
        }
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_modulos_pk" => $query[$i]['modulos_pk'],
                    "t_ic_ins"=>$query[$i]['ic_ins'],
                    "t_ic_upd"=>$query[$i]['ic_upd'],
                    "t_ic_del"=>$query[$i]['ic_del'],
                    "t_ic_cons"=>$query[$i]['ic_cons']
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

$grupodao = null;

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
