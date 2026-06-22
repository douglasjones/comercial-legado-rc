<?
include_once "../inc/php/header.php";
?>
<script src="rel_funil_vendas_res.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container col-md-10">
    <div class="row">
        <div class="col-md-4">
            &nbsp;
        </div>
        <div class="col-md-4" align="center">

            <button type="button" class="btn" id="cmdExport">Export</button>
            <button type="button" class="btn" id="cmdCancelar">Voltar</button>
        </div>
    </div>
    <form id='form'>
        <table>
            <tr>
                <td>
                    <h2>Funil de Vendas</h2>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <b>Dt Emissão:</b>
                </td>
                <td>
                    <div id="dt_emissao"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Usuário Emissão:</b>
                </td>
                <td>
                    <div id="ds_usuario_logado"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Polo:</b>
                </td>
                <td>
                   <div id="ds_polo"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Lead:</b>
                </td>
                <td>
                   <div id="ds_lead"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Perfil:</b>
                </td>
                <td>
                   <div id="ds_grupo"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Responsável:</b>
                </td>
                <td>
                   <div id="ds_responsavel"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Data Envio:</b>
                </td>
                <td>
                   <div id="dt_envio_ini"></div>
                   
                </td>
                <td>
                   <div id="dt_envio_fim"></div>
                   
                </td>
            </tr>
            <tr>
                <td>
                     <b>Data Prev. Fechamento:</b>
                </td>
                <td>
                   <div id="dt_prev_fechamento_ini"></div>
                   
                </td>
                <td>
                   <div id="dt_prev_fechamento_fim"></div>
                   
                </td>
            </tr>
            <tr>
                <td>
                     <b>Data Fechamento:</b>
                </td>
                <td>
                   <div id="dt_fechamento_ini"></div>
                   
                </td>
                <td>
                   <div id="dt_fechamento_fim"></div>
                   
                </td>
            </tr>
        </table>        
        <hr>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div id="form_grid">
                    <div id="grid"></div>
                </div>
            </div>
        </div>
    </form>
    
</div>
<?
include_once "../inc/php/footer.php";
?>

