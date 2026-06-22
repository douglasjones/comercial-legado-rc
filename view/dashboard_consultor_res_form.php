<?
//recebe o token 
$token = $_REQUEST['token'];
include_once "../inc/php/header.php";

$arrDados = array();

$arrDados = tratarToken($token);



$usuairo_logado_grupos_pk =  $arrDados['grupos_pk'];
$polos_pk_dashboard =  $arrDados['polos_pk'];
?>
<script src="dashboard_consultor_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container"> 
    <table>
        <tr>
            <td>
                <div><i class="fa fa-user" aria-hidden="true" style="font-size: 25px;" ></i> </div>
            </td>
            <td>
                &nbsp;<h5><div id="ds_usuario_logado"></div></h5>
                <input type="hidden" id="usuario_logado_pk" name="usuario_logado_pk" />
                <input type="hidden" id="usuairo_logado_grupos_pk" name="usuairo_logado_grupos_pk" value="<?=$usuairo_logado_grupos_pk?>"/>
                <input type="hidden" id="polos_pk_dashboard" name="polos_pk_dashboard" value="<?=$polos_pk_dashboard?>"/>
            </td>
        </tr>
    </table>
</div>
<br>
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>Retornos Pendentes</h4>
            </div>
        </div>
        <hr>
        <div class="modal-content">
            <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="widget green-1 animated fadeInDown" style="background-color:#ff0000;box-shadow: 5px 5px 5px grey;" >

                            <div class="widget-content padding">
                                <div class="text-center">
                                    <div class="text-box">
                                        <br>
                                        <p class="maindata"><b>RETORNOS ATRASADOS</b></p>
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h2><div id="qtde_retornos_atrasados"></div></h2>                       
                                    </div>
                                </div>    
                            </div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
               </div>                                            
            </div>
        </div> 
    </div>
</div>
<br>
<div class="container" id="exibir_retorno">     
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblRetorno">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>ocorrencias_pk</th>
                    <th>Lead_pk</th>
                    <th>Lead</th>
                    <th>DT Retorno</th>
                    <th>Tipo OC</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>  
    <hr><br>
</div>
<div class="container" id="exibir_informativo_agenda">
    <div class="row">
        <div class="col-md-12">
            <h4>Agenda de Visitas</h4>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="modal-content">
                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <div class="widget green-1 animated fadeInDown" style="background-color:#white;box-shadow: 0px 0px 0px white;" >
                                <div class="widget-content padding">
                                    <div class="text-center">
                                        <div class="text-box">
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <h1><div id="qtde_registro_agenda"></div></h1>                       
                                        </div>
                                    </div>    
                                </div>
                                <div class="widget-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!--GRAFICO 1---->
                        <div class="col-lg-4 col-md-3">
                            <div id="classificacao"></div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!--GRAFICO 2---->
                        <div class="col-lg-6 col-md-5">
                            <div id="agendado_por"></div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>                                            
            </div>
        </div> 
    </div>
    <br>
    <hr>
</div>
<!--AGENDA DE VISITA-->
<div id="exibir_agenda_visita">
    <?  include_once 'inc_dashboard_agenda_visita_res_form.php';?>
</div> 

<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>Propostas</h4>
            </div>
            <hr>
        </div>
        
        <div class="modal-content">
            <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="widget green-1 animated fadeInDown" style="background-color:#c3c3c3;box-shadow: 5px 5px 5px grey;" >

                            <div class="widget-content padding">
                                <div class="text-center">
                                    <div class="text-box">
                                        <br>
                                        <p class="maindata"><b>50%</b></p>
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h2><div id="qtde_proposta50"></div></h2>  
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h5><div id="vl_total50"></div></h5> 
                                    </div>
                                </div>    
                            </div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget green-1 animated fadeInDown" style="background-color:#ffa64d;box-shadow: 5px 5px 5px grey;" >

                            <div class="widget-content padding">
                                <div class="text-center">
                                    <div class="text-box">
                                        <br>
                                        <p class="maindata"><b>75%</b></p>
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h2><div id="qtde_proposta75"></div></h2>  
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h5><div id="vl_total75"></div></h5> 
                                    </div>
                                </div>    
                            </div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget green-1 animated fadeInDown" style="background-color:#66cdaa;box-shadow: 5px 5px 5px grey;" >

                            <div class="widget-content padding">
                                <div class="text-center">
                                    <div class="text-box">
                                        <br>
                                        <p class="maindata"><b>Fechada</b></p>
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h2><div id="qtde_proposta_fechada"></div></h2>  
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h5><div id="vl_total_fechada"></div></h5> 
                                    </div>
                                </div>    
                            </div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget green-1 animated fadeInDown" style="background-color:#ff7373;box-shadow: 5px 5px 5px grey;" >

                            <div class="widget-content padding">
                                <div class="text-center">
                                    <div class="text-box">
                                        <br>
                                        <p class="maindata"><b>Cancelada</b></p>
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h2><div id="qtde_proposta_cancelada"></div></h2>  
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h5><div id="vl_total_cancelada"></div></h5>  
                                    </div>
                                </div>    
                            </div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
               </div>                                            
            </div>
        </div> 
    </div>
</div>
<br>
<div class="container">    
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblPropostasDashboard">
            <thead>
                <tr>
                    <th>Lead</th>
                    <th>Responsável</th>
                    <th>DT Cad</th>
                    <th>DT<br>Envio</th>
                    <th>DT Previs<br>Fechamento</th>
                    <th>DT<br>Fechamento</th>
                    <th>VL Total</th>
                    <th>Time</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>  
</div>
<div class="container">    
    <form id="form_proposta" class="form">
        <div class="modal fade bd-example-modal-lg" id="janela_proposta" data-backdrop='static'>
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contatosLabel">Nova Proposta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <input type='hidden' id='propostas_pk' name='propostas_pk'/>
                        <input type='hidden' id='agenda_visita_proposta_pk' name='agenda_visita_proposta_pk'/>
                        <input type='hidden' id='propostas_pai_pk' name='propostas_pai_pk'/>
                        <input type='hidden' id='leads_pk_proposta' name='leads_pk_proposta'/>
                        <input type='hidden' id='polos_pk_proposta' name='polos_pk_proposta'/>
                    </div>
                    <br>                    
                    <div class="modal-content bd-example-modal-lg-12">
                        <div class="modal-body" >   
                            <div class="row">                                
                                <div class='col-md-4'>
                                    <label for='dt_inicio'>Versão: </label>
                                    <label id="n_versao"></label>
                                </div>                                                                                
                            </div>                             
                            <br>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for='ds_equipe'>Operadora:&nbsp;</label>
                                    <select class='form-control form-control-sm' id='operador_pk' name='operador_pk'>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblPropostaItens">
                                        <thead>
                                            <tr>
                                                <th>Cód</th>
                                                <th>Prod/Serv</th>
                                                <th>Qtde.Prod</th>
                                                <th>Vl. Unitario</th>
                                                <th>Vl. Total</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">&nbsp;</th>                                                
                                                <th><div id='qtde_itens_proposta'></div></th>
                                                <th colspan="1"></th>                                                
                                                <th><div id='vl_total_proposta'></div></th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </tfoot>   
                                    </table>
                                </div>
                            </div>  
                            <div class='row'>
                                <div class='col-md-12' align="center"> 
                                    <button type="button" class="btn" id="cmdIncluirPropostaItens" name="cmdIncluirPropostaItens">Incluir</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">                               
                                <div class='col-md-4'>
                                    <label for='dt_envio'>Dt de Envio Cliente: </label>
                                    <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_envio' name='dt_envio'>
                                </div>
                                <div class='col-md-4'>
                                    <label for='dt_previsao_fechamento'>Dt Previsão Fechamento: </label>
                                    <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_previsao_fechamento' name='dt_previsao_fechamento'>
                                </div>  
                                <div class='col-md-4'>
                                    <label for='dt_inicio_contrato'>Proposta Fechada:</label>
                                    <div class="text-left">
                                        <input type='checkbox' class='form-control form-control-sm' maxlength="10"  id='dt_fechamento' name='dt_fechamento'>
                                    </div>
                                </div>  
                            </div>                 
                            <div class="row">                               
                                  
                                <div class='col-md-4'>
                                    <label for='dt_inicio_contrato'>Cancelar Proposta:</label>
                                    <div class="text-left">
                                        <input type='checkbox' class='form-control form-control-sm' maxlength="10"  id='dt_cancelamento' name='dt_cancelamento'>
                                    </div>
                                </div>  
                                <div class='col-md-4' id="exibir_motivo_cancelamento">
                                    <label for='dt_previsao_fechamento'>Motivo Cancelamento: </label>
                                    <input type='text' class='form-control form-control-sm' maxlength="10"  id='ds_obs_motivo_cancelamento' name='ds_obs_motivo_cancelamento'>
                                </div>
                            </div>                 
                            <div class="row">  
                                <div class='col-md-4'>
                                    <label for='dt_validade'>Dt Validade Proposta: </label>
                                    <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_validade' name='dt_validade'>
                                </div>                                                                             
                            </div>
                            <div class="row">                               
                                <div class='col-md-12'>
                                    <label for='ds_obs_proposta'>Observação: </label>        
                                    <textarea  class=" form-control form-control-file" id="ds_obs_proposta" name="ds_obs_proposta"></textarea>
                                </div>                                                                 
                            </div>  
                            <div class='row'>
                                <div class='col-md-4'> 
                                    &nbsp;
                                </div>
                            </div>                          
                        </div>
                    </div>                   
                    <br>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn" id="cmdEnviarProposta"  name="cmdEnviarProposta">Enviar</button>
                        </div>
                    </div>  
                </div> 
            </div>
        </div>    
    </form>
</div>
<div class="container">
    <br>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4>Carteira Lead</h4>
        </div>
    </div>
    <hr>
    <div class="row">                                          
        <div class="col-sm-12"> 
             <div id="container"></div>                   
         </div>                                            
    </div>
</div>

<div class="container" id="exibir_informativo_agenda"> 
    <br>
        <div class="row">
            <div class="col-md-12">
                <h4>Oportunidades Futuras</h4>
            </div>
        </div>
    <hr>
     <div class="row">
        <div class="container">
            <div class="modal-content">
                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                    <div class="row">                
                       <div class="col-sm-12 text-center"> 
                            <h5><b>Oportunidades Futuras</b></h5>                     
                       </div>                   
                    </div>                                            
                    <div class="row">                                          
                       <div class="col-sm-12"> 
                            <div id="graf_oportunidades_futuras"></div>                   
                        </div>                                            
                    </div>
                 </div> 
             </div>
         </div>    
     </div>
    <br>
    <hr><br>
</div> 
<!--div class="container">     
    <div class="row">
        <div class="col-md-12">
            <h4>Leads</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblLead">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Lead</th>
                    <th>Operadora</th>
                    <th>Data Vencimento</th>
                    <th>Qtde Voz</th>
                    <th>Qtde Dados</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
    <div class="container">    
        <div class="modal fade bd-example-modal-lg" id="janela_operador_atual" >
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contatosLabel">Operadoras Atual</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                                    
                        <div>
                            <div class="row" id="ic_grid">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap " style="width:80%" id="tblLeadOperador">
                                        <thead >
                                            <tr>
                                            <th>Cód</th>
                                            <th>Operador</th>
                                            <th>Operador_pk</th>
                                            <th>Cliente</th>
                                            <th>icCliente</th>
                                            <th>Base</th>
                                            <th>icBase</th>
                                            <th>Dt.Ativação</th>
                                            <th>Dt.Venc.</th>
                                            <th>Custo Atual</th>
                                            <th>Qtde. Voz</th>
                                            <th>Qtde. Dados</th>
                                            <th>Status</th>
                                            <th>icStatus</th>
                                            <th>Tempo Contrato (Meses)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>  
    <hr><br>
</div-->

<!--div class="row">
    <div class="container">
        <div class="modal-content">
            <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Agendas Visita</h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="widget green-1 animated fadeInDown" style="background-color:#c3c3c3;box-shadow: 5px 5px 5px grey;" >

                            <div class="widget-content padding">
                                <div class="text-center">
                                    <div class="text-box">
                                        <br>
                                        <p class="maindata"><b>VISITAS DE HOJE</b></p>
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h2><div id="qtde_visitas_para_hj"></div></h2>                       
                                    </div>
                                </div>    
                            </div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="widget green-1 animated fadeInDown" style="background-color:#66CDAA;box-shadow: 5px 5px 5px grey;">
                            <div class="widget-content padding">
                                <div class="text-center">
                                    <div class="text-box">
                                        <br>
                                        <p class="maindata"><b>VISITAS AGENDADAS HOJE</b></p>
                                        <li style='list-style-type: none;'>
                                            <hr style='height:2px; border:none; color:#333333; background-color:#333333; margin-top: 0px; margin-bottom: 0px;'/>
                                        </li>
                                        <h2><div id="qtde_visitas_agendas_hj"></div></h2>                        
                                    </div>
                                </div>    
                            </div>
                            <div class="widget-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
               </div>                                            
            </div>
        </div> 
    </div>
</div-->

<!--MODAL RETORNO-->
<div class="container">    
    <form id="form_ocorrencia" class="form">
        <div class="modal fade bd-example-modal-lg" id="janela_ocorrencia" >
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Nova Ocorrência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                                    
                    <div class="row">
                        
                        <input type='hidden' id='ocorrencias_pk' name='ocorrencias_pk'/>
                        <input type='hidden' id='ic_fechar_ocorrencia_auto' name='ic_fechar_ocorrencia_auto'/>
                        
                        <div class='col-md-2'>
                            &nbsp;                                             
                        </div>
                        <div class='col-md-6'>
                            <label for='tipo_ocorrencia_pk'>Tipo Ocorrência&nbsp;</label>
                            <select class='form-control form-control-sm'  id='tipo_ocorrencia_pk' name='tipo_ocorrencia_pk' />
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>                                                             
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="ds_ocorrencia">Descrição Ocorrência:</label>
                                <textarea class=" form-control form-control-file" id="ds_ocorrencia" name="ds_ocorrencia"></textarea>
                            </div>
                        </div>                                                             
                    </div> 
                    
                    <div class="row">
                        <div class='col-md-2'>
                             
                        </div>
                        <div class='col-md-3'>
                            Fechar Ocorrência:
                        </div>                                                              
                        <div class='col-md-1'>
                            <input type='checkbox' class='form-control form-control-sm' maxlength="10"  id='dt_fechamento' name='dt_fechamento'>
                        </div>                                                              
                    </div>
                    
                    <div class="row">
                        <div class='col-md-2'>
                             
                        </div>
                        <div class='col-md-3'>
                            Agendar Retorno:
                        </div>                                                              
                        <div class='col-md-1'>
                            <input type='hidden' id='agenda_retorno_pk' name='agenda_retorno_pk'/>
                            <input type='checkbox' class='form-control form-control-sm' maxlength="10"  id='agenda_retorno' name='agenda_retorno'>
                        </div>                                                              
                    </div>
                    <!--Agenda Retornos-->
                    <div id='agenda_visible'>
                        <hr>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="dt_retornoa">Data Retorno:</label>
                                    <input type='text' class=" form-control form-control-file" id="agenda_dt_retorno" name="agenda_dt_retorno"/>
                                </div>
                            </div>  
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="hr_retorno">Hora Retorno:</label>
                                    <input type='text' class=" form-control form-control-file" id="agenda_hr_retorno" name="agenda_hr_retorno"/>
                                </div>    
                            </div>  
                        </div>                 
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                      
                            <div class='col-md-2'>
                                <label for='ic_usuario'>Usuário:&nbsp;</label>
                                <input type='radio' class=" form-control form-control-file" id="ic_usuario" name="ic_usuario"/>
                            </div>
                                           <div class='col-md-2'>
                                <label for='ic_equipe'>Equipe:&nbsp;</label>
                                <input type='radio' class=" form-control form-control-file" id="ic_equipe" name="ic_equipe"/>
                            </div>   
                            <div class='col-md-4'>
                                <div id='agenda_responsavel_visible'>                                   
                                    <label for='agenda_responsavel_pk'>Lista Usuários&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='agenda_responsavel_pk' name='agenda_responsavel_pk' />
                                        <option></option>
                                    </select>                                   
                                </div>    
                                <div id='agenda_equipe_visible'> 
                                    <label for='agenda_equipes_pk'>Lista Equipes&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='agenda_equipes_pk' name='agenda_equipes_pk' />
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>        
                    </div>                    
                    <!--EDIÇÃO RETORNO-->
                    <div id='edit_agenda_visible'>
                        <hr>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Data Retorno:</label>
                                    <div class=" form-control form-control-file" disabled id="edit_agenda_dt_retorno" name="edit_agenda_dt_retorno"></div>
                                </div>
                            </div> 
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Hora Retorno:</label>
                                    <div class=" form-control form-control-file" disabled id="edit_agenda_hr_retorno" name="edit_agenda_hr_retorno"></div>
                                </div>
                            </div>        
                        </div>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                      
                            <div class='col-md-3'>
                                <label for='ic_usuario'>Novo Retorno:&nbsp;</label>
                                <button type="button" class="btn btn-secondary"id="n_retorno" name="n_retorno" >Novo Retorno</button>
                            </div>
                        </div>
                        <div id='edit_agenda_responsavel_visible'>
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>                                                             
                                <div class='col-md-4'>
                                    <label for='agenda_responsavel_pk'>Usuário Responsável&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='edit_agenda_responsavel_pk' name='edit_agenda_responsavel_pk' />
                                        <option></option>
                                    </select>
                                </div>                                                             
                            </div>
                        </div>
                        <div id='edit_agenda_equipe_visible'>
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>                                                             
                                <div class='col-md-4'>
                                    <label for='agenda_equipes_pk'>Equipe Responsável&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='edit_agenda_equipes_pk' name='edit_agenda_equipes_pk' />
                                        <option></option>
                                    </select>
                                </div>                                                             
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="agenda_ds_retorno">Descrição Retorno:</label>
                                    <textarea disabled class=" form-control form-control-file" id="agenda_ds_retorno" name="agenda_ds_retorno"></textarea>
                                </div>
                            </div>                             
                        </div>
                        <div class="row">
                            <div class='col-md-2'>

                            </div>
                            <div class='col-md-3'>
                                Fechar Retorno:
                            </div>                                                              
                            <div class='col-md-1'>
                                <input type='checkbox' class='form-control form-control-sm' maxlength="10"  id='dt_termino_retorno' name='dt_termino_retorno'>
                            </div>                                                              
                        </div>
                    </div>  
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn" id="cmdEnviarOcorrencia"  name="cmdEnviarOcorrencia">Enviar</button>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    </form>
</div>

<?
include_once "../inc/php/footer.php";
?>
