<?
include_once "../inc/php/pre_header.php";

?>

<script src="inc_endereco_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <form id="form_lead_endereco" class="form">
    <!-- Inicio janeja modal para edicao do registro -->
    <div class="modal fade bd-example-modal-lg" id="janela_endereco" data-backdrop='static'>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_EnderecoLabel">Novo Endereço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type='hidden' class='form-control form-control-sm'  id='lead_endereco_pk' name='lead_endereco_pk'>
                    <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>

                    <div class="row">
                        <div class='col-md-4'>
                            <label for='tipo_endereco_pk'>Tipo Endereço: </label>
                            <select class='form-control form-control-sm'  id='tipo_endereco_pk' name='tipo_endereco_pk' required>
                                <option value=""></option>
                                <option value="1">Matriz</option>
                                <option value="2">Filial</option>
                                <option value="3">Cobrança</option>
                                <option value="4">Entrega</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-2'>
                            <label for='ds_cep'>Cep: </label>

                            <input type='text' class='form-control form-control-sm' maxlength="9"  id='ds_cep' name='ds_cep' required>
                        </div>
                        <div class='col-md-4'>
                            <label for='ds_enderco'>Endereço: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_endereco' name='ds_endereco' required>
                        </div>
                        <div class='col-md-4' >
                            <label for='ds_numero'>Número: </label>
                            <input type='text' class='form-control form-control-sm' id='ds_numero' name='ds_numero'>
                        </div>                                
                        <div class='col-md-4'>
                            <label for='ds_complemento'>Complemento: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_complemento' name='ds_complemento'  >

                        </div>     
                        <div class='col-md-4'>
                            <label for='ds_bairro'>Bairro: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_bairro' name='ds_bairro'  >

                        </div>     
                        <div class='col-md-4'>
                            <label for='ds_cidade'>Cidade: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_cidade' name='ds_cidade'  >

                        </div>     
                         <div class='col-md-2'>
                        <label for='ds_uf'>UF:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ds_uf' name='ds_uf' requered/>
                            <option></option>
                            <option>AC</option>
                            <option>AL</option>
                            <option>AP</option>
                            <option>AM</option>
                            <option>BA</option>
                            <option>CE</option>
                            <option>DF</option>
                            <option>ES</option>
                            <option>GO</option>
                            <option>MA</option>
                            <option>MT</option>
                            <option>MS</option>
                            <option>MG</option>
                            <option>PA</option>
                            <option>PB</option>
                            <option>PR</option>
                            <option>PE</option>
                            <option>PI</option>
                            <option>RJ</option>
                            <option>RN</option>
                            <option>RS</option>
                            <option>RO</option>
                            <option>RR</option>
                            <option>SC</option>
                            <option>SP</option>
                            <option>SE</option>
                            <option>TO</option>
                        </select>
                    </div>
                </div>
                    </div>                                                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn" id="cmdEnviarEndereco"  name="cmdEnviarEndereco">Enviar</button>
                </div>
            </div>
        </div>  
</div>            
</form>
</div>