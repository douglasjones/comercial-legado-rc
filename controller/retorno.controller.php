<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/retorno.dao.php";
include_once "../model/retorno.class.php";
include_once "../model/usuario.dao.php";
include_once "../model/usuario.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dt_retorno = $arrRequest['dt_retorno'];
$hr_retorno = $arrRequest['hr_retorno'];
$equipes_pk = $arrRequest['equipes_pk'];
$responsavel_pk = $arrRequest['responsavel_pk'];
$dt_termino_retorno = $arrRequest['dt_termino_retorno'];
$ds_retorno = $arrRequest['ds_retorno'];
$ocorrencias_pk = $arrRequest['ocorrencias_pk'];


$retornodao = new retornodao();
$retornodao->setToken($token); 

$usuariodao = new usuariodao();
$usuariodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $retorno = $retornodao->carregarPorPk($pk);
        if($retorno->getpk()>0){
            
            $retornodao->excluir($retorno);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'retorno nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $retorno = $retornodao->carregarPorPk($pk); 
        
        
        if($dt_retorno!=""){
            $retorno->setdt_retorno(str_replace(' ', "", DataYMD($dt_retorno))." ".$hr_retorno);
        }		

        $retorno->setequipes_pk($equipes_pk);
        $retorno->setresponsavel_pk($responsavel_pk);
        $retorno->setdt_termino_retorno($dt_termino_retorno);	           
        $retorno->setds_retorno($ds_retorno);
        $retorno->setocorrencias_pk($ocorrencias_pk);  

        $retornos_pk = $retornodao->salvar($retorno);
        
        $mysql_data[] = array(
                "pk" => $retornos_pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $retornodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_retorno"=>$query[$i]['dt_retorno'],
                    "equipes_pk"=>$query[$i]['equipes_pk'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],
                    "ds_retorno"=>$query[$i]['ds_retorno'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk']
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
    case 'listarRetornoEmAberto':{
        $resultado = "";
        $query = $retornodao->listarRetornoEmAberto();
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "dt_retorno"=>$query[$i]['dt_retorno'],
                    "ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "ds_retorno"=>$query[$i]['ds_retorno'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    
                    
                 
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
    case 'listarRetornoAtrasado':{
        
        $resultado = "";
        $query = $retornodao->listarRetornoAtrasado($token);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "total_atraso" => $query[$i]["total_atraso"]
                    
                    
                 
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
    
    case 'listarOcorrenciasPk':{
        
        $ocorrencias_pk = $_REQUEST['ocorrencias_pk'];
        $pk = $_REQUEST['pk'];
        $resultado = "";
        
        $query = $retornodao->listarPorOcorrenciasPk($ocorrencias_pk,$pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_retorno"=>$query[$i]['dt_retorno'],
                    "hr_retorno"=>$query[$i]['hr_retorno'],
                    "dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],
                    "hr_termino_retorno"=>$query[$i]['hr_termino_retorno'],
                    "equipes_pk"=>$query[$i]['equipes_pk'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],
                    "ds_retorno"=>$query[$i]['ds_retorno'],
                    "tipo_ocorrencia_pk"=>$query[$i]['tipo_ocorrencia_pk'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk']
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
    case 'listarTodos':{
        
        $resultado = "";
        $query = $retornodao->listar_por_dt_retorno($dt_retorno);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_retorno"=>$query[$i]['dt_retorno'],
                    "equipes_pk"=>$query[$i]['equipes_pk'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],
                    "ds_retorno"=>$query[$i]['ds_retorno'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }    
    case 'listarDataTablePopup':{        
                
        $resultado = "";
        $query = $retornodao->listar_retorno_aberto_Popup();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(  
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_ds_agendado_para"=>$query[$i]['ds_agendado_para'],
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_ds_retorno"=>$query[$i]['ds_retorno'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_qtde_retorno"=>count($query),

                    "t_functions" => ""
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
        $query = $retornodao->listar_por_dt_retorno($dt_retorno);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_equipes_pk"=>$query[$i]['equipes_pk'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],
                    "t_ds_retorno"=>$query[$i]['ds_retorno'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    case 'listarRerornoPopUp':{
                        
        $resultado = "";
        $query = $retornodao->listar_qtde_retorno_aberto();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_qtde_retorno" => $query[$i]["qtde_retorno"],
      
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    case 'listarQtdeRetornoPendente':{
                        
        
        
        $membro_equipe_pk = $_REQUEST['membro_equipe_pk'];
        
        
        
        $query_usuario = $usuariodao->listar_membro_equipe($membro_equipe_pk);
        
        $resultado = "";
        $result  = 'success';
        $message = 'query success';

        if(count($query_usuario) > 0){
            for($i = 0; $i < count($query_usuario); $i++){
                
                $query24 = $retornodao->listarQtdeRetornoPendente24($query_usuario[$i]['pk']);
                $query48 = $retornodao->listarQtdeRetornoPendente48();
                $query72 = $retornodao->listarQtdeRetornoPendente72();
                
                
                $mysql_data[] = array(
                    "ds_usuario" => $query_usuario[$i]['ds_usuario'],
                    "qtde24" => $query24[0]['qtde_retorno'],
                    "qtde48" => $query48[0]['qtde_retorno'],
                    "qtde72" => $query72[0]['qtde_retorno']
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

$retornodao = null;

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
