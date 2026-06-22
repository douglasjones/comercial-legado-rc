var tblAgendaVisita;
var tblResponsavel;
var agenda_visita_pk = "";
//--------------------Agenda Visita----------------------------
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

function fcAbrirFormNovoAgendamentoVisita(){
    fcCarregarLeadAgenda();
    $("#exib_motivo_reagendamento").hide();
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").hide();
    $('#exib_sem_pk').show();
    $('#exib_com_pk').hide();
    $("#exib_obs").show();
    $('#exibir_lembrete').hide();
    $('#exibir_agenda').hide();
    fcLimparFormAgendaVisita();
    
    fcCarregarEnderecoLead();
    
    tblResponsavel.clear().destroy();
    fcFormatarGridResponsavel();
    
    $("#janela_agenda_visita").modal();
    fcAtualizarDadosGridResponsavel();
    var validator = $( "#form_agenda_visita" ).validate();
    validator.resetForm();
    
    
}

function fcCarregarEnderecoLead(){
        
        var objParametros = {
            "leads_pk": leads_pk
        };        
        
        var arrCarregar = carregarController("endereco", "listarPorLead", objParametros);
        if(arrCarregar.data==""){
            $("#ds_cep").val("");
            $("#ds_endereco").val("");
            $("#ds_numero").val("");
            $("#ds_complemento").val("");
            $("#ds_bairro").val("");
            $("#ds_cidade").val("");
            $("#ds_uf").val("");
        }
        else{
            if (arrCarregar.result == 'success'){
                $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
                $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
                $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
                $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
                $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
                $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
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
    $("#ds_obs").val("");
    $("#motivo_reagendamento_pk").val("");
    $("#ds_obs_reagendamento").val("");
    $("#classificacao_agenda_pk").val("");
    $("#ds_obs_classificacao").val("");
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
    $("#aviso_pk").val("");
    $("#ds_titulo_agenda").val("");
    $("#atendente_pk").val("");
    
}




function fcCarregarGridAgendaVisita(){
    
    var objParametros = {
        "leads_pk": leads_pk,
        "processos_default_pk": processos_default_pk,
        "processos_pk":pk
    };     
    
    var v_url = montarUrlController("agenda_visita", "listarAgendaVisitaLeadProcesso", objParametros);
   
    //Trata a tabela
    tblAgendaVisita = $('#tblAgendaVisita').DataTable({
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
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                                   <a class='function_painel'><span><img width=19 height=16 src='../img/reagendamento.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                                   <a class='function_classificacao'><span><img width=16 height=16 src='../img/classificacao.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;\n\
                                   <a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_status"},
           {"targets": -3, "data": "t_ds_endereco"},
           {"targets": -4, "data": "t_dt_agenda"},
           {"targets": -5, "data": "t_classificacao_agenda_pk" ,"visible":false},
           {"targets": -6, "data": "t_ds_classificacao_agenda"},
           {"targets": -7, "data": "t_tipos_agendas_pk" , "visible":false},
           {"targets": -8, "data": "t_ds_tipo_agenda"},
           {"targets": -9, "data": "t_pk"}

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
        else if(tblAgendaVisita.row( $(this).parents('tr') ).data()){
            data = tblAgendaVisita.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirAgendaVisita(data['t_pk']);
        }
    } ); 
    
    return false;
}

function fcAbrirClassificacao(objRegistro){
    
    fcCarregarLeadAgenda();
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").show();
    $("#exib_motivo_reagendamento").hide();
    $("#exib_obs").show();
    $('#exibir_lembrete').hide();
    $('#exibir_agenda').show();
   fcLimparFormAgendaVisita();
   
    if(objRegistro['t_motivo_reagendamento_pk']!=null){
        $("#exib_motivo_reagendamento").hide();
        $("#motivo_reagendamento_pk").val(objRegistro['t_motivo_reagendamento_pk']);
        $("#ds_obs_reagendamento").val(objRegistro['t_ds_obs_reagendamento']);
    }
    if(objRegistro['t_classificacao_agenda_pk']== null){
        $("#exib_motivo_cancelamento").hide();
        $("#motivo_cancelamento_pk").val(objRegistro['t_motivo_cancelamento_pk']);
        $("#ds_obs_cancelamento").val(objRegistro['t_ds_obs_cancelamento']);
    }
    
    if(objRegistro['t_motivo_cancelamento_pk']!=null){
        $("#exib_motivo_cancelamento").hide();
        $("#exib_classificacao").hide();
        $("#exib_obs").show();
        $("#exib_obs_classificacao").hide();
        $('#exibir_lembrete').hide();
        $("#exib_motivo_reagendamento").hide();
    }
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(objRegistro['t_pk']);
    $("#agenda_reagendamento_pk").val(" ");
    fcCarregarAtendente();
    $("#atendente_pk").val(objRegistro['t_atendente_pk']);
    tblResponsavel.clear().destroy();
    fcFormatarGridResponsavel();
   
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
        if(objRegistro['t_ds_email']==null){
            $("#ds_email_contato").val("");
        }
        else{
            $("#ds_email_contato").val(objRegistro['t_ds_email']);
        }
        if(objRegistro['t_ds_cel']==null){
            $("#ds_cel").val("");
        }
        else{
            $("#ds_cel").val(objRegistro['t_ds_cel']);
        }
        if(objRegistro['t_ds_tel']==null){
            $("#ds_tel").val("");
        }
        else{
            $("#ds_tel").val(objRegistro['t_ds_tel']);
        }
        if(objRegistro['t_ds_cargo']==null){
            $("#ds_cargo").val("");
        }
        else{
            $("#ds_cargo").val(objRegistro['t_ds_cargo']);
        }
        if(objRegistro['t_ds_email']==null){
            $("#ds_email_contato").val("");
        }
        else{
            $("#ds_email_contato").val(objRegistro['t_ds_email']);
        }
    }
    else{
        $('#exib_sem_pk').show();
        $('#exib_com_pk').hide();
    }
    $("#ds_cep").val(objRegistro['t_ds_cep']);
    $("#classificacao_agenda_pk").val(objRegistro['t_classificacao_agenda_pk']);
    $("#ds_obs_classificacao").val(objRegistro['t_ds_obs_classificacao']);
    
    if(objRegistro['t_classificacao_agenda_pk']!= null ){
        $("select[id=classificacao_agenda_pk]").prop("disabled", true);
    }
    else{
        $("select[id=classificacao_agenda_pk]").prop("disabled", false);
    }
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
    
    
    
    $("#ds_obs").val(objRegistro['t_ds_obs']);
    
    if(objRegistro['t_tipo_evento_pk']==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
    }
    else if(objRegistro['t_tipo_evento_pk']==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
    }
    $("#ds_obs_cancelamento").val(objRegistro['t_ds_obs_cancelamento']);
    $("#janela_agenda_visita").modal();
    fcAtualizarDadosGridResponsavel();
    $("#form_agenda_visita").data('validator').resetForm();
    
}
function fcEditarAgendaVisita(objRegistro){
    fcCarregarLeadAgenda();
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").hide();
    $("#exib_motivo_reagendamento").hide();
    $("#exib_obs").show();
    
    fcLimparFormAgendaVisita();
    
    
    if(objRegistro['t_motivo_reagendamento_pk']!=null){
        $("#exib_motivo_reagendamento").show();
        $("#motivo_reagendamento_pk").val(objRegistro['t_motivo_reagendamento_pk']);
        $("#ds_obs_reagendamento").val(objRegistro['t_ds_obs_reagendamento']);
        
        $("#motivo_reagendamento_pk").prop('disabled', true);
        $("#ds_obs_reagendamento").prop('disabled', true);
    }
    if(objRegistro['t_classificacao_agenda_pk']!= null ){
        $("#exib_classificacao").show();
        $("#classificacao_agenda_pk").val(objRegistro['t_classificacao_agenda_pk']);
        $("#ds_obs_classificacao").val(objRegistro['t_ds_obs_classificacao']);
        
        $("#classificacao_agenda_pk").prop('disabled', true);
        $("#ds_obs_classificacao").prop('disabled', true);
    }
    if(objRegistro['t_ic_status']!= 3 && objRegistro['t_classificacao_agenda_pk']==null ){
        $("#exib_motivo_cancelamento").show();
        $("#motivo_cancelamento_pk").val(objRegistro['t_motivo_cancelamento_pk']);
        $("#ds_obs_cancelamento").val(objRegistro['t_ds_obs_cancelamento']);
    }
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(objRegistro['t_pk']);
    $("#agenda_reagendamento_pk").val(" ");
    fcCarregarAtendente();
    $("#atendente_pk").val(objRegistro['t_atendente_pk']);
    
    
    tblResponsavel.clear().destroy();
    fcFormatarGridResponsavel();
    
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
        if(objRegistro['t_ds_email']==null){
            $("#ds_email_contato").val("");
        }
        else{
            $("#ds_email_contato").val(objRegistro['t_ds_email']);
        }
        if(objRegistro['t_ds_cel']==null){
            $("#ds_cel").val("");
        }
        else{
            $("#ds_cel").val(objRegistro['t_ds_cel']);
        }
        if(objRegistro['t_ds_tel']==null){
            $("#ds_tel").val("");
        }
        else{
            $("#ds_tel").val(objRegistro['t_ds_tel']);
        }
        if(objRegistro['t_ds_cargo']==null){
            $("#ds_cargo").val("");
        }
        else{
            $("#ds_cargo").val(objRegistro['t_ds_cargo']);
        }
        if(objRegistro['t_ds_email']==null){
            $("#ds_email_contato").val("");
        }
        else{
            $("#ds_email_contato").val(objRegistro['t_ds_email']);
        }
    }
    else{
        $('#exib_sem_pk').show();
        $('#exib_com_pk').hide();
    }
 
    $("#ds_cep").val(objRegistro['t_ds_cep']);
    $("#classificacao_agenda_pk").val(objRegistro['t_classificacao_agenda_pk']);
    if(objRegistro['t_classificacao_agenda_pk']!=null){
        $("select[id=classificacao_agenda_pk]").prop("disabled", true);
    }
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
    
    
   
    $("#ds_obs").val(objRegistro['t_ds_obs']);
    
    $("#ds_obs_cancelamento").val(objRegistro['t_ds_obs_cancelamento']);
    
    $("#aviso_pk").val(objRegistro['t_aviso_pk']);
    $("#ds_titulo_agenda").val(objRegistro['t_ds_titulo_agenda']);
    if(objRegistro['t_tipo_evento_pk']==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
    }
    else if(objRegistro['t_tipo_evento_pk']==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
    }
    if(objRegistro['t_classificacao_agenda_pk']!= null ){
        $("#exib_classificacao").show();
        $("#classificacao_agenda_pk").val(objRegistro['t_classificacao_agenda_pk']);
        $("#ds_obs_cancelamento").val(objRegistro['t_ds_obs_cancelamento']);
    }
    $("#janela_agenda_visita").modal();
    fcAtualizarDadosGridResponsavel();
    $("#form_agenda_visita").data('validator').resetForm();
    
}

function fcAbrirReagendamento(objRegistro){
    fcCarregarLeadAgenda();
    $("#exib_motivo_cancelamento").hide();
    $("#exib_classificacao").hide();
    $("#exib_obs").show();
    $('#exibir_lembrete').hide();
    $('#exibir_agenda').show();
    $("#exib_motivo_reagendamento").show();
    
    
    fcLimparFormAgendaVisita();
    if(objRegistro['t_classificacao_agenda_pk']!= null ){
        $("#exib_classificacao").hide();
        $("#classificacao_agenda_pk").val(objRegistro['t_classificacao_agenda_pk']);
        $("#ds_obs_classificacao").val(objRegistro['t_ds_obs_classificacao']);
        $("#motivo_cancelamento_pk").prop('disabled', false);
        $("#ds_obs_cancelamento").prop('disabled', false);
    }
    if(objRegistro['t_motivo_reagendamento_pk']==null){
        $("#exib_motivo_cancelamento").hide();
        $("#motivo_cancelamento_pk").val(objRegistro['t_motivo_cancelamento_pk']);
        $("#ds_obs_cancelamento").val(objRegistro['t_ds_obs_cancelamento']);
        
        $("#motivo_cancelamento_pk").prop('disabled', false);
        $("#ds_obs_cancelamento").prop('disabled', false);
    }
    
    if(objRegistro['t_motivo_cancelamento_pk']!=null){
        $("#exib_motivo_reagendamento").hide();
        $("#exib_motivo_cancelamento").hide();
        $("#exib_classificacao").hide();
        $("#exib_obs").show();
        $("#exib_obs_classificacao").hide();
        $('#exibir_lembrete').hide();
        
    }
    
    
    
   //Carrega as informações da linha selecionada.
    $("#agenda_visita_pk").val(objRegistro['t_pk']);
    $("#agenda_reagendamento_pk").val(objRegistro['t_pk']);
    fcCarregarAtendente();
    $("#atendente_pk").val(objRegistro['t_atendente_pk']);
    
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
        if(objRegistro['t_ds_email']==null){
             $("#ds_email_contato").val("");
         }
         else{
             $("#ds_email_contato").val(objRegistro['t_ds_email']);
         }
         if(objRegistro['t_ds_cel']==null){
             $("#ds_cel").val("");
         }
         else{
             $("#ds_cel").val(objRegistro['t_ds_cel']);
         }
         if(objRegistro['t_ds_tel']==null){
             $("#ds_tel").val("");
         }
         else{
             $("#ds_tel").val(objRegistro['t_ds_tel']);
         }
         if(objRegistro['t_ds_cargo']==null){
             $("#ds_cargo").val("");
         }
         else{
             $("#ds_cargo").val(objRegistro['t_ds_cargo']);
         }
        if(objRegistro['t_ds_email']==null){
            $("#ds_email_contato").val("");
        }
        else{
            $("#ds_email_contato").val(objRegistro['t_ds_email']);
        }
    }
    else{
        $('#exib_sem_pk').show();
        $('#exib_com_pk').hide();
    }
    if(objRegistro['t_tipo_evento_pk']==1){
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').show();
        $("#tipo_evento_agenda_pk_0").prop('checked', true);
    }
    else if(objRegistro['t_tipo_evento_pk']==2){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
    }
    else if(objRegistro['t_tipo_evento_pk']==3){
        $('#exibir_lembrete').show();
        $('#exibir_agenda').hide();
        $("#tipo_evento_agenda_pk_0").prop('checked', false);
    }
    
    $("#motivo_reagendamento_pk").val(objRegistro['t_motivo_reagendamento_pk']);
    $("#ds_obs_reagendamento").val(objRegistro['t_ds_obs_reagendamento']);
    $("#ds_obs").val(objRegistro['t_ds_obs']);
    
    
    $("#janela_agenda_visita").modal(); 
    
    $("#form_agenda_visita").data('validator').resetForm();
    
}

function fcExcluirAgendaVisita(v_pk){
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              
       
        var arrExcluir = carregarController("agenda_visita", "excluir", objParametros);  
   
        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            tblAgendaVisita.ajax.reload();
            
        }
        else{
        }
    }
    else{
        alert("Código não encontrado");
    }
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
    if($("#contatos_pk").val()!=""){
        fcCarregarDescricaoContato($("#contatos_pk").val());
    }
    
    //TIPO EVENTO 
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
            "ds_obs":$('#ds_obs_reagendamento').val(),
            "ic_status":ic_status,
            "processos_etapas_pk":$('#processos_etapas_pk_1').val(),
            "agenda_reagendamento_pk":$('#agenda_reagendamento_pk').val(),
            "ds_contato":$('#ds_contato').val(),
            "ds_cel":$('#ds_cel').val(),
            "ds_tel":$('#ds_tel').val(),
            "ds_email":$('#ds_email_contato').val(),
            "ds_cargo":$('#ds_cargo').val(),
            "cargos_pk":$('#cargos_pk').val(),
            "polos_pk":polos_pk,
            "leads_pk":leads_pk,
            "processos_pk":pk,
            "ds_processo_etapas":$('#etapas_1').text(),
            "tipo_evento_pk":v_tipo_evento,
            "contatos_pk":$("#contatos_pk").val(),
            "atendente_pk":$("#atendente_pk").val(),
            //"aviso_pk":$("#aviso_pk").val(),
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
            "ds_obs_classificacao":$('#ds_obs_classificacao').val(),
            "motivo_reagendamento_pk":$('#motivo_reagendamento_pk').val(),
            "ds_obs_reagendamento":$('#ds_obs_reagendamento').val(),
            "ds_obs_cancelamento":$('#ds_obs_cancelamento').val(),
            "ic_status":ic_status,
            "motivo_cancelamento_pk":$('#motivo_cancelamento_pk').val(),
            "processos_etapas_pk":$('#processos_etapas_pk_1').val(),
            "ds_contato":$('#ds_contato').val(),
            "ds_cel":$('#ds_cel').val(),
            "ds_tel":$('#ds_tel').val(),
            "ds_email":$('#ds_email_contato').val(),
            "ds_cargo":$('#ds_cargo').val(),
            "cargos_pk":$('#cargos_pk').val(),
            "polos_pk":polos_pk,
            "leads_pk":leads_pk,
            "atendente_pk":$("#atendente_pk").val(),
            "contatos_pk":$("#contatos_pk").val(),
            "processos_pk":pk,
            "ds_processo_etapas":$('#etapas_1').text(),
            "tipo_evento_pk":v_tipo_evento,
            //"aviso_pk":$("#aviso_pk").val(),
            "ds_titulo_agenda":$("#ds_titulo_agenda").val(),
            "responsavel_pk": strJSONDadosTabela
        };
    }
     
     
    var arrEnviar = carregarController("agenda_visita", "salvar", objParametros);
    
    if (arrEnviar.result == 'success'){
        $("#janela_agenda_visita").modal("hide");
        
        if(classificacao_agenda_pk==1){
           
            if ($("#tblPropostaItens").length){     
                if (confirm ("Deseja cadastrar uma proposta ?")){
                    
                    $("#agenda_visita_proposta_pk").val(arrEnviar.data[0]['pk']);
                    fcAbrirFormNovaProposta();
                }
             }
        }
        tblAgendaVisita.ajax.reload();
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
    $("#ds_email_contato").val(arrCarregar.data[0]['ds_email']);
    $("#ds_cargo").val(arrCarregar.data[0]['ds_cargos']);
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
            if($("#agenda_visita_pk").val()!="" || arrCarregar.data.length==1){
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

function fcCarregarLeadAgenda(){

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

function fcCarregarAtendente(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarAtentedente", objParametros); 
    
    if(arrCarregar.data.lenght==1){
         carregarComboAjax($("#atendente_pk"), arrCarregar, "", "pk", "ds_usuario"); 
    }
    else{
        carregarComboAjax($("#atendente_pk"), arrCarregar, " ", "pk", "ds_usuario"); 
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
        
        fcCarregarAtendente();
        
        $("#ds_cep").keypress(function(){
           mascara(this,cep);
        });
        $("#ds_cep").change(function(){
            fcCarregarCep($("#ds_cep").val());
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
        
        fcCarregarContato();
        fcValidarFormAgendaVisita();
        $('#exib_sem_pk').hide();
        $('#exib_com_pk').show();
        
        $('#tipo_evento_agenda_pk_0').click(function() {       
            $('#exibir_lembrete').hide();
            $('#exibir_agenda').show();
            
        });
        $('#exibir_lembrete').hide();
        $('#exibir_agenda').hide();
    }
);




 
       
        
        
        
        
        
        
        
        
        
        
        
        
