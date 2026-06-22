<?
include_once "../inc/php/header.php";
?>

<script src="produto_servico_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Produtos/Serviços</h2>
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
                <label for='ds_equipe'>Tipo Produto:&nbsp;</label>
                <select class='form-control form-control-sm' id='tipo_produto_pk' name='tipo_produto_pk'>
                    <option></option>
                    <option value="1">Produto</option>
                    <option value="2">Serviço</option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_equipe'>Book:&nbsp;</label>
                <select class='form-control form-control-sm' id='book_pk' name='book_pk'>
                    <option></option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_equipe'>Operadora:&nbsp;</label>
                <select class='form-control form-control-sm' id='operador_pk' name='operador_pk'>
                    <option></option>
                </select>
            </div>
        </div>
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
                <label for='ds_produto_servico'>Produto/Serviço:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_produto_servico' name='ds_produto_servico' required >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_produto_servico'>Valor Aberto:&nbsp;</label>
                <input type='checkbox' class='form-control form-control-sm' id='ic_valor_aberto' name='ic_valor_aberto' >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_produto_servico'>Valor Produto/Serviço:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='vl_produto_servico' name='vl_produto_servico' required >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ic_status'>Status&nbsp;</label>
                <select class="form-control form-control-sm" id="ic_status" name="ic_status">
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
