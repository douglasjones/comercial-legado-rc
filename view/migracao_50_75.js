function fcValidarForm(){

    $("#form").validate({
        rules :{
            pk_old:{
                required:true
            },
            porcentagem_pk:{
                required:true
            }

        },
        messages:{
            pk_old:{
                required:"Por favor, informe PK OLD"
            },
            porcentagem_pk:{
                required:"Por favor, selecione Porcentagem"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}


function fcEnviar(){
    if($("#pk_old").val()==""){
        alert("Por favor, informe PK OLD ");
        return false;
    }
    var objParametros = {
        "pk_old": $("#pk_old").val(),
        "porcentagem_pk":$("#porcentagem_pk").val()
    };    

    var arrEnviar = carregarController("migrar_50_75", "salvar_migracao_50_75", objParametros);
    
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("menu_cpainel.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("menu_administracao.php", {token: token});
}


$(document).ready(function()
    {
        
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        
        fcValidarForm();

    }
);
