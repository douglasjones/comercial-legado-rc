<?
include_once "../inc/php/pre_header.php";

?>

<script src="inc_responsavel_lead_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <form id="form_lead_responsavel" class="form">
    <!-- Inicio janeja modal para edicao do registro -->
    <div class="modal fade bd-example-modal-lg" id="janela_responsavel" data-backdrop='static'>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_responsavelLabel">Novo Responsavel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type='hidden' class='form-control form-control-sm'  id='lead_responsavel_pk' name='lead_responsavel_pk'>
                    <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>

                    <div class="row">
                        <div class='col-md-4'>
                            <label for='grupos_pk'>Perfil: </label>
                            <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk' required>
                                <option></option>
                            </select>
                       </div>
                        <div class='col-md-4'>
                            <label for='usuarios_pk'>Responsável: </label>
                            <select class='form-control form-control-sm'  id='usuarios_pk' name='usuarios_pk' required>
                                <option></option>
                            </select>
                       </div>
                    </div>
                    <br>                                              
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn" id="cmdEnviarResponsavel"  name="cmdEnviarResponsavel">Enviar</button>
                </div>
            </div>
        </div>
    </div>   
</div>            
</form>
</div>