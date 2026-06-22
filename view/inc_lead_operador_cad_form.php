<?
include_once "../inc/php/pre_header.php";

?>

<script src="inc_lead_operador_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <form id="form_lead_operador" class="form">
    <!-- Inicio janeja modal para edicao do registro -->
    <div class="modal fade bd-example-modal-lg" id="janela_lead_operador" data-backdrop='static'>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_leadOPeradorLabel">Novo Operador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type='hidden' class='form-control form-control-sm'  id='lead_operador_pk' name='lead_operador_pk'>
                    <input type='hidden' class='form-control form-control-sm'  id='ds_operador_lead' name='ds_operador_lead'>
                    <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>

                    <div class="row">
                        <div class='col-md-4'>
                            <label for='operador_pk'>Operadora : </label>
                            <select class='form-control form-control-sm'  id='operador_pk' name='operador_pk' required>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-4'>
                            <label for='ic_cliente_operador'>Cliente: </label>
                            <select class='form-control form-control-sm'  id='ic_cliente_operador' name='ic_cliente_operador'>
                                <option value=""></option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>
                            </select>
                        </div>
                        <div class='col-md-4'>
                            <label for='ic_base'>Base: </label>
                            <select class='form-control form-control-sm'  id='ic_base' name='ic_base'>
                                <option value=""></option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-4'>
                            <label for='dt_ativacao'>Data ativação: </label>
                            <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_ativacao' name='dt_ativacao'>
                        </div>
                        <div class='col-md-4'>
                            <label for='dt_vencimento'>Data vencimento: </label>
                            <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_vencimento' name='dt_vencimento'>
                        </div>    
                    </div>
                    <div class="row">
                        <div class='col-md-4'>
                            <label for='ds_custo_atual'>Custo atual: </label>
                            <input type='text' class='form-control form-control-sm' id='ds_custo_atual' name='ds_custo_atual'>
                        </div>
                        <div class='col-md-4'>
                            <label for='ds_qtde_voz'>Quantidade voz: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_qtde_voz' name='ds_qtde_voz'>
                        </div>    
                        <div class='col-md-4'>
                            <label for='ds_qtde_dados'>Quantidade dados: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_qtde_dados' name='ds_qtde_dados'>
                        </div>    
                    </div>
                    <div class="row">
                        <div class='col-md-4'>
                            <label for='classificacao_pk'>Classificação : </label>
                            <select class='form-control form-control-sm'  id='classificacao_pk' name='classificacao_pk'>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-4'>
                            <label for='ic_status_operador'>Tempo Contrato (Meses): </label>
                            <select class='form-control form-control-sm'  id='tempo_contrato_pk' name='tempo_contrato_pk'>
                                <option></option>
                                <?php for ($mes = 1; $mes <= 300; $mes++) { ?>
                                    <option value="<?php echo $mes; ?>"><?php echo $mes; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-4'>
                            <label for='ic_status_operador'>Status: </label>
                            <select class='form-control form-control-sm'  id='ic_status_operador' name='ic_status_operador'>
                                <option value="1">Ativo</option>
                                <option value="2">Desativado</option>
                            </select>
                        </div>
                    </div>
                </div>                                                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn" id="cmdEnviarLeadOperador"  name="cmdEnviarLeadOperador">Enviar</button>
                </div>
            </div>
        </div>  
</div>            
</form>
</div>
