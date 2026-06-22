<?php
include_once "../inc/php/header.php";
//recebe o token
$token = $_REQUEST['token'];

$arrDados = array();

$arrDados = tratarToken($token);

$grupos_pk =  $arrDados['grupos_pk'];


?>

<input type="hidden" id="grupos_pk" name="grupos_pk" value="<?=$grupos_pk?>">
<script>

$(document).ready(function()
    {
  
    //sendPost("teste.php", {token: token});
    var arrCarregarPermissaoAcesso = permissao("menu_meu_gepros", "cons");
    if(arrCarregarPermissaoAcesso.result == 'success'){
        
        if(<?=$grupos_pk?>==2){
            
            sendPost("dashboard_consultor_res_form.php", {token: token});
            //sendPost("dashboard_res_form.php", {token: token});
           
        }
        if(<?=$grupos_pk?>==3){
            sendPost("dashboard_gestor_res_form.php", {token: token});
        }
        if(<?=$grupos_pk?>==5){
            sendPost("dashboard_supervisor_res_form.php", {token: token});
        }
        if(<?=$grupos_pk?>==6){
            sendPost("dashboard_telemarket_res_form.php", {token: token});
        }
        if(<?=$grupos_pk?>==4){
            sendPost("dashboard_res_form.php", {token: token});
        }
    }

    }
);

</script>

<?php
include_once "../inc/php/footer.php";
?>
