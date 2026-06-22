<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/agenda_visita.dao.php";
include_once "../model/agenda_visita.class.php";

$token = $_REQUEST['token'];
$polos_pk = $_REQUEST['polos_pk'];
$ds_razao_social = $_REQUEST['ds_razao_social'];
$tipos_agendas_pk = $_REQUEST['tipos_agendas_pk'];
$ic_status_1 = $_REQUEST['ic_status_1'];
$ic_status_2 = $_REQUEST['ic_status_2'];
$ic_status_3 = $_REQUEST['ic_status_3'];
$dt_agenda_ini = $_REQUEST['dt_agenda_ini'];
$dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
$mailing_pk = $_REQUEST['mailing_pk'];
$responsavel_pk = $_REQUEST['responsavel_pk'];
$grupos_pk = $_REQUEST['grupos_pk'];


$dashboard = $_REQUEST['dashboard'];
$dt_ini_ag = $_REQUEST['dt_ini_ag'];
$dt_fim_ag = $_REQUEST['dt_fim_ag'];

$agenda_visitadao = new agenda_visitadao();
$agenda_visitadao->setToken($token);

$arrMes = array();
$arrMes[] = "Jan";
$arrMes[] = "Fev";
$arrMes[] = "Mar";
$arrMes[] = "Abr";
$arrMes[] = "Mai";
$arrMes[] = "Jun";
$arrMes[] = "Jul";
$arrMes[] = "Ago";
$arrMes[] = "Set";
$arrMes[] = "Out";
$arrMes[] = "Nov";
$arrMes[] = "Dez";

$arrClassificacao = array();
$arrClassificacao[0] = "Sem Classificação";
$arrClassificacao[1] = "Produtivo";
$arrClassificacao[2] = "Improdutivo";
$arrClassificacao[3] = "Reagendado";
$arrClassificacao[4] = "Cancelado";

$strResultado.="{".'"'."series".'"'.": [";
if($dashboard==1){
    
    $arrCampos = array();
    $data = date("d/m/Y");
    $query_data = $agenda_visitadao->PegarData($data,0);
    $hoje = $query_data[0]['data'];
    $dt_inicio = primeiroDiaMes($hoje);
    $dt_fim = ultimoDiaMes($hoje);
    
    
    if($dt_ini_ag!=""){
       $dt_inicio =  $dt_ini_ag ;
       $dt_fim = $dt_fim_ag ;
    }
    else{
        $dt_inicio = primeiroDiaMes($hoje);
        $dt_fim = ultimoDiaMes($hoje);
    }
    

    $query = $agenda_visitadao->RellistarGraficoDashboardSupervisorAgendadoPor($token,$responsavel_pk,$dt_inicio,$dt_fim);
    if(count($query)>0){
        for($i = 0; $i < count($query); $i++){
            $arrCampos['name'] = $query[$i]['ds_usuario_cadastro'];
            $arrCampos['data'] = intval($query[$i]['total_agendas'])==""?0:intval($query[$i]['total_agendas']);
            $arrCampos['color'] = $arrPaletaCores[$i];
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";
        }
    }
    else{
        $arrCampos['data'] = [];
        $strResultado.= html_entity_decode(json_encode($arrCampos)).",";
    }
    
    $arrCampos = array();
}
else{
    
    $arrCampos = array();

    $query = $agenda_visitadao->RellistarGraficoAgendadoPor($token,$polos_pk,$ds_razao_social,$tipos_agendas_pk,$ic_status_1,$ic_status_2,$ic_status_3,$dt_agenda_ini,$dt_agenda_fim,$mailing_pk,$responsavel_pk,$grupos_pk);
    for($i = 0; $i < count($query); $i++){
        $arrCampos['name'] = $query[$i]['ds_usuario_cadastro'];
        $arrCampos['data'] = intval($query[$i]['total_agendas'])==""?0:intval($query[$i]['total_agendas']);
        $arrCampos['color'] = $arrPaletaCores[$i];
        $strResultado.= html_entity_decode(json_encode($arrCampos)).",";
    }
    $arrCampos = array();
}

$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;