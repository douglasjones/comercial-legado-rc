var tblPropostas;
var tblPropostaItens;
var proposta_contrato_pk = "";
$(document).ready(function()
    {       
               
        // carregar grid de propsotas
        fcCarregarGridProposta();
       
        //Chama modal de cadastro
         $(document).on('click', '#cmdIncluirProposta ', fcAbrirFormNovaProposta);
        //formata as datas do form  
        formataDatasForm();
 
        $(document).on('click', '#cmdIncluirPropostaItens', function () {            
            fcIncluirPropostaItens("");
        } );
 
        //VERSÃO DA PROPOSTA
        $('#n_versao').html('1.0');
        $('#n_versao').val('1.0');
        
        //CARREGAR PRODUTOS         
        fcCarregarOperador();
        carregarListaComboProdutoPropsota();
        
        $("#operador_pk").change(function(){
            tblPropostaItens.clear().destroy();
            carregarListaComboProdutoPropsota();
        });
        
        
        //VALIDAR FORM
        fcValidarFormProposta();
                 
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        
        fcCalculaTotalPropsota();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
        
        fcCarregarEtapasProcessoProposta();
       
         
    }
);

function fcCarregarEtapasProcessoProposta(){

    var objParametros = {
        "pk": $("#processos_propostas_pk").val()
    };        

    var arrCarregar = carregarController("processo", "listarEtapas", objParametros);
    if (arrCarregar.result == 'success'){
        for(i = 0; i < arrCarregar.data.length; i++){
            if(i==0){
                $('#etapas_1').html(arrCarregar.data[0]['etapas']); 
                        
                $('#processos_etapas_pk_1').val(arrCarregar.data[0]['pk']);
            }
            if(i==1){
                $('#etapas_2').html(arrCarregar.data[1]['etapas']);    
               
                $('#processos_etapas_pk_2').val(arrCarregar.data[1]['pk']);
            }
            if(i==2){
                $('#etapas_3').html(arrCarregar.data[2]['etapas']);    
                
                $('#processos_etapas_pk_3').val(arrCarregar.data[1]['pk']);
            }
           
        }
    }      
    else{
        alert('Falhar ao carregar o registro');
    }
}

function fcCarregarGridProposta(){    
    var objParametros = {
        "leads_pk": "",
        "polos_pk":$("#polos_pk_dashboard").val()
    };     
    
    var v_url = montarUrlController("proposta", "listarPropostaDashboard", objParametros);

    //Trata a tabela
    tblPropostas = $('#tblPropostas').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' title='Editar Proposta'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_versao' title='Versão da Propsota'><span><img width=16 height=16 src='../img/versao.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete' title='Excluir Proposta'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_vl_total"}, 
           {"targets": -3, "data": "t_dt_fechamento"}, 
           {"targets": -4, "data": "t_dt_previsao_fechamento"},
           {"targets": -5, "data": "t_dt_envio"},
           {"targets": -6, "data": "t_dt_validade"},
           {"targets": -7, "data": "t_dt_cad"},
           {"targets": -8, "data": "t_ds_responsavel"},  
           {"targets": -9, "data": "t_n_versao"},
           {"targets": -10, "data": "t_ds_lead"},
           {"targets": -11, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblPropostas tbody').on('click', '.function_edit', function () {
        var data;        
        rLinhaSelecionada = null;        
        if(tblPropostas.row( $(this).parents('li')).data()){
            data = tblPropostas.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblPropostas.row( $(this).parents('tr')).data()){
            data = tblPropostas.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarProposta(data);  
        
    } );   

    $('#tblPropostas tbody').on('click', '.function_versao', function () {
        var data;        
        rLinhaSelecionada = null;        
        if(tblPropostas.row( $(this).parents('li')).data()){
            data = tblPropostas.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblPropostas.row( $(this).parents('tr')).data()){
            data = tblPropostas.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcVersaoProposta(data);  
        
    } );   
    
    
    $('#tblPropostas tbody').on('click', '.function_delete', function () {
       
        var data;        
        if(tblPropostas.row( $(this).parents('li') ).data()){
            data = tblPropostas.row( $(this).parents('li') ).data();
        }
        else if(tblPropostas.row( $(this).parents('tr') ).data()){
            data = tblPropostas.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirProposta(data['t_pk']);
        }
    } );     
    return false;
}
function fcExcluirProposta(v_pk){
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              
       
        var arrExcluir = carregarController("proposta", "excluir", objParametros);  
        
        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            tblPropostas.ajax.reload();
            //fcRecarregarGridPropostas();
        }
        else{
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcAbrirFormNovaProposta(){
    
    $('#qtde_itens_proposta').html("");
    $('#vl_total_proposta').html("");
    tblPropostaItens.clear().destroy();
    fcFormatarGridPropostaItens(); 
    
    $("#dt_envio").val("");
    $("#dt_previsao_fechamento").val("");
    $('#dt_fechamento').prop('checked', false);
    $("#dt_validade").val("");
    $("#ds_obs_proposta").val("");
    $("#ds_obs_proposta").text("");
    $("#operador_pk").val("");
    $('#dt_fechamento').prop('checked', false);
    $("input[id=dt_envio]").prop("disabled", false);
    $("input[id=dt_previsao_fechamento]").prop("disabled", false);
    $("input[id=dt_fechamento]").prop("disabled", false);
    $("input[id=dt_validade]").prop("disabled", false);
    
    $("#janela_proposta").modal();
}



function formataDatasForm(){
    
    $('#dt_validade').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_validade").keypress(function(){
       mascara(this,mdata);
    });  
    
    $('#dt_envio').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_envio").keypress(function(){
       mascara(this,mdata);
    });  
    
     $('#dt_previsao_fechamento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_previsao_fechamento").keypress(function(){
       mascara(this,mdata);
    });  
}

function fcValidarFormProposta(){
    
    $("#form_proposta").validate({
        rules :{
            dt_validade:{
                required:true,
                minlength:10
            }
        },
        messages:{
            dt_validade:{
                required:"Por favor, informe Data Validade",
                minlength:"Por favor, informe Data válida"
            }

        },
        submitHandler: function(form){
            fcSalvarProposta();            
            return false;      
        }
    });
}

//SALVA O PROPOSTA
function fcSalvarProposta(){  
    var v_dt_fechamento = 0; 
    var str_proposta_pk = "";
   
    var strJSONDadosTabela = fcFormatarDadosProposta();  
   
    if(strJSONDadosTabela =="")
        return false;
    
    if($('#dt_fechamento').is(":checked")){
        v_dt_fechamento = 1;
    }
    else{
        v_dt_fechamento = 2;
    }
    
    if($("#propostas_pk").val()!=""){
        str_proposta_pk = $("#propostas_pk").val();
    }
 

    var objParametros = {
        "pk": str_proposta_pk,
        "processos_etapas_pk":$('#processos_etapas_pk_2').val(),        
        "dt_envio": $("#dt_envio").val(),
        "dt_previsao_fechamento": $("#dt_previsao_fechamento").val(),
        "dt_fechamento": v_dt_fechamento,        
        "dt_validade": $("#dt_validade").val(),
        "ds_obs": $("#ds_obs_proposta").val(),
        "operador_pk": $("#operador_pk").val(),
        "n_versao": $("#n_versao").html(),
        "polos_pk": $("#polos_propostas_pk").val(),
        "leads_pk": $("#leads_propostas_pk").val(),
        "agendas_pk": "",
        "vl_total":  $('#vl_total_proposta').html(),
        "processos_pk": $("#processos_propostas_pk").val(),
        "ds_processo_etapas":$('#etapas_2').text(),
        "proposta_itens": strJSONDadosTabela          
    };     

    var arrEnviar = carregarController("proposta", "salvar", objParametros);
    if (arrEnviar.result == 'success'){
        $("#janela_proposta").modal("hide");
        tblPropostas.ajax.reload();
       if(v_dt_fechamento==1){
           $("#janela_proposta").modal("hide");
            tblPropostas.ajax.reload();
            proposta_contrato_pk = arrEnviar.data[0]['pk'];
            fcLimparFormContrato();
            fcGerarContrato();
       }
        
    }    
    else{
       
        alert(arrEnviar.result);
    }
    //return true;    
}

function fcGerarContrato(){
    var strJSONDadosTabelaContrato = fcFormatarDadosPropostaContrato();  

        var ic_tipo_contrato = 1; 

        //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
        var objParametros = {
            "pk": "",
            "dt_inicio_contrato": "",
            "dt_fim_contrato": "",
            "processos_etapas_pk":$('#processos_etapas_pk_3').val(),
            "ic_tipo_contrato":ic_tipo_contrato,
            "contratos_pk":"",
            "polos_pk":$("#polos_propostas_pk").val(),
            "propostas_pk":proposta_contrato_pk,
            "responsavel_pk":$("#responsavel_pk").val(),
            "operador_pk":$("#operador_pk").val(),
            "processos_pk":$("#processos_propostas_pk").val(),
            "ds_processo_etapas":$('#etapas_3').text(),
            "contratos_itens": strJSONDadosTabelaContrato
        }; 

        var arrEnviar = carregarController("contrato", "salvar", objParametros);
        if (arrEnviar.result == 'success'){
            $("#janela_contratos").modal("hide");
            fcRecarregarGridContratos();
            
        }
}

//FORMATA OS DADOS DA GRID PROPOSTA ITENS
function fcFormatarDadosProposta(){

    var cboProdutosPk = $("select[id='produtos_servicos_pk']");
    var n_qtde_contratos_itens = $("input[id='n_qtde']");
    var proposta_itens_pk_2 = $("input[id='proposta_itens_pk_2']");
    var vl_total = $("input[id='vl_total']");
    var vl_unit = $("input[id='vl_unit']");

   

    var arrKeys = [];
    arrKeys[0] = "proposta_itens_pk";
    arrKeys[1] = "produtos_servicos_pk";
    arrKeys[2] = "n_qtde";
    arrKeys[3] = "vl_unit";
    arrKeys[4] = "vl_total";
   
    var arrDados = [];
    for(i = 0; i < (cboProdutosPk.length); i++){ 
        try{            
            if(cboProdutosPk.get(i).value == ""){
                cboProdutosPk.get(i).focus();
                return "";
            }      

            arrDados[i] = [
                proposta_itens_pk_2.get(i).value,
                cboProdutosPk.get(i).value, 
                n_qtde_contratos_itens.get(i).value, 
                moeda2float(vl_unit.get(i).value), 
                moeda2float(vl_total.get(i).value),
            ];
           
        }
        catch(err){
            alert(err.message);
        }
    }
    return arrayToJson(arrKeys, arrDados); 
    
}
function fcFormatarDadosPropostaContrato(){

    var cboProdutosPk_contrato = $("select[id='produtos_servicos_pk']");
    var n_qtde_contratos_itens_contrato = $("input[id='n_qtde']");
    var vl_total_contrato = $("input[id='vl_total']");
    var vl_unit_contrato = $("input[id='vl_unit']");

   

    var arrKeys = [];
    arrKeys[1] = "produtos_servicos_pk";
    arrKeys[2] = "n_qtde";
    arrKeys[3] = "vl_unit";
    arrKeys[4] = "vl_total";
   
    var arrDadosContrato = [];
    for(l = 0; l < (cboProdutosPk_contrato.length); l++){ 
        try{            
            if(cboProdutosPk_contrato.get(l).value == ""){
                cboProdutosPk_contrato.get(l).focus();
                return "";
            }      

            arrDadosContrato[l] = [
                "",
                cboProdutosPk_contrato.get(l).value, 
                n_qtde_contratos_itens_contrato.get(l).value, 
                moeda2float(vl_unit_contrato.get(l).value), 
                moeda2float(vl_total_contrato.get(l).value),
            ];
           
        }
        catch(err){
            alert(err.message);
        }
    }
    return arrayToJson(arrKeys, arrDadosContrato); 
    
}

function fcEditarProposta(objRegistro){
   
     
    $('#dt_fechamento').prop('checked', false);
    $("input[id=dt_envio]").prop("disabled", false);
    $("input[id=dt_previsao_fechamento]").prop("disabled", false);
    $("input[id=dt_fechamento]").prop("disabled", false);
    $("input[id=dt_validade]").prop("disabled", false);
    $("#ds_obs_proposta").prop("disabled", false);
    
    
    
    //carregarComboContratoPai(objRegistro['t_contratos_pk']);
   
    //Carrega as informações da linha selecionada.
    $("#propostas_pk").val(objRegistro['t_pk']);
    $("#dt_envio").val(objRegistro['t_dt_envio']); 
    $("#leads_propostas_pk").val(objRegistro['t_leads_pk']); 
    $("#polos_propostas_pk").val(objRegistro['t_polos_pk']); 
    $("#processos_propostas_pk").val(objRegistro['t_processos_pk']); 
    $("#dt_previsao_fechamento").val(objRegistro['t_dt_previsao_fechamento']);
    $("#dt_validade").val(objRegistro['t_dt_validade']);
    $("#ds_obs_proposta").val(objRegistro['t_ds_obs']);
    fcCarregarOperador();
    $("#operador_pk").val(objRegistro['t_operador_pk']);
    tblPropostaItens.clear().destroy();
    carregarListaComboProdutoPropsota();
    if(objRegistro['t_dt_fechamento']!=null){
        $('#dt_fechamento').prop('checked', true);
        $("input[id=dt_envio]").prop("disabled", true);
        $("input[id=dt_previsao_fechamento]").prop("disabled", true);
        $("input[id=dt_fechamento]").prop("disabled", true);
        $("input[id=dt_validade]").prop("disabled", true);
        $("#ds_obs_proposta").prop("disabled", true);
        var v_disabled = "readonly";
    }
    
    $("#janela_proposta").modal(); 
    fcAtualizarDadosGridPropostaItens(v_disabled);

    $("#form_proposta").data('validator').resetForm();
    
}

function fcVersaoProposta(objRegistro){
    
    
     
    $('#dt_fechamento').prop('checked', false);
    $("input[id=dt_envio]").prop("disabled", false);
    $("input[id=dt_previsao_fechamento]").prop("disabled", false);
    $("input[id=dt_fechamento]").prop("disabled", false);
    $("input[id=dt_validade]").prop("disabled", false);
    $("#ds_obs_proposta").prop("disabled", false);
        
    //fcFormatarGridPropostaItens();     
    //carregarComboContratoPai(objRegistro['t_contratos_pk']);

    //Carrega as informações da linha selecionada.
    $("#n_versao").html(1+ new Number(objRegistro['t_n_versao']));
    $("#propostas_pk").val(objRegistro['t_pk']);
    $("#propostas_pai_pk").val(objRegistro['t_pk']);
    $("#dt_envio").val(objRegistro['t_dt_envio']); 
    $("#dt_previsao_fechamento").val(objRegistro['t_dt_previsao_fechamento']);
    $("#dt_validade").val(objRegistro['t_dt_validade']);
    $("#ds_obs_proposta").val(objRegistro['t_ds_obs']);
    $("#leads_propostas_pk").val(objRegistro['t_leads_pk']); 
    $("#polos_propostas_pk").val(objRegistro['t_polos_pk']); 
    $("#processos_propostas_pk").val(objRegistro['t_processos_pk']);
    fcCarregarOperador();
    $("#operador_pk").val(objRegistro['t_operador_pk']);
    tblPropostaItens.clear().destroy();
    carregarListaComboProdutoPropsota();
    if(objRegistro['t_dt_fechamento']!=null){
        $('#dt_fechamento').prop('checked', true);
        $("input[id=dt_envio]").prop("disabled", true);
        $("input[id=dt_previsao_fechamento]").prop("disabled", true);
        $("input[id=dt_fechamento]").prop("disabled", true);
        $("input[id=dt_validade]").prop("disabled", true);
        $("#ds_obs_proposta").prop("disabled", true);
        var v_disabled = "readonly";
    }
    
    $("#janela_proposta").modal(); 
    fcAtualizarDadosGridPropostaItens(v_disabled);

    $("#form_proposta").data('validator').resetForm();
    
}

//RETORNA OS DADOS CADASTRAIS DO CONTRATO ITENS
function fcAtualizarDadosGridPropostaItens(v_disabled){    
    var objParametros = {
        "propostas_pk":$("#propostas_pk").val()
    };  
    var arrCarregar = carregarController("proposta_item", "listarPropostaItem", objParametros);  
    
    if (arrCarregar.result == 'success'){
        
        for(i = 0; i < arrCarregar.data.length; i++){
            
            if($("#propostas_pk").val()!=""){
                //Adiciona a linha.
                fcIncluirPropostaItens(arrCarregar.data[i]['t_pk'],v_disabled);                
            }
            
            //Pega as variaveis 
            var cboProdutosServicosPk = $("select[id='produtos_servicos_pk']");
            var proposta_itens_pk_2 = $("input[id='proposta_itens_pk_2']");
            var n_qtde = $("input[id='n_qtde']");
            var vl_total = $("input[id='vl_total']");
            var vl_unit = $("input[id='vl_unit']");
           
                     
            cboProdutosServicosPk.get(i).value = arrCarregar.data[i]['t_produtos_servicos_pk'];            
            proposta_itens_pk_2.get(i).value = arrCarregar.data[i]['t_pk'];     
            n_qtde.get(i).value = arrCarregar.data[i]['t_n_qtde'];
            vl_total.get(i).value = arrCarregar.data[i]['t_vl_total'];
            vl_unit.get(i).value = arrCarregar.data[i]['t_vl_unit'];
            vl_unit.get(i).disabled = true;
                        
        }        
        fcCalculaTotalPropsota()
    }
    else{
        alert('Falhou a requisição de exclusão.');
    }
}


function fcExcluirLinha(vlr){
    
    var proposta_itens_pk = vlr;

    if(proposta_itens_pk!=""){

         var objParametros = {
            "pk": proposta_itens_pk
        };              

        var arrExcluir = carregarController("proposta_item", "excluir", objParametros);   
        
        if (arrExcluir.result == 'success'){
            //Exibe a mensagem
            alert(arrExcluir.message);
            tblPropostas.ajax.reload();   
        }
        else{
           //Exibe a mensagem
            alert(arrExcluir.message);
        } 
    }
    return false;
 
    fcCalculaTotalPropsota();
}


function fcCancelar(){
    sendPost("proposta_res_form.php", {token: token});
}

function fcCarregar(){
    
    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("proposta", "listarPk", objParametros);
        if (arrCarregar.result == 'success'){
        
            $("#n_versao").val(arrCarregar.data[0]['n_versao']);
            $("#responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
            $("#vl_total").val(arrCarregar.data[0]['vl_total']);
            $("#ds_obs_proposta").val(arrCarregar.data[0]['ds_obs']);
            $("#dt_validade").val(arrCarregar.data[0]['dt_validade']);
            $("#dt_envio").val(arrCarregar.data[0]['dt_envio']);
            $("#dt_previsao_fechamento").val(arrCarregar.data[0]['dt_previsao_fechamento']);
            $("#dt_fechamento").val(arrCarregar.data[0]['dt_fechamento']);
            $("#dt_cancelamento").val(arrCarregar.data[0]['dt_cancelamento']);
            $("#ds_obs_proposta_motivo_cancelamento").val(arrCarregar.data[0]['ds_obs_motivo_cancelamento']);
            $("#processos_etapas_pk").val(arrCarregar.data[0]['processos_etapas_pk']);
            $("#agendas_pk").val(arrCarregar.data[0]['agendas_pk']);
            $("#operador_pk").val(arrCarregar.data[0]['operador_pk']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

//GRID ITENS PROPOSTA
function carregarListaComboProdutoPropsota(){
  
    var url = '../controller/produto_servico.controller.php?job=listarOperadorPk&token='+token+'&operador_pk='+$("#operador_pk").val();
    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            strComboProduto = "<select class='form-control form-control-sm' id='produtos_servicos_pk'  name='produtos_servicos_pk' onchange='carregarValorProdutoServico(this.value)'><option></option>";
            for(i = 0; i < output.data.length; i++){
                strComboProduto = strComboProduto + "<option value='"+output.data[i]['pk']+"' >"+output.data[i]['ds_produto_servico']+"</option>";
            }
            strComboProduto+= "</select>";
            
            //Carrega os dados no combo.
            fcFormatarGridPropostaItens();
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}
//FORMATA O GRID DE CONTRATO ITENS
function fcFormatarGridPropostaItens(){    
    tblPropostaItens = $("#tblPropostaItens").DataTable({
        "scrollX": false,
        "responsive": false,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "ordering": false,
        "columnDefs" : [
            {   
                "targets": 0,
                "data": "t1",
                "visible":false
            },
            
            {   
                "targets": 1,
                "data": "t2"
            },            
            {   
                "targets": 2,
                "data": "t3"
            },            
            {   
                "targets": 3,
                "data": "t4"
            },            
            {   
                "targets": 4,
                "data": "t5"
            },
            {   
                "targets": 5,
                "data": "t6",
                "defaultContent": "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            }        
        ],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    return false;    
}
//INCLUI PROPOSTA ITENS
function fcIncluirPropostaItens(propostas_itens_pk,v_disabled){  
    
    tblPropostaItens.row.add(          
    {           
        "t1":propostas_itens_pk,
        "t2":strComboProduto + "<input type='hidden' class='form-control form-control-sm' id='proposta_itens_pk_2' size='4' /><input type='hidden' class='form-control form-control-sm' id='ic_valor_aberto' size='4' />",
        "t3":"<input type='text' class='form-control form-control-sm' onchange='fcCalcularValorVlUnit()' onkeypress='mascara(this,soNumeros)' id='n_qtde' size='4' "+v_disabled+"/>",
        "t4":"<input type='text' class='form-control form-control-sm' onchange='fcCalcularValorVlUnit()' onkeypress='mascara(this,moeda)' id='vl_unit' "+v_disabled+" />",
        "t5":"<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,moeda)' id='vl_total' "+v_disabled+"/>",
        "t6":"<a class='function_delete' ><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
    }            
    ).draw( false );

    tblPropostaItens.on('click', '.function_delete', function () {      
        var data;        
        if(tblPropostaItens.row( $(this).parents('li') ).data()){    
            data = tblPropostaItens.row( $(this).parents('li') ).data();            
        }else if(tblPropostaItens.row( $(this).parents('tr') ).data()){            
            data = tblPropostaItens.row( $(this).parents('tr') ).data();
            
        }
        
        if(data['t1'] != ""){
              
            fcExcluirLinha(data['t1']);
        }
        tblPropostaItens.row($(this).parents('tr')).remove().draw();
        fcCalculaTotalPropsota();
    } ); 
    
    return false;
}
function fcCalcularValorVlUnit(){
    try{
   
        var n_qtde_propostas_itens = $("input[id='n_qtde']");
        var vl_unit = $("input[id='vl_unit']");
        var vl_total = $("input[id='vl_total']");

        
        for(i = 0; i < n_qtde_propostas_itens.length; i++){             
            vl_total.get(i).value = float2moeda(n_qtde_propostas_itens.get(i).value * moeda2float(vl_unit.get(i).value));
        }
        
       fcCalculaTotalPropsota()
    }
    catch(err){
        alert(err.message)
    }    
}

function fcCarregarOperador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("operador", "listarTodos", objParametros); 
   
    carregarComboAjax($("#operador_pk"), arrCarregar, " ", "pk", "ds_operador");
        
}

function carregarValorProdutoServico(pk){
    
    var objParametros = {
        "pk": pk
    };
    var arrCarregar = carregarController("produto_servico", "listarPk", objParametros); 
    
    
    //PEGA A QUANTIDADE DE LINHAS INSERIDAS
    var  data = tblPropostaItens.rows().data();
    
    var t = (data.length - 1);
    
   
    var vl_unit = $("input[id='vl_unit']"); 
    
    if(arrCarregar.data[0]['ic_valor_aberto']!=1){
        
        vl_unit.get(t).value = float2moeda(arrCarregar.data[0]['vl_produto_servico']);
        vl_unit.get(t).disabled = true;
    }
    else{
        vl_unit.get(t).value = (arrCarregar.data[0]['vl_produto_servico']);
        vl_unit.get(t).disabled = false;
    }
    
    
    t++;
   
        
}

function fcCalculaTotalPropsota(){

    $('#qtde_itens_proposta').html("");
    $('#vl_total_proposta').html("");
    
    var n_qtde_propostas_itens = $("input[id='n_qtde']");
    var vl_total = $("input[id='vl_total']");

    var vqtde_itens_proposta = 0;
    var vtotal_proposta = 0;
    var  data = tblPropostaItens.rows().data();

    for(i = 0; i < data.length; i++){         
        vqtde_itens_proposta += new Number(n_qtde_propostas_itens.get(i).value)
        
        vtotal_proposta += moeda2float(vl_total.get(i).value)    
    }

   $('#qtde_itens_proposta').html(vqtde_itens_proposta)
   $('#vl_total_proposta').html(float2moeda(vtotal_proposta));
}

//FIM GRID




