<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/agenda_visita.dao.php";
include_once "../model/agenda_visita.class.php";
include_once "../model/lead.dao.php";
include_once "../model/lead.class.php";
include_once "../model/usuario.dao.php";
include_once "../model/usuario.class.php";
include_once "../model/lead_operador.dao.php";
include_once "../model/lead_operador.class.php";
include_once "../model/retorno.dao.php";
include_once "../model/retorno.class.php";
include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";
include_once "../model/processo.dao.php";
include_once "../model/processo.class.php";
include_once "../model/proposta.dao.php";
include_once "../model/proposta.class.php";

$token = $_REQUEST['token'];
$responsavel_pk = $_REQUEST['responsavel_pk'];


$acao = $_REQUEST['acao'];

$agenda_visitadao = new agenda_visitadao();
$agenda_visitadao->setToken($token);

$leaddao = new leaddao();
$leaddao->setToken($token);

$usuariodao = new usuariodao();
$usuariodao->setToken($token);

$lead_operadordao = new lead_operadordao();
$lead_operadordao->setToken($token);

$retornodao = new retornodao();
$retornodao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token);

$processodao = new processodao();
$processodao->setToken($token);

$propostadao = new propostadao();
$propostadao->setToken($token);



$strResultado.="{".'"'."series".'"'.": [";
//QTDE LEAD
if($acao==1){
    
    
    $arrCampos = array();
    $query_usuario = $usuariodao->listar_membro_equipe($responsavel_pk);

    for($j = 0; $j < count($query_usuario); $j++){

        $query = $leaddao->listarQtdeLeadCadastradoSupervisor($token,$query_usuario[$j]['pk']);

        for($i = 0; $i < count($query); $i++){

            $arrCampos['name'] = $query_usuario[$j]['ds_usuario'];
            $arrCampos['data'] = intval($query[$i]['registros'])==""?0:intval($query[$i]['registros']);
            $arrCampos['color'] = $arrPaletaCores[$j];
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";

        }
    }
    
    
    $arrCampos = array();    
}
//OPORTUNIDADE FUTURAS
if($acao==2){
    
    
    $arrCampos = array();
    $query_usuario = $usuariodao->listar_membro_equipe($responsavel_pk);

    for($j = 0; $j < count($query_usuario); $j++){

        $query = $lead_operadordao->listarQtdeOportunidadeSupervisor($token,$query_usuario[$j]['pk']);

        for($i = 0; $i < count($query); $i++){

            $arrCampos['name'] = $query_usuario[$j]['ds_usuario'];
            $arrCampos['data'] = intval($query[$i]['registros'])==""?0:intval($query[$i]['registros']);
            $arrCampos['color'] = $arrPaletaCores[$j];
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";

        }
    }
    
    
    $arrCampos = array();    
}
//RETORNOS FINALIZADOS
if($acao==3){
    
    
    $arrCampos = array();
    $query_usuario = $usuariodao->listar_membro_equipe($responsavel_pk);

    for($j = 0; $j < count($query_usuario); $j++){

        $query = $retornodao->listarQtdeRetornosConcluidos($token,$query_usuario[$j]['pk']);

        for($i = 0; $i < count($query); $i++){

            $arrCampos['name'] = $query_usuario[$j]['ds_usuario'];
            $arrCampos['data'] = intval($query[$i]['registros'])==""?0:intval($query[$i]['registros']);
            $arrCampos['color'] = $arrPaletaCores[$j];
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";

        }
    }
    
    
    $arrCampos = array();    
}
//OCORRENCIA
if($acao==4){
    
    
    $arrCampos = array();
    $query_usuario = $usuariodao->listar_membro_equipe($responsavel_pk);

    for($j = 0; $j < count($query_usuario); $j++){

        $query = $ocorrenciadao->listarqtdeOcorrenciaRegistrada($token,$query_usuario[$j]['pk']);

        for($i = 0; $i < count($query); $i++){

            $arrCampos['name'] = $query_usuario[$j]['ds_usuario'];
            $arrCampos['data'] = intval($query[$i]['registros'])==""?0:intval($query[$i]['registros']);
            $arrCampos['color'] = $arrPaletaCores[$j];
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";

        }
    }
    
    
    $arrCampos = array();    
}
//PROCESSO
if($acao==5){
    
    
    $arrCampos = array();
    $query_usuario = $usuariodao->listar_membro_equipe($responsavel_pk);

    for($j = 0; $j < count($query_usuario); $j++){

        $query = $processodao->listarQuantidadeProcesso($token,$query_usuario[$j]['pk']);

        for($i = 0; $i < count($query); $i++){

            $arrCampos['name'] = $query_usuario[$j]['ds_usuario'];
            $arrCampos['data'] = intval($query[$i]['registros'])==""?0:intval($query[$i]['registros']);
            $arrCampos['color'] = $arrPaletaCores[$j];
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";

        }
    }
    
    
    $arrCampos = array();    
}

if($acao==6){
    
    
    $arrCampos = array();
    $query_usuario = $usuariodao->listar_membro_equipe($responsavel_pk);

    for($j = 0; $j < count($query_usuario); $j++){

        $query = $agenda_visitadao->listarQtdeVisita($token,$query_usuario[$j]['pk']);

        for($i = 0; $i < count($query); $i++){

            $arrCampos['name'] = $query_usuario[$j]['ds_usuario'];
            $arrCampos['data'] = intval($query[$i]['registros'])==""?0:intval($query[$i]['registros']);
            $arrCampos['color'] = $arrPaletaCores[$j];
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";

        }
    }
    
    
    $arrCampos = array();    
}

if($acao==7){
    
    
    $arrCampos = array();
    $query_usuario = $usuariodao->listar_membro_equipe($responsavel_pk);

    for($j = 0; $j < count($query_usuario); $j++){

        $query = $propostadao->listarQtdeProposta($token,$query_usuario[$j]['pk']);

        for($i = 0; $i < count($query); $i++){

            $arrCampos['name'] = $query_usuario[$j]['ds_usuario'];
            $arrCampos['data'] = intval($query[$i]['registros'])==""?0:intval($query[$i]['registros']);
            $arrCampos['color'] = $arrPaletaCores[$j];
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";

        }
    }
    
    
    $arrCampos = array();    
}

$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;