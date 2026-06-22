<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/lead_responsavel.dao.php";
include_once "../model/lead_responsavel.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$usuarios_pk = $arrRequest['usuarios_pk'];
$grupos_pk = $arrRequest['grupos_pk'];
$leads_pk = $arrRequest['leads_pk'];
$contas_pk = $arrRequest['contas_pk'];
$polos_pk = $arrRequest['polos_pk'];


$lead_responsaveldao = new lead_responsaveldao();
$lead_responsaveldao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $lead_responsavel = $lead_responsaveldao->carregarPorPk($pk);
        if($lead_responsavel->getpk()>0){
            
            $lead_responsaveldao->excluir($lead_responsavel);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'lead_responsavel nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $lead_responsavel = $lead_responsaveldao->carregarPorPk($pk);
        $lead_responsavel->setusuarios_pk($usuarios_pk);
        $lead_responsavel->setgrupos_pk($grupos_pk);
        $lead_responsavel->setleads_pk($leads_pk);
        $lead_responsavel->setcontas_pk($contas_pk);
        $lead_responsavel->setpolos_pk($polos_pk);

        
        $pk = $lead_responsaveldao->salvar($lead_responsavel);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $lead_responsaveldao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "usuarios_pk"=>$query[$i]['usuarios_pk'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "polos_pk"=>$query[$i]['polos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarPorLead':{
        
        if($_REQUEST['leads_pk']==""){
            $leads_pk = 0;
        }
        else{
            $leads_pk = $_REQUEST['leads_pk'];
        }
        $resultado = "";
        $query = $lead_responsaveldao->listarPorLeadsPk($leads_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "usuarios_pk"=>$query[$i]['usuarios_pk'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "ds_grupo"=>$query[$i]['ds_grupo'],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "polos_pk"=>$query[$i]['polos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }
    case 'listarResponsavelLeadComercial':{
        $leads_pk = $_REQUEST['leads_pk'];
        $ds_grupo = $_REQUEST['ds_grupo'];
        $resultado = "";
        $query = $lead_responsaveldao->listarPorLeadsPkEDsGrupo($leads_pk,$ds_grupo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_senha"=>$query[$i]['ds_senha'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $lead_responsaveldao->listar_por_usuarios_pk($usuarios_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "usuarios_pk"=>$query[$i]['usuarios_pk'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "polos_pk"=>$query[$i]['polos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $lead_responsaveldao->listar_por_usuarios_pk($usuarios_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_usuarios_pk"=>$query[$i]['usuarios_pk'],
                    "t_grupos_pk"=>$query[$i]['grupos_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contas_pk"=>$query[$i]['contas_pk'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    default:{
        break;
    }
}

$lead_responsaveldao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
