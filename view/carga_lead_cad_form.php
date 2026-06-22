<?
include_once "../inc/php/header.php";
?>

<script src="carga_lead_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Carga Lead</h2>
            <hr>
        </div>
    </div>
    <form id="form" class="form">
        <div class='row'>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Escolha o Arquivo</span>
                    <input id="fileupload"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php?token=<?=$token?>">
                    <input id="ds_arquivo"  type="hidden" >

                </span>
                <br>
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <div id="files" class="files"></div>
                <!---->
                <div class="row" id="rowFotos"></div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_equipe'>Polos:&nbsp;</label>
                <select class='form-control form-control-sm' id='polos_pk' name='polos_pk'>
                    <option></option>
                </select>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_equipe'>Mailing:&nbsp;</label>
                <select class='form-control form-control-sm' id='mailing_pk' name='mailing_pk'>
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='grupos_pk'>Perfil: </label>
                <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk' >
                    <option></option>
                </select>
           </div>
            
        </div>
        <div class="row">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='usuarios_pk'>Responsável: </label>
                <select class='form-control form-control-sm'  id='usuarios_pk' name='usuarios_pk' >
                    <option></option>
                </select>
           </div>
        </div>
        <div class="row">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ic_cliente'>Cliente:&nbsp;</label>
                <select class='form-control form-control-sm'  id='ic_cliente' name='ic_cliente' requered/>
                    <option></option>
                    <option value='1'>Sim</option>
                    <option value='2'>Não</option>
                </select>
            </div>
        </div>
        <br> 
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="center">
                <hr>
                <button type="submit" class="btn" id="cmdEnviar">Enviar</button>
                &nbsp;
                <button type="button" class="btn" id="cmdCancelar">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<?
include_once "../inc/php/footer.php";
?>
