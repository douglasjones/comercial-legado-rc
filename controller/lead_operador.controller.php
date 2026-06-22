<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/lead_operador.dao.php";
include_once "../model/lead_operador.class.php";

include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

include_once "../model/retorno.dao.php";
include_once "../model/retorno.class.php";

include_once "../model/tipo_ocorrencia.dao.php";
include_once "../model/tipo_ocorrencia.class.php";

include_once "../model/operador.dao.php";
include_once "../model/operador.class.php";

include_once "../model/agenda_visita.dao.php";
include_once "../model/agenda_visita.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$operador_pk = $arrRequest['operador_pk'];
$leads_pk = $arrRequest['leads_pk'];
$ic_cliente = $arrRequest['ic_cliente'];
$ic_base = $arrRequest['ic_base'];
$dt_ativacao = $arrRequest['dt_ativacao'];
$dt_vencimento = $arrRequest['dt_vencimento'];
$ds_custo_atual = $arrRequest['ds_custo_atual'];
$ds_qtde_voz = $arrRequest['ds_qtde_voz'];
$ds_qtde_dados = $arrRequest['ds_qtde_dados'];
$ic_status = $arrRequest['ic_status'];
$classificacao_pk = $arrRequest['classificacao_pk'];
$tempo_contrato_pk = $arrRequest['tempo_contrato_pk'];


$lead_operadordao = new lead_operadordao();
$lead_operadordao->setToken($token); 

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token); 

$retornodao = new retornodao();
$retornodao->setToken($token); 

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token);

$operadordao = new operadordao();
$operadordao->setToken($token);

$agenda_visitadao = new agenda_visitadao();
$agenda_visitadao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $lead_operador = $lead_operadordao->carregarPorPk($pk);
        if($lead_operador->getpk()>0){
            
            $lead_operadordao->excluir($lead_operador);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'lead_operador nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
            if($dt_vencimento!="" ||$dt_ativacao!="" ){
                $ds_operador = $operadordao->listarPorPk($operador_pk);
                $querytipo_ocorrencia = $tipo_ocorrenciadao->listarTipoOcOportunidadeFutura();
                $ocorrencia = $ocorrenciadao->carregarPorPk("");
                $ocorrencia->setds_ocorrencia("Oportunidade Futura - ".$ds_operador[0]['ds_operador']);
                $ocorrencia->settipos_ocorrencias_pk($querytipo_ocorrencia[0]['pk']);
                $ocorrencia->setdt_fechamento(2);
                $ocorrencia->setleads_pk($leads_pk);
                
                $ocorrencia_pk = $ocorrenciadao->salvar($ocorrencia); 
                
                if($dt_vencimento!=""){
                    $dt_retorno = date('d/m/Y', strtotime('-60 days', strtotime(str_replace("/","-",$dt_vencimento))));
                }
                else if($dt_ativacao!=""){
                    $dt_retorno = date('d/m/Y', strtotime('-60 days', strtotime(str_replace("/","-",$dt_ativacao))));
                }
                         
                $retorno = $retornodao->carregarPorPk("");            
                if($dt_retorno!=""){
                    $retorno->setdt_retorno(DataYMD($dt_retorno)." 00:00:00");
                }		
           
                $retorno->setds_retorno("Oportunidade Futura - ".$ds_operador[0]['ds_operador']);
                $retorno->setocorrencias_pk($ocorrencia_pk);  

                $retornos_pk = $retornodao->salvar($retorno);

            }
        
        
        
        
        $lead_operador = $lead_operadordao->carregarPorPk($pk);
        $lead_operador->setoperador_pk($operador_pk);
        $lead_operador->setleads_pk($leads_pk);
        $lead_operador->setic_cliente($ic_cliente);
        $lead_operador->setic_base($ic_base);
        if($dt_ativacao!=""){
            $lead_operador->setdt_ativacao(DataYMD($dt_ativacao));
        }
        if($dt_vencimento!=""){
            $lead_operador->setdt_vencimento(DataYMD($dt_vencimento));
        }
        
        
        if($ds_custo_atual!="" && $ds_custo_atual!="NaN"){
            $lead_operador->setds_custo_atual($ds_custo_atual);
        }
        else{
            $lead_operador->setds_custo_atual("0.00");
        }
        $lead_operador->setds_qtde_voz($ds_qtde_voz);
        $lead_operador->setds_qtde_dados($ds_qtde_dados);
        $lead_operador->setic_status($ic_status);
        $lead_operador->setclassificacao_pk($classificacao_pk);
        $lead_operador->settempo_contrato_pk($tempo_contrato_pk);

        
        $pk = $lead_operadordao->salvar($lead_operador);
        
        
     
        
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $lead_operadordao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ic_cliente"=>$query[$i]['ic_cliente'],
                    "ic_base"=>$query[$i]['ic_base'],
                    "dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "ds_custo_atual"=>$query[$i]['ds_custo_atual'],
                    "ds_qtde_voz"=>$query[$i]['ds_qtde_voz'],
                    "ds_qtde_dados"=>$query[$i]['ds_qtde_dados'],
                    "classificacao_pk"=>$query[$i]['classificacao_pk'],
                    "tempo_contrato_pk"=>$query[$i]['tempo_contrato_pk'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $lead_operadordao->listar_por_operador_pk($operador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ic_cliente"=>$query[$i]['ic_cliente'],
                    "ic_base"=>$query[$i]['ic_base'],
                    "dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "ds_custo_atual"=>$query[$i]['ds_custo_atual'],
                    "ds_qtde_voz"=>$query[$i]['ds_qtde_voz'],
                    "ds_qtde_dados"=>$query[$i]['ds_qtde_dados'],
                    "classificacao_pk"=>$query[$i]['classificacao_pk'],
                    "tempo_contrato_pk"=>$query[$i]['tempo_contrato_pk'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $lead_operadordao->listar_por_operador_pk($operador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ic_cliente"=>$query[$i]['ic_cliente'],
                    "t_ic_base"=>$query[$i]['ic_base'],
                    "t_dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_ds_custo_atual"=>$query[$i]['ds_custo_atual'],
                    "t_ds_qtde_voz"=>$query[$i]['ds_qtde_voz'],
                    "t_ds_qtde_dados"=>$query[$i]['ds_qtde_dados'],
                    "t_classificacao_pk"=>$query[$i]['classificacao_pk'],
                    "t_tempo_contrato_pk"=>$query[$i]['tempo_contrato_pk'],
                    "t_ic_status"=>$query[$i]['ic_status'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarGridOf':{
        
        $membro_equipe_pk = $_REQUEST['membro_equipe_pk'];
        $dt_ini_of = $_REQUEST['dt_ini_of'];
        $dt_fim_of = $_REQUEST['dt_fim_of'];
        
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
        
        $resultado = "";
        $query = $lead_operadordao->listar_grid_of($membro_equipe_pk,$dt_inicio,$dt_fim);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ic_cliente"=>$query[$i]['ic_cliente'],
                    "t_ic_base"=>$query[$i]['ic_base'],
                    "t_dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_ds_custo_atual"=>$query[$i]['ds_custo_atual'],
                    "t_ds_qtde_voz"=>$query[$i]['ds_qtde_voz'],
                    "t_ds_qtde_dados"=>$query[$i]['ds_qtde_dados'],
                    "t_classificacao_pk"=>$query[$i]['classificacao_pk'],
                    
                    "t_tempo_contrato_pk"=>$query[$i]['tempo_contrato_pk'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_operador"=>$query[$i]['ds_operador'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarPorLead':{
        
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        if($leads_pk!=""){
            $query = $lead_operadordao->listar_por_leads_pk($leads_pk);
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
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_ic_base"=>$query[$i]['ic_base'],
                    "t_ic_cliente"=>$query[$i]['ic_cliente'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_operador"=>$query[$i]['ds_operador'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_cliente"=>$query[$i]['ds_cliente'],
                    "t_ds_base"=>$query[$i]['ds_cliente'],
                    "t_dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_ds_custo_atual"=>number_format($query[$i]['ds_custo_atual'],2,',','.'),
                    "t_ds_qtde_voz"=>$query[$i]['ds_qtde_voz'],
                    "t_ds_qtde_dados"=>$query[$i]['ds_qtde_dados'],
                    "t_classificacao_pk"=>$query[$i]['classificacao_pk'],
                    "t_ds_classificacao"=>$query[$i]['ds_classificacao'],
                    "t_tempo_contrato_pk"=>$query[$i]['tempo_contrato_pk'],
                    "t_ds_status"=>$query[$i]['ds_status'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listar_grid_relatorio':{
        $responsavel_pk = $_REQUEST['responsavel_pk'];
        $resultado = "";

       
        $query = $lead_operadordao->listar_grid_relatorio($responsavel_pk);
        
        
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_ic_base"=>$query[$i]['ic_base'],
                    "t_ic_cliente"=>$query[$i]['ic_cliente'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_operador"=>$query[$i]['ds_operador'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_cliente"=>$query[$i]['ds_cliente'],
                    "t_ds_base"=>$query[$i]['ds_cliente'],
                    "t_dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "t_dt_vencimento"=>$query[$i]['dt_vencimento'],
                    "t_ds_custo_atual"=>number_format($query[$i]['ds_custo_atual'],2,',','.'),
                    "t_ds_qtde_voz"=>$query[$i]['ds_qtde_voz'],
                    "t_ds_qtde_dados"=>$query[$i]['ds_qtde_dados'],
                    "t_classificacao_pk"=>$query[$i]['classificacao_pk'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_tempo_contrato_pk"=>$query[$i]['tempo_contrato_pk'],

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

$lead_operadordao = null;

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
