
var tblOcorrencia;
var click = 1 ;
function fcCarregarGridOcorrencia(){   
    var objParametros = {
        "leads_pk": pk
    };     
    var v_url = montarUrlController("ocorrencia", "listarOcorrenciaProcessoLead", objParametros);
    
    //Trata a tabela
    tblOcorrencia = $('#tblOcorrencia').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        "aaSorting"      : [],
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
            
           {"targets": -2, "data": "t_dt_termino_retorno"}, 
           {"targets": -3, "data": "t_ds_retorno"},
           {"targets": -4, "data": "t_dt_retorno"},
           {"targets": -5, "data": "t_agendado_para"},
           {"targets": -6, "data": "t_dt_fechamento"}, 
           {"targets": -7, "data": "t_nome_usuario_cadastro"},
           {"targets": -8, "data": "t_ds_ocorrencia"},
           {"targets": -9, "data": "t_tipos_ocorrencias_pk" ,"visible":false},
           {"targets": -10, "data": "t_ds_tipo_ocorrencia"},
           {"targets": -11, "data": "t_dt_cadastro"}, 
           {"targets": -12, "data": "t_pk"} 

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblOcorrencia tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblOcorrencia.row( $(this).parents('li') ).data()){
            data = tblOcorrencia.row( $(this).parents('li') ).data();
        }
        else if(tblOcorrencia.row( $(this).parents('tr') ).data()){
            data = tblOcorrencia.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirOcorrencia(data['t_pk']);
        }
    } );
    
    $('#tblOcorrencia tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblOcorrencia.row( $(this).parents('li')).data()){
            data = tblOcorrencia.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblOcorrencia.row( $(this).parents('tr')).data()){
            data = tblOcorrencia.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarOcorrencia(data);        
    } ); 
}

function fcAbrirFormNovaOcorrencia(){

    $('#tipo_ocorrencia_pk').prop('disabled',true);
    $("#ocorrencias_pk").val("");
    $("#ds_ocorrencia").val("");
    $("#tipo_ocorrencia_pk").val("");
    $('#tipo_ocorrencia_pk').prop('disabled', false);
    $('#dt_fechamento').prop('checked', false);
    $('#motivo_sem_interesse_pk').prop('disabled', false);
    
    //AGENDA RETORNO
    $("#agenda_visible").hide();
    $("#sem_interesse").hide();
    $("#agenda_retorno_pk").val("");
    $("#motivo_sem_interesse_pk").val("");
    $("#ds_motivo_sem_interesse").val("");
    
    $("#edit_agenda_visible").hide();
    $("#agenda_equipe_visible").hide();
    $("#agenda_responsavel_visible").hide();
    $('#agenda_retorno').prop('checked', false);
    $('#agenda_retorno').prop('disabled', true);
    $("#agenda_dt_retorno").val("");
    $("#agenda_hr_retorno").val("");
    $("#agenda_ic_agendar_para").val("");
    $("#agenda_equipes_pk").val("");
    //$("#agenda_responsavel_pk").val("");
    fcCarregarComboUsuario();
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
    $('#n_retorno').prop('checked', false);
    $('#n_retorno').prop('disabled', true);
    
    $("#agenda_ds_retorno").html("");
    
    $("#janela_ocorrencia").modal();
}

function fcEditarOcorrencia(objRegistro){    
   var arrCarregar = permissao("ocorrencia", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    fcAbrirFormNovaOcorrencia();

          
    //Carrega as informações da linha selecionada.
    if(objRegistro['t_dt_fechamento']!=null){
         $("input[id=dt_fechamento]").prop("checked", "true");
         $('#dt_fechamento').prop('disabled', true);
         $("#sem_interesse").hide();
    }
    $("#ocorrencias_pk").val(objRegistro['t_pk']);
    fcCarregarTipoOcorrencia();    
    $("#tipo_ocorrencia_pk").val(objRegistro['t_tipos_ocorrencias_pk']);
    
    //$("select[id=tipo_ocorrencia_pk]").prop("disabled", "true");   
    
    $('#tipo_ocorrencia_pk').prop('disabled', true);
    $("#ds_ocorrencia").val(objRegistro['t_ds_ocorrencia_modal']);
    
    if(objRegistro['t_motivo_sem_interesse_pk']!="" && objRegistro['t_motivo_sem_interesse_pk']!=null){
        $("#sem_interesse").show();
        $('#motivo_sem_interesse_pk').prop('disabled', true);
        $("#motivo_sem_interesse_pk").val(objRegistro['t_motivo_sem_interesse_pk']);
        $("#ds_motivo_sem_interesse").val(objRegistro['t_ds_motivo_sem_interesse']);
    }
    
    //carrega agenda retorno
    fcEditarRetorno(objRegistro['t_pk']); 
}

function fcEditarOcorrenciaCalendario(pk,tipos_ocorrencias_pk,ds_ocorrencia,dt_fechamento){
   /* var arrCarregar = permissao("ocorrencia", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
    fcAbrirFormNovaOcorrencia();
    //carrega agenda retorno
    
    fcEditarRetorno(pk);    
    //Carrega as informações da linha selecionada.
    if('t_dt_fechamento'!=null){
         $("input[id=dt_fechamento]").prop("checked", "true");
         $('#dt_fechamento').prop('disabled', true);
    }
    
    $("#ocorrencias_pk").val(pk);    
    fcCarregarTipoOcorrencia();    
    $("#tipo_ocorrencia_pk").val(tipos_ocorrencias_pk);  
    $('#tipo_ocorrencia_pk').prop('disabled', true);
    $("#ds_ocorrencia").val(ds_ocorrencia);
}


function fcExcluirOcorrencia(v_pk){
    
    var arrCarregar = permissao("ocorrencia", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("ocorrencia", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){
            //Exibe a mensagem
            alert(arrExcluir.message);
            tblOcorrencia.clear().destroy();    
            fcCarregarGridOcorrencia();
        }
        else{
            alert('Você não tem permissão');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}


function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}


//FINAL DOCUMENTOS UPLOAD
function fcEditarRetorno(ocorrencias_pk){
    /*var arrCarregar = permissao("agenda_retorno", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
    if(ocorrencias_pk > 0){

        var objParametros = {
            "ocorrencias_pk": ocorrencias_pk,
            "pk":""
        };        
        
        var arrCarregar = carregarController("retorno", "listarOcorrenciasPk", objParametros);
        if (arrCarregar.result == 'success'){
            if(arrCarregar.data.length > 0){
                
                $("input[id=agenda_retorno]").prop("checked", "true");
                $("input[id=agenda_retorno]").prop("disabled", "true");
                $("#edit_agenda_dt_retorno").html(arrCarregar.data[0]['dt_retorno']);
                $("#edit_agenda_hr_retorno").html(arrCarregar.data[0]['hr_retorno']);          
                $("#agenda_ds_retorno").val(arrCarregar.data[0]['ds_retorno']);
                $('#agenda_ds_retorno').prop('disabled', false);
                $('#dt_termino_retorno').prop('checked', false);
                $("input[id=dt_termino_retorno]").prop("disabled", false);
                
                $("#agenda_retorno_pk").val(arrCarregar.data[0]['pk']);
                
                
                
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                var hh = today.getHours();
                var min = today.getMinutes();
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

                var dtAtual = dd+"/"+mm+"/"+yyyy;
                var str_hora = hh + ':' + min; 
                
                
                
                var strData = arrCarregar.data[0]['dt_retorno'];
                var partesData = strData.split("/");
                var hora1 = arrCarregar.data[0]['hr_retorno'].split(":");
       
                var strDataAgora = dtAtual;
                var partesDataAtual = strDataAgora.split("/");
                var hora2 = str_hora.split(":");



                var data = new Date(partesData[2], partesData[1] - 1, partesData[0], hora1[0], hora1[1]);
                var data_atual = new Date(partesDataAtual[2], partesDataAtual[1] - 1, partesDataAtual[0], hora2[0], hora2[1]);
                
                if(data_atual > data){
                    
                    if(arrCarregar.data[0]['dt_termino_retorno']!=null){
                       $("input[id=n_retorno]").prop("disabled", true);
                      
                    }
                }
                else{
                    if(arrCarregar.data[0]['dt_termino_retorno']!=null){
                        $("input[id=n_retorno]").prop("disabled", true);
                    }
                }
                
                
                                               
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
function fcEditRetornoFechaOC(){
    /*var arrCarregar = permissao("agenda_retorno", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
    if($('#dt_termino_retorno').is(":checked")){         
        $('#dt_fechamento').prop('disabled', false);
        
    }else{               
       $('#dt_fechamento').prop('disabled',true);
       $('#dt_fechamento').prop('checked', false);
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

function fcEnviarOcorrencia(){
   /* var arrCarregar = permissao("ocorrencia", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
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
   
    //Valida retorno 
    //fcValidarFormOcorrenciaRetorno() 
    
    if($("#agenda_retorno_pk").val()!=""){
         v_agenda_equipes_pk = $("#edit_agenda_equipes_pk").val();
         v_agenda_responsavel_pk = $("#edit_agenda_responsavel_pk").val();
         //v_agenda_dt_retorno_termino = $("#dt_retorno_termino").val();
         //v_agenda_hr_retorno_termino = $("#edit_agenda_hr_retorno_termino").val();
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
            "motivo_sem_interesse_pk":$("#motivo_sem_interesse_pk").val(),
            "ds_motivo_sem_interesse":$("#ds_motivo_sem_interesse").val(),
            //"hr_termino_retorno":v_agenda_hr_retorno_termino,
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
            //"hr_termino_retorno":v_agenda_hr_retorno_termino,
            "motivo_sem_interesse_pk":$("#motivo_sem_interesse_pk").val(),
            "ds_motivo_sem_interesse":$("#ds_motivo_sem_interesse").val(),
            "agenda_retorno":v_agenda_retorno,
            "agenda_retorno_pk":$("#agenda_retorno_pk").val()
        };
    }
    
    var arrEnviar = carregarController("ocorrencia", "salvar", objParametros); 
	
    if (arrEnviar.result == 'success'){                
        // Reload datable
        //alert(arrEnviar.message);
        
        
        //verifica se a tabela existe
        if ($("#tblOcorrencia").length){ 
           $("#janela_ocorrencia").modal("hide"); 
            tblOcorrencia.clear().destroy();    
            fcCarregarGridOcorrencia();            
        }
        else if ($("#tblResultado").length){ 
            $("#janela_ocorrencia").modal("hide"); 
            tblResultado.ajax.reload();
        }
        else{
            $("#janela_ocorrencia").modal("hide"); 
            fcCarregar();
        }
        if($("#ds_sem_interesse").val()=="Concorrência outra operadora" || $("#ds_sem_interesse").val()=="Proposta da concorrência valor inferior"){
           $('#janela_ocorrencia').on('hidden.bs.modal', function (e) {
            // do something...
            $("#janela_lead_operador").modal('show');
          })
        }
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
// Validaão de OC 
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
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, "", "pk", "ds_usuario");
    //$("#agenda_responsavel_pk").val(arrCarregar.data[0]['pk']);
        
}
function fcCarregarComboUsuarioTodos(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros); 
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
    //$("#agenda_responsavel_pk").val(arrCarregar.data[0]['pk']);
        
}
function fcCarregarComboSemInteresse(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("ocorrencia", "ListarMotivosSemInterre", objParametros);    
    carregarComboAjax($("#motivo_sem_interesse_pk"), arrCarregar, " ", "pk", "ds_motivo_sem_interesse");
        
}


function fcCarregarFechamentoAutomatico(v_tipo_ocorrencia_pk){
    
    if(v_tipo_ocorrencia_pk > 0){

        var objParametros = {
            "pk": v_tipo_ocorrencia_pk
        };        
        
        var arrCarregar = carregarController("tipo_ocorrencia", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            $("#ic_fechar_ocorrencia_auto").val(arrCarregar.data[0]['ic_fechar_ocorrencia_auto']);
            
            if(arrCarregar.data[0]['ic_fechar_ocorrencia_auto'] == 1){               
                $("input[id=dt_fechamento]").prop("checked", "true");
                $("input[id=dt_fechamento]").prop("disabled", "true");
                //Desabilita o marcador para retorno
                $("#agenda_visible").hide();
                $('#agenda_retorno').prop('checked', false);
                $("input[id=agenda_retorno]").prop("disabled", "true"); 
                //Limpa os dados do retorno
                $("#agenda_retorno_pk").val("");
                $("#edit_agenda_visible").hide();
                $("#agenda_equipe_visible").hide();
                $("#agenda_responsavel_visible").hide();
                $('#agenda_retorno').prop('checked', false);
                $("#agenda_dt_retorno").val("");
                $("#agenda_hr_retorno").val("");
                $("#agenda_ic_agendar_para").val("");
                $("#agenda_equipes_pk").val("");
                $("#agenda_responsavel_pk").val("");
                $("#agenda_ds_retorno").val("");
            }
            else{
                $('#dt_fechamento').prop('checked', false);
                $('#dt_fechamento').prop('disabled', false);                
                $('#agenda_retorno').prop('disabled', false);
            }
            

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
    
}
function fcPegarNomeTipoOc(v_tipo_ocorrencia_pk){
    
    if(v_tipo_ocorrencia_pk > 0){

        var objParametros = {
            "pk": v_tipo_ocorrencia_pk
        };        
        
        var arrCarregar = carregarController("tipo_ocorrencia", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            $("#ds_tipo_ocorrencia").val(arrCarregar.data[0]['ds_tipo_ocorrencia']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
    
}
function  fcPegarNomeMotivoSemInteresse(v_motivo_sem_interesse_pk){
    
    if(v_motivo_sem_interesse_pk > 0){

        var objParametros = {
            "pk": v_motivo_sem_interesse_pk
        };        
        
        var arrCarregar = carregarController("ocorrencia", "ListarMotivosSemInterre", objParametros);
        
        if (arrCarregar.result == 'success'){
            $("#ds_sem_interesse").val(arrCarregar.data[0]['ds_motivo_sem_interesse']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
    
}

function fcMostrarAgendaRetorno(){
    if($('#agenda_retorno').is(":checked")){
        $("#agenda_visible").show();
        $('#dt_fechamento').prop('checked', false);
        $("input[id=dt_fechamento]").prop("disabled", "true");
        ///Deixa Combo usuario marcado        
        $('#ic_usuario').prop('checked', true); 
        $('#ic_usuario').prop('checked', true);
        $('#ic_equipe').prop('checked', false);
        $('#agenda_responsavel_visible').show();
        $('#agenda_equipe_visible').hide();
        
    }
    else{
        $("#agenda_visible").hide();
        $('#dt_fechamento').prop('disabled', false);   
    }
}

function fcAbrirNovoRetorno(){
    $('#dt_termino_retorno').prop('checked', true); 
    fcEnviarOcorrencia();
    setTimeout(function(){
        fcAbrirFormNovaOcorrencia();
    }, 3000);
   
}

$(document).ready(function(){ 
    
    $("input[id='dt_termino_retorno']").change(function(){
        if ( this.checked ){
            $('#n_retorno').prop('disabled', false); 
        }
        else{
            $('#n_retorno').prop('disabled', true); 
        }
    });
    $("input[id='n_retorno']").change(function(){
        if ( this.checked ){
            fcAbrirNovoRetorno();
        }
    });
    
    fcCarregarGridOcorrencia();
    
    //CARREGA COMBO USUARIO E EQUIPE AGENDA
    fcCarregarComboEquipe();
    
    
    
    //carrega dados da grid de ocorrencias
   
    
   
    //Valida Campos Ocorrencia
    fcValidarFormOcorrencia();

    //carrega combo
    fcCarregarTipoOcorrencia();  
    
    //SEM INTERESSE
    fcCarregarComboSemInteresse();
    
    var arrCarregar = permissao("ocorrencia", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;   
    }
    $(document).on('click', '#n_retorno', fcAbrirNovoRetorno);
    //var arrCarregar1 = permissao("ocorrencia", "ins");        
        
    //if (arrCarregar1.result == 'success'){            
        $(document).on('click', '#cmdIncluirOcorrencia', fcAbrirFormNovaOcorrencia);
    //}   

    $(document).on('click', '#dt_termino_retorno', fcEditRetornoFechaOC);    
        
 
    
    
    //AGENDA RETORNO
    $(document).on('click', '#agenda_retorno', fcMostrarAgendaRetorno);
    

    //carrega datepicker com a data atual (Agenda)
     $('#agenda_dt_retorno').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#agenda_dt_retorno").keypress(function(){
       mascara(this,mdata);
    });
    $("#agenda_hr_retorno").keypress(function(){
       mascara(this,horamask);
    });               

    $('#edit_agenda_dt_retorno_termino').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#edit_agenda_dt_retorno_termino").keypress(function(){
       mascara(this,mdata);
    });
    $("#edit_agenda_hr_retorno_termino").keypress(function(){
       mascara(this,horamask);
    });

    $("#tipo_ocorrencia_pk").change(function(){
        fcCarregarFechamentoAutomatico($("#tipo_ocorrencia_pk").val());
        fcPegarNomeTipoOc($("#tipo_ocorrencia_pk").val());
        
        if($("#ds_tipo_ocorrencia").val()=="Sem Interesse"){
            $('#sem_interesse').show();
            
            $("#motivo_sem_interesse_pk").change(function(){
                fcPegarNomeMotivoSemInteresse($("#motivo_sem_interesse_pk").val());

                /*if($("#ds_tipo_ocorrencia").val()=="Sem Interesse"){
                    $('#sem_interesse').show();
                }
                else{
                    $('#sem_interesse').hide();
                }*/
            });
        }
        else{
            $('#sem_interesse').hide();
        }
    }); 
    
        $('#agenda_responsavel_pk').click(function(){ 
            if(click==1){
                
                $('#agenda_responsavel_pk').val("");
                fcCarregarComboUsuarioTodos();
            }
            click++;
        });
        
    
    
    //EXIBE O COMBO DE AGENDA DE ROTORNO DE USUARIOS E EQUIPES 
    
    $('#ic_equipe').click(function() {           
        $('#ic_equipe').prop('checked', true);
        $('#ic_usuario').prop('checked', false);
        $('#agenda_responsavel_visible').hide();
        $('#agenda_equipe_visible').show();
    });
    $('#ic_usuario').click(function() { 
        
        $('#ic_usuario').prop('checked', true);
        $('#ic_equipe').prop('checked', false);
        $('#agenda_responsavel_visible').show();
        $('#agenda_equipe_visible').hide();
    });
    $("#edit_agenda_visible").hide();
    
    
    
    
        
   
});
