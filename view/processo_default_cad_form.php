<?
include_once "../inc/php/header.php";
?>

<script src="processo_default_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Processos default</h3>
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
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>Polo:&nbsp;</label>
               <select class='form-control form-control-sm'  id='polos_pk' name='polos_pk' />
                    <option></option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_processo_default'>Processo:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_processo_default' name='ds_processo_default' required >
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Status:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblEtapas">
                    <thead>
                        <tr>
                            <th>Ordem</th>
                            <th>Processo</th>
                            <th>Classificação</th>
                            <th>Tipo Ocorrência</th>
                            <th>Enviar E-mail Responsável</th>
                            <th>Enviar E-mail Lead</th>
                            <th>E-mail Saida Grupo</th>
                            <th>Desc. Email </th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12' align="center"> 
                <button type="button" class="btn" id="cmdIncluir" name="cmdIncluir">Incluir</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="center">
                <hr>
                <button type="submit" class="btn" id="cmdEnviar">Enviar</button>
                &nbsp;
                <button type="button" class="btn" id="cmdCancelar">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<?
include_once "../inc/php/footer.php";
?>
