var tblAgendaVisita;
//--------------------Agenda Visita----------------------------
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


function fcLimparFormAgendaVisita(){
    $("#agenda_visita_pk").val("");
    $("#tipos_agendas_pk").val("");
    $("#dt_agenda_visita").val("");
    $("#hr_agenda_visita").val("");
    $("#ds_cep").val("");
    $("#ds_endereco").val("");
    $("#ds_numero").val("");
    $("#ds_complemento").val("");
    $("#ds_bairro").val("");
    $("#ds_cidade").val("");
    $("#ds_uf").val("");
    $("#classificacao_agenda_pk").val("");
    $("#ds_obs_visita_agenda").val("");
    $("#motivo_reagendamento_pk").val("");
    $("#classificacao_agenda_pk").val("");
    $("#motivo_cancelamento_pk").val("");
    $("#ds_obs_cancelamento").val("");
    $("#ic_status").val("");
    $("#agenda_reagendamento_pk").val("");
    $("#ds_contato").val("");
    $("#ds_tel").val("");
    $("#ds_cel").val("");
    $("#cargos_pk").val("");
    $("#ds_cargo").val("");
    $("#contatos_pk").val("");
    $("#tipo_evento_agenda_pk_0").prop('checked', false);
    $("#tipo_evento_agenda_pk_1").prop('checked', false);
    $("#tipo_evento_agenda_pk_2").prop('checked', false);
    $("#aviso_pk").val("");
    $("#ds_titulo_agenda").val("");
    $("#agenda_atendente_pk").val("");
    
}
//SALVA O CONTRATO
function fcSalvarAgendaVisita(){
    var classificacao_agenda_pk = "";
    var v_tipo_evento = "";
    var ic_status = "";
    
    classificacao_agenda_pk = $("#classificacao_agenda_pk").val();
    if(classificacao_agenda_pk!="" && classificacao_agenda_pk!=null){
        ic_status = classificacao_agenda_pk;
    }
    else if($('#ic_status').val()!="" && $('#ic_status').val()!=null){
        ic_status = $('#ic_status').val();
    } 
    else{
        if($("#agenda_visita_pk").val()!=""){
            if($("#motivo_cancelamento_pk").val()!="" && $("#motivo_cancelamento_pk").val()!=null){
               ic_status = 4 ;
            }
        }
    }
    
    if($("#contatos_pk").val()!=""){
        fcCarregarDescricaoContato($("#contatos_pk").val());
    }
    
   
    v_tipo_evento = 1;
    
    
    var strJSONDadosTabela = fcFormatarDadosResponsavel();

    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    if($("#agenda_reagendamento_pk").val()!=""){
        var objParametros = {
           
            "pk": $("#agenda_visita_pk").val(),
            "tipos_agendas_pk": $("#tipos_agendas_pk").val(),
            "dt_agenda_visita": $("#dt_agenda_visita").val(),
            "hr_agenda_visita": $("#hr_agenda_visita").val(),
            "dt_reagenda_visita": $("#dt_agenda_visita").val(),
            "hr_reagenda_visita": $("#hr_agenda_visita").val(),
            "ds_cep": $("#ds_cep").val(),
            "ds_endereco":$('#ds_endereco').val(),
            "ds_numero":$('#ds_numero').val(),
            "ds_complemento":$('#ds_complemento').val(),
            "ds_bairro":$('#ds_bairro').val(),
            "ds_cidade":$('#ds_cidade').val(),
            "ds_uf":$('#ds_uf').val(),
            "classificacao_agenda_pk":classificacao_agenda_pk,
            "ds_obs_classificacao":$('#ds_obs_classificacao').val(),
            "motivo_reagendamento_pk":$('#motivo_reagendamento_pk').val(),
            "ds_obs_reagendamento":$('#ds_obs_reagendamento').val(),
            "motivo_cancelamento_pk":$('#motivo_cancelamento_pk').val(),
            "ds_obs_cancelamento":$('#ds_obs_cancelamento').val(),
            "ds_obs":$('#ds_obs_visita_agenda').val(),
            "ic_status":ic_status,
            "processos_etapas_pk":$('#processos_etapas_pk_1').val(),
            "agenda_reagendamento_pk":$('#agenda_reagendamento_pk').val(),
            "ds_contato":$('#ds_contato').val(),
            "ds_cel":$('#ds_cel').val(),
            "ds_tel":$('#ds_tel').val(),
            "cargos_pk":$('#cargos_pk').val(),
            "polos_pk":$("#polos_pk").val(),
            "leads_pk":$("#leads_pk").val(),
            "ds_processo_etapas":$('#etapas_1').text(),
            "tipo_evento_pk":v_tipo_evento,
            //"aviso_pk":$("#aviso_pk").val(),
            "ds_titulo_agenda":$("#ds_titulo_agenda").val(),
            "atendente_pk":$("#agenda_atendente_pk").val(),
            "responsavel_pk": strJSONDadosTabela
        };
    }
    else{
        
        var objParametros = {
            "pk": $("#agenda_visita_pk").val(),
            "tipos_agendas_pk": $("#tipos_agendas_pk").val(),
            "dt_agenda_visita": $("#dt_agenda_visita").val(),
            "hr_agenda_visita": $("#hr_agenda_visita").val(),
            "ds_cep": $("#ds_cep").val(),
            "ds_endereco":$('#ds_endereco').val(),
            "ds_numero":$('#ds_numero').val(),
            "ds_complemento":$('#ds_complemento').val(),
            "ds_bairro":$('#ds_bairro').val(),
            "ds_cidade":$('#ds_cidade').val(),
            "ds_uf":$('#ds_uf').val(),
            "classificacao_agenda_pk":classificacao_agenda_pk,
            "ds_obs_classificacao":$('#ds_obs_classificacao').val(),
            "motivo_reagendamento_pk":$('#motivo_reagendamento_pk').val(),
            "ds_obs_reagendamento":$('#ds_obs_reagendamento').val(),
            "motivo_cancelamento_pk":$('#motivo_cancelamento_pk').val(),
            "ds_obs_cancelamento":$('#ds_obs_cancelamento').val(),
            "ds_obs":$('#ds_obs').val(),
            "ic_status":ic_status,
            "processos_etapas_pk":$('#processos_etapas_pk_1').val(),
            "ds_contato":$('#ds_contato').val(),
            "ds_cel":$('#ds_cel').val(),
            "ds_tel":$('#ds_tel').val(),
            "cargos_pk":$('#cargos_pk').val(),
            "polos_pk":$("#polos_pk").val(),
            "leads_pk":$("#leads_pk").val(),
            "ds_processo_etapas":$('#etapas_1').text(),
            "tipo_evento_pk":v_tipo_evento,
            //"aviso_pk":$("#aviso_pk").val(),
            "ds_titulo_agenda":$("#ds_titulo_agenda").val(),
            "atendente_pk":$("#agenda_atendente_pk").val(),
            "responsavel_pk": strJSONDadosTabela
        };
    }
     
    var arrEnviar = carregarController("agenda_visita", "salvar", objParametros); 
    if (arrEnviar.result == 'success'){
        $("#janela_agenda_visita").modal("hide");
        fcCarregar();
    }    
    else{
        alert(arrEnviar.result);
    }
    return true;
    
}

function fcValidarFormAgendaVisita(){
    
     $("#form_agenda_visita").validate({
        rules :{
            dt_agenda_visita:{
                required:true,
                minlength:10
            },
            hr_agenda_visita:{
                required:true,
                minlength:5
            },
            tipos_agendas_pk:{
                required:true
            },
            ds_endereco:{
                required:true
            },
            ds_numero:{
                required:true
            },
            ds_cep:{
                required:true,
                minlength:8
            },
            ds_bairro:{
                required:true
            },
            ds_cidade:{
                required:true
            }

        },
        messages:{
            dt_agenda_visita:{
                required:"Por favor, informe a Data",
                minlength:" Data Inválida"
            },
            hr_agenda_visita:{
                required:"Por favor, informe Hora",
                minlength:" Hora Inválida"
            },
            tipos_agendas_pk:{
                required:"Por favor, informe Tipo agendamento"
            },
            ds_endereco:{
                required:"Por favor, informe Endereço",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ds_numero:{
                required:"Por favor, informe Número",
                minlength:" deve ter pelo menos 3 caracteres"
            },
            ds_cep:{
                required:"Por favor, informe Cep",
                minlength:" Cep inválido"
            },
            ds_bairro:{
                required:"Por favor, informe Bairro"
            },
            ds_cidade:{
                required:"Por favor, informe Cidade"
            }

        },
        submitHandler: function(form){
            fcSalvarAgendaVisita(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}
function fcCarregarContato(){
    
    var objParametros = {
        "leads_pk": leads_pk
    };      
    
    var arrCarregar = carregarController("contato", "listarPorLeadPk", objParametros); 
    carregarComboAjax($("#contatos_pk"), arrCarregar, " ", "pk", "ds_contato"); 
}
function fcCarregarDescricaoContato(pk){
    var objParametros = {
        "pk": pk
    };      
    
    var arrCarregar = carregarController("contato", "listarPk", objParametros);
    
    $("#ds_contato").val(arrCarregar.data[0]['ds_contato']);
    $("#ds_cel").val(arrCarregar.data[0]['ds_cel']);
    $("#ds_tel").val(arrCarregar.data[0]['ds_tel']);
    $("#cargos_pk").val(arrCarregar.data[0]['cargos_pk']);
        
}

function fcFormatarDadosResponsavel(){

    var cboResponsavelPk = $("select[id='responsavel_pk']");
    var arrKeys = [];
    arrKeys[0] = "responsavel_pk";
    var arrDados = [];
    for(i = 0; i < (cboResponsavelPk.length); i++){ 
        try{
            
            if(cboResponsavelPk.get(i).value == ""){
                cboResponsavelPk.get(i).focus();
                return "";
            }
            
            arrDados[i] = [cboResponsavelPk.get(i).value];
        }
        catch(err){
            alert("erro");
            alert(err.message);
        }
    }    
    return arrayToJson(arrKeys, arrDados);
    
}



//--------------------------------RESPONSAVEL----------------------
function carregarListaComboResponsavel(){

    var url = '../controller/usuario.controller.php?job=listarTodos&token='+token;
    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            strComboResponsavel = "<select class='form-control form-control-sm' id='responsavel_pk' name='responsavel_pk'><option></option>";
            for(i = 0; i < output.data.length; i++){
                strComboResponsavel = strComboResponsavel + "<option value='"+output.data[i]['pk']+"'>"+output.data[i]['ds_usuario']+"</option>";
            }
            strComboResponsavel+= "</select>";
            
            //Carrega os dados no combo.
            fcFormatarGridResponsavel();
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}

//FORMATA O GRID DE RESPONSAVEL
function fcFormatarGridResponsavel(){
    
    tblResponsavel = $("#tblResponsavel").DataTable({
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
                "data": "t0"
            },           
            
            {   
                "targets": 1,
                "data": "t1",
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

//RETORNA OS DADOS CADASTRAIS DO RESPONSAVEL
function fcAtualizarDadosGridResponsavel(){
    var objParametros = {
        "agenda_visita_pk":$("#agenda_visita_pk").val()
    };              

    var arrCarregar = carregarController("agenda_visita", "listarResponsavelAgendaVisita", objParametros);  
   
    if (arrCarregar.result == 'success'){
        for(i = 0; i < arrCarregar.data.length; i++){
            if($("#agenda_visita_pk").val()!=""){
                //Adiciona a linha.
                fcIncluirResponsavel(arrCarregar.data[i]['t_pk']);
            
                //Pega as variaveis 
                var cboResponsavelPk = $("select[id='responsavel_pk']");


                cboResponsavelPk.get(i).value = arrCarregar.data[i]['t_usuarios_pk'];
            }

        }
    }
    else{
        alert('Falhou a requisição de exclusão.');
    }
}

//INCLUI RESPONSAVEL
function fcIncluirResponsavel(v_pk){

    tblResponsavel.row.add(
    {   
        "t0":strComboResponsavel,
        "t1":"<a class='function_delete' ><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
    }            
    ).draw( false );
    
    tblResponsavel.on('click', '.function_delete', function () {
        var data;
        if(tblResponsavel.row( $(this).parents('li') ).data()){
            data = tblResponsavel.row( $(this).parents('li') ).data();
        }
        else if(tblResponsavel.row( $(this).parents('tr') ).data()){
            data = tblResponsavel.row( $(this).parents('tr') ).data();
        }
        if(data['t0'] != ""){
            fcExcluirLinhaResponsavel(v_pk);
        }
        tblResponsavel.row($(this).parents('tr')).remove().draw();
    } );
    
    
   
    return false;
}

function fcExcluirLinhaResponsavel(v_pk){
    if(v_pk!=""){
         var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("agenda_visita", "excluir_responsavel", objParametros);   
        
        if (arrExcluir.result == 'success'){
            //Exibe a mensagem
            alert(arrExcluir.message);
        }
        else{
           //Exibe a mensagem
            alert(arrExcluir.message);
        } 
    }
    
    return false;
}





//--------------------------------CALENDARIO----------------------------
function fcEditarAgendaVisitaCalendario(pk,responsavel_pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,usuario_cadastro_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs){
    var arrPermissao = permissao("acessar_todos_lead_agenda", "cons");
    if(arrPermissao.result =='success'){
       fcAbrirAgendaVisitaCalendario(pk,responsavel_pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else if(responsavel_pk==0){
         alert("Você não é o responsavel da Agenda!!!");
    }
    else if($("#usuario_logado_pk").val().match(responsavel_pk)){
        fcAbrirAgendaVisitaCalendario(pk,responsavel_pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else if($("#usuario_logado_pk").val() == usuario_cadastro_pk){
        fcAbrirAgendaVisitaCalendario(pk,responsavel_pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else{
        alert("Você não é o responsavel da Agenda!!!");
    }
}
function fcAbrirAgendaVisitaCalendario(pk,responsavel_pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs){
    
    fcCarregarLeadAgenda(leads_pk);
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").hide();
    $("#exib_obs_classificacao").hide();
    $("#exib_motivo_reagendamento").hide();
    $("#exib_obs").show();
    
    fcLimparFormAgendaVisita();
    
    if(motivo_reagendamento_pk!="null"){
        $("#exib_motivo_reagendamento").show();
        $("#motivo_reagendamento_pk").val(motivo_reagendamento_pk);
        $("#ds_obs_reagendamento").val(ds_obs_reagendamento);
        $("#motivo_reagendamento_pk").prop('disabled', true);
        $("#ds_obs_reagendamento").prop('disabled', true);
    }
    if(classificacao_agenda_pk!= "null" ){
        $("#exib_classificacao").show();
        $("#classificacao_agenda_pk").val(classificacao_agenda_pk);
        $("#ds_obs_classificacao").val(ds_obs_classificacao);
        $("#classificacao_agenda_pk").prop('disabled', true);
        $("#ds_obs_classificacao").prop('disabled', true);
    
    }
    if(ic_status!= 3 && classificacao_agenda_pk=="null" ){
        $("#exib_motivo_cancelamento").show();
        $("#motivo_cancelamento_pk").val(motivo_cancelamento_pk);
        $("#ds_obs_cancelamento").val(ds_obs_cancelamento);
    }
    
    fcCarregarAtendenteAgenda();
    $("#agenda_atendente_pk").val(atendente_pk);
    
    tblResponsavel.clear().destroy();
   
    fcFormatarGridResponsavel();
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(pk);
    $("#agenda_reagendamento_pk").val(" ");
    $("#leads_pk").val(leads_pk);
    $("#polos_pk").val(polos_pk);
    $('#processos_etapas_pk_1').val(processos_etapas_pk);
    
    fcAtualizarDadosGridResponsavel();
    $("#tipos_agendas_pk").val(tipos_agendas_pk);
    if(dt_reagendamento_visita==null){
        $("#dt_agenda_visita").val(dt_agenda_visita);
        $("#hr_agenda_visita").val(hr_agenda_visita);
    }else if(dt_reagendamento_visita=="null"){
        $("#dt_agenda_visita").val(dt_agenda_visita);
        $("#hr_agenda_visita").val(hr_agenda_visita);
    }
    else{
        $("#dt_agenda_visita").val(dt_reagendamento_visita);
        $("#hr_agenda_visita").val(hr_reagendamento_visita);
    } 
    
    
    $("#ds_cep").val(ds_cep);
    $("#classificacao_agenda_pk").val(classificacao_agenda_pk);
    $("#ds_endereco").val(ds_endereco);
    $("#ds_numero").val(ds_numero);
    if(ds_complemento!='null'){
       $("#ds_complemento").val(ds_complemento);
    }
    
    $("#ds_bairro").val(ds_bairro);
    $("#ds_cidade").val(ds_cidade);
    $("#ds_uf").val(ds_uf);
    $("#motivo_cancelamento_pk").val(motivo_cancelamento_pk);
    $("#ds_titulo_agenda").val(ds_titulo_agenda);
    $("#aviso_pk").val(aviso_pk);
    
    if(ic_status!=null){
        $("#ic_status").val(ic_status);
    }
    else{
        $("#ic_status").val("");
    }

    $("#ds_obs_visita_agenda").val(ds_obs);
    
    
    if(tipo_evento_pk==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(tipo_evento_pk==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', true);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(tipo_evento_pk==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', true);
    }
    
    if(ds_contato!="null"){
        $("#ds_contato").val(ds_contato);
        if(ds_cel!="null"){
            $("#ds_cel").val(ds_cel);
        }
        else{
            $("#ds_cel").val("");
        }
        if(ds_tel!="null"){
            $("#ds_tel").val(ds_tel);
        }
        else{
            $("#ds_tel").val("");
        }
        if(ds_cargo!="null"){
            $("#ds_cargo").val(ds_cargo);
        }
        else{
            $("#ds_cargo").val("");
        }
        if(ds_email!="null"){
            $("#ds_email_contato").val(ds_email);
        }
        else{
            $("#ds_email_contato").val("");
        }
        
    }
    $("#janela_agenda_visita").modal();

    $("#form_agenda_visita").data('validator').resetForm();
}

function fcReagendamentoAgendaVisitaCalendario(pk,responsavel_pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,usuario_cadastro_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs){
      
    
    var arrPermissao = permissao("acessar_todos_lead_agenda", "cons");
    
    if(arrPermissao.result =='success'){
        fcAbrirReagendamentoAgendaVisitaCalendario(pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else if(responsavel_pk==0){
         alert("Você não é o responsavel da Agenda!!!");
    }
    else if($("#usuario_logado_pk").val().match(responsavel_pk)){
        fcAbrirReagendamentoAgendaVisitaCalendario(pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else if($("#usuario_logado_pk").val() == usuario_cadastro_pk){
        fcAbrirReagendamentoAgendaVisitaCalendario(pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else{
        alert("Você não é o responsavel da Agenda!!!");
    }
}
function fcAbrirReagendamentoAgendaVisitaCalendario(pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs){
      
    fcCarregarLeadAgenda(leads_pk);
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").hide();
    $("#exib_obs").show();
    $("#exib_obs_classificacao").hide();
    $('#exibir_lembrete').hide();
    $('#exibir_agenda').show();
    $("#exib_motivo_reagendamento").show();

    
    
    fcLimparFormAgendaVisita();
    
    if(classificacao_agenda_pk!= "null" ){
        $("#exib_classificacao").show();
        $("#classificacao_agenda_pk").val(classificacao_agenda_pk);
        $("#ds_obs_classificacao").val(ds_obs_classificacao);
    }
    if(motivo_cancelamento_pk!="null"){
        $("#exib_motivo_cancelamento").hide();
        $("#motivo_cancelamento_pk").val(motivo_cancelamento_pk);
        $("#ds_obs_cancelamento").val(ds_obs_cancelamento);
    }
    
    /*if(motivo_cancelamento_pk!="null"){
        $("#exib_motivo_cancelamento").hide();
        $("#exib_classificacao").hide();
        $("#exib_obs").show();
        $("#exib_obs_classificacao").hide();
        $('#exibir_lembrete').hide();
        $("#exib_motivo_reagendamento").hide();
    }*/
    
    fcCarregarAtendenteAgenda();
    $("#agenda_atendente_pk").val(atendente_pk);
    
    tblResponsavel.clear().destroy();
   
    fcFormatarGridResponsavel();
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(pk);
    $("#agenda_reagendamento_pk").val(pk);
    $("#leads_pk").val(leads_pk);
    $("#polos_pk").val(polos_pk);
    $('#processos_etapas_pk_1').val(processos_etapas_pk);
    
    fcAtualizarDadosGridResponsavel();
    $("#agenda_visita_pk").val("");
    $("#tipos_agendas_pk").val(tipos_agendas_pk);
    
    if(dt_reagendamento!=null){
        $("#dt_agenda_visita").val(dt_reagendamento_visita);
        $("#hr_agenda_visita").val(hr_reagendamento_visita);
    }
    else{
        $("#dt_agenda_visita").val(dt_agenda_visita);
        $("#hr_agenda_visita").val(hr_agenda_visita);
    } 
    
    
    $("#ds_cep").val(ds_cep);
    $("#classificacao_agenda_pk").val("");
    $("#ds_endereco").val(ds_endereco);
    $("#ds_numero").val(ds_numero);
    if(ds_complemento!='null'){
       $("#ds_complemento").val(ds_complemento);
    }
    
    $("#ds_bairro").val(ds_bairro);
    $("#ds_cidade").val(ds_cidade);
    $("#ds_uf").val(ds_uf);
    $("#motivo_cancelamento_pk").val(motivo_cancelamento_pk);
    $("#motivo_reagendamento_pk").val(motivo_reagendamento_pk);
    $("#motivo_reagendamento_pk").prop('disabled', false);
    $("#ds_obs_reagendamento").prop('disabled', false);
    $("#ds_obs_reagendamento").val(ds_obs_reagendamento);
    $("#ds_titulo_agenda").val(ds_titulo_agenda);
    $("#aviso_pk").val(aviso_pk);
    
    $("#ic_status").val(3);

    $("#ds_obs_visita_agenda").val(ds_obs);

    
    
    if(tipo_evento_pk==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(tipo_evento_pk==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', true);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(tipo_evento_pk==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', true);
    }
    
    if(ds_contato!="null"){
        $("#ds_contato").val(ds_contato);
        if(ds_cel!="null"){
            $("#ds_cel").val(ds_cel);
        }
        else{
            $("#ds_cel").val("");
        }
        if(ds_tel!="null"){
            $("#ds_tel").val(ds_tel);
        }
        else{
            $("#ds_tel").val("");
        }
        if(ds_cargo!="null"){
            $("#ds_cargo").val(ds_cargo);
        }
        else{
            $("#ds_cargo").val("");
        }
        if(ds_email!="null"){
            $("#ds_email_contato").val(ds_email);
        }
        else{
            $("#ds_email_contato").val("");
        }
        
    }
    $("#janela_agenda_visita").modal();

    $("#form_agenda_visita").data('validator').resetForm();
}

function fcClassificacaoAgendaVisitaCalendario(pk,responsavel_pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,usuario_cadastro_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs){
    var arrPermissao = permissao("acessar_todos_lead_agenda", "cons");
    
    if(arrPermissao.result =='success'){
        fcAbrirClassificacaoAgendaVisitaCalendario(pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else if(responsavel_pk==0){
         alert("Você não é o responsavel da Agenda!!!");
    }
    else if($("#usuario_logado_pk").val().match(responsavel_pk)){
        fcAbrirClassificacaoAgendaVisitaCalendario(pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else if($("#usuario_logado_pk").val() == usuario_cadastro_pk){
        fcAbrirClassificacaoAgendaVisitaCalendario(pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs);
    }
    else{
        alert("Você não é o responsavel da Agenda!!!");
    }
}
function fcAbrirClassificacaoAgendaVisitaCalendario(pk,ds_contato,ds_cel,ds_tel,ds_cargo,ds_email,atendente_pk,tipos_agendas_pk,ic_status,processos_etapas_pk,leads_pk,polos_pk,tipo_evento_pk,ds_titulo_agenda,aviso_pk,dt_reagendamento,dt_reagendamento_visita,hr_reagendamento_visita,dt_agenda_visita,hr_agenda_visita,ds_cep,classificacao_agenda_pk,ds_endereco,ds_numero,ds_complemento,ds_bairro,ds_cidade,ds_uf,motivo_cancelamento_pk,motivo_reagendamento_pk,ds_obs_cancelamento,ds_obs_reagendamento,ds_obs_classificacao,ds_obs){
      fcCarregarLeadAgenda(leads_pk);
    
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").show();
    $("#exib_motivo_reagendamento").hide();
    $("#exib_obs").hide();
    $("#exib_obs_classificacao").show();
    $('#exibir_lembrete').hide();
    $('#exibir_agenda').show();
    
    fcLimparFormAgendaVisita();
    
    
    
    if(motivo_reagendamento_pk!="null"){
        $("#exib_motivo_reagendamento").hide();
        $("#motivo_reagendamento_pk").val(motivo_reagendamento_pk);
        $("#ds_obs_reagendamento").val(ds_obs_reagendamento);
    }
    if(classificacao_agenda_pk== "null"){
        $("#exib_motivo_cancelamento").hide();
        $("#motivo_cancelamento_pk").val(motivo_cancelamento_pk);
        $("#ds_obs_cancelamento").val(ds_obs_cancelamento);
    }
    
    /*if(motivo_cancelamento_pk!="null"){
        $("#exib_motivo_cancelamento").hide();
        $("#exib_classificacao").hide();
        $("#exib_obs").show();
        $("#exib_obs_classificacao").hide();
        $('#exibir_lembrete').hide();
        $("#exib_motivo_reagendamento").hide();
    }*/
    
    fcCarregarAtendenteAgenda();
    $("#agenda_atendente_pk").val(atendente_pk);
    tblResponsavel.clear().destroy();
   
    fcFormatarGridResponsavel();
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(pk);
    $("#agenda_reagendamento_pk").val(" ");
    $("#leads_pk").val(leads_pk);
    $("#polos_pk").val(polos_pk);
    $('#processos_etapas_pk_1').val(processos_etapas_pk);
    
    fcAtualizarDadosGridResponsavel();
    $("#tipos_agendas_pk").val(tipos_agendas_pk);
    
    if(dt_reagendamento!=null){
        $("#dt_agenda_visita").val(dt_reagendamento_visita);
        $("#hr_agenda_visita").val(hr_reagendamento_visita);
    }
    else{
        $("#dt_agenda_visita").val(dt_agenda_visita);
        $("#hr_agenda_visita").val(hr_agenda_visita);
    } 
    
    
    $("#ds_cep").val(ds_cep);
    $("#classificacao_agenda_pk").val(classificacao_agenda_pk);
    $("#ds_endereco").val(ds_endereco);
    $("#ds_numero").val(ds_numero);
    if(ds_complemento!='null'){
       $("#ds_complemento").val(ds_complemento);
    }
    
    $("#ds_bairro").val(ds_bairro);
    $("#ds_cidade").val(ds_cidade);
    $("#ds_uf").val(ds_uf);
    $("#motivo_cancelamento_pk").val(motivo_cancelamento_pk);
    $("#ds_titulo_agenda").val(ds_titulo_agenda);
    $("#aviso_pk").val(aviso_pk);
    
    if(ic_status!=null){
        $("#ic_status").val(ic_status);
    }    
    else{
        $("#ic_status").val("");
    }

    $("#ds_obs_visita_agenda").val(ds_obs);
    
    if(tipo_evento_pk==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(tipo_evento_pk==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', true);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(tipo_evento_pk==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', true);
    }
    
    if(ds_contato!="null"){
        $("#ds_contato").val(ds_contato);
        if(ds_cel!="null"){
            $("#ds_cel").val(ds_cel);
        }
        else{
            $("#ds_cel").val("");
        }
        if(ds_tel!="null"){
            $("#ds_tel").val(ds_tel);
        }
        else{
            $("#ds_tel").val("");
        }
        if(ds_cargo!="null"){
            $("#ds_cargo").val(ds_cargo);
        }
        else{
            $("#ds_cargo").val("");
        }
        if(ds_email!="null"){
            $("#ds_email_contato").val(ds_email);
        }
        else{
            $("#ds_email_contato").val("");
        }
      
    }
    $("#janela_agenda_visita").modal();

    $("#form_agenda_visita").data('validator').resetForm();
}
function fcCarregarLeadAgenda(leads_pk){

    if(leads_pk > 0){

        var objParametros = {
            "pk": leads_pk
        };        
        
        var arrCarregar = carregarController("lead", "listarPkSubMenu", objParametros);
        if (arrCarregar.result == 'success'){
        
            $(".leads_pk_cad_agenda").text(arrCarregar.data[0]['pk']);
            $(".ds_lead_agenda").text(arrCarregar.data[0]['ds_lead']);
        

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}
function fcCarregarAtendenteAgenda(){
    var objParametros = {
        "grupos_pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarAtentedente", objParametros); 
    
    if(arrCarregar.data.lenght==1){
         carregarComboAjax($("#agenda_atendente_pk"), arrCarregar, "", "pk", "ds_usuario"); 
    }
    else{
        carregarComboAjax($("#agenda_atendente_pk"), arrCarregar, " ", "pk", "ds_usuario"); 
    }
   

}
$(document).ready(function()
    {
        $(document).on('click', '#cmdIncluirResponsavel', function () {
            fcIncluirResponsavel("");
        } );
        //Agenda Visita        
        carregarListaComboResponsavel();
        
        $("#ds_cep").keypress(function(){
           mascara(this,cep);
        });
        $("#ds_cep").change(function(){
            fcCarregarCep();
        });
        
        $('#dt_agenda_visita').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        });
        $("#dt_agenda_visita").keypress(function(){
            mascara(this,mdata);
        });
        $("#hr_agenda_visita").keypress(function(){
           mascara(this,horamask);
        });
        
        
        fcValidarFormAgendaVisita();
        
        $('#exib_sem_pk').hide();
        $('#exib_com_pk').show();
        
        $('#tipo_evento_agenda_pk_0').click(function() {       
            $('#exibir_lembrete').hide();
            $('#exibir_agenda').show();
            
        });
        $('#tipo_evento_agenda_pk_1').click(function() {       
            $('#exibir_lembrete').show();
            $('#exibir_agenda').hide();
            
        });
        $('#tipo_evento_agenda_pk_2').click(function() {       
            $('#exibir_lembrete').show();
            $('#exibir_agenda').hide();
            
        });
        
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').hide();
    }
);




 
       
        
        
        
        
        
        
        
        
        
        
        
        