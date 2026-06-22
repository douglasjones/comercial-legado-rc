function fcValidarForm(){

    $("#form").validate({
        rules :{
		ds_modulo:{
required:true,
minlength:3
},
ds_dominio:{
required:true,
minlength:3
}

        },
        messages:{
		ds_modulo:{
required:"Por favor, informe o Módulo do grupo",
minlength:"O nome deve ter pelo menos 3 caracteres"
},
ds_dominio:{
required:"Por favor, informe o Domínio do grupo",
minlength:"O nome deve ter pelo menos 3 caracteres"
}

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_modulo = $("#ds_modulo").val();
    var v_ds_dominio = $("#ds_dominio").val();
    var v_polos_pk = $("#polos_pk").val();


    var url = '../controller/modulo.controller.php?job=salvar&token='+token+'&pk=' + pk + '&ds_modulo=' + (v_ds_modulo)
+ '&ds_dominio=' + (v_ds_dominio)+'&polos_pk='+v_polos_pk;
    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            // Reload datable
            alert(output.message);
            sendPost("modulo_res_form.php", {token: token});
        }
        else{
            alert('Falhou a requisição para salvar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falhou a requisição para salvar o registro: ' + textStatus);
    });

}

function fcCancelar(){
    sendPost("modulo_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){
        var url = '../controller/modulo.controller.php?job=listarPk&token='+token+'&pk=' + pk;
        var request = $.ajax({
            url:          url,
            cache:        false,
            dataType:     'json',
            contentType:  'application/json; charset=utf-8',
            type:         'post'
        });
        request.done(function(output){
            if (output.result == 'success'){
                $("#ds_modulo").val(output.data[0]['ds_modulo']);
                $("#ds_dominio").val(output.data[0]['ds_dominio']);
                $("#polos_pk").val(output.data[0]['polos_pk']);

            }
            else{
                alert('Falhar ao carregar o registro');
            }
        });
        request.fail(function(jqXHR, textStatus){
            alert('Falha ao carregar o registro: ' + textStatus);
        });
    }
}

function fcCarregarPolo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPk", objParametros); 
   
    carregarComboAjax($("#polos_pk"), arrCarregar, " ", "pk", "ds_polo");
        
}

$(document).ready(function()
    {
        var arrCarregar = permissao("modulo", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcCarregarPolo();
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
