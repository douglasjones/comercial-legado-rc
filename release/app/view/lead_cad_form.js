

var clickTel = 1;
var clickEndereco = 1;
var clickContato = 1;
var clickOperadoras = 1;
function fcExibirTefelefone(){
    
    $("#exibir_telefone").show();
    if(clickTel==1){
        tblTelefone.clear().destroy(); 
        window.setTimeout(function() {
            fcCarregarGridTelefone();
        }, 1000);
        clickTel++;
    }
   
    
}
function fcExibirEndereco(){
    $("#exibir_endereco").show();
    if(clickEndereco==1){
        tblEndereco.clear().destroy();
        window.setTimeout(function() {
            fcCarregarGridEndereco();
        }, 1000);
        clickEndereco++;
    }
    
    

}
function fcExibirContato(){
    $("#exibir_contato").show();
    if(clickContato==1){
        tblLeadContatos.clear().destroy();
        window.setTimeout(function() {
            fcCarregarGridContato();
        }, 1000);
        clickContato++
    }
    
    
}
function fcExibirOperadoras(){
    $("#exibir_operadoras").show();
    if(clickOperadoras==1){
        tblLeadOperador.clear().destroy();
        window.setTimeout(function() {
            fcCarregarGridLeadOperador();
        }, 1000);
        clickOperadoras++;
    }
    
    
}


function fcValidarForm(){

    $("#form").validate({
        rules :{
            tipo_pessoa_pk:{
                required:true
            },
            ds_lead:{
                required:true,
                minlength:3
            },
            ds_cpf_cnpj:{
                required:true
            },

            ic_cliente:{
                required:true
            },
            polos_pk:{
                required:true
            }

        },
        messages:{
            tipo_pessoa_pk:{
                required:"Por favor, informe Tipo pessoa"
            },
            ds_lead:{
                required:"Por favor, informe Lead",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ds_cpf_cnpj:{
                required:"Por favor, informe CPF/CNPJ"
            },
            ic_cliente:{
                required:"Por favor, informe Cliente ",

            },
            polos_pk:{
                required:"Por favor, informe Polo ",

            }


        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var strJSONDadosTabelaContato = fcFormatarDadosContato();
    var strJSONDadosTabelaResponsavel = fcFormatarDadosResponsavel();
    var strJSONDadosTabelaEndereco = fcFormatarDadosEndereco();
    var strJSONDadosTabelaTelefone = fcFormatarDadosTelefone();
    var strJSONDadosTabelaOperador = fcFormatarDadosLeadOperador();


    var v_tipo_pessoa_pk = $("#tipo_pessoa_pk").val();
    var v_ds_lead = $("#ds_lead").val();
    var v_ds_razao_social = $("#ds_razao_social").val();
    var v_ds_cpf_cnpj = $("#ds_cpf_cnpj").val();
    var v_ds_ie = $("#ds_ie").val();
    var v_ds_rg = $("#ds_rg").val();
    var v_ds_cnae = $("#ds_cnae").val();
    var v_ic_cliente = $("#ic_cliente").val();
    var v_ds_obs = $("#ds_obs").val();
    var v_ds_site = $("#ds_site").val();
    var v_mailing_pk = $("#mailing_pk").val();
    var v_polos_pk = $("#polos_pk").val();
    var v_ds_log = $("#ds_log").val();
    var v_ciclo_uso = $("#ciclo_uso").val();

    var objParametros = {
        "pk": pk,
        "tipo_pessoa_pk": (v_tipo_pessoa_pk),
        "ds_lead": (v_ds_lead),
        "ds_razao_social": (v_ds_razao_social),
        "ds_cpf_cnpj": (v_ds_cpf_cnpj),
        "ds_ie": (v_ds_ie),
        "ds_rg": (v_ds_rg),
        "ds_cnae": (v_ds_cnae),
        "ic_cliente": (v_ic_cliente),
        "ds_obs": (v_ds_obs),
        "ds_site": (v_ds_site),
        "mailing_pk": (v_mailing_pk),
        "polos_pk": (v_polos_pk),
        "ciclo_uso": (v_ciclo_uso),
        "ds_log": (v_ds_log),
        "contatos_pk": (strJSONDadosTabelaContato),
        "responsavel_pk": (strJSONDadosTabelaResponsavel),
        "endereco_pk": (strJSONDadosTabelaEndereco),
        "telefone_pk": (strJSONDadosTabelaTelefone) ,
        "lead_operador": (strJSONDadosTabelaOperador)
    };

    var arrEnviar = carregarController("lead", "salvar", objParametros);
   
    

    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);

        sendPost('lead_main_form.php', {token: token, pk: arrEnviar.data[0]['pk'],agenda:""});

    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("lead_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };

        var arrCarregar = carregarController("lead", "listarPk", objParametros);

        if (arrCarregar.result == 'success'){

            $("#tipo_pessoa_pk").val(arrCarregar.data[0]['tipo_pessoa_pk']);
            $("#ds_lead").val(arrCarregar.data[0]['ds_lead']);
            $("#ds_razao_social").val(arrCarregar.data[0]['ds_razao_social']);
            $("#ds_cpf_cnpj").val(arrCarregar.data[0]['ds_cpf_cnpj']);
            $("#ds_ie").val(arrCarregar.data[0]['ds_ie']);
            $("#ds_rg").val(arrCarregar.data[0]['ds_rg']);
            $("#ds_cnae").val(arrCarregar.data[0]['ds_cnae']);
            $("#ic_cliente").val(arrCarregar.data[0]['ic_cliente']);
            $("#ds_obs").val(arrCarregar.data[0]['ds_obs']);
            $("#ds_site").val(arrCarregar.data[0]['ds_site']);
            $("#mailing_pk").val(arrCarregar.data[0]['mailing_pk']);
            $("#polos_pk").val(arrCarregar.data[0]['polos_pk']);
            $("#ciclo_uso").val(arrCarregar.data[0]['ciclo_uso']);
            $("#ds_log").val(arrCarregar.data[0]['ds_log']);

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
function fcCarregarCpfCnpj(){

    var objParametros = {
        "ds_cpf_cnpj": $("#ds_cpf_cnpj").val()
    };

    var arrCarregar = carregarController("lead", "listarCPF", objParametros);

    if(arrCarregar.data.length > 0){
        alert("Já existe um Lead com esse CPF/CNPJ");
        $("#ds_cpf_cnpj").val("");
    }


}

function fcCarregarSubMenu(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };

        var arrCarregar = carregarController("lead", "listarPkSubMenu", objParametros);
        if (arrCarregar.result == 'success'){

            $(".leads_pk_cad").text(arrCarregar.data[0]['pk']);
            $(".ds_lead_cad").text(arrCarregar.data[0]['ds_lead']);
            $(".ds_tipo_pessoa_cad").text(arrCarregar.data[0]['tipo_pessoa_pk']);
            $(".ds_polo_cad").text(arrCarregar.data[0]['ds_polo']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcCarregarMailing(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("mailing", "listarPorContasPk", objParametros);

    carregarComboAjax($("#mailing_pk"), arrCarregar, " ", "pk", "ds_mailing");

}

$(document).ready(function()
    {
        var arrCarregar = permissao("lead", "ins");

        if (arrCarregar.result != 'success'){
            alert('Falhar ao carregar o registro');
            return false;
        }
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();
        fcCarregarPolo();
        fcCarregarMailing();
        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();

        fcCarregarSubMenu();
        if(pk!=""){
            $(".exibir").show();
        }
        else{
            $(".exibir").hide();
        }

        $("#ds_cpf_cnpj").keypress(function(){
           chama_mascara(this);
        });

        $("#ds_cpf_cnpj").change(function(){
            fcCarregarCpfCnpj();
        });
        
        
        if(pk==""){
            if($('#ds_lead').val()==""){
                $("#ds_lead").focus();
            }
        }
         
    }
);
