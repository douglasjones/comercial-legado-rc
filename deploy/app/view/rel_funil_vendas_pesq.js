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
   
    sendPost('rel_funil_vendas_res.php', {token: token, polos_pk: $("#polos_pk").val(),
            leads_pk: $("#leads_pk").val(),
            responsavel_pk: $("#responsavel_pk").val(),
            grupos_pk: $("#grupos_pk").val(),
            dt_envio_ini: $("#dt_envio_ini").val(),
            dt_envio_fim: $("#dt_envio_fim").val(),
            dt_prev_fechamento_ini: $("#dt_prev_fechamento_ini").val(),
            dt_prev_fechamento_fim: $("#dt_prev_fechamento_fim").val(),
            dt_fechamento_ini: $("#dt_fechamento_ini").val(),
            dt_fechamento_fim: $("#dt_fechamento_fim").val()
            });
    
    
}

function fcCarregarPolo(){
    var objParametros = {
        "pk": ""
    };      
    
   var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros);    
   carregarComboAjax($("#polos_pk"), arrCarregar, "", "pk", "ds_polo"); 
        
}

function fcCarregarLead(){
    
    var objParametros = {
        "pk": ""
    };      

    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 

    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
        
}


function fcCancelar(){
    sendPost("menu_relatorios.php", {token: token});
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
        $("#responsavel_pk").html("<option value='" + usuarioLogado.pk + "' selected>" + usuarioLogado.ds_usuario + "</option>");
        $("#responsavel_pk").prop("disabled", true);
        return;
    }
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros);  
    
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#responsavel_pk"), arrCarregar, "", "pk", "ds_usuario");
    }
    else{
        carregarComboAjax($("#responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
    }
    $("#responsavel_pk").prop("disabled", false);
    
    
        
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
$(document).ready(function(){ 
    
    var arrCarregar = permissao("funil_venda", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem Permissão');
        return false;
    }
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    
    fcCarregarUsuarioLogado();
    fcCarregarPolo();
    fcCarregarLead();
    fcCarregarPerfil();
    fcCarregarResponsavel();
    $("#grupos_pk").change(function(){
        fcCarregarResponsavel();
    });
    
    $('#dt_envio_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    
    $('#dt_envio_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    
    $('#dt_prev_fechamento_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    
    $('#dt_prev_fechamento_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    
    $('#dt_fechamento_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    
    $('#dt_fechamento_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

});


