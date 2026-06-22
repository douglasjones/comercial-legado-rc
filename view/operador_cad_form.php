<?
include_once "../inc/php/header.php";
?>

<script src="operador_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Operador</h2>
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
                <label for='ds_operador'>Operador:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_operador' name='ds_operador' required >
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='segmentos_pk'>Segmento:&nbsp;</label>
                <select class='form-control form-control-sm'  id='segmentos_pk' name='segmentos_pk' />
                    <option></option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ic_status'>Status:&nbsp;</label>
                <select class='form-control form-control-sm'  id='ic_status' name='ic_status' >
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
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
                &nbsp;
                <button type="button" class="btn" id="cmdCancelar">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<?
include_once "../inc/php/footer.php";
?>
