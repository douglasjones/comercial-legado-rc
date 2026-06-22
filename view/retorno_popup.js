
function fcCarregarGrid(){
      
    var token = $("#t_token").val()

    var objParametros = {
        "ds_lead": 'teste'
    };  
    //var v_url = montarUrlController("retorno", "listarDataTablePopup", objParametros);
    var url = "../controller/retorno.controller.php?job=listarDataTablePopup&token="+token; 

    $.getJSON(url, function(result) {
        for(i = 0; i < result.data.length; i++){
            var tabela = document.getElementById("tblRetorno");
            if (!tabela.rows.length)
                    v_id = 0;
            else
                    v_id = parseInt(tabela.rows[tabela.rows.length - 1].id) + 1;
            
            row = tabela.insertRow(tabela.rows.length);
            row.id = v_id;

            cell = row.insertCell(0);
            cell.innerHTML = "<a href='javascript:abrirMenu1("+result.data[i]['t_leads_pk']+")' >"+result.data[i]['t_ds_lead']+"</a>";
            cell.align = "center";

            cell = row.insertCell(1);
            cell.innerHTML = result.data[i]['t_dt_retorno'];
            cell.align = "center";

            cell = row.insertCell(2);
            cell.innerHTML = result.data[i]['t_dt_retorno'];
            cell.align = "center";

            cell = row.insertCell(3);
            cell.innerHTML = result.data[i]['t_ds_agendado_para'];    
            cell.align = "center";

            cell = row.insertCell(4);
            cell.innerHTML = result.data[i]['t_ds_tipo_ocorrencia'];       
            cell.align = "center";
    
            cell = row.insertCell(5);
            cell.innerHTML = result.data[i]['t_ds_retorno'];
            cell.align = "center";   
        }
     }); 
}
function abrirMenu1(leads_pk){
    var token = $("#t_token").val()
    
    window.opener.sendPost('lead_main_form.php', {token: token,pk:leads_pk});
    window.close();
}
$(document).ready(function()
    {
        
        fcCarregarGrid()
    }
);