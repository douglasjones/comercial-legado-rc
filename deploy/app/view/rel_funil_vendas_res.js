var tblResultado;
var click_id = 0;
function fcCarregarGrid(){
    
    
    var strRetorno = "";
    var strNenhumRegisto = "";
        var objParametros = {
            "polos_pk": polos_pk,
            "leads_pk": leads_pk,
            "responsavel_pk": responsavel_pk,
            "grupos_pk": grupos_pk,
            "dt_envio_ini": dt_envio_ini,
            "dt_envio_fim": dt_envio_fim,
            "dt_prev_fechamento_ini": dt_prev_fechamento_ini,
            "dt_prev_fechamento_fim": dt_prev_fechamento_fim,
            "dt_fechamento_ini": dt_fechamento_ini,
            "dt_fechamento_fim": dt_fechamento_fim
            
        };         
        var arrCarregar = carregarController("proposta", "relatorioFunilVendas", objParametros);
        
   
        
        if (arrCarregar.result == 'success'){
            
            if(arrCarregar.data.length > 0){
                var ds_lead = "";
                var ds_responsavel = "";
                var processos_pk = "";
                var ds_status = "";
                var qtde_itens = "";
                var vl_total = "";
                var dt_cadastro = "";
                var dt_envio = "";
                var dt_prev_fechamento = "";
                var dt_fechamento = "";
                var dt_validade = "";
                var dt_cancelamento = "";

                strRetorno+="<div class='row'><div class='col-md-12'>";
                strRetorno+="<table class='table table-striped table-bordered tblResultado' style='width:100%' id='tblResultado'>";
                strRetorno+="<thead><tr>";
                strRetorno+="<th width='10%'>Lead</th><th width='10%'>Responsavel</th><th width='5%'>ID Processo</th><th width='5%'>Status</th><th width='5%'>Qtde. Itens</th>";
                strRetorno+="<th width='10%'>Valor Total</th><th width='10%'>Data Cadastro</th><th width='10%'>Data Envio</th><th width='10%'>Data Prev. Fechamento</th>";
                strRetorno+="<th width='10%'>Data Fechamento</th><th width='10%'>Data Validade</th>";
                strRetorno+="<th width='10%'>Data Cancelamento</th>";
                strRetorno+="</tr></thead>";
                strRetorno+="<tbody>";
                for(j=0; j < arrCarregar.data.length ;j++){

                    ds_lead = arrCarregar.data[j]['t_ds_lead'];
                    ds_responsavel = arrCarregar.data[j]['t_ds_responsavel'];
                    processos_pk = arrCarregar.data[j]['t_processos_pk'];
                    ds_status = arrCarregar.data[j]['t_ds_classficacao_processo'];
                    qtde_itens = arrCarregar.data[j]['t_n_qtde'];
                    vl_total = arrCarregar.data[j]['t_vl_total'];
                    dt_cadastro = arrCarregar.data[j]['t_dt_cadastro'];
                    dt_envio = arrCarregar.data[j]['t_dt_envio'];
                    dt_prev_fechamento = arrCarregar.data[j]['t_dt_previsao_fechamento'];
                    dt_fechamento = arrCarregar.data[j]['t_dt_fechamento'];
                    dt_validade = arrCarregar.data[j]['t_dt_validade'];
                    dt_cancelamento = arrCarregar.data[j]['t_dt_cancelamento'];
                   
                    
                    
                    

                    strRetorno+="<tr>";
                    strRetorno+="<td width='10%'>"+ds_lead+"</td>";
                    strRetorno+="<td width='10%'>"+ds_responsavel+"</td>";
                    strRetorno+="<td width='5%'>"+processos_pk+"</td>";
                    strRetorno+="<td width='5%'>"+ds_status+"</td>";
                    strRetorno+="<td width='5%'>"+qtde_itens+"</td>";
                    strRetorno+="<td width='10%'>"+vl_total+"</td>";
                    strRetorno+="<td width='10%'>"+dt_cadastro+"</td>";
                    strRetorno+="<td width='10%'>"+dt_envio+"</td>";
                    strRetorno+="<td width='10%'>"+dt_prev_fechamento+"</td>";
                    strRetorno+="<td width='10%'>"+dt_fechamento+"</td>";
                    strRetorno+="<td width='10%'>"+dt_validade+"</td>";
                    strRetorno+="<td width='10%'>"+dt_cancelamento+"</td>";
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

    sendPost("rel_funil_vendas_pesq.php", {token: token});
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
function fcCarregarLead(){
    if(leads_pk > 0){
        var objParametros = {
            "pk": leads_pk
        };      

        var arrCarregar = carregarController("lead", "listarPk", objParametros); 
        $("#ds_lead").text(arrCarregar.data[0]['ds_lead']);

    }
}

function fcCarregarResponsavel(){
    if(responsavel_pk > 0){
        var objParametros = {
            "pk": responsavel_pk,
        };      

        var arrCarregar = carregarController("usuario", "listarPk", objParametros);    
        $("#ds_responsavel").text(arrCarregar.data[0]['ds_usuario']);
       
    }
    
        
}
function fcCarregarPerfil(){
    if(grupos_pk > 0){
        var objParametros = {
            "pk": grupos_pk,
        };      

        var arrCarregar = carregarController("grupo", "listarPk", objParametros);    
        $("#ds_grupo").text(arrCarregar.data[0]['ds_grupo']);
       
    }
    
        
}
function fcCarregarUsuario(){
        var objParametros = {
            "pk": ""
        };      

        var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 

        $("#ds_usuario_logado").text(arrCarregar.data[0]['ds_usuario']);
    
        
}
function fcCarregarCabecalho(){
    fcCarregarPolo();
    fcCarregarUsuario();
    fcCarregarLead();
    fcCarregarResponsavel();
    fcCarregarPerfil();
    
    
    
    
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
    $("#dt_envio_ini").text(dt_envio_ini);
    $("#dt_envio_fim").text(dt_envio_fim);
    $("#dt_prev_fechamento_ini").text(dt_prev_fechamento_ini);
    $("#dt_prev_fechamento_fim").text(dt_prev_fechamento_fim);
    $("#dt_fechamento_ini").text(dt_fechamento_ini);
    $("#dt_fechamento_fim").text(dt_fechamento_fim);
    
}

$(document).ready(function(){ 
    var arrCarregar = permissao("funil_venda", "cons");        

    if (arrCarregar.result != 'success'){            
         alert('Você não tem Permissão');
        return false;
    }
    
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
           
    fcCarregarCabecalho();    
    fcCarregarGrid();

});


