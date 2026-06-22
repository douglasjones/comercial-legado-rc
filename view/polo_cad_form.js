$(document).ready(function()
    {
        var arrCarregar = permissao("polo", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        
        fcMascaraFormConta();
        
        fcCarregarContas();
    
        formataDatasForm();
        
        $("#ds_cep").change(function(){
            fcCarregarCep();
        });
        //carregar Planos    
        fcCarregarPlanos();      
        
                //esconde cartão
        $("#pg_cartao").hide();        
          
        $("#tipo_pagamentos_pk").change(function(){
            if($("#tipo_pagamentos_pk").val()==1){
                $("#pg_cartao").hide();
            }else{
                $("#pg_cartao").show();
            }
        });  
                
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
        
        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar(); 
        
        //carregar Planos    
        fcCarregarPlanos();  
    }
);
function fcCarregarContas(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("conta", "listarContasUsuarios", objParametros); 

    carregarComboAjax($("#contas_pk"), arrCarregar, "", "pk", "ds_conta");        
}




function fcCarregarPlanos(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("plano", "listarTodos", objParametros); 
  
    carregarComboAjax($("#planos_pk"), arrCarregar, " ", "pk", "ds_plano");        
}
function fcMascaraFormConta(){
    $("#ds_tel").keypress(function(){
     mascara(this, mascaraTelefone);
   });

   $("#ds_cel").keypress(function(){
     mascara(this, mascaraTelefone);
   });
   
   $("#ds_cep").keypress(function(){
      mascara(this,cep);
   });
}



function formataDatasForm(){
    $('#dt_cancelamento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_cancelamento").keypress(function(){
       mascara(this,mdata);
    });  
      
}

function fcCarregarCep(){  
    var cpf = $("#ds_cep").val();

    if(cpf.length == 9){
        
        var objParametros = {
            "ds_cep": $("#ds_cep").val()
        };        
        
        var arrCarregar = carregarController("cep", "buscarCep", objParametros);
  
        if (arrCarregar.result == 'success'){

            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }       
    }
}    
function fcValidarForm(){
    $("#form").validate({
        rules :{
            ds_polo:{
                required:true                
            }, 
            ic_status:{
                required:true               
            },
            segmentos_pk:{
                required:true               
            },
            ds_cep:{
                required:true,
                minlength:8
            },
            ds_endereco:{
                required:true                
            },
            ds_numero:{
                required:true
            },
            ds_bairro:{
                required:true
            },
            ds_cidade:{
                required:true
            },
            ds_uf:{
                required:true
            },
            ds_tel:{
                minlength:13
            },
            planos_pk:{
                required:true
            },
            dia_vencimento:{
                required:true
            },
            tipo_pagamentos_pk:{
                required:true
            },
            ds_email_financeiro:{
                required:true
            }
        },
        messages:{
            ds_polo:{
                required:"Por favor, informe o Polo "
            },
            ic_status:{
                required:"Por favor, informe o Status "
                
            },
            segmentos_pk:{
                required:"Por favor, informe o Segmento "
            },       
            ds_cep:{
                required:"Por favor, informe o Cep ",
                minlength:"Por favor, informe um Cep valido"
            },
            ds_endereco:{
                required:"Por favor, informe o Endereço "
            },
            ds_numero:{
                required:"Por favor, informe o Número"
            },
            ds_bairro:{
                required:"Por favor, informe o Bairro "
            },
            ds_cidade:{
                required:"Por favor, informe a Cidade "
            },
            ds_uf:{
                required:"Por favor, informe o UF "
            },
            ds_tel:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ds_cel:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ds_site:{
                required:"Por favor, informe ",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ds_tel:{
                required:"Por favor, informe o Telefone ",
                minlength:"Por favor, informe um Telefone valido"
            },
            planos_pk:{
                required:"Por favor, informe o Plano "
            },
            dia_vencimento:{
                required:"Por favor, informe o Dia de vencimento "
            },
            tipo_pagamentos_pk:{
                required:"Por favor, informe o Tipo de pagamento "
            },
            ds_email_financeiro:{
                required:"Por favor, informe o E-mail financeiro "
            }     

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var strJSONDadosTabelaOperador = fcFormatarDadosOperador();
    var strJSONDadosTabelaEtapa = fcFormatarDadosEsteira();
    
    var strJSONDadosTabelaModeloProposta = fcFormatarDadosModeloProposta();
    

    var v_ds_polo = $("#ds_polo").val();
    var v_dt_cancelamento = $("#dt_cancelamento").val();
    var v_ic_status = $("#ic_status").val();
    var v_segmentos_pk = $("#segmentos_pk").val();
    var v_contas_pk = $("#contas_pk").val();
    var v_ds_cep = $("#ds_cep").val();
    var v_ds_endereco = $("#ds_endereco").val();
    var v_ds_numero = $("#ds_numero").val();
    var v_ds_complemento = $("#ds_complemento").val();
    var v_ds_bairro = $("#ds_bairro").val();
    var v_ds_cidade = $("#ds_cidade").val();
    var v_ds_uf = $("#ds_uf").val();
    var v_responsavel_pk = $("#responsavel_pk").val();
    var v_ds_tel = $("#ds_tel").val();
    var v_ds_cel = $("#ds_cel").val();
    var v_ds_site = $("#ds_site").val();
    var v_ds_email = $("#ds_email").val();
    var v_planos_pk = $("#planos_pk").val();    
    var v_dia_vencimento = $("#dia_vencimento").val();
    var v_tipo_pagamentos_pk = $("#tipo_pagamentos_pk").val();    
    var v_n_cartao = $("#n_cartao").val();
    var v_ds_vencimento_cartao = $("#ds_vencimento_cartao").val();
    var v_ds_nome_cartao = $("#ds_nome_cartao").val();
    var v_bandeira_cartao_pk = $("#bandeira_cartao_pk").val();
    var v_ds_email_financeiro = $("#ds_email_financeiro").val();
    
    var objParametros = {
        "pk": pk,
        "ds_polo": (v_ds_polo),
        "dt_cancelamento": (v_dt_cancelamento),
        "ic_status": (v_ic_status),
        "segmentos_pk": (v_segmentos_pk),
        "contas_pk": (v_contas_pk),
        "ds_cep": (v_ds_cep),
        "ds_endereco": (v_ds_endereco),
        "ds_numero": (v_ds_numero),
        "ds_complemento": (v_ds_complemento),
        "ds_bairro": (v_ds_bairro),
        "ds_cidade": (v_ds_cidade),
        "ds_uf": (v_ds_uf),
        "responsavel_pk": (v_responsavel_pk),
        "ds_tel": (v_ds_tel),
        "ds_cel": (v_ds_cel),
        "ds_site": (v_ds_site),
        "ds_email": (v_ds_email),
        "planos_pk": (v_planos_pk),
        "dia_vencimento": (v_dia_vencimento),
        "tipo_pagamentos_pk": (v_tipo_pagamentos_pk),
        "n_cartao": (v_n_cartao),
        "ds_vencimento_cartaoo": (v_ds_vencimento_cartao),
        "ds_nome_cartao": (v_ds_nome_cartao),
        "bandeira_cartao_pk": (v_bandeira_cartao_pk),
        "ds_email_financeiro": (v_ds_email_financeiro),
        "polos_operadores_pk": (strJSONDadosTabelaOperador),
        "etapas_contratos_pk": (strJSONDadosTabelaEtapa),
        "modelo_proposta_pk": (strJSONDadosTabelaModeloProposta)
    };    

    var arrEnviar = carregarController("polo", "salvar", objParametros);           

    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("polo_res_form.php", {token: token});
    }
    else{
        //alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("polo_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("polo", "listarPk", objParametros);

        if (arrCarregar.result == 'success'){
          
            $("#ds_polo").val(arrCarregar.data[0]['ds_polo']);
            $("#dt_cancelamento").val(arrCarregar.data[0]['dt_cancelamento']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#segmentos_pk").val(arrCarregar.data[0]['segmentos_pk']);
            $("#contas_pk").val(arrCarregar.data[0]['contas_pk']);
            $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
            $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
            $("#responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
            $("#ds_tel").val(arrCarregar.data[0]['ds_tel']);
            $("#ds_cel").val(arrCarregar.data[0]['ds_cel']);
            $("#ds_site").val(arrCarregar.data[0]['ds_site']);
            $("#ds_email").val(arrCarregar.data[0]['ds_email']);
   
            $("#planos_pk").val(arrCarregar.data[0]['planos_pk']);
            $("#dia_vencimento").val(arrCarregar.data[0]['dia_vencimento']);            
            $("#tipo_pagamentos_pk").val(arrCarregar.data[0]['tipo_pagamentos_pk']);
            $("#bandeira_cartao_pk").val(arrCarregar.data[0]['bandeira_cartao_pk']);
            $("#n_cartao").val(arrCarregar.data[0]['n_cartao']);
            $("#ds_vencimento_cartao").val(arrCarregar.data[0]['ds_vencimento_cartao']);
            $("#ds_nome_cartao").val(arrCarregar.data[0]['ds_nome_cartao']);
            $("#ds_email_financeiro").val(arrCarregar.data[0]['ds_email_financeiro']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}


