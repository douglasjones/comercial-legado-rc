<?

include_once "../inc/php/header.php";

?>
<script src="rel_funil_vendas_pesq.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Funil Vendas</h2>
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
                <select class='form-control form-control-sm'  id='responsavel_pk' name='responsavel_pk'>
                    <option></option>
                </select>
           </div>
            
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="leads_pk">Leads:&nbsp;</label>
                <select id="leads_pk" class="form-control form-control-sm" name="leads_pk">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Data Envio:&nbsp;</label>
               
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                 <input type='text' class='form-control form-control-sm col-md-10' id='dt_envio_ini' name='dt_envio_ini' > 
            </div>
            <div class="col-md-2">
                
                <input type='text' class='form-control form-control-sm col-md-10' id='dt_envio_fim' name='dt_envio_fim' >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Data Prev. Fechamento:&nbsp;</label>
               
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                 <input type='text' class='form-control form-control-sm col-md-10' id='dt_prev_fechamento_ini' name='dt_prev_fechamento_ini' > 
            </div>
            <div class="col-md-2">
                
                <input type='text' class='form-control form-control-sm col-md-10' id='dt_prev_fechamento_fim' name='dt_prev_fechamento_fim' >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Data Fechamento:&nbsp;</label>
               
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                 <input type='text' class='form-control form-control-sm col-md-10' id='dt_fechamento_ini' name='dt_fechamento_ini' > 
            </div>
            <div class="col-md-2">
                
                <input type='text' class='form-control form-control-sm col-md-10' id='dt_fechamento_fim' name='dt_fechamento_fim' >
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
