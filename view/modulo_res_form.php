<?
include_once "../inc/php/header.php";
?>
<script src="modulo_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Módulos</h3>
        </div>
    </div>
    <form method="post">
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
        
        <div class="row">
            <div class="col-md-4">
                 
            </div>
            <div class='col-md-4'>
                <label for="ds_modulo">Módulo: </label>
                <input type="text" class="form-control form-control-sm" id="ds_modulo" required="true">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                 
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><i class="fa fa-search" aria-hidden="true" style="font-size: 15px;" > Pesquisar</i></button>
                &nbsp;&nbsp;
                <button type="button" class="btn btn-link" id="cmdIncluir"><i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 15px;" > Incluir</i></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Módulo</th>
                    <th>Domínio</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?
include_once "../inc/php/footer.php";
?>
