<?
include_once "../inc/php/header.php";
?>

<script src="tipo_ocorrencia_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Tipo Ocorrências</h2>
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
                <label for='ds_tipo_ocorrencia'>Tipo ocorrência:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_tipo_ocorrencia' name='ds_tipo_ocorrencia' required >
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_fechar_ocorrencia_auto">Fechar ocorrência:&nbsp;</label>
                <select id="ic_fechar_ocorrencia_auto" class="form-control form-control-sm" name="ic_fechar_ocorrencia_auto">
                    <option value=""></option>
                    <option value="1">Sim</option>
                    <option value="2">Não</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Status:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
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
