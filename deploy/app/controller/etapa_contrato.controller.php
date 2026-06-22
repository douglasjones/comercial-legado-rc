<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/etapa_contrato.dao.php";
include_once "../model/etapa_contrato.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_etapa = $arrRequest['ds_etapa'];
$operador_pk = $arrRequest['operador_pk'];
$ic_status = $arrRequest['ic_status'];
$polos_pk = $arrRequest['polos_pk'];
$operadores_pk = $arrRequest['operadores_pk'];
$n_ordem = $arrRequest['n_ordem'];


$etapa_contratodao = new etapa_contratodao();
$etapa_contratodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $etapa_contrato = $etapa_contratodao->carregarPorPk($pk);
        if($etapa_contrato->getpk()>0){
            
            $etapa_contratodao->excluir($etapa_contrato);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'etapa_contrato nao encontrado';
        }
        break;
    }
    case 'salvar':{
   
        $etapa_contrato = $etapa_contratodao->carregarPorPk($pk);
        $etapa_contrato->setds_etapa($ds_etapa);
        $etapa_contrato->setoperador_pk($operador_pk);
        $etapa_contrato->setic_status($ic_status);
        $etapa_contrato->setpolos_pk($polos_pk);
        $etapa_contrato->setoperadores_pk($operadores_pk);
        $etapa_contrato->setn_ordem($n_ordem);

        $pk = $etapa_contratodao->salvar($etapa_contrato);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $etapa_contratodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_etapa"=>$query[$i]['ds_etapa'],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "operadores_pk"=>$query[$i]['operadores_pk'],
                    "n_ordem"=>$query[$i]['n_ordem']
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
        $query = $etapa_contratodao->listar_por_ds_etapa($ds_etapa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_etapa"=>$query[$i]['ds_etapa'],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "operadores_pk"=>$query[$i]['operadores_pk'],
                    "n_ordem"=>$query[$i]['n_ordem']
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
        $query = $etapa_contratodao->listarPorPolo($polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "ds_segmento"=>$query[$i]['ds_segmento'],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "ds_operador"=>$query[$i]['ds_operador'],
                    "n_ordem"=>$query[$i]['n_ordem'],
                    "ds_etapa"=>$query[$i]['ds_etapa'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "ic_status_esteira"=>$query[$i]['ds_status'],                    
                    "polos_pk"=>$query[$i]['polos_pk'],
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
        $query = $etapa_contratodao->listar_por_ds_etapa($ds_etapa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_etapa"=>$query[$i]['ds_etapa'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_operadores_pk"=>$query[$i]['operadores_pk'],
                    "t_n_ordem"=>$query[$i]['n_ordem'],

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

$etapa_contratodao = null;

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
