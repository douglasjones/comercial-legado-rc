var tblResultado;
var click_id = 0;
function fcCarregarGrid(){
    
    
    var strRetorno = "";
    var strNenhumRegisto = "";
    
        var objParametros = {
            "polos_pk": polos_pk,
            "ds_razao_social": ds_razao_social,
            "ic_status_1": ic_status_1,
            "ic_status_2": ic_status_2,
            "ic_status_3": ic_status_3,
            "ic_status_4": ic_status_4,
            "grupos_pk": grupos_pk,
            "usuarios_pk": usuarios_pk,
            "tipo_pessoa_pk": tipo_pessoa_pk,
            "mailing_pk": mailing_pk,
            "operador_pk": operador_pk,
            "classificacao_operador_pk": classificacao_operador_pk,
            "tempo_contrato_pk": tempo_contrato_pk,
            "qtde_linhas_ini": qtde_linhas_ini,
            "qtde_linhas_fim": qtde_linhas_fim
            
        };         
        var arrCarregar = carregarController("transferencia_lead", "listarQtdeLead", objParametros); 
        
        if (arrCarregar.result == 'success'){
            
            if(arrCarregar.data.length > 0){
                var n_qtde_registros="";
                var ds_classificacao="";
                strRetorno+="<div class='container' ><div class='modal-content' style='box-shadow: 10px 10px 5px grey;'><div class='row'>&nbsp;</div>";
                strRetorno+="<div class='row'>";
                strRetorno+="<div class='col-md-1'>";
                strRetorno+="&nbsp;";
                strRetorno+="</div>";
               for(j=0; j < arrCarregar.data.length ;j++){

                    n_qtde_registros = arrCarregar.data[j]['qtde_registros'];
                    ds_classificacao = arrCarregar.data[j]['ds_classificacao'];
                    
                    if(ds_classificacao==null){
                        strRetorno+="<div class='col-md-3'>";
                        strRetorno+="<label><b>Sem status:</b>&nbsp;&nbsp; Total= "+n_qtde_registros+"&nbsp;&nbsp;</label>";
                        strRetorno+="<input class='form-control-sm form-control-sm col-sm-2' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_0'>";
                        strRetorno+="</div>";
                    }
                    if(ds_classificacao=="25%"){
                        strRetorno+="<div class='col-md-3'>";
                        strRetorno+="<label><b>"+ds_classificacao+":</b>&nbsp;&nbsp; Total= "+n_qtde_registros+"&nbsp;&nbsp;</label>";
                        strRetorno+="<input class='form-control-sm form-control-sm col-sm-2' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_1'>";
                        strRetorno+="</div>";
                    }
                    if(ds_classificacao=="50%"){
                        strRetorno+="<div class='col-md-3'>";
                        strRetorno+="<label><b>"+ds_classificacao+":</b>&nbsp;&nbsp; Total= "+n_qtde_registros+"&nbsp;&nbsp;</label>";
                        strRetorno+="<input class='form-control-sm form-control-sm col-sm-2' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_2'>";
                        strRetorno+="</div>";
                    }
                    if(ds_classificacao=="75%"){
                        strRetorno+="<div class='col-md-3'>";
                        strRetorno+="<label><b>"+ds_classificacao+":</b>&nbsp;&nbsp; Total= "+n_qtde_registros+"&nbsp;&nbsp</label>";
                        strRetorno+="<input class='form-control-sm form-control-sm col-sm-2' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_3'>";
                        strRetorno+="</div>";
                    }
                    if(ds_classificacao=="Cliente"){
                        strRetorno+="<div class='col-md-3'>";
                        strRetorno+="<label><b>"+ds_classificacao+":</b>&nbsp;&nbsp; Total= "+n_qtde_registros+"&nbsp;&nbsp</label>";
                        strRetorno+="<input class='form-control-sm col-sm-2' type='text' onkeypress='mascara(this,soNumeros)' id='qtde_transferencia_4'>";
                        strRetorno+="</div>";
                    }
                    
                }
                //COMBO COM O RESPONSAVEL QUE VAI RECEBER OS NOVOS LEADS
                strRetorno+="</div>";
                strRetorno+="<hr><br>";
                strRetorno+="<div class='row'>&nbsp;</div>";
                strRetorno+="<div class='row'><div class='col-md-5'>&nbsp;</div>";
                strRetorno+="<div class='col-md'><b>Transferir para:</b></div></div>";
                strRetorno+="<div class='row'>&nbsp;</div>";
                strRetorno+="<div class='row'><div class='col-md-2'>&nbsp;</div>";
                strRetorno+="<div class='col-md-4'><label for='grupos_pk'>Perfil: </label><select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk'><option></option></select></div>";
                strRetorno+="<div class='col-md-4'><label for='usuarios_pk'>Responsável: </label><select class='form-control form-control-sm'  id='usuarios_pk' name='usuarios_pk'><option></option></select></div></div>";
                strRetorno+="<div class='row'>&nbsp;</div>";
                strRetorno+="<div class='row'>&nbsp;</div>";
                
                //BOTÃO QUE ENVIA A TRANSFERENCIA
                strRetorno+="<div class='row'><div class='col-md-4'> &nbsp;</div><div class='col-md-8' align='right'><button type='button' class='btn btn-link' id='cmdEnviarTransferencia'><i class='fa fa-arrow-right' aria-hidden='true' style='font-size: 15px;' > Transferir</i></button></div></div>";
                
                strRetorno+="</div>";
                strRetorno+="</div>";
                
                
            }
            
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    
    
    if(strRetorno!=""){
        $("#grid").append(strRetorno);
    }
    else{
        
        strNenhumRegisto+="<div class='row'>";
        strNenhumRegisto+="<div class='col-md-12 text-center'>";
        strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
        strNenhumRegisto+=" </div>";
        strNenhumRegisto+="</div>";
        $("#grid").append(strNenhumRegisto);
    }
    
}

function fcCarregarPerfil(){
    
    var objParametros = {
        "pk": grupos_pk
    };      
    
    var arrCarregar = carregarController("grupo", "listarPk", objParametros);   

    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
        
}

function fcCarregarResponsavel(){
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros);    
    carregarComboAjax($("#usuarios_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}


//SALVA O CONTRATO
function fcRealizarTransferencia(){
    
    
    if($("#qtde_transferencia_0").val()!=undefined){
        var qtde_transferencia_0 = $("#qtde_transferencia_0").val();
    }
    else{
        var qtde_transferencia_0 = 0;
    }
    if($("#qtde_transferencia_1").val()!=undefined){
       var qtde_transferencia_1 = $("#qtde_transferencia_1").val();
    }
    else{
        var qtde_transferencia_1 = 0;
    }
    
    if($("#qtde_transferencia_2").val()!=undefined){
       var qtde_transferencia_2 = $("#qtde_transferencia_2").val();
    }
    else{
        var qtde_transferencia_2 = 0;
    }
    
    if($("#qtde_transferencia_3").val()!=undefined){
       var qtde_transferencia_3 = $("#qtde_transferencia_3").val();
    }
    else{
        var qtde_transferencia_3 = 0;
    }
    
    if($("#qtde_transferencia_4").val()!= undefined){
       var qtde_transferencia_4 = $("#qtde_transferencia_4").val();
    }
    else{
        var qtde_transferencia_4 = 0;
    }
    
    total_transferencia = Number(qtde_transferencia_0) + Number(qtde_transferencia_1) + Number(qtde_transferencia_2) + Number(qtde_transferencia_3) + Number(qtde_transferencia_4) ;
    //TIPO EVENTO 
    var objParametros = {
        "polos_pk": polos_pk,
        "ds_razao_social": ds_razao_social,
        "ic_status_1": ic_status_1,
        "ic_status_2": ic_status_2,
        "ic_status_3": ic_status_3,
        "ic_status_4": ic_status_4,
        "usuarios_pk": usuarios_pk,
        "grupos_pk": grupos_pk,
        "tipo_pessoa_pk": tipo_pessoa_pk,
        "mailing_pk": mailing_pk,
        "operador_pk": operador_pk,
        "classificacao_operador_pk": classificacao_operador_pk,
        "tempo_contrato_pk": tempo_contrato_pk,
        "qtde_linhas_ini": qtde_linhas_ini,
        "qtde_linhas_fim": qtde_linhas_fim,
        "responsavel_pk":$("#usuarios_pk").val(),
        "grupo_responsavel":$("#grupos_pk").val(),
        "total_transferencia":total_transferencia,
    };
    
     
    var arrEnviar = carregarController("transferencia_lead", "transferirLead", objParametros);   
    
    if (arrEnviar.result == 'success'){
        alert("Lead transferido com sucesso !!!");
        sendPost('menu_administracao.php', {token: token });
    }    
    else{
        alert(arrEnviar.result);
    }
    return true;
    
}


$(document).ready(function(){ 
    /*var arrCarregar = permissao("transferencia", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
    $(document).on('click', '#cmdEnviarTransferencia', fcRealizarTransferencia);
    fcCarregarGrid();
    fcCarregarPerfil();

    $("#grupos_pk").change(function(){
        fcCarregarResponsavel();
    });
});


