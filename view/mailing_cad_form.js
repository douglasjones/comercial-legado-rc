function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_mailing:{
                required:true,
                minlength:3
            },
            ic_status:{
                required:true
            },
            polos_pk:{
                required:true
            }

        },
        messages:{
            ds_mailing:{
                required:"Por favor, informe Mailing",
                minlength:"Mailing deve ter pelo menos 3 caracteres"
            },
            ic_status:{
                required:"Por favor, informe Status"
            },
            polos_pk:{
                required:"Por favor, informe Polo"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_mailing = $("#ds_mailing").val();
    var v_ic_status = $("#ic_status").val();
    var v_polos_pk = $("#polos_pk").val();


    var objParametros = {
        "pk": pk,
        "ds_mailing": (v_ds_mailing),
        "ic_status": (v_ic_status),
        "polos_pk": (v_polos_pk)        
    };    

    var arrEnviar = carregarController("mailing", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("mailing_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("mailing_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("mailing", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_mailing").val(arrCarregar.data[0]['ds_mailing']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
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

$(document).ready(function()
    {
        
        var arrCarregar = permissao("mailing", "cons");        

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
