<?
include_once "../inc/php/header.php";
include("inc_ocorrencia_cad_form.php");
?>

<script src="ocorrencia_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Ocorrências</h2>
        </div>
    </div>
    <form method="post">
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-8'>
                <label for="ds_lead">Lead:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_lead" required="true">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Tipo Ocorrência&nbsp;</label>
                <select class='form-control form-control-sm'  id='tipo_ocorrencia_res_pk' name='tipo_ocorrencia_res_pk' />
                    <option></option>
                </select>
            </div>  
           <div class="col-md-2">
                <label for="ic_status">Status Ocorrências:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value=""></option>
                    <option value="1">Aberta</option>
                    <option value="2">Fechada</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Usuário de Cadastro&nbsp;</label>
                <select class='form-control form-control-sm'  id='usuario_cadastro_res_pk' name='usuario_cadastro_res_pk' />
                    <option></option>
                </select>    
            </div> 
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Data Abertura Oc Ini</label>
                    <input type='text' class=" form-control form-control-file" id="dt_cadastro" name="dt_cadastro"/>
                </div>
            </div>  
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Data Abertura Oc Fim</label>
                    <input type='text' class=" form-control form-control-file" id="dt_cadastro_fim" name="dt_cadastro_fim"/>
                </div>    
            </div>      
        </div>        
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>                
            </div>
        </div>
    </form>
</div>   

<div class="row">
    <div class="col-md-1">
        &nbsp;
    </div>
    <div class="col-md-10">
    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
        <thead>
            <tr>
                <th>Cód</th>
                <th>Lead</th>                    
                <th>Dt Cad OC</th>
                <th>Tipo OC</th>
                <th>Tipo Ocorrência_pk</th>
                <th>Descr OC</th> 
                <th>Usuário Cad</th>
                <th>Dt Fech OC</th>                    
                <th>Agendado Para</th>
                <th>Dt Retorno</th>
                <th>Descr Retorno</th>
                <th>Dt Fech Retorno</th>                
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table> 
    </div>    
    <div class="col-md-1">
        &nbsp;
    </div>
</div>  

<?
include_once "../inc/php/footer.php";
?>
