<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/lead_operador.dao.php";
include_once "../model/lead_operador.class.php";

include_once "../model/operador.dao.php";
include_once "../model/operador.class.php";

include_once "../model/agenda_visita.dao.php";
include_once "../model/agenda_visita.class.php";

$token = $_REQUEST['token'];
$membro_equipes_pk  = $_REQUEST['membro_equipes_pk'];
$dt_ini_of  = $_REQUEST['dt_ini_of'];
$dt_fim_of  = $_REQUEST['dt_fim_of'];

$lead_operadordao = new lead_operadordao();
$lead_operadordao->setToken($token);

$operadordao = new operadordao();
$operadordao->setToken($token);

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





$strResultado.="{".'"'."series".'"'.": [";
$query_operador = $operadordao->listarTodos();

if(count($query_operador) > 0){
    
    for($j=0; $j < count($query_operador);$j++){
        
        if($query_operador[$j]['ic_status']==1){
            
            $arrCampos = array();
       
            $arrCampos['name'] = $query_operador[$j]['ds_operador'];
            //for($i = 2; $i >= 0;$i--){
                $data = date("d/m/Y");
                $query_data = $agenda_visitadao->PegarData($data,0);
                $hoje = $query_data[0]['data'];
                
                
                if($dt_ini_of==""){
                    $dt_inicio = primeiroDiaMes($hoje);
                    $dt_fim = ultimoDiaMes($hoje);
                }
                else{
                    $dt_inicio = $dt_ini_of;
                    $dt_fim = $dt_fim_of;
                }
                
                
                
                
                
                $mes = (int) pegarMes($hoje);

                    $query = $lead_operadordao->listar_grafico_supervisor($token,$membro_equipes_pk,$dt_inicio,$dt_fim,$query_operador[$j]['pk']);

                    if(count($query)==0){
                        $arrCampos['data'][] = 0; 
                    }
                    else{
                        for($l = 0; $l < count($query); $l++){
                            $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']);
                            $arrCampos['categories'][] = $query[$l]['ds_usuario']; 
                        }
                    }

                    
            //}
            $strResultado.= html_entity_decode(json_encode($arrCampos)).",";
        
            
        }
    }
}

$arrCampos = array();

for($i = 2; $i >= 0;$i--){
    
}

$strResultado.= html_entity_decode(json_encode($arrCampos)).",";




$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;