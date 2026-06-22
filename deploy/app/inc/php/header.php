<?
    include_once "pre_header.php";
    $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : session_id();

    $arrDados = array();

    $arrDados = tratarToken($token);

    $grupos_pk =  $arrDados['grupos_pk'];
    
    
?>
<html>
    <head>

    <? include_once PATH.'inc/php/scripts.php';?>
    <script>

        <?        
            criarConstantesPost();     
        ?>

var span = document.querySelector("#time");

countDown(0);
function countDown(counter) {
    
    var interval = setInterval(function() {
    var minutes = ((counter / 60) | 0) + "";
    var seconds = (counter % 60) + "";
    var format = "" +

    new Array(3 - minutes.length).join("0") + minutes + ":" + new Array(3 - seconds.length).join("0") + seconds;
    
    //span.innerHTML = format;
    counter++;
    
       if (seconds == 599) {
            
            // Verifica se exite Retorno em aberto    
            var url = "../controller/retorno.controller.php?job=listarRerornoPopUp&token="+token; 
           
            //pega as informações
            $.getJSON(url, function(result) {
                for(i = 0; i < result.data.length; i++){
                   if(result.data[i]['t_qtde_retorno']>0){               

                        var width = 1100;
                        var height = 600;

                        var left = 250;
                        var top = 150;
                        var URL = "../view/retorno_popup.php?token="+token;
                        window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
                   }
                }
             }); 
       }
    }, 1e3)
}

function timerReset() {
countDown(0);

}
function fcCarregarUsuario(){
    
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
    $("#usuario_login_sessao").text(arrCarregar.data[0]['ds_usuario']);
    
        
}
function fcVerificarConta(){
    
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("conta", "verificarConta", objParametros); 
    if(arrCarregar.data[0]['ic_status']==2){
        sendPost("../index.php", {token: token});
    } 
        
}

function fcPesquisarLead(){
    var arrCarregar = permissao("lead_pesquisar", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    sendPost("pesquisar_lead_res.php", {token: token,pesquisar:$("#pesquisar").val()});
}

$(document).ready(function(){    
    fcCarregarUsuario();   
    fcVerificarConta();
   $(document).on('click', '#cmdPesquisarLead', fcPesquisarLead);
   
   
});


    

    </script>

<body>
<!-- MENU -->
<nav class="navbar navbar-expand-lg navbar-dark " >
    <a class="navbar-brand" target="_new" href="http://www.gepros.com.br"><img class="img-responsive" src="<?= PATH;?>img/logo_branco.png" ></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample05" >
        <ul class="navbar-nav mr-auto">
            <?if(permissao("menu_meu_gepros", "cons", $token)){?>
                <li class="nav-item">
                    <?if($grupos_pk==2){?>
                        <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/dashboard_consultor_res_form.php');">
                            Meu Gepros
                        </a>  
                    <?}
                    else if($grupos_pk==3){?>
                        <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/dashboard_gestor_res_form.php');">
                            Meu Gepros
                        </a>  
                    <?}
                    else if($grupos_pk==4){?>
                        <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/dashboard_supervisor_res_form.php');">
                            Meu Gepros
                        </a>  
                    <?}
                    else if($grupos_pk==6){?>
                        <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/dashboard_telemarket_res_form.php');">
                            Meu Gepros
                        </a>  
                    <?}
                    else{?>    
                        <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/dashboard_res_form.php');">
                            Meu Gepros
                        </a> 
                    <?}?>
                    
                </li>
            <?}?>
            <?if(permissao("menu_leads", "cons", $token)){?>
                <li class="nav-item">
                    <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/lead_res_form.php');">
                        Leads
                    </a> 
                </li>
            <?}?>
            <?if(permissao("menu_agendas", "cons", $token)){?>
                <li class="nav-item">
                    <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/agenda_res_form.php');">
                        Ag. Visita
                    </a> 
                </li>
            <?}?>
            <?//if(permissao("menu_agendas_retorno", "cons", $token)){?>
                <li class="nav-item">
                    <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/agenda_retorno_res_form.php');">
                        Ag. Retorno
                    </a> 
                </li>
            <?//}?>
            <?if(permissao("menu_relatorios", "cons", $token)){?>
                <li class="nav-item">
                    <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_relatorios.php');">
                        Relatórios
                    </a> 
                </li> 
            <?}?>
            <?if(permissao("menu_administracao", "cons", $token)){?>
                <li class="nav-item">
                    <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_administracao.php');">
                        Administração
                    </a> 
                </li>   
            <?}?>
            <?if(permissao("menu_cpainel", "cons", $token)){?>
                <li class="nav-item">
                    <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/menu_cpainel.php');">
                        CPainel
                    </a> 
                </li>   
            <?}?>
            <li class="nav-item">
                <a class="nav-link" href="javascript: abrirMenu('<?= PATH;?>view/logoff.php');">
                    Sair
                </a> 
            </li>  
            <div class="form-inline mt-2 mt-md-0">
                <i class="fa fa-user" aria-hidden="true" style="font-size: 20px;color:white" ></i> 
                &nbsp;
                <div style="color:white" id="usuario_login_sessao"></div>
            </div> 
            <li class="nav-item">
              <a class="nav-link" href="#">
                  &nbsp;
              </a> 
            </li>                
        </ul>
        <div class="form-inline mt-2 mt-md-0">
            <input class="form-control-sm" type="text" id="pesquisar" placeholder="Pesquisar" aria-label="Pesquisar">
            &nbsp;
            <button class="btn btn-outline-warning btn-sm" type="button" id="cmdPesquisarLead">Pesquisar</button>
            
        </div>
    </div>
</nav>
<!-- FIM DO MENU -->

<main>

