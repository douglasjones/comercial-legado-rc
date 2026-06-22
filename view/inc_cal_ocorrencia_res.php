
<div class="modal fade bd-example-modal-lg"  id="janela_agenda_visita_ocorrencia">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contratosLabel">Ocorrências</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <br>
            <div class='row'>
                <div class='col-md-12'>
                    &nbsp;
                </div>
            </div>
            <div class='row'>
                
                <div class='col-md-11'>
                    <button type="button" class="btn btn-secondary" id="cmdIncluirOcorrencia">Incluir Ocorrência</button>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>
                    &nbsp;
                </div>
            </div>
            <br>
            <div class="modal-content bd-example-modal-lg-12">
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblOcorrencia">
                                <thead>
                                    <tr>
                                        <th>Cód</th>             
                                        <th>Dt Cad OC</th>
                                        <th>Tipo OC</th>
                                        <th>Tipo Ocorrência_pk</th>
                                        <th>Descr OC</th> 
                                        <th>Usuário Cad</th>
                                        <th>Dt Fech OC</th>                    
                                        <th>Agendado Para</th>
                                        <th>Dt Retorno</th>
                                        <th>Descr Retorno</th>
                                        <th>Dt Fech Retorno</th>                                     
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>  
</div>
<div class="container">    
    <form id="form_ocorrencia" class="form">
        <div class="modal fade bd-example-modal-lg" id="janela_ocorrencia_agenda" >
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
                        <input type='hidden' id='ds_tipo_ocorrencia' name='ds_tipo_ocorrencia'/>
                        <input type='hidden' id='ds_sem_interesse' name='ds_sem_interesse'/>
                        <input type='hidden' id='agenda_leads_pk' name='agenda_leads_pk'/>

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
                    <div id="sem_interesse" style="display:none">
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-6'>
                                <label for='motivo_sem_interesse_pk'>Motivo Sem Interesse&nbsp;</label>
                                <select class='form-control form-control-sm'  id='motivo_sem_interesse_pk' name='motivo_sem_interesse_pk' />
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-6'>
                                <label for='ds_motivo_sem_interesse'>Descrição Motivo Sem Interesse&nbsp;</label>
                                 <textarea class=" form-control form-control-file" id="ds_motivo_sem_interesse" name="ds_motivo_sem_interesse"></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
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
                                    <select class='form-control form-control-sm'  id='agenda_responsavel_pk' name='agenda_responsavel_pk' >
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
                        <!--<div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="agenda_ds_retorno">Descrição Retorno:</label>
                                    <textarea class=" form-control form-control-file" id="agenda_ds_retorno" name="agenda_ds_retorno"></textarea>
                                </div>
                            </div>                                                             
                        </div>-->
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
                        <!--<div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-4'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Data Termino Retorno:</label>
                                    <input type='text' class=" form-control form-control-file" id="edit_agenda_dt_retorno_termino" name="edit_agenda_dt_retorno_termino"/>
                                </div>
                            </div> 
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Hora Termino Retorno:</label>
                                    <input type='text' class=" form-control form-control-file" id="edit_agenda_hr_retorno_termino" name="edit_agenda_hr_retorno_termino"/>
                                </div>
                            </div>  
                        </div>-->
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

