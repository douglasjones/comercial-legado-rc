<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/lead.dao.php";
include_once "../model/lead.class.php";

$token = $_REQUEST['token'];
$responsavel_pk  = $_REQUEST['responsavel_pk'];

$leaddao = new leaddao();
$leaddao->setToken($token);

$arrCategories = array();
$arrCategories[1] = "Lead 25"; 
$arrCategories[2] = "Lead 50"; 
$arrCategories[3] = "Lead 75"; 
$arrCategories[4] = "Cliente"; 
$arrCategories[5] = "Contactado"; 
$arrCategories[6] = "Não Contactado"; 

$strResultado.="{".'"'."series".'"'.": [";
$total = 0;     



$arrCampos = array();

$arrCampos['name'][] = "Nao Contactado"; 
$query = $leaddao->listarCarteiraLead($token,$responsavel_pk,6);

if(count($query)==0){
    $arrCampos['data'][] = 0; 
}
else{
    for($l = 0; $l < count($query); $l++){
        
        $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']); 
        $total += intval($query[$l]['total_leads']);  
        
    }
}
$strResultado.= html_entity_decode(json_encode($arrCampos)).","; 




$arrCampos = array();
$arrCampos['name'][] = "Contactado"; 
$query = $leaddao->listarCarteiraLead($token,$responsavel_pk,5);

if(count($query)==0){
    $arrCampos['data'][] = 0; 
}
else{
    for($l = 0; $l < count($query); $l++){
        $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']); 
        $total += intval($query[$l]['total_leads']);    
    }
}
$strResultado.= html_entity_decode(json_encode($arrCampos)).","; 




$arrCampos = array();
$arrCampos['name'][] = "Lead 25"; 
$query = $leaddao->listarCarteiraLead($token,$responsavel_pk,1);

if(count($query)==0){
    $arrCampos['data'][] = 0; 
}
else{
    for($l = 0; $l < count($query); $l++){
        $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']); 
        $total += intval($query[$l]['total_leads']);    
    }
}
$strResultado.= html_entity_decode(json_encode($arrCampos)).","; 



$arrCampos = array();
$arrCampos['name'][] = "Lead 50"; 
$query = $leaddao->listarCarteiraLead($token,$responsavel_pk,2);

if(count($query)==0){
    $arrCampos['data'][] = 0; 
}
else{
    for($l = 0; $l < count($query); $l++){
        $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']); 
        $total += intval($query[$l]['total_leads']);    
    }
}
$strResultado.= html_entity_decode(json_encode($arrCampos)).",";            





$arrCampos = array();
$arrCampos['name'][] = "Lead 75"; 
$query = $leaddao->listarCarteiraLead($token,$responsavel_pk,3);

if(count($query)==0){
    $arrCampos['data'][] = 0; 
}
else{
    for($l = 0; $l < count($query); $l++){
        $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']); 
        $total += intval($query[$l]['total_leads']);    
    }
}
$strResultado.= html_entity_decode(json_encode($arrCampos)).",";  

$arrCampos = array();
$arrCampos['name'][] = "Lead 80"; 
$query = $leaddao->listarCarteiraLead($token,$responsavel_pk,8);

if(count($query)==0){
    $arrCampos['data'][] = 0; 
}
else{
    for($l = 0; $l < count($query); $l++){
        $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']); 
        $total += intval($query[$l]['total_leads']);    
    }
}
$strResultado.= html_entity_decode(json_encode($arrCampos)).",";  

$arrCampos = array();
$arrCampos['name'][] = "Lead 90"; 
$query = $leaddao->listarCarteiraLead($token,$responsavel_pk,9);

if(count($query)==0){
    $arrCampos['data'][] = 0; 
}
else{
    for($l = 0; $l < count($query); $l++){
        $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']); 
        $total += intval($query[$l]['total_leads']);    
    }
}
$strResultado.= html_entity_decode(json_encode($arrCampos)).","; 



$arrCampos = array();
$arrCampos['name'][] = "Cliente"; 
$query = $leaddao->listarCarteiraLead($token,$responsavel_pk,4);

if(count($query)==0){
    $arrCampos['data'][] = 0; 
}
else{
    for($l = 0; $l < count($query); $l++){
        $arrCampos['data'][] = intval($query[$l]['total_leads'])==""?0:intval($query[$l]['total_leads']); 
        $total += intval($query[$l]['total_leads']);    
    }
}
$strResultado.= html_entity_decode(json_encode($arrCampos)).",";                   
      


$arrCampos = array();
$arrCampos['categories'] = $total; 




        

$strResultado.= html_entity_decode(json_encode($arrCampos)).",";

$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;