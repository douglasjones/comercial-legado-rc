var tblResultado;
var click_id = 0;


function fcCarregarVisitaParaHoje(){
    var objParametros = {
        "pk": "",
        "polos_pk":$("#polos_pk_dashboard").val()
    };      

    var arrCarregar = carregarController("agenda_visita", "listarVisitaParaHoje", objParametros); 
 
    $("#qtde_visitas_para_hj").text(arrCarregar.data[0]['qtde_agendas_para_hoje']);
    
        
}
function fcCarregarVisitasAgendadasHoje(){
    var objParametros = {
        "pk": "",
        "polos_pk":$("#polos_pk_dashboard").val()
    };      

    var arrCarregar = carregarController("agenda_visita", "listarVisitaAgendadasHoje", objParametros);  
    

    $("#qtde_visitas_agendas_hj").text(arrCarregar.data[0]['qtde_agendas_para_hoje']);
}

function fcCarregarRetornosAtrasados(){
    var objParametros = {
        "pk": ""
    };      

    var arrCarregar = carregarController("retorno", "listarRetornoAtrasado", objParametros);  

    $("#qtde_retornos_atrasados").text(arrCarregar.data[0]['total_atraso']);
}

function fcCarregarGridRetorno(){
    
    var objParametros = {
        "leads_pk": ""
    };     
    
    var v_url = montarUrlController("retorno", "listarRetornoEmAberto", objParametros);
   
    //Trata a tabela
    tblRetorno = $('#tblRetorno').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,

        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 src='../img/painel.png'></span></a>"
            },
           {"targets": -2, "data": "ds_retorno"},
           {"targets": -3, "data": "ds_tipo_ocorrencia"},
           {"targets": -4, "data": "dt_retorno"},
           {"targets": -5, "data": "ds_lead"},
           {"targets": -6, "data": "leads_pk", visible:false},
           {"targets": -7, "data": "ocorrencias_pk", visible:false},
           {"targets": -8, "data": "pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblRetorno tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblRetorno.row( $(this).parents('li')).data()){
            data = tblRetorno.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblRetorno.row( $(this).parents('tr')).data()){
            data = tblRetorno.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarRetorno(data['ocorrencias_pk'],data['ds_ocorrencia']);
        
    } );   
    
    $('#tblRetorno tbody').on('click', '.function_painel', function () {
        var data;
        
        if(tblRetorno.row( $(this).parents('li') ).data()){
            data = tblRetorno.row( $(this).parents('li') ).data();
        }
        else if(tblRetorno.row( $(this).parents('tr') ).data()){
            data = tblRetorno.row( $(this).parents('tr') ).data();
        }
        
        if(data['leads_pk'] != ""){
            fcAbrirPainelLead(data['leads_pk']);
        }
    } ); 
    
    return false;
}

//---------------------------------------------ABRIR MODAL RETORNO----------------------------------------------------
function fcAbrirFormNovaOcorrencia(){

    $('#tipo_ocorrencia_pk').prop('disabled',true);
    $("#ocorrencias_pk").val("");
    $("#ds_ocorrencia").val("");
    $("#tipo_ocorrencia_pk").val("");
    $('#tipo_ocorrencia_pk').prop('disabled', false);
    $('#dt_fechamento').prop('checked', false);
    
    //AGENDA RETORNO
    $("#agenda_visible").hide();
    $("#agenda_retorno_pk").val("");
    
    $("#edit_agenda_visible").hide();
    $("#agenda_equipe_visible").hide();
    $("#agenda_responsavel_visible").hide();
    $('#agenda_retorno').prop('checked', false);
    $('#agenda_retorno').prop('disabled', true);
    $("#agenda_dt_retorno").val("");
    $("#agenda_hr_retorno").val("");
    $("#agenda_ic_agendar_para").val("");
    $("#agenda_equipes_pk").val("");
    $("#agenda_responsavel_pk").val("");
    $("#agenda_ds_retorno").val("");
    //EDIÇÃO AGENDA
    
    $("#edit_agenda_dt_retorno").html("");
    $('#edit_agenda_responsavel_pk').prop('disabled', false);
    $("#edit_agenda_equipes_pk").val("");
    $("#edit_agenda_dt_retorno_termino").val("");
    $("#edit_agenda_hr_retorno_termino").val("");
    $("input[id=edit_agenda_dt_retorno_termino]").prop("disabled", false);
    $("input[id=edit_agenda_hr_retorno_termino]").prop("disabled", false);
    $('#edit_agenda_equipes_pk').prop('disabled', false);
    $("#edit_agenda_responsavel_pk").val("");
    $("#edit_agenda_ds_retorno").html("");
    
    $("#agenda_ds_retorno").html("");
    
    $("#janela_ocorrencia").modal();
}
function fcEditarRetorno(ocorrencias_pk,ds_ocorrencia){
    
    if(ocorrencias_pk > 0){
        fcAbrirFormNovaOcorrencia();
        $("#ocorrencias_pk").val(ocorrencias_pk);
        $("#ds_ocorrencia").val(ds_ocorrencia);
        var objParametros = {
            "ocorrencias_pk": ocorrencias_pk
        };        
        
        var arrCarregar = carregarController("retorno", "listarOcorrenciasPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            if(arrCarregar.data.length > 0){
                fcCarregarTipoOcorrencia();    
                $("#tipo_ocorrencia_pk").val(arrCarregar.data[0]['tipo_ocorrencia_pk']);
                $("input[id=agenda_retorno]").prop("checked", "true");
                $("input[id=agenda_retorno]").prop("disabled", "true");
                $("#edit_agenda_dt_retorno").html(arrCarregar.data[0]['dt_retorno']);
                $("#edit_agenda_hr_retorno").html(arrCarregar.data[0]['hr_retorno']);          
                $("#agenda_ds_retorno").val(arrCarregar.data[0]['ds_retorno']);
                $('#agenda_ds_retorno').prop('disabled', false);
                $('#dt_termino_retorno').prop('checked', false);
                $("input[id=dt_termino_retorno]").prop("disabled", false);
                
                $("#agenda_retorno_pk").val(arrCarregar.data[0]['pk']);
                                               
                if(arrCarregar.data[0]['dt_termino_retorno']!=null){  
                    $('#dt_termino_retorno').prop('checked', true);
                    $("input[id=dt_termino_retorno]").prop("disabled", "true");
                    
                    //descrição do retorno
                    $('#agenda_ds_retorno').prop('disabled', true);
                    
                    //Desabilita o fechamento da Ocorrencia
                    $("input[id=dt_fechamento]").prop("disabled", "true");
                    
                }
             
                if(arrCarregar.data[0]['equipes_pk']!= null && arrCarregar.data[0]['responsavel_pk']==null){                    
					
                    fcCarregarComboResponsavelEquipe(arrCarregar.data[0]['responsavel_pk']);
                    $("#edit_agenda_responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
                    fcCarregarComboEquipeEdit();
                    $("#edit_agenda_equipes_pk").val(arrCarregar.data[0]['equipes_pk']);
                    $("select[id=edit_agenda_equipes_pk]").prop("disabled", "true");
                }else{
					
                    fcCarregarComboResponsavelEquipe(arrCarregar.data[0]['equipes_pk']);
                    
                    $("#edit_agenda_responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
                    
                    $("select[id=edit_agenda_responsavel_pk]").prop("disabled", "true");
                    $("select[id=edit_agenda_equipes_pk]").prop("disabled", "true");
                }
                
                $("#edit_agenda_visible").show();
            }
            else{
                
                $('#agenda_retorno').prop('checked', false);
                $("#agenda_retorno").prop("disabled", false);
                
                $("#edit_agenda_visible").hide();
            }
            

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }    
}

function fcCarregarComboResponsavelEquipe(v_equipes_pk){
     
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#edit_agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
    
    
}
function fcCarregarComboEquipeEdit(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("equipe", "listarTodos", objParametros);   
    carregarComboAjax($("#edit_agenda_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
        
}

function fcValidarFormOcorrencia(){
    
    $("#form_ocorrencia").validate({
        rules :{
            ds_ocorrencia:{
                required:true
            },
            tipo_ocorrencia_pk:{
                required:true
            },
            agenda_dt_retorno:{
                    required:true
            },
            agenda_hr_retorno:{
                required:true
            },      
            agenda_responsavel_pk:{
                required:true
            },
            agenda_equipes_pk:{
                required:true
            }
        },
        messages:{
            ds_ocorrencia:{
                required:"Por favor, informe Ocorrência"
            },
            tipo_ocorrencia_pk:{
                required:"Por favor, informe Tipo ocorrência"
            },
            agenda_dt_retorno:{
                required:"Por favor, informe a Data"
            },
            agenda_hr_retorno:{
                required:"Por favor, informe a Hora"
            },  
            agenda_responsavel_pk:{
                required:"Por favor, selecione o Usuário"
            },
            agenda_equipes_pk:{
                required:"Por favor, selecione a Equipe"
            } 
        },
        submitHandler: function(form){
            
            fcEnviarOcorrencia(); //Se a validação deu certo, faz o envio do formulario.            
            return false;
        }      
    });    
}

function fcEnviarOcorrencia(){
    var v_agenda_equipes_pk = "";
    var v_agenda_responsavel_pk = "";
    var v_agenda_dt_retorno = "";
    var v_agenda_hr_retorno = "";
    var v_agenda_ds_retorno = "";
    var v_dt_retorno_termino = 0;
    
    var v_dt_fechamento = 0;
    var v_agenda_retorno = 0;
    var v_ds_ocorrencia = $("#ds_ocorrencia").val();
    var v_tipo_ocorrencia_pk = $("#tipo_ocorrencia_pk").val();
   
   
    if($("#agenda_retorno_pk").val()!=""){
         v_agenda_equipes_pk = $("#edit_agenda_equipes_pk").val();
         v_agenda_responsavel_pk = $("#edit_agenda_responsavel_pk").val();
         v_agenda_ds_retorno = $("#agenda_ds_retorno").val();
    }else{
        v_agenda_dt_retorno = $("#agenda_dt_retorno").val();
        v_agenda_hr_retorno = $("#agenda_hr_retorno").val();
        v_agenda_equipes_pk = $("#agenda_equipes_pk").val();
        v_agenda_responsavel_pk = $("#agenda_responsavel_pk").val();
        v_agenda_ds_retorno = $("#agenda_ds_retorno").val();
    }
 
    if($('#dt_fechamento').is(":checked")){
        v_dt_fechamento = 1;
    }
    else{
        v_dt_fechamento = 2;
    }
    if($('#agenda_retorno').is(":checked")){
        v_agenda_retorno = 1;
    }
    else{
        v_agenda_retorno = 2;
    }
   if($('#dt_termino_retorno').is(":checked")){
        v_dt_retorno_termino = 1;
    }
    else{
        v_dt_retorno_termino = 2;
    }
    
    if($("#ocorrencias_pk").val()==''){
        var objParametros = {        
            "leads_pk": pk,
            "pk": $("#ocorrencias_pk").val(),
            "ds_ocorrencia":v_ds_ocorrencia,
            "tipos_ocorrencias_pk":v_tipo_ocorrencia_pk,
            "dt_fechamento":v_dt_fechamento,
            "dt_retorno":v_agenda_dt_retorno,
            "hr_retorno":v_agenda_hr_retorno,
            "equipes_pk":v_agenda_equipes_pk,
            "responsavel_pk":v_agenda_responsavel_pk,
            "ds_retorno":v_agenda_ds_retorno,
            "agenda_retorno":v_agenda_retorno,
            "dt_termino_retorno":v_dt_retorno_termino,
            "agenda_retorno":v_agenda_retorno,
            "agenda_retorno_pk":$("#agenda_retorno_pk").val()
        };
    }else{
        var objParametros = {      
            
            "pk": $("#ocorrencias_pk").val(),
            "ds_ocorrencia":v_ds_ocorrencia,
            "tipos_ocorrencias_pk":v_tipo_ocorrencia_pk,
            "dt_fechamento":v_dt_fechamento,
            "dt_retorno":v_agenda_dt_retorno,
            "hr_retorno":v_agenda_hr_retorno,
            "equipes_pk":v_agenda_equipes_pk,
            "responsavel_pk":v_agenda_responsavel_pk,
            "ds_retorno":v_agenda_ds_retorno,
            "agenda_retorno":v_agenda_retorno,
            "dt_termino_retorno":v_dt_retorno_termino,
            "agenda_retorno":v_agenda_retorno,
            "agenda_retorno_pk":$("#agenda_retorno_pk").val()
        };
    }
    
    var arrEnviar = carregarController("ocorrencia", "salvar", objParametros); 
	
    if (arrEnviar.result == 'success'){                
        // Reload datable
        alert(arrEnviar.message);
        $("#janela_ocorrencia").modal("hide");
        tblRetorno.ajax.reload();
        
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
   
}
function fcCarregarTipoOcorrencia(){

    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros); 

    carregarComboAjax($("#tipo_ocorrencia_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");
        
}

//---------------------------------------------------FINAL MODAL RETORNO-------------------------------------

function fcAbrirPainelLead(leads_pk){
      sendPost('lead_main_form.php', {token: token, pk: leads_pk});
}


function fcCarregarInformacoesAgenda(){
    
    fcCarregarVisitaParaHoje();

    fcCarregarVisitasAgendadasHoje();
    
    fcCarregarRetornosAtrasados();
    
    
}

function fcCarregarUsuarioLogin(){
    
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
    $("#ds_usuario_logado").text(arrCarregar.data[0]['ds_usuario']);
    
        
}
function carregarGraficoFunil(){

        var arrSeries = [];  
        var url = "../controller/grafico_funil_vendas_controller.php?token="+token+"&polos_pk="+$("#polos_pk_dashboard").val();

        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] = {name: result.series[i].name, y: result.series[i].data};
                
            }
            //monta o grafico
            Highcharts.chart('graf_funil', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ' '
            },
            colors: [
                '#0fa1ff',
                '#1c7c1a',
                '#fe4240',
                '#0f6f0f'
            ],
            plotOptions: {
                pie: {
                    allowPointSelect: false,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: ' ',
                colorByPoint: true,
                data: arrSeries
            }]
        });
        })
        .fail(function() {
           //alert("Deu erro. Veio nada, veio JSON inválido etc");
      });
    
}

function carregarGraficoAgenda(){
    
    var arrSeries = [];  

    var arrCategories = [];  
        var url = "../controller/grafico_agendamento_controller.php?token="+token+"&polos_pk="+$("#polos_pk_dashboard").val();
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length-1; i++){
                arrSeries[i] ={name: result.series[i].name,data: result.series[i].data};
                for(j=0; j<result.series[5].categories.length;j++ ){
                    arrCategories[j] = result.series[5].categories[j];
                }
                
            }
            //monta o grafico
            Highcharts.chart('graf_agenda', {
            chart: {
                type: 'column'
            },
            title: {
                text: ' '
            },
            xAxis: {
                categories:arrCategories
             },
             colors: [
                '#dbdbdb',
                '#a9df91',
                '#f68685',
                '#f8e98a',
                '#e52122'
            ],
            yAxis: {
                min: 0,
                title: {
                    text: ''
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold'
                        
                    }
                }
            },
            legend: {
                align: 'right',
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: arrSeries
        });
        })
        .fail(function() {
           //alert("Deu erro. Veio nada, veio JSON inválido etc");
      }); 
    
}

function fcEsconderTudo(){
    //INFORMATIVO AGENDAS
    $('#exibir_informativo_agenda').hide();

    // RETORNO
    $('#exibir_retorno').hide();

    // AGENDA VISITA
    $('#exibir_agenda_visita').hide();

    // CONTRATO
    $('#exibir_contrato').hide();

    // FUNIL VENDAS
    $('#exibir_funil_vendas').hide();

    // PROPOSTA
    $('#exibir_proposta_dashboard').hide();
} 

function fcCarregarPolo(){
    var objParametros = {
        "pk": ""
    };      
    
   var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros); 
   if(arrCarregar.length > 1){
       carregarComboAjax($("#polos_pk_dashboard"), arrCarregar, " ", "pk", "ds_polo");
   }
   else{
       carregarComboAjax($("#polos_pk_dashboard"), arrCarregar, "", "pk", "ds_polo");
   }
   
            
}

function fcAbrirNovoRetorno(){
    $('#dt_termino_retorno').prop('checked', true); 
    fcEnviarOcorrencia();
    setTimeout(function(){
        fcAbrirFormNovaOcorrencia();
    }, 2000);
   
}
$(document).ready(function(){
    $(document).on('click', '#n_retorno', fcAbrirNovoRetorno);
    //fcEsconderTudo();
    fcCarregarGridRetorno();
    
    fcValidarFormOcorrencia();
    
    fcCarregarPolo();
    fcCarregarUsuarioLogin();
    if($("#polos_pk_dashboard").val()!=""){
        fcCarregarInformacoesAgenda();
 
    
        carregarGraficoFunil();

        carregarGraficoAgenda();

    }
    $("#polos_pk_dashboard").change(function(){
        fcCarregarInformacoesAgenda();
 
        carregarGraficoFunil();

        carregarGraficoAgenda();
        
        tblAgendaVisita.clear().destroy();
        fcCarregarGridAgendaVisita();
        
        tblPropostas.ajax.reload();
    });
    
    
    
    
    
    
        
    //}
    
  

});


