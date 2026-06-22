<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/agenda_retorno.dao.php";
include_once "../model/agenda_retorno.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dt_retorno = $arrRequest['dt_retorno'];
$equipes_pk = $arrRequest['equipes_pk'];
$responsavel_pk = $arrRequest['responsavel_pk'];
$dt_termino_retorno = $arrRequest['dt_termino_retorno'];
$ds_retorno = $arrRequest['ds_retorno'];
$ocorrencias_pk	 = $arrRequest['ocorrencias_pk	'];


$agenda_retornodao = new agenda_retornodao();
$agenda_retornodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $agenda_retorno = $agenda_retornodao->carregarPorPk($pk);
        if($agenda_retorno->getpk()>0){
            
            $agenda_retornodao->excluir($agenda_retorno);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agenda_retorno nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $agenda_retorno = $agenda_retornodao->carregarPorPk($pk);
        $agenda_retorno->setdt_retorno($dt_retorno);
        $agenda_retorno->setequipes_pk($equipes_pk);
        $agenda_retorno->setresponsavel_pk($responsavel_pk);
        $agenda_retorno->setdt_termino_retorno($dt_termino_retorno);
        $agenda_retorno->setds_retorno($ds_retorno);
        $agenda_retorno->setocorrencias_pk($ocorrencias_pk);

        
        $pk = $agenda_retornodao->salvar($agenda_retorno);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $agenda_retornodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_retorno"=>$query[$i]['dt_retorno'],
                    "equipes_pk"=>$query[$i]['equipes_pk'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],
                    "ds_retorno"=>$query[$i]['ds_retorno'],
                    "ocorrencias_pk	"=>$query[$i]['ocorrencias_pk	']
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
        $query = $agenda_retornodao->listar_por_dt_retorno($dt_retorno);
        
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
                    "ocorrencias_pk	"=>$query[$i]['ocorrencias_pk	']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarAgendaRetornoData':{
        $dt_base = $_REQUEST['dt_base'];
        $dt_base_fim = $_REQUEST['dt_base_fim']; 
        $ocorrencias_pk = $_REQUEST['ocorrencias_pk'];
        $equipes_pk = $_REQUEST['equipes_pk'];
        $responsavel_pk = $_REQUEST['usuarios_pk'];
        
        $resultado = "";
        $query = $agenda_retornodao->listar_agenda_retorno($dt_base,$dt_base_fim,$ocorrencias_pk,$equipes_pk,$responsavel_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_hr_retorno"=>$query[$i]['hr_retorno'],
                    "t_equipes_pk"=>$query[$i]['equipes_pk'],
                    "t_ds_equipe"=>$query[$i]['ds_equipe'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_retorno"=>$query[$i]['ds_retrono'],
                    "t_ds_responsavel"=>$query[$i]['ds_usuario'],
                    "t_ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_dt_hr_retorno"=>$query[$i]['dt_hr_retorno'],
                    "t_dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk']
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
        $query = $agenda_retornodao->listar_por_dt_retorno($dt_retorno);
        
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
                    "t_ocorrencias_pk	"=>$query[$i]['ocorrencias_pk	'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    case 'listarData':{
        $dt_agenda = $_REQUEST['dt_agenda'];
        
        $resultado = "";
        $query = $agenda_retornodao->listar_data($dt_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "dia_semana" => $query[$i]["dia_semana"],

                    "t_functions" => ""
                );
            }
        }
        else{           
            $mysql_data = [];
        }		
        break;
    }   
    case 'listarAgendaRetornoData':{
      
        $dt_base = $_REQUEST['dt_base'];
        $dt_base_fim = $_REQUEST['dt_base_fim'];        
        $equipes_pk = $_REQUEST['equipes_pk'];
        $responsavel_pk = $_REQUEST['responsavel_pk'];
                
        $resultado = "";
        if($dt_base!=""){            
            $query = $agenda_retornodao->listar_agenda_retorno_data($dt_base,$dt_base_fim,$equipes_pk,$responsavel_pk);            
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],          
                    "t_leads_pk" => $query[$i]["leads_pk"],          
                    "t_hr_retorno"=>$query[$i]['hr_retorno'],
                    "t_hrRetorno_comparar"=>$query[$i]['hrRetorno_comparar'],                    
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_ds_equipe"=>$query[$i]['ds_equipe'],
                    "t_equipes_pk"=>$query[$i]['equipes_pk'],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],                    
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],
                    "t_ds_retorno"=>$query[$i]['ds_retorno'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],
                    "t_condominio"=>$query[$i]['condominio'],
                    
                    "t_ocorrencia_pk"=>$query[$i]['ocorrencia_pk'],                    
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "t_ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    
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

$agenda_retornodao = null;

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
