<?php

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/agenda_visita.dao.php";
include_once "../model/agenda_visita.class.php";

include_once "../model/processo.dao.php";
include_once "../model/processo.class.php";

include_once "../model/processo_default_etapa.dao.php";
include_once "../model/processo_default_etapa.class.php";

include_once "../model/ocorrencia.dao.php";
include_once "../model/ocorrencia.class.php";

include_once "../model/tipo_ocorrencia.dao.php";
include_once "../model/tipo_ocorrencia.class.php";

include_once "../model/contato.dao.php";
include_once "../model/contato.class.php";

include_once "../model/usuario.dao.php";
include_once "../model/usuario.class.php";

include_once "../model/lead_responsavel.dao.php";
include_once "../model/lead_responsavel.class.php";

include_once "../model/polo.dao.php";
include_once "../model/polo.class.php";

include_once "../model/enviar_email.dao.php";
include_once "layout_agenda.controller.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dt_agenda_visita = $arrRequest['dt_agenda_visita'];
$hr_agenda_visita = $arrRequest['hr_agenda_visita'];
$dt_reagenda_visita = $arrRequest['dt_reagenda_visita'];
$hr_reagenda_visita = $arrRequest['hr_reagenda_visita'];
$dt_termino = $arrRequest['dt_termino'];
$ds_endereco = $arrRequest['ds_endereco'];
$ds_numero = $arrRequest['ds_numero'];
$ds_complemento = $arrRequest['ds_complemento'];
$ds_cep = $arrRequest['ds_cep'];
$ds_bairro = $arrRequest['ds_bairro'];
$ds_cidade = $arrRequest['ds_cidade'];
$ds_uf = $arrRequest['ds_uf'];
$ds_obs = $arrRequest['ds_obs'];
$classificacao_agenda_pk = $arrRequest['classificacao_agenda_pk'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$motivo_cancelamento_pk = $arrRequest['motivo_cancelamento_pk'];
$ds_obs_cancelamento = $arrRequest['ds_obs_cancelamento'];
$dt_reagendamento = $arrRequest['dt_reagendamento'];
$motivo_reagendamento_pk = $arrRequest['motivo_reagendamento_pk'];
$ds_obs_reagendamento = $arrRequest['ds_obs_reagendamento'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$tipos_agendas_pk = $arrRequest['tipos_agendas_pk'];
$responsavel_pk = $arrRequest['responsavel_pk'];
$ds_obs_classificacao = $arrRequest['ds_obs_classificacao'];
$ic_status = $arrRequest['ic_status'];
$agenda_reagendamento_pk = $arrRequest['agenda_reagendamento_pk'];
$ds_contato = $arrRequest['ds_contato'];
$ds_cel = $arrRequest['ds_cel'];
$ds_tel = $arrRequest['ds_tel'];
$ds_email = $arrRequest['ds_email'];
$ds_cargo = $arrRequest['ds_cargo'];
$cargos_pk = $arrRequest['cargos_pk'];
$polos_pk = $arrRequest['polos_pk'];
$leads_pk = $arrRequest['leads_pk'];
$contas_pk = $arrRequest['contas_pk'];
$processos_pk = $arrRequest['processos_pk'];
$ds_processo_etapas = $arrRequest['ds_processo_etapas'];
$tipo_evento_pk = $arrRequest['tipo_evento_pk'];
$ds_titulo_agenda = $arrRequest['ds_titulo_agenda'];
$aviso_pk = $arrRequest['aviso_pk'];
$contatos_pk = $arrRequest['contatos_pk'];
$atendente_pk = $arrRequest['atendente_pk'];


$agenda_visitadao = new agenda_visitadao();
$agenda_visitadao->setToken($token); 

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token);

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token);

$processodao = new processodao();
$processodao->setToken($token);

$contatodao = new contatodao();
$contatodao->setToken($token);

$usuariodao = new usuariodao();
$usuariodao->setToken($token);

$enviar_emaildao = new enviar_emaildao();
$enviar_emaildao->setToken($token);

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token);

$lead_responsaveldao = new lead_responsaveldao();
$lead_responsaveldao->setToken($token); 

$polodao = new polodao();
$polodao->setToken($token);



switch($job){
    
    case 'excluir':{
        
        $resultdo = "";
       
        $agenda_visita = $agenda_visitadao->carregarPorPk($pk);
        
        if($agenda_visita->getpk()>0){
            $agenda_visitadao->excluirAgendaResponsavelPk($agenda_visita->getpk());
            $agenda_visitadao->excluir($agenda_visita);
            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agenda_visita nao encontrado';
        }
        break;
    }
    case 'excluir_responsavel':{
            
            $resultdo = "";
            $agenda_visitadao->excluirResponsavelPk($agenda_visita_pk);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';
        break;
    }
    case 'salvar':{
     
        if($responsavel_pk != "")
            $arrResponsavel = json_decode($responsavel_pk, true);
        
        
        $agenda_visita = $agenda_visitadao->carregarPorPk($pk);
        
        $agenda_visita->setdt_agenda(DataYMD($dt_agenda_visita)." ".$hr_agenda_visita);
        $agenda_visita->setdt_termino($dt_termino);
        $agenda_visita->setds_endereco($ds_endereco);
        $agenda_visita->setds_numero($ds_numero);
        $agenda_visita->setds_complemento($ds_complemento);
        $agenda_visita->setds_cep($ds_cep);
        $agenda_visita->setds_bairro($ds_bairro);
        $agenda_visita->setds_cidade($ds_cidade);
        $agenda_visita->setds_uf($ds_uf);
        $agenda_visita->setds_obs($ds_obs);
        $agenda_visita->setclassificacao_agenda_pk($classificacao_agenda_pk);
        $agenda_visita->setdt_cancelamento($dt_cancelamento);
        $agenda_visita->setmotivo_cancelamento_pk($motivo_cancelamento_pk);
        $agenda_visita->setds_obs_cancelamento($ds_obs_cancelamento);
        
        
        $agenda_visita->setdt_reagendamento(DataYMD($dt_agenda_visita)." ".$hr_agenda_visita);
        
        $agenda_visita->setmotivo_reagendamento_pk($motivo_reagendamento_pk);
        $agenda_visita->setds_obs_reagendamento($ds_obs_reagendamento);
        $agenda_visita->setprocessos_etapas_pk($processos_etapas_pk);
        $agenda_visita->settipos_agendas_pk($tipos_agendas_pk);
        $agenda_visita->setds_obs_classificacao($ds_obs_classificacao);
        $agenda_visita->setic_status($ic_status);
        $agenda_visita->setagenda_reagendamento_pk($agenda_reagendamento_pk);
        $agenda_visita->setds_contato($ds_contato);
        $agenda_visita->setds_tel($ds_tel);
        $agenda_visita->setds_cel($ds_cel);
        
        $agenda_visita->setds_email($ds_email);
 
        $agenda_visita->setcargos_pk($cargos_pk);
        $agenda_visita->setpolos_pk($polos_pk);
        $agenda_visita->setleads_pk($leads_pk);
        $agenda_visita->settipo_evento_pk($tipo_evento_pk);
        $agenda_visita->setds_titulo_agenda($ds_titulo_agenda);
        $agenda_visita->setaviso_pk($aviso_pk);
        $agenda_visita->setatendente_pk($atendente_pk);
        
        
        
        $pk = $agenda_visitadao->salvar($agenda_visita);
        
        
        if($pk!=""){
            $agenda_visita_pk = $pk;
        }
        else{
            $agenda_visita_pk = $agenda_visita->getpk();
        }
       
        $agenda_visitadao->excluirResponsavel($agenda_visita_pk);
    
        if(count($arrResponsavel) > 0){
           
            for($i = 0; $i < count($arrResponsavel); $i++){               
                
                $agenda_visitadao->adicionarResponsavel($arrResponsavel[$i]['responsavel_pk'],$agenda_visita_pk);
                
                $arrGruposPk = $usuariodao->listarPorPk($arrResponsavel[$i]['responsavel_pk']);
                $query_responsavel_lead = $lead_responsaveldao->listarPorResponsavelPk($arrResponsavel[$i]['responsavel_pk'],$leads_pk);
                if(count($query_responsavel_lead) == 0){
                        
                        $lead_responsavel = $lead_responsaveldao->carregarPorPk("");
                        $lead_responsavel->setgrupos_pk($arrGruposPk[$i]['grupos_pk']);
                        $lead_responsavel->setusuarios_pk($arrResponsavel[$i]['responsavel_pk']);
                        $lead_responsavel->setpolos_pk($polos_pk);
                        $lead_responsavel->setleads_pk($leads_pk);
                        $lead_responsavel_pk = $lead_responsaveldao->salvar($lead_responsavel);
                }
            }
            
        }
        if($atendente_pk!=""){
           

                
                $arrGruposPk = $usuariodao->listarPorPk($atendente_pk);
                $query_responsavel_lead = $lead_responsaveldao->listarPorResponsavelPk($atendente_pk,$leads_pk);
                if(count($query_responsavel_lead) == 0){
                        
                        $lead_responsavel = $lead_responsaveldao->carregarPorPk("");
                        $lead_responsavel->setgrupos_pk($arrGruposPk[0]['grupos_pk']);
                        $lead_responsavel->setusuarios_pk($atendente_pk);
                        $lead_responsavel->setpolos_pk($polos_pk);
                        $lead_responsavel->setleads_pk($leads_pk);
                        $lead_responsavel_pk = $lead_responsaveldao->salvar($lead_responsavel);
                }

            }
        
         //ATUALIZA A CLASSIFICAÇÃO DO PROCESSO 
        //Pega a classificação atual do processo
        if($processos_pk!=""){
            
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
                if($tipos_agendas_pk==1){
                    $processodao->updClassificacao($processos_pk,$classificacao_processo_etapa);
                }
                
            }
           
            
            
            //GERA OCORRENCIA
            if($query1[0]['tipos_ocorrencias_pk']!=""){
               if($classificacao_agenda_pk!=""){
                    $querytipo_ocorrencia = $tipo_ocorrenciadao->listarPorPk(1);
                    $ocorrencia = $ocorrenciadao->carregarPorPk('');
                    if($ds_obs_classificacao!=""){
                        $ocorrencia->setds_ocorrencia($ds_obs_classificacao);
                    }
                    else{
                        $ocorrencia->setds_ocorrencia("Classificação Agenda");
                    }
                    $ocorrencia->settipos_ocorrencias_pk(1);
                    $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
                    $ocorrencia->setdt_fechamento($querytipo_ocorrencia[0]['ic_fechar_ocorrencia_auto']);
                    $ocorrencia->setleads_pk($leads_pk);
                    $ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);
                  
                }
                //REAGENDAMENTO
                else if($motivo_reagendamento_pk!=""){
                  
                    $querymotivo_reagendamento = $tipo_ocorrenciadao->listarTipoOcReagendamentoVisita();

                    $ocorrencia = $ocorrenciadao->carregarPorPk('');
                    if($ds_obs_reagendamento!=""){
                        $ocorrencia->setds_ocorrencia($ds_obs_reagendamento);
                    }
                    else{
                        $ocorrencia->setds_ocorrencia("Reagendamento Visita");
                    }
                    $ocorrencia->settipos_ocorrencias_pk($querymotivo_reagendamento[0]['pk']);
                    $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
                    $ocorrencia->setdt_fechamento($querymotivo_reagendamento[0]['ic_fechar_ocorrencia_auto']);
                    $ocorrencia->setleads_pk($leads_pk);
                    $ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);


                }
                else{
                    $querytipo_ocorrencia = $tipo_ocorrenciadao->listarPorPk($query1[0]['tipos_ocorrencias_pk']);

                    $ocorrencia = $ocorrenciadao->carregarPorPk('');
                    $ocorrencia->setds_ocorrencia($ds_obs);
                    $ocorrencia->settipos_ocorrencias_pk($query1[0]['tipos_ocorrencias_pk']);
                    $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
                    $ocorrencia->setdt_fechamento($querytipo_ocorrencia[0]['ic_fechar_ocorrencia_auto']);
                    $ocorrencia->setleads_pk($leads_pk);
                    $ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);
    
                }
		
		
	    }
            
            
            
            
        }
        else{
            
            if($classificacao_agenda_pk!=""){
                $querytipo_ocorrencia = $tipo_ocorrenciadao->listarPorPk(1);
            	$ocorrencia = $ocorrenciadao->carregarPorPk('');
                if($ds_obs_classificacao!=""){
                    $ocorrencia->setds_ocorrencia($ds_obs_classificacao);
                }
                else{
                    $ocorrencia->setds_ocorrencia("Classificação Agenda");
                }
           	$ocorrencia->settipos_ocorrencias_pk($querytipo_ocorrencia[0]['pk']);
           	$ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
           	$ocorrencia->setdt_fechamento($querytipo_ocorrencia[0]['ic_fechar_ocorrencia_auto']);
            	$ocorrencia->setleads_pk($leads_pk);
            	$ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);
            }
            
            if($motivo_reagendamento_pk!=""){

                $querymotivo_reagendamento = $tipo_ocorrenciadao->listarTipoOcReagendamentoVisita();

                $ocorrencia = $ocorrenciadao->carregarPorPk('');
                if($ds_obs_reagendamento!=""){
                    $ocorrencia->setds_ocorrencia($ds_obs_reagendamento);
                }
                else{
                    $ocorrencia->setds_ocorrencia("Reagendamento Visita");
                }
                $ocorrencia->settipos_ocorrencias_pk($querymotivo_reagendamento[0]['pk']);
                $ocorrencia->setprocessos_etapas_pk($processos_etapas_pk);
                $ocorrencia->setdt_fechamento($querymotivo_reagendamento[0]['ic_fechar_ocorrencia_auto']);
                $ocorrencia->setleads_pk($leads_pk);
                $ocorrencias_pk = $ocorrenciadao->salvar($ocorrencia);


            }
        }
        
      
        //ENVIO DE EMAIL 
        if($classificacao_agenda_pk==""){
            //VERIFICA O TIPO DE AGENDAMENTO 
            if($tipo_evento_pk==1){
                //VERIFICA SE UM CONTATO FOI CADASTRADO
                if($contatos_pk!="" || $ds_contato!=""){
                     
                    $ds_email_contato = $contatodao->carregarEmailContato($contatos_pk,$ds_contato);
                    
                    //VERIFICA SE ESSE CONTATO TEM EMAIL CADASTRADO 
                    if(!empty($ds_email_contato)){
                        
                        //VERIFICA SE O RESPONSAVEL FOI CADASTRADO
                        if(count($arrResponsavel) > 0){
           
                            for($i = 0; $i < count($arrResponsavel); $i++){  
                                
                                $ds_email_responsavel = "";
                                $ds_email_responsavel = $usuariodao->pegarEmailResponsavel($arrResponsavel[$i]['responsavel_pk']);
                                $polo_endereco = $polodao->listar_por_contas_usuarios();
                                //VERIFICA SE ESSE RESPONSAVEL TEM EMAIL CADASTRADO 
                                if(!empty($ds_email_responsavel)){
                                    $ds_endereco_agendamento = $polo_endereco[0]['ds_endereco'].", ".$polo_endereco[0]['ds_numero']."<br> Bairro:".$polo_endereco[0]['ds_bairro']."<br> Cidade:".$polo_endereco[0]['ds_cidade']."<br> CEP:".$polo_endereco[0]['ds_cep']."<br>";
                                    
                                    $ds_consultor_responsavel = $agenda_visitadao->listar_responsavel_agenda($agenda_visita_pk);
                                    $ds_responsavel_visita = str_replace(",",";",$ds_consultor_responsavel[0]['ds_consultor']);
                                    
                                    $html =   layout_email::layout_agendamento($dt_agenda_visita,$hr_agenda_visita,$ds_responsavel_visita,$ds_email_responsavel,$ds_endereco_agendamento);
                                    //CHAMA A FUNÇÃO DO ENVIO DE EMAIL
                                    $enviar_emaildao->envia_email_agendamento($html, /*De*/$ds_email_responsavel, /*Para*/$ds_email_contato, "Agendamento Visita Comercial");
                                } 
                            }
                        }
                    }  
                }
            }
        }
        
        
        
        
        $mysql_data[] = array(
            "pk" => $agenda_visita_pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $agenda_visitadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_agenda"=>$query[$i]['dt_agenda'],
                    "dt_termino"=>$query[$i]['dt_termino'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "classificacao_agenda_pk"=>$query[$i]['classificacao_agenda_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "motivo_cancelamento_pk"=>$query[$i]['motivo_cancelamento_pk'],
                    "ds_obs_cancelamento"=>$query[$i]['ds_obs_cancelamento'],
                    "dt_reagendamento"=>$query[$i]['dt_reagendamento'],
                    "motivo_reagendamento_pk"=>$query[$i]['motivo_reagendamento_pk'],
                    "ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento'],
                    "tipos_agendas_pk"=>$query[$i]['tipos_agendas_pk'],
                    "ds_obs_classificacao"=>$query[$i]['ds_obs_classificacao'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "cargos_pk"=>$query[$i]['cargos_pk'],
                    "atendente_pk"=>$query[$i]['atendente_pk'],
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
    case 'listarTodos':{
        
        $resultado = "";
        $query = $agenda_visitadao->listar_por_dt_agenda($dt_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_agenda"=>$query[$i]['dt_agenda'],
                    "dt_termino"=>$query[$i]['dt_termino'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "classificacao_agenda_pk"=>$query[$i]['classificacao_agenda_pk'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "motivo_cancelamento_pk"=>$query[$i]['motivo_cancelamento_pk'],
                    "ds_obs_cancelamento"=>$query[$i]['ds_obs_cancelamento'],
                    "dt_reagendamento"=>$query[$i]['dt_reagendamento'],
                    "motivo_reagendamento_pk"=>$query[$i]['motivo_reagendamento_pk'],
                    "ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento'],
                    "tipos_agendas_pk"=>$query[$i]['tipos_agendas_pk'],
                    "ds_obs_classificacao"=>$query[$i]['ds_obs_classificacao'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "cargos_pk"=>$query[$i]['cargos_pk'],
                    "atendente_pk"=>$query[$i]['atendente_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarVisitaParaHoje':{
        
        $resultado = "";
        $query = $agenda_visitadao->listar_agenda_visita_para_hoje($polos_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "qtde_agendas_para_hoje" => $query[$i]["qtde_registros"],
                    
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarVisitaAgendadasHoje':{
        
        $resultado = "";
        $query = $agenda_visitadao->listar_agenda_visita_agendadas_hoje($polos_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "qtde_agendas_para_hoje" => $query[$i]["qtde_registros"],
                    
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listarAgendaVisitaLeadProcesso':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        
        $resultado = "";
        $query = $agenda_visitadao->listar_agenda_visita_lead_processo($leads_pk,$processos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_agenda"=>$query[$i]['dt_agenda'],
                    "t_dt_agenda_visita"=>$query[$i]['dt_agenda_visita'],
                    "t_hr_agenda_visita"=>$query[$i]['hr_agenda_visita'],
                    "t_dt_termino"=>$query[$i]['dt_termino'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_classificacao_agenda_pk"=>$query[$i]['classificacao_agenda_pk'],
                    "t_ds_classificacao_agenda"=>$query[$i]['ds_classificacao_agenda'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_motivo_cancelamento_pk"=>$query[$i]['motivo_cancelamento_pk'],
                    "t_ds_obs_cancelamento"=>$query[$i]['ds_obs_cancelamento'],
                    "t_dt_reagendamento"=>$query[$i]['dt_reagendamento'],
                    "t_motivo_reagendamento_pk"=>$query[$i]['motivo_reagendamento_pk'],
                    "t_ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento'],
                    "t_tipos_agendas_pk"=>$query[$i]['tipos_agendas_pk'],
                    "t_ds_tipo_agenda"=>$query[$i]['ds_tipo_agenda'],
                    "t_ds_obs_classificacao"=>$query[$i]['ds_obs_classificacao'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    
                    "t_dt_reagenda"=>$query[$i]['dt_reagenda'],
                    "t_dt_reagenda_visita"=>$query[$i]['dt_reagenda_visita'],
                    "t_hr_reagenda_visita"=>$query[$i]['hr_reagenda_visita'],
                    "t_ds_contato"=>$query[$i]['ds_contato'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],
                    "t_cargos_pk"=>$query[$i]['cargos_pk'],
                    "t_ds_cargo"=>$query[$i]['ds_cargo'],
                    "t_ds_tipo_evento"=>$query[$i]['ds_tipo_evento'],
                    "t_tipo_evento_pk"=>$query[$i]['tipo_evento_pk'],
                    "t_aviso_pk"=>$query[$i]['aviso_pk'],
                    "t_ds_titulo_agenda"=>$query[$i]['ds_titulo_agenda'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_atendente_pk"=>$query[$i]['atendente_pk'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listarAgendaVisitaDashboard':{
        
        $resultado = "";
        $query = $agenda_visitadao->listar_agenda_visita_dashboard($polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_agenda"=>$query[$i]['dt_agenda'],
                    "t_dt_agenda_visita"=>$query[$i]['dt_agenda_visita'],
                    "t_hr_agenda_visita"=>$query[$i]['hr_agenda_visita'],
                    "t_dt_termino"=>$query[$i]['dt_termino'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_classificacao_agenda_pk"=>$query[$i]['classificacao_agenda_pk'],
                    "t_ds_classificacao_agenda"=>$query[$i]['ds_classificacao_agenda'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_motivo_cancelamento_pk"=>$query[$i]['motivo_cancelamento_pk'],
                    "t_ds_obs_cancelamento"=>$query[$i]['ds_obs_cancelamento'],
                    "t_dt_reagendamento"=>$query[$i]['dt_reagendamento'],
                    "t_motivo_reagendamento_pk"=>$query[$i]['motivo_reagendamento_pk'],
                    "t_ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento'],
                    "t_tipos_agendas_pk"=>$query[$i]['tipos_agendas_pk'],
                    "t_ds_tipo_agenda"=>$query[$i]['ds_tipo_agenda'],
                    "t_ds_obs_classificacao"=>$query[$i]['ds_obs_classificacao'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    
                    "t_dt_reagenda"=>$query[$i]['dt_reagenda'],
                    "t_dt_reagenda_visita"=>$query[$i]['dt_reagenda_visita'],
                    "t_hr_reagenda_visita"=>$query[$i]['hr_reagenda_visita'],
                    "t_ds_contato"=>$query[$i]['ds_contato'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],
                    "t_cargos_pk"=>$query[$i]['cargos_pk'],
                    "t_ds_cargo"=>$query[$i]['ds_cargo'],
                    "t_ds_tipo_evento"=>$query[$i]['ds_tipo_evento'],
                    "t_tipo_evento_pk"=>$query[$i]['tipo_evento_pk'],
                    "t_aviso_pk"=>$query[$i]['aviso_pk'],
                    "t_ds_titulo_agenda"=>$query[$i]['ds_titulo_agenda'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_atendente_pk"=>$query[$i]['atendente_pk'],
                    "t_processos_pk"=>$query[$i]['processos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listarResponsavelAgendaVisita':{
        $pk = $_REQUEST['agenda_visita_pk'];
        
        $resultado = "";
        $result  = 'success';
        $message = 'query success';
        if($pk!=""){
            $query = $agenda_visitadao->listar_agenda_visita_responsavel($pk,$token);
        
        

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "t_pk" => $query[$i]["pk"],
                        "t_usuarios_pk"=>$query[$i]['usuarios_pk']
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
    case 'listarData':{
        $dt_agenda = $_REQUEST['dt_agenda'];
        
        $resultado = "";
        $query = $agenda_visitadao->listar_data($dt_agenda);
        
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
    case 'listarAgendaVisitaData':{

        $dt_base = $_REQUEST['dt_base'];
        $dt_base_fim = $_REQUEST['dt_base_fim']; 
        $tipo_evento_pk = $_REQUEST['tipo_evento_pk']; 
        $tipos_agendas_pk = $_REQUEST['tipos_agendas_pk']; 
        $classificacao_agenda_pk = $_REQUEST['classificacao_agenda_pk']; 
        $polos_pk = $_REQUEST['polos_pk']; 
        $grupos_pk = $_REQUEST['grupos_pk']; 
        $usuarios_pk = $_REQUEST['usuarios_pk']; 
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk']; 
        $equipes_pk = $_REQUEST['equipes_pk']; 
        $atendente_pk = $_REQUEST['atendente_pk']; 
               
                
        $resultado = "";
        if($dt_base!=""){            
            $query = $agenda_visitadao->listar_agenda_visita_data($token,$dt_base,$dt_base_fim,$tipo_evento_pk,$tipos_agendas_pk,$classificacao_agenda_pk,$polos_pk,$grupos_pk,$usuarios_pk,$usuario_cadastro_pk,$equipes_pk,$atendente_pk);            
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
                    "t_dt_agenda"=>$query[$i]['dt_agenda'],
                    "t_dt_agenda_visita"=>$query[$i]['dt_agenda_visita'],
                    "t_hr_agenda_visita"=>$query[$i]['hr_agenda_visita'],
                    "t_dt_termino"=>$query[$i]['dt_termino'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_ds_obs"=>str_replace('"'," ",$query[$i]['ds_obs']),
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    
                    
                    "t_classificacao_agenda_pk"=>$query[$i]['classificacao_agenda_pk'],
                    "t_ds_tipo_evento"=>$query[$i]['ds_tipo_evento'],
                    "t_tipo_evento_pk"=>$query[$i]['tipo_evento_pk'],
                    "t_ds_titulo_agenda"=>$query[$i]['ds_titulo_agenda'],
                    "t_aviso_pk"=>$query[$i]['aviso_pk'],

                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_motivo_cancelamento_pk"=>$query[$i]['motivo_cancelamento_pk'],
                    "t_ds_obs_cancelamento"=>str_replace('"'," ",$query[$i]['ds_obs_cancelamento']),
                    
                    "t_dt_reagendamento"=>$query[$i]['dt_reagendamento'],
                    "t_motivo_reagendamento_pk"=>$query[$i]['motivo_reagendamento_pk'],
                    "t_ds_obs_reagendamento"=>str_replace('"'," ",$query[$i]['ds_obs_reagendamento']),
                    
                    "t_tipos_agendas_pk"=>$query[$i]['tipos_agendas_pk'],
                    
                    "t_ds_obs_classificacao"=>str_replace('"'," ",$query[$i]['ds_obs_classificacao']),
                    "t_ic_status"=>$query[$i]['ic_status'],
                    
                    "t_agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    
                    "t_dt_reagenda"=>$query[$i]['dt_reagenda'],
                    "t_dt_reagenda_visita"=>$query[$i]['dt_reagenda_visita'],
                    "t_hr_reagenda_visita"=>$query[$i]['hr_reagenda_visita'],
                    
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_ds_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_ds_obs"=>str_replace('"'," ",$query[$i]['ds_obs']),
                    "t_ds_obs_pagina"=>mb_strimwidth(str_replace('"'," ",$query[$i]['ds_obs']), 0, 60, '...' ),
                    "t_agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    "t_usuario_cadastro_pk"=>$query[$i]['usuario_cadastro_pk'],
                    "t_ds_contato"=>$query[$i]['ds_contato'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],
                    "t_cargos_pk"=>$query[$i]['cargos_pk'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_cargo"=>$query[$i]['ds_cargo'],
                    "t_atendente_pk"=>$query[$i]['atendente_pk'],
                    "t_ds_atendente"=>$query[$i]['ds_atendente'],
                    
                    "t_functions" => ""
                );
            }
        }
        else{           
            $mysql_data = [];
        }		
        break;
    }
    case 'listarQtdeAgendaVisitaData':{

        $dt_base = $_REQUEST['dt_base'];
        $dt_base_fim = $_REQUEST['dt_base_fim']; 
        $tipo_evento_pk = $_REQUEST['tipo_evento_pk']; 
        $tipos_agendas_pk = $_REQUEST['tipos_agendas_pk']; 
        $classificacao_agenda_pk = $_REQUEST['classificacao_agenda_pk']; 
        $polos_pk = $_REQUEST['polos_pk']; 
        $grupos_pk = $_REQUEST['grupos_pk']; 
        $usuarios_pk = $_REQUEST['usuarios_pk']; 
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk']; 
        $equipes_pk = $_REQUEST['equipes_pk']; 
        $atendente_pk = $_REQUEST['atendente_pk']; 
               
                
        $resultado = "";
        if($dt_base!=""){            
            $query = $agenda_visitadao->listar_qtde_agenda_visita($token,$dt_base,$dt_base_fim,$tipo_evento_pk,$tipos_agendas_pk,$classificacao_agenda_pk,$polos_pk,$grupos_pk,$usuarios_pk,$usuario_cadastro_pk,$equipes_pk,$atendente_pk);            
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(        
                    "t_registro" => $query[$i]["registro"],
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
    case 'relatorioAgendamento':{
        
        
        
        $polos_pk = $_REQUEST['polos_pk'];
        $ds_razao_social = $_REQUEST['ds_razao_social'];
        $tipos_agendas_pk = $_REQUEST['tipos_agendas_pk'];
        $ic_status_1 = $_REQUEST['ic_status_1'];
        $ic_status_2 = $_REQUEST['ic_status_2'];
        $ic_status_3 = $_REQUEST['ic_status_3'];
        $dt_agenda_ini = $_REQUEST['dt_agenda_ini'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        $dt_visita_ini = $_REQUEST['dt_visita_ini'];
        $dt_visita_fim = $_REQUEST['dt_visita_fim'];
        $mailing_pk = $_REQUEST['mailing_pk'];
        $responsavel_pk = $_REQUEST['responsavel_pk'];
        $grupos_pk = $_REQUEST['grupos_pk'];
        $resultado = "";          
        $query = $agenda_visitadao->listar_rel_agenda_visita($polos_pk,$ds_razao_social,$tipos_agendas_pk,$ic_status_1,$ic_status_2,$ic_status_3,$dt_agenda_ini,$dt_agenda_fim,$mailing_pk,$responsavel_pk,$grupos_pk,$dt_visita_ini,$dt_visita_fim);            
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(        
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_agenda"=>$query[$i]['dt_agenda'],
                    "t_dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "t_dt_agenda_visita"=>$query[$i]['dt_agenda_visita'],
                    "t_hr_agenda_visita"=>$query[$i]['hr_agenda_visita'],
                    "t_dt_termino"=>$query[$i]['dt_termino'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_ds_tipo_agenda"=>$query[$i]['ds_tipo_agenda'],
                    
                    "t_classificacao_agenda_pk"=>$query[$i]['classificacao_agenda_pk'],
                    "t_ds_tipo_evento"=>$query[$i]['ds_tipo_evento'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "t_tipo_evento_pk"=>$query[$i]['tipo_evento_pk'],
                    "t_ds_titulo_agenda"=>$query[$i]['ds_titulo_agenda'],
                    "t_aviso_pk"=>$query[$i]['aviso_pk'],

                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_motivo_cancelamento_pk"=>$query[$i]['motivo_cancelamento_pk'],
                    "t_ds_obs_cancelamento"=>$query[$i]['ds_obs_cancelamento'],
                    
                    "t_dt_reagendamento"=>$query[$i]['dt_reagendamento'],
                    "t_motivo_reagendamento_pk"=>$query[$i]['motivo_reagendamento_pk'],
                    "t_ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento'],
                    
                    "t_tipos_agendas_pk"=>$query[$i]['tipos_agendas_pk'],
                    
                    "t_ds_obs_classificacao"=>$query[$i]['ds_obs_classificacao'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    
                    "t_agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    
                    "t_dt_reagenda"=>$query[$i]['dt_reagenda'],
                    "t_dt_reagenda_visita"=>$query[$i]['dt_reagenda_visita'],
                    "t_hr_reagenda_visita"=>$query[$i]['hr_reagenda_visita'],
                    
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_ds_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
                    "t_ds_status"=>$query[$i]['ds_status'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "t_atendente_pk"=>$query[$i]['atendente_pk'],
                    
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
        $query = $agenda_visitadao->listar_por_dt_agenda($dt_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_agenda"=>$query[$i]['dt_agenda'],
                    "t_dt_termino"=>$query[$i]['dt_termino'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_classificacao_agenda_pk"=>$query[$i]['classificacao_agenda_pk'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_motivo_cancelamento_pk"=>$query[$i]['motivo_cancelamento_pk'],
                    "t_ds_obs_cancelamento"=>$query[$i]['ds_obs_cancelamento'],
                    "t_dt_reagendamento"=>$query[$i]['dt_reagendamento'],
                    "t_motivo_reagendamento_pk"=>$query[$i]['motivo_reagendamento_pk'],
                    "t_ds_obs_reagendamento"=>$query[$i]['ds_obs_reagendamento'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "t_tipos_agendas_pk"=>$query[$i]['tipos_agendas_pk'],
                    "t_ds_obs_classificacao"=>$query[$i]['ds_obs_classificacao'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_agenda_reagendamento_pk"=>$query[$i]['agenda_reagendamento_pk'],
                    "t_atendente_pk"=>$query[$i]['atendente_pk'],

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

$agenda_visitadao = null;

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
