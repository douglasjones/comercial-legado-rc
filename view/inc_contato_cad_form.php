<?
include_once "../inc/php/pre_header.php";

?>

<script src="inc_contato_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <form id="form_contato" class="form">
    <!-- Inicio janeja modal para edicao do registro -->
    <div class="modal fade bd-example-modal-lg" id="janela_contatos" data-backdrop='static'>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Novo Contato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type='hidden' class='form-control form-control-sm'  id='contatos_pk' name='contatos_pk'>
                    <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>

                    <div class="row">
                        <div class='col-md-4'>
                            <label for='ds_contato'>Contato: </label>

                            <input type='text' class='form-control form-control-sm'  id='ds_contato' name='ds_contato' required>
                        </div>
                        <div class='col-md-4'>
                            <label for='ds_cel'>Celular: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_cel' name='ds_cel' >
                        </div>                                
                        <div class='col-md-2'>
                            <label for='ic_whatsapp'>Whatsapp: </label>
                            <select class='form-control form-control-sm'  id='ic_whatsapp' name='ic_whatsapp' >
                                <option value=""></option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>
                            </select>
                        </div>
                        <div id='alert_contato'></div>
                        <div class='col-md-4' >
                            <label for='ds_tel'>Telefone: </label>
                            <input type='text' class='form-control form-control-sm' size='20' attrname='ds_tel_contato' id='ds_tel_contato' name='ds_tel_contato'>
                        </div>                                
                        <div class='col-md-4'>
                            <label for='ds_email'>E-mail: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_email' name='ds_email'  >

                        </div>     
                        <div class='col-md-3'>
                            <label for='cargos_pk'>Função: </label>
                            <select class='form-control form-control-sm'  id='cargos_pk' name='cargos_pk' /><option></option></select>
                        </div>
                    </div>                                                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn" id="cmdEnviarContato"  name="cmdEnviarContato">Enviar</button>
                </div>
            </div>
        </div>
    </div>   
</div>            
</form>
</div>