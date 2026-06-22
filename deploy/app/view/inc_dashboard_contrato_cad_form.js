//--------------------CONTRATOS----------------------------
function carregarComboContratoPai(vlr){
    var contrato_pai_pk = "";
    if(vlr > 0){
        contrato_pai_pk = vlr;
    }
    else{
        contrato_pai_pk = "";
    }
    
    var objParametros = {
        "leads_pk": "",
        "contratos_pai_pk":contrato_pai_pk,
        "contratos_pk":$("#contratos_pk").val()
    };      
    
    var arrCarregar = carregarController("contrato", "listarContratoPai", objParametros);
    
    carregarComboAjax($("#contrato_pai_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fcCarregarGridContrato(){
    
    var objParametros = {
        "leads_pk": "",
        "polos_pk":$("#polos_pk_dashboard").val()
    };     
    
    var v_url = montarUrlController("contrato", "listarContratoDashboard", objParametros);
    //Trata a tabela
    tblContratos = $('#tblContratos').DataTable({
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
           {"targets": -2, "data": "t_vl_total"},
           {"targets": -3, "data": "t_ds_tipo_contrato"},
           {"targets": -4, "data": "t_dt_fim_contrato"},
           {"targets": -5, "data": "t_dt_inicio_contrato"},
           {"targets": -6, "data": "t_ds_lead"},
           {"targets": -7, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblContratos tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblContratos.row( $(this).parents('li')).data()){
            data = tblContratos.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblContratos.row( $(this).parents('tr')).data()){
            data = tblContratos.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarContrato(data);
        
    } );   
    
    $('#tblContratos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblContratos.row( $(this).parents('li') ).data()){
            data = tblContratos.row( $(this).parents('li') ).data();
        }
        else if(tblContratos.row( $(this).parents('tr') ).data()){
            data = tblContratos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirContrato(data['t_pk']);
        }
    } ); 
    
    return false;
}

function fcEditarContrato(objRegistro){
    
    tblContratoItens.clear().destroy();
    tblContratoEtapas.clear().destroy();
    
    fcFormatarGridContratoItens(); 
    fcFormatarGridContratoEtapa(); 

    fcCarregarOperadorContrato();

    $("#operador_contrato_pk").val(objRegistro['t_operador_pk']);
    
    carregarComboContratoPai(objRegistro['t_contratos_pk']);

    //Carrega as informações da linha selecionada.
    $("#contratos_pk").val(objRegistro['t_pk']);
    $("#dt_inicio_contrato").val(objRegistro['t_dt_inicio_contrato']);
    $("#dt_fim_contrato").val(objRegistro['t_dt_fim_contrato']);
    $("#polos_contratos_pk").val(objRegistro['t_polos_pk']);
    $("#processos_contratos_pk").val(objRegistro['t_processos_pk']);
    fcCarregarEtapasProcessoContratos();

    if(objRegistro['t_ic_tipo_contrato'] == 1){
        $('#ic_contrato').prop('checked', true);
        $('#ic_aditivo').prop('checked', false);
        $('#contrato_pai_pk').val("");
        $('#exib_contrato_pai').hide();
    }
    else if(objRegistro['t_ic_tipo_contrato'] == 2){
        $('#ic_contrato').prop('checked', false);
        $('#ic_aditivo').prop('checked', true);
        $("#contrato_pai_pk").val(objRegistro['t_contratos_pk']);
        $('#exib_contrato_pai').show();
    
   }   
   $("#janela_contratos").modal(); 
    fcAtualizarDadosGridContratoItens();
    fcAtualizarDadosGridContratoEtapas();

   $("#form_contrato").data('validator').resetForm();
    
}

function fcExcluirContrato(v_pk){
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              
       
        var arrExcluir = carregarController("contrato", "excluir", objParametros); 
        
        if (arrExcluir.result == 'success'){
            
            //Exibe a mensagem
            alert(arrExcluir.message);
            //tblContratos.clear().destroy();
            fcRecarregarGridContratos();
        }
        else{
        }
    }
    else{
        alert("Código não encontrado");
    }
}

//FORMATA OS DADOS DA GRID CONTRATO ITENS
function fcFormatarDadosContrato(){

    var cboProdutosPk = $("select[id='produtos_servicos_contrato_pk']");
    var n_qtde_contratos_itens_contrato = $("input[id='n_qtde_contrato']");
    var contratos_itens_pk_2 = $("input[id='contratos_itens_pk_2']");
    var vl_total_contrato = $("input[id='vl_total_contrato']");
    var vl_unit_contrato = $("input[id='vl_unit_contrato']");
    var n_qtde_dias_semana_contrato = $("input[id='n_qtde_dias_semana_contrato']");
    
    var arrKeys = [];
    arrKeys[0] = "contratos_itens_pk";
    arrKeys[1] = "produtos_servicos_pk";
    arrKeys[2] = "n_qtde";
    arrKeys[3] = "vl_unit";
    arrKeys[4] = "vl_total";
    arrKeys[5] = "n_qtde_dias_semana";
    var arrDados = [];
    for(i = 0; i < (cboProdutosPk.length); i++){ 

        try{
            
            if(cboProdutosPk.get(i).value == ""){
                cboProdutosPk.get(i).focus();
                return "";
            }
            
            arrDados[i] = [
                contratos_itens_pk_2.get(i).value,
                cboProdutosPk.get(i).value, 
                n_qtde_contratos_itens_contrato.get(i).value, 
                moeda2float(vl_unit_contrato.get(i).value), 
                moeda2float(vl_total_contrato.get(i).value),
                n_qtde_dias_semana_contrato.get(i).value
            ];
        }
        catch(err){
            alert(err.message);
        }
    }    
    
    return arrayToJson(arrKeys, arrDados);    
}

//SALVA O CONTRATO
function fcSalvarContrato(){
    
    var strJSONDadosTabela = fcFormatarDadosContrato();   
    if(strJSONDadosTabela =="")
        return false;
    
    var strJSONDadosTabelaEtapas = fcFormatarDadosContratoEtapas();   
    if(strJSONDadosTabelaEtapas =="")
        return false;
        
    
    var ic_tipo_contrato = 1; 
    
    if($("#ic_contrato").is(":checked") == true ){
        ic_tipo_contrato = 1;
        $('#contrato_pai_pk').val("null");
    }
    else if($("#ic_aditivo").is(":checked") == true){
        ic_tipo_contrato = 2;
        if($('#contrato_pai_pk').val()==""){
            $("#alert_contrato_pai").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_contrato_pai").slideUp(500);
            });
            $('#contrato_pai_pk').focus();
            return false;
        }
    }
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#contratos_pk").val(),
        "dt_inicio_contrato": $("#dt_inicio_contrato").val(),
        "dt_fim_contrato": $("#dt_fim_contrato").val(),
        "processos_etapas_pk":$('#processos_etapas_pk_3').val(),
        "ic_tipo_contrato":ic_tipo_contrato,
        "contratos_pk":$('#contrato_pai_pk').val(),
        "polos_pk":$("#polos_contratos_pk").val(),
        "responsavel_pk":$("#responsavel_pk").val(),
        "operador_pk":$("#operador_contrato_pk").val(),
        "processos_pk":$("#processos_contratos_pk").val(),
        "ds_processo_etapas":$('#etapas_3').text(),
        "contratos_itens": strJSONDadosTabela,
        "contratos_etapas": strJSONDadosTabelaEtapas
    }; 
    
    var arrEnviar = carregarController("contrato", "salvar", objParametros);



    if (arrEnviar.result == 'success'){
        $("#janela_contratos").modal("hide");
        fcRecarregarGridContratos();
    }    
    else{
        alert(arrEnviar.result);
    }
    return true;
    
}

function fcCarregarResponsavel(){

    if(pk > 0){
        var objParametros = {
            "leads_pk": " ",
            "ds_grupo":"Comercial"
        };       
        
        var arrCarregar = carregarController("lead_responsavel", "listarResponsavelLeadComercial", objParametros);
        
        if (arrCarregar.result == 'success'){
            
            $("#responsavel_pk").text(arrCarregar.data[0]['pk']);  
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcValidarFormContratos(){
    
    $("#form_contrato").validate({
        rules :{
            /*dt_inicio_contrato:{
                required:true,
                minlength:10
            },
            dt_fim_contrato:{
                required:true,
                minlength:10
            }*/

        },
        messages:{
            /*dt_inicio_contrato:{
                required:"Por favor, informe Data Inicio",
                minlength:"Por favor, informe Data válida"
            },
            dt_fim_contrato:{
                required:"Por favor, informe Data Fim",
                minlength:"Por favor, informe Data válida"
            }*/

        },
        submitHandler: function(form){
            fcSalvarContrato(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}

//---------------------------------- CONTRATOS ITENS -------------------------------------------

//CARREGA O COMBO DE PRODUTOS DO CONTRATO
function carregarListaComboProduto(){

    var url = '../controller/produto_servico.controller.php?job=listarOperadorPk&token='+token+'&operador_pk='+$("#operador_contrato_pk").val();
    
    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            strComboProdutoContrato = "<select class='form-control form-control-sm' onchange='carregarValorProdutoServicoContrato(this.value)' id='produtos_servicos_contrato_pk' name='produtos_servicos_contrato_pk'><option></option>";
            for(i = 0; i < output.data.length; i++){
                strComboProdutoContrato = strComboProdutoContrato + "<option value='"+output.data[i]['pk']+"'>"+output.data[i]['ds_produto_servico']+"</option>";
            }
            strComboProdutoContrato+= "</select>";
            
            //Carrega os dados no combo.
            fcFormatarGridContratoItens();
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}

function carregarValorProdutoServicoContrato(pk){
    
    var objParametros = {
        "pk": pk
    };
    var arrCarregar = carregarController("produto_servico", "listarPk", objParametros); 
    
    
    //PEGA A QUANTIDADE DE LINHAS INSERIDAS
    var  data = tblContratoItens.rows().data();
    
    var t = (data.length - 1);
    
   
    var vl_unit_contrato = $("input[id='vl_unit_contrato']"); 
    
    if(arrCarregar.data[0]['ic_valor_aberto']!=1){
        
        vl_unit_contrato.get(t).value = float2moeda(arrCarregar.data[0]['vl_produto_servico']);
        vl_unit_contrato.get(t).disabled = true;
    }
    else{
        vl_unit_contrato.get(t).value = (arrCarregar.data[0]['vl_produto_servico']);
        vl_unit_contrato.get(t).disabled = false;
    }
    
    
    t++;
   
        
}

//FORMATA O GRID DE CONTRATO ITENS
function fcFormatarGridContratoItens(){
    tblContratoItens = $("#tblContratoItens").DataTable({
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
                "data": "t6"
            },
            {   
                "targets": 6,
                "data": "t7",
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

//RETORNA OS DADOS CADASTRAIS DO CONTRATO ITENS
function fcAtualizarDadosGridContratoItens(){
    
    var objParametros = {
        "contratos_pk":$("#contratos_pk").val()
    };              

    var arrCarregar = carregarController("contrato_item", "listarContratoItem", objParametros);  

    if (arrCarregar.result == 'success'){

        for(i = 0; i < arrCarregar.data.length; i++){

            if($("#contratos_pk").val()!=""){
                //Adiciona a linha.
                fcIncluirContratoItens(arrCarregar.data[i]['t_pk']);
            }

            //Pega as variaveis 
            var cboProdutosServicosPk_contrato = $("select[id='produtos_servicos_contrato_pk']");
            var contratos_itens_pk_2 = $("input[id='contratos_itens_pk_2']");
            var n_qtde_contratos_itens_contrato = $("input[id='n_qtde_contrato']");
            var n_qtde_dias_semana_contrato = $("input[id='n_qtde_dias_semana_contrato']");
            var vl_total_contrato = $("input[id='vl_total_contrato']");
            var vl_unit_contrato = $("input[id='vl_unit_contrato']");

            

            cboProdutosServicosPk_contrato.get(i).value = arrCarregar.data[i]['t_produtos_servicos_pk'];
            contratos_itens_pk_2.get(i).value = arrCarregar.data[i]['t_pk'];
            n_qtde_contratos_itens_contrato.get(i).value = arrCarregar.data[i]['t_n_qtde'];
            n_qtde_dias_semana_contrato.get(i).value = arrCarregar.data[i]['t_n_qtde_dias_semana'];
            vl_total_contrato.get(i).value = arrCarregar.data[i]['t_vl_total'];
            vl_unit_contrato.get(i).value = arrCarregar.data[i]['t_vl_unit'];



        }
    }
    else{
        alert('Falhou a requisição de exclusão.');
    }
}

//INCLUI CONTRATO ITENS
function fcIncluirContratoItens(contratos_itens_pk){

    tblContratoItens.row.add(
    {   
        "t1":contratos_itens_pk,
        "t2":strComboProdutoContrato + "<input type='hidden' class='form-control form-control-sm' id='contratos_itens_pk_2' size='4'/>",
        "t3":"<input type='text' class='form-control form-control-sm' onchange='fcCalcularValorVlUnitContrato()' onkeypress='mascara(this,soNumeros)' id='n_qtde_contrato' size='4'/>",
        "t4":"<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,soNumeros)' id='n_qtde_dias_semana_contrato'/>",
        "t5":"<input type='text' class='form-control form-control-sm' onchange='fcCalcularValorVlUnitContrato()' onkeypress='mascara(this,moeda)' id='vl_unit_contrato'  />",
        "t6":"<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,moeda)' id='vl_total_contrato' readonly/>",
        "t7":"<a class='function_delete' ><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
    }            
    ).draw( false );
    
    tblContratoItens.on('click', '.function_delete', function () {
        var data;
        if(tblContratoItens.row( $(this).parents('li') ).data()){
            data = tblContratoItens.row( $(this).parents('li') ).data();
        }
        else if(tblContratoItens.row( $(this).parents('tr') ).data()){
            data = tblContratoItens.row( $(this).parents('tr') ).data();
        }
        if(data['t1'] != ""){
            fcExcluirLinhaContrato(data['t1']);
        }
        tblContratoItens.row($(this).parents('tr')).remove().draw();
    } );
    
    
   
    return false;
}

function fcCalcularValorVlUnitContrato(){
    try{
        
        var n_qtde_contratos_itens_contrato = $("input[id='n_qtde_contrato']");
        var vl_unit_contrato = $("input[id='vl_unit_contrato']");
        var vl_total_contrato = $("input[id='vl_total_contrato']");
        
        for(i = 0; i < n_qtde_contratos_itens_contrato.length; i++){
            
            vl_total_contrato.get(i).value = float2moeda(n_qtde_contratos_itens_contrato.get(i).value * moeda2float(vl_unit_contrato.get(i).value));
        }

    }
    catch(err){
        alert(err.message)
    }
    
}
function fcExcluirLinhaContrato(vlr){
    var contratos_itens_pk = vlr;
    if(contratos_itens_pk!=""){
         var objParametros = {
            "pk": contratos_itens_pk
        };              

        var arrExcluir = carregarController("contrato_item", "excluir", objParametros);   
       
        if (arrExcluir.result == 'success'){
            //Exibe a mensagem
            alert(arrExcluir.message);
            tblContratos.ajax.reload();
        }
        else{
           //Exibe a mensagem
            alert(arrExcluir.message);
        } 
    }
    
    return false;
}

function fcLimparFormContrato(){
    $("#contratos_pk").val("");
    $("#operador_contrato_pk").val("");
    $('#contrato_pai_pk').val("");
    $("#dt_inicio_contrato").val("");
    $("#dt_fim_contrato").val("");
    tblContratoItens.clear().destroy();
    fcFormatarGridContratoItens(); 
    tblContratoEtapas.clear().destroy();
    fcFormatarGridContratoEtapa();
}

//abre o formulario para a inclusao de um novo contrato.
function fcAbrirFormNovoContrato(){
    fcLimparFormContrato();
    $('#exib_contrato_pai').hide();
    $("#contratos_pk").val("");
    $('#contrato_pai_pk').val("");
    $('#ic_contrato').prop('checked', false);
    $('#ic_aditivo').prop('checked', false);
    $("#dt_inicio_contrato").val("");
    $("#dt_fim_contrato").val("");
    $("#janela_contratos").modal();
    carregarComboContratoPai(0);
    fcAtualizarDadosGridContratoItens();
    fcAtualizarDadosGridContratoEtapas();
    var validator = $( "#form_contrato" ).validate();
    validator.resetForm();
    
    
    
}

function fcRecarregarGridContratos(){
    tblContratos.ajax.reload();
    tblContratos.clear().destroy();    
    fcCarregarGridContrato();
}

function fcRecarregarGridItensContatos(){
    tblContratoItens.clear().destroy();    
    
    fcAtualizarDadosGridContratoItens();
    fcFormatarGridContratoItens();
    
    tblContratoEtapas.clear().destroy();
    
    fcAtualizarDadosGridContratoEtapas();
    fcFormatarGridContratoEtapa();
}


function fcCarregarOperadorContrato(){
    
    var objParametros = {
        "pk": ""
    };      
    var arrCarregar = carregarController("operador", "listarTodos", objParametros); 

    carregarComboAjax($("#operador_contrato_pk"), arrCarregar, " ", "pk", "ds_operador");
        
}

//---------------------------------- CONTRATOS ETAPAS -------------------------------------------

//CARREGA O COMBO DE PRODUTOS DO CONTRATO
function carregarListaComboEtapa(){

    var url = '../controller/contrato.controller.php?job=listarContratoEtapa&token='+token+'&operador_pk='+$("#operador_contrato_pk").val();

    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            strContratoEtapa = "<select class='form-control form-control-sm' id='contratos_etapas_pk' name='contratos_etapas_pk'><option></option>";
            for(i = 0; i < output.data.length; i++){
                strContratoEtapa = strContratoEtapa + "<option value='"+output.data[i]['t_pk']+"'>"+output.data[i]['t_ds_etapa']+"</option>";
            }
            strContratoEtapa+= "</select>";
            
            //Carrega os dados no combo.
            fcFormatarGridContratoEtapa();
            
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
function fcFormatarGridContratoEtapa(){
    tblContratoEtapas = $("#tblContratoEtapas").DataTable({
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
                "data": "t6"
            },            
            {   
                "targets": 6,
                "data": "t7",
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

//RETORNA OS DADOS CADASTRAIS DO CONTRATO ITENS
function fcAtualizarDadosGridContratoEtapas(){
    
    var objParametros = {
        "contratos_pk":$("#contratos_pk").val()
    };              

    var arrCarregar = carregarController("contrato", "listarContratoEtapaCadastrado", objParametros);  
    
    if (arrCarregar.result == 'success'){

        for(i = 0; i < arrCarregar.data.length; i++){

            if($("#contratos_pk").val()!=""){
                //Adiciona a linha.
                fcIncluirContratoEtapas(arrCarregar.data[i]['pk']);
            }

            //Pega as variaveis 
            var cboEtapasContrato = $("select[id='contratos_etapas_pk']");
            var contratos_etapas_pk_2 = $("input[id='contratos_etapas_pk_2']");
            var dt_etapa = $("input[id='dt_etapa']");
            var usuario_cadastro = $("input[id='usuario_cadastro']");
            var dt_cadastro = $("input[id='dt_cadastro']");
            var ds_obs = $("input[id='ds_obs']");

            

            cboEtapasContrato.get(i).value = arrCarregar.data[i]['etapas_contratos_pk'];
            contratos_etapas_pk_2.get(i).value = arrCarregar.data[i]['pk'];
            dt_etapa.get(i).value = arrCarregar.data[i]['dt_etapa'];
            usuario_cadastro.get(i).value = arrCarregar.data[i]['usuario_cadastro'];
            dt_cadastro.get(i).value = arrCarregar.data[i]['dt_cadastro'];
            ds_obs.get(i).value = arrCarregar.data[i]['ds_obs'];



        }
    }
    else{
        alert('Falhou a requisição de exclusão.');
    }
}

//INCLUI CONTRATO ITENS
function fcIncluirContratoEtapas(contratos_etapas_pk){

    tblContratoEtapas.row.add(
    {   
        "t1":contratos_etapas_pk,
        "t2":strContratoEtapa + "<input type='hidden' class='form-control form-control-sm' id='contratos_etapas_pk_2' size='4'/>",
        "t3":"<input type='text' class='form-control form-control-sm' maxlength='10' onkeypress='mascara(this,mdata)' id='dt_etapa' />",
        "t4":"<input type='text' class='form-control form-control-sm' disabled id='usuario_cadastro'/>",
        "t5":"<input type='text' class='form-control form-control-sm' disabled id='dt_cadastro'  />",
        "t6":"<input type='text' class='form-control form-control-sm' id='ds_obs' />",
        "t7":"<a class='function_delete' ><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
    }            
    ).draw( false );
    
    tblContratoEtapas.on('click', '.function_delete', function () {
        var data;
        if(tblContratoEtapas.row( $(this).parents('li') ).data()){
            data = tblContratoEtapas.row( $(this).parents('li') ).data();
        }
        else if(tblContratoEtapas.row( $(this).parents('tr') ).data()){
            data = tblContratoEtapas.row( $(this).parents('tr') ).data();
        }
        if(data['t1'] != ""){
            fcExcluirLinhaEtapa(data['t1']);
        }
        tblContratoEtapas.row($(this).parents('tr')).remove().draw();
    } );
    
    
   
    return false;
}

function fcExcluirLinhaEtapa(vlr){
    var contratos_etapas_pk = vlr;
    if(contratos_etapas_pk!=""){
         var objParametros = {
            "pk": contratos_etapas_pk
        };              

        var arrExcluir = carregarController("contrato", "excluirEtapa", objParametros);   
       
        if (arrExcluir.result == 'success'){
            //Exibe a mensagem
            alert(arrExcluir.message);
            tblContratoEtapas.ajax.reload();
        }
        else{
           //Exibe a mensagem
            alert(arrExcluir.message);
        } 
    }
    
    return false;
}

function fcFormatarDadosContratoEtapas(){

    var cboEtapasContrato = $("select[id='contratos_etapas_pk']");
    var contratos_etapas_pk_2 = $("input[id='contratos_etapas_pk_2']");
    var dt_etapa = $("input[id='dt_etapa']");
    var usuario_cadastro = $("input[id='usuario_cadastro']");
    var dt_cadastro = $("input[id='dt_cadastro']");
    var ds_obs = $("input[id='ds_obs']");
    
    
    
    
    
    
    var arrKeys = [];
    arrKeys[0] = "contratos_etapas_pk_2";
    arrKeys[1] = "contratos_etapas_pk";
    arrKeys[2] = "dt_etapa";
    arrKeys[3] = "usuario_cadastro";
    arrKeys[4] = "dt_cadastro";
    arrKeys[5] = "ds_obs";
    var arrDados = [];
    for(i = 0; i < (cboEtapasContrato.length); i++){ 

        try{
            
            if(cboEtapasContrato.get(i).value == ""){
                cboEtapasContrato.get(i).focus();
                return "";
            }
            
            arrDados[i] = [
                contratos_etapas_pk_2.get(i).value,
                cboEtapasContrato.get(i).value, 
                dt_etapa.get(i).value, 
                usuario_cadastro.get(i).value, 
                dt_cadastro.get(i).value, 
                ds_obs.get(i).value
            ];
        }
        catch(err){
            alert(err.message);
        }
    }    
    
    return arrayToJson(arrKeys, arrDados);    
}

function fcCarregarEtapasProcessoContratos(){

    var objParametros = {
        "pk": $("#processos_contratos_pk").val()
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

$(document).ready(function()
    {
        $(document).on('click', '#btn_modal', fcAbrirFormNovoContrato);
        $(document).on('click', '#cmdIncluirContratosItens', function () {
            fcIncluirContratoItens("");
        } );
        $(document).on('click', '#cmdIncluirContratosEtapas', function () {
            fcIncluirContratoEtapas("");
        } );
        fcValidarFormContratos();
      
        

        $('#dt_inicio_contrato').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker("setDate", new Date() );  

        $("#dt_inicio_contrato").keypress(function(){
           mascara(this,mdata);
        });
        

        $("#dt_inicio_contrato").keypress(function(){
           mascara(this,mdata);
        });

        $('#dt_fim_contrato').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker("setDate", new Date() );  
        $("#dt_fim_contrato").keypress(function(){
           mascara(this,mdata);
        });
        
        fcCarregarOperadorContrato();
       
        carregarListaComboProduto();
        carregarListaComboEtapa();
        
        $("#operador_contrato_pk").change(function(){
            tblContratoItens.clear().destroy();
            carregarListaComboProduto();
            tblContratoEtapas.clear().destroy();
            carregarListaComboEtapa();
        });
        
        

        fcCarregarGridContrato();

        $('#ic_aditivo').click(function() {

           $('#ic_contrato').prop('checked', false);
           $('#ic_aditivo').prop('checked', true);
           $('#exib_contrato_pai').show();
        });
        $('#ic_contrato').click(function() {

           $('#ic_contrato').prop('checked', true);
           $('#ic_aditivo').prop('checked', false);
           $('#contrato_pai_pk').val("null");
           $('#agenda_responsavel_visible').show();
           $('#exib_contrato_pai').hide();
       });

        $("#exib_contrato_pai").hide();
        
        
        
        

     
    }
);