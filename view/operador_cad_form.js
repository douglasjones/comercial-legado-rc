function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_operador:{
                required:true
            },
            segmentos_pk:{
                required:true
            },
            ic_status:{
                required:true
            }

        },
        messages:{
            ds_operador:{
                required:"Por favor, informe Operador"
            },
            segmentos_pk:{
                required:"Por favor, selecione Segmento"
            },
            ic_status:{
                required:"Por favor, selecione Status "
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_operador = $("#ds_operador").val();
    var v_segmentos_pk = $("#segmentos_pk").val();
    var v_ic_status = $("#ic_status").val();


    var objParametros = {
        "pk": pk,
        "ds_operador": (v_ds_operador),
        "segmentos_pk": (v_segmentos_pk),
        "ic_status": (v_ic_status)        
    };    

    var arrEnviar = carregarController("operador", "salvar", objParametros);
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("operador_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("operador_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("operador", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_operador").val(arrCarregar.data[0]['ds_operador']);
            $("#segmentos_pk").val(arrCarregar.data[0]['segmentos_pk']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}
function fcCarregarSegmento(){
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("segmento", "listarTodos", objParametros);    
  
    carregarComboAjax($("#segmentos_pk"), arrCarregar, " ", "pk", "ds_segmento");
        
}
$(document).ready(function()
    {
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();
        
        fcCarregarSegmento();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
