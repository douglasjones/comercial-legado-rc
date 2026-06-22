<?

include_once "../inc/php/header.php";

?>
<script src="rel_carteira_pesq.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Carteira</h2>
        </div>
    </div>
    <form id="form" class="form">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="polos_pk">Polo:&nbsp;</label>
                <select id="polos_pk" class="form-control form-control-sm" name="polos_pk">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='grupos_pk'>Perfil: </label>
                <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk'>
                    <option></option>
                </select>
           </div>
            
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='usuarios_pk'>Responsável: </label>
                <select class='form-control form-control-sm'  id='usuarios_pk' name='usuarios_pk'>
                    <option></option>
                </select>
           </div>
            
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="leads_pk">Cód Lead:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='leads_pk' name='leads_pk' >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ds_lead">Lead:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_lead' name='ds_lead' >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='equipes_pk'>Equipes: </label>
                <select class='form-control form-control-sm'  id='equipes_pk' name='equipes_pk'>
                    <option></option>
                </select>
           </div>
        </div>
        
        <br>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="submit" class="btn" id="cmdEnviar">Enviar</button>
                <button type="button" class="btn" id="cmdCancelar">Voltar</button>
            </div>
        </div>
        <br>
    </form>
</div>
<?
include_once "../inc/php/footer.php";
?>
