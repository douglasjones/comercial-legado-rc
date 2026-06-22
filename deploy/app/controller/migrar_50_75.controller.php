<?
set_time_limit(6000000);
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/migrar.dao.php";

require_once "../model/agenda_visita.dao.php";
require_once "../model/agenda_visita.class.php";

require_once "../model/processo.dao.php";
require_once "../model/processo.class.php";

require_once "../model/processo_default_etapa.dao.php";
require_once "../model/processo_default_etapa.class.php";

require_once "../model/ocorrencia.dao.php";
require_once "../model/ocorrencia.class.php";

require_once "../model/tipo_ocorrencia.dao.php";
require_once "../model/tipo_ocorrencia.class.php";

require_once "../model/lead.dao.php";
require_once "../model/lead.class.php";

require_once "../model/proposta.dao.php";
require_once "../model/proposta.class.php";

require_once "../model/contrato.dao.php";
require_once "../model/contrato.class.php";

require_once "../model/operador.dao.php";
require_once "../model/operador.class.php";

require_once "../model/etapa_contrato.dao.php";
require_once "../model/etapa_contrato.class.php";

require_once "../model/contrato_item.dao.php";
require_once "../model/contrato_item.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];

$migrardao = new migrardao();
$migrardao->setToken($token);


$processodao = new processodao();
$processodao->setToken($token);

$processo_default_etapadao = new processo_default_etapadao();
$processo_default_etapadao->setToken($token);

$ocorrenciadao = new ocorrenciadao();
$ocorrenciadao->setToken($token);

$tipo_ocorrenciadao = new tipo_ocorrenciadao();
$tipo_ocorrenciadao->setToken($token);

$leaddao = new leaddao();
$leaddao->setToken($token);

$propostadao = new propostadao();
$propostadao->setToken($token);

$contratodao = new contratodao();
$contratodao->setToken($token); 

$operadordao = new operadordao();
$operadordao->setToken($token); 

$etapa_contratodao = new etapa_contratodao();
$etapa_contratodao->setToken($token); 

$agenda_visitadao = new agenda_visitadao();
$agenda_visitadao->setToken($token); 

$contrato_itemdao = new contrato_itemdao();
$contrato_itemdao->setToken($token); 


switch($job){
    case 'salvar_migracao_50_75':{
        //USUARIOS
        $pk_old = $_REQUEST['pk_old'];
        $porcentagem_pk = $_REQUEST['porcentagem_pk'];
        
        $query = $leaddao->listarPorPkOld($pk_old);
        
        if(count($query) > 0){
            for($i=0;$i<count($query);$i++){

                $processos_pk = $migrardao->salvarProcessos($query[$i]['pk']);
                $processos_etapas_pk = $migrardao->pegarProcessoEtapa($processos_pk);
                
                
                //50%
                if($porcentagem_pk==1){
                    
                    $operador_pk = $operadordao->listar_por_polo();
                    
                    $proposta = $propostadao->carregarPorPk("");
                    $proposta->setn_versao("1.0");
                    $proposta->setvl_total('0.00');     
                    $proposta->setdt_validade("");  
                    $proposta->setprocessos_etapas_pk($processos_etapas_pk);
                    $proposta->setpolos_pk("");
                    $proposta->setleads_pk($query[$i]['pk']);
                    $proposta->setoperador_pk($operador_pk[0]['pk']);

                    $proposta_pk = $propostadao->salvar($proposta);
                    $processodao->updClassificacao($processos_pk,2);
                }
                //75%
                if($porcentagem_pk==2){
                    
                    $contrato = $contratodao->carregarPorPk("");
                    $contrato->setprocessos_etapas_pk($processos_etapas_pk);
                    $contrato->setic_tipo_contrato(1);
                    $contrato->setpolos_pk("");
                    $contrato_pk = $contratodao->salvar($contrato);
                    
                    $processodao->updClassificacao($processos_pk,3);
                }
                //80%
                if($porcentagem_pk==3){
 
                    $contrato = $contratodao->carregarPorPk("");
                    $contrato->setprocessos_etapas_pk($processos_etapas_pk);
                    $contrato->setic_tipo_contrato(1);
                    $contrato->setpolos_pk("");
                    $contrato_pk = $contratodao->salvar($contrato);
                    
                    $query_etapa = $etapa_contratodao->listarPorPk80();
                    
                    $contratodao->adicionarContratoEtapas("",$contrato_pk,$query_etapa[0]['pk'],"","");
                    $processodao->updClassificacao($processos_pk,5);

                }
                //90%
                if($porcentagem_pk==4){
                    
                    $contrato = $contratodao->carregarPorPk("");
                    $contrato->setprocessos_etapas_pk($processos_etapas_pk);
                    $contrato->setic_tipo_contrato(1);
                    $contrato->setpolos_pk("");
                    $contrato_pk = $contratodao->salvar($contrato);
                    
                    $query_etapa = $etapa_contratodao->listarPorPk90();
               
                    $contratodao->adicionarContratoEtapas("",$contrato_pk,$query_etapa[0]['pk'],"","");
                    $processodao->updClassificacao($processos_pk,6);

                }
                //Cliente%
                if($porcentagem_pk==5){
                    
                    $contrato = $contratodao->carregarPorPk("");
                    $contrato->setprocessos_etapas_pk($processos_etapas_pk);
                    $contrato->setic_tipo_contrato(1);
                    $contrato->setpolos_pk("");
                    $contrato_pk = $contratodao->salvar($contrato);
                    
                    $query_etapa = $etapa_contratodao->listarPorPkCliente();
               
                    $contratodao->adicionarContratoEtapas("",$contrato_pk,$query_etapa[0]['pk'],"","");
                    $processodao->updClassificacao($processos_pk,4);
                    
                    $contratodao->icClienteLead(2, $query[$i]['pk']);
                    

                }
                //Sem Insteresse
                if($porcentagem_pk==6){
                    
                    $querytipo_ocorrencia = $tipo_ocorrenciadao->listarTipoOcSemInteresse();
                    $querymotivo_sem_interesse = $ocorrenciadao->listarMotivoSemInteresseMigracao();
                    $ocorrencia = $ocorrenciadao->carregarPorPk("");
                    $ocorrencia->setds_ocorrencia("Migração");
                    $ocorrencia->settipos_ocorrencias_pk($querytipo_ocorrencia[0]['pk']);
                    $ocorrencia->setdt_fechamento(2);
                    $ocorrencia->setleads_pk($query[$i]['pk']);
                    $ocorrencia->setmotivo_sem_interesse_pk($querymotivo_sem_interesse[0]['pk']);
                    $ocorrencia->setds_motivo_sem_interesse("Migração");

                    $ocorrencia_pk = $ocorrenciadao->salvar($ocorrencia); 
                    

                }
                //Não Contactado
                if($porcentagem_pk==7){
                   
                    $del_ocorrencia = $ocorrenciadao->listarPorLeadsPk($query[$i]['pk']);
                    if(count($del_ocorrencia) > 0){
                        for($p = 0; $p < count($del_ocorrencia); $p++){
                            $ocorrenciadao->excluirRetorno($del_ocorrencia[$p]['pk']);
                            $ocorrenciadao->excluirOcMigracao($del_ocorrencia[$p]['pk']);
                        }
                    }
                    
                    
                    
                    $processo = $processodao->listarPorLeadsPk($query[$i]['pk']);
                    if(count($processo) > 0){
                        for($p = 0; $p < count($processo); $p++){
                            $contrato = $contratodao->listar_contrato_lead_processo($query[$i]['pk'],$processo[$p]['pk']);
                            $agenda = $agenda_visitadao->listar_agenda_visita_lead_processo($query[$i]['pk'],$processo[$p]['pk']);
                            $proposta = $propostadao->listar_proposta_lead_processo($query[$i]['pk'],$processo[$p]['pk']);




                            if(count($contrato) > 0){
                                for($i = 0; $i < count($contrato); $i++){
                                    $contrato_itemdao->excluirPorContrato($contrato[$i]['pk']);
                                }
                            }

                            if(count($agenda) > 0){
                                for($i = 0; $i < count($agenda); $i++){
                                    $agenda_visitadao->excluirResponsavelPk($agenda[$i]['pk']);
                                }
                            }
                            if(count($proposta) > 0){
                                for($i = 0; $i < count($proposta); $i++){
                                    $propostadao->excluirItemPropostaPk($proposta[$i]['pk']);
                                }
                            }

                                $query_p = $processodao->listarEtapasPorPk($processo[$p]['pk']);
                                if(count($query) > 0){
                                    for($i = 0; $i < count($query_p); $i++){
                                        
                                        $processodao->excluirContratos($query_p[$i]["pk"]);
                                        $processodao->excluirAgenda($query_p[$i]["pk"]);
                                        $processodao->excluirPropostas($query_p[$i]["pk"]);
                                    }
                                }
                                $processodao->excluirProcessosEtapasPk($processo[$p]['pk']);
                                $processodao->excluirProcessoMigracao($processo[$p]['pk']);
                        }
                    
                    }
                }
                //Contactado
                if($porcentagem_pk==8){
                   
                    $ocorrencia = $ocorrenciadao->listarPorLeadsPk($query[$i]['pk']);
                    
                    if(count($ocorrencia)==0){
                        $querytipo_ocorrencia = $tipo_ocorrenciadao->listarTipoOcMigracao();
                        $ocorrencia = $ocorrenciadao->carregarPorPk("");
                        $ocorrencia->setds_ocorrencia("Migração");
                        $ocorrencia->settipos_ocorrencias_pk($querytipo_ocorrencia[0]['pk']);
                        $ocorrencia->setdt_fechamento(2);
                        $ocorrencia->setleads_pk($query[$i]['pk']);

                        $ocorrencia_pk = $ocorrenciadao->salvar($ocorrencia); 
                    }
                    
                    
                    
                    
                    
                    $processo = $processodao->listarPorLeadsPk($query[$i]['pk']);
                    if(count($processo) > 0){
                        for($p = 0; $p < count($processo); $p++){
                            $contrato = $contratodao->listar_contrato_lead_processo($query[$i]['pk'],$processo[$p]['pk']);
                            $agenda = $agenda_visitadao->listar_agenda_visita_lead_processo($query[$i]['pk'],$processo[$p]['pk']);
                            $proposta = $propostadao->listar_proposta_lead_processo($query[$i]['pk'],$processo[$p]['pk']);




                            if(count($contrato) > 0){
                                for($i = 0; $i < count($contrato); $i++){
                                    $contrato_itemdao->excluirPorContrato($contrato[$i]['pk']);
                                }
                            }

                            if(count($agenda) > 0){
                                for($i = 0; $i < count($agenda); $i++){
                                    $agenda_visitadao->excluirResponsavelPk($agenda[$i]['pk']);
                                }
                            }
                            if(count($proposta) > 0){
                                for($i = 0; $i < count($proposta); $i++){
                                    $propostadao->excluirItemPropostaPk($proposta[$i]['pk']);
                                }
                            }

                                $query_p = $processodao->listarEtapasPorPk($processo[$p]['pk']);
                                if(count($query) > 0){
                                    for($i = 0; $i < count($query_p); $i++){
                                        $ocorrencia = $ocorrenciadao->listar_ocorrencia_processo_lead($query[$i]["pk"],$query_p[$i]["pk"]);

                                        if(count($ocorrencia) > 0){
                                            for($j = 0; $j < count($ocorrencia); $j++){
                                                $ocorrenciadao->excluirRetornos($ocorrencia[$j]['pk']);
                                            }
                                        }


                                        $processodao->excluirContratos($query_p[$i]["pk"]);
                                        $processodao->excluirAgenda($query_p[$i]["pk"]);
                                        $processodao->excluirPropostas($query_p[$i]["pk"]);
                                        $processodao->excluirOcorrencias($query_p[$i]["pk"]);
                                    }
                                }
                                $processodao->excluirProcessosEtapasPk($processo[$p]['pk']);
                                $processodao->excluir($processo[$p]['pk']);
                        }
                    
                    }
                }
            }
        }
        
        



        $result  = 'success';
        $message = 'Registro salvo com sucesso.';

        break;
    }
}

$dia_semanadao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = html_entity_decode(json_encode($data));
echo $json_data;


?>
