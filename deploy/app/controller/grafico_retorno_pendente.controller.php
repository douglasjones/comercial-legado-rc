<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/retorno.dao.php";
include_once "../model/retorno.class.php";
include_once "../model/usuario.dao.php";
include_once "../model/usuario.class.php";

$token = $_REQUEST['token'];
$membro_equipe_pk = $_REQUEST['membro_equipe_pk'];

$retornodao = new retornodao();
$retornodao->setToken($token);

$usuariodao = new usuariodao();
$usuariodao->setToken($token);





$strResultado.="{".'"'."series".'"'.": [";
$arrCampos['data'] = array();
$query_usuario = $usuariodao->listar_membro_equipe($membro_equipe_pk);

for($j = 0; $j < count($query_usuario); $j++){
    
    $query = $retornodao->listarGraficoRetornoPendente($token,$query_usuario[$j]['pk']);

    for($i = 0; $i < count($query); $i++){

        $arrCampos['name'] = $query_usuario[$j]['ds_usuario'];
        $arrCampos['data'] = intval($query[$i]['qtde_retorno'])==""?0:intval($query[$i]['qtde_retorno']); 
        $strResultado.= html_entity_decode(json_encode($arrCampos)).",";

    }
}


$strResultado.= html_entity_decode(json_encode($arrCampos)).",";
$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;