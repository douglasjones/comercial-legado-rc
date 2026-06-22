<?
include_once "../inc/php/header.php";
?>
<script src="pesquisar_lead_res.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Leads</h3>
            <input type="hidden" id="usuario_logado_pk"/>
        </div>
    </div>
    <div class='row' id="alert" style="display:none">
        <div class='col-md-4'>
            &nbsp;
        </div>
        <div class='col-md-6'  >
            <strong style="color: red">Você não é responsavel por esse Lead !!!</strong>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblPesquisa">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Lead</th>
                    <th>Endereço</th>
                    <th>Responsavel</th>
                    <th>Status</th>
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
