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
    var v_ic_status_1 = "";
    var v_ic_status_2 = "";
    var v_ic_status_3 = "";
    
    if($('#ic_status_1').is(":checked")){
        v_ic_status_1 = 1;
    }
    else{
        v_ic_status_1 = "";
    }
    
    if($('#ic_status_2').is(":checked")){
        v_ic_status_2 = 2;
    }
    else{
        v_ic_status_2 = "";
    }
    if($('#ic_status_3').is(":checked")){
        v_ic_status_3 = 3;
    }
    else{
        v_ic_status_3 = "";
    }
    sendPost('rel_agendamento_res.php', {token: token, polos_pk: $("#polos_pk").val(),ds_razao_social: $("#ds_razao_social").val(),tipos_agendas_pk: $("#tipos_agendas_pk").val(),ic_status_1: v_ic_status_1,ic_status_2: v_ic_status_2,ic_status_3: v_ic_status_3,dt_agenda_ini: $("#dt_agenda_ini").val(), dt_agenda_fim: $("#dt_agenda_fim").val(), mailing_pk: $("#mailing_pk").val(),grupos_pk:$("#grupos_pk").val(),responsavel_pk:$("#usuarios_pk").val(),dt_visita_ini:$("#dt_visita_ini").val(),dt_visita_fim:$("#dt_visita_fim").val()});
    
    
}

function fcCarregarPolo(){    
    var objParametros = {
        "pk": ""
    };      
    
   var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros);    
    carregarComboAjax($("#polos_pk"), arrCarregar, "", "pk", "ds_polo");        
}

function fcCarregarMailing(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("mailing", "listarPorContasPk", objParametros); 
   
    carregarComboAjax($("#mailing_pk"), arrCarregar, " ", "pk", "ds_mailing");
        
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
    fcCarregarMailing();
    
    fcCarregarPerfil();
    
    fcCarregarResponsavel();
    $("#grupos_pk").change(function(){
        fcCarregarResponsavel();
    });
    
    $('#dt_agenda_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    
    $('#dt_agenda_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    
    $('#dt_visita_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    
    $('#dt_visita_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

});


