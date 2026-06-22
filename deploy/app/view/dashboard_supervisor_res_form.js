var tblResultado;
var click_id = 0;

function fcCarregarMembroEquipes(){
    
    var objParametros = {
        "pk": ""       
    };      
    
    var arrCarregar = carregarController("usuario", "listarMembroEquipe", objParametros);   

    carregarComboAjax($("#membro_equipe_pk"), arrCarregar, " ", "pk", "ds_usuario");  
}


function fcCarregarUsuarioGrupoLogin(){
    
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
    $("#ds_usuario_logado").text(arrCarregar.data[0]['ds_usuario']);
       
}

function carregarGraficoOportunidadesFuturas(){
    var arrSeries = [];  

    var arrCategories = [];  
        var url = "../controller/grafico_oportunidade_futura_supervisor.controller.php?membro_equipes_pk="+$("#membro_equipe_pk").val()+"&dt_ini_of="+$("#dt_ini_of").val()+"&dt_fim_of="+$("#dt_fim_of").val()+"&token="+token;
        
        //pega as informações
        $.getJSON(url, function(result) {
           
            for(i = 0; i < result.series.length-1; i++){
                arrSeries[i] ={name: result.series[i].name,data: result.series[i].data};
                arrCategories[i] = result.series[0].categories[i];
            }
            //monta o grafico
            Highcharts.chart('graf_oportunidades_futuras', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: arrCategories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.0,
                    borderWidth: 0
                }
            },
            series: arrSeries
        });
        })
        .fail(function() {
           //alert("Deu erro. Veio nada, veio JSON inválido etc");
      }); 
    
}

function fcCarregarGridOportunidadeFuturas(){
    
    var objParametros = {
        "membro_equipe_pk": $("#membro_equipe_pk").val(),
        "dt_ini_of":$("#dt_ini_of").val(),
        "dt_fim_of":$("#dt_fim_of").val()
    };     
    
    var v_url = montarUrlController("lead_operador", "listarGridOf", objParametros);
   
    //Trata a tabela
    tblOportunidadesFuturas = $('#tblOportunidadesFuturas').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,

        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_painel'><span><img width=16 height=16 src='../img/painel.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/list.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;"
            },
           {"targets": -2, "data": "t_ds_qtde_voz"},
           {"targets": -3, "data": "t_ds_qtde_dados"},
           {"targets": -4, "data": "t_dt_vencimento"},
           {"targets": -5, "data": "t_ds_usuario"},
           {"targets": -6, "data": "t_ds_operador"},
           {"targets": -7, "data": "t_ds_lead"}
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblOportunidadesFuturas tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblOportunidadesFuturas.row( $(this).parents('li')).data()){
            data = tblOportunidadesFuturas.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblOportunidadesFuturas.row( $(this).parents('tr')).data()){
            data = tblOportunidadesFuturas.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        if(data['t_leads_pk'] != ""){
           fcAbrirOperadorasAtuais(data['t_leads_pk']);
        }
        
        
    } );   
    
    $('#tblOportunidadesFuturas tbody').on('click', '.function_painel', function () {
        var data;
        
        if(tblOportunidadesFuturas.row( $(this).parents('li') ).data()){
            data = tblOportunidadesFuturas.row( $(this).parents('li') ).data();
        }
        else if(tblOportunidadesFuturas.row( $(this).parents('tr') ).data()){
            data = tblOportunidadesFuturas.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_leads_pk'] != ""){
            fcAbrirPainelLead(data['t_leads_pk']);
        }
    } ); 
    $('#tblOportunidadesFuturas tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblOportunidadesFuturas.row( $(this).parents('li') ).data()){
            data = tblOportunidadesFuturas.row( $(this).parents('li') ).data();
        }
        else if(tblOportunidadesFuturas.row( $(this).parents('tr') ).data()){
            data = tblOportunidadesFuturas.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_leads_pk'] != ""){
            abrirGridOc(data['t_leads_pk']);
        }
    } ); 
    
    return false;
}

function abrirGridOc(pk){
    
    if(pk!=""){
        fcCarregarSubMenu(pk);
        $("#janela_agenda_visita_ocorrencia").modal();
        tblOcorrencia.clear().destroy();
    }
    
    var objParametros = {
        "leads_pk": pk
    };     
    var v_url = montarUrlController("ocorrencia", "listarOcorrenciaProcessoLead", objParametros);

    //Trata a tabela
    tblOcorrencia = $('#tblOcorrencia').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        "aaSorting"      : [], 
        "columnDefs": [

           {"targets": -1, "data": "t_dt_termino_retorno"}, 
           {"targets": -2, "data": "t_ds_retorno"},
           {"targets": -3, "data": "t_dt_retorno"},
           {"targets": -4, "data": "t_agendado_para"},
           {"targets": -5, "data": "t_dt_fechamento"}, 
           {"targets": -6, "data": "t_nome_usuario_cadastro"},
           {"targets": -7, "data": "t_ds_ocorrencia"},
           {"targets": -8, "data": "t_tipos_ocorrencias_pk" ,"visible":false},
           {"targets": -9,"data": "t_ds_tipo_ocorrencia"},
           {"targets": -10, "data": "t_dt_cadastro"}, 
           {"targets": -11, "data": "t_pk"} 

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    $(document).on('click', '#cmdIncluirOcorrencia', function () { 
        $("#janela_agenda_visita_ocorrencia").modal("hide");
        fcAbrirFormNovaOcorrencia(pk);
    } );

    
}

function fcAbrirPainelLead(leads_pk){
      sendPost('lead_main_form.php', {token: token, pk: leads_pk,agenda:3});
}

function fcAbrirOperadorasAtuais(leads_pk){
    tblLeadOperador.clear().destroy();
    fcCarregarGridLeadOperador(leads_pk);
}

var tblLeadOperador;

function fcCarregarGridLeadOperador(pk){
    if(pk!=""){
        fcCarregarSubMenu(pk);
        $("#janela_agenda_visita_lead").modal();
    }
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

function fcCarregarSubMenu(pk){

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

function fcCarregarGridCarteiraLeadStatus(){
    var objParametros = {
        "membro_equipe_pk": $("#membro_equipe_pk").val()
    };     
    
    var v_url = montarUrlController("lead", "listarCarteiraLeadStatusSupervisor", objParametros);
    //Trata a tabela
    tblCarteiraLeadStatus = $('#tblCarteiraLeadStatus').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
           {"targets": -1, "data": "qtde_cliente"},
           {"targets": -2, "data": "qtde_90"},
           {"targets": -3, "data": "qtde_80"},
           {"targets": -4, "data": "qtde_75"},
           {"targets": -5, "data": "qtde_50"},
           {"targets": -6, "data": "qtde_25"},
           {"targets": -7, "data": "qtde_contactado"},
           {"targets": -8, "data": "qtde_nao_contactado"},
           {"targets": -9, "data": "qtde_sem_interesse"},
           {"targets": -10, "data": "ds_usuario"}
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
   
    return false;
}

function carregarGraficoPizzaRetornoPendente(){
    
    var arrSeries = [];  
        var url = "../controller/grafico_retorno_pendente.controller.php?token="+token+
                /*"&polos_pk="+polos_pk+
                "&ds_razao_social="+ds_razao_social+
                "&tipos_agendas_pk="+tipos_agendas_pk+
                "&ic_status_1="+ic_status_1+
                "&ic_status_2="+ic_status_2+
                "&ic_status_3="+ic_status_3+
                "&dt_agenda_ini="+dt_agenda_ini+
                "&dt_agenda_fim="+dt_agenda_fim+
                "&mailing_pk="+mailing_pk+*/
                "&membro_equipe_pk="+$("#membro_equipe_pk").val();
                /*"&grupos_pk="+grupos_pk;*/
                
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length-1; i++){
                arrSeries[i] = {name: result.series[i].name, y: result.series[i].data};
                
            }
            //$("#qtde_registro_agenda").text("Total: "+(teste));
            //monta o grafico
           Highcharts.chart('grafic_retorno_pendente', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Retorno Pendente'
            },
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

function fcCarregarGridRetornoPendente(){
    var objParametros = {
        "membro_equipe_pk": $("#membro_equipe_pk").val()
    };     
    
    var v_url = montarUrlController("retorno", "listarQtdeRetornoPendente", objParametros);
    //Trata a tabela
    tblRetornoPendente = $('#tblRetornoPendente').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
           {"targets": -1, "data": "qtde72"},
           {"targets": -2, "data": "qtde48"},
           {"targets": -3, "data": "qtde24"},
           {"targets": -4, "data": "ds_usuario"}
           

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
        var url = "../controller/grafico_rel_agendamento_controller.php?token="+token+
                "&dt_ini_ag="+$("#dt_ini_ag").val()+
                "&dt_fim_ag="+$("#dt_fim_ag").val()+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&dashboard=1";

        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length-1; i++){
                arrSeries[i] = {name: result.series[i].name, y: result.series[i].data};
                
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
            colors: [
                '#f4f4f6',//sem classificacao
                '#DFF0D8',//produtiva
                '#f68686',//improdutiva
                '#fae98a',//reagendada
                '#e62121'//Cancelado
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
function carregarGraficoAgendadoPor(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_rel_agendado_por_controller.php?token="+token+
                "&dt_ini_ag="+$("#dt_ini_ag").val()+
                "&dt_fim_ag="+$("#dt_fim_ag").val()+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&dashboard=1";
        
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
function carregarGraficoProspeccao(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_produtividade.controller.php?token="+token+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&acao=1";
       
        
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};
                arrColor[i] = result.series[i].color;
            }
            //monta o grafico
           Highcharts.chart('prospeccao', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Prospecções'
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
function carregarGraficoOportunidadesFuturasPizza(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_produtividade.controller.php?token="+token+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&acao=2";
        
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};
                arrColor[i] = result.series[i].color;
            }
            //monta o grafico
           Highcharts.chart('oportunidades_futuras_pizza', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Oportunidades Futuras'
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
function carregarGraficoRetornosRespondidos(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_produtividade.controller.php?token="+token+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&acao=3";
        
        
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};
                arrColor[i] = result.series[i].color;
            }
            //monta o grafico
           Highcharts.chart('retornos_respondidos', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Retornos Respondidos'
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
function carregarGraficoOcorrencia(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_produtividade.controller.php?token="+token+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&acao=4";
        
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};
                arrColor[i] = result.series[i].color;
            }
            //monta o grafico
           Highcharts.chart('ocorrencia', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Ocorrências'
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

function carregarGraficoProcesso(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_produtividade.controller.php?token="+token+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&acao=5";
        
        
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};
                arrColor[i] = result.series[i].color;
            }
            //monta o grafico
           Highcharts.chart('processo', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Processos de Negociação '
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
function carregarGraficoAgendaVisitaPizza(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_produtividade.controller.php?token="+token+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&acao=6";
        
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};
                arrColor[i] = result.series[i].color;
            }
            //monta o grafico
           Highcharts.chart('agenda_visita_pizza', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Agenda de Visitas '
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
function carregarGraficoProposta(){
    
    var arrSeries = [];  
    var arrColor = [];  
        var url = "../controller/grafico_produtividade.controller.php?token="+token+
                "&responsavel_pk="+$("#membro_equipe_pk").val()+
                "&acao=7";
        
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};
                arrColor[i] = result.series[i].color;
            }
            //monta o grafico
           Highcharts.chart('proposta', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Proposta'
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
$(document).ready(function(){
   fcCarregarUsuarioGrupoLogin();
    
    fcCarregarMembroEquipes(); 

    carregarGraficoOportunidadesFuturas();

    fcCarregarGridOportunidadeFuturas();

    fcCarregarGridCarteiraLeadStatus();
    
    carregarGraficoPizzaRetornoPendente();
    
    fcCarregarGridRetornoPendente();
    
    carregarGraficoAgenda();
    
    carregarGraficoAgendadoPor();
    
    carregarGraficoProspeccao();
    
    carregarGraficoOportunidadesFuturasPizza();
    
    carregarGraficoRetornosRespondidos();
    
    carregarGraficoOcorrencia();
    
    carregarGraficoProcesso();
    
    carregarGraficoAgendaVisitaPizza();
    
    carregarGraficoProposta();
    
    
    $('#dt_ini_of').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_ini_of").keypress(function(){
       mascara(this,mdata);
    }); 
    $('#dt_fim_of').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_fim_of").keypress(function(){
       mascara(this,mdata);
    });
     $(document).on('click', '#filtrar_of', function () { 
        carregarGraficoOportunidadesFuturas();
        
        tblOportunidadesFuturas.clear().destroy();
        fcCarregarGridOportunidadeFuturas();
        
        
    } );
    
    
    $('#dt_ini_ag').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_ini_ag").keypress(function(){
       mascara(this,mdata);
    }); 
    $('#dt_fim_ag').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_fim_ag").keypress(function(){
       mascara(this,mdata);
    });
     $(document).on('click', '#filtrar_ag', function () { 
        carregarGraficoAgenda();
    
        carregarGraficoAgendadoPor();
        
    } );
    
   
    $("#membro_equipe_pk").change(function(){
        carregarGraficoOportunidadesFuturas();
        
        tblOportunidadesFuturas.clear().destroy();
        fcCarregarGridOportunidadeFuturas();
        
        tblCarteiraLeadStatus.clear().destroy();
        fcCarregarGridCarteiraLeadStatus();
        
        carregarGraficoPizzaRetornoPendente();
        
        tblRetornoPendente.clear().destroy();
        fcCarregarGridRetornoPendente();
        
        carregarGraficoAgenda();
    
        carregarGraficoAgendadoPor();
        
        carregarGraficoProspeccao();
        
        carregarGraficoOportunidadesFuturasPizza();
        
        carregarGraficoRetornosRespondidos();
        
        carregarGraficoOcorrencia();
        
        carregarGraficoProcesso();
        
        carregarGraficoAgendaVisitaPizza();
        
        carregarGraficoProposta();
    });
    
    
    
    
    fcCarregarGridLeadOperador("");
    abrirGridOc("");
  

});


