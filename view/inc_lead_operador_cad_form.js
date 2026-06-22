var tblLeadOperador;

function fcCarregarGridLeadOperador(){
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("lead_operador", "listarPorLead", objParametros);
    
    //Trata a tabela
    tblLeadOperador = $('#tblLeadOperador').DataTable({
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
           {"targets": -2, "data": "t_tempo_contrato_pk"},
           {"targets": -3, "data": "t_ic_status",visible:false},
           {"targets": -4, "data": "t_ds_status"},
           {"targets": -5, "data": "t_ds_qtde_dados"},
           {"targets": -6, "data": "t_ds_qtde_voz"},
           {"targets": -7, "data": "t_ds_custo_atual"},
           {"targets": -8, "data": "t_dt_vencimento"},
           {"targets": -9, "data": "t_dt_ativacao"},
           {"targets": -10, "data": "t_ic_base",visible:false},
           {"targets": -11, "data": "t_ds_base"},
           {"targets": -12, "data": "t_ic_cliente",visible:false},
           {"targets": -13, "data": "t_ds_cliente"},
           {"targets": -14, "data": "t_ds_classificacao"},
           {"targets": -15, "data": "t_classificacao_pk",visible:false},
           {"targets": -16, "data": "t_operador_pk",visible:false},
           {"targets": -17, "data": "t_ds_operador"},
           {"targets": -18, "data": "t_pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblLeadOperador tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblLeadOperador.row( $(this).parents('li')).data()){
            data = tblLeadOperador.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblLeadOperador.row( $(this).parents('tr')).data()){
            data = tblLeadOperador.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarLeadOperador(data);
        
    } );   
    
    $('#tblLeadOperador tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblLeadOperador.row( $(this).parents('li') ).data()){
            data = tblLeadOperador.row( $(this).parents('li') ).data();
        }
        else if(tblLeadOperador.row( $(this).parents('tr') ).data()){
            data = tblLeadOperador.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirLeadOperador(data['t_pk']);
        }
        tblLeadOperador.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}


function fcEditarLeadOperador(objRegistro){
   /* var arrCarregar = permissao("lead_operador", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
    fcLimparFormLeadOperador();
    
    
    
    $("#janela_lead_operador").modal();
    $("#lead_operador_pk").val("");
    $("#acao").val("upd");
    //Carrega as informações da linha selecionada.
    $("#lead_operador_pk").val(objRegistro['t_pk']);
    $("#operador_pk").val(objRegistro['t_operador_pk']);
    
    fcPegarNomeOperador($("#operador_pk").val());
  
    $("#classificacao_pk").val(objRegistro['t_classificacao_pk']);
    
    $("#ic_cliente_operador").val(objRegistro['t_ic_cliente']);
    $("#ic_base").val(objRegistro['t_ic_base']);
    $("#dt_ativacao").val(objRegistro['t_dt_ativacao']);
    $("#dt_vencimento").val(objRegistro['t_dt_vencimento']);
    $("#ds_custo_atual").val(objRegistro['t_ds_custo_atual']);
    $("#ds_qtde_voz").val(objRegistro['t_ds_qtde_voz']);
    $("#ds_qtde_dados").val(objRegistro['t_ds_qtde_dados']);
    $("#ic_status_operador").val(objRegistro['t_ic_status']);
    $("#tempo_contrato_pk").val(objRegistro['t_tempo_contrato_pk']);
    
    
}

function fcExcluirLeadOperador(v_pk){
    /*var arrCarregar = permissao("lead_operador", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("lead_operador", "excluir", objParametros); 

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


function fcEnviarLeadOperador(){

        if(pk == ""){
            
            if($("#acao").val() == "ins"){
                fcIncluirLeadOperadorSemPk();
                
            }
            else if($("#acao").val() == "upd"){
                fcEditarLeadOperadorSemPk();
            }
        }
        else{
           
            fcSalvarLeadOperador();
        }   
        $("#janela_lead_operador").modal("hide");
}

function fcRecarregarGridLeadOperador(){
    tblLeadOperador.clear().destroy();
    fcCarregarGridLeadOperador();
}

function fcSalvarLeadOperador(){
    
    
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#lead_operador_pk").val(),
        "leads_pk": pk,
        "operador_pk": $("#operador_pk").val(),
        "classificacao_pk": $("#classificacao_pk").val(),
        "ic_cliente": $("#ic_cliente_operador").val(),
        "ic_base": $("#ic_base").val(),
        "dt_ativacao": $("#dt_ativacao").val(),
        "dt_vencimento": $("#dt_vencimento").val(),
        "ds_custo_atual": moeda2float($("#ds_custo_atual").val()),
        "ds_qtde_voz": $("#ds_qtde_voz").val(),
        "ds_qtde_dados": $("#ds_qtde_dados").val(),
        "tempo_contrato_pk": $("#tempo_contrato_pk").val(),
        "ic_status": $("#ic_status_operador").val()
    }; 
    var arrEnviar = carregarController("lead_operador", "salvar", objParametros);
   
    if (arrEnviar.result == 'success'){
        fcRecarregarGridLeadOperador();
    }    
    else{
        alert(arrEnviar.result);
    }
    
}

function fcIncluirLeadOperadorSemPk(){ 
    
    tblLeadOperador.row.add(
        {
            "t_pk":"",
            "t_ds_operador":$("#operador_pk option:selected").text(),
            "t_operador_pk":$("#operador_pk").val(),
            "t_classificacao_pk":$("#classificacao_pk").val(),
            "t_ds_classificacao":$("#classificacao_pk option:selected").text(),
            "t_ds_cliente":$("#ic_cliente_operador option:selected").text(),
            "t_ic_cliente":$("#ic_cliente_operador").val(),
            "t_ds_base":$("#ic_base option:selected").text(),
            "t_ic_base":$("#ic_base").val(),
            "t_dt_ativacao":$("#dt_ativacao").val(),
            "t_dt_vencimento":$("#dt_vencimento").val(),
            "t_ds_custo_atual":($("#ds_custo_atual").val()),
            "t_ds_qtde_voz":$("#ds_qtde_voz").val(),
            "t_ds_qtde_dados":$("#ds_qtde_dados").val(),
            "t_ds_status":$("#ic_status_operador option:selected").text(),
            "t_ic_status":$("#ic_status_operador").val(),
            "t_tempo_contrato_pk":$("#tempo_contrato_pk").val(),
            "t_functions":""
        }
    ).draw();
    
    return false;
}

function fcExcluirLeadOperadorSemPk(){
   tblLeadOperador.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcEditarLeadOperadorSemPk(){
    
    fcIncluirLeadOperadorSemPk();
    tblLeadOperador.row(rLinhaSelecionada).remove().draw();
    return false;
}



function fcLimparFormLeadOperador(){
    $("#acao").val("");
    $("#lead_operador_pk").val("");
    $("#operador_pk").val("");
    $("#classificacao_pk").val(" ");
    $("#classificacao_pk").val(" ");
    $("#ic_cliente_operador").val("");
    $("#ic_base").val("");
    $("#dt_ativacao").val("");
    $("#dt_vencimento").val("");
    $("#ds_custo_atual").val("");
    $("#ds_qtde_voz").val("");
    $("#ds_qtde_dados").val("");
    //$("#ic_status_operador").val(""); 
    $("#tempo_contrato_pk").val(""); 
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoLeadOperador(){
    //limpa os dados de qualquer registro existe
    $("#exibir_oc").hide();
    fcLimparFormLeadOperador();
    $("#janela_lead_operador").modal();
    $("#acao").val("ins");
    
}

function fcValidarFormLeadOperador(){
    
    $("#form_lead_operador").validate({
        rules :{
            operador_pk:{
                required:true
            },
            ic_status_operador:{
                required:true
            }
            

        },
        messages:{
            operador_pk:{
                required:"Por favor, selecione Operadora"
            },
            ic_status_operador:{
                required:"Por favor, selecione Status"
            }

        },
        submitHandler: function(form){
            fcEnviarLeadOperador(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}

function fcFormatarDadosLeadOperador(){
    
    
    try{

        var lead_operador_pk = "";
        var operador_pk = "";
        var t_classificacao_pk = "";
        var ic_cliente_operador = "";
        var ic_base = "";
        var dt_ativacao = "";
        var dt_vencimento = "";
        var ds_custo_atual = "";
        var ds_qtde_voz = "";
        var ds_qtde_dados = "";
        var ic_status_operador = "";
        var t_tempo_contrato_pk = "";


        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "lead_operador_pk";
        arrKeys[1] = "operador_pk";
        arrKeys[2] = "ic_cliente";
        arrKeys[3] = "ic_base";
        arrKeys[4] = "dt_ativacao";
        arrKeys[5] = "dt_vencimento";
        arrKeys[6] = "ds_custo_atual";
        arrKeys[7] = "ds_qtde_voz";
        arrKeys[8] = "ds_qtde_dados";
        arrKeys[9] = "ic_status";
        arrKeys[10] = "classificacao_pk";
        arrKeys[11] = "tempo_contrato_pk";
        
        var  data = tblLeadOperador.rows().data();
        
        for(i = 0; i< data.length; i++){

            lead_operador_pk = data[i]['t_pk'];
            operador_pk = data[i]['t_operador_pk'];
            ic_cliente_operador =  data[i]['t_ic_cliente'];
            ic_base =  data[i]['t_ic_base'];
            dt_ativacao =  data[i]['t_dt_ativacao'];
            dt_vencimento =  data[i]['t_dt_vencimento'];
            ds_custo_atual =  moeda2float(data[i]['t_ds_custo_atual']);
            ds_qtde_voz =  data[i]['t_ds_qtde_voz'];
            ds_qtde_dados =  data[i]['t_ds_qtde_dados'];
            ic_status_operador =  data[i]['t_ic_status'];
            t_classificacao_pk =  data[i]['t_classificacao_pk'];
            t_tempo_contrato_pk =  data[i]['t_tempo_contrato_pk'];

            
            
            arrDados[i] = [lead_operador_pk, operador_pk, ic_cliente_operador,ic_base,dt_ativacao,dt_vencimento,ds_custo_atual,ds_qtde_voz,ds_qtde_dados,ic_status_operador,t_classificacao_pk,t_tempo_contrato_pk];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}

function fcCarregarOperador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("operador", "listarTodos", objParametros);
    
   
    carregarComboAjax($("#operador_pk"), arrCarregar, " ", "pk", "ds_operador");
        
}
function fcCarregarClassificacaoOperador(operadoras_pk,ds_operador){
    
    var objParametros = {
        "operadoras_pk": operadoras_pk,
        "ds_operador":ds_operador
    };      
    
    var arrCarregar = carregarController("operador", "listarClassificacaoOPerador", objParametros); 
   
    carregarComboAjax($("#classificacao_pk"), arrCarregar, " ", "pk", "ds_classificacao");
        
}

function fcPegarNomeOperador(v_operador_pk){
    
    if(v_operador_pk > 0){

        var objParametros = {
            "pk": v_operador_pk
        };        
 
        var arrCarregar = carregarController("operador", "listarPk", objParametros);
   
        if (arrCarregar.result == 'success'){
            fcCarregarClassificacaoOperador("",arrCarregar.data[0]['ds_operador']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
    
}
       
$(document).ready(function(){      
    /*var arrCarregar = permissao("lead_operador", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
    fcCarregarGridLeadOperador();
    
    $('#dt_ativacao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_ativacao").keypress(function(){
       mascara(this,mdata);
    });  
    $('#dt_vencimento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_vencimento").keypress(function(){
       mascara(this,mdata);
    });  
    $("#ds_custo_atual").keypress(function(){
       mascara(this,moeda);
    });  
    $("#ds_qtde_voz").keypress(function(){
       mascara(this,soNumeros);
    });  
    $("#ds_qtde_dados").keypress(function(){
       mascara(this,soNumeros);
    });  
    $(document).on('click', '#btn_modal_lead_operador', fcAbrirFormNovoLeadOperador);
    
    
    
    fcCarregarOperador();
    
    
    $("#operador_pk").change(function(){
        fcPegarNomeOperador($("#operador_pk").val());
        
    });
    
    

    
    fcValidarFormLeadOperador();
});