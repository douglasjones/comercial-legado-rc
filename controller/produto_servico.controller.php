<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/produto_servico.dao.php";
include_once "../model/produto_servico.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_produto_servico = $arrRequest['ds_produto_servico'];
$polos_pk = $arrRequest['polos_pk'];
$tipo_produto_pk = $arrRequest['tipo_produto_pk'];
$book_pk = $arrRequest['book_pk'];
$vl_produto_servico = $arrRequest['vl_produto_servico'];
$operador_pk = $arrRequest['operador_pk'];
$ic_valor_aberto = $arrRequest['ic_valor_aberto'];
$ic_status = $arrRequest['ic_status'];

$produto_servicodao = new produto_servicodao();
$produto_servicodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $produto_servico = $produto_servicodao->carregarPorPk($pk);
        if($produto_servico->getpk()>0){
            
            $produto_servicodao->excluir($produto_servico);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'produto_servico nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $produto_servico = $produto_servicodao->carregarPorPk($pk);
        $produto_servico->setds_produto_servico($ds_produto_servico);
        $produto_servico->setpolos_pk($polos_pk);
        $produto_servico->settipo_produto_pk($tipo_produto_pk);
        $produto_servico->setbook_pk($book_pk);
        $produto_servico->setvl_produto_servico($vl_produto_servico);
        $produto_servico->setoperador_pk($operador_pk);
        $produto_servico->setic_valor_aberto($ic_valor_aberto);
        $produto_servico->setic_status($ic_status);

        
        $pk = $produto_servicodao->salvar($produto_servico);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $produto_servicodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "tipo_produto_pk"=>$query[$i]['tipo_produto_pk'],
                    "book_pk"=>$query[$i]['book_pk'],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "ic_valor_aberto"=>$query[$i]['ic_valor_aberto'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "vl_produto_servico"=>$query[$i]['vl_produto_servico']
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
    case 'listarOperadorPk':{
        $operador_pk = $_REQUEST['operador_pk'];
        $resultado = "";
        $query = $produto_servicodao->listarPorOperadorPk($operador_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "tipo_produto_pk"=>$query[$i]['tipo_produto_pk'],
                    "book_pk"=>$query[$i]['book_pk'],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "ic_valor_aberto"=>$query[$i]['ic_valor_aberto'],
                    "vl_produto_servico"=>$query[$i]['vl_produto_servico']
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
        $query = $produto_servicodao->listar_por_ds_produto_servico($ds_produto_servico);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "operador_pk" => $query[$i]["operador_pk"],
                    "ic_valor_aberto" => $query[$i]["ic_valor_aberto"],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listarTodosPorLeads':{
        $leads_pk = $_REQUEST['leads_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        $resultado = "";
        $query = $produto_servicodao->listar_por_leads_pk($leads_pk,$contratos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "operador_pk" => $query[$i]["operador_pk"],
                    "ic_valor_aberto" => $query[$i]["ic_valor_aberto"],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarQualificacaoColaboradores':{
        
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];

        $result  = 'success';
        $message = 'query success';

        if($colaboradores_pk > 0){
            $query = $produto_servicodao->listar_qualificacao_colaboradores($colaboradores_pk);
        }
        else{
            $mysql_data = [];
        }
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_produtos_servicos_pk" => $query[$i]['produtos_servicos_pk'],
                    "t_ic_possui_treinamento"=>$query[$i]['ic_possui_treinamento'],
                    "t_ic_possui_certificado"=>$query[$i]['ic_possui_certificado']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;        
        
    }
    case 'listarDataTable':{
        
        $operador_pk = $_REQUEST['operador_pk'];
        $resultado = "";
        $query = $produto_servicodao->listar_por_ds_produto_servico($ds_produto_servico,$polos_pk,$ic_status,$operador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_ic_valor_aberto"=>$query[$i]['ic_valor_aberto'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_operador"=>$query[$i]['ds_operador'],

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

$produto_servicodao = null;

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
