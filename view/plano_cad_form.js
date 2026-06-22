function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_plano:{
                required:true,
                minlength:3
            },
            vl_plano:{
                required:true,
                minlength:3
            },
            segmentos_pk:{
                required:true,
                minlength:3
            },
            ic_status:{
                required:true,
                minlength:3
            }

        },
        messages:{
            ds_plano:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            vl_plano:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            segmentos_pk:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ic_status:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_plano = $("#ds_plano").val();
    var v_vl_plano = $("#vl_plano").val();
    var v_segmentos_pk = $("#segmentos_pk").val();
    var v_ic_status = $("#ic_status").val();


    var objParametros = {
        "pk": pk,
        "ds_plano": encodeURIComponent(v_ds_plano),
        "vl_plano": encodeURIComponent(v_vl_plano),
        "segmentos_pk": encodeURIComponent(v_segmentos_pk),
        "ic_status": encodeURIComponent(v_ic_status)        
    };    

    var arrEnviar = carregarController("plano", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("plano_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("plano_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("plano", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_plano").val(arrCarregar.data[0]['ds_plano']);
            $("#vl_plano").val(arrCarregar.data[0]['vl_plano']);
            $("#segmentos_pk").val(arrCarregar.data[0]['segmentos_pk']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

$(document).ready(function()
    {
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
