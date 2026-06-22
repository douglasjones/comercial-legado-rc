<script src="cal_inc_agenda_retorno.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">    
    <form id="form_ocorrencia" class="form">
        <div class="modal fade bd-example-modal-lg" id="janela_ocorrencia" >
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
                        <div class='col-md-2'>
                             
                        </div>
                        <div class='col-md-3'>
                            Agendar Retorno:
                        </div>                                                              
                        <div class='col-md-1'>
                            <input type='hidden' id='agenda_retorno_pk' name='agenda_retorno_pk'/>
                            <input type='hidden' id='ocorrencias_pk' name='ocorrencias_pk'/>
                            <input type='checkbox' class='form-control form-control-sm' maxlength="10"  id='agenda_retorno' name='agenda_retorno'>
                        </div>                                                              
                    </div>           
                    
                    <div id='cad_new'>
                        <hr>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Data Retorno:</label>
                                    <input type="text" class=" form-control form-control-file"  id="agenda_dt_retorno" name="agenda_dt_retorno">
                                </div>
                            </div> 
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Hora Retorno:</label>
                                    <input type="text" class=" form-control form-control-file"  id="agenda_hr_retorno" name="agenda_hr_retorno">
                                </div>
                            </div>        
                        </div>
                        <div >
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>                                                             
                                <div class='col-md-4'>
                                    <label for='agenda_responsavel_pk'>Usuário Responsável&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='agenda_responsavel_pk' name='agenda_responsavel_pk' />
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
                    <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="agenda_ds_retorno">Descrição Retorno:</label>
                                    <textarea  class=" form-control form-control-file" id="agenda_ds_retorno" name="agenda_ds_retorno"></textarea>
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
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                      
                            <div class='col-md-3'>
                                <label for='ic_usuario'>Novo Retorno:&nbsp;</label>
                                
                            </div>
                            <div class='col-md-1'>
                                <input type='checkbox' disabled="" class='form-control form-control-sm' maxlength="10"  id='n_retorno' name='n_retorno'>
                            </div>
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
