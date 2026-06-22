<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/processo.dao.php";
include_once "../model/processo.class.php";

$token = $_REQUEST['token'];
$polos_pk = $_REQUEST['polos_pk'];
$processodao = new processodao();
$processodao->setToken($token);


$query = $processodao->GraficolistarQuantidadePorClassificacao($token,$polos_pk);

$strResultado.="{".'"'."series".'"'.": [";

$arrCampos = array();

for($i = 0; $i < count($query); $i++){
    $arrCampos['name'] = $query[$i]['ds_classificacao'];
    $arrCampos['data'] = intval($query[$i]['qtde_processos'])==""?0:intval($query[$i]['qtde_processos']); 
    $strResultado.= html_entity_decode(json_encode($arrCampos)).",";
}

$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;
include_once "../legado/libs/desconectar.php";