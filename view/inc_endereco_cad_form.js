var tblEndereco;

function fcCarregarGridEndereco(){
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("endereco", "listarPorLead", objParametros);
 
    //Trata a tabela
    tblEndereco = $('#tblEndereco').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "tipo_endereco_pk",visible:false},
           {"targets": -3, "data": "ds_tipo_entrega"},
           {"targets": -4, "data": "ds_bairro"},
           {"targets": -5, "data": "ds_complemento"},
           {"targets": -6, "data": "ds_numero"},
           {"targets": -7, "data": "ds_uf"},
           {"targets": -8, "data": "ds_cidade"},
           {"targets": -9, "data": "ds_endereco"},
           {"targets": -10, "data": "ds_cep"},
           {"targets": -11, "data": "pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblEndereco tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblEndereco.row( $(this).parents('li')).data()){
            data = tblEndereco.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblEndereco.row( $(this).parents('tr')).data()){
            data = tblEndereco.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarEndereco(data);
        
    } );   
    
    $('#tblEndereco tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblEndereco.row( $(this).parents('li') ).data()){
            data = tblEndereco.row( $(this).parents('li') ).data();
        }
        else if(tblEndereco.row( $(this).parents('tr') ).data()){
            data = tblEndereco.row( $(this).parents('tr') ).data();
        }
        
        if(data['pk'] != ""){
            fcExcluirEndereco(data['pk']);
        }
        tblEndereco.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}


function fcEditarEndereco(objRegistro){
    var arrCarregar = permissao("endereco", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    fcLimparFormTelefone();
    $("#janela_endereco").modal();
    $("#lead_endereco_pk").val("");
    $("#acao").val("upd");
    
    //Carrega as informações da linha selecionada.
    $("#lead_endereco_pk").val(objRegistro['pk']);
    $("#tipo_endereco_pk").val(objRegistro['tipo_endereco_pk']);
    $("#ds_cep").val(objRegistro['ds_cep']);
    $("#ds_cidade").val(objRegistro['ds_cidade']); 
    $("#ds_endereco").val(objRegistro['ds_endereco']); 
    $("#ds_numero").val(objRegistro['ds_numero']); 
    $("#ds_complemento").val(objRegistro['ds_complemento']); 
    $("#ds_bairro").val(objRegistro['ds_bairro']); 
    $("#ds_uf").val(objRegistro['ds_uf']); 
    
}

function fcExcluirEndereco(v_pk){
    var arrCarregar = permissao("endereco", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("endereco", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcBotoesGridEndereco(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcEnviarEndereco(){
        if(pk == ""){
            if($("#acao").val() == "ins"){
                fcIncluirEnderecoSemPk();
            }
            else if($("#acao").val() == "upd"){
                fcEditarEnderecoSemPk();
            }
        }
        else{
            fcSalvarEndereco();
        }   
        $("#janela_endereco").modal("hide");
}

function fcRecarregarGridEndereco(){
    tblEndereco.clear().destroy();    
    fcCarregarGridEndereco();
}

function fcSalvarEndereco(){
    
    
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#lead_endereco_pk").val(),
        "leads_pk": pk,
        "ds_cep": $("#ds_cep").val(),
        "ds_endereco": $("#ds_endereco").val(),
        "tipo_endereco_pk": $("#tipo_endereco_pk").val(),
        "ds_bairro": $("#ds_bairro").val(),
        "ds_cidade": $("#ds_cidade").val(),
        "ds_complemento": $("#ds_complemento").val(),
        "ds_numero": $("#ds_numero").val(),
        "ds_uf": $("#ds_uf").val(),
        "polos_pk": $("#polos_pk").val()
    }; 
    var arrEnviar = carregarController("endereco", "salvar", objParametros);
   
    if (arrEnviar.result == 'success'){
        fcRecarregarGridEndereco();
    }    
    else{
        alert(arrEnviar.result);
    }
    
}

function fcIncluirEnderecoSemPk(){      
    tblEndereco.row.add(
        {
            "pk":"",
            "ds_cep":$("#ds_cep").val(),
            "ds_endereco":$("#ds_endereco").val(),
            "ds_cidade":$("#ds_cidade").val(),
            "ds_uf":$("#ds_uf").val(),
            "ds_numero":$("#ds_numero").val(),
            "ds_complemento":$("#ds_complemento").val(),
            "ds_bairro":$("#ds_bairro").val(),
            "tipo_endereco_pk":$("#tipo_endereco_pk").val(),
            "ds_tipo_entrega":$("#tipo_endereco_pk option:selected").text(),
            "t_functions":""
        }
    ).draw();
    
    return false;
}

function fcExcluirEnderecoSemPk(){
   tblEndereco.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcEditarEnderecoSemPk(){
    
    fcIncluirEnderecoSemPk();
    tblEndereco.row(rLinhaSelecionada).remove().draw();
    return false;
}



function fcFormatarDadosEndereco(){
    
    
    try{


        var lead_endereco_pk = "";
        var ds_cep = "";
        var ds_endereco = "";
        var ds_numero = "";
        var ds_complemento = "";
        var ds_bairro = "";
        var ds_cidade = "";
        var ds_uf = "";
        var tipo_endereco_pk = "";


        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "lead_endereco_pk";
        arrKeys[1] = "ds_cep";
        arrKeys[2] = "ds_endereco";
        arrKeys[3] = "ds_numero";
        arrKeys[4] = "ds_complemento";
        arrKeys[5] = "ds_bairro";
        arrKeys[6] = "ds_cidade";
        arrKeys[7] = "ds_uf";
        arrKeys[8] = "tipo_endereco_pk";
        
        var  data = tblEndereco.rows().data();
        
        for(i = 0; i< data.length; i++){

            lead_endereco_pk = data[i]['pk'];
            ds_cep = data[i]['ds_cep'];
            ds_endereco =  data[i]['ds_endereco'];
            ds_numero =  data[i]['ds_numero'];
            ds_complemento =  data[i]['ds_complemento'];
            ds_bairro =  data[i]['ds_bairro'];
            ds_cidade =  data[i]['ds_cidade'];
            ds_uf =  data[i]['ds_uf'];
            tipo_endereco_pk =  data[i]['tipo_endereco_pk'];

            
            
            arrDados[i] = [lead_endereco_pk, ds_cep, ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,tipo_endereco_pk];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}


function fcLimparFormEndereco(){
    $("#acao").val("");
    $("#lead_endereco_pk").val("");
    $("#ds_cep").val("");
    $("#ds_endereco").val("");      
    $("#ds_numero").val("");      
    $("#ds_complemento").val("");      
    $("#ds_bairro").val("");      
    $("#ds_cidade").val("");      
    $("#ds_uf").val("");      
    $("#tipo_endereco_pk").val("");      
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoEndereco(){
    
    //limpa os dados de qualquer registro existe
    fcLimparFormEndereco();
    
    $("#janela_endereco").modal();
    $("#acao").val("ins");
    $("#lead_endereco_pk").val("");
    $("#ds_cep").val("");
    $("#ds_endereco").val("");
    $("#ds_numero").val("");
    $("#ds_complemento").val("");
    $("#ds_bairro").val("");
    $("#ds_cidade").val("");
    $("#ds_uf").val("");
    $("#tipo_endereco_pk").val("");
}

function fcValidarFormEndereco(){
    
    $("#form_lead_endereco").validate({
        rules :{
            tipo_endereco_pk:{
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
            tipo_endereco_pk:{
                required:"Por favor, informe Tipo Endereço"
            },
            ds_cep:{
                required:"Por favor, informe Cep"
            },
            ds_numero:{
                required:"Por favor, informe Número"
            },
            ds_bairro:{
                required:"Por favor, informe Bairro"
            },
            ds_cidade:{
                required:"Por favor, informe Cidade"
            },
            ds_uf:{
                required:"Por favor, informe UF"
            },
            ds_endereco:{
                required:"Por favor, informe Endereco"
            }

        },
        submitHandler: function(form){
            fcEnviarEndereco(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}

function fcCarregarCep(ds_cep){
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#ds_endereco").val("");
        $("#ds_bairro").val("");
        $("#ds_cidade").val("");
        $("#ds_uf").val("");
    }

    //Nova variável "cep" somente com dígitos.
    var cep = ds_cep.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#ds_endereco").val("...");
            $("#ds_bairro").val("...");
            $("#ds_cidade").val("...");
            $("#ds_uf").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#ds_endereco").val(dados.logradouro);
                    $("#ds_bairro").val(dados.bairro);
                    $("#ds_cidade").val(dados.localidade);
                    $("#ds_uf").val(dados.uf);
                } else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulário_cep();

                    sweetMensagem('warning', 'CEP não encontrado');
                }
            });
        } else {
            //cep é inválido.
            limpa_formulário_cep();

            sweetMensagem('warning', 'Formato de CEP inválido');
        }
    }else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
}        
$(document).ready(function(){
    
    fcCarregarGridEndereco();
    
    fcValidarFormEndereco();
    
    
    
    var arrCarregar = permissao("endereco", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
        
    $(document).on('click', '#btn_modal_endereco', fcAbrirFormNovoEndereco);
    $("#ds_cep").keypress(function(){
        mascara(this,cep);
     });
    $("#ds_cep").change(function(){
        fcCarregarCep($("#ds_cep").val());
    });
    
    
});
