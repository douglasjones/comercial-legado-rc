var tblResultado;
var click_id = 0;
function fcCarregarGrid(){
    
    
    var strRetorno = "";
    var strNenhumRegisto = "";
        var objParametros = {
            "ds_lead": ds_lead,
            "polos_pk":polos_pk,
            "tipos_ocorrencias_pk": tipos_ocorrencias_pk,
            "ic_status": ic_status,
            "usuario_cadastro_pk": usuario_cadastro_pk,
            "dt_cadastro": dt_cadastro,
            "dt_cadastro_fim": dt_cadastro_fim
            
        };         
        var arrCarregar = carregarController("ocorrencia", "listarDataTableGrid", objParametros);
   
        
        if (arrCarregar.result == 'success'){
            
            if(arrCarregar.data.length > 0){
                var t_dt_termino_retorno= " "; 
                var t_ds_retorno= " ";
                var t_dt_retorno= " ";
                var t_agendado_para= " ";
                var t_dt_fechamento= " "; 
                var t_nome_usuario_cadastro= " ";
                var t_ds_ocorrencia= " ";
                var t_ds_tipo_ocorrencia= " ";           
                var t_dt_cadastro= " ";           
                var t_ds_lead= " ";
                var t_pk = " ";

                strRetorno+="<div class='row'><div class='col-md-12'>";
                strRetorno+="<table class='table table-striped table-bordered tblResultado' style='width:100%' id='tblResultado'>";
                strRetorno+="<thead><tr>";
                strRetorno+="<th width='10%'>Cod</th><th width='10%'>Lead</th><th width='5%'>Dt. Cadastro</th><th width='5%'>Tipo Oc.</th><th width='5%'>Ocorrência</th>";
                strRetorno+="<th width='10%'>Usuário Cad.</th><th width='10%'>Dt. Fechamento</th><th width='10%'>Agendado para</th><th width='10%'>Dt. Retorno</th>";
                strRetorno+="<th width='10%'>Descrição retorno</th><th width='10%'>Dt. Termino</th>";
                strRetorno+="</tr></thead>";
                strRetorno+="<tbody>";
                for(j=0; j < arrCarregar.data.length ;j++){
                    
                    t_dt_termino_retorno= arrCarregar.data[j]['t_dt_termino_retorno'];
                    t_ds_retorno= arrCarregar.data[j]['t_ds_retorno'];
                    if(arrCarregar.data[j]['t_agendado_para']!=null){
                        t_agendado_para= arrCarregar.data[j]['t_agendado_para'];
                    }
                    else{
                        t_agendado_para= " ";
                    }
                    if(arrCarregar.data[j]['t_dt_retorno']!=null){
                        t_dt_retorno= arrCarregar.data[j]['t_dt_retorno'];
                    }
                    else{
                        t_dt_retorno= " ";
                    }
                    if(arrCarregar.data[j]['t_dt_termino_retorno']!=null){
                      t_dt_termino_retorno= arrCarregar.data[j]['t_dt_termino_retorno'];
                    }
                    else{
                        t_dt_termino_retorno= " ";
                    }
                    
                    t_dt_fechamento= arrCarregar.data[j]['t_dt_fechamento'];
                    t_nome_usuario_cadastro= arrCarregar.data[j]['t_nome_usuario_cadastro'];
                    t_ds_ocorrencia= arrCarregar.data[j]['t_ds_ocorrencia'];
                    t_ds_tipo_ocorrencia= arrCarregar.data[j]['t_ds_tipo_ocorrencia'];    
                    t_dt_cadastro= arrCarregar.data[j]['t_dt_cadastro'];     
                    t_ds_lead = arrCarregar.data[j]['t_ds_lead'];
                    t_pk = arrCarregar.data[j]['t_pk'];
                    
                    
                    

                    strRetorno+="<tr>";
                    strRetorno+="<td width='10%'>"+t_pk+"</td>";
                    strRetorno+="<td width='10%'>"+t_ds_lead+"</td>";
                    strRetorno+="<td width='5%'>"+t_dt_cadastro+"</td>";
                    strRetorno+="<td width='5%'>"+t_ds_tipo_ocorrencia+"</td>";
                    strRetorno+="<td width='5%'>"+t_ds_ocorrencia+"</td>";
                    strRetorno+="<td width='10%'>"+t_nome_usuario_cadastro+"</td>";
                    strRetorno+="<td width='10%'>"+t_dt_fechamento+"</td>";
                    strRetorno+="<td width='10%'>"+t_agendado_para+"</td>";
                    strRetorno+="<td width='10%'>"+t_dt_retorno+"</td>";
                    strRetorno+="<td width='10%'>"+t_ds_retorno+"</td>";
                    strRetorno+="<td width='10%'>"+t_dt_termino_retorno+"</td>";
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

    sendPost("rel_ocorrencia_pesq.php", {token: token});
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
function fcCarregarTipoOcorrencia(){
    if(tipos_ocorrencias_pk > 0){
        var objParametros = {
            "pk": tipos_ocorrencias_pk,
        };      

        var arrCarregar = carregarController("tipo_ocorrencia", "listarPk", objParametros);    
        $("#ds_tipo_ocorrencia").text(arrCarregar.data[0]['ds_tipo_ocorrencia']);
       
    }
    
        
}
function fcCarregarUsuarioCadastro(){
    if(usuario_cadastro_pk > 0){
        var objParametros = {
            "pk": usuario_cadastro_pk,
        };      

        var arrCarregar = carregarController("usuario", "listarPk", objParametros);    
        $("#ds_usuario_cadastro").text(arrCarregar.data[0]['ds_usuario']);
       
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
    fcCarregarUsuarioCadastro();
    fcCarregarTipoOcorrencia();
    
    
    
    
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
    $("#dt_cadastro").text(dt_cadastro);
    $("#dt_cadastro_fim").text(dt_cadastro_fim);
    $("#ds_lead").text(ds_lead);
    if(ic_status==1){
        $("#ds_status").text("Aberto");
    }
    else if(ic_status==2){
        $("#ds_status").text("Fechado");
    }
}

$(document).ready(function(){ 
    /*var arrCarregar = permissao("funil_venda", "cons");        

    if (arrCarregar.result != 'success'){            
         alert('Você não tem Permissão');
        return false;
    }*/
    
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
           
    fcCarregarCabecalho();    
    fcCarregarGrid();

});


