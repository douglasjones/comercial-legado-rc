//--------------------------------------------------------SEMANA ATUAL--------------------------------------------------//
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();  

var tblTelefone;
var tblResponsavelLeadAgenda;
var tblLeadContatos;
var tblEndereco;
var tblLeadOperador;

if(dd<10) {
    dd = '0'+dd
} 
if(mm<10) {
    mm = '0'+mm
}   
var dtAtual = dd+'/'+mm+'/'+yyyy;

function fcCarregarSemana(){      
   //RETORNA AS DATAS
    var v_dt_agenda = "01/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
    
    
     
    
    //Separa as datas  dia,mes,ano
    var partesDt_base = v_dt_agenda.split("/");

    
    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
    //0 dia; 1 mes; 2 ano
    
    
    var data_base = new Date(partesDt_base[2], partesDt_base[1] - 1, partesDt_base[0]);
    var nova_data = new Date(partesDt_base[2], partesDt_base[1] - 1, partesDt_base[0]);
    
    //subtrai de acordo com a posicao do dia da semana
    nova_data.setDate(data_base.getDate() - fcPosicaoDataSemana01());
    
    
    //gera a data do começo da semana   
    if(nova_data.getDate() < '10'){
        var dia = '0'+nova_data.getDate() ;
    }else{
        var dia = nova_data.getDate() ;
    }
    
    if(nova_data.getMonth()+1 < '10'){
        var mes = '0'+(nova_data.getMonth()+1);
    }else{
        var mes = +nova_data.getMonth()+1;
    }
    
    var nova_v_dt_agenda = dia+"/"+mes+"/"+nova_data.getFullYear();
    
    if((nova_data.getMonth()+1) <= '8'){
        
        var nova_v_dt_agenda_fim = "31/0"+(nova_data.getMonth()+2)+"/"+nova_data.getFullYear();
        
    }else{
        if((nova_data.getMonth()+1)<='10'){
            var nova_v_dt_agenda_fim = "31/"+(nova_data.getMonth()+3)+"/"+nova_data.getFullYear();
        }
        else{
            if((nova_data.getMonth()+1)==12){
                var nova_v_dt_agenda_fim = "31/01/"+(nova_data.getFullYear()+1);
            }
            else{
                var nova_v_dt_agenda_fim = "31/"+(nova_data.getMonth()+2)+"/"+nova_data.getFullYear();
            }
            
        }
         
    }
    
    
    var colorClassificacao = "background-color:#e0e0e0";  

 // Data e horario atual
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
    var dtCalendario = nova_data.getFullYear()+""+mes+""+dia;
    var str_hora = hh + '' + mm;  

    var tipo_avento_pk = "";

    tipo_avento_pk = $('#calendar_tipo_evento_agenda_pk_0').val();
    
    var arrCarregarEdit = permissao("agenda", "ins"); 
    var arrCarregarReag = permissao("agenda_reagendamento", "ins"); 
    var arrCarregarClass = permissao("agenda_classificacao", "upd");
        if(nova_v_dt_agenda !=""){
            
            fcCarregarQtdeAgendamento(nova_v_dt_agenda,nova_v_dt_agenda_fim,tipo_avento_pk,$("#calendar_agendado_por").val());
            
            var objParametros = {                
                "dt_base": nova_v_dt_agenda,
                "dt_base_fim":nova_v_dt_agenda_fim,
                "tipo_evento_pk":tipo_avento_pk,
                "tipos_agendas_pk":$('#calendar_tipos_agendas_pk').val(),
                "classificacao_agenda_pk":$('#calendar_classificacao_agenda_pk').val(),
                "polos_pk":$('#calendar_polos_pk').val(),  
                "grupos_pk":$('#calendar_grupos_pk').val(),
                "usuarios_pk":$('#calendar_usuarios_pk').val(),
                "usuario_cadastro_pk":$("#calendar_agendado_por").val(),
                "equipes_pk":$("#calendar_equipes_pk").val(),
                "atendente_pk":$("#calendar_atendente_pk").val()
            };   
            var arrCarregar = carregarController("agenda_visita", "listarAgendaVisitaData", objParametros); 
           
            if (arrCarregar.result == 'success'){
                    
                        for(j=0; j < arrCarregar.data.length ;j++){                    
                        var strResultado ="";  
                        var dsResponsavel ="";  
                        var responsavel_pk = 0;
                        if(arrCarregar.data[j]['t_responsavel_pk']!=null){
                            responsavel_pk =  arrCarregar.data[j]['t_responsavel_pk'];
                        }
                 
                        if(arrCarregar.data[j]['t_ic_status']!=null){    
                                if(arrCarregar.data[j]['t_ic_status']==1){
                                    colorClassificacao = "background-color:#DFF0D8";
                                }
                                else if (arrCarregar.data[j]['t_ic_status']==2){
                                    colorClassificacao = "background-color:#f68686";
                                }
                                else if (arrCarregar.data[j]['t_ic_status']==3){
                                    colorClassificacao = "background-color:#fae98a";
                                }
                                else if (arrCarregar.data[j]['t_ic_status']==4){
                                    colorClassificacao = "background-color:#e62121";
                                }

                            }
                            else{                        
                                colorClassificacao = "background-color:";                 
                            }     

                            strResultado += "<div class='modal-content' id='exampleModalLong' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'  >";
                            strResultado += "<div style="+colorClassificacao+">" //color classificaçaõ
                            strResultado += "<div class='modal-body'><div class='row'>";
                            
                            /*if(arrCarregar.data[j]['t_ds_tipo_evento']!= null){ 
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/eventos.png'> Evento: "+arrCarregar.data[j]['t_ds_tipo_evento']+"</label>"; // RESPONSAVEL//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // RESPONSAVEL//        
                            }*/
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> <h5>"+arrCarregar.data[j]['t_hr_agenda_visita']+"</h5></label>"; // Horario do visita//
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> Lead: <a href='javascript:fcCarregarLead("+arrCarregar.data[j]['t_leads_pk']+","+'"'+responsavel_pk+'"'+","+arrCarregar.data[j]['t_usuario_cadastro_pk']+")'> "+arrCarregar.data[j]['t_ds_lead']+" </a></label>";//LEAD
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'>Cód "+arrCarregar.data[j]['t_pk']+"</label>"; // Cod Visita//
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/localizacao.png'> "+arrCarregar.data[j]['t_ds_endereco']+"</a></label>"; // Endereço//                
                            if(arrCarregar.data[j]['t_ds_responsavel']!= null){ 
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/responsavel.png'> Responsável: "+arrCarregar.data[j]['t_ds_responsavel']+"</label>"; // RESPONSAVEL//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // RESPONSAVEL//        
                            }
                            if(arrCarregar.data[j]['t_ds_atendente']!= null){ 
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/tele.png'> Atendente: "+arrCarregar.data[j]['t_ds_atendente']+"</label>"; // RESPONSAVEL//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // RESPONSAVEL//        
                            }
                            if(arrCarregar.data[j]['t_ds_usuario_cadastro']!=null){
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/usuarios.png'>"+arrCarregar.data[j]['t_ds_usuario_cadastro']+"</label>"; // USUARIO CADASTRO//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // USUARIO CADASTRO//        
                            }

                            if(arrCarregar.data[j]['t_ds_obs']!= null){
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'>Descrição: "+arrCarregar.data[j]['t_ds_obs_pagina']+"</label>"; // DESCRIÇÃO//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // DESCRIÇÃO//        
                            }

                            if(arrCarregar.data[j]['t_agenda_reagendamento_pk']!= null){
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/relatorio.png'>ID Reagendamento: "+arrCarregar.data[j]['t_agenda_reagendamento_pk']+"</label>"; // DESCRIÇÃO//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // DESCRIÇÃO//        
                            }
                            
                            
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'>";
                            
                            if (arrCarregarEdit.result != 'success'){
                                strResultado += " ";
                            }
                            else{

                                strResultado += "<a href='javascript:fcEditarAgendaVisitaCalendario("+arrCarregar.data[j]['t_pk']+","
                                              +'"'+responsavel_pk+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_contato']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cel']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_tel']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cargo']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_email']+'"'+","
                                              +arrCarregar.data[j]['t_atendente_pk']+","
                                              +arrCarregar.data[j]['t_usuario_cadastro_pk']+","
                                              +arrCarregar.data[j]['t_tipos_agendas_pk']+","
                                              +arrCarregar.data[j]['t_ic_status']+","
                                              +arrCarregar.data[j]['t_processos_etapas_pk']+","
                                              +arrCarregar.data[j]['t_leads_pk']+","
                                              +arrCarregar.data[j]['t_polos_pk']+","
                                              +arrCarregar.data[j]['t_tipo_evento_pk']+","
                                              +'"'+arrCarregar.data[j]['t_ds_titulo_agenda']+'"'+","
                                              +arrCarregar.data[j]['t_aviso_pk']+","
                                              +'"'+arrCarregar.data[j]['t_dt_reagenda']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_dt_reagenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_hr_reagenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_dt_agenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_hr_agenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cep']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_classificacao_agenda_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_endereco']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_numero']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_complemento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_bairro']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cidade']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_uf']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_motivo_cancelamento_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_motivo_reagendamento_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_cancelamento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_reagendamento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_classificacao']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs']+'"'+")'> <img width=18 height=18 src='../img/copiar.png' ></a>&nbsp;&nbsp;";//editar
                            }
                            


                            if (arrCarregarReag.result != 'success'){ 
                                strResultado += " ";
                            }
                            else{
                                strResultado += "<a href='javascript:fcReagendamentoAgendaVisitaCalendario("+arrCarregar.data[j]['t_pk']+","
                                              +'"'+responsavel_pk+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_contato']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cel']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_tel']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cargo']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_email']+'"'+","
                                              +arrCarregar.data[j]['t_atendente_pk']+","
                                              +arrCarregar.data[j]['t_usuario_cadastro_pk']+","
                                              +arrCarregar.data[j]['t_tipos_agendas_pk']+","
                                              +arrCarregar.data[j]['t_ic_status']+","
                                              +arrCarregar.data[j]['t_processos_etapas_pk']+","
                                              +arrCarregar.data[j]['t_leads_pk']+","
                                              +arrCarregar.data[j]['t_polos_pk']+","
                                              +arrCarregar.data[j]['t_tipo_evento_pk']+","
                                              +'"'+arrCarregar.data[j]['t_ds_titulo_agenda']+'"'+","
                                              +arrCarregar.data[j]['t_aviso_pk']+","
                                              +'"'+arrCarregar.data[j]['t_dt_reagenda']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_dt_reagenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_hr_reagenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_dt_agenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_hr_agenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cep']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_classificacao_agenda_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_endereco']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_numero']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_complemento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_bairro']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cidade']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_uf']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_motivo_cancelamento_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_motivo_reagendamento_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_cancelamento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_reagendamento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_classificacao']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs']+'"'+")'> <img width=18 height=18 src='../img/reagendamento.png' ></a>&nbsp;&nbsp;";//reagendar
                            }


                            if (arrCarregarClass.result != 'success'){
                                strResultado += " ";
                            }
                            else{
                                strResultado += "<a href='javascript:fcClassificacaoAgendaVisitaCalendario("+arrCarregar.data[j]['t_pk']+","
                                              +'"'+responsavel_pk+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_contato']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cel']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_tel']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cargo']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_email']+'"'+","
                                              +arrCarregar.data[j]['t_atendente_pk']+","
                                              +arrCarregar.data[j]['t_usuario_cadastro_pk']+","
                                              +arrCarregar.data[j]['t_tipos_agendas_pk']+","
                                              +arrCarregar.data[j]['t_ic_status']+","
                                              +arrCarregar.data[j]['t_processos_etapas_pk']+","
                                              +arrCarregar.data[j]['t_leads_pk']+","
                                              +arrCarregar.data[j]['t_polos_pk']+","
                                              +arrCarregar.data[j]['t_tipo_evento_pk']+","
                                              +'"'+arrCarregar.data[j]['t_ds_titulo_agenda']+'"'+","
                                              +arrCarregar.data[j]['t_aviso_pk']+","
                                              +'"'+arrCarregar.data[j]['t_dt_reagenda']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_dt_reagenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_hr_reagenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_dt_agenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_hr_agenda_visita']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cep']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_classificacao_agenda_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_endereco']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_numero']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_complemento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_bairro']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_cidade']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_uf']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_motivo_cancelamento_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_motivo_reagendamento_pk']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_cancelamento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_reagendamento']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs_classificacao']+'"'+","
                                              +'"'+arrCarregar.data[j]['t_ds_obs']+'"'+")'> <img width=18 height=18 src='../img/classificacao.png' ></a>&nbsp;&nbsp;";//classificacao
                            }
                            
                            //-----------OCORRENCIA-----------//
                                strResultado += "<a href='javascript:fcCarregarGridOcorrencia("+arrCarregar.data[j]['t_leads_pk']+","+'"'+responsavel_pk+'"'+","+arrCarregar.data[j]['t_usuario_cadastro_pk']+")'><i width=18 height=18 class='fa fa-list' aria-hidden='true'></i></a>&nbsp;&nbsp;";//editar
                           


                            strResultado += "</label>";  
                            strResultado += "</div>";
                            strResultado += "</div>";
                            strResultado += "</div>";
                            strResultado += "</div>";
                        
                        
                        
                       
                        
                        /*for(i=0;i<42;i++){
                            if(i<6){*/
                                if($("#dt_agenda_dom1_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_dom1").html(strResultado+"<br>"+$(".ds_visita_dom1").html());                            
                                }
                                if($("#dt_agenda_seg1_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_seg1").html(strResultado+"<br>"+$(".ds_visita_seg1").html());                            
                                }
                                if($("#dt_agenda_ter1_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_ter1").html(strResultado+"<br>"+$(".ds_visita_ter1").html());                            
                                }
                                if($("#dt_agenda_qua1_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qua1").html(strResultado+"<br>"+$(".ds_visita_qua1").html());                            
                                }
                                if($("#dt_agenda_qui1_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qui1").html(strResultado+"<br>"+$(".ds_visita_qui1").html());                            
                                }
                                if($("#dt_agenda_sex1_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sex1").html(strResultado+"<br>"+$(".ds_visita_sex1").html());                            
                                }
                                if($("#dt_agenda_sab1_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sab1").html(strResultado+"<br>"+$(".ds_visita_sab1").html());                            
                                }
                           /* }
                            if(i>=7 && i<14){*/
                                if($("#dt_agenda_dom2_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_dom2").html(strResultado+"<br>"+$(".ds_visita_dom2").html());                            
                                }
                                if($("#dt_agenda_seg2_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_seg2").html(strResultado+"<br>"+$(".ds_visita_seg2").html());                            
                                }
                                if($("#dt_agenda_ter2_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_ter2").html(strResultado+"<br>"+$(".ds_visita_ter2").html());                            
                                }
                                if($("#dt_agenda_qua2_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qua2").html(strResultado+"<br>"+$(".ds_visita_qua2").html());                            
                                }
                                if($("#dt_agenda_qui2_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qui2").html(strResultado+"<br>"+$(".ds_visita_qui2").html());                            
                                }
                                if($("#dt_agenda_sex2_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sex2").html(strResultado+"<br>"+$(".ds_visita_sex2").html());                            
                                }
                                if($("#dt_agenda_sab2_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sab2").html(strResultado+"<br>"+$(".ds_visita_sab2").html());                            
                                }
                            /*}
                            if(i>=14 && i<21){*/
                                if($("#dt_agenda_dom3_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_dom3").html(strResultado+"<br>"+$(".ds_visita_dom3").html());                            
                                }
                                if($("#dt_agenda_seg3_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_seg3").html(strResultado+"<br>"+$(".ds_visita_seg3").html());                            
                                }
                                if($("#dt_agenda_ter3_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_ter3").html(strResultado+"<br>"+$(".ds_visita_ter3").html());                            
                                }
                                if($("#dt_agenda_qua3_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qua3").html(strResultado+"<br>"+$(".ds_visita_qua3").html());                            
                                }
                                if($("#dt_agenda_qui3_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qui3").html(strResultado+"<br>"+$(".ds_visita_qui3").html());                            
                                }
                                if($("#dt_agenda_sex3_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sex3").html(strResultado+"<br>"+$(".ds_visita_sex3").html());                            
                                }
                                if($("#dt_agenda_sab3_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sab3").html(strResultado+"<br>"+$(".ds_visita_sab3").html());                            
                                }
                            /*}
                            if(i>=21 && i<28){*/
                                if($("#dt_agenda_dom4_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_dom4").html(strResultado+"<br>"+$(".ds_visita_dom4").html());                            
                                }
                                if($("#dt_agenda_seg4_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_seg4").html(strResultado+"<br>"+$(".ds_visita_seg4").html());                            
                                }
                                if($("#dt_agenda_ter4_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_ter4").html(strResultado+"<br>"+$(".ds_visita_ter4").html());                            
                                }
                                if($("#dt_agenda_qua4_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qua4").html(strResultado+"<br>"+$(".ds_visita_qua4").html());                            
                                }
                                if($("#dt_agenda_qui4_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qui4").html(strResultado+"<br>"+$(".ds_visita_qui4").html());                            
                                }
                                if($("#dt_agenda_sex4_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sex4").html(strResultado+"<br>"+$(".ds_visita_sex4").html());                            
                                }
                                if($("#dt_agenda_sab4_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sab4").html(strResultado+"<br>"+$(".ds_visita_sab4").html());                            
                                }
                            /*}
                            if(i>=28 && i<35){*/
                                if($("#dt_agenda_dom5_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_dom5").html(strResultado+"<br>"+$(".ds_visita_dom5").html());                            
                                }
                                if($("#dt_agenda_seg5_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_seg5").html(strResultado+"<br>"+$(".ds_visita_seg5").html());                            
                                }
                                if($("#dt_agenda_ter5_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_ter5").html(strResultado+"<br>"+$(".ds_visita_ter5").html());                            
                                }
                                if($("#dt_agenda_qua5_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qua5").html(strResultado+"<br>"+$(".ds_visita_qua5").html());                            
                                }
                                if($("#dt_agenda_qui5_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qui5").html(strResultado+"<br>"+$(".ds_visita_qui5").html());                            
                                }
                                if($("#dt_agenda_sex5_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sex5").html(strResultado+"<br>"+$(".ds_visita_sex5").html());                            
                                }
                                if($("#dt_agenda_sab5_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sab5").html(strResultado+"<br>"+$(".ds_visita_sab5").html());                            
                                }
                           /* }
                            if(i>36){*/
                                if($("#dt_agenda_dom6_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_dom6").html(strResultado+"<br>"+$(".ds_visita_dom6").html());                            
                                }
                                if($("#dt_agenda_seg6_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_seg6").html(strResultado+"<br>"+$(".ds_visita_seg6").html());                            
                                }
                                if($("#dt_agenda_ter6_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_ter6").html(strResultado+"<br>"+$(".ds_visita_ter6").html());                            
                                }
                                if($("#dt_agenda_qua6_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qua6").html(strResultado+"<br>"+$(".ds_visita_qua6").html());                            
                                }
                                if($("#dt_agenda_qui6_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_qui6").html(strResultado+"<br>"+$(".ds_visita_qui6").html());                            
                                }
                                if($("#dt_agenda_sex6_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sex6").html(strResultado+"<br>"+$(".ds_visita_sex6").html());                            
                                }
                                if($("#dt_agenda_sab6_val").val()==arrCarregar.data[j]['t_dt_agenda_visita']){                            
                                    $(".ds_visita_sab6").html(strResultado+"<br>"+$(".ds_visita_sab6").html());                            
                                }
                            //}
                        //}
                        
                }
            }
            else{
                alert('Falhar ao carregar o registro');
            }
        } 
}


function fcLimparVariaveisSemana(){
    var strResultado =" ";
    
    for(i=1;i<7;i++){
         //DOMINGO                     
        $(".ds_visita_dom"+i).html("");
        $("#dt_agenda_dom"+i).html("").css("color", "");

        //SEGUNDA
        $(".ds_visita_seg"+i).html("");
        $("#dt_agenda_seg"+i).html("").css("color", "");
       //TERÇA
        $(".ds_visita_ter"+i).html("");
        $("#dt_agenda_ter"+i).html("").css("color", "");

        //QUARTA
        $(".ds_visita_qua"+i).html("");
        $("#dt_agenda_qua"+i).html("").css("color", "");

        //QUINTA
        $(".ds_visita_qui"+i).html("");
        $("#dt_agenda_qui"+i).html("").css("color", "");


        //SEXTA
        $(".ds_visita_sex"+i).html("");
        $("#dt_agenda_sex"+i).html("").css("color", "");

        //SABADO
        $(".ds_visita_sab"+i).html("");
        $("#dt_agenda_sab"+i).html("").css("color", "");
    }
    
    $('.ds_qtde_sem_classificacao').html(" "); 
    $('.ds_qtde_produtivo').html(" "); 
    $('.ds_qtde_improdutivo').html(" "); 
    $('.ds_qtde_reagendado').html(" "); 
    $('.ds_qtde_atrasado').html(" "); 
   
          
}


function fcCarregarDataSemana(){    
    //joga as data em uma variavel     
    var v_dt_agenda = "01/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();   
   

    //Separa as datas  dia,mes,ano
    var partesDt_base = v_dt_agenda.split("/");
    
    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
    //0 dia; 1 mes; 2 ano
    var data_base = new Date(partesDt_base[2], partesDt_base[1] - 1, partesDt_base[0]);
    var nova_data = new Date(partesDt_base[2], partesDt_base[1] - 1, partesDt_base[0]);
    
    //subtrai de acordo com a posicao do dia da semana
    nova_data.setDate(data_base.getDate() - fcPosicaoDataSemana01());
    //gera a data do começo da semana
     
    var nova_v_dt_agenda = 0;
    var dia_comeco = 0;
    var mes_comeco = 0;
    var ano_comeco = 0;
    if(nova_data.getDate()<10){
        dia_comeco = "0"+nova_data.getDate();
        mes_comeco = (nova_data.getMonth()+1);
        ano_comeco = nova_data.getFullYear();
    }
    else{
        dia_comeco = nova_data.getDate();
        mes_comeco = (nova_data.getMonth()+1);
        ano_comeco = nova_data.getFullYear();
    }    
    if((nova_data.getMonth()+1)<10){
        mes_comeco = "0"+(nova_data.getMonth()+1);
        ano_comeco = nova_data.getFullYear();
    }
    else{
        mes_comeco = (nova_data.getMonth()+1);
        ano_comeco = nova_data.getFullYear();        
    }

    nova_v_dt_agenda = dia_comeco+"/"+mes_comeco+"/"+ano_comeco;
    
    for(i=0;i<42;i++){
        if(nova_v_dt_agenda !=""){
            var ArrData = nova_v_dt_agenda.split("/");
            //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
            //0 dia; 1 mes; 2 ano
            var dt_semana = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);   
            var dia = nova_v_dt_agenda.split("/");
                
                //PRIMEIRA SEMANA 
                if(i<=6){
                     if(dt_semana.getDay()==0){

                        if(dtAtual==nova_v_dt_agenda){

                            $("#dt_agenda_dom1").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_dom1_val").val(nova_v_dt_agenda);                         
                        }
                        else{
                            $("#dt_agenda_dom1").html(dia[0]);
                            $("#dt_agenda_dom1_val").val(nova_v_dt_agenda);

                        }
                   }else if(dt_semana.getDay()==1){

                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_seg1").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_seg1_val").val(nova_v_dt_agenda);
                        }
                        else{
                            $("#dt_agenda_seg1").html(dia[0]);
                            $("#dt_agenda_seg1_val").val(nova_v_dt_agenda);
                        }                    

                   }else if(dt_semana.getDay()==2){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_ter1").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_ter1_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_ter1").html(dia[0]);
                           $("#dt_agenda_ter1_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==3){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qua1").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qua1_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qua1").html(dia[0]);
                           $("#dt_agenda_qua1_val").val(nova_v_dt_agenda);
                        }                    
                   }else if(dt_semana.getDay()==4){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qui1").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qui1_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qui1").html(dia[0]);
                           $("#dt_agenda_qui1_val").val(nova_v_dt_agenda);
                        }
                   } else if(dt_semana.getDay()==5){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_sex1").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_sex1_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_sex1").html(dia[0]);
                           $("#dt_agenda_sex1_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==6){
                       if(dtAtual==nova_v_dt_agenda){
                           $("#dt_agenda_sab1").html(dia[0]).css("color", "blue");
                           $("#dt_agenda_sab1_val").val(nova_v_dt_agenda);
                       }
                       else{
                          $("#dt_agenda_sab1").html(dia[0]);
                          $("#dt_agenda_sab1_val").val(nova_v_dt_agenda);
                       }
                   }
                }
                
                //SEGUNDA SEMANA 
                if(i>=7 && i < 14){
                     if(dt_semana.getDay()==0){

                        if(dtAtual==nova_v_dt_agenda){

                            $("#dt_agenda_dom2").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_dom2_val").val(nova_v_dt_agenda);                         
                        }
                        else{
                            $("#dt_agenda_dom2").html(dia[0]);
                            $("#dt_agenda_dom2_val").val(nova_v_dt_agenda);

                        }
                   }else if(dt_semana.getDay()==1){

                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_seg2").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_seg2_val").val(nova_v_dt_agenda);
                        }
                        else{
                            $("#dt_agenda_seg2").html(dia[0]);
                            $("#dt_agenda_seg2_val").val(nova_v_dt_agenda);
                        }                    

                   }else if(dt_semana.getDay()==2){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_ter2").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_ter2_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_ter2").html(dia[0]);
                           $("#dt_agenda_ter2_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==3){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qua2").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qua2_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qua2").html(dia[0]);
                           $("#dt_agenda_qua2_val").val(nova_v_dt_agenda);
                        }                    
                   }else if(dt_semana.getDay()==4){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qui2").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qui2_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qui2").html(dia[0]);
                           $("#dt_agenda_qui2_val").val(nova_v_dt_agenda);
                        }
                   } else if(dt_semana.getDay()==5){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_sex2").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_sex2_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_sex2").html(dia[0]);
                           $("#dt_agenda_sex2_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==6){
                       if(dtAtual==nova_v_dt_agenda){
                           $("#dt_agenda_sab2").html(dia[0]).css("color", "blue");
                           $("#dt_agenda_sab2_val").val(nova_v_dt_agenda);
                       }
                       else{
                          $("#dt_agenda_sab2").html(dia[0]);
                          $("#dt_agenda_sab2_val").val(nova_v_dt_agenda);
                       }
                   }
                }
                
                //TERCEIRA SEMANA 
                if(i>=14 && i < 21){
                     if(dt_semana.getDay()==0){

                        if(dtAtual==nova_v_dt_agenda){

                            $("#dt_agenda_dom3").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_dom3_val").val(nova_v_dt_agenda);                         
                        }
                        else{
                            $("#dt_agenda_dom3").html(dia[0]);
                            $("#dt_agenda_dom3_val").val(nova_v_dt_agenda);

                        }
                   }else if(dt_semana.getDay()==1){

                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_seg3").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_seg3_val").val(nova_v_dt_agenda);
                        }
                        else{
                            $("#dt_agenda_seg3").html(dia[0]);
                            $("#dt_agenda_seg3_val").val(nova_v_dt_agenda);
                        }                    

                   }else if(dt_semana.getDay()==2){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_ter3").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_ter3_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_ter3").html(dia[0]);
                           $("#dt_agenda_ter3_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==3){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qua3").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qua3_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qua3").html(dia[0]);
                           $("#dt_agenda_qua3_val").val(nova_v_dt_agenda);
                        }                    
                   }else if(dt_semana.getDay()==4){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qui3").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qui3_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qui3").html(dia[0]);
                           $("#dt_agenda_qui3_val").val(nova_v_dt_agenda);
                        }
                   } else if(dt_semana.getDay()==5){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_sex3").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_sex3_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_sex3").html(dia[0]);
                           $("#dt_agenda_sex3_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==6){
                       if(dtAtual==nova_v_dt_agenda){
                           $("#dt_agenda_sab3").html(dia[0]).css("color", "blue");
                           $("#dt_agenda_sab3_val").val(nova_v_dt_agenda);
                       }
                       else{
                          $("#dt_agenda_sab3").html(dia[0]);
                          $("#dt_agenda_sab3_val").val(nova_v_dt_agenda);
                       }
                   }
                }
                
                //QUARTA SEMANA 
                if(i>=21 && i < 28){
                     if(dt_semana.getDay()==0){

                        if(dtAtual==nova_v_dt_agenda){

                            $("#dt_agenda_dom4").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_dom4_val").val(nova_v_dt_agenda);                         
                        }
                        else{
                            $("#dt_agenda_dom4").html(dia[0]);
                            $("#dt_agenda_dom4_val").val(nova_v_dt_agenda);

                        }
                   }else if(dt_semana.getDay()==1){

                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_seg4").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_seg4_val").val(nova_v_dt_agenda);
                        }
                        else{
                            $("#dt_agenda_seg4").html(dia[0]);
                            $("#dt_agenda_seg4_val").val(nova_v_dt_agenda);
                        }                    

                   }else if(dt_semana.getDay()==2){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_ter4").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_ter4_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_ter4").html(dia[0]);
                           $("#dt_agenda_ter4_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==3){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qua4").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qua4_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qua4").html(dia[0]);
                           $("#dt_agenda_qua4_val").val(nova_v_dt_agenda);
                        }                    
                   }else if(dt_semana.getDay()==4){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qui4").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qui4_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qui4").html(dia[0]);
                           $("#dt_agenda_qui4_val").val(nova_v_dt_agenda);
                        }
                   } else if(dt_semana.getDay()==5){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_sex4").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_sex4_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_sex4").html(dia[0]);
                           $("#dt_agenda_sex4_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==6){
                       if(dtAtual==nova_v_dt_agenda){
                           $("#dt_agenda_sab4").html(dia[0]).css("color", "blue");
                           $("#dt_agenda_sab4_val").val(nova_v_dt_agenda);
                       }
                       else{
                          $("#dt_agenda_sab4").html(dia[0]);
                          $("#dt_agenda_sab4_val").val(nova_v_dt_agenda);
                       }
                   }
                }
                //QUINTA SEMANA 
                if(i>=28 && i < 35){
                     if(dt_semana.getDay()==0){

                        if(dtAtual==nova_v_dt_agenda){

                            $("#dt_agenda_dom5").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_dom5_val").val(nova_v_dt_agenda);                         
                        }
                        else{
                            $("#dt_agenda_dom5").html(dia[0]);
                            $("#dt_agenda_dom5_val").val(nova_v_dt_agenda);

                        }
                   }else if(dt_semana.getDay()==1){

                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_seg5").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_seg5_val").val(nova_v_dt_agenda);
                        }
                        else{
                            $("#dt_agenda_seg5").html(dia[0]);
                            $("#dt_agenda_seg5_val").val(nova_v_dt_agenda);
                        }                    

                   }else if(dt_semana.getDay()==2){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_ter5").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_ter5_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_ter5").html(dia[0]);
                           $("#dt_agenda_ter5_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==3){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qua5").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qua5_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qua5").html(dia[0]);
                           $("#dt_agenda_qua5_val").val(nova_v_dt_agenda);
                        }                    
                   }else if(dt_semana.getDay()==4){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qui5").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qui5_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qui5").html(dia[0]);
                           $("#dt_agenda_qui5_val").val(nova_v_dt_agenda);
                        }
                   } else if(dt_semana.getDay()==5){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_sex5").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_sex5_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_sex5").html(dia[0]);
                           $("#dt_agenda_sex5_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==6){
                       if(dtAtual==nova_v_dt_agenda){
                           $("#dt_agenda_sab5").html(dia[0]).css("color", "blue");
                           $("#dt_agenda_sab5_val").val(nova_v_dt_agenda);
                       }
                       else{
                          $("#dt_agenda_sab5").html(dia[0]);
                          $("#dt_agenda_sab5_val").val(nova_v_dt_agenda);
                       }
                   }
                }
                //SEXTA SEMANA 
                if(i >= 35){
                     if(dt_semana.getDay()==0){

                        if(dtAtual==nova_v_dt_agenda){

                            $("#dt_agenda_dom6").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_dom6_val").val(nova_v_dt_agenda);                         
                        }
                        else{
                            $("#dt_agenda_dom6").html(dia[0]);
                            $("#dt_agenda_dom6_val").val(nova_v_dt_agenda);

                        }
                   }else if(dt_semana.getDay()==1){

                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_seg6").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_seg6_val").val(nova_v_dt_agenda);
                        }
                        else{
                            $("#dt_agenda_seg6").html(dia[0]);
                            $("#dt_agenda_seg6_val").val(nova_v_dt_agenda);
                        }                    

                   }else if(dt_semana.getDay()==2){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_ter6").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_ter6_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_ter6").html(dia[0]);
                           $("#dt_agenda_ter6_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==3){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qua6").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qua6_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qua6").html(dia[0]);
                           $("#dt_agenda_qua6_val").val(nova_v_dt_agenda);
                        }                    
                   }else if(dt_semana.getDay()==4){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_qui6").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_qui6_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_qui6").html(dia[0]);
                           $("#dt_agenda_qui6_val").val(nova_v_dt_agenda);
                        }
                   } else if(dt_semana.getDay()==5){
                       if(dtAtual==nova_v_dt_agenda){
                            $("#dt_agenda_sex6").html(dia[0]).css("color", "blue");
                            $("#dt_agenda_sex6_val").val(nova_v_dt_agenda);
                        }
                        else{
                           $("#dt_agenda_sex6").html(dia[0]);
                           $("#dt_agenda_sex6_val").val(nova_v_dt_agenda);
                        }
                   }else if(dt_semana.getDay()==6){
                       if(dtAtual==nova_v_dt_agenda){
                           $("#dt_agenda_sab6").html(dia[0]).css("color", "blue");
                           $("#dt_agenda_sab6_val").val(nova_v_dt_agenda);
                       }
                       else{
                          $("#dt_agenda_sab6").html(dia[0]);
                          $("#dt_agenda_sab6_val").val(nova_v_dt_agenda);
                       }
                   }
                }
               

                //separa a data 
                var p_nova_dt_agenda = nova_v_dt_agenda.split("/");
                
                
                //pega a data que ja passou pelo for 
                var nova_dt_agenda_dia_anterior = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                var nova_dt_agenda_dia_proximo = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                //a cada looping acrescenta mais um dia 
                nova_dt_agenda_dia_proximo.setDate(nova_dt_agenda_dia_anterior.getDate() + 1);
                 
                var nova_v_dt_agenda = 0;
                var dia = 0;
                var mes = 0;
                var ano = 0;
                if(nova_dt_agenda_dia_proximo.getDate()<10){
                    dia = "0"+nova_dt_agenda_dia_proximo.getDate();
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                }
                else{
                    dia = nova_dt_agenda_dia_proximo.getDate();
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                }

                if((nova_dt_agenda_dia_proximo.getMonth()+1)<10){
                    mes = "0"+(nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                    
                }
                else{
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                     
                }                
                nova_v_dt_agenda = dia+"/"+mes+"/"+ano;
 
            
        }
       
    }
    return (nova_v_dt_agenda);  
    
}

function fcPosicaoDataSemana01(){
    var v_dt_agenda = "01/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
    
    if(v_dt_agenda !=""){
        var objParametros = {
            "dt_agenda": v_dt_agenda  
        };      
        //var arrCarregar = carregarController("agenda_colaborador_padrao", "listarData", objParametros);  
       var arrCarregar = carregarController("agenda_visita", "listarData", objParametros);
        
        if (arrCarregar.result == 'success'){
            
            var posicao_data = arrCarregar.data[0]['dia_semana'];

        }
        else{
            alert('Falhar ao carregar o registro');
        }
        return posicao_data;
    }
}

function fcCarregar(){   

    fcLimparVariaveisSemana();
    
    //CARREGA AS DATAS DAS SEMANAS
    var DTsemana1 = fcCarregarDataSemana();  
    
    //CARREGA AS VISITAS POS SEMANA
    fcCarregarSemana();
}

function fcCarregarDatasSemanas(){

    fcLimparVariaveisSemana();
    
    //CARREGA AS DATAS DAS SEMANAS
    var DTsemana1 = fcCarregarDataSemana();  
    
    //CARREGA AS VISITAS POS SEMANA
    fcCarregarSemana();
   
      
}

function fcCarregarUsuarioLogin(){
        
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
    $("#ds_usuario_logado").text(" - "+arrCarregar.data[0]['ds_usuario']);          
    $("#usuario_logado_pk").val(arrCarregar.data[0]['pk']);          
}

function fcDatasCaleandario(label,acao){
    
    fcLimparVariaveisSemana();
    
    
    
    var today = new Date();
    var dd = today.getDate();        
    var mm = today.getMonth()+1; //January is 0!   
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
   
      
    if(label=='mes'){
        if(acao=='anterior'){     
            if($("#ic_mes").val()==1){
                mm = 12;
                yyyy = ($("#ds_ano").val()-1);
            }else{
                mm = ($("#ic_mes").val()-1);
                yyyy = (new Number($("#ds_ano").val()));
            }                        
        }else if(acao=='proximo'){             
            if($("#ic_mes").val()==12){
                mm = 1;
                yyyy = (new Number($("#ds_ano").val())+1) 
            }else{
                mm = (new Number($("#ic_mes").val())+1);
                yyyy = (new Number($("#ds_ano").val()));
            }             
        }
    }     
    
    if(label=='ano'){
        if(acao=='anterior'){  
            mm = $("#ic_mes").val();
            yyyy = ($("#ds_ano").val()-1);
        }else if(acao=='proximo'){    
            mm = $("#ic_mes").val();
            yyyy = (new Number($("#ds_ano").val())+1)      
        }
    }  
      
    $("#ano_pk").text(yyyy);    
    $("#ds_ano").val(yyyy);       
    if(mm=='1'){
        $("#ds_mes").text('Janeiro');
        $("#ic_mes").val(1);
    }else if(mm=='2'){
        $("#ds_mes").text('Fevereiro');
        $("#ic_mes").val(2);
    }else if(mm=='3'){
        $("#ds_mes").text('Março');
        $("#ic_mes").val(3);
    }else if(mm=='4'){
        $("#ds_mes").text('Abril');
        $("#ic_mes").val(4);
    }else if(mm=='5'){
        $("#ds_mes").text('Maio');
        $("#ic_mes").val(5);
    }else if(mm=='6'){
        $("#ds_mes").text('Junho');
        $("#ic_mes").val(6);
    }else if(mm=='7'){
        $("#ds_mes").text('Julho');
        $("#ic_mes").val(7);
    }else if(mm=='8'){
        $("#ds_mes").text('Agosto');
        $("#ic_mes").val(8);
    }else if(mm=='9'){
        $("#ds_mes").text('Setembro');
        $("#ic_mes").val(9);
    }else if(mm=='10'){
        $("#ds_mes").text('Outubro');
        $("#ic_mes").val(10);
    }else if(mm=='11'){
        $("#ds_mes").text('Novembro');
        $("#ic_mes").val(11);
    }else if(mm=='12'){
        $("#ds_mes").text('Dezembro');
        $("#ic_mes").val(12);
    }  
    fcCarregar();
}

function fcCarregarPerfil(){
    
    var objParametros = {
        "pk": ""
    };     
    
    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);   
  
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#calendar_grupos_pk"), arrCarregar, "", "pk", "ds_grupo");
    }
    else{
        carregarComboAjax($("#calendar_grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
    }    
}
function fcCarregarEquipe(){
    
    var objParametros = {
        "pk": ""
    };     
    
    var arrCarregar = carregarController("equipe", "listarEquipesCalendario", objParametros); 
   
  
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#calendar_equipes_pk"), arrCarregar, "", "pk", "ds_equipe");
    }
    else{
        carregarComboAjax($("#calendar_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
    }    
}
function fcCarregarResponsavel(){
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#calendar_grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros);  
   
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#calendar_usuarios_pk"), arrCarregar, "", "pk", "ds_usuario");
    }
    else{
        carregarComboAjaxResponsavel($("#calendar_usuarios_pk"), arrCarregar, " ", "pk", "ds_usuario");
    }
}
function fcCarregarAgendadoPor(){
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#calendar_grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros); 

    
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#calendar_agendado_por"), arrCarregar, " ", "pk", "ds_usuario");
    }
    else{
        carregarComboAjax($("#calendar_agendado_por"), arrCarregar, " ", "pk", "ds_usuario");
    }
}
function fcCarregarPolo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros); 

    carregarComboAjax($("#calendar_polos_pk"), arrCarregar, "", "pk", "ds_polo");
        
}
function fcAbrirLead(leads_pk){
    
     sendPost('lead_main_form.php',{token: token, pk: leads_pk,agenda:1});
        
}

function fcCarregarQtdeAgendamento(nova_v_dt_agenda,nova_v_dt_agenda_fim,tipo_avento_pk,usuario_cadastro_pk){

     if($("#ic_mes").val()<10){
        var dt_base = "01/0"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
        var dt_base_fim = "31/0"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
    }
    else{
        var dt_base = "01/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
        var dt_base_fim = "31/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
    }
    var objParametros = {
        "dt_base": dt_base,
        "dt_base_fim":dt_base_fim,
        "tipo_evento_pk":tipo_avento_pk,
        "tipos_agendas_pk":$('#calendar_tipos_agendas_pk').val(),
        "classificacao_agenda_pk":$('#calendar_classificacao_agenda_pk').val(),
        "polos_pk":$('#calendar_polos_pk').val(),  
        "grupos_pk":$('#calendar_grupos_pk').val(),
        "usuarios_pk":$('#calendar_usuarios_pk').val(),
        "usuario_cadastro_pk":usuario_cadastro_pk,
        "equipes_pk":$("#calendar_equipes_pk").val(),
        "atendente_pk":$("#calendar_atendente_pk").val()
    };           

    var arrCarregar = carregarController("agenda_visita", "listarQtdeAgendaVisitaData", objParametros);
    
   
    if (arrCarregar.result == 'success'){
        for(i = 0; i < arrCarregar.data.length; i++){
            if(arrCarregar.data[i]['t_ic_status']==null){  
                $('.ds_qtde_sem_classificacao').html(arrCarregar.data[i]['t_registro']); 
            }
            if(arrCarregar.data[i]['t_ic_status']==1){  
                $('.ds_qtde_produtivo').html(arrCarregar.data[i]['t_registro']); 
            }
            if(arrCarregar.data[i]['t_ic_status']==2){  
                $('.ds_qtde_improdutivo').html(arrCarregar.data[i]['t_registro']); 
            }
            if(arrCarregar.data[i]['t_ic_status']==3){  
                $('.ds_qtde_reagendado').html(arrCarregar.data[i]['t_registro']); 
            }
            if(arrCarregar.data[i]['t_ic_status']==4){  
                $('.ds_qtde_atrasado').html(arrCarregar.data[i]['t_registro']); 
            }
        }
    }       
    else{
        alert('Falhar ao carregar o registro');
    }
}


//--------------------------------------------OCORRENCIAS--------------------------------------------

var click = 1 ;
function fcCarregarGridOcorrencia(pk,responsavel_pk,usuario_cadastro_pk){
    
    var arrPermissao = permissao("acessar_todos_lead_agenda", "cons");
    
    if(arrPermissao.result =='success'){
        abrirGridOc(pk);
    }
    else if(responsavel_pk==0){
         alert("Você não é o responsavel da Agenda!!!");
    }
    else if($("#usuario_logado_pk").val().match(responsavel_pk)){
        abrirGridOc(pk);
    }
    else if(usuario_cadastro_pk == $("#usuario_logado_pk").val()){
        abrirGridOc(pk);
    }
    else{
        alert("Você não é o responsavel da Agenda!!!");
    }
}

function abrirGridOc(pk){
    
    if(pk!=""){
        $("#janela_agenda_visita_ocorrencia").modal();
        tblOcorrencia.clear().destroy();
    }
    
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
        "columnDefs": [

           {"targets": -1, "data": "t_dt_termino_retorno"}, 
           {"targets": -2, "data": "t_ds_retorno"},
           {"targets": -3, "data": "t_dt_retorno"},
           {"targets": -4, "data": "t_agendado_para"},
           {"targets": -5, "data": "t_dt_fechamento"}, 
           {"targets": -6, "data": "t_nome_usuario_cadastro"},
           {"targets": -7, "data": "t_ds_ocorrencia"},
           {"targets": -8, "data": "t_tipos_ocorrencias_pk" ,"visible":false},
           {"targets": -9,"data": "t_ds_tipo_ocorrencia"},
           {"targets": -10, "data": "t_dt_cadastro"}, 
           {"targets": -11, "data": "t_pk"} 

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    $(document).on('click', '#cmdIncluirOcorrencia', function () { 
        $("#janela_agenda_visita_ocorrencia").modal("hide");
        fcAbrirFormNovaOcorrencia(pk);
    } );

    
}

function fcAbrirFormNovaOcorrencia(leads_pk){
    
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
    fcCarregarComboUsuarioOc();
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
    
    $("#agenda_ds_retorno").html("");
    
    
    $("#agenda_leads_pk").val(leads_pk);
    
    $("#janela_ocorrencia_agenda").modal();
}

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
            "leads_pk": $("#agenda_leads_pk").val(),
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
        $("#janela_ocorrencia_agenda").modal("hide");
        abrirGridOc($("#agenda_leads_pk").val());
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
   
}

function fcCarregarComboEquipeOc(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("equipe", "listarTodos", objParametros); 
    carregarComboAjax($("#agenda_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");        
}

function fcCarregarComboUsuarioOc(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, "", "pk", "ds_usuario");
    //$("#agenda_responsavel_pk").val(arrCarregar.data[0]['pk']);
        
}

function fcCarregarTipoOcorrencia(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros); 

    carregarComboAjax($("#tipo_ocorrencia_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");
    

        
}

function fcCarregarComboSemInteresse(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("ocorrencia", "ListarMotivosSemInterre", objParametros);    
    carregarComboAjax($("#motivo_sem_interesse_pk"), arrCarregar, " ", "pk", "ds_motivo_sem_interesse");
        
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

function fcCarregarComboUsuarioTodos(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros); 
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
    //$("#agenda_responsavel_pk").val(arrCarregar.data[0]['pk']);
        
}

//--------------------------------------------LEAD--------------------------------------------
function fcCarregarLead(pk,responsavel_pk,usuario_cadastro_pk){

    var arrPermissao = permissao("acessar_todos_lead_agenda", "cons");
    
    if(arrPermissao.result =='success'){
        fcAbrirCarregarLead(pk);
    }
    else if(responsavel_pk==0){
         alert("Você não é o responsavel da Agenda!!!");
    }
    else if($("#usuario_logado_pk").val().match(responsavel_pk)){
        fcAbrirCarregarLead(pk);
    }
    else if($("#usuario_logado_pk").val() == usuario_cadastro_pk){
        fcAbrirCarregarLead(pk);
    }
    else{
        alert("Você não é o responsavel da Agenda!!!");
    }
}


function fcAbrirCarregarLead(pk){
    
    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        
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
            $("#ds_mailing").val(arrCarregar.data[0]['ds_mailing']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
        
        $("#cmdRedirecionar").click(function() {
            fcAbrirLead(pk);
        });
             
        fcCarregarSubMenu(pk);
       
        fcCarregarStatus(pk);
    
        
        tblEndereco.clear().destroy();
        fcCarregarGridEndereco(pk);

        tblTelefone.clear().destroy();
        fcCarregarGridTelefone(pk);

        tblLeadContatos.clear().destroy();
        fcCarregarGridContato(pk);

        tblLeadOperador.clear().destroy();
        fcCarregarGridLeadOperador(pk);
        
        $(document).on('click', '#enderecos-tab', function () { 
            tblEndereco.clear().destroy();
            fcCarregarGridEndereco(pk);
        } );  
        $(document).on('click', '#telefones-tab', function () { 
            tblTelefone.clear().destroy();
            fcCarregarGridTelefone(pk);
        } );
        $(document).on('click', '#contatos-tab', function () {  
            tblLeadContatos.clear().destroy();
            fcCarregarGridContato(pk);
        } ); 
        
        $(document).on('click', '#operador-tab', function () { 
            tblLeadOperador.clear().destroy();
            fcCarregarGridLeadOperador(pk);
        } );  
        
        
        tblResponsavelLeadAgenda.clear().destroy();
        fcCarregarGridResponsavelAgendaLead(pk);
        
        $("#janela_agenda_visita_lead").modal();
        
    }
}

var tblLeadOperador;

function fcCarregarGridLeadOperador(pk){
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("lead_operador", "listarPorLead", objParametros);
    
    //Trata a tabela
    tblLeadOperador = $('#tblLeadOperador').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
           {"targets": -1, "data": "t_tempo_contrato_pk"},
           {"targets": -2, "data": "t_ic_status",visible:false},
           {"targets": -3, "data": "t_ds_status"},
           {"targets": -4, "data": "t_ds_qtde_dados"},
           {"targets": -5, "data": "t_ds_qtde_voz"},
           {"targets": -6, "data": "t_ds_custo_atual"},
           {"targets": -7, "data": "t_dt_vencimento"},
           {"targets": -8, "data": "t_dt_ativacao"},
           {"targets": -9, "data": "t_ic_base",visible:false},
           {"targets": -10, "data": "t_ds_base"},
           {"targets": -11, "data": "t_ic_cliente",visible:false},
           {"targets": -12, "data": "t_ds_cliente"},
           {"targets": -13, "data": "t_operador_pk",visible:false},
           {"targets": -14, "data": "t_ds_operador"},
           {"targets": -15, "data": "t_pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
   
    return false;
}

          
function fcCarregarGridTelefone(pk){
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("telefone", "listarPorLead", objParametros);
    //Trata a tabela
    tblTelefone = $('#tblTelefone').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
           {"targets": -1, "data": "ic_status", visible:false},
           {"targets": -2, "data": "ds_naoperturbe"},
           {"targets": -3, "data": "ds_ddd_tel"},
           {"targets": -4, "data": "ds_tipo_telefone"},
           {"targets": -5, "data": "tipo_telefone_pk", visible:false},
           {"targets": -6, "data": "pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    return false;
}

function fcCarregarGridEndereco(pk){
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("endereco", "listarPorLead", objParametros);
 
    //Trata a tabela
    tblEndereco = $('#tblEndereco').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
           {"targets": -1, "data": "tipo_endereco_pk",visible:false},
           {"targets": -2, "data": "ds_tipo_entrega"},
           {"targets": -3, "data": "ds_bairro"},
           {"targets": -4, "data": "ds_complemento"},
           {"targets": -5, "data": "ds_numero"},
           {"targets": -6, "data": "ds_uf"},
           {"targets": -7, "data": "ds_cidade"},
           {"targets": -8, "data": "ds_endereco"},
           {"targets": -9, "data": "ds_cep"},
           {"targets": -10, "data": "pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    return false;
}


function fcCarregarGridContato(pk){
   
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("lead", "listarContatoLead", objParametros);

    //Trata a tabela
    tblLeadContatos = $('#tblLeadContatos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
           {"targets": -1, "data": "t_cargos_pk","visible":false},
           {"targets": -2, "data": "t_ds_cargos_pk"},
           {"targets": -3, "data": "t_ds_tel"},
           {"targets": -4, "data": "t_ic_whatsapp","visible":false},
           {"targets": -5, "data": "t_ds_whatsapp"},
           
           {"targets": -6, "data": "t_ds_cel"},
           {"targets": -7, "data": "t_ds_email"},
           {"targets": -8, "data": "t_ds_contato"},
           {"targets": -9, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    return false;
}


function fcCarregarGridResponsavelAgendaLead(pk){
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("lead_responsavel", "listarPorLead", objParametros);
    //Trata a tabela
    tblResponsavelLeadAgenda = $('#tblResponsavelLeadAgenda').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
           
           {"targets": -1, "data": "ds_usuario"},
           {"targets": -2, "data": "ds_grupo"},
           {"targets": -3, "data": "usuarios_pk","visible":false},
           {"targets": -4, "data": "grupos_pk","visible":false},
           {"targets": -5, "data": "pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    return false;
}


function fcCarregarSubMenu(pk){

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
function fcCarregarStatus(pk){

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
function fcCarregarAtendente(){
    var objParametros = {
        "grupos_pk": $("#calendar_grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarAtentedente", objParametros); 
    
    if(arrCarregar.data.lenght==1){
         carregarComboAjax($("#calendar_atendente_pk"), arrCarregar, "", "pk", "ds_usuario"); 
    }
    else{
        carregarComboAjax($("#calendar_atendente_pk"), arrCarregar, " ", "pk", "ds_usuario"); 
    }
   

}

$(document).ready(function(){
    
    
    fcCarregarUsuarioLogin();
     
    
    $(document).on('click', '#cmdPreviMes', function () {            
        fcDatasCaleandario('mes','anterior');
    } );
        
    $(document).on('click', '#cmdNextMes', function () {  
        fcDatasCaleandario('mes','proximo');
    } );    
    
    $(document).on('click', '#cmdPreviAno', function () {  
        fcDatasCaleandario('ano','anterior');
    } );    

    $(document).on('click', '#cmdNextAno', function () {  
        fcDatasCaleandario('ano','proximo');
    } );    
    
      
    fcCarregarPolo();
    fcCarregarPerfil();  
    fcCarregarEquipe();
    fcCarregarResponsavel();
    fcCarregarAgendadoPor();
    fcCarregarAtendente();
    $("#calendar_grupos_pk").change(function(){
       fcCarregarResponsavel();
       fcCarregarAgendadoPor();
       fcCarregarAtendente();
    }); 
        
    $(document).on('click', '#cmdFiltrar', function () { 
       fcCarregarDatasSemanas();               
    } );    
   
    
    fcDatasCaleandario(); 
    $("#loader").hide();
    $("#exibir").show();
    
        fcCarregarGridTelefone("");
        fcCarregarGridLeadOperador("");
        fcCarregarGridEndereco("");
        fcCarregarGridContato("");
        fcCarregarGridResponsavelAgendaLead("");
        abrirGridOc("");
        fcCarregarComboEquipeOc();
        fcCarregarComboUsuarioOc();
        fcValidarFormOcorrencia();
        
        //carrega combo
        fcCarregarTipoOcorrencia();  

        //SEM INTERESSE
        fcCarregarComboSemInteresse();
        
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
