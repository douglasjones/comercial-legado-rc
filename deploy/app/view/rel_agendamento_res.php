<?
include_once "../inc/php/header.php";
?>
<script src="rel_agendamento_res.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                    <h2>Agendamento</h2>
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
                    <b>Perfil:</b>
                </td>
                <td>
                   <div id="ds_grupo"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Responsavel:</b>
                </td>
                <td>
                   <div id="ds_responsavel"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Razão Social:</b>
                </td>
                <td>
                   <div id="ds_razao_social"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Tipo Agenda:</b>
                </td>
                <td>
                   <div id="ds_tipos_agendas"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Status:</b>
                </td>
                <td>
                   <div id="ds_status"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Mailing:</b>
                </td>
                <td>
                   <div id="ds_mailing"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>DT. Agendamento:</b>
                </td>
                <td>
                   <div id="dt_agendamento"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>DT. Visita:</b>
                </td>
                <td>
                   <div id="dt_visita"></div>
                </td>
            </tr>
        </table>
        <hr>
        <div class="container" id="exibir_informativo_agenda"> 
            <div class="row">
                <div class="container">
                    <div class="modal-content">
                        <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <div class="widget green-1 animated fadeInDown" style="background-color:#white;box-shadow: 0px 0px 0px white;" >
                                        <div class="widget-content padding">
                                            <div class="text-center">
                                                <div class="text-box">
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <h1><div id="qtde_registro"></div></h1>                       
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="widget-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    &nbsp;
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--GRAFICO 1---->
                                <div class="col-lg-4 col-md-3">
                                    <div id="classificacao"></div>
                                    <div class="widget-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <!--GRAFICO 2---->
                                <div class="col-lg-6 col-md-5">
                                    <div id="agendado_por"></div>
                                    <div class="widget-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>                                            
                    </div>
                </div> 
            </div>
        </div>      
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
