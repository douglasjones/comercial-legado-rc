<?php
include "../inc/php/header.php";
$token = $_REQUEST['token'];
?>
<div class="container">  
    <div class="row">
        <div class="col-sm">
            <h2>Cadastros</h2> 
        </div>
    </div> 
    <hr>
    <div class="row">
        <hr>
        <div class="col-sm">                        
            <div class="text-left">  
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('cargo_res_form.php');">
                        <img src=../img/funcao.png width="4%">&nbsp;Cargos
                    </a>
                </div>
            </div>
            <Br>
            <div class="text-left">  
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('motivo_pausa_res_form.php');">
                        <img src=../img/ausencia.png width="4%">&nbsp;Motivos Pausa
                    </a>
                </div>
            </div>            
            <Br>
            <div class="text-left">  
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('equipe_res_form.php');">
                        <img src=../img/equipe.png width="4%">&nbsp;Equipes
                    </a>
                </div>
            </div>            
            <Br>
            <div class="text-left">  
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('genero_res_form.php');">
                        <img src=../img/genero.png width="4%">&nbsp;Gêneros
                    </a>
                </div>
            </div>                        
            <Br>
            <div class="text-left">  
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('produto_servico_res_form.php');">
                        <img src=../img/produto_servico.png width="4%">&nbsp;Produtos/Serviços
                    </a>
                </div>
            </div> 
            <Br>
            <div class="text-left">  
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('processo_default_res_form.php');">
                        <img src=../img/processo.png width="4%">&nbsp;Processos Default
                    </a>
                </div>
            </div>            
            <Br>
            <div class="text-left">  
                <div class=' col-sm text-left'>
                    <a href="javascript: abrirMenu('tipo_ocorrencia_res_form.php');">
                        <img src=../img/tipos_ocorrencia.png width="4%">&nbsp;Tipos Ocorrências
                    </a>
                </div>
            </div>            
        </div>
    </div>    
</div>    
<?php
include "../inc/php/footer.php";
?>
