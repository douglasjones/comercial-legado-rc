<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/agenda_retorno.dao.php";
include_once "../model/agenda_retorno.class.php";

$token = $_REQUEST['token'];
$dt_base_ini = $_REQUEST['dt_base_ini'];
$dt_base_fim = $_REQUEST['dt_base_fim'];
$ocorrencia_pk = $_REQUEST['ocorrencia_pk'];
$equipes_pk = $_REQUEST['equipes_pk'];
$usuarios_pk = $_REQUEST['usuarios_pk'];

$agenda_retornodao = new agenda_retornodao();
$agenda_retornodao->setToken($token); 


$query = $agenda_retornodao->listar_agenda_retorno($dt_base_ini,$dt_base_fim,$ocorrencias_pk,$equipes_pk,$usuarios_pk);


$query_data = $agenda_retornodao->listar_hoje();


$hoje = $query_data[0]['data'];
$concluidas = 0;
$atrasados = 0;
$sem_classificacao = 0;
if(count($query) > 0){
    for($i = 0; $i < count($query); $i++){
        if($hoje > $query[$i]['dt_retorno']){
            if($query[$i]['dt_termino_retorno']!=null){
               //$concluidas ++;
            }
            else{
                $atrasados++;
            }

        }
        
        if($query[$i]['dt_termino_retorno']!=null){
            $concluidas ++;
        }
    }
}


$strResultado.="{".'"'."series".'"'.": [";

$arrCampos = array();



$arrCampos['name'] = "Retornos Concluidos";
$arrCampos['data'] = intval($concluidas)==""?0:intval($concluidas); 
$strResultado.= html_entity_decode(json_encode($arrCampos)).",";

$arrCampos = array();

$arrCampos['name'] = "Atrasados";
$arrCampos['data'] = intval($atrasados)==""?0:intval($atrasados); 
$strResultado.= html_entity_decode(json_encode($arrCampos)).",";
$arrCampos = array();


$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;
