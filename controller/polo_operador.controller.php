<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/polo_operador.dao.php";
include_once "../model/polo_operador.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$polos_pk = $arrRequest['polos_pk'];
$operadores_pk = $arrRequest['operador_pk'];
$ic_status = $arrRequest['ic_status_operador'];

$polo_operadordao = new polo_operadordao();
$polo_operadordao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $polo_operador = $polo_operadordao->carregarPorPk($pk);
        if($polo_operador->getpk()>0){
            
            $polo_operadordao->excluir($polo_operador);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'polo_operador nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $polo_operador = $polo_operadordao->carregarPorPk($pk);
        $polo_operador->setpolos_pk($polos_pk);
        $polo_operador->setoperadores_pk($operadores_pk);
        $polo_operador->setic_status($ic_status);

        
        $pk = $polo_operadordao->salvar($polo_operador);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $polo_operadordao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "operadores_pk"=>$query[$i]['operadores_pk'],
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
        $query = $polo_operadordao->listar_por_polos_pk($polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "operadores_pk"=>$query[$i]['operadores_pk'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorPolo':{
        
        $resultado = "";
        $query = $polo_operadordao->listar_por_polos_pk($polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "operador_pk"=>$query[$i]['operadores_pk'],
                    "ds_operador"=>$query[$i]['ds_operador'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "ds_segmento"=>$query[$i]['ds_segmento'],
                    "ic_status_operador"=>$query[$i]['ic_status'],
                    "ds_status"=>$query[$i]['ds_status']
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
        $query = $polo_operadordao->listar_por_polos_pk($polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_operadores_pk"=>$query[$i]['operadores_pk'],
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

$polo_operadordao = null;

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
