<?

include_once "../inc/php/header.php";

?>
<script src="rel_agendamento_pesq.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Agendamento</h2>
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
                <label for="ds_razao_social">Razão Social:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_razao_social' name='ds_razao_social' >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipos_agendas_pk'>Tipo agendamento: </label>

                <select class='form-control form-control-sm'  id='tipos_agendas_pk' name='tipos_agendas_pk'>
                    <option value=""></option>
                    <option value="1">Prospecção</option>
                    <option value="2">Reunião</option>
                    <option value="3">Fechamento</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Status:&nbsp;</label>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-1">
                <label for="ic_status">Produtivo&nbsp;<input type='checkbox' class='form-control form-control-sm ' id='ic_status_1' name='ic_status[]' value="1" /> </label>
            </div>
            <div class="col-md-1">
                <label >Improdutivo&nbsp;<input type='checkbox' class='form-control form-control-sm ' id='ic_status_2' name='ic_status[]' value="2" /></label>
                
            </div>
            <div class="col-md-1">
                <label>Reagendado&nbsp;<input type='checkbox' class='form-control form-control-sm ' id='ic_status_3' name='ic_status[]' value="3" /></label>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Data Agendamento:&nbsp;</label>
               
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                 <input type='text' class='form-control form-control-sm col-md-10' id='dt_agenda_ini' name='dt_agenda_ini' > 
            </div>
            <div class="col-md-2">
                
                <input type='text' class='form-control form-control-sm col-md-10' id='dt_agenda_fim' name='dt_agenda_fim' >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Data Visita:&nbsp;</label>
               
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                 <input type='text' class='form-control form-control-sm col-md-10' id='dt_visita_ini' name='dt_agenda_ini' > 
            </div>
            <div class="col-md-2">
                
                <input type='text' class='form-control form-control-sm col-md-10' id='dt_visita_fim' name='dt_agenda_fim' >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="mailing_pk">Mailing:&nbsp;</label>
                <select id="mailing_pk" class="form-control form-control-sm" name="mailing_pk">
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
