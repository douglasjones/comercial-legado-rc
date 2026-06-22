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
    
    
    fcCarregarInformacoesAgenda();
 
    fcCarregarGridRetorno();
    
    fcValidarFormOcorrencia();
    
    carregarGraficoCarteiraLeadStatus();
    
    carregarGraficoOportunidadesFuturas();
    
    fcCarregarGridLead();
    
    fcCarregarGridLeadOperador("");
    
  

});


