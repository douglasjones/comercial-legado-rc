<script src="inc_dashboard_contrato_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<form id="form_contrato" class="form">
    <!-- Inicio janeja modal para CONTRATOS -->
    <div class="modal fade bd-example-modal-lg"  id="janela_contratos">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contratosLabel">Novo Contrato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_contato">
                    <div class="modal-content bd-example-modal-lg-12">
                        <div class="modal-body" >                                    
                            <div class="row">
                                <div class='col-md-2'>
                                    <label for='ic_contrato'>Contrato:&nbsp;</label>
                                    <input type='radio' class=" form-control form-control-file" id="ic_contrato" name="ic_contrato"/>
                                </div>                                                             
                                <div class='col-md-2'>
                                    <label for='ic_aditivo'>Aditivo:&nbsp;</label>
                                    <input type='radio' class=" form-control form-control-file" id="ic_aditivo" name="ic_aditivo"/>
                                </div>
                                <div class='col-md-4' id="exib_contrato_pai">
                                    <label for='contrato_pai_pk'>Contrato Original: </label>

                                    <select class='form-control form-control-sm'  id='contrato_pai_pk' name='contrato_pai_pk'>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-md-2'>
                                   &nbsp;
                                </div>                                                             
                                <div class='col-md-2'>
                                   &nbsp;
                                   <div id="input"></div>
                                </div>
                                <div class='col-md-4' id="alert_contrato_pai" style="display:none" >
                                    <strong style="color: red">Selecione o Contrato Original</strong>
                                </div>
                            </div>
                            <div class="row">

                                <input type='hidden' class='form-control form-control-sm'  id='contratos_pk' name='contratos_pk'>
                                <input type='hidden' class='form-control form-control-sm'  id='polos_contratos_pk' name='polos_contratos_pk'>
                                <input type='hidden' class='form-control form-control-sm'  id='processos_contratos_pk' name='processos_contratos_pk'>
                                <input type='hidden' class='form-control form-control-sm'  id='responsavel_pk' name='responsavel_pk'>

                                <!--div class='col-md-4'>
                                    <label for='dt_inicio_contrato'>Data Início: </label>

                                    <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_inicio_contrato' name='dt_inicio_contrato'>
                                </div>
                                <div class='col-md-4'>
                                    <label for='dt_fim_contrato'>Data Fim: </label>
                                    <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_fim_contrato' name='dt_fim_contrato'>
                                </div-->                                                   
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for='ds_equipe'>Operadora:&nbsp;</label>
                                    <select class='form-control form-control-sm' id='operador_contrato_pk' name='operador_contrato_pk'>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblContratoItens">
                                        <thead>
                                            <tr>
                                                <th>Cód</th>
                                                <th>Prod/Serv</th>
                                                <th>Qtde.Prod</th>
                                                <th>Qtde.Dias</th>
                                                <th>Vl. Unitario</th>
                                                <th>Vl. Total</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12' align="center"> 
                                    <button type="button" class="btn" id="cmdIncluirContratosItens" name="cmdIncluirContratosItens">Incluir</button>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'> 
                                    &nbsp;
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblContratoEtapas">
                                        <thead>
                                            <tr>
                                                <th>Cód</th>
                                                <th>Etapa Contrato</th>
                                                <th>Dt. Etapa</th>
                                                <th>Usuário Cad.</th>
                                                <th>Dt. Cadastro</th>
                                                <th>Observação</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12' align="center"> 
                                    <button type="button" class="btn"  id="cmdIncluirContratosEtapas" name="cmdIncluirContratosEtapas">Incluir</button>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'> 
                                    &nbsp;
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn" id="cmdEnviarContrato"  name="cmdEnviarContrato">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</form>