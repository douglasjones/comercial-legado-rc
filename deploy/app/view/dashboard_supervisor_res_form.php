<?
//recebe o token 
$token = $_REQUEST['token'];
require_once "../inc/php/header.php";

$arrDados = array();

$arrDados = tratarToken($token);

$usuairo_logado_grupos_pk =  $arrDados['grupos_pk'];
?>
<script src="dashboard_supervisor_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container"> 
    <table>
        <tr>
            <td>
                <div><i class="fa fa-user" aria-hidden="true" style="font-size: 25px;" ></i> </div>
                
            </td>
            <td>
               <h5><div id="ds_usuario_logado"></div></h5>
            </td>
        </tr>
        <tr>
            <td>
                Membro Equipe:
            </td>
            <td>
                <select class='form-control form-control-sm'  id='membro_equipe_pk' name='membro_equipe_pk' >
                    <option value=" "></option>
                </select> 
            </td>
        </tr>
    </table>
</div>
<br>
<div class="container"> 
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
                       <div class="col-sm-4"> 
                           &nbsp;
                        </div>                                            
                       <div class="col-sm-2"> 
                           <label>Data Inicio</label>
                           <input class="form-control form-control-sm" id="dt_ini_of">
                        </div>                                            
                       <div class="col-sm-2"> 
                           <label>Data Fim</label>
                           <input class="form-control form-control-sm" id="dt_fim_of">
                        </div>                                            
                    </div>
                    <br>
                    <div class="row">                                                                                    
                       <div class="col-sm-12" align="center"> 
                           <button type="button" class="btn btn-secondary" id="filtrar_of">Filtrar</button>
                           
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

    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblOportunidadesFuturas">
            <thead>
                <tr>
                    <th>Lead</th>
                    <th>Operadora</th>
                    <th>Usuário</th>
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
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg"  id="janela_agenda_visita_lead">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content " >
                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">    
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contratosLabel">Operadora</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <br>
                     <div class='row'>
                         <div class="form-group">
                             <label class="col-md-12 control-label"><b>ID Lead: </b></label>
                         </div>
                         <div class='col-md-2'>
                             <div class=' leads_pk_cad'></div>
                         </div>
                     </div>
                     <div class='row'>
                         <div class="form-group">
                             <label class="col-md-12 control-label"><b>Polo: </b></label>
                         </div>
                         <div class='col-md-3'>
                             <div class=' ds_polo_cad'></div>
                         </div>
                     </div>
                     <div class='row'>
                         <div class="form-group">
                             <label class="col-md-12 control-label"><b>Tipo Pessoa: </b></label>
                         </div>
                         <div class='col-md-2'>
                             <div class=' ds_tipo_pessoa_cad'></div>
                         </div>
                     </div>
                     <div class='row'>
                         <div class="form-group">
                             <label class="col-md-12 control-label"><b>Lead: </b></label>
                         </div>
                         <div class='col-md-2'>
                             <div class=' ds_lead_cad'></div>
                         </div>
                     </div>
                     <br>
                     <div>
                         <div class="row" id="ic_grid">
                             <div class="col-md-12">
                                 <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblLeadOperador">
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
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                 </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg"  id="janela_agenda_visita_ocorrencia">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" >
                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contratosLabel">Ocorrências</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>ID Lead: </b></label>
                        </div>
                        <div class='col-md-2'>
                            <div class=' leads_pk_cad'></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>Polo: </b></label>
                        </div>
                        <div class='col-md-3'>
                            <div class=' ds_polo_cad'></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>Tipo Pessoa: </b></label>
                        </div>
                        <div class='col-md-2'>
                            <div class=' ds_tipo_pessoa_cad'></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>Lead: </b></label>
                        </div>
                        <div class='col-md-2'>
                            <div class=' ds_lead_cad'></div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-content bd-example-modal-lg-12">
                        <div class="modal-body" >
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblOcorrencia">
                                        <thead>
                                            <tr>
                                                <th>Cód</th>             
                                                <th>Dt Cad OC</th>
                                                <th>Tipo OC</th>
                                                <th>Tipo Ocorrência_pk</th>
                                                <th>Descr OC</th> 
                                                <th>Usuário Cad</th>
                                                <th>Dt Fech OC</th>                    
                                                <th>Agendado Para</th>
                                                <th>Dt Retorno</th>
                                                <th>Descr Retorno</th>
                                                <th>Dt Fech Retorno</th>                                     
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4>Carteira Lead Status</h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblCarteiraLeadStatus">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Sem Interesse</th>
                    <th>Não Contactado</th>
                    <th>Contactado</th>
                    <th>Qtde 25%</th>
                    <th>Qtde 50%</th>
                    <th>Qtde 75%</th>
                    <th>Qtde 80%</th>
                    <th>Qtde 90%</th>
                    <th>Cliente</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4>Retornos Pendentes</h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div id="grafic_retorno_pendente"></div>
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
    <br>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblRetornoPendente">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>24 Horas</th>
                    <th>48 Horas</th>
                    <th>72 Horas</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4>Agenda de Visitas</h4>
        </div>
    </div>
    <hr>
     <div class="row">
        <div class="container">
            <div class="modal-content">
                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                    <div class="row">                
                       <div class="col-sm-12 text-center"> 
                            <h5><b>Agenda de Visitas</b></h5>                     
                       </div>                   
                    </div>                                            
                    <div class="row">                                          
                       <div class="col-sm-4"> 
                           &nbsp;
                        </div>                                            
                       <div class="col-sm-2"> 
                           <label>Data Inicio</label>
                           <input class="form-control form-control-sm" id="dt_ini_ag">
                        </div>                                            
                       <div class="col-sm-2"> 
                           <label>Data Fim</label>
                           <input class="form-control form-control-sm" id="dt_fim_ag">
                        </div>                                            
                    </div>
                    <br>
                    <div class="row">                                                                                    
                       <div class="col-sm-12" align="center"> 
                           <button type="button" class="btn btn-secondary" id="filtrar_ag">Filtrar</button>
                           
                        </div>                                                                                      
                    </div>
                    <br>
                    <div class="row">
                        <div class="container">
                            <div class="modal-content">
                                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2">
                                            <div class="widget green-1 animated fadeInDown" style="background-color:#white;box-shadow: 0px 0px 0px white;" >
                                                <!--div class="widget-content padding">
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
                                                </div-->
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
                 </div> 
             </div>
         </div>    
     </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4>Produtividade</h4>
        </div>
    </div>
    <hr>
     <div class="row">
        <div class="container">
            <div class="modal-content">
                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                    <div class="row">                
                       <div class="col-sm-12 text-center"> 
                            <h5><b>Produtividade</b></h5>                     
                       </div>                   
                    </div>                                            
                    <br>
                    <div class="row">
                        <div class="container">
                            <div class="modal-content">
                                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2">
                                            <div class="widget green-1 animated fadeInDown" style="background-color:#white;box-shadow: 0px 0px 0px white;" >
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
                                            <div id="prospeccao"></div>
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
                                            <div id="oportunidades_futuras_pizza"></div>
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
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2">
                                            <div class="widget green-1 animated fadeInDown" style="background-color:#white;box-shadow: 0px 0px 0px white;" >
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
                                        <!--GRAFICO 3---->
                                        <div class="col-lg-4 col-md-3">
                                            <div id="retornos_respondidos"></div>
                                            <div class="widget-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        &nbsp;
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <!--GRAFICO 4---->
                                        <div class="col-lg-6 col-md-5">
                                            <div id="ocorrencia"></div>
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
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2">
                                            <div class="widget green-1 animated fadeInDown" style="background-color:#white;box-shadow: 0px 0px 0px white;" >
                                                <!--div class="widget-content padding">
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
                                                </div-->
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
                                        <!--GRAFICO 5---->
                                        <div class="col-lg-4 col-md-3">
                                            <div id="processo"></div>
                                            <div class="widget-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        &nbsp;
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <!--GRAFICO 6---->
                                        <div class="col-lg-6 col-md-5">
                                            <div id="agenda_visita_pizza"></div>
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
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2">
                                            <div class="widget green-1 animated fadeInDown" style="background-color:#white;box-shadow: 0px 0px 0px white;" >
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
                                       <!--GRAFICO 7---->
                                        <div class="col-lg-4 col-md-3">
                                            <div id="proposta"></div>
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
                    </div>
                    
                    </div>
                 </div> 
             </div>
         </div>    
     </div>
    <br>   
</div>  

<?
require_once "../inc/php/footer.php";
?>
