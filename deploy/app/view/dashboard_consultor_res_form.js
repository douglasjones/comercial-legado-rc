var tblResultado;
var click_id = 0;


function fcCarregarVisitaParaHoje(){
    var objParametros = {
        "pk": ""
    };      

    var arrCarregar = carregarController("agenda_visita", "listarVisitaParaHoje", objParametros); 
 
    $("#qtde_visitas_para_hj").text(arrCarregar.data[0]['qtde_agendas_para_hoje']);
    
        
}
function fcCarregarVisitasAgendadasHoje(){
    var objParametros = {
        "pk": ""
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

function fcAbrirPainelLead(leads_pk){
      sendPost('lead_main_form.php', {token: token, pk: leads_pk});
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
    //$("#usuario_logado_pk").val(226);
    $("#usuario_logado_pk").val(arrCarregar.data[0]['pk']);
    
        
}
function carregarGraficoCarteiraLeadStatus(){

    var arrSeries = [];  
    var arrTexto = [];  
    var url = "../controller/grafico_carteira_lead.controller.php?responsavel_pk="+$("#usuario_logado_pk").val()+"&token="+token;
    //pega as informações
    $.getJSON(url, function(result) {

        for(i = 0; i < result.series.length-1; i++){
            arrSeries[i] ={name: result.series[i].name ,data:result.series[i].data};
            arrTexto = "Carteira Lead Total = "+result.series[8].categories;

        }
        //monta o grafico
       Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: arrTexto
            },
            subtitle: {
                text: ' '
            },
            xAxis: {
                categories: " ",
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Quantidade',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' '
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: 10,
                y: 35,
                floating: false,
                borderWidth: 1,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: arrSeries
        });
    })
    .fail(function() {
       //alert("Deu erro. Veio nada, veio JSON inválido etc");
  });  
}

function carregarGraficoOportunidadesFuturas(){
    var arrSeries = [];  

    var arrCategories = [];  
        var url = "../controller/grafico_oportunidade_futura.controller.php?responsavel_pk="+$("#usuario_logado_pk").val()+"&token="+token;
 
        //pega as informações
        $.getJSON(url, function(result) {
           
            for(i = 0; i < result.series.length-1; i++){
                arrSeries[i] ={name: result.series[i].name,data: result.series[i].data};
                for(j=0; j<result.series[2].categories.length;j++ ){
                    arrCategories[j] = result.series[2].categories[j];
                }
            }
            //monta o grafico
            Highcharts.chart('graf_oportunidades_futuras', {
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
                '#e52122',
                '#FFB90F',
                '#006400',
                '#3f48cc'
                
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

function fcCarregarGridLead(){
    
    var objParametros = {
        "responsavel_pk": $("#usuario_logado_pk").val()
    };     
    
    var v_url = montarUrlController("lead_operador", "listar_grid_relatorio", objParametros);
   
    //Trata a tabela
    tblLead = $('#tblLead').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        //"bProcessing"    : true,
        "aaSorting"      : [],
        //"sPaginationType": "full_numbers",

        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 src='../img/painel.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_qtde_dados"},
           {"targets": -3, "data": "t_ds_qtde_voz"},
           {"targets": -4, "data": "t_dt_vencimento"},
           {"targets": -5, "data": "t_ds_operador"},
           {"targets": -6, "data": "t_ds_lead"},
           {"targets": -7, "data": "t_pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblLead tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblLead.row( $(this).parents('li')).data()){
            data = tblLead.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblLead.row( $(this).parents('tr')).data()){
            data = tblLead.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcAbrirOperadoresAtualLead(data['t_leads_pk']);
        
    } );   
    
    $('#tblLead tbody').on('click', '.function_painel', function () {
        var data;
        
        if(tblLead.row( $(this).parents('li') ).data()){
            data = tblLead.row( $(this).parents('li') ).data();
        }
        else if(tblLead.row( $(this).parents('tr') ).data()){
            data = tblLead.row( $(this).parents('tr') ).data();
        }
        
        if(data['leads_pk'] != ""){
            fcAbrirPainelLead(data['t_leads_pk']);
        }
    } ); 
    
    return false;
}

function fcAbrirOperadoresAtualLead(leads_pk){
    tblLeadOperador.clear().destroy();
    fcCarregarGridLeadOperador(leads_pk);
    
    $("#janela_operador_atual").modal();
}

function fcCarregarGridLeadOperador(pk){
    
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
        "columnDefs": [
           {"targets": -1, "data": "t_tempo_contrato_pk"},
           {"targets": -2, "data": "t_ic_status",visible:false},
           {"targets": -3, "data": "t_ds_status"},
           {"targets": -4, "data": "t_ds_qtde_dados"},
           {"targets": -5, "data": "t_ds_qtde_voz"},
           {"targets": -6, "data": "t_ds_custo_atual"},
           {"targets": -7, "data": "t_dt_vencimento"},
           {"targets": -8, "data": "t_dt_ativacao"},
           {"targets": -9, "data": "t_ic_base",visible:false},
           {"targets": -10, "data": "t_ds_base"},
           {"targets": -11, "data": "t_ic_cliente",visible:false},
           {"targets": -12, "data": "t_ds_cliente"},
           {"targets": -13, "data": "t_operador_pk",visible:false},
           {"targets": -14, "data": "t_ds_operador"},
           {"targets": -15, "data": "t_pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    return false;
}

function carregarGraficoAgenda(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_rel_agendamento_controller.php?token="+token+
                /*"&polos_pk="+polos_pk+
                "&ds_razao_social="+ds_razao_social+
                "&tipos_agendas_pk="+tipos_agendas_pk+
                "&ic_status_1="+ic_status_1+
                "&ic_status_2="+ic_status_2+
                "&ic_status_3="+ic_status_3+
                "&dt_agenda_ini="+dt_agenda_ini+
                "&dt_agenda_fim="+dt_agenda_fim+
                "&mailing_pk="+mailing_pk+*/
                "&responsavel_pk="+$("#usuario_logado_pk").val();
                /*"&grupos_pk="+grupos_pk;*/
               

        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length-1; i++){
                arrSeries[i] = {name: result.series[i].name, y: result.series[i].data};
                arrColor[i] = result.series[i].color;
                
            }
            //$("#qtde_registro_agenda").text("Total: "+(teste));
            //monta o grafico
           Highcharts.chart('classificacao', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'CLASSIFICAÇÃO'
            },
            colors: arrColor,
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
function carregarGraficoAgendadoPor(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_rel_agendado_por_controller.php?token="+token+
                /*"&polos_pk="+polos_pk+
                "&ds_razao_social="+ds_razao_social+
                "&tipos_agendas_pk="+tipos_agendas_pk+
                "&ic_status_1="+ic_status_1+
                "&ic_status_2="+ic_status_2+
                "&ic_status_3="+ic_status_3+
                "&dt_agenda_ini="+dt_agenda_ini+
                "&dt_agenda_fim="+dt_agenda_fim+
                "&mailing_pk="+mailing_pk+*/
                "&responsavel_pk="+$("#usuario_logado_pk").val();
                /*"&grupos_pk="+grupos_pk;*/
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};
                arrColor[i] = result.series[i].color;
            }
            //monta o grafico
           Highcharts.chart('agendado_por', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'AGENDADO POR SDR'
            },
            colors: arrColor,
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

function fcCarregarProposta50(){
    var objParametros = {
        "pk": ""
    };      

    var arrCarregar = carregarController("proposta", "listarProposta50", objParametros); 
    
    $("#qtde_proposta50").text(arrCarregar.data[0]['qtde_proposta50']);
    if(arrCarregar.data[0]['vl_total']==null){
        $("#vl_total50").text("R$: 0,00");
    }
    else{
        $("#vl_total50").text("R$: "+arrCarregar.data[0]['vl_total']);
    }
}
function fcCarregarProposta75(){
    var objParametros = {
        "pk": ""
    };      

    var arrCarregar = carregarController("proposta", "listarProposta75", objParametros); 
    
    $("#qtde_proposta75").text(arrCarregar.data[0]['qtde_proposta75']);
    $("#vl_total75").text(arrCarregar.data[0]['vl_total']);
    if(arrCarregar.data[0]['vl_total']==null){
        $("#vl_total75").text("R$: 0,00");
    }
    else{
        $("#vl_total75").text("R$: "+arrCarregar.data[0]['vl_total']);
    }
}
function fcCarregarPropostaFechada(){
    var objParametros = {
        "pk": ""
    };      

    var arrCarregar = carregarController("proposta", "listarPropostaFechada", objParametros); 
    
    $("#qtde_proposta_fechada").text(arrCarregar.data[0]['qtde_proposta_fechada']);
    $("#vl_total_fechada").text(arrCarregar.data[0]['vl_total']);
    if(arrCarregar.data[0]['vl_total']==null){
        $("#vl_total_fechada").text("R$: 0,00");
    }
    else{
        $("#vl_total_fechada").text("R$: "+arrCarregar.data[0]['vl_total']);
    }
}
function fcCarregarPropostaCancelada(){
    var objParametros = {
        "pk": ""
    };      

    var arrCarregar = carregarController("proposta", "listarPropostaCancelada", objParametros); 
    
    $("#qtde_proposta_cancelada").text(arrCarregar.data[0]['qtde_proposta_cancelada']);
    if(arrCarregar.data[0]['vl_total']==null){
        $("#vl_total_cancelada").text("R$: 0,00");
    }
    else{
        $("#vl_total_cancelada").text("R$: "+arrCarregar.data[0]['vl_total']);
    }
    
}

function fcCarregarGridPropostaDashboard(){    
    var objParametros = {
        "pk": ""
    };     
    
    var v_url = montarUrlController("proposta", "listarPropostaDashboardConsultor", objParametros);
    
    //Trata a tabela
    tblPropostasDashboard = $('#tblPropostasDashboard').DataTable({
        "scrollX": true,
        
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": false,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [
            {
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' title='Editar Proposta'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel' title='Acessar Lead'><span><img width=16 height=16 src='../img/painel.png'></span></a>"
            },
           {"targets": -2, "data": "t_time"}, 
           {"targets": -3, "data": "t_vl_total"}, 
           {"targets": -4, "data": "t_dt_fechamento"}, 
           {"targets": -5, "data": "t_dt_previsao_fechamento"},
           {"targets": -6, "data": "t_dt_envio"},
           {"targets": -7, "data": "t_dt_cad"},
           {"targets": -8, "data": "t_ds_responsavel"},  
           {"targets": -9, "data": "t_ds_lead"},
         ],
         
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    //Atribui os eventos na coluna ação.
    $('#tblPropostasDashboard tbody').on('click', '.function_edit', function () {
        var data;        
        rLinhaSelecionada = null;        
        if(tblPropostasDashboard.row( $(this).parents('li')).data()){
            data = tblPropostasDashboard.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblPropostasDashboard.row( $(this).parents('tr')).data()){
            data = tblPropostasDashboard.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarProposta(data);  
        
    } );   

    $('#tblPropostasDashboard tbody').on('click', '.function_painel', function () {
        var data;        
        rLinhaSelecionada = null;        
        if(tblPropostasDashboard.row( $(this).parents('li')).data()){
            data = tblPropostasDashboard.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblPropostasDashboard.row( $(this).parents('tr')).data()){
            data = tblPropostasDashboard.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcAbrirPainelLead(data['t_leads_pk']);  
        
    } ); 
       
    return false;
}
function fcEditarProposta(objRegistro){
    
   $('#exibir_motivo_cancelamento').hide();
    
    $('#dt_fechamento').prop('checked', false);
    $('#dt_cancelamento').prop('checked', false);
    $("input[id=dt_envio]").prop("disabled", false);
    $("input[id=dt_previsao_fechamento]").prop("disabled", false);
    $("input[id=dt_fechamento]").prop("disabled", false);
    $("input[id=dt_cancelamento]").prop("disabled", false);
    $("input[id=dt_validade]").prop("disabled", false);
    $("#ds_obs_proposta").prop("disabled", false);
  
    
    
    //carregarComboContratoPai(objRegistro['t_contratos_pk']);
   
    //Carrega as informações da linha selecionada.
    $("#propostas_pk").val(objRegistro['t_pk']);
    $("#dt_envio").val(objRegistro['t_dt_envio']); 
    $("#dt_previsao_fechamento").val(objRegistro['t_dt_previsao_fechamento']);
    $("#dt_validade").val(objRegistro['t_dt_validade']);
    $("#ds_obs_proposta").val(objRegistro['t_ds_obs']);
    $("#leads_pk_proposta").val(objRegistro['t_leads_pk']);
    $("#polos_pk_proposta").val(objRegistro['t_polos_pk']);
    $("#n_versao").html(objRegistro['t_versao'])
    
    fcCarregarOperadorProposta();
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
   
    if(objRegistro['t_dt_cancelamento']!=null){
        $('#dt_cancelamento').prop('checked', true);
        $('#exibir_motivo_cancelamento').show();
        $("#ds_obs_motivo_cancelamento").val(objRegistro['t_ds_obs_motivo_cancelamento']);
        if(objRegistro['t_ds_obs_motivo_cancelamento']!=null){
            $("input[id=ds_obs_motivo_cancelamento]").prop("disabled", true);
        }
        $("input[id=dt_cancelamento]").prop("disabled", true);
    }
    
    $("#janela_proposta").modal(); 
    //fcAtualizarDadosGridPropostaItens(v_disabled);
    

    $("#form_proposta").data('validator').resetForm();
}

function fcCarregarOperadorProposta(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("operador", "listarTodosPorPolo", objParametros); 
   
    carregarComboAjax($("#operador_pk"), arrCarregar, " ", "pk", "ds_operador");
        
}
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
            
            fcAtualizarDadosGridPropostaItens("");
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}

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

//SALVA O PROPOSTA
function fcSalvarProposta(){ 
    var v_dt_fechamento = 0; 
    var v_dt_cancelamento = 0; 
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
    if($('#dt_cancelamento').is(":checked")){
        v_dt_cancelamento = 1;
    }
    else{
        v_dt_cancelamento = 2;
    }
    
    if($("#propostas_pk").val()!=""){
        str_proposta_pk = $("#propostas_pk").val();
    }
    if($("#propostas_pai_pk").val()!=""){
        str_proposta_pk = "";
    }
    
    var objParametros = {
        "pk": str_proposta_pk,
        //"processos_etapas_pk":$('#processos_etapas_pk_2').val(),        
        "dt_envio": $("#dt_envio").val(),
        "dt_previsao_fechamento": $("#dt_previsao_fechamento").val(),
        "dt_fechamento": v_dt_fechamento,        
        "dt_cancelamento": v_dt_cancelamento,        
        "dt_validade": $("#dt_validade").val(),
        "ds_obs": $("#ds_obs_proposta").val(),
        "operador_pk": $("#operador_pk").val(),
        "ds_obs_motivo_cancelamento": $("#ds_obs_motivo_cancelamento").val(),
        "n_versao": $("#n_versao").html(),
        "polos_pk": $("#polos_pk_proposta").val(),
        "leads_pk": $("#leads_pk_proposta").val(),
        "agendas_pk": $("#agenda_visita_proposta_pk").val(),
        "vl_total":  $('#vl_total_proposta').html(),
        //"processos_pk": pk,
        //"ds_processo_etapas":$('#etapas_2').text(),
        "proposta_itens": strJSONDadosTabela          
    };    

    var arrEnviar = carregarController("proposta", "salvar", objParametros);
    
   
    if (arrEnviar.result == 'success'){
        $("#janela_proposta").modal("hide");
        fcCarregarProposta50();
        fcCarregarProposta75();
        fcCarregarPropostaFechada();
        fcCarregarPropostaCancelada();
        tblPropostasDashboard.ajax.reload();
        
    }    
    else{
       
        alert(arrEnviar.result);
    }
    //return true;    
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
    fcCarregarUsuarioLogin();
    
    fcCarregarProposta50();
    fcCarregarProposta75();
    fcCarregarPropostaFechada();
    fcCarregarPropostaCancelada();
    
    carregarGraficoAgenda();
    carregarGraficoAgendadoPor();
    
    fcCarregarInformacoesAgenda();
 
    fcCarregarGridRetorno();
    
    fcValidarFormOcorrencia();
    
    carregarGraficoCarteiraLeadStatus();
    
    carregarGraficoOportunidadesFuturas();
    
    fcCarregarGridLead();
    
    fcCarregarGridLeadOperador("");
    
    fcCarregarGridPropostaDashboard();
    carregarListaComboProdutoPropsota();
    fcValidarFormProposta();
    
    fcAtualizarDadosGridPropostaItens();

    $("#operador_pk").change(function(){
        tblPropostaItens.clear().destroy();
        carregarListaComboProdutoPropsota();
    });
    fcCalculaTotalPropsota();
    $(document).on('click', '#cmdIncluirPropostaItens', function () {            
        fcIncluirPropostaItens("");
    } );
  

});


