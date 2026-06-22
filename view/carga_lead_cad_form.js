function fcValidarForm(){

    $("#form").validate({
        rules :{
            mailng_pk:{
                required:true
            },
            polos_pk:{
                required:true
            }
            ,
            ic_cliente:{
                required:true
            }

        },
        messages:{
            mailng_pk:{
                required:"Por favor, selecione Mailing"
            },
            polos_pk:{
                required:"Por favor, selecione Polo"
            }
            ,
            ic_cliente:{
                required:"Por favor, selecione Cliente"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_mailng_pk = $("#mailing_pk").val();
    var v_polos_pk = $("#polos_pk").val();
    var v_arquivo = $("#ds_arquivo").text();

    var objParametros = {
        "pk": pk,
        "mailing_pk": (v_mailng_pk),
        "polos_pk": (v_polos_pk),
        "ds_arquivo": (v_arquivo),
        "grupos_pk": $("#grupos_pk").val(),
        "usuarios_pk": $("#usuarios_pk").val(),
        "ic_cliente": $("#ic_cliente").val(),
    };    

    var arrEnviar = carregarController("carga_lead", "salvar", objParametros); 
  
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("carga_lead_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("carga_lead_res_form.php", {token: token});
}
function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}
function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}
$(function () {
    
    $('#fileupload').fileupload({
        
        dataType: 'json',
        done: function (e, data) {
            window.setTimeout('Reset()', 2000);
            if(data.result && data.result.result === "success" && data.result.data && data.result.data.length > 0){
                $("#ds_arquivo").text(data.result.data[0].ds_documento);
                alert("Sucesso ao subir o arquivo");
            } else {
                alert("Falha ao subir o arquivo");
            }
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },            
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width', progress + '%');
        }
    });
});

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("carga_lead", "listarPk", objParametros);
        if (arrCarregar.result == 'success'){
        
            $("#mailing_pk").val(arrCarregar.data[0]['mailing_pk']);
            $("#polos_pk").val(arrCarregar.data[0]['polos_pk']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
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
    
    var arrCarregar = carregarController("mailing", "listarTodos", objParametros); 
   
    carregarComboAjax($("#mailing_pk"), arrCarregar, " ", "pk", "ds_mailing");
        
}
function fcCarregarResponsavel(){
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros);    
    carregarComboAjax($("#usuarios_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}

function fcCarregarPerfil(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);    
    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
        
}



$(document).ready(function()
    {
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();
        
        fcCarregarPolo();
        
        fcCarregarMailing();
        
        fcCarregarPerfil();  
        
        $("#grupos_pk").change(function(){
            fcCarregarResponsavel();
        });

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
