<?
include_once "../inc/php/pre_header.php";

?>
<script src="inc_usuario_polos_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class='row'>
        <div class='col-md-12'>
            <button type="button" id="btn_modal" class="btn btn-secondary" >Novo Polo</button>
        </div>
    </div>
    <br>
    <div class='col-md-3' id="alert_polo" style="display:none" >
        <strong style="color: red">Selecione um Polo</strong>
    </div>
    <br>
    <div class="row" id="ic_grid">
        <div class="col-md-12">
            <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblPolo">
                <thead >
                    <tr>
                        <th>Código</th>   
                        <th>Polo_pk</th>     
                        <th>Polo</th>     
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>