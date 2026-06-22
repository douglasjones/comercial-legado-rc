<?
include_once "../inc/php/header.php";
?>

<script src="grupo_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Grupos</h3>
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
                <label for='ds_equipe'>Polos:&nbsp;</label>
                <select class='form-control form-control-sm' id='polos_pk' name='polos_pk'>
                    <option></option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_grupo'>Grupo: </label>
                <input type='text' class='form-control form-control-sm' id='ds_grupo' name='ds_grupo' required >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblPermissoes">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Cons</th>
                            <th>Ins</th>
                            <th>Upd</th>
                            <th>Del</th>
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
        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
        </div>
        
        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
        </div>        
        <div class="row">
            <div class="col-md-12" align="center">
                <hr>
                <button type="submit" class="btn" id="cmdEnviar">Enviar</button>
                &nbsp;&nbsp;
                <button type="button" class="btn" id="cmdCancelar">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<?
include_once "../inc/php/footer.php";
?>
