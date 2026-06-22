function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_produto_servico:{
                required:true,
                minlength:3
            },
            vl_produto_servico:{
                required:true
            },
            tipo_produto_pk:{
                required:true
            },
            ic_status:{
                required:true
            }

        },
        messages:{
            ds_produto_servico:{
                required:"Por favor, informe Produto/Serviço",
                minlength:"Produto/Serviço deve ter pelo menos 3 caracteres"
            },
            vl_produto_servico:{
                required:"Por favor, informe Valor Produto/Serviço"
            },
            tipo_produto_pk:{
                required:"Por favor, selecione Tipo produto"
            },
            ic_status:{
                required:"Por favor, selecione Status"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){
    var v_ic_valor_aberto = 2;
    var v_vl_produto_servico = " ";
    if($('#ic_valor_aberto').is(":checked")){
        v_ic_valor_aberto = 1;
    }
    else{
        v_ic_valor_aberto = 2;
    }

    var v_ds_produto_servico = $("#ds_produto_servico").val();
    var v_polos_pk = $("#polos_pk").val();
    var v_tipo_produto_pk = $("#tipo_produto_pk").val();
    var v_book_pk = $("#book_pk").val();
    var v_operador_pk = $("#operador_pk").val();
    var v_ic_status = $("#ic_status").val();
    if($("#vl_produto_servico").val()!=""){
         var v_vl_produto_servico = moeda2float($("#vl_produto_servico").val());
    }
   


    var objParametros = {
        "pk": pk,
        "ds_produto_servico": (v_ds_produto_servico),       
        "tipo_produto_pk": (v_tipo_produto_pk),       
        "book_pk": (v_book_pk),       
        "vl_produto_servico": (v_vl_produto_servico),       
        "operador_pk": (v_operador_pk),       
        "ic_valor_aberto": (v_ic_valor_aberto),       
        "ic_status": (v_ic_status),       
        "polos_pk": (v_polos_pk)        
    };    

    var arrEnviar = carregarController("produto_servico", "salvar", objParametros); 
   
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("produto_servico_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("produto_servico_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("produto_servico", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_produto_servico").val(arrCarregar.data[0]['ds_produto_servico']);
            $("#polos_pk").val(arrCarregar.data[0]['polos_pk']);
            $("#operador_pk").val(arrCarregar.data[0]['operador_pk']);
            
            $("#tipo_produto_pk").val(arrCarregar.data[0]['tipo_produto_pk']);
            $("#book_pk").val(arrCarregar.data[0]['book_pk']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            
            if(arrCarregar.data[0]['ic_valor_aberto']==1){
                $("#vl_produto_servico").val((arrCarregar.data[0]['vl_produto_servico']));
                $("input[id=vl_produto_servico]").prop("disabled", "true");
                $('#ic_valor_aberto').prop('checked', true);
            }
            else{
                $("#vl_produto_servico").val(float2moeda(arrCarregar.data[0]['vl_produto_servico']));
                $("input[id=vl_produto_servico]").prop("disabled", false);
                $('#ic_valor_aberto').prop('checked', false);
            }

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
function fcCarregarOperador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("operador", "listarTodosPorPolo", objParametros); 
   
    carregarComboAjax($("#operador_pk"), arrCarregar, " ", "pk", "ds_operador");
        
}

function fcDesabilitarCampo(){
    if($('#ic_valor_aberto').is(":checked")){
        $("input[id=vl_produto_servico]").prop("disabled", "true");
    }
    else{
        $("input[id=vl_produto_servico]").prop("disabled", false);
    }
}

$(document).ready(function()
    {
        var arrCarregar = permissao("produto_servico", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
        $(document).on('click', '#ic_valor_aberto', fcDesabilitarCampo);
        

        $("#vl_produto_servico").keypress(function(){
            mascara(this,moeda);
         });

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregarPolo();
        fcCarregarOperador();
        fcCarregar();
        
        
        
        
        
        
    }
);
