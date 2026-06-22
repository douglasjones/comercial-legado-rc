<?
require_once "../inc/php/header.php";
?>

<script src="migracao_50_75.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Migração (50%,75%)</h2>
            <hr>
        </div>
    </div>
    <form id="form" class="form">
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>PK OLD (separado por Virgula):&nbsp;</label>
                <textarea class="form-control form-control-sm" id="pk_old"></textarea>                        
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>Porcentagem:&nbsp;</label>
               <select class='form-control form-control-sm'  id='porcentagem_pk' name='porcentagem_pk'>
                    <option></option>
                    <option value="6">Sem Interesse</option>
                    <option value="7">Não Contactado</option>
                    <option value="8">Contactado</option>
                    <option value="1">50%</option>
                    <option value="2">75%</option>
                    <option value="3">80%</option>
                    <option value="4">90%</option>
                    <option value="5">Cliente</option>
                </select>                        
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="submit" class="btn" id="cmdEnviar">Salvar</button>
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>
