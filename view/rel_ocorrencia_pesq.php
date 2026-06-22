<?

include_once "../inc/php/header.php";

?>
<script src="rel_ocorrencia_pesq.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Ocorrência</h2>
        </div>
    </div>
    <form id="form" class="form">
        <div class="row">
            <div class="col-md-2">
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
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-8'>
                <label for="ds_lead">Lead:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_lead" >
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
                 <button type="submit" class="btn" id="cmdEnviar">Enviar</button>
                <button type="button" class="btn" id="cmdCancelar">Voltar</button>        
            </div>
        </div>
    </form>
</div>
<?
include_once "../inc/php/footer.php";
?>
