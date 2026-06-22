<?
/*include_once "../inc/php/pre_header.php";
$token = $_REQUEST['token'];

$arrDados = array();

$arrDados = tratarToken($token);

$grupos_pk =  $arrDados['grupos_pk'];*/

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>

<div class="row">
    <div class='col-md-2'>
        <label for='ds_cep'>Cep: </label>

        <input type='text' class='form-control form-control-sm' maxlength="9"  id='ds_cep' name='ds_cep' required>
    </div>
    <div class='col-md-4'>
        <label for='ds_enderco'>Retorno: </label>
        <textarea type='text' class='form-control form-control-sm'  id='retorno' name='retorno' ></textarea>
    </div>
</div>
<script>
/*function fcCarregarCep(){
   var cpf = $("#ds_cep").val();

    if(cpf.length == 9){
        
        var objParametros = {
            "ds_cep": $("#ds_cep").val()
        };        
        var url = "../controller/cep.controller.php?job=buscarCep&ds_cep="+$("#ds_cep").val();
        var arrCarregar = carregarController("cep", "buscarCep", objParametros);
        
        
        
        sendPost(url, {token: token});
        
        if (arrCarregar.result == 'success'){

            $("#retorno").text(arrCarregar.mysql_dados);
            

        }
        else{
            alert('Falhar ao carregar o registro');
        }
       
    }
       
}     
    
    
    
    
$(document).ready(function(){
    $("#ds_cep").keypress(function(){
        mascara(this,cep);
     });
    $("#ds_cep").change(function(){
        fcCarregarCep();
    });
    
});*/
</script>

</body>
</html>
