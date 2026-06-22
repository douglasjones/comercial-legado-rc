<?
include_once "../inc/php/pre_header.php";

?>

<div class="container">
    <!--So aparecer quando o lead estiver cadastrado ou lead_main-->
    <div class="exibir">
        <div class='row'>
            <div class="form-group">
                <label class="col-md-12 control-label"><b>ID Lead: </b></label>
            </div>
            <div class='col-md-2'>
                <div class=' leads_pk_cad'></div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label class="col-md-12 control-label"><b>Polo: </b></label>
            </div>
            <div class='col-md-3'>
                <div class=' ds_polo_cad'></div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label class="col-md-12 control-label"><b>Tipo Pessoa: </b></label>
            </div>
            <div class='col-md-2'>
                <div class=' ds_tipo_pessoa_cad'></div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label class="col-md-12 control-label"><b>Lead: </b></label>
            </div>
            <div class='col-md-2'>
                <div class=' ds_lead_cad'></div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-md-12'>
            <button type="button" id="btn_modal_endereco" class="btn btn-secondary" >Incluir Endereços</button>
        </div>
    </div>
    <div class="row" id="ic_grid">
        <div class="col-md-12">
            <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblEndereco">
                <thead >
                    <tr>
                    <th>Código</th>
                    <th>CEP</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>UF</th>
                    <th>Numero</th>
                    <th>Complemento</th>
                    <th>Bairro</th>
                    <th>Tipo Endereço</th>
                    <th>Tipo Endereço_pk</th>
                    <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>