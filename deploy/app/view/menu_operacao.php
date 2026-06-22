<?php
include "../inc/php/header.php";
$token = $_REQUEST['token'];
?>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h2>Operação</h2>
        </div>
    </div>
    <hr>
    <div class="row">
        <hr>
        <div class="col-sm">
            <div class="text-left">
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('lead_res_form.php');">
                        <img src="../img/predio1.png" width="4%">&nbsp;Leads
                    </a>
                </div>
            </div>
            <br>
            <div class="text-left">
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('colaborador_res_form.php');">
                        <img src="../img/colaboradores.png" width="4%">&nbsp;Colaboradores
                    </a>
                </div>
            </div>
            <Br>
            <div class="text-left">
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('agenda_condominio_res_form.php');">
                        <img src="../img/eventos.png" width="4%">&nbsp;Agenda do Condomínio
                    </a>
                </div>
            </div>
            <Br>
            <div class="text-left">
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('agenda_colaborador_res_form.php');">
                        <img src="../img/eventos.png" width="4%">&nbsp;Agenda do Colaborador
                    </a>
                </div>
            </div>
            <br>
            <div class="text-left">
                <div class=' col-sm text-left'>
                    <!--<a href="javascript: abrirMenu('agenda_retorno_cad_form.php');">-->
                    <a href="javascript: abrirMenu('teste_calendario_res_form.php');">
                        <img src="../img/eventos.png" width="4%">&nbsp;Agenda de Retorno
                    </a>
                </div>
            </div>
            <Br>
            <div class="text-left">
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('Ocorrencia_res_form.php');">
                        <img src="../img/predio1.png" width="4%">&nbsp;Ocorrências
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "../inc/php/footer.php";
?>
