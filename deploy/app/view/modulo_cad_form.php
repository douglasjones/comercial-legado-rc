<?
include_once "../inc/php/header.php";
?>

<script src="modulo_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Módulos</h3>
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
                <label for='ds_modulo'>Módulo: </label>
                <input type='text' class='form-control form-control-sm' id='ds_modulo' name='ds_modulo' required >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_dominio'>Domínio: </label>
                <input type='text' class='form-control form-control-sm' id='ds_dominio' name='ds_dominio' required >
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="center">
				<hr>
                <button type="submit" class="btn" id="cmdEnviar">Enviar</button>
                 
                <button type="button" class="btn" id="cmdCancelar">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<?
include_once "../inc/php/footer.php";
?>
