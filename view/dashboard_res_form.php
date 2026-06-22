<?
//recebe o token 
$token = $_REQUEST['token'];
include_once "../inc/php/header.php";

$arrDados = array();

$arrDados = tratarToken($token);


$usuairo_logado_grupos_pk =  $arrDados['grupos_pk'];
$polos_pk_dashboard =  $arrDados['polos_pk'];
?>
<script src="dashboard_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container"> 
    <table>
        <tr>
            <td>
                <div><i class="fa fa-user" aria-hidden="true" style="font-size: 25px;" ></i> </div>
            </td>
            <td>
                &nbsp;<h5><div id="ds_usuario_logado"></div></h5>
                <input type="hidden" id="usuairo_logado_grupos_pk" name="usuairo_logado_grupos_pk" value="<?=$usuairo_logado_grupos_pk?>"/>
                <input type="hidden" id="polos_pk_dashboard" name="polos_pk_dashboard" value="<?=$polos_pk_dashboard?>"/>
            </td>
        </tr>
    </table>
</div>
<div class="container" id="exibir_informativo_agenda"> 
    <div class="row">
        <div class="container">
             
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
    </div>
     <div class="row">
        <div class="container">
            <div class="modal-content">
                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                    <div class="row">                
                       <div class="col-sm-12 text-center"> 
                            <h5><b>Agendamento</b></h5>                     
                       </div>                   
                    </div>                                            
                    <div class="row">                                          
                       <div class="col-sm-12"> 
                            <div id="graf_agenda"></div>                   
                        </div>                                            
                     </div>
                 </div> 
             </div>
         </div>    
     </div>
    <br>
</div> 
<div class="container" id="exibir_retorno">     
    <div class="row">
        <div class="col-md-12">
            <h4>Retornos Pendentes</h4>
        </div>
    </div>
 
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
<!--AGENDA DE VISITA-->
<div id="exibir_agenda_visita">
    <?  include_once 'inc_dashboard_agenda_visita_res_form.php';?>
</div> 
<!--PROPOSTA-->
<div id="exibir_proposta_dashboard">
    <?  include_once 'inc_dashboard_proposta_res_form.php';?>
</div> 

<!--CONTRATO-->
<div id="exibir_contrato">
    <?  include_once 'inc_dashboard_contrato_res_form.php';?>
</div> 


<div class="container" id="exibir_funil_vendas">  
    <br>
    <div class="row">
        <div class="container">
            <div class="modal-content">
                <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                    <div class="row">
                       <div class="col-sm-12 text-center"> 
                            <h5><b>Funil de Vendas</b></h5>                     
                       </div>                   
                                
                    </div>                                            
                    <div class="row">
                       <div class="col-sm-12"> 
                            <div id="graf_funil"></div>                   
                        </div>                                                                                        
                     </div>
                 </div> 
             </div>
         </div>    
     </div>
</div>
    
    
    
    
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
