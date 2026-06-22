<?php

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

include_once "../model/retorno.dao.php";
include_once "../model/retorno.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_ocorrencia = $arrRequest['ds_ocorrencia'];
$tipos_ocorrencias_pk = $arrRequest['tipos_ocorrencias_pk'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$dt_fechamento = $arrRequest['dt_fechamento'];
$leads_pk = $arrRequest['leads_pk'];
$ds_lead = $arrRequest['ds_lead'];
$ic_status = $arrRequest['ic_status'];
$usuario_cadastro_pk = $arrRequest['usuario_cadastro_pk'];
$dt_cadastro = $arrRequest['dt_cadastro'];
$dt_cadastro_fim = $arrRequest['dt_cadastro_fim'];
$motivo_sem_interesse_pk = $arrRequest['motivo_sem_interesse_pk'];
$ds_motivo_sem_interesse = $arrRequest['ds_motivo_sem_interesse'];

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token); 

$retornodao = new retornodao();
$retornodao->setToken($token); 

switch($job){

    case 'excluir':{
        /*if(!permissao("ocorrencia", "del", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }*/
        $resultdo = "";
        
        $ocorrencia = $ocorrenciadao->carregarPorPk($pk);
        if($ocorrencia->getpk()>0){
            
            $ocorrenciadao->excluirRetorno($ocorrencia->getpk());
            $ocorrenciadao->excluir($ocorrencia);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'ocorrencia nao encontrado';
        }
        break;
    }
    case 'salvar':{
        /*if($pk!=""){
            $ic_acao = "upd";
        }
        else{
            $ic_acao = "ins";
        }
        if(!permissao("ocorrencia", $ic_acao, $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }*/
        $ocorrencia = $ocorrenciadao->carregarPorPk($pk);
        $ocorrencia->setds_ocorrencia($ds_ocorrencia);
        $ocorrencia->settipos_ocorrencias_pk($tipos_ocorrencias_pk);
        $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
        $ocorrencia->setdt_fechamento($dt_fechamento);
        $ocorrencia->setleads_pk($leads_pk);
        $ocorrencia->setmotivo_sem_interesse_pk($motivo_sem_interesse_pk);
        $ocorrencia->setds_motivo_sem_interesse($ds_motivo_sem_interesse);

        
        
        $pk = $ocorrenciadao->salvar($ocorrencia);
		
        if($pk!=""){
            $ocorrencias_pk = $pk;
        }
        else{
            $ocorrencias_pk = $ocorrencia->getpk();
        }
                
        $agenda_retorno_pk = $_REQUEST['agenda_retorno_pk'];
        $dt_retorno = $_REQUEST['dt_retorno'];
        $hr_retorno = $_REQUEST['hr_retorno'];
        $equipes_pk = $_REQUEST['equipes_pk'];
        $responsavel_pk = $_REQUEST['responsavel_pk'];
        $ds_retorno = $_REQUEST['ds_retorno'];
        $agenda_retorno = $_REQUEST['agenda_retorno'];
        $dt_termino_retorno = $_REQUEST['dt_termino_retorno'];
        $hr_termino_retorno = $_REQUEST['hr_termino_retorno'];
    
        //if($dt_termino_retorno==''){            
        $retorno = $retornodao->carregarPorPk($agenda_retorno_pk);            
        if($dt_retorno!=""){
            $retorno->setdt_retorno(DataYMD($dt_retorno)." ".$hr_retorno);
        }		

        $retorno->setequipes_pk($equipes_pk);
        $retorno->setresponsavel_pk($responsavel_pk);
        $retorno->setdt_termino_retorno($dt_termino_retorno);	           
        $retorno->setds_retorno($ds_retorno);
        $retorno->setocorrencias_pk($ocorrencias_pk);  

        $retornos_pk = $retornodao->salvar($retorno);
        //}
       
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        /*if(!permissao("ocorrencia", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }*/
        $resultado = "";
        $query = $ocorrenciadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento']
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
       /* if(!permissao("ocorrencia", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }*/
        $resultado = "";
        $query = $ocorrenciadao->listar_por_ds_ocorrencia($ds_ocorrencia);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'ListarMotivosSemInterre':{
        $motivo_sem_interesse_pk = $_REQUEST['pk'];
        $resultado = "";
        $query = $ocorrenciadao->listarMotivoSemInteresse($motivo_sem_interesse_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_motivo_sem_interesse"=>$query[$i]['ds_motivo_sem_interesse']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{ 
        /*if(!permissao("ocorrencia", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }*/
        $resultado = "";
        $query = $ocorrenciadao->listar_por_ds_ocorrencia($ds_lead,$tipos_ocorrencias_pk,$ic_status,$usuario_cadastro_pk,$dt_cadastro,$dt_cadastro_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],                    
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_ds_ocorrencia"=>$query[$i]['ds_ocorrencia'],
                    "t_nome_usuario_cadastro"=>$query[$i]['nome_usuario_cadastro'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_agendado_para"=>$query[$i]['nome_agendado_para'],
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_ds_retorno"=>$query[$i]['ds_retorno'],
                    "t_dt_fechamento_retorno"=>$query[$i]['dt_fechamento_retorno'],
                                        "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "t_ds_processo_etapa"=>$query[$i]['ds_processo_etapa'],
                    "t_ds_processo"=>$query[$i]['ds_processo'],
                             
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }   
        case 'listarDataTableGrid':{ 
            /*if(!permissao("ocorrencia", "cons", $token)){
                $result  = 'error';
                $message = 'Erro de validação';
                $mysql_data = [];

                break;
            }*/
        $polos_pk = $_REQUEST['polos_pk'];
        $resultado = "";
        $query = $ocorrenciadao->listar_por_ds_ocorrencia($ds_lead,$tipos_ocorrencias_pk,$ic_status,$usuario_cadastro_pk,$dt_cadastro,$dt_cadastro_fim,$polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],                    
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                    "t_ds_ocorrencia"=>wordwrap($query[$i]['ds_ocorrencia'], 30, "<br />\n"),
                    "t_nome_usuario_cadastro"=>$query[$i]['nome_usuario_cadastro'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_agendado_para"=>$query[$i]['nome_agendado_para'],
                    "t_dt_retorno"=>$query[$i]['dt_retorno'],
                    "t_ds_retorno"=>wordwrap($query[$i]['ds_retorno'], 30, "<br />\n"),
                    "t_dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],                    
                    "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                    "t_ds_processo_etapa"=>$query[$i]['ds_processo_etapa'],
                    "t_ds_processo"=>$query[$i]['ds_processo'],
                             
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    } 
    case 'listarOcorrenciaProcessoLead':{
       /* if(!permissao("lead", "cons", $token)){
            $result  = 'error';
            $message = 'Erro de validação';
            $mysql_data = [];

            break;
        }*/
        $leads_pk = $_REQUEST['leads_pk'];
        if($leads_pk!=""){
            $resultado = "";
            $query = $ocorrenciadao->listar_ocorrencia_processo_lead($leads_pk);

            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){

                    $mysql_data[] = array(

                        "t_pk" => $query[$i]["pk"],
                        "t_ds_lead"=>$query[$i]['ds_lead'],
                        "t_dt_cadastro"=>$query[$i]['dt_cadastro'],                    
                        "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                        "t_tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                        "t_ds_ocorrencia"=>wordwrap($query[$i]['ds_ocorrencia'], 30, "<br />\n"),
                        "t_nome_usuario_cadastro"=>$query[$i]['nome_usuario_cadastro'],
                        "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                        "t_agendado_para"=>$query[$i]['nome_agendado_para'],
                        "t_motivo_sem_interesse_pk"=>$query[$i]['motivo_sem_interesse_pk'],
                        "t_ds_motivo_sem_interesse"=>$query[$i]['ds_motivo_sem_interesse'],
                        "t_dt_retorno"=>$query[$i]['dt_retorno'],
                        "t_ds_retorno"=>wordwrap($query[$i]['ds_retorno'], 30, "<br />\n"),
                        "t_dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],                    
                        "t_ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                        "t_ds_processo_etapa"=>$query[$i]['ds_processo_etapa'],
                        "t_ds_processo"=>$query[$i]['ds_processo'],                    
                        "t_ds_ocorrencia_modal"=>$query[$i]['ds_ocorrencia'],                    

                        "t_functions" => ""
                    );
                }
            }
            else{
                $mysql_data = [];
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

$ocorrenciadao = null;

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
