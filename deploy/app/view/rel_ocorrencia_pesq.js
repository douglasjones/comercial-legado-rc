var tblResultado;
var click_id = 0;



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
   
    sendPost('rel_ocorrencia_res.php', {token: token, polos_pk: $("#polos_pk").val(),
            "ds_lead": $("#ds_lead").val(),
            "tipos_ocorrencias_pk": $("#tipo_ocorrencia_res_pk").val(),
            "ic_status": $("#ic_status").val(),
            "usuario_cadastro_pk": $("#usuario_cadastro_res_pk").val(),
            "dt_cadastro": $("#dt_cadastro").val(),
            "dt_cadastro_fim": $("#dt_cadastro_fim").val()
            });
    
    
}

function fcCarregarPolo(){
    var objParametros = {
        "pk": ""
    };      
    
   var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros);    
   carregarComboAjax($("#polos_pk"), arrCarregar, "", "pk", "ds_polo");         
}

function fcCarregarTipoOcorrenciaRes(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros);    
    carregarComboAjax($("#tipo_ocorrencia_res_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");        
}

function fcCancelar(){
    sendPost("menu_relatorios.php", {token: token});
}

function fcCarregarComboUsuarioRes(){    
    var objParametros = {
        "pk": ""
    };  
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#usuario_cadastro_res_pk"), arrCarregar, " ", "pk", "ds_usuario");        
}

$(document).ready(function(){
    /*var arrCarregar = permissao("ocorrencia", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
    
    
    
    
    //carrega cadastro ini
    $('#dt_cadastro').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_cadastro").keypress(function(){
       mascara(this,mdata);
    });
        
    //carrega cadastro fim
    $('#dt_cadastro_fim').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_cadastro_fim").keypress(function(){
       mascara(this,mdata);
    });
    
    fcCarregarTipoOcorrenciaRes();    
    fcCarregarComboUsuarioRes();    
    fcCarregarPolo();    
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdCancelar', fcCancelar); 

});