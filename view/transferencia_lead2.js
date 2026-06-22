var tblResultado;
var selectedLeads = {};
var transferenciaLeadContext = window.transferenciaLeadContext || {};
var transferenciaLeadWarnings = window.transferenciaLeadWarnings || [];

try{
    if (window.sessionStorage){
        var transferenciaLeadContextStorage = window.sessionStorage.getItem("transferencia_lead_context");
        if (transferenciaLeadContextStorage){
            transferenciaLeadContext = $.extend({}, JSON.parse(transferenciaLeadContextStorage), transferenciaLeadContext);
        }
    }
}
catch(e){
    console.warn("Transferencia Lead: falha ao restaurar contexto do sessionStorage.", e);
}

function getContextValue(chave, valorPadrao){
    if (typeof transferenciaLeadContext[chave] === "undefined" || transferenciaLeadContext[chave] === null){
        return valorPadrao;
    }

    return transferenciaLeadContext[chave];
}

function fcLogarContextoTransferencia(){
    if (transferenciaLeadWarnings.length > 0){
        console.warn("Transferencia Lead: contexto incompleto detectado.", transferenciaLeadWarnings);
    }
}

function getStatusMeta(statusId){
    var meta = {
        "0": "Sem status",
        "1": "25%",
        "2": "50%",
        "3": "75%",
        "4": "Cliente"
    };

    return meta[statusId] || "";
}

function getFiltroTransferencia(){
    return {
        "polos_pk": getContextValue("polos_pk", ""),
        "ds_razao_social": getContextValue("ds_razao_social", ""),
        "ic_status_1": getContextValue("ic_status_1", "0"),
        "ic_status_2": getContextValue("ic_status_2", "0"),
        "ic_status_3": getContextValue("ic_status_3", "0"),
        "ic_status_4": getContextValue("ic_status_4", "0"),
        "grupos_pk": getContextValue("grupos_pk", ""),
        "usuarios_pk": getContextValue("usuarios_pk", ""),
        "tipo_pessoa_pk": getContextValue("tipo_pessoa_pk", ""),
        "mailing_pk": getContextValue("mailing_pk", ""),
        "operador_pk": getContextValue("operador_pk", ""),
        "classificacao_operador_pk": getContextValue("classificacao_operador_pk", ""),
        "tempo_contrato_ini": getContextValue("tempo_contrato_ini", ""),
        "tempo_contrato_fim": getContextValue("tempo_contrato_fim", ""),
        "qtde_linhas_ini": getContextValue("qtde_linhas_ini", ""),
        "qtde_linhas_fim": getContextValue("qtde_linhas_fim", "")
    };
}

function getSelectedLeadsPk(){
    var arrSelected = [];

    $(".lead-transfer-checkbox:checked").each(function(){
        arrSelected.push($(this).val());
    });

    return arrSelected;
}

function atualizarResumoSelecionados(){
    var totalSelecionados = getSelectedLeadsPk().length;
    $("#totalSelecionados").text(totalSelecionados);
}

function atualizarMarcadorGeral(statusId){
    var $checkboxes = $("#box_consulta_" + statusId + " .lead-transfer-checkbox");
    var total = $checkboxes.length;
    var selecionados = $checkboxes.filter(":checked").length;

    $("#selecionar_todos_" + statusId).prop("checked", total > 0 && total === selecionados);
}

function montarGridLeads(statusId, leads){
    var dsStatus = getStatusMeta(statusId);
    var strRetorno = "";

    strRetorno += "<div class='row' id='box_consulta_" + statusId + "'>";
    strRetorno += "    <div class='col-md-12'>";
    strRetorno += "        <div class='modal-content' style='padding: 15px; margin-top: 15px;'>";
    strRetorno += "            <div class='row'>";
    strRetorno += "                <div class='col-md-6'><h5>Leads para transferir - " + dsStatus + "</h5></div>";
    strRetorno += "                <div class='col-md-6 text-right'><button type='button' class='btn btn-link cmdSelecionarTodos' data-status='" + statusId + "'>Selecionar todos</button></div>";
    strRetorno += "            </div>";
    strRetorno += "            <div class='table-responsive'>";
    strRetorno += "                <table class='table table-sm table-bordered'>";
    strRetorno += "                    <thead>";
    strRetorno += "                        <tr>";
    strRetorno += "                            <th width='8%' class='text-center'><input type='checkbox' class='selecionar-todos-grid' id='selecionar_todos_" + statusId + "' data-status='" + statusId + "'></th>";
    strRetorno += "                            <th width='8%'>PK</th>";
    strRetorno += "                            <th>Razão Social</th>";
    strRetorno += "                            <th width='16%'>CNPJ</th>";
    strRetorno += "                            <th width='14%'>Tempo Contrato</th>";
    strRetorno += "                            <th width='14%'>Qtde. Linhas</th>";
    strRetorno += "                        </tr>";
    strRetorno += "                    </thead>";
    strRetorno += "                    <tbody>";

    for(var i = 0; i < leads.length; i++){
        var checked = selectedLeads[leads[i]['pk']] ? " checked" : "";
        var dsCpfCnpj = leads[i]['ds_cpf_cnpj'] == null ? "" : leads[i]['ds_cpf_cnpj'];
        var tempoContrato = leads[i]['tempo_contrato_pk'] == null || leads[i]['tempo_contrato_pk'] === "" ? "" : leads[i]['tempo_contrato_pk'] + " meses";
        var qtdeLinhas = leads[i]['ds_qtde_voz'] == null ? "" : leads[i]['ds_qtde_voz'];

        strRetorno += "                    <tr>";
        strRetorno += "                        <td class='text-center'><input type='checkbox' class='lead-transfer-checkbox' data-status='" + statusId + "' value='" + leads[i]['pk'] + "'" + checked + "></td>";
        strRetorno += "                        <td>" + leads[i]['pk'] + "</td>";
        strRetorno += "                        <td>" + leads[i]['ds_lead'] + "</td>";
        strRetorno += "                        <td>" + dsCpfCnpj + "</td>";
        strRetorno += "                        <td>" + tempoContrato + "</td>";
        strRetorno += "                        <td>" + qtdeLinhas + "</td>";
        strRetorno += "                    </tr>";
    }

    strRetorno += "                    </tbody>";
    strRetorno += "                </table>";
    strRetorno += "            </div>";
    strRetorno += "        </div>";
    strRetorno += "    </div>";
    strRetorno += "</div>";

    return strRetorno;
}

function fcConsultarLeads(){
    var statusId = $(this).attr("data-status");
    var qtdeConsulta = $("#qtde_transferencia_" + statusId).val();

    if(qtdeConsulta == "" || Number(qtdeConsulta) <= 0){
        alert("Informe a quantidade para consultar.");
        return false;
    }

    var objParametros = getFiltroTransferencia();
    objParametros["status_consulta"] = statusId;
    objParametros["qtde_consulta"] = qtdeConsulta;

    var arrCarregar = carregarController("transferencia_lead", "listarLeadsTransferencia", objParametros);
    $("#box_consulta_" + statusId).remove();

    if (arrCarregar.result == 'success'){
        if(arrCarregar.data.length > 0){
            $("#leadsConsultaContainer").append(montarGridLeads(statusId, arrCarregar.data));
            atualizarResumoSelecionados();
        }
        else{
            alert("Nenhum lead encontrado para esta consulta.");
        }
    }
    else{
        alert("Falhar ao carregar o registro");
    }
}

function fcCarregarGrid(){
    var strRetorno = "";
    var strNenhumRegisto = "";
    var objParametros = getFiltroTransferencia();
    var arrCarregar = carregarController("transferencia_lead", "listarQtdeLead", objParametros);

    if (arrCarregar.result == 'success'){
        if(arrCarregar.data.length > 0){
            var n_qtde_registros = "";
            var ds_classificacao = "";

            strRetorno += "<div class='container'><div class='modal-content' style='box-shadow: 10px 10px 5px grey;'><div class='row'>&nbsp;</div>";
            strRetorno += "<div class='row'>";
            strRetorno += "<div class='col-md-1'>&nbsp;</div>";

            for(j = 0; j < arrCarregar.data.length; j++){
                n_qtde_registros = arrCarregar.data[j]['qtde_registros'];
                ds_classificacao = arrCarregar.data[j]['ds_classificacao'];

                if(ds_classificacao == null){
                    strRetorno += "<div class='col-md-4'>";
                    strRetorno += "<label><b>Sem status:</b>&nbsp;&nbsp; Total= " + n_qtde_registros + "&nbsp;&nbsp;</label>";
                    strRetorno += "<div class='form-inline'>";
                    strRetorno += "<input class='form-control-sm col-sm-3' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_0'>";
                    strRetorno += "<button type='button' class='btn btn-link cmdConsultarLeads' data-status='0'>Consultar</button>";
                    strRetorno += "</div>";
                    strRetorno += "</div>";
                }
                if(ds_classificacao == "25%"){
                    strRetorno += "<div class='col-md-4'>";
                    strRetorno += "<label><b>" + ds_classificacao + ":</b>&nbsp;&nbsp; Total= " + n_qtde_registros + "&nbsp;&nbsp;</label>";
                    strRetorno += "<div class='form-inline'>";
                    strRetorno += "<input class='form-control-sm col-sm-3' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_1'>";
                    strRetorno += "<button type='button' class='btn btn-link cmdConsultarLeads' data-status='1'>Consultar</button>";
                    strRetorno += "</div>";
                    strRetorno += "</div>";
                }
                if(ds_classificacao == "50%"){
                    strRetorno += "<div class='col-md-4'>";
                    strRetorno += "<label><b>" + ds_classificacao + ":</b>&nbsp;&nbsp; Total= " + n_qtde_registros + "&nbsp;&nbsp;</label>";
                    strRetorno += "<div class='form-inline'>";
                    strRetorno += "<input class='form-control-sm col-sm-3' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_2'>";
                    strRetorno += "<button type='button' class='btn btn-link cmdConsultarLeads' data-status='2'>Consultar</button>";
                    strRetorno += "</div>";
                    strRetorno += "</div>";
                }
                if(ds_classificacao == "75%"){
                    strRetorno += "<div class='col-md-4'>";
                    strRetorno += "<label><b>" + ds_classificacao + ":</b>&nbsp;&nbsp; Total= " + n_qtde_registros + "&nbsp;&nbsp;</label>";
                    strRetorno += "<div class='form-inline'>";
                    strRetorno += "<input class='form-control-sm col-sm-3' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_3'>";
                    strRetorno += "<button type='button' class='btn btn-link cmdConsultarLeads' data-status='3'>Consultar</button>";
                    strRetorno += "</div>";
                    strRetorno += "</div>";
                }
                if(ds_classificacao == "Cliente"){
                    strRetorno += "<div class='col-md-4'>";
                    strRetorno += "<label><b>" + ds_classificacao + ":</b>&nbsp;&nbsp; Total= " + n_qtde_registros + "&nbsp;&nbsp;</label>";
                    strRetorno += "<div class='form-inline'>";
                    strRetorno += "<input class='form-control-sm col-sm-3' onkeypress='mascara(this,soNumeros)' type='text' id='qtde_transferencia_4'>";
                    strRetorno += "<button type='button' class='btn btn-link cmdConsultarLeads' data-status='4'>Consultar</button>";
                    strRetorno += "</div>";
                    strRetorno += "</div>";
                }
            }

            strRetorno += "</div>";
            strRetorno += "<div class='row'><div class='col-md-1'>&nbsp;</div><div class='col-md-10'><hr><div><b>Leads selecionados:</b> <span id='totalSelecionados'>0</span></div><div id='leadsConsultaContainer'></div></div></div>";
            strRetorno += "<hr><br>";
            strRetorno += "<div class='row'>&nbsp;</div>";
            strRetorno += "<div class='row'><div class='col-md-5'>&nbsp;</div>";
            strRetorno += "<div class='col-md'><b>Transferir para:</b></div></div>";
            strRetorno += "<div class='row'>&nbsp;</div>";
            strRetorno += "<div class='row'><div class='col-md-2'>&nbsp;</div>";
            strRetorno += "<div class='col-md-4'><label for='grupos_pk'>Perfil: </label><select class='form-control form-control-sm' id='grupos_pk' name='grupos_pk'><option></option></select></div>";
            strRetorno += "<div class='col-md-4'><label for='usuarios_pk'>Responsável: </label><select class='form-control form-control-sm' id='usuarios_pk' name='usuarios_pk'><option></option></select></div></div>";
            strRetorno += "<div class='row'>&nbsp;</div>";
            strRetorno += "<div class='row'>&nbsp;</div>";
            strRetorno += "<div class='row'><div class='col-md-4'> &nbsp;</div><div class='col-md-8' align='right'><button type='button' class='btn btn-link' id='cmdEnviarTransferencia'><i class='fa fa-arrow-right' aria-hidden='true' style='font-size: 15px;'> Transferir</i></button></div></div>";
            strRetorno += "</div></div>";
        }
    }
    else{
        alert('Falhar ao carregar o registro');
    }

    if(strRetorno != ""){
        $("#grid").append(strRetorno);
    }
    else{
        strNenhumRegisto += "<div class='row'>";
        strNenhumRegisto += "<div class='col-md-12 text-center'>";
        strNenhumRegisto += "<h3><b>Nenhum Registro Encontrado</b></h3>";
        strNenhumRegisto += "</div>";
        strNenhumRegisto += "</div>";
        $("#grid").append(strNenhumRegisto);
    }
}

function fcCarregarPerfil(){
    var objParametros = {
        "pk": getContextValue("grupos_pk", "")
    };

    var arrCarregar = carregarController("grupo", "listarPk", objParametros);
    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
}

function fcCarregarResponsavel(){
    var objParametros = {
        "pk": "",
        "grupos_pk": $("#grupos_pk").val()
    };

    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros);
    carregarComboAjax($("#usuarios_pk"), arrCarregar, " ", "pk", "ds_usuario");
}

function fcSelecionarTodos(){
    var statusId = $(this).attr("data-status");
    $("#box_consulta_" + statusId + " .lead-transfer-checkbox").prop("checked", true).trigger("change");
}

function fcSelecionarTodosGrid(){
    var statusId = $(this).attr("data-status");
    var checked = $(this).is(":checked");

    $("#box_consulta_" + statusId + " .lead-transfer-checkbox").prop("checked", checked).trigger("change");
}

function fcControleSelecaoLead(){
    var leadPk = $(this).val();
    var statusId = $(this).attr("data-status");

    if($(this).is(":checked")){
        selectedLeads[leadPk] = true;
    }
    else{
        delete selectedLeads[leadPk];
    }

    atualizarResumoSelecionados();
    atualizarMarcadorGeral(statusId);
}

function fcRealizarTransferencia(){
    var arrSelected = getSelectedLeadsPk();

    if(arrSelected.length == 0){
        alert("Selecione ao menos um lead para transferir.");
        return false;
    }

    var objParametros = getFiltroTransferencia();
    objParametros["usuarios_pk"] = getContextValue("usuarios_pk", "");
    objParametros["responsavel_pk"] = $("#usuarios_pk").val();
    objParametros["grupo_responsavel"] = $("#grupos_pk").val();
    objParametros["selected_leads_pk"] = arrSelected.join(",");

    var arrEnviar = carregarController("transferencia_lead", "transferirLead", objParametros);

    if (arrEnviar.result == 'success'){
        alert("Lead transferido com sucesso !!!");
        sendPost('menu_administracao.php', {token: token });
    }
    else{
        alert(arrEnviar.result);
    }
    return true;
}

$(document).ready(function(){
    fcLogarContextoTransferencia();
    $(document).on('click', '#cmdEnviarTransferencia', fcRealizarTransferencia);
    $(document).on('click', '.cmdConsultarLeads', fcConsultarLeads);
    $(document).on('click', '.cmdSelecionarTodos', fcSelecionarTodos);
    $(document).on('change', '.selecionar-todos-grid', fcSelecionarTodosGrid);
    $(document).on('change', '.lead-transfer-checkbox', fcControleSelecaoLead);

    fcCarregarGrid();
    fcCarregarPerfil();

    $(document).on('change', '#grupos_pk', function(){
        fcCarregarResponsavel();
    });
});
