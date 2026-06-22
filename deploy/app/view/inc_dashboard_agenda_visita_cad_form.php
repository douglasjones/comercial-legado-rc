<script src="inc_dashboard_agenda_visita_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<form id="form_agenda_visita" class="form">
    <!-- Inicio janeja modal para Agenda Visita -->
    <div class="modal fade bd-example-modal-lg"  id="janela_agenda_visita">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contratosLabel">Nova Agenda Visita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_contato">
                    <div class="modal-content bd-example-modal-lg-12">
                        <div class="modal-body" >                                    

                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for='tipo_evento'>Tipo Evento: </label>
                                </div>                                        
                            </div>
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <input type="radio" value="1" name="tipo_evento_agenda_pk" id="tipo_evento_agenda_pk_0"/> <i class="fa fa-calendar" aria-hidden="true" style="font-size: 18px;" > Agenda de Visita</i>
                                </div>                                        
                                <div class='col-md-3'>
                                    <input type="radio" value="2" name="tipo_evento_agenda_pk" id="tipo_evento_agenda_pk_1"/> <i class="fa fa-bell" aria-hidden="true" style="font-size: 18px;" > Lembrete</i>
                                </div>                                        
                                <div class='col-md-2'>
                                    <input type="radio" value="3" name="tipo_evento_agenda_pk" id="tipo_evento_agenda_pk_2"/><i class="fa fa-history" aria-hidden="true" style="font-size: 18px;" > Retorno</i> 
                                </div>                                        
                            </div>
                            <div class='row'>
                                <div class='col-md-2'>
                                    &nbsp;

                                </div>
                                <div class='col-md-3' id="alert_tipo_evento" style="display:none" >
                                    <strong style="color: red">Selecione Tipo evento</strong>
                                </div>
                            </div>
                            <div class="row">

                                <input type='hidden' class='form-control form-control-sm'  id='agenda_visita_pk' name='agenda_visita_pk'>
                                <input type='hidden' class='form-control form-control-sm'  id='agenda_reagendamento_pk' name='agenda_reagendamento_pk'>
                                <input type='hidden' class='form-control form-control-sm'  id='ic_status' name='ic_status'>
                                <input type='hidden' class='form-control form-control-sm'  id='leads_pk' name='leads_pk'>
                                <input type='hidden' class='form-control form-control-sm'  id='polos_pk' name='polos_pk'>
                                <input type='hidden' class='form-control form-control-sm'  id='processos_pk' name='processos_pk'>
                                <input type='hidden' class='form-control form-control-sm'  id='etapas_1' name='etapas_1'>
                                <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_1' name='processos_etapas_pk_1'>
                                <input type='hidden' class='form-control form-control-sm'  id='etapas_2' name='etapas_2'>
                                <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_2' name='processos_etapas_pk_2'>
                                <input type='hidden' class='form-control form-control-sm'  id='etapas_3' name='etapas_3'>
                                <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_3' name='processos_etapas_pk_3'>
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for='tipos_agendas_pk'>Tipo agendamento: </label>

                                    <select class='form-control form-control-sm'  id='tipos_agendas_pk' name='tipos_agendas_pk'>
                                        <option value=""></option>
                                        <option value="1">Prospecção</option>
                                        <option value="2">Reunião</option>
                                        <option value="3">Fechamento</option>
                                    </select>
                                </div>                                        
                            </div>
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>                                               
                                <div class='col-md-3'>
                                    <div class="form-group">
                                        <label for="dt_agenda_visita">Data visita:</label>
                                        <input type='text' class=" form-control form-control-file" id="dt_agenda_visita" name="dt_agenda_visita"/>
                                    </div>
                                </div>  
                                <div class='col-md-2'>
                                    <div class="form-group">
                                        <label for="hr_agenda_visita">Hora visita:</label>
                                        <input type='text' class=" form-control form-control-file" id="hr_agenda_visita" name="hr_agenda_visita"/>
                                    </div>    
                                </div>  
                            </div>
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>   
                                <div class="col-md-8">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResponsavel">
                                        <thead>
                                            <tr>
                                                <th>Responsavel</th>
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
                                    <button type="button" class="btn" id="cmdIncluirResponsavel" name="cmdIncluirResponsavel">Incluir</button>
                                </div>
                            </div>
                            <!--EXIBIR CASO O EVENTO SEJA LEMBRETE-->
                            <div id="exibir_lembrete">
                                <div class='row'>
                                    <div class='col-md-2'>
                                        &nbsp;

                                    </div>
                                    <div class='col-md-3'>
                                        <label for='ds_titulo_agenda'>Lembrar-me de ?&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm'  id='ds_titulo_agenda' name='ds_titulo_agenda' >
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-2'>
                                        &nbsp;

                                    </div>
                                    <div class='col-md-3' id="alert_ds_titulo_agenda" style="display:none" >
                                        <strong style="color: red">Selecione Lembrar-me de</strong>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-2'>
                                        &nbsp;

                                    </div>
                                    <div class='col-md-3'>
                                        <label for='aviso_pk'>Lembrar&nbsp;</label>
                                        <select name='aviso_pk' id='aviso_pk' class='form-control'>
                                            <option></option>
                                            <option value='15'>15 Minutos</option>
                                            <option value='30'>30 Minutos</option>
                                            <option value='60'>1 Hora</option>
                                            <option value='120'>2 Horas</option>
                                            <option value='1440'>1 Dia</option>
                                         </select>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-2'>
                                        &nbsp;

                                    </div>
                                    <div class='col-md-3' id="alert_aviso_pk" style="display:none" >
                                        <strong style="color: red">Selecione Lembrar</strong>
                                    </div>
                                </div>
                            </div>
                            <!--EXIBIR CASO O EVENTO SEJA AGENDA DE VISITA-->
                            <div id="exibir_agenda">
                                <div class='row' id="exib_sem_pk">
                                    <div class='col-md-2'>
                                        &nbsp;

                                    </div>
                                    <div class='col-md-3'>
                                        <label for='contatos_pk'>Contato:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='contatos_pk' name='contatos_pk'>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div id="exib_com_pk">
                                    <div class='row'>
                                        <div class='col-md-2'>
                                            &nbsp;
                                        </div>
                                        <div class='col-md-3'>
                                            <label for='ds_contato'>Contato:&nbsp;</label>
                                            <input type='text' class='form-control form-control-sm' id='ds_contato' name='ds_contato' disabled>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-2'>
                                            &nbsp;
                                        </div>
                                        <div class='col-md-3'>
                                            <label for='ds_cel'>Celular:&nbsp;</label>
                                            <input type='text' class='form-control form-control-sm' id='ds_cel' name='ds_cel' disabled>
                                        </div>
                                        <div class='col-md-3'>
                                            <label for='ds_tel'>Telefone:&nbsp;</label>
                                            <input type='text' class='form-control form-control-sm' id='ds_tel' name='ds_tel' disabled>
                                        </div>
                                        <div class='col-md-2'>
                                            <label for='ds_cargo'>Cargo:&nbsp;</label>
                                            <input type='text' class='form-control form-control-sm' id='ds_cargo' name='ds_cargo' disabled>
                                            <input type='hidden' class='form-control form-control-sm' id='cargos_pk' name='cargos_pk' disabled>
                                        </div>

                                    </div>
                                </div>

                                <div class='row'>
                                    <div class='col-md-2'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='ds_cep'>CEP:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm'  maxlength="9" id='ds_cep' name='ds_cep'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-2'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-8'>
                                        <label for='ds_endereco'>Endereço:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_endereco' name='ds_endereco'>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div class='col-md-2'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-2'>
                                        <label for='ds_numero'>Nr:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm' maxlength="10" id='ds_numero' name='ds_numero'>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='ds_complemento'>Complemento:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm' maxlength="10" id='ds_complemento' name='ds_complemento'  >
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-2'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='ds_bairro'>Bairro:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm' maxlength="45" id='ds_bairro' name='ds_bairro'>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='ds_cidade'>Cidade:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm' maxlength="45" id='ds_cidade' name='ds_cidade'>
                                    </div>
                                    <div class='col-md-2'>
                                        <label for='ds_uf'>UF:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='ds_uf' name='ds_uf'>
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
                                <div class='row'>
                                    <div class='col-md-4'> 
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                            <div id='exib_classificacao'>
                                <div class="row">
                                    <div class='col-md-2'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='classificacao_agenda_pk'>Classificação: </label>

                                        <select class='form-control form-control-sm'  id='classificacao_agenda_pk' name='classificacao_agenda_pk'>
                                            <option value=""></option>
                                            <option value="1">Produtivo</option>
                                            <option value="2">Improdutivo</option>
                                        </select>
                                    </div>                                        
                                </div>
                            </div>
                            <div class="row" id='exib_motivo_reagendamento'>
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for='motivo_reagendamento_pk'>Motivo reagendamento: </label>

                                    <select class='form-control form-control-sm'  id='motivo_reagendamento_pk' name='motivo_reagendamento_pk'>
                                        <option value=""></option>
                                        <option value="1">Lead solicitou outra data</option>
                                        <option value="2">Aguardar próxima assembleia</option>
                                    </select>
                                </div>                                        
                            </div>
                            <div class="row" id='exib_obs'>
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>
                                <div class='col-md-8'>
                                    <label for='ds_obs'>Observação: </label>
                                    <textarea class='form-control form-control-sm' id='ds_obs' name='ds_obs' ></textarea>
                                </div>                                        
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-md-4'> 
                                    &nbsp;
                                </div>
                            </div>
                            <div id='exib_motivo_cancelamento'>
                                <div class="row">
                                    <div class='col-md-2'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='motivo_cancelamento_pk'>Motivo Cancelamento: </label>

                                        <select class='form-control form-control-sm'  id='motivo_cancelamento_pk' name='motivo_cancelamento_pk'>
                                            <option value=""></option>
                                            <option value="1">Valor do contrato atual inferior ao da proposta</option>
                                        </select>
                                    </div>                                        
                                </div>
                                <div class="row">
                                    <div class='col-md-2'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-8'>
                                        <label for='ds_obs_cancelamento'>Observação cancelamento: </label>
                                        <textarea class='form-control form-control-sm' id='ds_obs_cancelamento' name='ds_obs_cancelamento' ></textarea>
                                    </div>                                        
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
