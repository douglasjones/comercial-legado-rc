<?
include_once "../inc/php/header.php";
?>

<script src="processo_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
    td.details-control {
        background: url('../img/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../img/details_close.png') no-repeat center center;
    }            
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Processo Comercial</h2>
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
            <div class='col-md-3' align="center " style="color: #007bff">
                &nbsp;<i class="fas fa-info-circle status_lead" ></i>
            </div>
        </div>
        <br>
        <div class='row'>
            <div class="form-group">
                <label class="col-xs-2 control-label">&nbsp;&nbsp;&nbsp;&nbsp;<b>ID Lead:</b> </label>
            </div>
            <div class='col-md-2'>
                <div class=' leads_pk_cad'></div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label class="col-xs-2 control-label"><b>&nbsp;&nbsp;&nbsp;&nbsp;Polo: </b></label>
            </div>
            <div class='col-md-2'>
                <div class=' ds_polo_cad'></div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label class="col-xs-2 control-label"><b>&nbsp;&nbsp;&nbsp;&nbsp;Tipo Pessoa:</b> </label>
            </div>
            <div class='col-md-2'>
                <div class=' ds_tipo_pessoa_cad'></div>
            </div>
        </div>
         <div class='row'>
            <div class="form-group">
                <label class="col-xs-2 control-label"><b>&nbsp;&nbsp;&nbsp;&nbsp;Lead:</b> </label>
            </div>
            <div class='col-md-2'>
                <div class=' ds_lead_cad'></div>
            </div>
        </div>
        <div class='row'>
            <div class="form-group">
                <label class="col-xs-2 control-label"><b>&nbsp;&nbsp;&nbsp;&nbsp;Processo:</b> </label>
            </div>
            <div class='col-md-2'>
                <div id="ds_processo"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="right">
                &nbsp;
                <button type="button" class="btn btn-secondary" id="cmdCancelarProcesso1">Retornar ao Lead</button>
            </div>
        </div>
       <div class="row">
            <div class="col-md-12">
                <div>
                    <hr>
                    <!--ETAPA 1-->
                    <h2 id="etapas_1"></h2>
                    <div id="inc_etapas_1"></div>  
                    <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_1' name='processos_etapas_pk_1'>
                    <!--ETAPA 2-->
                    <h2 id="etapas_2"></h2>
                    <div id="inc_etapas_2"></div>  
                    <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_2' name='processos_etapas_pk_2'>
                    <br>
                    <!--ETAPA 3-->
                    <h2 id="etapas_3"></h2>
                    <div id="inc_etapas_3"></div>  
                    <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_3' name='processos_etapas_pk_3'>
                    <br>
                     <!--ETAPA 4-->
                    <h2 id="etapas_4"></h2>
                    <div id="inc_etapas_4"></div>  
                    <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_4' name='processos_etapas_pk_4'>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="right">
                &nbsp;
                <button type="button" class="btn btn-secondary" id="cmdCancelarProcesso">Retornar ao Lead</button>
            </div>
        </div>
       
    </form>
    <!--MODAL CONTRATOS-->
    <style>
        .modal .modal-dialog { width: 100%; } 
    </style>
</div>
<?
include_once "../inc/php/footer.php";
?>
