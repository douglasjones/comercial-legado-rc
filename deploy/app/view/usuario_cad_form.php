<?php
include_once "../inc/php/header.php";
?>

<script src="usuario_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Usuário</h3>
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
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for='conta_pk'>Conta:&nbsp;</label>
                <select class='form-control form-control-sm'  id='contas_pk' name='contas_pk' />
                    <option></option>
                </select>
            </div>
            <div class='col-md-3'>
                <label for='grupos_pk'>Grupo:&nbsp;</label>
                <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk' />
                    <option></option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <label for='ds_usuario'>Usuário:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_usuario' name='ds_usuario' required >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>

            <div class='col-md-3'>
                <label for='ds_login'>Login:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_login' name='ds_login' required >
            </div>
            <div class='col-md-3'>
                <label for='ds_senha'>Redefinir Senha:&nbsp;</label>
                <input class='form-control form-control-sm' type='checkbox' id='ic_senha' name='ic_senha' />
                <input class='form-control form-control-sm' type='hidden' id='ds_senha' name='ds_senha' />
            </div>
        </div>

        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <label for='ds_email'>Email:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_email' name='ds_email' required >
            </div>
            <div class='col-md-3'>
                <label for='ds_cel'>Cel:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_cel' name='ds_cel' required >
            </div>
        </div>


        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for='ic_status'>Status:&nbsp;</label>
                <select class='form-control form-control-sm'  id='ic_status' name='ic_status' />
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            
        </div>
        <?php  include("inc_usuario_polos_res_form.php"); ?>
        

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
    <!--MODAL RESPONSAVEL-->
    <?include("inc_usuario_polos_cad_form.php");?>
</div>
<?php
include_once "../inc/php/footer.php";
?>
