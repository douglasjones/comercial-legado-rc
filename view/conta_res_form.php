<?
include_once "../inc/php/header.php";
?>
<script src="conta_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Conta</h3>
        </div>
    </div>
    <hr>
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_tipo_pessoa">Tipo Pessoa:&nbsp;</label>                
                
                <select id="ds_tipo_pessoa" class="form-control form-control-sm" name="ds_tipo_pessoa">
                    <option value=""></option>
                    <option value="1">PF</option>
                    <option value="2">PJ</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_tipo_pessoa">Conta:&nbsp;</label>                
                <input type="text" class="form-control form-control-sm" id="ds_conta" required="true">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_tipo_pessoa">Razão Social:&nbsp;</label>                
                <input type="text" class="form-control form-control-sm" id="ds_razao_social" required="true">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_tipo_pessoa">CPF / CNPJ:&nbsp;</label>                
                <input type="text" class="form-control form-control-sm" id="ds_cpf_cnpj" required="true">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Status:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value=""></option>
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
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
                    <th>Tipo Pessoa</th>
                    <th>Conta</th>
                    <th>CPF / CNPJ</th>
                    <th>Tel</th>
                    <th>Ativação</th>
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
