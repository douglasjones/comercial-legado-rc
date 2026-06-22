<?
require_once "../inc/php/header.php";
?>

<script src="migrar.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Migrar</h2>
            <hr>
        </div>
    </div>
    <form id="form" class="form">
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="button" class="btn" id="cmdEnviar">Migrar Usuário</button>
                &nbsp;
                <button type="button" class="btn" id="cmdEnviarLead">Migrar Lead</button>
                &nbsp;
                <button type="button" class="btn" id="cmdCancelar">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>
