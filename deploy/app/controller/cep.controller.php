<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$ds_cep = $arrRequest['ds_cep'];



switch($job){ 
    case 'buscarCep':{
        
        $resultado = "";
       
        $query =  file_get_contents("http://www.gepros6.com.br/cep/controller/cep.controller.php?job=buscarCep&ds_cep=".$ds_cep);
        $json_str = json_decode($query, true);
        $itens = $json_str['data'];
        
        $result  = 'success';
        $message = 'query success';
        //$mysql_dados = 'ds_cidade=>'.$itens[0]['ds_cidade'].','.'ds_endereco=>'.$itens[0]["ds_endereco"].','.'ds_bairro=>'.$itens[0]["ds_bairro"].','.'ds_uf=>'.$itens[0]["ds_uf"];
        $mysql_data[] = array(
            "ds_cidade"=>$itens[0]['ds_cidade'],
            "ds_endereco"=>$itens[0]["ds_endereco"],
            "ds_bairro"=>$itens[0]["ds_bairro"],
            "ds_uf"=>$itens[0]["ds_uf"]
        );
			
        break;
    }
    default:{
        break;
    }
}

$dia_semanadao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data,
    //"mysql_dados"=>$mysql_dados
);

// Convert PHP array to JSON array
$json_data = html_entity_decode(json_encode($data));
echo $json_data;


?>
