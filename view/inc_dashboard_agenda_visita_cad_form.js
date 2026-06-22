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

function fcAbrirFormNovoAgendamentoVisita(){
    $("#exib_motivo_reagendamento").hide();
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").hide();
    $('#exib_sem_pk').show();
    $('#exib_com_pk').hide();
    $("#exib_obs").show();
    $('#exibir_lembrete').hide();
    $('#exibir_agenda').hide();
    
    fcLimparFormAgendaVisita();

    tblResponsavel.clear().destroy();

    fcFormatarGridResponsavel();

    fcAtualizarDadosGridResponsavel();

    
    $("#janela_agenda_visita").modal();
    var validator = $( "#form_agenda_visita" ).validate();
    validator.resetForm();
    
    
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
    $("#ds_obs").val("");
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
    $("#leads_pk").val("");
    $("#polos_pk").val("");
    $("#processos_pk").val("");
    
}




function fcCarregarGridAgendaVisita(){
    
    var objParametros = {
        "leads_pk": "",
        "polos_pk":$("#polos_pk_dashboard").val()
    };     
    
    var v_url = montarUrlController("agenda_visita", "listarAgendaVisitaDashboard", objParametros);
    //Trata a tabela
    tblAgendaVisita = $('#tblAgendaVisita').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_painel'><span><img width=19 height=16 src='../img/reagendamento.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                                   <a class='function_classificacao'><span><img width=16 height=16 src='../img/classificacao.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                                   <a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                                   <a class='function_delete'><span><img width=16 height=16 src='../img/painel.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;"
            },
           {"targets": -2, "data": "t_ds_status"},
           {"targets": -3, "data": "t_ds_endereco"},
           {"targets": -4, "data": "t_dt_agenda"},
           {"targets": -5, "data": "t_classificacao_agenda_pk" ,"visible":false},
           {"targets": -6, "data": "t_ds_classificacao_agenda"},
           {"targets": -7, "data": "t_tipo_evento_pk" , "visible":false},
           {"targets": -8, "data": "t_ds_tipo_evento"},
           {"targets": -9, "data": "t_tipos_agendas_pk" , "visible":false},
           {"targets": -10, "data": "t_ds_tipo_agenda"},
           {"targets": -11, "data": "t_ds_lead"},
           {"targets": -12, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    $('#tblAgendaVisita tbody').on('click', '.function_classificacao', function () {
        var data;
        if(tblAgendaVisita.row( $(this).parents('li') ).data()){
            data = tblAgendaVisita.row( $(this).parents('li') ).data();
        }
        else if(tblAgendaVisita.row( $(this).parents('tr') ).data()){
            data = tblAgendaVisita.row( $(this).parents('tr') ).data();
        }
        fcAbrirClassificacao(data);
    }); 
    
    $('#tblAgendaVisita tbody').on('click', '.function_painel', function () {
        var data;
        if(tblAgendaVisita.row( $(this).parents('li') ).data()){
            data = tblAgendaVisita.row( $(this).parents('li') ).data();
        }
        else if(tblAgendaVisita.row( $(this).parents('tr') ).data()){
            data = tblAgendaVisita.row( $(this).parents('tr') ).data();
        }
        fcAbrirReagendamento(data);
    });  
    
    //Atribui os eventos na coluna ação.
    $('#tblAgendaVisita tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblAgendaVisita.row( $(this).parents('li')).data()){
            data = tblAgendaVisita.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblAgendaVisita.row( $(this).parents('tr')).data()){
            data = tblAgendaVisita.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarAgendaVisita(data);
        
    } ); 
    $('#tblAgendaVisita tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblAgendaVisita.row( $(this).parents('li') ).data()){
            data = tblAgendaVisita.row( $(this).parents('li') ).data();
        }
        else if(tblRetorno.row( $(this).parents('tr') ).data()){
            data = tblAgendaVisita.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_leads_pk'] != ""){
            fcAbrirPainelLead(data['t_leads_pk']);
        }
    } ); 
    
    
    return false;
}

function fcAbrirPainelLead(leads_pk){
      sendPost('lead_main_form.php', {token: token, pk: leads_pk});
}
function fcAbrirClassificacao(objRegistro){
    
    
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").show();
    $("#exib_motivo_reagendamento").hide();
    $("#exib_obs").show();
    $('#exibir_lembrete').hide();
    $('#exibir_agenda').show();
    
    
    
    fcLimparFormAgendaVisita();
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(objRegistro['t_pk']);
    $("#agenda_reagendamento_pk").val(objRegistro['t_pk']);
    tblResponsavel.clear().destroy();
    fcFormatarGridResponsavel();
    fcAtualizarDadosGridResponsavel();
   
    $("#tipos_agendas_pk").val(objRegistro['t_tipos_agendas_pk']);
    
    if(objRegistro['t_dt_reagenda']!=null){
        $("#dt_agenda_visita").val(objRegistro['t_dt_reagenda_visita']);
        $("#hr_agenda_visita").val(objRegistro['t_hr_reagenda_visita']);
    }
    else{
        $("#dt_agenda_visita").val(objRegistro['t_dt_agenda_visita']);
        $("#hr_agenda_visita").val(objRegistro['t_hr_agenda_visita']);
    } 
    if(objRegistro['t_ds_contato']!=null){
        $('#exib_sem_pk').hide();
        $('#exib_com_pk').show();
        $("#ds_contato").val(objRegistro['t_ds_contato']);
        $("#ds_cel").val(objRegistro['t_ds_cel']);
        $("#ds_tel").val(objRegistro['t_ds_tel']);
        $("#ds_cargo").val(objRegistro['t_ds_cargo']);
    }
    else{
        $('#exib_sem_pk').show();
        $('#exib_com_pk').hide();
    }
    $("#ds_cep").val(objRegistro['t_ds_cep']);
    $("#classificacao_agenda_pk").val(objRegistro['t_classificacao_agenda_pk']);
    $("#ds_endereco").val(objRegistro['t_ds_endereco']);
    $("#ds_numero").val(objRegistro['t_ds_numero']);
    $("#ds_complemento").val(objRegistro['t_ds_complemento']);
    $("#ds_bairro").val(objRegistro['t_ds_bairro']);
    $("#ds_cidade").val(objRegistro['t_ds_cidade']);
    $("#ds_uf").val(objRegistro['t_ds_uf']);
    $("#motivo_cancelamento_pk").val(objRegistro['t_motivo_cancelamento_pk']);
    if(objRegistro['t_motivo_cancelamento_pk']!=null){
        $("#ic_status").val(4);
    }
    else if (objRegistro['t_classificacao_agenda_pk']!=null){
        $("#ic_status").val(objRegistro['t_classificacao_agenda_pk']);
    }
    else{
        $("#ic_status").val("");
    }
    
    
    if(objRegistro['t_ds_obs_reagendamento']!=null){
        $("#ds_obs").val(objRegistro['t_ds_obs_reagendamento']);
    }
    else{
        $("#ds_obs").val(objRegistro['t_ds_obs']);
    }
    if(objRegistro['t_tipo_evento_pk']==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', true);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', true);
    }
    $("#ds_obs_cancelamento").val(objRegistro['t_ds_obs_cancelamento']);
    
    $("#leads_pk").val(objRegistro['t_leads_pk']);
    $("#polos_pk").val(objRegistro['t_polos_pk']);
    $("#processos_pk").val(objRegistro['t_processos_pk']);
    fcCarregarEtapasProcesso();
    fcCarregarContato();
    $("#janela_agenda_visita").modal();

    $("#form_agenda_visita").data('validator').resetForm();
    
}
function fcEditarAgendaVisita(objRegistro){
    
    
    $("#exib_motivo_cancelamento").show();
    $("#exib_classificacao").hide();
    $("#exib_motivo_reagendamento").hide();
    $("#exib_obs").show();
    
    
    
    
    
    fcLimparFormAgendaVisita();
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(objRegistro['t_pk']);
    $("#agenda_reagendamento_pk").val(objRegistro['t_pk']);
    tblResponsavel.clear().destroy();
    fcFormatarGridResponsavel();
    fcAtualizarDadosGridResponsavel();
    
    
    $("#tipos_agendas_pk").val(objRegistro['t_tipos_agendas_pk']);
    
    if(objRegistro['t_dt_reagenda']!=null){
        $("#dt_agenda_visita").val(objRegistro['t_dt_reagenda_visita']);
        $("#hr_agenda_visita").val(objRegistro['t_hr_reagenda_visita']);
    }
    else{
        $("#dt_agenda_visita").val(objRegistro['t_dt_agenda_visita']);
        $("#hr_agenda_visita").val(objRegistro['t_hr_agenda_visita']);
    } 
    if(objRegistro['t_ds_contato']!=null){
        $('#exib_sem_pk').hide();
        $('#exib_com_pk').show();
        $("#ds_contato").val(objRegistro['t_ds_contato']);
        $("#ds_cel").val(objRegistro['t_ds_cel']);
        $("#ds_tel").val(objRegistro['t_ds_tel']);
        $("#ds_cargo").val(objRegistro['t_ds_cargo']);
    }
    else{
        $('#exib_sem_pk').show();
        $('#exib_com_pk').hide();
    }
 
    $("#ds_cep").val(objRegistro['t_ds_cep']);
    $("#classificacao_agenda_pk").val(objRegistro['t_classificacao_agenda_pk']);
    $("#ds_endereco").val(objRegistro['t_ds_endereco']);
    $("#ds_numero").val(objRegistro['t_ds_numero']);
    $("#ds_complemento").val(objRegistro['t_ds_complemento']);
    $("#ds_bairro").val(objRegistro['t_ds_bairro']);
    $("#ds_cidade").val(objRegistro['t_ds_cidade']);
    $("#ds_uf").val(objRegistro['t_ds_uf']);
    $("#motivo_cancelamento_pk").val(objRegistro['t_motivo_cancelamento_pk']);
    if(objRegistro['t_motivo_cancelamento_pk']!=null){
        $("#ic_status").val(4);
    }
    else if (objRegistro['t_classificacao_agenda_pk']!=null){
        $("#ic_status").val(objRegistro['t_classificacao_agenda_pk']);
    }
    else{
        $("#ic_status").val("");
    }
    
    
    if(objRegistro['t_ds_obs_reagendamento']!=null){
        $("#ds_obs").val(objRegistro['t_ds_obs_reagendamento']);
    }
    else{
        $("#ds_obs").val(objRegistro['t_ds_obs']);
    }
    $("#ds_obs_cancelamento").val(objRegistro['t_ds_obs_cancelamento']);
    
    $("#aviso_pk").val(objRegistro['t_aviso_pk']);
    $("#ds_titulo_agenda").val(objRegistro['t_ds_titulo_agenda']);
    if(objRegistro['t_tipo_evento_pk']==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', true);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', true);
    }
    $("#leads_pk").val(objRegistro['t_leads_pk']);
    $("#polos_pk").val(objRegistro['t_polos_pk']);
    $("#processos_pk").val(objRegistro['t_processos_pk']);
    fcCarregarEtapasProcesso();
    fcCarregarContato();
    $("#janela_agenda_visita").modal();

    $("#form_agenda_visita").data('validator').resetForm();
    
}

function fcAbrirReagendamento(objRegistro){
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").hide();
    $("#exib_obs").show();
    $('#exibir_lembrete').hide();
    $('#exibir_agenda').show();
    
    
    fcLimparFormAgendaVisita();
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(objRegistro['t_pk']);
    $("#agenda_reagendamento_pk").val(objRegistro['t_pk']);
    tblResponsavel.clear().destroy();
    fcFormatarGridResponsavel();
    fcAtualizarDadosGridResponsavel();
    
    $("#agenda_visita_pk").val("");
    $("#tipos_agendas_pk").val(objRegistro['t_tipos_agendas_pk']);
    $("#dt_agenda_visita").val(objRegistro['t_dt_reagenda_visita']);
    $("#hr_agenda_visita").val(objRegistro['t_hr_reagenda_visita']);
    $("#ds_cep").val(objRegistro['t_ds_cep']);
    $("#ds_endereco").val(objRegistro['t_ds_endereco']);
    $("#ds_numero").val(objRegistro['t_ds_numero']);
    $("#ds_complemento").val(objRegistro['t_ds_complemento']);
    $("#ds_bairro").val(objRegistro['t_ds_bairro']);
    $("#ds_cidade").val(objRegistro['t_ds_cidade']);
    $("#ds_uf").val(objRegistro['t_ds_uf']);
    $("#ic_status").val(3);
    $("#exib_motivo_reagendamento").show();
    if(objRegistro['t_ds_contato']!=null){
        $('#exib_sem_pk').hide();
        $('#exib_com_pk').show();
        $("#ds_contato").val(objRegistro['t_ds_contato']);
        $("#ds_cel").val(objRegistro['t_ds_cel']);
        $("#ds_tel").val(objRegistro['t_ds_tel']);
        $("#ds_cargo").val(objRegistro['t_ds_cargo']);
    }
    else{
        $('#exib_sem_pk').show();
        $('#exib_com_pk').hide();
    }
    if(objRegistro['t_tipo_evento_pk']==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', true);
        $("#tipo_evento_agenda_pk_2").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
        $("#tipo_evento_agenda_pk_1").prop('checked', false);
        $("#tipo_evento_agenda_pk_2").prop('checked', true);
    }
    
    $("#ds_obs").val(objRegistro['t_ds_obs_reagendamento']);
    $("#leads_pk").val(objRegistro['t_leads_pk']);
    $("#polos_pk").val(objRegistro['t_polos_pk']);
    $("#processos_pk").val(objRegistro['t_processos_pk']);
    fcCarregarEtapasProcesso();
    fcCarregarContato();
    $("#janela_agenda_visita").modal(); 
   
    $("#form_agenda_visita").data('validator').resetForm();
    
}


//SALVA O CONTRATO
function fcSalvarAgendaVisita(){
    var classificacao_agenda_pk = "";
    var v_tipo_evento = "";
    var ic_status = "";
    
    classificacao_agenda_pk = $("#classificacao_agenda_pk").val();
    if(classificacao_agenda_pk!=""){
        ic_status = classificacao_agenda_pk;
    }
    else{
        ic_status = $('#ic_status').val();
    }
    
    if($("#agenda_visita_pk").val()!=""){
        if($("#motivo_cancelamento_pk").val()!=""){
           ic_status = 4 ;
        }
    }
    if($("#contatos_pk").val()!=""){
        fcCarregarDescricaoContato($("#contatos_pk").val());
    }
    

    
    
    
    
    //TIPO EVENTO 
    if($('#tipo_evento_agenda_pk_0').is(":checked") == false && $('#tipo_evento_agenda_pk_1').is(":checked") == false && $('#tipo_evento_agenda_pk_2').is(":checked") == false){
        $("#alert_tipo_evento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_evento").slideUp(500);
        });
        return false;
    }

    
    
    if($('#tipo_evento_agenda_pk_0').is(":checked") == true){
        v_tipo_evento = 1;
    }
    
    else if($('#tipo_evento_agenda_pk_1').is(":checked") == true){
            if($('#aviso_pk').val()==""){
                $("#alert_aviso_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_aviso_pk").slideUp(500);
                });
                $('#aviso_pk').focus();
                return false;
            }
            
            if($('#ds_titulo_agenda').val()==""){
                $("#alert_ds_titulo_agenda").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_ds_titulo_agenda").slideUp(500);
                });
                $('#ds_titulo_agenda').focus();
                return false;
            }
        v_tipo_evento = 2;
    }
    
    else{
        if($('#aviso_pk').val()==""){
            $("#alert_aviso_pk").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_aviso_pk").slideUp(500);
            });
            $('#aviso_pk').focus();
            return false;
        }

        if($('#ds_titulo_agenda').val()==""){
            $("#alert_ds_titulo_agenda").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_ds_titulo_agenda").slideUp(500);
            });
            $('#ds_titulo_agenda').focus();
            return false;
        }
        v_tipo_evento = 3;
    }
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
            "motivo_reagendamento_pk":$('#motivo_reagendamento_pk').val(),
            "motivo_cancelamento_pk":$('#motivo_cancelamento_pk').val(),
            "ds_obs_cancelamento":$('#ds_obs_cancelamento').val(),
            "ds_obs":$('#ds_obs').val(),
            "ic_status":ic_status,
            "processos_etapas_pk":$('#processos_etapas_pk_1').val(),
            "agenda_reagendamento_pk":$('#agenda_reagendamento_pk').val(),
            "ds_contato":$('#ds_contato').val(),
            "ds_cel":$('#ds_cel').val(),
            "ds_tel":$('#ds_tel').val(),
            "cargos_pk":$('#cargos_pk').val(),
            "polos_pk":$("#polos_pk").val(),
            "leads_pk":$("#leads_pk").val(),
            "contatos_pk":$("#contatos_pk").val(),
            "processos_pk":$("#processos_pk").val(),
            "ds_processo_etapas":$('#etapas_1').text(),
            "tipo_evento_pk":v_tipo_evento,
            "aviso_pk":$("#aviso_pk").val(),
            "ds_titulo_agenda":$("#ds_titulo_agenda").val(),
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
            "ds_obs":$('#ds_obs').val(),
            "classificacao_agenda_pk":classificacao_agenda_pk,
            "ds_obs_cancelamento":$('#ds_obs_cancelamento').val(),
            "ic_status":ic_status,
            "motivo_cancelamento_pk":$('#motivo_cancelamento_pk').val(),
            "processos_etapas_pk":$('#processos_etapas_pk_1').val(),
            "ds_contato":$('#ds_contato').val(),
            "ds_cel":$('#ds_cel').val(),
            "ds_tel":$('#ds_tel').val(),
            "cargos_pk":$('#cargos_pk').val(),
            "polos_pk":$("#polos_pk").val(),
            "leads_pk":$("#leads_pk").val(),
            "contatos_pk":$("#contatos_pk").val(),
            "processos_pk":$("#processos_pk").val(),
            "ds_processo_etapas":$('#etapas_1').text(),
            "tipo_evento_pk":v_tipo_evento,
            "aviso_pk":$("#aviso_pk").val(),
            "ds_titulo_agenda":$("#ds_titulo_agenda").val(),
            "responsavel_pk": strJSONDadosTabela
        };
    }
    
     
    var arrEnviar = carregarController("agenda_visita", "salvar", objParametros);
   
    if (arrEnviar.result == 'success'){
        $("#janela_agenda_visita").modal("hide");
        tblAgendaVisita.clear().destroy();
        fcCarregarGridAgendaVisita();
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
        "leads_pk": $("#leads_pk").val()
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


function fcCarregarEtapasProcesso(){

    var objParametros = {
        "pk": $("#processos_pk").val()
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
       
        $(document).on('click', '#cmdIncluirAgendaVisita', fcAbrirFormNovoAgendamentoVisita);    
        $(document).on('click', '#cmdIncluirResponsavel', function () {
            fcIncluirResponsavel("");
        } );
        //Agenda Visita
        fcCarregarGridAgendaVisita();
        
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




 
       
        
        
        
        
        
        
        
        
        
        
        
        
