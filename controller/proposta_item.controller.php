<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/proposta_item.dao.php";
include_once "../model/proposta_item.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];

$n_qtde = $arrRequest['n_qtde'];
$vl_unit = $arrRequest['vl_unit'];
$vl_total = $arrRequest['vl_total'];
$propostas_pk = $arrRequest['propostas_pk'];
$produtos_servicos_pk = $arrRequest['produtos_servicos_pk'];



$proposta_itemdao = new proposta_itemdao();
$proposta_itemdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $proposta_item = $proposta_itemdao->carregarPorPk($pk);
        if($proposta_item->getpk()>0){
            
            $proposta_itemdao->excluir($proposta_item);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'proposta_item nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $proposta_item = $proposta_itemdao->carregarPorPk($pk);
        $proposta_item->setn_qtde($n_qtde);
        $proposta_item->setvl_unit($vl_unit);
        $proposta_item->setvl_total($vl_total);
        $proposta_item->setpropostas_pk($propostas_pk);
        $proposta_item->setprodutos_servicos_pk($produtos_servicos_pk);

        
        $pk = $proposta_itemdao->salvar($proposta_item);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $proposta_itemdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "n_qtde"=>$query[$i]['n_qtde'],
                    "vl_unit"=>$query[$i]['vl_unit'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "propostas_pk"=>$query[$i]['propostas_pk'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk']
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
        $query = $proposta_itemdao->listar_por_n_qtde($n_qtde);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "n_qtde"=>$query[$i]['n_qtde'],
                    "vl_unit"=>$query[$i]['vl_unit'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "propostas_pk"=>$query[$i]['propostas_pk'],
                    "produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk']
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
        $query = $proposta_itemdao->listar_por_n_qtde($n_qtde);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_n_qtde"=>$query[$i]['n_qtde'],
                    "t_vl_unit"=>$query[$i]['vl_unit'],
                    "t_vl_total"=>$query[$i]['vl_total'],
                    "t_propostas_pk"=>$query[$i]['propostas_pk'],
                    "t_produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }  
    case 'listarPropostaItem':{   

        $resultado = "";
        if($propostas_pk!=""){
            $query = $proposta_itemdao->listarPropostaItem($propostas_pk);
        }
        else{
            $mysql_data = [];
        }
                
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_n_qtde"=>$query[$i]['n_qtde'],
                    "t_vl_unit"=>number_format($query[$i]['vl_unit'],2,',','.'),
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),
                    "t_propostas_pk"=>$query[$i]['propostas_pk'],
                    "t_produtos_servicos_pk"=>$query[$i]['produtos_servicos_pk'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],

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


$proposta_itemdao = null;

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
