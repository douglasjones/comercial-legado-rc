function fcAbrirFormNovaOcorrencia(){
    $("#cad_new").hide();
    $('#tipo_ocorrencia_pk').prop('disabled',true);
    $('#tipo_ocorrencia_pk').prop('disabled', false);
    $('#dt_fechamento').prop('checked', false);
    
    //EDIÇÃO AGENDA
    $("#edit_agenda_dt_retorno").html("");
    $('#edit_agenda_responsavel_pk').prop('disabled', false);
    $("#edit_agenda_equipes_pk").val("");
    $("#edit_agenda_dt_retorno").val("");
    $("#edit_agenda_hr_retorno").val("");
    $("input[id=edit_agenda_dt_retorno]").prop("disabled", false);
    $("input[id=edit_agenda_hr_retorno]").prop("disabled", false);
    $('#edit_agenda_equipes_pk').prop('disabled', false);
    $('#n_retorno').prop('checked', false);
    $('#n_retorno').prop('disabled', true);
    $("#edit_agenda_responsavel_pk").val("");
    
    $("#edit_agenda_ds_retorno").html("");
    
    $("#janela_ocorrencia").modal();
}


function fcEditarRetorno(ocorrencias_pk,pk){
    fcAbrirFormNovaOcorrencia();
    $("#ocorrencias_pk").val(ocorrencias_pk);
    
    if(ocorrencias_pk > 0){

        var objParametros = {
            "ocorrencias_pk": ocorrencias_pk,
            "pk":pk
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
                    if(arrCarregar.data[0]['responsavel_pk']==null){
                        fcCarregarComboResponsavelEquipe(" ");
                        $("#edit_agenda_responsavel_pk").val(" ");
                    }
                    else{
                        fcCarregarComboResponsavelEquipe(arrCarregar.data[0]['responsavel_pk']);
                        $("#edit_agenda_responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
                    }
                    
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
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
    
    
}


function fcCarregarComboEquipeEdit(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("equipe", "listarTodos", objParametros);   
    carregarComboAjax($("#edit_agenda_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
    carregarComboAjax($("#agenda_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
        
}

function fcEnviarOcorrencia(){
    
  
    var v_agenda_equipes_pk = "";
    var v_agenda_responsavel_pk = "";
    var v_agenda_dt_retorno = "";
    var v_agenda_hr_retorno = "";
    var v_agenda_ds_retorno = "";
    var v_dt_retorno_termino = 0;
    if($("#agenda_retorno_pk").val()!=""){
         v_agenda_equipes_pk = $("#edit_agenda_equipes_pk").val();
         v_agenda_responsavel_pk = $("#edit_agenda_responsavel_pk").val();
         v_agenda_dt_retorno = $("#edit_agenda_dt_retorno").val();
         v_agenda_hr_retorno = $("#edit_agenda_hr_retorno").val();
         v_agenda_ds_retorno = $("#agenda_ds_retorno").val();
    }else{
        v_agenda_dt_retorno = $("#agenda_dt_retorno").val();
        v_agenda_hr_retorno = $("#agenda_hr_retorno").val();
        v_agenda_equipes_pk = $("#agenda_equipes_pk").val();
        v_agenda_responsavel_pk = $("#agenda_responsavel_pk").val();
        v_agenda_ds_retorno = $("#agenda_ds_retorno").val();
    }
   
 
    
   if($('#dt_termino_retorno').is(":checked")){
        v_dt_retorno_termino = 1;
    }
    else{
        v_dt_retorno_termino = 2;
    }
   
        var objParametros = {      
            
            "ocorrencias_pk": $("#ocorrencias_pk").val(),
            "dt_retorno":v_agenda_dt_retorno,
            "hr_retorno":v_agenda_hr_retorno,
            "equipes_pk":v_agenda_equipes_pk,
            "responsavel_pk":v_agenda_responsavel_pk,
            "ds_retorno":v_agenda_ds_retorno,
            "dt_termino_retorno":v_dt_retorno_termino,
            "pk":$("#agenda_retorno_pk").val()
        };
    
    var arrEnviar = carregarController("retorno", "salvar", objParametros); 
  
    if (arrEnviar.result == 'success'){                
        // Reload datable
        alert(arrEnviar.message);
        $("#janela_ocorrencia").modal("hide"); ;
        fcCarregar();
        
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
          
        },
        messages:{
          
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
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
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
function fcAbrirNewFormOc(){
    $("#agenda_retorno_pk").val("");
    $("#agenda_ds_retorno").html("");
    $('#agenda_dt_retorno').prop('disabled', false); 
    $('#agenda_hr_retorno').prop('disabled', false); 
    $('#agenda_ds_retorno').prop('disabled', false); 
    $("#agenda_dt_retorno").val("");
    $("#agenda_hr_retorno").val("");
    $("#agenda_responsavel_pk").val("");
    $("#agenda_equipes_pk").val("");
    $("#agenda_ds_retorno").val("");
    $('#dt_termino_retorno').prop('checked', false);
    $('#dt_termino_retorno').prop('disabled', false); 
    
    $("#janela_ocorrencia").modal();
}
function fcAbrirNovoRetorno(){
    $('#dt_termino_retorno').prop('checked', true); 
    fcEnviarOcorrencia();
    setTimeout(function(){
        fcAbrirNewFormOc();
        $("#cad_new").show();
        $("#edit_agenda_visible").hide();
    }, 2000);
   
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

    $(document).on('click', '#dt_termino_retorno', fcEditRetornoFechaOC);    
    //AGENDA RETORNO

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

    $('#edit_agenda_dt_retorno').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#edit_agenda_dt_retorno").keypress(function(){
       mascara(this,mdata);
    });
    $("#edit_agenda_hr_retorno").keypress(function(){
       mascara(this,horamask);
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
    $("#cad_new").hide();
    
    //CARREGA COMBO USUARIO E EQUIPE AGENDA
    fcCarregarComboEquipe();
    
    fcCarregarComboUsuario();
    
   
    //Valida Campos Ocorrencia
    fcValidarFormOcorrencia();
  
   
});
