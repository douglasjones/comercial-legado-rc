<?
include_once "../inc/php/pre_header.php";

?>

<script src="inc_polo_operador_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <form id="form_polo_operador" class="form">
        <!-- Inicio janeja modal para edicao do registro -->
        <div class="modal fade bd-example-modal-lg" id="janela_operador" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contatosLabel">Operadoras</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' class='form-control form-control-sm'  id='polos_operadores_pk' name='polos_operadores_pk'>
                        <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                        <div class="row">                                                   
                            <div class='col-md-4'>
                                <label for='segmentos_pk'>Segmento: </label>
                                <select class='form-control form-control-sm'  id='segmentos_pk' name='segmentos_pk' required>
                                    <option value=""></option>
                                </select>                        
                            </div>   
                            <div class='col-md-4'>
                                <label for='operador_pk'>Operadoras: </label>
                                <select class='form-control form-control-sm'  id='operador_pk' name='operador_pk' required>
                                    <option value=""></option>
                                </select>                        
                            </div> 
                            <div class='col-md-4'>
                                <label for='ic_status_'>Status: </label>
                                <select class='form-control form-control-sm'  id='ic_status_operador' name='ic_status_operador' required>
                                    <option value="1">Ativo</option>
                                    <option value="2">Desativado</option>
                                </select>                        
                            </div>                        
                        </div>                                                    
                        <br>                                                   
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn" id="cmdEnviarOperador"  name="cmdEnviarOperador">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>   
        </div>            
    </form>
</div>