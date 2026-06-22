<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/polo_modelo_proposta.dao.php";
require_once "../model/polo_modelo_proposta.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_modelo_pk = $arrRequest['tipo_modelo_pk'];
$tipo_envio_pk = $arrRequest['tipo_envio_pk'];
$ds_email = $arrRequest['ds_email'];
$html_modelo = $arrRequest['html_modelo'];
$polos_pk = $arrRequest['polos_pk'];
$operador_pk = $arrRequest['operador_pk'];
$status_pk = $arrRequest['status_pk'];


$polo_modelo_propostadao = new polo_modelo_propostadao();
$polo_modelo_propostadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $polo_modelo_proposta = $polo_modelo_propostadao->carregarPorPk($pk);
        if($polo_modelo_proposta->getpk()>0){
            
            $polo_modelo_propostadao->excluir($polo_modelo_proposta);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'polo_modelo_proposta nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $polo_modelo_proposta = $polo_modelo_propostadao->carregarPorPk($pk);
        $polo_modelo_proposta->settipo_modelo_pk($tipo_modelo_pk);
        $polo_modelo_proposta->settipo_envio_pk($tipo_envio_pk);
        $polo_modelo_proposta->setds_email($ds_email);
        $polo_modelo_proposta->sethtml_modelo($html_modelo);
        $polo_modelo_proposta->setpolos_pk($polos_pk);
        $polo_modelo_proposta->setoperador_pk($operador_pk);
        $polo_modelo_proposta->setstatus_pk($status_pk);

        
        $pk = $polo_modelo_propostadao->salvar($polo_modelo_proposta);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $polo_modelo_propostadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_modelo_pk"=>$query[$i]['tipo_modelo_pk'],
                    "tipo_envio_pk"=>$query[$i]['tipo_envio_pk'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "html_modelo"=>$query[$i]['html_modelo'],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "status_pk"=>$query[$i]['status_pk']
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
        $query = $polo_modelo_propostadao->listar_por_tipo_modelo_pk($tipo_modelo_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_modelo_pk"=>$query[$i]['tipo_modelo_pk'],
                    "tipo_envio_pk"=>$query[$i]['tipo_envio_pk'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "html_modelo"=>$query[$i]['html_modelo'],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "status_pk"=>$query[$i]['status_pk']
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
        $query = $polo_modelo_propostadao->listar_por_tipo_modelo_pk($tipo_modelo_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_tipo_modelo_pk"=>$query[$i]['tipo_modelo_pk'],
                    "t_tipo_envio_pk"=>$query[$i]['tipo_envio_pk'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_html_modelo"=>$query[$i]['html_modelo'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_status_pk"=>$query[$i]['status_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPorPolo':{
        $polos_pk = $_REQUEST['polos_pk'];
        
        if($polos_pk!=""){
            
            $resultado = "";
            $query = $polo_modelo_propostadao->listar_por_polo($polos_pk);

            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){

                    $mysql_data[] = array(
                        "t_pk" => $query[$i]["pk"],
                        "t_tipo_modelo_pk"=>$query[$i]['tipo_modelo_pk'],
                        "t_tipo_envio_pk"=>$query[$i]['tipo_envio_pk'],
                        "t_ds_email"=>$query[$i]['ds_email'],
                        "t_html_modelo"=>$query[$i]['html_modelo'],
                        "t_polos_pk"=>$query[$i]['polos_pk'],
                        "t_operador_pk"=>$query[$i]['operador_pk'],
                        "t_status_pk"=>$query[$i]['status_pk'],
                        "ds_status"=>$query[$i]['ds_status'],
                        "ds_operador"=>$query[$i]['ds_operador'],

                        "t_functions" => ""
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
    case 'listarPorOperador':{
        $operador_pk = $_REQUEST['operador_pk'];
        
        if($operador_pk!=""){
            
            $resultado = "";
            $query = $polo_modelo_propostadao->listar_por_operador($operador_pk);

            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){

                    $mysql_data[] = array(
                        "t_pk" => $query[$i]["pk"],
                        "t_tipo_modelo_pk"=>$query[$i]['tipo_modelo_pk'],
                        "t_tipo_envio_pk"=>$query[$i]['tipo_envio_pk'],
                        "t_ds_email"=>$query[$i]['ds_email'],
                        "t_html_modelo"=>$query[$i]['html_modelo'],
                        "t_polos_pk"=>$query[$i]['polos_pk'],
                        "t_operador_pk"=>$query[$i]['operador_pk'],
                        "t_status_pk"=>$query[$i]['status_pk'],
                        "ds_status"=>$query[$i]['ds_status'],
                        "ds_operador"=>$query[$i]['ds_operador'],

                        "t_functions" => ""
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
    default:{
        break;
    }
}

$polo_modelo_propostadao = null;

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
