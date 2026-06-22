<?
include_once "../inc/php/pre_header.php";

?>

<div class="container">
    <div class='row'>
        &nbsp;
    </div>    
    <div class='row'>
        <div class='col-md-12'>
            <button type="button" id="btn_modal_esteira" class="btn btn-secondary" >Nova Etapa</button>
        </div>
    </div>
    <br>
    <div class="row" id="ic_grid">
        <div class="col-md-12">
            <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblEsteira">
                <thead >
                    <tr>
                        <th>Cód</th>
                        <th>Tipo segmento_pk</th>
                        <th>Segmento</th> 
                        <th>Tipo operador_pk</th>
                        <th>Operadora</th>  
                        <th>Ordem</th> 
                        <th>Etapa</th>
                        <th>status_pk</th>
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

