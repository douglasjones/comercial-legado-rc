<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/proposta.dao.php";
include_once "../model/proposta.class.php";

include_once "../model/proposta_item.dao.php";
include_once "../model/proposta_item.class.php";

include_once "../model/processo.dao.php";
include_once "../model/processo.class.php";

include_once "../model/processo_default_etapa.dao.php";
include_once "../model/processo_default_etapa.class.php";

include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

include_once "../model/tipo_ocorrencia.dao.php";
include_once "../model/tipo_ocorrencia.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$n_versao = $arrRequest['n_versao'];
$responsavel_pk = $arrRequest['responsavel_pk'];
$vl_total = $arrRequest['vl_total'];
$ds_obs = $arrRequest['ds_obs'];
$dt_validade = $arrRequest['dt_validade'];
$dt_envio = $arrRequest['dt_envio'];
$dt_previsao_fechamento = $arrRequest['dt_previsao_fechamento'];
$dt_fechamento = $arrRequest['dt_fechamento'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$ds_obs_motivo_cancelamento = $arrRequest['ds_obs_motivo_cancelamento'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$agendas_pk = $arrRequest['agendas_pk'];
$polos_pk = $arrRequest['polos_pk'];
$leads_pk = $arrRequest['leads_pk'];
$proposta_itens = $arrRequest['proposta_itens'];
$processos_pk = $arrRequest['processos_pk'];
$ds_processo_etapas = $arrRequest['ds_processo_etapas'];
$operador_pk = $arrRequest['operador_pk'];

$propostadao = new propostadao();
$propostadao->setToken($token); 

$proposta_itemdao = new proposta_itemdao();
$proposta_itemdao->setToken($token); 

$processodao = new processodao();
$processodao->setToken($token);

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token);

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token);

switch($job){
    case 'excluir':{
        
        $resultdo = "";
        
        $proposta = $propostadao->carregarPorPk($pk);
        if($proposta->getpk()>0){
            
            $propostadao->excluir($proposta);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'proposta nao encontrado';
        }
        break;
    }
    case 'salvar':{
       
        if($proposta_itens != "")                     
            $arrPropostaItens = json_decode($proposta_itens, true);
                
    
        if(count($arrPropostaItens) > 0){    
            
            for($i = 0; $i < count($arrPropostaItens); $i++){              
                $valor_total+= ($arrPropostaItens[$i]["vl_total"]);                                                
            }            
        }
                 
        $proposta = $propostadao->carregarPorPk($pk);
        
        $proposta->setn_versao($n_versao);
        $proposta->setresponsavel_pk($responsavel_pk);
        if($valor_total!=null){
            $proposta->setvl_total($valor_total);
        }
        else{
            $proposta->setvl_total('0.00');
        }
        
        $proposta->setds_obs($ds_obs);        
        $proposta->setdt_validade(DataYMD($dt_validade));
        if(!empty($dt_envio)){
            $proposta->setdt_envio(DataYMD($dt_envio));
        }
        if(!empty($dt_previsao_fechamento)){
            $proposta->setdt_previsao_fechamento(DataYMD($dt_previsao_fechamento));
        }        
        $proposta->setdt_fechamento($dt_fechamento);
        $proposta->setdt_cancelamento($dt_cancelamento);
        $proposta->setds_obs_motivo_cancelamento($ds_obs_motivo_cancelamento);
        $proposta->setprocessos_etapas_pk($processos_etapas_pk);
        $proposta->setagendas_pk($agendas_pk);
        $proposta->setpolos_pk($polos_pk);
        $proposta->setleads_pk($leads_pk);
        $proposta->setoperador_pk($operador_pk);

        $pk = $propostadao->salvar($proposta);
          
          
               
        
        if($pk!=""){
            $propostas_pk = $pk;
        }
        else{
            //$propostas_pk = $propostas->getpk();
            $propostas_pk = $arrRequest['pk'];
        }
 
        if(count($arrPropostaItens) > 0){   
        
           
            for($i = 0; $i < count($arrPropostaItens); $i++){
       
                $valor_unitario= ($arrPropostaItens[$i]["vl_unit"]);
                $valor_total= ($arrPropostaItens[$i]["vl_total"]);                                
                $propostadao->adicionarPropostaItens($arrPropostaItens[$i]['proposta_itens_pk'],$propostas_pk, $arrPropostaItens[$i]['n_qtde'], $valor_unitario, $valor_total, $arrPropostaItens[$i]["produtos_servicos_pk"]);
            }            
        }
        
       
        //ATUALIZA A CLASSIFICAÇÃO DO PROCESSO 
        //Pega a classificação atual do processo
        
        if($processos_pk ==""){
            
            $query_processo = $propostadao->listarPorPk($propostas_pk);
            
            
            $consult = $processodao->listarProcessoPorEtapasPk($query_processo[0]['processos_etapas_pk']);
            $processos_pk = $consult[0]['processos_pk'];

        }
        
        $query = $processodao->carregarClassificacaoProcesso($processos_pk);
        if($query[0]['classificacao_processo_pk']!=null){
             $classificacao_processo = $query[0]['classificacao_processo_pk'];
        }
        else{
             $classificacao_processo = 0;
        }
        //PEGA O NOME DO PROCESSO ETAPA
        $arrDsProcessoEtapa= explode(". ",$ds_processo_etapas);
        
        //ATUALIZA A CLASSIFICAÇÃO DA ETAPA DO PROCESSO
        //Pega a classificação atual do processo
        $query1 = $processo_default_etapadao->listarPorPk($processos_pk,$arrDsProcessoEtapa[1]);
        $classificacao_processo_etapa = $query1[0]['classificacao_processo_etapa_pk'];
        
        //UPD DA CLASSIFICACAO DO PROCESSO
        if($classificacao_processo < $classificacao_processo_etapa){
            $processodao->updClassificacao($processos_pk,$classificacao_processo_etapa);
        }
        
        //GERA OCORRENCIA
        if($query1[0]['tipos_ocorrencias_pk']!=""){
            $querytipo_ocorrencia = $tipo_ocorrenciadao->listarPorPk($query1[0]['tipos_ocorrencias_pk']);

            $ocorrencia = $ocorrenciadao->carregarPorPk('');
            $ocorrencia->setds_ocorrencia("Agenda Visita");
            $ocorrencia->settipos_ocorrencias_pk($query1[0]['tipos_ocorrencias_pk']);
            $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
            $ocorrencia->setdt_fechamento($querytipo_ocorrencia[0]['ic_fechar_ocorrencia_auto']);
            $ocorrencia->setleads_pk($leads_pk);
            $ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);
        }    
        
        $mysql_data[] = array(
            "pk" => $propostas_pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
             

        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $propostadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "n_versao"=>$query[$i]['n_versao'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "dt_validade"=>$query[$i]['dt_validade'],
                    "dt_envio"=>$query[$i]['dt_envio'],
                    "dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "operador_pk"=>$query[$i]['operador_pk'],
                    "agendas_pk"=>$query[$i]['agendas_pk']
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
        $query = $propostadao->listar_por_dt_inicio();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "n_versao"=>$query[$i]['n_versao'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "dt_validade"=>$query[$i]['dt_validade'],
                    "dt_envio"=>$query[$i]['dt_envio'],
                    "dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "operador_pk"=>$query[$i]['operador_pks'],
                    "agendas_pk"=>$query[$i]['agendas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'relatorioFunilVendas':{
        
        $polos_pk = $_REQUEST['polos_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        $responsavel_pk = $_REQUEST['responsavel_pk'];
        $dt_envio_ini = $_REQUEST['dt_envio_ini'];
        $dt_envio_fim = $_REQUEST['dt_envio_fim'];
        $dt_prev_fechamento_ini = $_REQUEST['dt_prev_fechamento_ini'];
        $dt_prev_fechamento_fim = $_REQUEST['dt_prev_fechamento_fim'];
        $dt_fechamento_ini = $_REQUEST['dt_fechamento_ini'];
        $dt_fechamento_fim = $_REQUEST['dt_fechamento_fim'];
        $grupos_pk = $_REQUEST['grupos_pk'];
        $resultado = "";
        $query = $propostadao->listar_rel_funil_vendas($polos_pk,$leads_pk,$responsavel_pk,$dt_envio_ini,$dt_envio_fim,$dt_prev_fechamento_ini,$dt_prev_fechamento_fim,$dt_fechamento_ini,$dt_fechamento_fim,$grupos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($query[$i]["ds_lead"]!=null){
                    $mysql_data[] = array(
                        "t_ds_lead"=> $query[$i]["ds_lead"],
                        "t_processos_pk"=> $query[$i]["processos_pk"],
                        "t_classificacao_processo_pk"=> $query[$i]["classificacao_processo_pk"],
                        "t_ds_classficacao_processo"=> $query[$i]["ds_classficacao_processo"],
                        "t_ds_responsavel"=> $query[$i]["ds_responsavel"],
                        "t_n_qtde"=> $query[$i]["n_qtde"],
                        "t_vl_total"=> $query[$i]["vl_total"],
                        "t_dt_envio"=> $query[$i]["dt_envio"],
                        "t_dt_cancelamento"=> $query[$i]["dt_cancelamento"],
                        "t_dt_fechamento"=> $query[$i]["dt_fechamento"],
                        "t_dt_previsao_fechamento"=> $query[$i]["dt_previsao_fechamento"],
                        "t_dt_validade"=> $query[$i]["dt_validade"],
                        "t_operador_pk"=> $query[$i]["operador_pk"],
                        "t_dt_cadastro"=> $query[$i]["dt_cadastro"]
                    );
                }
                else{
                    $mysql_data = [];
                }
                
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $propostadao->listar_por_dt_inicio();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    
                    "t_n_versao"=>$query[$i]['n_versao'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_vl_total"=>$query[$i]['vl_total'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_dt_validade"=>$query[$i]['dt_validade'],
                    "t_dt_envio"=>$query[$i]['dt_envio'],
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_agendas_pk"=>$query[$i]['agendas_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }
    case 'listarProposta50':{
        
        
        $resultado = "";
        $query = $propostadao->listarProposta50();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "qtde_proposta50" => $query[$i]["qtde_proposta50"],
                    "vl_total" => $query[$i]["vl_total"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }
    case 'listarProposta75':{
        
        
        $resultado = "";
        $query = $propostadao->listarProposta75();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "qtde_proposta75" => $query[$i]["qtde_proposta75"],
                    "vl_total" => $query[$i]["vl_total"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }
    case 'listarPropostaFechada':{
        
        
        $resultado = "";
        $query = $propostadao->listarPropostaFechada();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "qtde_proposta_fechada" => $query[$i]["qtde_proposta_fechada"],
                    "vl_total" => $query[$i]["vl_total"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }
    case 'listarPropostaCancelada':{
        
        
        $resultado = "";
        $query = $propostadao->listarPropostaCancelada();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "qtde_proposta_cancelada" => $query[$i]["qtde_proposta_cancelada"],
                    "vl_total" => $query[$i]["vl_total"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }
    case 'listarPropostaLeadProcesso':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        
        $resultado = "";
        $query = $propostadao->listar_proposta_lead_processo($leads_pk,$processos_pk);
   
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_n_versao"=>$query[$i]['n_versao'],
                    "t_dt_cad"=>$query[$i]['dt_cad'],
                    "t_dt_validade"=>$query[$i]['dt_validade'], 
                    "t_dt_envio"=>$query[$i]['dt_envio'],  
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),
                    "t_ds_obs"=>$query[$i]['ds_obs'],                    
                    "t_ds_contato"=>$query[$i]['ds_contato'],                    
                    "t_leads_pk"=>$query[$i]['leads_pk'],                    
                    "t_ds_email_contato"=>$query[$i]['ds_email_contato'],                    
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }     
    case 'listarPropostaDashboardConsultor':{
        
        $resultado = "";
        $query = $propostadao->listarPropostaDashboardConsultor();
   
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                
                
                if($query[$i]["dt_envio"]!=""){
                    if($query[$i]["dt_fechamento"]!=null){
                        $time = $propostadao->dateDiff($query[$i]["dt_envio"],"");
                    }
                    else{
                        $time = $propostadao->dateDiff($query[$i]["dt_envio"],$query[$i]["dt_fechamento"]);
                    }
                }
                
                
                
                
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_dt_cad"=>$query[$i]['dt_cad'],
                    "t_dt_validade"=>$query[$i]['dt_validade'], 
                    "t_dt_envio"=>$query[$i]['dt_envio'],  
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),
                    "t_ds_obs"=>$query[$i]['ds_obs'],                    
                    "t_ds_contato"=>$query[$i]['ds_contato'],                    
                    "t_leads_pk"=>$query[$i]['leads_pk'],                    
                    "t_polos_pk"=>$query[$i]['polos_pk'],                    
                    "t_versao"=>$query[$i]['n_versao'],                    
                    "t_ds_email_contato"=>$query[$i]['ds_email_contato'],
                    "t_time"=>$time[0]['time'],                
                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }     
    case 'listarPropostaDashboard':{
   
        $resultado = "";
        $query = $propostadao->listar_proposta_lead_processo_dashboard($token,$polos_pk);
   
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_n_versao"=>$query[$i]['n_versao'],
                    "t_dt_cad"=>$query[$i]['dt_cad'],
                    "t_dt_validade"=>$query[$i]['dt_validade'], 
                    "t_dt_envio"=>$query[$i]['dt_envio'],  
                    "t_dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                    "t_dt_fechamento"=>$query[$i]['dt_fechamento'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),
                    "t_ds_obs"=>$query[$i]['ds_obs'],                    
                    "t_leads_pk"=>$query[$i]['leads_pk'],                    
                    "t_polos_pk"=>$query[$i]['polos_pk'],                    
                    "t_processos_pk"=>$query[$i]['processos_pk'],                    
                    "t_ds_lead"=>$query[$i]['ds_lead'],                    
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

$propostadao = null;

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
