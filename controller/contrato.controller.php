<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/contrato.dao.php";
include_once "../model/contrato.class.php";

include_once "../model/agenda_colaborador_padrao.dao.php";
include_once "../model/agenda_colaborador_padrao.class.php";

include_once "../model/contrato_item.dao.php";
include_once "../model/contrato_item.class.php";

include_once "../model/processo.dao.php";
include_once "../model/processo.class.php";

include_once "../model/processo_default_etapa.dao.php";
include_once "../model/processo_default_etapa.class.php";

include_once "../model/etapa_contrato.dao.php";
include_once "../model/etapa_contrato.class.php";

include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

include_once "../model/tipo_ocorrencia.dao.php";
include_once "../model/tipo_ocorrencia.class.php";

include_once "../model/lead_operador.dao.php";
include_once "../model/lead_operador.class.php";

include_once "../model/lead.dao.php";
include_once "../model/lead.class.php";

include_once "../model/lead_responsavel.dao.php";
include_once "../model/lead_responsavel.class.php";

include_once "../model/usuario.dao.php";
include_once "../model/usuario.class.php";

include_once "../model/contato.dao.php";
include_once "../model/contato.class.php";

include_once "layout_agenda.controller.php";
include_once "../model/enviar_email.dao.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dt_inicio_contrato = $arrRequest['dt_inicio_contrato'];
$dt_fim_contrato = $arrRequest['dt_fim_contrato'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$contratos_itens = $arrRequest['contratos_itens'];
$contratos_etapas = $arrRequest['contratos_etapas'];
$contrato_pai_pk = $arrRequest['contratos_pk'];
$ic_tipo_contrato = $arrRequest['ic_tipo_contrato'];
$polos_pk = $arrRequest['polos_pk'];
$responsavel_pk = $arrRequest['responsavel_pk'];
$propostas_pk = $arrRequest['propostas_pk'];
$operador_pk = $arrRequest['operador_pk'];
$ds_numero_pedido_operador = $arrRequest['ds_numero_pedido_operador'];
$ds_obs = $arrRequest['ds_obs'];
$processos_pk = $arrRequest['processos_pk'];
$ds_processo_etapas = $arrRequest['ds_processo_etapas'];

$contratodao = new contratodao();
$contratodao->setToken($token); 

$contrato_itemdao = new contrato_itemdao();
$contrato_itemdao->setToken($token); 

$agenda_colaborador_padraodao = new agenda_colaborador_padraodao();
$agenda_colaborador_padraodao->setToken($token); 

$processodao = new processodao();
$processodao->setToken($token);

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token);

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token);

$etapa_contratodao = new etapa_contratodao();
$etapa_contratodao->setToken($token);

$lead_operadordao = new lead_operadordao();
$lead_operadordao->setToken($token);

$leaddao = new leaddao();
$leaddao->setToken($token);

$usuariodao = new usuariodao();
$usuariodao->setToken($token);

$contatodao = new contatodao();
$contatodao->setToken($token);

$enviar_emaildao = new enviar_emaildao();
$enviar_emaildao->setToken($token);

$lead_responsaveldao = new lead_responsaveldao();
$lead_responsaveldao->setToken($token);






switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $contrato = $contratodao->carregarPorPk($pk);
        if($contrato->getpk()>0){
            
            $contratodao->excluirContratoItens($contrato->getpk());
            $contratodao->excluirContratoEtapasContratosPk($contrato->getpk());
            $contratodao->excluir($contrato);

            $result  = 'success';
            $message = 'Registro excluído com sucesso.';
           
            

        }
        else{
            $result  = 'error';
            $message = 'contrato nao encontrado';
        }
        break;
    }
    case 'excluirEtapa':{
        $contratos_etapas_pk = $_REQUEST['pk'];
        $resultdo = "";
        
        $contrato = $contratodao->carregarPorPk($pk);
        if($contratos_etapas_pk>0){
            
            $contratodao->excluirContratoEtapas($contratos_etapas_pk);

            $result  = 'success';
            $message = 'Registro excluído com sucesso.';
           
            

        }
        else{
            $result  = 'error';
            $message = 'contrato nao encontrado';
        }
        break;
    }
    case 'salvar':{
        if($contratos_itens != "")
            $arrContratoItens = json_decode($contratos_itens, true);
        if($contratos_etapas != "")
            
            $arrContratoEtapas = json_decode($contratos_etapas, true);
        
        $contrato = $contratodao->carregarPorPk($pk);
        //$contrato->setdt_inicio_contrato(DataYMD($dt_inicio_contrato));
        //$contrato->setdt_fim_contrato(DataYMD($dt_fim_contrato));
        $contrato->setprocessos_etapas_pk($processos_etapas_pk);
        $contrato->setic_tipo_contrato($ic_tipo_contrato);
        $contrato->setcontratos_pk($contrato_pai_pk);
        $contrato->setpropostas_pk($propostas_pk);
        $contrato->setpolos_pk($polos_pk);
        $contrato->setresponsavel_pk($responsavel_pk);
        $contrato->setoperador_pk($operador_pk);
        $contrato->setds_numero_pedido_operador($ds_numero_pedido_operador);
        $contrato->setds_obs($ds_obs);

        
        $pk = $contratodao->salvar($contrato);
        
        if($pk!=""){
            $contratos_pk = $pk;
        }
        else{
            $contratos_pk = $contrato->getpk();
        }
       
        if(count($arrContratoItens) > 0){
           
            for($i = 0; $i < count($arrContratoItens); $i++){
                
                //tira ponto e a virgula para salvar o valor no BD 
                $valor_unitario= ($arrContratoItens[$i]["vl_unit"]);
                $valor_total= ($arrContratoItens[$i]["vl_total"]);
                $valor_total_tudo += ($valor_total);
                $qtde_total += ($arrContratoItens[$i]['n_qtde']);
                
               
                $contratodao->adicionarContratoItens($arrContratoItens[$i]['contratos_itens_pk'],$contratos_pk,$arrContratoItens[$i]['n_qtde_dias_semana'], $arrContratoItens[$i]['n_qtde'], $valor_unitario, $valor_total, $arrContratoItens[$i]["produtos_servicos_pk"]);
            }
            
        }
        
        
        
        //ATUALIZA A CLASSIFICAÇÃO DO PROCESSO 
        //Pega a classificação atual do processo
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
        if($query1[0]['tipos_ocorrencias_pk'] != ""){
            $querytipo_ocorrencia = $tipo_ocorrenciadao->listarPorPk($query1[0]['tipos_ocorrencias_pk']);

            $ocorrencia = $ocorrenciadao->carregarPorPk('');
            $ocorrencia->setds_ocorrencia("Agenda Visita");
            $ocorrencia->settipos_ocorrencias_pk($query1[0]['tipos_ocorrencias_pk']);
            $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
            $ocorrencia->setdt_fechamento($querytipo_ocorrencia[0]['ic_fechar_ocorrencia_auto']);
            $ocorrencia->setleads_pk($leads_pk);
            $ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);
        }  
        
        $query_processo_pk = $processodao->listarPorPk($processos_pk);
        
        //ETAPAS
        if(count($arrContratoEtapas) > 0){
           
            for($i = 0; $i < count($arrContratoEtapas); $i++){
                //tira ponto e a virgula para salvar o valor no BD 
                
                $query_etapa = $etapa_contratodao->listarPorPk($arrContratoEtapas[$i]['contratos_etapas_pk']);
                $contratodao->adicionarContratoEtapas($arrContratoEtapas[$i]['contratos_etapas_pk_2'],$contratos_pk,$arrContratoEtapas[$i]['contratos_etapas_pk'], $arrContratoEtapas[$i]['dt_etapa'], $arrContratoEtapas[$i]['ds_obs']);
                
                //80%
                if(preg_match("/80%/", $query_etapa[0]['ds_etapa'])){
                    $processodao->updClassificacao($processos_pk,5);
                }
                //90%
                if(preg_match("/90%/", $query_etapa[0]['ds_etapa'])){
                    $processodao->updClassificacao($processos_pk,6);
                }
                //Cliente
                if(preg_match("/Cliente/", $query_etapa[0]['ds_etapa'])){
                    $processodao->updClassificacao($processos_pk,4);
                    //if($arrContratoEtapas[$i]['contratos_etapas_pk_2']==""){
                        
                        
                        $contratodao->icClienteLead(2, $query_processo_pk[0]['leads_pk']);
                        if($query_processo_pk[0]['classificacao_processo_pk']==4){
                            
                            //18 meses a mais que a data de hoje
                            $data = date('d-m-Y');
                            $dt_vencimento = date('d/m/Y', strtotime('+540 days', strtotime($data)));
                            
                            
                            
                            $lead_operador = $lead_operadordao->carregarPorPk("");
                            $lead_operador->setoperador_pk($operador_pk);
                            $lead_operador->setleads_pk($query_processo_pk[0]['leads_pk']);
                            $lead_operador->setic_cliente(1);
                            //$lead_operador->setic_base($arrLeadOperador[$i]['ic_base']);
                            $lead_operador->setdt_ativacao("sysdate()");
                            $lead_operador->setdt_vencimento(DataYMD($dt_vencimento));
                            $lead_operador->setds_custo_atual($valor_total_tudo);
                            //$lead_operador->setds_qtde_voz($arrLeadOperador[$i]['ds_qtde_voz']);
                            //$lead_operador->setds_qtde_dados($arrLeadOperador[$i]['ds_qtde_dados']);
                            $lead_operador->setic_status(1);
                            //$lead_operador->setclassificacao_pk($arrLeadOperador[$i]['classificacao_pk']);

                            $lead_operador_pk = $lead_operadordao->salvar($lead_operador);
                        }
                    //}
                } 
            }
            
        }
        
        
        if(count($arrContratoEtapas) > 0){
            $usuario_cadastro = $contratodao->listarPorPk($contratos_pk);
            
            //LISTAR OS RESPONSAVEIS DO LEAD
            $usuario_responsavel = $lead_responsaveldao->listarResponsavelLeadPk($query_processo_pk[0]['leads_pk']);
            
            $ds_lead = $leaddao->listarPorPk($query_processo_pk[0]['leads_pk']);
           
            $contato = $contatodao->listarPorLeadsPk($query_processo_pk[0]['leads_pk']);
            
            
            for($i = 0; $i < count($arrContratoEtapas); $i++){
                if($arrContratoEtapas[$i]['contratos_etapas_pk_2']==""){
                    $ds_etapa = "";
                    
                    $ds_etapa = $etapa_contratodao->listarPorPk($arrContratoEtapas[$i]['contratos_etapas_pk']);
                    
                    $html =   layout_email::layout_contrato($ds_lead[0]['ds_lead'],$ds_etapa[$i]['ds_etapa'],DataDMY($arrContratoEtapas[$i]['dt_etapa']),$usuario_responsavel[0]['ds_usuario'],$arrContratoEtapas[$i]['ds_obs']);
                    
                    if(count($usuario_responsavel) > 0){
                        for($j=0;$j< count($usuario_responsavel);$j++){
                            //PEGA O EMAIL
                            $email_responsavel = $usuariodao->listarPorPk($usuario_responsavel[$j]['usuarios_pk']);
                            
                            if($email_responsavel[0]['ds_email']!=""){
                                //SÓ OS RESPONSAVEIS RECEBEM ESSE EMAIL 
                                $enviar_emaildao->envia_email_agendamento($html, /*De*/$email_responsavel[0]['ds_email'], /*Para*/$email_responsavel[0]['ds_email'], "Status Contrato");

                            }
                        }
                    }  
                }
            }
        }
        
        
        
        
        
        
        $mysql_data[] = array(
            "pk" => $contratos_pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';    
              
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $contratodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk']
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
    case 'listarLeadsPk':{
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $contratodao->listarPorLeadsPk($leads_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "ds_combo_contrato"=>$query[$i]['ds_combo_contrato'],
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
        $query = $contratodao->listar_por_dt_inicio_contrato($dt_inicio_contrato);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarContratoPai':{
        $leads_pk = $_REQUEST['leads_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        $contrato_pai_pk = $_REQUEST['contrato_pai_pk'];
        $resultado = "";
        $query = $contratodao->listar_contrato_pai($leads_pk,$contratos_pk,$contrato_pai_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_contrato"=>$query[$i]['ds_combo_contrato']
                    
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
        $query = $contratodao->listar_por_dt_inicio_contrato($dt_inicio_contrato);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "t_dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'listarQtdeDeDiasProdutoServico':{
        $contratos_pk = $_REQUEST['contratos_pk'];
        $contratos_itens_pk = $_REQUEST['contratos_itens_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        
        $resultado = "";
        $query = $contratodao->listar_qtde_dias_contratados_produtos_servicos($contratos_pk,$contratos_itens_pk,$produtos_servicos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarContratoLeadProcesso':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        
        $resultado = "";
        $query = $contratodao->listar_contrato_lead_processo($leads_pk,$processos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "t_dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_ic_tipo_contrato"=>$query[$i]['ic_tipo_contrato'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_ds_tipo_contrato"=>$query[$i]['ds_tipo_contrato'],
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarContratoDashboard':{
        
        $resultado = "";
        $query = $contratodao->listar_contrato_dashboard($token,$polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_contrato"=>$query[$i]['dt_inicio_contrato'],
                    "t_dt_fim_contrato"=>$query[$i]['dt_fim_contrato'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_ic_tipo_contrato"=>$query[$i]['ic_tipo_contrato'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_operador_pk"=>$query[$i]['operador_pk'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_processos_pk"=>$query[$i]['processos_pk'],
                    "t_ds_tipo_contrato"=>$query[$i]['ds_tipo_contrato'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_vl_total"=>number_format($query[$i]['vl_total'],2,',','.'),

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarContratoEtapa':{
        $operador_pk = $_REQUEST['operador_pk'];
        
        $resultado = "";
        $query = $contratodao->listarContratoEtapa($operador_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_etapa"=>$query[$i]['ds_etapa'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarContratoEtapaCadastrado':{
        $contratos_pk = $_REQUEST['contratos_pk'];
        
        $resultado = "";
        $query = $contratodao->listarContratoEtapaCadastrado($contratos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "dt_etapa" => $query[$i]["dt_etapa"],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "etapas_contratos_pk"=>$query[$i]['etapas_contratos_pk'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "usuario_cadastro"=>$query[$i]['usuario_cadastro'],
                    "pk"=>$query[$i]['pk'],

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

$contratodao = null;

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
