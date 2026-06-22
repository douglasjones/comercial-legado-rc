<?
include_once "../inc/php/pre_header.php";

?>


<div class="container">
    <form id="form_usuario_polo" class="form">
    <!-- Inicio janeja modal para edicao do registro -->
    <div class="modal fade bd-example-modal-lg" id="janela_polo" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_responsavelLabel">Polo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type='hidden' class='form-control form-control-sm'  id='usuario_polos_pk' name='usuario_polos_pk'>
                    <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>

                    <div class="row">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>    
                        <div class='col-md-4'>
                            <label for='grupos_pk'>Perfil: </label>
                             <select class='form-control form-control-sm'  id='polos_pk' name='polos_pk' />
                                <option></option>
                             </select>
                       </div>
                    </div>
                    <br>                                              
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn" id="cmdEnviarPolo"  name="cmdEnviarPolo">Enviar</button>
                </div>
            </div>
        </div>
    </div>   
</div>            
</form>
</div>