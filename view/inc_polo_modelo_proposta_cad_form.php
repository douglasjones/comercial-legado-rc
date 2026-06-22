<?
include_once "../inc/php/pre_header.php";

?>

<script src="inc_polo_modelo_proposta_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <form id="form_polo_modelo_proposta" class="form">
        <!-- Inicio janeja modal para edicao do registro -->
        <div class="modal fade bd-example-modal-lg" id="janela_modelo_proposta" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_leadOPeradorLabel">Novo Modelo Proposta</h5>
                        <h5 class="modal-title" id="janela_etapasLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' class='form-control form-control-sm'  id='modelo_proposta_pk' name='modelo_proposta_pk'>
                        <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                        <div class="row">                                                   
                            <div class='col-md-3'>
                                <label for='operador_pk'>Operadoras: </label>
                                <select class='form-control form-control-sm'  id='modelo_operador_pk' name='modelo_operador_pk' required>
                                    <option value=""></option>
                                </select>                        
                            </div>
                        </div>  
                        <div class="row">  
                            <div class='col-md-3'>
                                <label for='n_ordem'>Tipo Modelo: </label>
                                <select class='form-control form-control-sm'  id='tipo_modelo_pk' name='tipo_modelo_pk' required>
                                    <option value=""></option>
                                    <option value="1">Padrão</option>
                                    <option value="2">Personalizado</option>
                                </select> 
                            </div> 
                            <div class='col-md-5'>
                                <label for='ds_etapa'>Tipo de Envio: </label>
                                <select class='form-control form-control-sm'  id='tipo_envio_pk' name='tipo_envio_pk' required>
                                    <option value=""></option>
                                    <option value="1">E-mail do Usuário</option>
                                    <option value="2">E-mail Único</option>
                                </select> 
                            </div>                     
                        </div>                                                    
                        <div class="row">  
                            <div class='col-md-5'>
                                <label for='n_ordem'>E-mail: </label>
                                <input class='form-control form-control-sm'  id='modelo_ds_email' name='modelo_ds_email' required> 
                            </div>                     
                        </div>                                                    
                        <div class="row">  
                            <div class='col-md-2'>
                                <label for='ic_status_'>Status: </label>
                                <select class='form-control form-control-sm'  id='ic_status_modelo' name='ic_status_modelo' required>
                                    <option value="1">Ativo</option>
                                    <option value="2">Desativado</option>
                                </select>                        
                            </div>                        
                        </div>                                                    
                        <div class="row">  
                            <div class='col-md-12'>
                                <label for='ds_etapa'>HTML modelo proposta: </label>
                                <textarea class='form-control form-control-sm'  rows="10" id='html_modelo' name='html_modelo' ></textarea>                      
                            </div>                     
                        </div>                                                    
                        <br>                                                   
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn" id="cmdEnviarModeloProposta"  name="cmdEnviarModeloProposta">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>   
        </div>            
    </form>
</div>