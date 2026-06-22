var tblResultado;
var click_id = 0;
function fcCarregarGrid(){
    
   
    var strRetorno = "";
    var strNenhumRegisto = "";
        var objParametros = {
            "equipes_pk":equipes_pk,
            "polos_pk":polos_pk,
            "ds_lead": ds_lead,
            "leads_pk": leads_pk,
            "grupos_pk":grupos_pk,
            "responsavel_pk":responsavel_pk
            
        };    
        var arrCarregar = carregarController("lead", "RelListarLead", objParametros);
       
        
        if (arrCarregar.result == 'success'){
            
            if(arrCarregar.data.length > 0){
                var cod_lead = "";
                var ds_leads = "";
                var ds_endereco = "";
                var ds_responsavel = "";
                var ds_status = "";

                strRetorno+="<div class='row'><div class='col-md-12'>";
                strRetorno+="<table class='table table-striped table-bordered tblResultado' style='width:100%' id='tblResultado'>";
                strRetorno+="<thead><tr>";
                strRetorno+="<th width='5%'>Cód</th><th width='10%'>Lead</th><th width='10%'>Endereço</th><th width='10%'>Responsavel</th><th width='10%'>Status</th>";
                strRetorno+="</tr></thead>";
                strRetorno+="<tbody>";
                for(j=0; j < arrCarregar.data.length ;j++){

                    cod_lead = arrCarregar.data[j]['t_pk'];
                    ds_leads = arrCarregar.data[j]['t_ds_lead'];
                    ds_endereco = arrCarregar.data[j]['t_ds_endereco'];
                    ds_responsavel = arrCarregar.data[j]['t_ds_responsavel'];
                    ds_status = arrCarregar.data[j]['t_ds_classificacao_processo'];
                    

                    strRetorno+="<tr>";
                    strRetorno+="<td width='5%'>"+cod_lead+"</td>";
                    strRetorno+="<td width='10%'>"+ds_leads+"</td>";
                    strRetorno+="<td width='10%'>"+ds_endereco+"</td>";
                    strRetorno+="<td width='10%'>"+ds_responsavel+"</td>";
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

    sendPost("rel_carteira_pesq.php", {token: token});
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
function fcCarregarEquipe(){
    if(equipes_pk > 0){
        var objParametros = {
            "pk": equipes_pk
        };      

        var arrCarregar = carregarController("equipe", "listarPk", objParametros); 

        $("#ds_equipe").text(arrCarregar.data[0]['ds_equipe']);
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
    fcCarregarEquipe();
    
    
    
    
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
    $("#ds_lead").text(ds_lead);
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

});


