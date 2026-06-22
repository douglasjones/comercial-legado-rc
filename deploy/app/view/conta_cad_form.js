$(document).ready(function(){


        var arrCarregar = permissao("conta", "ins");        
        
        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        
        
        
        
        
        //mascaras
        fcMascaraFormConta();
        
        $("#ds_cep").change(function(){
            fcCarregarCep();
        });
                
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);

function fcMascaraFormConta(){
    $("#ds_cpf_cnpj").keypress(function(){
        chama_mascara(this);
    });    
    
    $("#ds_tel").keypress(function(){
     mascara(this, mascaraTelefone);
   });

   $("#ds_cel").keypress(function(){
     mascara(this, mascaraTelefone);
   });
   
   $("#ds_cep").keypress(function(){
      mascara(this,cep);
   });
   
   $('#dt_cancelamento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
   $('#dt_ativacao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
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
            ds_tipo_pessoa:{
                required:true
            },
            ds_conta:{
                required:true
            },
            ds_razao_social:{
                required:true
            },
            ds_cpf_cnpj:{
                required:true
            },
            ds_tel:{
                required:true
            },
            ds_email:{
                required:true
            },
            ds_cel:{
                required:true
            },
            ds_cep:{
                required:true
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
            } 
        },
        messages:{
            ds_tipo_pessoa:{
                required:"Por favor, informe o Tipo Pessoa"    
            },
            ds_conta:{
                required:"Por favor, informe o Bome da Conta"                
            },
            ds_razao_social:{
                required:"Por favor, informe a Razão Social / Nome"
            },
            ds_cpf_cnpj:{
                required:"Por favor, informe o CPF/CNPJ"
            },
            ds_tel:{
                required:"Por favor, informe o Telefone ",
                minlength:"Por favor, informe um Telefone valido"
            },            
            ds_email:{
                required:"Por favor, informe um E-mail ",
                email:"Por favor, informe um Email valido"
            },
            ds_cel:{               
                minlength:"Por favor, informe um Celular valido"
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
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_tipo_pessoa = $("#ds_tipo_pessoa").val();
    var v_ds_conta = $("#ds_conta").val();
    var v_ds_razao_social = $("#ds_razao_social").val();
    var v_ds_cpf_cnpj = $("#ds_cpf_cnpj").val();
    var v_ds_cnae = $("#ds_cnae").val();
    var v_ds_rg = $("#ds_rg").val();
    var v_ds_tel = $("#ds_tel").val();
    var v_ds_email = $("#ds_email").val();
    var v_ds_cel = $("#ds_cel").val();
    var v_ds_cep = $("#ds_cep").val();
    var v_ds_endereco = $("#ds_endereco").val();
    var v_ds_numero = $("#ds_numero").val();
    var v_ds_complemento = $("#ds_complemento").val();
    var v_ds_bairro = $("#ds_bairro").val();
    var v_ds_cidade = $("#ds_cidade").val();
    var v_ds_uf = $("#ds_uf").val();
    var v_dt_ativacao = $("#dt_ativacao").val();
    var v_dt_cancelamento = $("#dt_cancelamento").val();
    var v_ic_status = $("#ic_status").val();    
    

    var objParametros = {
        "pk": pk,
        "ds_tipo_pessoa": (v_ds_tipo_pessoa),
        "ds_conta": (v_ds_conta),
        "ds_razao_social": (v_ds_razao_social),
        "ds_cpf_cnpj": (v_ds_cpf_cnpj),
        "ds_cnae": (v_ds_cnae),
        "ds_rg": (v_ds_rg),
        "ds_tel": (v_ds_tel),
        "ds_email": (v_ds_email),
        "ds_cel": (v_ds_cel),
        "ds_cep": (v_ds_cep),
        "ds_endereco": (v_ds_endereco),
        "ds_numero": (v_ds_numero),
        "ds_complemento": (v_ds_complemento),
        "ds_bairro": (v_ds_bairro),
        "ds_cidade": (v_ds_cidade),
        "ds_uf": (v_ds_uf),
        "dt_ativacao": (v_dt_ativacao),
        "dt_cancelamento": (v_dt_cancelamento),
        "ic_status": (v_ic_status)        
    };    

    var arrEnviar = carregarController("conta", "salvar", objParametros);
 
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("conta_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("conta_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("conta", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_tipo_pessoa").val(arrCarregar.data[0]['ds_tipo_pessoa']);
            $("#ds_conta").val(arrCarregar.data[0]['ds_conta']);
            $("#ds_razao_social").val(arrCarregar.data[0]['ds_razao_social']);
            $("#ds_cpf_cnpj").val(arrCarregar.data[0]['ds_cpf_cnpj']);
            $("#ds_cnae").val(arrCarregar.data[0]['ds_cnae']);
            $("#ds_rg").val(arrCarregar.data[0]['ds_rg']);
            $("#ds_ddd").val(arrCarregar.data[0]['ds_ddd']);
            $("#ds_tel").val(arrCarregar.data[0]['ds_tel']);
            $("#ds_ddd_cel").val(arrCarregar.data[0]['ds_ddd_cel']);
            $("#ds_email").val(arrCarregar.data[0]['ds_email']);
            $("#ds_cel").val(arrCarregar.data[0]['ds_cel']);
            $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
            $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
            $("#segmentos_pk").val(arrCarregar.data[0]['segmentos_pk']);
            $("#dt_ativacao").val(arrCarregar.data[0]['dt_ativacao']);
            $("#dt_cancelamento").val(arrCarregar.data[0]['dt_cancelamento']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}


