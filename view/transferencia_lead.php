<?
include_once "../inc/php/header.php";
?>
<script src="transferencia_lead.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Transferencia Lead</h3>
        </div>
    </div>
</div>
<br>
<div class="container" >
     <div class="modal-content" style="box-shadow: 10px 10px 5px grey;">
        <form method="post" >
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for="ds_lead">Polo:&nbsp;</label>
                     <select class='form-control form-control-sm'  id='polos_pk' name='polos_pk'>                            
                        <option value=""></option>                       
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for="ds_lead">Razão Social:&nbsp;</label>
                    <input type="text" class="form-control form-control-sm" id="ds_razao_social">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class='col-md-1'>
                    <label for="ds_lead">Status:&nbsp;</label>
                </div>
                <div class='col-md-1'>
                    <label for="ds_lead"><input type="checkbox" name="ic_status" class="form-control form-control-sm" id="ic_status_1" >25%</label> 
                </div>
                <div class='col-md-1'>
                    <label for="ds_lead"><input type="checkbox" name="ic_status" class="form-control form-control-sm" id="ic_status_2" >50%</label> 
                </div>
                <div class='col-md-1'>
                    <label for="ds_lead"><input type="checkbox" name="ic_status" class="form-control form-control-sm" id="ic_status_3" >75%</label> 
                </div>
                <div class='col-md-1'>
                    <label for="ds_lead"><input type="checkbox" name="ic_status" class="form-control form-control-sm" id="ic_status_4" >Cliente</label> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for='grupos_pk'>Perfil: </label>
                    <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk'>
                        <option></option>
                    </select>
               </div>
                <div class='col-md-4'>
                    <label for='usuarios_pk'>Responsável: </label>
                    <select class='form-control form-control-sm'  id='usuarios_pk' name='usuarios_pk'>
                        <option></option>
                    </select>
               </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for="ds_lead">Tipo Pessoa:&nbsp;</label>
                    <select class='form-control form-control-sm'  id='tipo_pessoa_pk' name='tipo_pessoa_pk'>                            
                        <option value=""></option>
                        <option value="PJ">PJ</option>
                        <option value="PF">PF</option>                            
                    </select>
                </div>
                <div class='col-md-4'>
                    <label for="ds_lead">Mailing:&nbsp;</label>
                    <select class='form-control form-control-sm'  id='mailing_pk' name='mailing_pk'>                            
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for='operador_pk'>Operadora: </label>
                    <select class='form-control form-control-sm'  id='operador_pk' name='operador_pk'>
                        <option value=""></option>
                    </select>
               </div>
                <div class='col-md-4'>
                    <label for='classificacao_operador_pk'>Classificação Operadora: </label>
                    <select class='form-control form-control-sm'  id='classificacao_operador_pk' name='classificacao_operador_pk'>
                        <option value=""></option>
                    </select>
               </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for='tempo_contrato_ini'>Tempo Contrato (Meses): </label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm" id="tempo_contrato_ini" placeholder="De">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm" id="tempo_contrato_fim" placeholder="Até">
                        </div>
                    </div>
               </div>
                <div class='col-md-4'>
                    <label for='qtde_linhas_ini'>Qtde. Linhas: </label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm" id="qtde_linhas_ini" placeholder="De">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm" id="qtde_linhas_fim" placeholder="Até">
                        </div>
                    </div>
               </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-8" align="right">
                    <button type="button" class="btn btn-link" id="cmdPesquisar"><i class="fa fa-arrow-right" aria-hidden="true" style="font-size: 15px;" > Avançar</i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?
include_once "../inc/php/footer.php";
?>
