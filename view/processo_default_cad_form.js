var tblEtapas;
function fcValidarForm(){
    
    $("#form").validate({
        rules :{
            polos_pk:{
                required:true
            },
            ds_processo_default:{
                required:true,
                minlength:3
            }
        },
        messages:{
            polos_pk:{
                required:"Por favor, informe Polo"             
            },
            ds_processo_default:{
                required:"Por favor, informe Processo",
                minlength:"Processo deve ter pelo menos 3 caracteres"
            }
        },
        submitHandler: function(form){
            
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){
    
    var v_polos_pk = $("#polos_pk").val();   
    var v_ds_processo_default = $("#ds_processo_default").val();
    var v_ic_status = $("#ic_status").val();
   
    var strJSONDadosTabela = fcFormatarDadosEtapa();
    var objParametros = {
        "pk": pk,
        "polos_pk": (v_polos_pk),
        "ds_processo_default": (v_ds_processo_default),
        "ic_status": (v_ic_status),       
        "arrProcessoEtapa": (strJSONDadosTabela)        
    };    

    var arrEnviar = carregarController("processo_default", "salvar", objParametros); 
    if (arrEnviar.result == 'success'){
        //Reload datable
    
        sendPost("processo_default_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("processo_default_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("processo_default", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_processo_default").val(arrCarregar.data[0]['ds_processo_default']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#polos_pk").val(arrCarregar.data[0]['polos_pk']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
        
        //fcAtualizarDadosGrid();
    }
}

function fcFormatarGrid(){
        
    tblEtapas = $("#tblEtapas").DataTable({
       "scrollX": false,
        "responsive": false,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "ordering": false,
        "columnDefs" : [
            {   
                "targets": 0,
                "data": "t1"
            },
            
            {   
                "targets": 1,
                "data": "t2"
            },            
            {   
                "targets": 2,
                "data": "t3"
            },            
            {   
                "targets": 3,
                "data": "t4"
            },            
            {   
                "targets": 4,
                "data": "t5"
            },
            {   
                "targets": 5,
                "data": "t6"
            },
            {   
                "targets": 6,
                "data": "t7"
            },
            {   
                "targets": 7,
                "data": "t8"
            },
            {   
                "targets": 8,
                "data": "t9",
                "defaultContent": "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            }        
        ],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    
    return false;
    
}

function fcIncluirEtapa(){    
    tblEtapas.row.add(
    {   
        "t1":"<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,soNumeros )' id='n_ordem_etapa' />",
        "t2":"<input type='text' class='form-control form-control-sm' id='ds_processo_default_etapa' />",
        "t3":"<select id='classificacao_processo_etapa_pk' class='form-control form-control-sm' name='classificacao_processo_etapa_pk'><option value=''></option><option value='1'>25%</option><option value='2'>50%</option><option value='3'>75%</option><option value='5'>80%</option><option value='6'>90%</option><option value='4'>Cliente</option></select>",
        "t4":strComboTipoOcorrencia,
        "t5":"<select id='ic_ev_email_responsavel' class='form-control form-control-sm' name='ic_ev_email_responsavel'><option value=''></option><option value='1'>Sim</option><option value='2'>Não</option></select>",
        "t6":"<select id='ic_ev_email_lead' class='form-control form-control-sm' name='ic_ev_email_lead'><option value=''></option><option value='1'>Sim</option><option value='2'>Não</option></select>",
        "t7":strComboGrupo,
        "t8": "<input type='text' class='form-control form-control-sm' id='ds_email_saida' />",
        "t9":"<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
    }            
    ).draw( false );
    
   $(".function_delete").on("click",fcExcluirLinha);
    
    return false;
}
function fcAtualizarDadosGrid(){
    
    var v_url = "../controller/processo_default_etapa.controller.php?job=listarProcessoDefaultPk&token="+token+"&processo_default_pk="+pk;

    var request = $.ajax({
        url:          v_url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    
    request.done(function(output){
        if (output.result == 'success'){
            for(i = 0; i < output.data.length; i++){
                //Adiciona a linha.
                fcIncluirEtapa();
                //Pega as variaveis 
                var cboDsProcessoDefaultEtapa = $("input[id='ds_processo_default_etapa']");
                var intOrdem = $("input[id='n_ordem_etapa']");
                var cboclassificacao_processo_etapa_pk = $("select[id='classificacao_processo_etapa_pk']");
                var cbotipo_ocorrencia_pk = $("select[id='tipos_ocorrencias_pk']");
                
                var ic_ev_email_responsavel = $("select[id='ic_ev_email_responsavel']");
                var ic_ev_email_lead = $("select[id='ic_ev_email_lead']");
                var cboemail_saida_grupos_pk = $("select[id='email_saida_grupos_pk']");
                var ds_email_saida = $("input[id='ds_email_saida']");

                cboDsProcessoDefaultEtapa.get(i).value = output.data[i]['t_ds_processo_default_etapa'];
                intOrdem.get(i).value = output.data[i]['t_n_ordem_etapa'];
                cboclassificacao_processo_etapa_pk.get(i).value = output.data[i]['t_classificacao_processo_etapa_pk'];
                cbotipo_ocorrencia_pk.get(i).value = output.data[i]['t_tipo_ocorrencia_pk'];
                
                
                ic_ev_email_responsavel.get(i).value = output.data[i]['t_ic_ev_email_responsavel'];
                ic_ev_email_lead.get(i).value = output.data[i]['t_ic_ev_email_lead'];
                cboemail_saida_grupos_pk.get(i).value = output.data[i]['t_email_saida_grupos_pk'];
                ds_email_saida.get(i).value = output.data[i]['t_ds_email_saida'];
                
                
            }
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });    
    
}
function fcExcluirLinha(){
    
    tblEtapas.row($(this).parents('tr')).remove().draw();
    
    return false;
}

function fcFormatarDadosEtapa(){
    var StringDsProcessoDefaultEtapa = $("input[id='ds_processo_default_etapa']");
    var IntOrdemEtapa = $("input[id='n_ordem_etapa']");
    var cboclassificacao_processo_etapa_pk = $("select[id='classificacao_processo_etapa_pk']");
    var cbotipo_ocorrencia_pk = $("select[id='tipos_ocorrencias_pk']");
    
    var ic_ev_email_responsavel = $("select[id='ic_ev_email_responsavel']");
    var ic_ev_email_lead = $("select[id='ic_ev_email_lead']");
    var cboemail_saida_grupos_pk = $("select[id='email_saida_grupos_pk']");
    var ds_email_saida = $("input[id='ds_email_saida']");
    
    var arrKeys = [];
    arrKeys[0] = "ds_processo_default_etapa";
    arrKeys[1] = "n_ordem_etapa";
    arrKeys[2] = "classificacao_processo_etapa_pk";
    arrKeys[3] = "tipos_ocorrencias_pk";
    
    arrKeys[4] = "ic_ev_email_responsavel";
    arrKeys[5] = "ic_ev_email_lead";
    arrKeys[6] = "email_saida_grupos_pk";
    arrKeys[7] = "ds_email_saida";
     
    var arrDados = [];  
    
    for(i = 0; i < StringDsProcessoDefaultEtapa.length; i++){
        
        if(StringDsProcessoDefaultEtapa.get(i).value == ""){
            StringDsProcessoDefaultEtapa.get(i).focus();
            return false;
        }
        
        
        arrDados[i] = [StringDsProcessoDefaultEtapa.get(i).value,
            IntOrdemEtapa.get(i).value,
            cboclassificacao_processo_etapa_pk.get(i).value,
            cbotipo_ocorrencia_pk.get(i).value,
            ic_ev_email_responsavel.get(i).value,
            ic_ev_email_lead.get(i).value,
            cboemail_saida_grupos_pk.get(i).value,
            ds_email_saida.get(i).value
        ];
        
    }
    
    return arrayToJson(arrKeys, arrDados);
    
}
function fcCarregarPolo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros); 

    carregarComboAjax($("#polos_pk"), arrCarregar, "", "pk", "ds_polo");
        
}


function carregarListaCombo(){

    var url = '../controller/tipo_ocorrencia.controller.php?job=listarTodos&token='+token;
    
    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            strComboTipoOcorrencia = "<select id='tipos_ocorrencias_pk' class='form-control form-control-sm' name='tipos_ocorrencias_pk'><option></option>";
            for(i = 0; i < output.data.length; i++){
                strComboTipoOcorrencia = strComboTipoOcorrencia + "<option value='"+output.data[i]['pk']+"'>"+output.data[i]['ds_tipo_ocorrencia']+"</option>";
            }
            strComboTipoOcorrencia += "</select>";
            
            //Carrega os dados no combo.
           
            
            fcFormatarGrid();
            
            fcAtualizarDadosGrid();
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}

function carregarListaComboGrupo(){

    var url = '../controller/grupo.controller.php?job=listarTodos&token='+token;
    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            strComboGrupo = "<select id='email_saida_grupos_pk' class='form-control form-control-sm' name='email_saida_grupos_pk'><option></option>";
            for(i = 0; i < output.data.length; i++){
                strComboGrupo = strComboGrupo + "<option value='"+output.data[i]['pk']+"'>"+output.data[i]['ds_grupo']+"</option>";
            }
            strComboGrupo += "</select>";
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}

$(document).ready(function()
    {
        var arrCarregar = permissao("processo_default", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
        $(document).on('click', '#cmdIncluir', fcIncluirEtapa);
         carregarListaComboGrupo();
        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        fcCarregarPolo();
        
        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
        
        //Carrega os dados no combo.
        //fcFormatarGrid();
        
        carregarListaCombo();
        
       
        
        
        
    }
);
