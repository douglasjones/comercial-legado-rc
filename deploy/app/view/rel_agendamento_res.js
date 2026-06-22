var tblResultado;
var click_id = 0;
function fcCarregarGrid(){
    
   
    var strRetorno = "";
    var strNenhumRegisto = "";
        var objParametros = {
            "polos_pk":polos_pk,
            "ds_razao_social":ds_razao_social,
            "tipos_agendas_pk":tipos_agendas_pk,
            "ic_status_1":ic_status_1,
            "ic_status_2":ic_status_2,
            "ic_status_3":ic_status_3,
            "dt_agenda_ini":dt_agenda_ini,
            "dt_agenda_fim":dt_agenda_fim,
            "dt_visita_ini":dt_visita_ini,
            "dt_visita_fim":dt_visita_fim,
            "mailing_pk":mailing_pk,
            "responsavel_pk":responsavel_pk,
            "grupos_pk":grupos_pk
            
        };    
        var arrCarregar = carregarController("agenda_visita", "relatorioAgendamento", objParametros); 
        
        if (arrCarregar.result == 'success'){
            
            if(arrCarregar.data.length > 0){
                var agenda_pk = "";
                var ds_tipo_evento = "";
                var data_agenda = "";
                var data_cadastro = "";
                var ds_lead = "";
                var ds_razao_social_agenda = "";
                var ds_cpf_cnpj = "";
                var ds_cidade = "";
                var ds_usuario_cadastro = "";
                var ds_responsavel = "";
                var tipo_agenda = "";
                var ds_obs = "";
                var ds_status = "";

                strRetorno+="<div class='row'><div class='col-md-12'>";
                strRetorno+="<table class='table table-striped table-bordered tblResultado' style='width:100%' id='tblResultado'>";
                strRetorno+="<thead><tr>";
                strRetorno+="<th width='5%'>Cód</th><th width='10%'>Agendamento</th><th width='10%'>Data cadastro</th><th width='10%'>Data Visita</th><th width='10%'>Lead</th>";
                strRetorno+="<th width='10%'>Razão Social</th><th width='10%'>CPF/CNPJ</th><th width='10%'>Cidade</th><th width='10%'>Agendado por</th>";
                strRetorno+="<th width='10%'>Responsavel</th><th width='10%'>Tipo</th>";
                strRetorno+="<th width='10%'>Descrição</th><th width='10%'>Status</th>";
                strRetorno+="</tr></thead>";
                strRetorno+="<tbody>";
                for(j=0; j < arrCarregar.data.length ;j++){

                    agenda_pk = arrCarregar.data[j]['t_pk'];
                    ds_tipo_evento = arrCarregar.data[j]['t_ds_tipo_evento'];
                    data_agenda = arrCarregar.data[j]['t_dt_agenda'];
                    data_cadastro = arrCarregar.data[j]['t_dt_cadastro'];
                    ds_lead = arrCarregar.data[j]['t_ds_lead'];
                    ds_razao_social_agenda = arrCarregar.data[j]['t_ds_razao_social'];
                    //cpf/cnpj
                    if(arrCarregar.data[j]['t_ds_cpf_cnpj']!=null){
                        ds_cpf_cnpj = arrCarregar.data[j]['t_ds_cpf_cnpj'];
                    }
                    else{
                        ds_cpf_cnpj = "";
                    }
                    //responsavel
                    if(arrCarregar.data[j]['t_ds_responsavel']!=null){
                        ds_responsavel = arrCarregar.data[j]['t_ds_responsavel'];
                    }
                    else{
                        ds_responsavel = "";
                    }
                    //descrição
                    if(arrCarregar.data[j]['t_ds_obs']!=null){
                        ds_obs = arrCarregar.data[j]['t_ds_obs'];
                    }
                    else{
                        ds_obs = "";
                    }
                    //status
                    if(arrCarregar.data[j]['t_ds_status']!=null){
                        ds_status = arrCarregar.data[j]['t_ds_status'];
                    }
                    else{
                        ds_status = "";
                    }
                    
                    ds_cidade = arrCarregar.data[j]['t_ds_cidade'];
                    ds_usuario_cadastro = arrCarregar.data[j]['t_ds_usuario_cadastro'];
                    
                    tipo_agenda = arrCarregar.data[j]['t_ds_tipo_agenda'];
                    
                    

                    strRetorno+="<tr>";
                    strRetorno+="<td width='5%'>"+agenda_pk+"</td>";
                    strRetorno+="<td width='10%'>"+ds_tipo_evento+"</td>";
                    strRetorno+="<td width='10%'>"+data_cadastro+"</td>";
                    strRetorno+="<td width='10%'>"+data_agenda+"</td>";
                    strRetorno+="<td width='10%'>"+ds_lead+"</td>";
                    strRetorno+="<td width='10%'>"+ds_razao_social_agenda+"</td>";
                    strRetorno+="<td width='10%'>"+ds_cpf_cnpj+"</td>";
                    strRetorno+="<td width='10%'>"+ds_cidade+"</td>";
                    strRetorno+="<td width='10%'>"+ds_usuario_cadastro+"</td>";
                    strRetorno+="<td width='10%'>"+ds_responsavel+"</td>";
                    strRetorno+="<td width='10%'>"+tipo_agenda+"</td>";
                    strRetorno+="<td width='10%'>"+ds_obs+"</td>";
                    strRetorno+="<td width='10%'>"+ds_status+"</td>";
                    strRetorno+="</tr>";
                }
                strRetorno+="</tbody>";
                strRetorno+="</table>";
                strRetorno+="</div>";
                strRetorno+="</div>";
                strRetorno+="<hr><br>";
            }
            
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    
    
    if(strRetorno!=""){
        $("#grid").append(strRetorno);
        $("#qtde_registro").text("Total: "+arrCarregar.data.length);
    }
    else{
        
        strNenhumRegisto+="<div class='row'>";
        strNenhumRegisto+="<div class='col-md-12 text-center'>";
        strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
        strNenhumRegisto+=" </div>";
        strNenhumRegisto+="</div>";
        $("#grid").append(strNenhumRegisto);
    }
    
}


function fcCancelar(){

    sendPost("rel_agendamento_pesq.php", {token: token});
}

function fcExport(){

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#form").html() + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "export.xls";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}
function fcCarregarPolo(){
    if(polos_pk > 0){
        var objParametros = {
            "pk": polos_pk
        };      

        var arrCarregar = carregarController("polo", "listarPk", objParametros); 

        $("#ds_polo").text(arrCarregar.data[0]['ds_polo']);
    }
    
        
}
function fcCarregarMailing(){
    if(mailing_pk > 0){
        var objParametros = {
            "pk": mailing_pk
        };      

        var arrCarregar = carregarController("mailing", "listarPorPk", objParametros); 

        $("#ds_mailing").text(arrCarregar.data[0]['ds_mailing']);
    }
    
        
}
function fcCarregarUsuario(){
        var objParametros = {
            "pk": ""
        };      

        var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 

        $("#ds_usuario_logado").text(arrCarregar.data[0]['ds_usuario']);
    
        
}

function fcCarregarPerfil(){
    if(grupos_pk!=""){
         var objParametros = {
            "pk": grupos_pk
        };      

        var arrCarregar = carregarController("grupo", "listarPk", objParametros); 
        $("#ds_grupo").text(arrCarregar.data[0]['ds_grupo']);
        
    }
   
    
        
}

function fcCarregarResponsavel(){
    if(responsavel_pk!=""){
         var objParametros = {
            "pk": responsavel_pk
        };      

        var arrCarregar = carregarController("usuario", "listarPk", objParametros); 
         $("#ds_responsavel").text(arrCarregar.data[0]['ds_usuario']);
    }
    
    
    
    
        
}
function fcCarregarCabecalho(){
    fcCarregarPolo();
    fcCarregarUsuario();
    fcCarregarPerfil();
    fcCarregarResponsavel();
    //fcCarregarMailing();
    
    
    
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
    var seg = today.getSeconds();
    //data
    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 
    //hora 
    if(hh<10) {
        hh = '0'+hh
    } 

    if(min<10) {
        min = '0'+min
    } 
    if(seg<10) {
        seg = '0'+seg
    } 

    today = dd + '/' + mm + '/' + yyyy + ' '+hh+':'+min+':'+seg;
    
    
    
    $("#dt_emissao").text(today);
    $("#ds_razao_social").text(ds_razao_social);
    $("#dt_agendamento").text(dt_agenda_ini+" - "+dt_agenda_fim);
    $("#dt_visita").text(dt_visita_ini+" - "+dt_visita_fim);
    
    if(tipos_agendas_pk==1){
        $("#ds_tipos_agendas").text("Prospecção");
    }
    else if(tipos_agendas_pk==2){
        $("#ds_tipos_agendas").text("Reunião");
    }
    else if(tipos_agendas_pk==3){
        $("#ds_tipos_agendas").text("Fechamento");
    }
    var strStatus = " ";
    if(ic_status_1==1){
        strStatus += "Produtivo,";
    }
    if(ic_status_2==2){
        strStatus += "Improdutivo,";
    }
    if(ic_status_3==3){
        strStatus += "Reagendado";
    }
    $("#ds_status").text(strStatus);
}

function carregarGraficoAgenda(){
    
    var arrSeries = [];  
        var url = "../controller/grafico_rel_agendamento_controller.php?token="+token+
                "&polos_pk="+polos_pk+
                "&ds_razao_social="+ds_razao_social+
                "&tipos_agendas_pk="+tipos_agendas_pk+
                "&ic_status_1="+ic_status_1+
                "&ic_status_2="+ic_status_2+
                "&ic_status_3="+ic_status_3+
                "&dt_agenda_ini="+dt_agenda_ini+
                "&dt_agenda_fim="+dt_agenda_fim+
                "&mailing_pk="+mailing_pk+
                "&responsavel_pk="+responsavel_pk+
                "&grupos_pk="+grupos_pk;
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length-1; i++){
                arrSeries[i] = {name: result.series[i].name, y: result.series[i].data};
                
            }
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
                "&polos_pk="+polos_pk+
                "&ds_razao_social="+ds_razao_social+
                "&tipos_agendas_pk="+tipos_agendas_pk+
                "&ic_status_1="+ic_status_1+
                "&ic_status_2="+ic_status_2+
                "&ic_status_3="+ic_status_3+
                "&dt_agenda_ini="+dt_agenda_ini+
                "&dt_agenda_fim="+dt_agenda_fim+
                "&mailing_pk="+mailing_pk+
                "&responsavel_pk="+responsavel_pk+
                "&grupos_pk="+grupos_pk;
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

$(document).ready(function(){    
    var arrCarregar = permissao("agendamento", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    
    
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
    
    
    
   
    fcCarregarCabecalho();
    fcCarregarGrid();
    
    carregarGraficoAgenda();
    carregarGraficoAgendadoPor();
    
    

});


