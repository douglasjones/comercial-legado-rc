<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";

header('Content-Type: application/json; charset=utf-8');

function fetchNaoPerturbeData($telefone){
    $url = "http://naoperturbe.gepros6.com.br/naoperturbe/controller/naoperturbe.controller.php?job=naoPerturbe&telefone=" . $telefone;
    $context = stream_context_create([
        "http" => [
            "timeout" => 3
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response === false || $response === "") {
        return ["descricao" => null, "dt_cadastro" => null];
    }

    $json = json_decode($response, true);
    if (!is_array($json) || !isset($json["data"][0])) {
        return ["descricao" => null, "dt_cadastro" => null];
    }

    return [
        "descricao" => isset($json["data"][0]["descricao"]) ? $json["data"][0]["descricao"] : null,
        "dt_cadastro" => isset($json["data"][0]["dt_cadastro"]) ? $json["data"][0]["dt_cadastro"] : null
    ];
}

$arrRequest = tratar_request();

$job = isset($arrRequest['job']) ? $arrRequest['job'] : "";
$token = isset($arrRequest['token']) ? $arrRequest['token'] : "";
$telefone = isset($arrRequest['telefone']) ? $arrRequest['telefone'] : "";

$result = "error";
$message = "";
$mysql_data = [];

if(strlen($telefone) > 10){
    $ds_telefone = trim(substr($telefone, 4, 14));
}
else{
    $ds_telefone = $telefone;
}

switch($job){ 
    case 'naoPerturbe':{
        
        $resultado = "";
        $itens = fetchNaoPerturbeData($ds_telefone);
        $result  = 'success';
        $message = 'query success';
        $mysql_data[] = array(
            "descricao"=>$itens['descricao'],
            "dt_cadastro"=>$itens['dt_cadastro']
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
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
if ($json_data === false) {
    error_log("JSON encode error in naoperturbe.controller.php: " . json_last_error_msg());
    $json_data = json_encode([
        "result" => "error",
        "message" => "json_encode_failed",
        "data" => []
    ]);
}
echo $json_data;


?>
