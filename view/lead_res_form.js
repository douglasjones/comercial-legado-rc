var tblResultado;
var gUsuarioLogadoPk = "";
var gGrupoLogadoPk = "";
var gUsuarioLogadoNome = "";

function fcRespostaComboValida(arrCarregar){
    return arrCarregar && arrCarregar.result == 'success' && Array.isArray(arrCarregar.data);
}

function fcPreencherComboSeguro(objCombo, arrCarregar, vValorPrimeiroItem, vPk, vDescricao){
    if (!fcRespostaComboValida(arrCarregar)){
        objCombo.empty();
        if (vValorPrimeiroItem !== ""){
            objCombo.append($('<option>', {
                value: "",
                text: vValorPrimeiroItem
            }));
        }
        return false;
    }

    carregarComboAjax(objCombo, arrCarregar, vValorPrimeiroItem, vPk, vDescricao);
    return true;
}

function fcMontarOpcoesCombo(arrDados, vValorPrimeiroItem, vPk, vDescricao){
    var arrHtml = [];

    if (vValorPrimeiroItem !== ""){
        arrHtml.push('<option value="">' + vValorPrimeiroItem + '</option>');
    }

    for (var i = 0; i < arrDados.length; i++){
        arrHtml.push('<option value="' + arrDados[i][vPk] + '">' + arrDados[i][vDescricao] + '</option>');
    }

    return arrHtml.join('');
}

function fcUsuarioEhResponsavel(vResponsavelPk, vUsuarioPk){
    if (!vUsuarioPk){
        return false;
    }
    if (!vResponsavelPk){
        return false;
    }

    var sUsuario = String(vUsuarioPk).trim();
    var sResponsavel = String(vResponsavelPk).trim();

    if (sResponsavel === sUsuario){
        return true;
    }

    var aResponsaveis = sResponsavel.split(',');
    for (var i = 0; i < aResponsaveis.length; i++){
        if (aResponsaveis[i].trim() === sUsuario){
            return true;
        }
    }
    return false;
}

function fcSalvarFiltros() {
    var filtros = {
        "pk": $("#id_lead").val(),
        "ds_lead": $("#ds_lead").val(),
        "polos_pk": $("#polos_pk").val(),
        "ds_razao_social": $("#ds_razao_social").val(),
        "ds_cpf_cnpj": $("#ds_cpf_cnpj").val(),
        "tipo_pessoa_pk": $("#tipo_pessoa_pk").val(),
        "mailing_pk": $("#mailing_pk").val(),
        "grupos_pk": $("#grupos_pk").val(),
        "usuarios_pk": $("#usuarios_pk").val(),
        "status_processo_pk": $("#status_processo_pk").val(),
        "operador_pk": $("#operador_pk").val(),
        "classificacao_operador_pk": $("#classificacao_operador_pk").val(),
        "qtde_linhas_ini": $("#qtde_linhas_ini").val(),
        "qtde_linhas_fim": $("#qtde_linhas_fim").val(),
        "ds_cidade": $("#ds_cidade").val(),
        "tempo_contrato_pk": $("#tempo_contrato_pk").val(),
        "ic_cliente": $("#ic_status").val(),
        "qtde_ult_oc": $("#qtde_ult_oc").val()
    };
    sessionStorage.setItem("lead_filtros", JSON.stringify(filtros));
    sessionStorage.setItem("lead_tabela_visivel", "true");
}

function fcRestaurarFiltros() {
    var filtrosSalvos = sessionStorage.getItem("lead_filtros");
    if (!filtrosSalvos) return false;

    var filtros = JSON.parse(filtrosSalvos);
    for (var chave in filtros) {
        if (filtros.hasOwnProperty(chave) && filtros[chave] !== "") {
            var $campo = $("#" + chave);
            if ($campo.length) {
                $campo.val(filtros[chave]);
            }
        }
    }

    // Se o grupos_pk foi restaurado, carrega o responsavel correspondente
    if (filtros["grupos_pk"] && filtros["grupos_pk"] !== "") {
        fcCarregarResponsavel(filtros["usuarios_pk"] || "");
    }

    return true;
}

function fcPesquisar(){
    var arrCarregar = permissao("lead", "cons");

    if (arrCarregar.result != 'success'){
        alert('Falhar ao carregar o registro');
        return false;
    }

    if ($.fn.DataTable.isDataTable('#tblResultado')){
        $('#tblResultado').DataTable().clear().destroy();
    }

    fcSalvarFiltros();
    fcCarregarGrid();
    $("#tabela_lead").show();

}

function fcIncluir(){
     var arrCarregar = permissao("lead", "ins");

    if (arrCarregar.result != 'success'){
        alert('Falhar ao carregar o registro');
        return false;
    }
    sendPost('lead_cad_form.php',{token: token, pk: '',editar:''});

}

function fcExcluir(v_pk, v_ds_lead,v_resposavel){
        var arrCarregar = permissao("lead", "del");

        if (arrCarregar.result != 'success'){
            alert('Falhar ao carregar o registro');
            return false;
        }
        if (confirm("Deseja realmente excluir o registro '" + v_ds_lead + "'?")){
            if(v_pk != ""){

                var objParametros = {
                    "pk": v_pk
                };

                var arrExcluir = carregarController("lead", "excluir", objParametros);

                if (arrExcluir.result == 'success'){

                    //Exibe a mensagem
                    alert(arrExcluir.message);

                    // Reload datable
                    tblResultado.ajax.reload();

                }
                else{
                    alert('Falhou a requisição de exclusão.');
                }
            }
            else{
                alert("Código não encontrado");
            }
        }
    return false;
}

function fcEditar(v_pk,v_resposavel){
        var arrCarregar = permissao("lead", "upd");

        if (arrCarregar.result != 'success'){
                alert('Falhar ao carregar o registro');
                return false;
        }
         var arrCarregar = permissao("lead", "upd");

        if (arrCarregar.result != 'success'){
            alert('Falhar ao carregar o registro');
            return false;
        }
        sendPost('lead_cad_form.php', {token: token, pk: v_pk,editar:''});

}

function fcCarregarGrid(){
    var arrPermissao = permissao("acessar_todos_lead", "cons");
    var objParametros = {
        "pk": $("#id_lead").val(),
        "ds_lead": $("#ds_lead").val(),
        "polos_pk": $("#polos_pk").val(),
        "ds_razao_social": $("#ds_razao_social").val(),
        "ds_cpf_cnpj": $("#ds_cpf_cnpj").val(),
        "tipo_pessoa_pk": $("#tipo_pessoa_pk").val(),
        "mailing_pk": $("#mailing_pk").val(),
        "ds_processo_pk": $("#ds_processo_pk").val(),
        "processo_default_pk": $("#processo_default_pk").val(),
        "grupos_pk": $("#grupos_pk").val(),
        "usuarios_pk": $("#usuarios_pk").val(),
        //"equipes_pk": $("#equipes_pk").val(),
        "status_processo_pk": $("#status_processo_pk").val(),
        "operador_pk": $("#operador_pk").val(),
        "classificacao_operador_pk": $("#classificacao_operador_pk").val(),
        "qtde_linhas_ini": $("#qtde_linhas_ini").val(),
        "qtde_linhas_fim": $("#qtde_linhas_fim").val(),
        /*"dt_ativacao_ini": $("#dt_ativacao_ini").val(),
        "dt_ativacao_fim": $("#dt_ativacao_fim").val(),
        "dt_vencimento_ini": $("#dt_vencimento_ini").val(),
        "dt_vencimento_fim": $("#dt_vencimento_fim").val(),*/
        "ds_cidade": $("#ds_cidade").val(),
        "tempo_contrato_pk": $("#tempo_contrato_pk").val(),
        "ic_cliente": $("#ic_status").val(),
        //"dt_transf_ini":$("#dt_transf_ini").val(),
        //"dt_transf_fim":$("#dt_transf_fim").val(),
        //"dt_cadastro_ini":$("#dt_cadastro_ini").val(),
        //"dt_cadastro_fim":$("#dt_cadastro_fim").val(),
        "qtde_ult_oc":$("#qtde_ult_oc").val()
    };

    var v_url = montarUrlController("lead", "listarDataTable", objParametros);

   //NewWindow(v_last_url);
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
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
                "defaultContent": "<a class='function_painel'><span><img width=16 height=16 src='../img/painel.png'></span></a>\n\
                                  &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>\
                                  &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
           },
           {"targets": -2, "data": "t_ultcontato"},
           {"targets": -3, "data": "t_ds_status_oc"},
           {"targets": -4, "data": "t_tempo_contrato_pk"},
           {"targets": -5, "data": "t_ds_qtde_voz"},
           {"targets": -6, "data": "t_ds_usuario"},
           {"targets": -7, "data": "t_ds_lead"},
           {"targets": -8, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });


    //Atribui os eventos na coluna ação.




     $('#tblResultado tbody').on('click', '.function_painel', function () {

        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        if(!data){
            alert('Falha ao identificar o registro selecionado.');
            return false;
        }
        fcAbrirPainel(data['t_pk'],data['t_responsavel_pk']);
        /*if(arrPermissao.result == 'success'){
            fcAbrirPainel(data['t_pk'],data['t_responsavel_pk']);
        }else{
            if(fcUsuarioEhResponsavel(data['t_responsavel_pk'], $("#usuario_logado_pk").val())){
                fcAbrirPainel(data['t_pk'],data['t_responsavel_pk']);
            }else{
                $("#alert").fadeTo(3000, 500).slideUp(500, function(){
                    $("#alert").slideUp(500);
                });
            }
        }*/
    } );

    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        if(!data){
            alert('Falha ao identificar o registro selecionado.');
            return false;
        }
        if(arrPermissao.result == 'success'){

            fcEditar(data['t_pk']);
        }
        else{
            if(fcUsuarioEhResponsavel(data['t_responsavel_pk'], $("#usuario_logado_pk").val())){
                fcEditar(data['t_pk'],data['t_responsavel_pk']);
            }else{
                $("#alert").fadeTo(3000, 500).slideUp(500, function(){
                    $("#alert").slideUp(500);
                });
            }

        }
    } );
    $('#tblResultado tbody').on('click', '.function_delete', function () {

        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        if(!data){
            alert('Falha ao identificar o registro selecionado.');
            return false;
        }



        if(arrPermissao.result == 'success'){
            fcExcluir(data['t_pk'], data['t_ds_lead'],data['t_responsavel_pk']);
        }
        else{
            if(fcUsuarioEhResponsavel(data['t_responsavel_pk'], $("#usuario_logado_pk").val())){
                fcExcluir(data['t_pk'], data['t_ds_lead'],data['t_responsavel_pk']);
            }else{
                $("#alert").fadeTo(3000, 500).slideUp(500, function(){
                    $("#alert").slideUp(500);
                });
            }

        }


    } );
}
function fcAbrirPainel(v_pk,v_resposavel){
    fcSalvarFiltros();
    sendPost('lead_main_form.php', {token: token, pk: v_pk,agenda:""});

}

function fcCarregarPolo(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros);

    carregarComboAjax($("#polos_pk"), arrCarregar, "", "pk", "ds_polo");

}
function fcCarregarProcesso(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("processo_default", "listarTodos", objParametros);

    carregarComboAjax($("#processo_default_pk"), arrCarregar, " ", "pk", "ds_processo_default");

}

function fcCarregarMailing(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("mailing", "listarPorContasPk", objParametros);

    carregarComboAjax($("#mailing_pk"), arrCarregar, " ", "pk", "ds_mailing");

}

function fcCarregarPerfil(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);

    if (!fcRespostaComboValida(arrCarregar)){
        fcPreencherComboSeguro($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
        return;
    }

    if(arrCarregar.data.length==1){
        carregarComboAjax($("#grupos_pk"), arrCarregar, "", "pk", "ds_grupo");
    }
    else{
        carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
    }


}

function fcCarregarResponsavel(vUsuarioSelecionado){
    var objCombo = $("#usuarios_pk");
    var vGrupoPk = $("#grupos_pk").val();

    if (!vGrupoPk){
        objCombo.prop("disabled", false).html('<option value=""> </option>');
        return;
    }

    var objParametros = {
        "pk": "",
        "grupos_pk": vGrupoPk
    };
    var vUrl = montarUrlController("usuario", "listarPorGrupo", objParametros);

    objCombo.prop("disabled", true).html('<option value="">Carregando...</option>');

    $.ajax({
        url: vUrl,
        cache: false,
        dataType: 'json',
        contentType: 'application/json; charset=utf-8',
        type: 'post'
    }).done(function(output){
        if (!fcRespostaComboValida(output)){
            if (String(gGrupoLogadoPk) === "2" && gUsuarioLogadoPk && gUsuarioLogadoNome){
                objCombo.html(fcMontarOpcoesCombo([
                    {"pk": String(gUsuarioLogadoPk), "ds_usuario": gUsuarioLogadoNome}
                ], "", "pk", "ds_usuario"));
                objCombo.val(String(gUsuarioLogadoPk));
            }
            else{
                objCombo.html('<option value=""> </option>');
            }
            return;
        }

        if (output.data.length === 0 && String(gGrupoLogadoPk) === "2" && gUsuarioLogadoPk && gUsuarioLogadoNome){
            objCombo.html(fcMontarOpcoesCombo([
                {"pk": String(gUsuarioLogadoPk), "ds_usuario": gUsuarioLogadoNome}
            ], "", "pk", "ds_usuario"));
            objCombo.val(String(gUsuarioLogadoPk));
            return;
        }

        if (output.data.length === 1){
            objCombo.html(fcMontarOpcoesCombo(output.data, "", "pk", "ds_usuario"));
        }
        else{
            objCombo.html(fcMontarOpcoesCombo(output.data, " ", "pk", "ds_usuario"));
        }

        if (vUsuarioSelecionado){
            objCombo.val(String(vUsuarioSelecionado));
        }
    }).fail(function(jqXHR, textStatus){
        objCombo.html('<option value=""> </option>');
        alert('Falha na req: ' + textStatus);
    }).always(function(){
        if (String(gGrupoLogadoPk) === "2"){
            objCombo.prop("disabled", true);
        }
        else{
            objCombo.prop("disabled", false);
        }
    });
}

function fcAplicarFiltroConsultorLogado(){
    if (String(gGrupoLogadoPk) !== "2"){
        return;
    }

    $("#grupos_pk").val(String(gGrupoLogadoPk));
    $("#grupos_pk").prop("disabled", true);
    fcCarregarResponsavel(gUsuarioLogadoPk);
}
function fcCarregarEquipes(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("equipe", "listarTodos", objParametros);
    if(arrCarregar.data.length==1){
        if($("#usuario_logado_pk").val()==2){
            carregarComboAjax($("#equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
        }
        else{
            carregarComboAjax($("#equipes_pk"), arrCarregar, "", "pk", "ds_equipe");
        }

    }
    else{
        carregarComboAjax($("#equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
    }
}

function fcCarregarOperador(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("operador", "listarTodos", objParametros);

    fcPreencherComboSeguro($("#operador_pk"), arrCarregar, " ", "pk", "ds_operador");

}
function fcCarregarCidade(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("endereco", "listarCidade", objParametros);

    fcPreencherComboSeguro($("#ds_cidade"), arrCarregar, " ", "ds_cidade", "ds_cidade");

}

function fcCarregarClassificacaoOperador(){

    var objParametros = {
        "operadoras_pk": $("#operador_pk").val()
    };

    var arrCarregar = carregarController("operador", "listarClassificacaoOPerador", objParametros);

    fcPreencherComboSeguro($("#classificacao_operador_pk"), arrCarregar, " ", "pk", "ds_classificacao");

}

function fcCarregarUsuarioLogin(){


    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros);
    if (fcRespostaComboValida(arrCarregar) && arrCarregar.data.length > 0){
        gUsuarioLogadoPk = arrCarregar.data[0]['pk'];
        gGrupoLogadoPk = arrCarregar.data[0]['grupos_pk'];
        gUsuarioLogadoNome = arrCarregar.data[0]['ds_usuario'];
        $("#usuario_logado_pk").val(gUsuarioLogadoPk);
    }


}
$(document).ready(function(){

    fcCarregarUsuarioLogin();

    fcCarregarPolo();
    fcCarregarMailing();

    //fcCarregarProcesso();

   // fcCarregarEquipes();

    fcCarregarOperador();

    fcCarregarClassificacaoOperador();
    $("#operador_pk").change(function(){
        fcCarregarClassificacaoOperador();
    });
    fcCarregarPerfil();
    fcCarregarCidade();
    $("#usuarios_pk").html('<option value=""> </option>');
    $("#grupos_pk").change(function(){
        fcCarregarResponsavel();
    });
    fcAplicarFiltroConsultorLogado();

    $("#ds_processo_pk").keypress(function(){
        mascara(this,soNumeros);
    });
    $("#qtde_linhas_ini").keypress(function(){
        mascara(this,soNumeros);
    });
    $("#qtde_linhas_fim").keypress(function(){
        mascara(this,soNumeros);
    });
    $("#id_lead").keypress(function(){
        mascara(this,soNumeros);
    });

    /*$('#dt_ativacao_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_ativacao_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_ativacao_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_ativacao_fim").keypress(function(){
       mascara(this,mdata);
    });

    $('#dt_vencimento_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_vencimento_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_vencimento_fim").keypress(function(){
       mascara(this,mdata);
    });

    $('#dt_transf_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_transf_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_transf_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_transf_fim").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_cadastro_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_cadastro_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro_fim").keypress(function(){
       mascara(this,mdata);
    });*/

    $("#ds_cpf_cnpj").keypress(function(){
        chama_mascara(this);
     });

    //faz a carga inicial do grid.

    //Restaura filtros salvos e recarrega a grid se houver
    var filtrosSalvos = sessionStorage.getItem("lead_filtros");
    var tabelaVisivel = sessionStorage.getItem("lead_tabela_visivel");
    if (filtrosSalvos && tabelaVisivel === "true") {
        fcRestaurarFiltros();
        // Aguarda o carregamento dos combos assincronos para pesquisar
        window.setTimeout(function() {
            fcPesquisar();
        }, 1000);
    }

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

    $("#loader").hide();

    $("#exibir").show();
   
});
