<?
include_once "../inc/php/pre_header.php";

?>

<script src="inc_telefone_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <form id="form_lead_telefone" class="form">
    <!-- Inicio janeja modal para edicao do registro -->
    <div class="modal fade bd-example-modal-lg" id="janela_telefone" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Novo Telefone</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type='hidden' class='form-control form-control-sm'  id='lead_telefone_pk' name='lead_telefone_pk'>
                    <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                    <div class="row">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>                                
                        <div class='col-md-2'>
                            <label for='tipo_telefone_pk'>Tipo Telefone: </label>
                            <select class='form-control form-control-sm'  id='tipo_telefone_pk' name='tipo_telefone_pk' required>
                                <option value=""></option>
                                <option value="1">Fixo</option>
                                <option value="2">Celular</option>
                                <option value="3">WhatsApp</option>
                            </select>
                        
                        </div> 
                        <div class='col-md-4'>
                            <label for='ds_tel'>Telefone: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_tel' name='ds_tel' required>
                        </div>
                        <div class='col-md-2'>
                            <label for='ic_status'>Status: </label>
                            <select class='form-control form-control-sm'  id='ic_status' name='ic_status' required>
                                <option value="1">Ativo</option>
                                <option value="2">Desativado</option>
                            </select>
                        
                        </div>
                        
                    </div>                                                    
                    <br>                                                   
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn" id="cmdEnviarTelefone"  name="cmdEnviarTelefone">Enviar</button>
                </div>
            </div>
        </div>
    </div>   
</div>            
</form>
</div>
