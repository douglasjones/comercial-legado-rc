<?php

function encontrarMainInclude(){
    $arrURL = explode("/", $_SERVER["REQUEST_URI"]);
    $strURL = "";
    $url = "";
    

    $intRetorno = 0;
    for($i = (count($arrURL)-1); $i > 0; $i--){

        $strURL .= "../";
        $url = $strURL."inc/php/maininclude.php";
        
        //Verifica se o arquivo libs/maininclude existe;
        if(is_file($url)){
            break;
        }
    }
    return $strURL;
}
//Determina o caminho de todos os includes
$strPath = encontrarMainInclude();
session_start();
define("PATH", $strPath);

$ds_login = $_REQUEST['ds_login'];
?>
<html>
    <head>
    <?php include_once '../inc/php/scripts.php';?>
    </head>
<style>
    @import "bourbon";

    .wrapper {
        margin-top: 80px;
        margin-bottom: 80px;
    }
    .form-signin {
      max-width: 380px;
      padding: 15px 35px 45px;
      margin: 0 auto;
      background-color: #fff;
      border: 1px solid rgba(0,0,0,0.1);


    }
    .login-wrap .login-input {
        position: relative;
      }
</style>
<script src="nova_senha.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>  
<br>
<br>
<br>
<div class="container">
    <div class="wrapper">
        <form id="form_trocar_senha" class="form-signin" >
            <div class="row">
                <div class="col" align="center">
                     <img src="../img/nlogo.png"  width="100%">
                </div>              
            </div>
            <div class="row">
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col" align="center">
                     <input type="text" name="ds_login" class="form-control text-input" disabled id="ds_login" value="<?=$ds_login?>">
                     <br>
                     <input type="password" name="ds_nova_senha" id="ds_nova_senha" class="form-control text-input" placeholder="Senha">
                </div>             
            </div>
            <div class="row">
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col" align="center">
                     <input type="password" name="ds_confirmar_senha" id="ds_confirmar_senha" class="form-control text-input" placeholder="Confirme a senha">
                </div>             
            </div>
            <div class="row">
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col" align="center">
                    <button type="submit" class="btn btn-lg btn-primary btn-block" id="cmdConfirmarSenhaNova">Enviar</button>
                </div>               
            </div>
        </form>
    </div>
</div>
</html>
<?php
//include_once "../inc/php/footer.php";
?>