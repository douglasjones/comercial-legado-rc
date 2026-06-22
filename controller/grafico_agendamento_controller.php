<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/agenda_visita.dao.php";
include_once "../model/agenda_visita.class.php";

$token = $_REQUEST['token'];
$polos_pk = $_REQUEST['polos_pk'];
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

$arrCampos = array();
$arrCampos['name'] = 'Sem Classificação';
for($i = 2; $i >= 0;$i--){
    $data = date("d/m/Y");
    $query_data = $agenda_visitadao->PegarData($data,$i);
    $hoje = $query_data[0]['data'];
    $dt_inicio = primeiroDiaMes($hoje);
    $dt_fim = ultimoDiaMes($hoje);
    $mes = (int) pegarMes($hoje);
    
    
        $query = $agenda_visitadao->listarGraficoAgendamento($token,$dt_inicio,$dt_fim,0,$polos_pk);
        
        if(count($query)==0){
            $arrCampos['data'][] = 0; 
        }
        else{
            for($j = 0; $j < count($query); $j++){
                $arrCampos['data'][] = intval($query[$j]['total_agendas'])==""?0:intval($query[$j]['total_agendas']); 
            }
        }
}

$strResultado.= html_entity_decode(json_encode($arrCampos)).",";

//zerando varaivel
$arrCampos['data'] = array();
$arrCampos['name'] = 'Produtivo';
for($i = 2; $i >= 0;$i--){
    $data = date("d/m/Y");
    $query_data = $agenda_visitadao->PegarData($data,$i);
    $hoje = $query_data[0]['data'];
    $dt_inicio = primeiroDiaMes($hoje);
    $dt_fim = ultimoDiaMes($hoje);
    $mes = (int) pegarMes($hoje);
    
    
        $query = $agenda_visitadao->listarGraficoAgendamento($token,$dt_inicio,$dt_fim,1,$polos_pk);
        
        if(count($query)==0){
            $arrCampos['data'][] = 0; 
        }
        else{
            for($j = 0; $j < count($query); $j++){
                $arrCampos['data'][] = intval($query[$j]['total_agendas'])==""?0:intval($query[$j]['total_agendas']); 
            }
        }
}

$strResultado.= html_entity_decode(json_encode($arrCampos)).",";

//zerando varaivel
$arrCampos['data'] = array();
$arrCampos['name'] = 'Improdutivo';
for($i = 2; $i >= 0;$i--){
    $data = date("d/m/Y");
    $query_data = $agenda_visitadao->PegarData($data,$i);
    $hoje = $query_data[0]['data'];
    $dt_inicio = primeiroDiaMes($hoje);
    $dt_fim = ultimoDiaMes($hoje);
    $mes = (int) pegarMes($hoje);
    
    
        $query = $agenda_visitadao->listarGraficoAgendamento($token,$dt_inicio,$dt_fim,2,$polos_pk);
        
        if(count($query)==0){
            $arrCampos['data'][] = 0; 
        }
        else{
            for($j = 0; $j < count($query); $j++){
                $arrCampos['data'][] = intval($query[$j]['total_agendas'])==""?0:intval($query[$j]['total_agendas']); 
            }
        }
}

$strResultado.= html_entity_decode(json_encode($arrCampos)).",";

//zerando varaivel
$arrCampos['data'] = array();
$arrCampos['name'] = 'Reagendado';
for($i = 2; $i >= 0;$i--){
    $data = date("d/m/Y");
    $query_data = $agenda_visitadao->PegarData($data,$i);
    $hoje = $query_data[0]['data'];
    $dt_inicio = primeiroDiaMes($hoje);
    $dt_fim = ultimoDiaMes($hoje);
    $mes = (int) pegarMes($hoje);
    
    
        $query = $agenda_visitadao->listarGraficoAgendamento($token,$dt_inicio,$dt_fim,3,$polos_pk);
        
        if(count($query)==0){
            $arrCampos['data'][] = 0; 
        }
        else{
            for($j = 0; $j < count($query); $j++){
                $arrCampos['data'][] = intval($query[$j]['total_agendas'])==""?0:intval($query[$j]['total_agendas']); 
            }
        }
}

$strResultado.= html_entity_decode(json_encode($arrCampos)).",";

//zerando varaivel
$arrCampos['data'] = array();
$arrCampos['name'] = 'Cancelado';
for($i = 2; $i >= 0;$i--){
    $data = date("d/m/Y");
    $query_data = $agenda_visitadao->PegarData($data,$i);
    $hoje = $query_data[0]['data'];
    $dt_inicio = primeiroDiaMes($hoje);
    $dt_fim = ultimoDiaMes($hoje);
    $mes = (int) pegarMes($hoje);
    
    
        $query = $agenda_visitadao->listarGraficoAgendamento($token,$dt_inicio,$dt_fim,4,$polos_pk);
        
        if(count($query)==0){
            $arrCampos['data'][] = 0; 
        }
        else{
            for($j = 0; $j < count($query); $j++){
                $arrCampos['data'][] = intval($query[$j]['total_agendas'])==""?0:intval($query[$j]['total_agendas']); 
            }
        }
}

$strResultado.= html_entity_decode(json_encode($arrCampos)).",";

$arrCampos = array();

for($i = 2; $i >= 0;$i--){
    $data = date("d/m/Y");
    $query_data = $agenda_visitadao->PegarData($data,$i);
    $hoje = $query_data[0]['data'];
    $dt_inicio = primeiroDiaMes($hoje);
    $dt_fim = ultimoDiaMes($hoje);
    $mes = (int) pegarMes($hoje);
    $arrCampos['categories'][] = $arrMes[$mes -1]; 
}

$strResultado.= html_entity_decode(json_encode($arrCampos)).",";




$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;
include_once "../legado/libs/desconectar.php";