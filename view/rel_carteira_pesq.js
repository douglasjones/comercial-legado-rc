var tblResultado;
var click_id = 0;
var usuarioLogado = null;



function fcValidarForm(){

    $("#form").validate({
        rules :{

        },
        messages:{
        },
        submitHandler: function(form){
            fcCarregarGrid(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcCarregarGrid(){
    sendPost('rel_carteira_res.php', {token: token,equipes_pk:$("#equipes_pk").val(), polos_pk: $("#polos_pk").val(),ds_lead: $("#ds_lead").val(),leads_pk: $("#leads_pk").val(),grupos_pk:$("#grupos_pk").val(),responsavel_pk:$("#usuarios_pk").val()});
    
    
}

function fcCarregarPolo(){    
    var objParametros = {
        "pk": ""
    };      
    
   var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros);    
    carregarComboAjax($("#polos_pk"), arrCarregar, "", "pk", "ds_polo");        
}


function fcCarregarPerfil(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);   
    
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#grupos_pk"), arrCarregar, "", "pk", "ds_grupo");
    }
    else{
        carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
    }
    
        
}
function fcCarregarEquipes(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("equipe", "listarTodos", objParametros);   
    
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#equipes_pk"), arrCarregar, "", "pk", "ds_equipe");
    }
    else{
        carregarComboAjax($("#equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
    }
    
        
}

function fcCarregarResponsavel(){
    if(usuarioLogado !== null && parseInt(usuarioLogado.grupos_pk, 10) === 2){
        $("#usuarios_pk").html("<option value='" + usuarioLogado.pk + "' selected>" + usuarioLogado.ds_usuario + "</option>");
        $("#usuarios_pk").prop("disabled", true);
        return;
    }
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros);  
    
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#usuarios_pk"), arrCarregar, "", "pk", "ds_usuario");
    }
    else{
        carregarComboAjax($("#usuarios_pk"), arrCarregar, " ", "pk", "ds_usuario");
    }
    $("#usuarios_pk").prop("disabled", false);
    
    
        
}

function fcCarregarUsuarioLogado(){
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros);
    if(arrCarregar.data.length > 0){
        usuarioLogado = arrCarregar.data[0];
    }
}

function fcCancelar(){
    sendPost("menu_relatorios.php", {token: token});
}

$(document).ready(function(){    
    
    var arrCarregar = permissao("agendamento", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
        
    
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
    fcCarregarUsuarioLogado();
    fcCarregarPolo();
    fcCarregarEquipes();
    fcCarregarPerfil();
    
    fcCarregarResponsavel();
    $("#grupos_pk").change(function(){
        fcCarregarResponsavel();
    });
    $("#leads_pk").keypress(function(){
            mascara(this,soNumeros );
    });
    

});


