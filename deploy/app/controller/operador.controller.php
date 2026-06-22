<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/operador.dao.php";
include_once "../model/operador.class.php";
include_once "../model/polo_operador.dao.php";
include_once "../model/polo_operador.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_operador = $arrRequest['ds_operador'];
$segmentos_pk = $arrRequest['segmentos_pk'];
$ic_status = $arrRequest['ic_status'];


$operadordao = new operadordao();
$operadordao->setToken($token); 

$polo_operadordao = new polo_operadordao();
$polo_operadordao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $operador = $operadordao->carregarPorPk($pk);
        if($operador->getpk()>0){
            
            $operadordao->excluirPolo($operador->getpk());
            $operadordao->excluir($operador);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'operador nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $operador = $operadordao->carregarPorPk($pk);
        $operador->setds_operador($ds_operador);
        $operador->setsegmentos_pk($segmentos_pk);
        $operador->setic_status($ic_status);

        
        $pk = $operadordao->salvar($operador);
        
        if($pk!=""){
            $operador_pk = $pk;
        }
        else{
            
            $operador_pk = $operador->getpk();
            
        }
       
        
        $polo = $polo_operadordao->carregarPorOperadorPk($operador_pk);
        $polo->setoperadores_pk($operador_pk);
        $polo->setic_status($ic_status);
        
        $polos_operador_pk = $polo_operadordao->salvarPolo($polo);
        $mysql_data[] = array(
                "pk" => $operador_pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $operadordao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_operador"=>$query[$i]['ds_operador'],
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
        $query = $operadordao->listar_por_ds_operador($ds_operador,$segmentos_pk,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_operador"=>$query[$i]['ds_operador'],
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
    case 'listarTodosPorPolo':{
        
        $resultado = "";
        $query = $operadordao->listar_por_polo();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_operador"=>$query[$i]['ds_operador'],
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
    case 'listarClassificacaoOPerador':{
        
        $resultado = "";
        
        $operadora_pk = $_REQUEST['operadoras_pk'];
        $ds_operador = $_REQUEST['ds_operador'];
        $query = $operadordao->listarClassificacaoOperador($operadora_pk,$ds_operador);
        
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_classificacao"=>$query[$i]['ds_classificacao'],
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
        $query = $operadordao->listar_por_ds_operador($ds_operador,$segmentos_pk,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_operador"=>$query[$i]['ds_operador'],
                    "t_ds_segmentos"=>$query[$i]['ds_segmento'],
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

$operadordao = null;

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
