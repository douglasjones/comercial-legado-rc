var tblContatos;
var tblProcessos;
var tblDocumentos;
var tblArquivos;

var click_oc = 1;
var click_processo = 1;
var click_documento = 1;

function fcExibirOc(){
    
    if(click_oc %2 == 0) {
        $("#exibir_oc").hide();
    }else{
        tblOcorrencia.clear().destroy();    
        fcCarregarGridOcorrencia();
         $("#exibir_oc").show();
    }
    click_oc++;
        
    
}
function fcExibirProcesso(){
   
    if(click_processo %2 == 0) {
        $("#exibir_processo").hide();
    }else{
        tblProcessos.clear().destroy();    
        fcCarregarGridProcessos();
        $("#exibir_processo").show();
    }
    click_processo++;
}
function fcExibirDocumeto(){
    if(click_documento %2 == 0) {
        $("#exibir_documento").hide();
    }else{
        tblDocumentos.clear().destroy(); 
        fcCarregarGridDocumentos();
        $("#exibir_documento").show();
    }
    click_documento++;  
}

function fcExibirTefelefone(){
    $("#exibir_telefone").show();
    tblTelefone.clear().destroy(); 
    window.setTimeout(function() {
        fcCarregarGridTelefone();
    }, 1000);
    
}
function fcExibirEndereco(){
    $("#exibir_endereco").show();
    
    tblEndereco.clear().destroy();
    window.setTimeout(function() {
        fcCarregarGridEndereco();
    }, 1000);
    

}
function fcExibirContato(){
    $("#exibir_contato").show();
    tblLeadContatos.clear().destroy();
    window.setTimeout(function() {
        fcCarregarGridContato();
    }, 1000);
    
}
function fcExibirOperadoras(){
    $("#exibir_operadoras").show();
    tblLeadOperador.clear().destroy();
    window.setTimeout(function() {
        fcCarregarGridLeadOperador();
    }, 1000);
    
}

function fcCarregarStatus(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregarSemInteresse = carregarController("lead", "listarStatusSemInteresse", objParametros);
        var arrCarregarContactado = carregarController("lead", "listarStatusContactado", objParametros);
        var arrCarregarNaoContactado = carregarController("lead", "listarStatusNaoContactado", objParametros);
        var arrCarregarClassificacao = carregarController("lead", "listarStatus", objParametros);
            
            if(arrCarregarSemInteresse.data[0]['registro'] > 0){
                $(".status_lead").text("Sem Interesse");
            }
            else if(arrCarregarContactado.data[0]['registro']>0){
                $(".status_lead").text("Contactado");
            }
            else if(arrCarregarNaoContactado.data[0]['registro']>0){
                $(".status_lead").text("Não Contactado");
            }
            else if(arrCarregarClassificacao.data[0]['registro']>0){
                $(".status_lead").text(arrCarregarClassificacao.data[0]['ds_classificacao_processo']);
            }
            else{
                $(".status_lead").text("Não Contactado");
            }
            
        
             
    }
}
function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        //NewWindow(v_last_url);
        if (arrCarregar.result == 'success'){
        
            $("#tipo_pessoa_pk").text(arrCarregar.data[0]['tipo_pessoa_pk']);
            $("#ds_lead").text(arrCarregar.data[0]['ds_lead']);
            $("#ds_razao_social").text(arrCarregar.data[0]['ds_razao_social']);
            $("#ds_cpf_cnpj").text(arrCarregar.data[0]['ds_cpf_cnpj']);
            $("#ds_ie").text(arrCarregar.data[0]['ds_ie']);
            $("#ds_rg").text(arrCarregar.data[0]['ds_rg']);
            $("#ds_cnae").text(arrCarregar.data[0]['ds_cnae']);
            $("#ds_cliente").text(arrCarregar.data[0]['ds_cliente']);
            $("#ds_obs").text(arrCarregar.data[0]['ds_obs']);
            $("#ds_site").text(arrCarregar.data[0]['ds_site']);
            $("#ds_polo").text(arrCarregar.data[0]['ds_polo']);
            $("#polos_pk").val(arrCarregar.data[0]['polos_pk']);
            $("#ds_mailing").text(arrCarregar.data[0]['ds_mailing']);
            $("#ciclo_uso").text(arrCarregar.data[0]['ciclo_uso']);
            $("#ds_log").text(arrCarregar.data[0]['ds_log']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
        
             
        fcCarregarSubMenu();
        //RESPONSAVEL
        fcCarregarGridResponsavel(); 
    }
}



function fcCarregarGridResponsavel(){
    
 var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("lead_responsavel", "listarPorLead", objParametros);
   
    //Trata a tabela
    tblResponsavel = $('#tblResponsavel').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           
           {"targets": -2, "data": "ds_usuario"},
           {"targets": -3, "data": "ds_grupo"},
           {"targets": -4, "data": "usuarios_pk","visible":false},
           {"targets": -5, "data": "grupos_pk","visible":false},
           {"targets": -6, "data": "pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblResponsavel tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblResponsavel.row( $(this).parents('li')).data()){
            data = tblResponsavel.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblResponsavel.row( $(this).parents('tr')).data()){
            data = tblResponsavel.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarResponsavel(data);
        
    } );   
    
    $('#tblResponsavel tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblResponsavel.row( $(this).parents('li') ).data()){
            data = tblResponsavel.row( $(this).parents('li') ).data();
        }
        else if(tblResponsavel.row( $(this).parents('tr') ).data()){
            data = tblResponsavel.row( $(this).parents('tr') ).data();
        }
        
        if(data['pk'] != ""){
            fcExcluirResponsavel(data['pk']);
        }
        tblResponsavel.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}

function fcEditarResponsavel(objRegistro){
    var arrCarregar = permissao("responsavel", "upd");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    fcLimparFormResponsavel();
    $("#janela_responsavel").modal();
    $("#lead_responsavel_pk").val("");
    $("#acao").val("upd");
    //Carrega as informações da linha selecionada.
    
    $("#grupos_pk").val(objRegistro['grupos_pk']);
    fcCarregarResponsavel();
    $("#usuarios_pk").val(objRegistro['usuarios_pk']);
    
    
    
    $("#lead_responsavel_pk").val(objRegistro['pk']); 
    
}
function fcLimparFormResponsavel(){
    $("#acao").val("");
    $("#lead_responsavel_pk").val("");
    $("#usuarios_pk").val("");
    $("#grupos_pk").val("");      
}

function fcAbrirFormNovoResponsavel(){
    
    //limpa os dados de qualquer registro existe
    fcLimparFormResponsavel();
    
    $("#janela_responsavel").modal();
    $("#acao").val("ins");
    $("#lead_responsavel_pk").val("");
}

function fcValidarFormResponsavel(){
    
    $("#form_lead_responsavel").validate({
        rules :{
            usuarios_pk:{
                required:true
            },
            grupos_pk:{
                required:true
            }

        },
        messages:{
            usuarios_pk:{
                required:"Por favor, informe Responsável"
            },
            grupos_pk:{
                required:"Por favor, informe Perfil"
            }

        },
        submitHandler: function(form){
            fcEnviarResponsavel(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}

function fcCarregarResponsavel(){
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros); 
    
    carregarComboAjax($("#usuarios_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}

function fcCarregarPerfil(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);    
    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
        
}

function fcExcluirResponsavel(v_pk){
    /* var arrCarregar = permissao("responsavel", "del");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("lead_responsavel", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcBotoesGridResponsavel(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcEnviarResponsavel(){
    fcSalvarResponsavel();
    $("#janela_responsavel").modal("hide");
}

function fcRecarregarGridResponsavel(){
    tblResponsavel.clear().destroy();    
    fcCarregarGridResponsavel();
}

function fcSalvarResponsavel(){
    
    
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#lead_responsavel_pk").val(),
        "leads_pk": pk,
        "usuarios_pk": $("#usuarios_pk").val(),
        "grupos_pk": $("#grupos_pk").val(),
        "polos_pk": $("#polos_pk").val()
    }; 
    var arrEnviar = carregarController("lead_responsavel", "salvar", objParametros);
    if (arrEnviar.result == 'success'){
        fcRecarregarGridResponsavel();
    }    
    else{
        alert(arrEnviar.result);
    }
    
}

function fcCarregarGridProcessos(){
    /*var arrCarregar = permissao("processo", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Não tem permissão de acesso');
        return false;
    }*/
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("processo", "listarProcessoLead", objParametros);
    //Trata a tabela
    tblProcessos = $('#tblProcessos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        //"bProcessing"    : true,
        "aaSorting"      : [],
        "sPaginationType": "full_numbers",
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>\
                                   &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 src='../img/cancelado.png'></span></a>\n\
                                  &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_classificacao"},
           {"targets": -3, "data": "t_ds_processo"},
           {"targets": -4, "data": "t_dt_cancelamento"},
           {"targets": -5, "data": "t_dt_fim"},
           {"targets": -6, "data": "t_dt_inicio"},
           {"targets": -7, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblProcessos tbody').on('click', '.function_painel', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblProcessos.row( $(this).parents('li')).data()){
            data = tblProcessos.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblProcessos.row( $(this).parents('tr')).data()){
            data = tblProcessos.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcMotivoCancelamento(data);
    } );
    //Atribui os eventos na coluna ação.
    $('#tblProcessos tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblProcessos.row( $(this).parents('li')).data()){
            data = tblProcessos.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblProcessos.row( $(this).parents('tr')).data()){
            data = tblProcessos.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        
            fcEditarProcessos(data);
        
    } );   
    
    $('#tblProcessos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblProcessos.row( $(this).parents('li') ).data()){
            data = tblProcessos.row( $(this).parents('li') ).data();
        }
        else if(tblProcessos.row( $(this).parents('tr') ).data()){
            data = tblProcessos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirProcessos(data['t_pk']);
        }
    } ); 
    
}

function fcEditarProcessos(objRegistro){
    if(objRegistro['t_dt_cancelamento']==null){
        var arrCarregar = permissao("processo", "upd");        

        if (arrCarregar.result != 'success'){            
            alert('Não tem permissão de acesso');
            return false;
        }
        sendPost('processo_cad_form.php',{pk: objRegistro['t_pk'], processos_default_pk:objRegistro['processos_default_pk'] ,polos_pk:$("#polos_pk").val(), leads_pk:pk, token:token});

    }    
}

function fcMotivoCancelamento(objRegistro){
    
    if(objRegistro['t_dt_cancelamento']==null){
        $("#motivo_cancelamento_processo_pk").val("");
        $("#ds_motivo_cancelamento").val("");  
        $("#processos_cancelamento_pk").val("");  

        $("#processos_cancelamento_pk").val(objRegistro['t_pk']);
        $("#janela_processos_cancelamento").modal("show");
    }
    
    
}

function fcExcluirProcessos(v_pk){
    var arrCarregar = permissao("processo", "del");        

    if (arrCarregar.result != 'success'){            
        alert('Não tem permissão de acesso');
        return false;
    }
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk,
            "leads_pk": pk
        };              

        var arrExcluir = carregarController("processo", "excluir", objParametros);  
        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            tblProcessos.clear().destroy();    
            fcCarregarGridProcessos();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcCarregarGridDocumentos(){
   /* var arrCarregar = permissao("documento", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("documento", "listarDocumentosLead", objParametros);

    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        //"bProcessing"    : true,
        "aaSorting"      : [],
        "sPaginationType": "full_numbers",
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_nome_original"},
           {"targets": -3, "data": "t_ds_obs"},
           {"targets": -4, "data": "t_ds_documento"},
           {"targets": -5, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblDocumentos tbody').on('click', '.function_edit', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcDownloadDocumento(data['t_pk']);
        }
    });
    $('#tblDocumentos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirDocumento(data['t_pk'],data['t_ds_documento']);
        }
    });
}

function fcDownloadDocumento(file_id){
    var v_url = "../controller/documento.controller.php?job=download&file_id="+encodeURIComponent(file_id)+"&token="+encodeURIComponent(token);
    window.open(v_url, '_blank');
}

function fcExcluirDocumento(v_pk,v_ds_documento){
    var arrCarregar = permissao("documento", "del");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    
    if(v_pk != ""){
        
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("documento", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcExcluirArquivo(v_ds_documento);
            tblDocumentos.clear().destroy();    
            fcCarregarGridDocumentos();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}
function fcEditarLead(){
    sendPost('lead_cad_form.php',{token: token, pk: pk,editar:1});
}

function fcIncluirProcesso(){
    $("#processos_pk").val("");
    $("#janela_processos").modal();
}

function fcCarregarProcessos(){
    //Carrega os grupos
    
    var objParametros = {
        "polos_pk": $("#polos_pk").val()
    };      
    
    var arrCarregar = carregarController("processo_default", "listarPorPolosPk", objParametros);    
   
    carregarComboAjax($("#processos_pk"), arrCarregar, " ", "pk", "ds_processo_default");
    
}

function fcValidarFormProcessos(){
    $("#form_processo").validate({
        rules :{
            processos_pk:{
                required:true
            }

        },
        messages:{
            processos_pk:{
                required:"Por favor, selecione Processo"
            }

        },
        submitHandler: function(form){
            fcEnviarProcesso(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}

function fcEnviarProcesso(){
    
    
    //Carrega os grupos
    var v_processos_pk = $("#processos_pk").val();
    var v_polos_pk = $("#polos_pk").val();
    
    var objParametros = {
        "pk": v_processos_pk,
        "leads_pk": pk,
        "polos_pk":v_polos_pk,
        "motivo_cancelamento_processo_pk":$("#motivo_cancelamento_processo_pk").val(),
        "processos_cancelamento_pk":$("#processos_cancelamento_pk").val(),
        "ds_motivo_cancelamento":$("#ds_motivo_cancelamento").val()
    };      
    var arrEnviar = carregarController("processo", "salvar", objParametros);   
    
    
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        $("#janela_processos").modal("hide");
        $("#janela_processos_cancelamento").modal("hide");
        
        if($("#motivo_cancelamento_processo_pk").val()!=""){
            tblProcessos.clear().destroy();    
            fcCarregarGridProcessos();
        }
        else{
           sendPost("processo_cad_form.php", {token: token,polos_pk:$("#polos_pk").val(), pk:arrEnviar.data[0]['pk'], processos_default_pk:arrEnviar.data[0]['processos_default_pk'], leads_pk: pk}); 
        }
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
    
}

function fcCarregarComboMotivoCancelamento(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("ocorrencia", "ListarMotivosSemInterre", objParametros);    
    carregarComboAjax($("#motivo_cancelamento_processo_pk"), arrCarregar, " ", "pk", "ds_motivo_sem_interesse");
        
}

function fcValidarDocumentos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() == "Nenhum registro encontrado"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    } 
    else{
        fcEnviarDocumento();
    }
    
}
function fcEnviarDocumento(){ 
    
    var strJSONDadosTabela =  fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();
    
    var objParametros = {
        "leads_pk": pk,
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs
    };       
    
    
    var arrEnviar = carregarController("documento", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_documentos").modal("hide");
        alert(arrEnviar.message);
        tblDocumentos.clear().destroy();    
        fcCarregarGridDocumentos();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
           
}

function fcCarregarGridArquivos(){
    tblArquivos = $("#tblArquivos").DataTable(
        { 
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2]
            }],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
            }
        }   
    );
    return false;
}
//COMEÇO DOCUMENTOS UPLOAD

function fcAlterarNomeArquivo(v_arquivo){    
    
    var objParametros = {
        "leads_pk": pk,
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivo", objParametros);  
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#ds_documento").html(arrEnviar.data[0]['t_ds_nome_salvo']);
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }    
}

function fcApagarArquivo(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').click(function () {
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivo(nome_arquivo);
    });
    
    tblArquivos.row($(this).parents('tr')).remove().draw();
}

function fcCancelarEnvioDocumento(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
            var colunas = $(this).children();
            nome_arquivo = $(colunas[0]).text();
            fcExcluirArquivo(nome_arquivo);
        });
}


function fcExcluirArquivo(v_nome_arquivo){
    var objParametros = {
        "nome_arquivo": v_nome_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "removerArquivo", objParametros);           
           
    if(arrEnviar.result == 'success'){
        
    }
}
function fcIncluirLinhaArquivo(nome_original){
    tblArquivos.row.add(
            [$("#ds_documento").html(),
             nome_original,
             "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcApagarArquivo);
    return false;
}


function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}
$(function () {
   
    $('#fileupload').fileupload({
        
        dataType: 'json',
        done: function (e, data) {
            window.setTimeout('Reset()', 2000);
            if(data.result && data.result.result === "success" && data.result.data && data.result.data.length > 0){
                var uploaded = data.result.data[0];
                $("#ds_nome_original").html(uploaded.ds_nome_original);
                $("#ds_documento").html(uploaded.ds_documento);
                fcIncluirLinhaArquivo(uploaded.ds_nome_original);
            } else {
                alert("Falha ao subir o arquivo");
            }
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },            
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width', progress + '%');
        }
    });
});

function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}

function fcFormatarDadosArquivos(){

    var dsDocumento = "";
    var dsNomeOriginal = "";
    
    var arrKeys = [];
    arrKeys[0] = "ds_documento";
    arrKeys[1] = "ds_nome_original";
    
    var arrDados = [];
        var i = 0;
        $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
            dsDocumento =  $(colunas[0]).text(); 
            dsNomeOriginal = $(colunas[1]).text();
            
            
            arrDados[i] = [dsDocumento, dsNomeOriginal];
            i++;
        });
       
    return arrayToJson(arrKeys, arrDados);
    
}

function fcAbrirFormNovoDocumento(){
    tblArquivos.clear().destroy(); 
    fcCarregarGridArquivos();
   
    $("#janela_documentos").modal();
    $("#ds_obs_doc").val("");
}


function fcCarregarComboEquipe(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("equipe", "listarTodos", objParametros);   
    carregarComboAjax($("#agenda_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
        
}

function fcCarregarComboUsuario(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}


function fcVoltar(){
    if(agenda==1){
        sendPost("agenda_res_form.php", {token: token});
    }
    else if (agenda==2){
         sendPost("agenda_retorno_res_form.php", {token: token});
        
    }
    else if (agenda==3){
         sendPost("dashboard_supervisor_res_form.php", {token: token});
        
    }
    else{
        sendPost("lead_res_form.php", {token: token});
    }
    
    
}

function fcCarregarSubMenu(){

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
$(document).ready(function()
    {
       
        var arrCarregar = permissao("lead_main", "cons");        
        if (arrCarregar.result != 'success'){            
            alert('Você não tem permissão');
            return false;
        }
        //Carrega os dados do lead
        fcCarregar();
      
        //fcCarregarStatus();
        
        $(document).on('click', '#cmdEditarLead', fcEditarLead); 
        
        $(document).on('click', '#cmdVoltar', fcVoltar);
        var arrCarregarR = permissao("responsavel", "ins");       

        if (arrCarregarR.result == 'success'){            
            $(document).on('click', '#btn_modal', fcAbrirFormNovoResponsavel);
        } 

        fcCarregarPerfil();

        $("#grupos_pk").change(function(){
            fcCarregarResponsavel();
        });
        fcValidarFormResponsavel();
               
        //carrega dados da grid de processos
        fcCarregarComboMotivoCancelamento();
        fcValidarFormProcessos();
        fcCarregarProcessos();

        $(document).on('click', '#cmdIncluirProcesso', fcIncluirProcesso); 
        fcCarregarGridArquivos();     
        $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);          
        $(document).on('click', '#cmdCancelarDocumento', fcCancelarEnvioDocumento); 
           
        $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos); 
        
        fcCarregarGridDocumentos();
        fcCarregarGridProcessos();
                
 
        $("#loader").hide();
        
        
        $("#exibir").show();
      
    }
);
