//--------------------------------------------------------SEMANA ATUAL--------------------------------------------------//
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();  
var click = 1 ;

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
    var str_hora = hh + ':' + min;  
    
    var arrCarregarEdit = permissao("agenda", "ins"); 
    var arrCarregarReag = permissao("agenda_reagendamento", "ins"); 
    var arrCarregarClass = permissao("agenda_classificacao", "upd");
        if(nova_v_dt_agenda !=""){
            var objParametros = {                
                "dt_base": nova_v_dt_agenda,
                "dt_base_fim":nova_v_dt_agenda_fim,
                "ocorrencias_pk":$('#calendar_ocorrencia_pk').val(),  
                "equipes_pk":$('#calendar_equipe_pk').val(),
                "usuarios_pk":$('#calendar_usuarios_pk').val()
            };   
            var arrCarregar = carregarController("agenda_retorno", "listarAgendaRetornoData", objParametros); 

            if (arrCarregar.result == 'success'){
                    
                        for(j=0; j < arrCarregar.data.length ;j++){                    
                            var strResultado ="";  
                            var dsResponsavel ="";      


                            var strData = arrCarregar.data[j]['t_dt_retorno'];
                            var partesData = strData.split("/");
                            var hora1 = arrCarregar.data[j]['t_hr_retorno'].split(":");

                            var strDataAgora = dtAtual;
                            var partesDataAtual = strDataAgora.split("/");
                            var hora2 = str_hora.split(":");



                            var data = new Date(partesData[2], partesData[1] - 1, partesData[0], hora1[0], hora1[1]);
                            var data_atual = new Date(partesDataAtual[2], partesDataAtual[1] - 1, partesDataAtual[0], hora2[0], hora2[1]);

                            if(data_atual > data){
                                if(arrCarregar.data[j]['t_dt_termino_retorno']!=null){
                                    colorClassificacao = "background-color:#DFF0D8";
                                }
                                else{
                                    colorClassificacao = "background-color:#e62121";
                                }

                            }
                            else if (arrCarregar.data[j]['t_dt_termino_retorno']!=null){
                                colorClassificacao = "background-color:#DFF0D8";
                            }
                            else{
                                colorClassificacao = "background-color:";        
                            }

                            strResultado += "<div class='modal-content' id='exampleModalLong' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'  >";
                            strResultado += "<div style="+colorClassificacao+">" //color classificaçaõ
                            strResultado += "<div class='modal-body'><div class='row'>";
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/eventos.png'> Evento: Retorno</label>"; // RESPONSAVEL//        
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> <h5>"+arrCarregar.data[j]['t_hr_retorno']+"</h5></label>"; // Horario do visita//
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> Lead: <a href='javascript:fcAbrirLead("+arrCarregar.data[j]['t_leads_pk']+")'> "+arrCarregar.data[j]['t_ds_lead']+" </a></label>";//LEAD
                            strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'>Cód "+arrCarregar.data[j]['t_pk']+"</label>"; // Cod Visita//               
                            if(arrCarregar.data[j]['t_ds_responsavel']!= null){ 
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/responsavel.png'> Responsável: "+arrCarregar.data[j]['t_ds_responsavel']+"</label>"; // RESPONSAVEL//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // RESPONSAVEL//        
                            }
                            if(arrCarregar.data[j]['t_ds_ocorrencia']!= null){ 
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/ocorrencias.jpg'> Ocorrência: "+arrCarregar.data[j]['t_ds_ocorrencia']+"</label>"; // RESPONSAVEL//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // RESPONSAVEL//        
                            }
                            if(arrCarregar.data[j]['t_ds_equipe']!= null){ 
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'><img width=18 height=18 src='../img/equipe.png'> Equipe: "+arrCarregar.data[j]['t_ds_equipe']+"</label>"; // RESPONSAVEL//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // RESPONSAVEL//        
                            }

                            if(arrCarregar.data[j]['t_ds_retorno']!= null){
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'>Descrição: "+arrCarregar.data[j]['t_ds_retorno']+"</label>"; // DESCRIÇÃO//        
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> </label>"; // DESCRIÇÃO//        
                            }
                           if (arrCarregarEdit.result != 'success'){
                                strResultado += " ";
                            }
                            else{
                                strResultado += "<label id='grupo' class='col-sm-12' style='font-size: 14px;'> <a href='javascript:fcEditarRetorno("+arrCarregar.data[j]['ocorrencias_pk']+","+arrCarregar.data[j]['t_pk']+")'> <img width=18 height=18 src='../img/copiar.png' ></a>&nbsp;&nbsp;";//editar
                            }
                            strResultado += "</label>";
                            strResultado += "</div>";
                            strResultado += "</div>";
                            strResultado += "</div>";
                            strResultado += "</div>";
                        
                        
                        
                        
                      
                        
                        /*for(i=0;i<42;i++){
                            if(i<6){*/
                                if($("#dt_agenda_dom1_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_dom1").html(strResultado+"<br>"+$(".ds_visita_dom1").html());                            
                                }
                                if($("#dt_agenda_seg1_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_seg1").html(strResultado+"<br>"+$(".ds_visita_seg1").html());                            
                                }
                                if($("#dt_agenda_ter1_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_ter1").html(strResultado+"<br>"+$(".ds_visita_ter1").html());                            
                                }
                                if($("#dt_agenda_qua1_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qua1").html(strResultado+"<br>"+$(".ds_visita_qua1").html());                            
                                }
                                if($("#dt_agenda_qui1_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qui1").html(strResultado+"<br>"+$(".ds_visita_qui1").html());                            
                                }
                                if($("#dt_agenda_sex1_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sex1").html(strResultado+"<br>"+$(".ds_visita_sex1").html());                            
                                }
                                if($("#dt_agenda_sab1_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sab1").html(strResultado+"<br>"+$(".ds_visita_sab1").html());                            
                                }
                           /* }
                            if(i>=7 && i<14){*/
                                if($("#dt_agenda_dom2_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_dom2").html(strResultado+"<br>"+$(".ds_visita_dom2").html());                            
                                }
                                if($("#dt_agenda_seg2_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_seg2").html(strResultado+"<br>"+$(".ds_visita_seg2").html());                            
                                }
                                if($("#dt_agenda_ter2_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_ter2").html(strResultado+"<br>"+$(".ds_visita_ter2").html());                            
                                }
                                if($("#dt_agenda_qua2_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qua2").html(strResultado+"<br>"+$(".ds_visita_qua2").html());                            
                                }
                                if($("#dt_agenda_qui2_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qui2").html(strResultado+"<br>"+$(".ds_visita_qui2").html());                            
                                }
                                if($("#dt_agenda_sex2_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sex2").html(strResultado+"<br>"+$(".ds_visita_sex2").html());                            
                                }
                                if($("#dt_agenda_sab2_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sab2").html(strResultado+"<br>"+$(".ds_visita_sab2").html());                            
                                }
                            /*}
                            if(i>=14 && i<21){*/
                                if($("#dt_agenda_dom3_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_dom3").html(strResultado+"<br>"+$(".ds_visita_dom3").html());                            
                                }
                                if($("#dt_agenda_seg3_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_seg3").html(strResultado+"<br>"+$(".ds_visita_seg3").html());                            
                                }
                                if($("#dt_agenda_ter3_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_ter3").html(strResultado+"<br>"+$(".ds_visita_ter3").html());                            
                                }
                                if($("#dt_agenda_qua3_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qua3").html(strResultado+"<br>"+$(".ds_visita_qua3").html());                            
                                }
                                if($("#dt_agenda_qui3_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qui3").html(strResultado+"<br>"+$(".ds_visita_qui3").html());                            
                                }
                                if($("#dt_agenda_sex3_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sex3").html(strResultado+"<br>"+$(".ds_visita_sex3").html());                            
                                }
                                if($("#dt_agenda_sab3_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sab3").html(strResultado+"<br>"+$(".ds_visita_sab3").html());                            
                                }
                            /*}
                            if(i>=21 && i<28){*/
                                if($("#dt_agenda_dom4_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_dom4").html(strResultado+"<br>"+$(".ds_visita_dom4").html());                            
                                }
                                if($("#dt_agenda_seg4_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_seg4").html(strResultado+"<br>"+$(".ds_visita_seg4").html());                            
                                }
                                if($("#dt_agenda_ter4_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_ter4").html(strResultado+"<br>"+$(".ds_visita_ter4").html());                            
                                }
                                if($("#dt_agenda_qua4_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qua4").html(strResultado+"<br>"+$(".ds_visita_qua4").html());                            
                                }
                                if($("#dt_agenda_qui4_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qui4").html(strResultado+"<br>"+$(".ds_visita_qui4").html());                            
                                }
                                if($("#dt_agenda_sex4_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sex4").html(strResultado+"<br>"+$(".ds_visita_sex4").html());                            
                                }
                                if($("#dt_agenda_sab4_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sab4").html(strResultado+"<br>"+$(".ds_visita_sab4").html());                            
                                }
                            /*}
                            if(i>=28 && i<35){*/
                                if($("#dt_agenda_dom5_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_dom5").html(strResultado+"<br>"+$(".ds_visita_dom5").html());                            
                                }
                                if($("#dt_agenda_seg5_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_seg5").html(strResultado+"<br>"+$(".ds_visita_seg5").html());                            
                                }
                                if($("#dt_agenda_ter5_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_ter5").html(strResultado+"<br>"+$(".ds_visita_ter5").html());                            
                                }
                                if($("#dt_agenda_qua5_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qua5").html(strResultado+"<br>"+$(".ds_visita_qua5").html());                            
                                }
                                if($("#dt_agenda_qui5_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qui5").html(strResultado+"<br>"+$(".ds_visita_qui5").html());                            
                                }
                                if($("#dt_agenda_sex5_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sex5").html(strResultado+"<br>"+$(".ds_visita_sex5").html());                            
                                }
                                if($("#dt_agenda_sab5_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sab5").html(strResultado+"<br>"+$(".ds_visita_sab5").html());                            
                                }
                           /* }
                            if(i>36){*/
                                if($("#dt_agenda_dom6_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_dom6").html(strResultado+"<br>"+$(".ds_visita_dom6").html());                            
                                }
                                if($("#dt_agenda_seg6_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_seg6").html(strResultado+"<br>"+$(".ds_visita_seg6").html());                            
                                }
                                if($("#dt_agenda_ter6_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_ter6").html(strResultado+"<br>"+$(".ds_visita_ter6").html());                            
                                }
                                if($("#dt_agenda_qua6_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qua6").html(strResultado+"<br>"+$(".ds_visita_qua6").html());                            
                                }
                                if($("#dt_agenda_qui6_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_qui6").html(strResultado+"<br>"+$(".ds_visita_qui6").html());                            
                                }
                                if($("#dt_agenda_sex6_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
                                    $(".ds_visita_sex6").html(strResultado+"<br>"+$(".ds_visita_sex6").html());                            
                                }
                                if($("#dt_agenda_sab6_val").val()==arrCarregar.data[j]['t_dt_retorno']){                            
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
    
    fcGraficoRetorno();
   
      
}

function fcCarregarUsuarioLogin(){
        
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
    $("#ds_usuario_logado").text(" - "+arrCarregar.data[0]['ds_usuario']);          
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
    
    fcGraficoRetorno();
}

function fcCarregarEquipe(){
    
    var objParametros = {
        "pk": ""
    };     
    
    var arrCarregar = carregarController("equipe", "listarEquipesCalendario", objParametros);   
  
   /*if(arrCarregar.data.length==1){
        carregarComboAjax($("#calendar_equipe_pk"), arrCarregar, "", "pk", "ds_equipe");
    }
    else{*/
        carregarComboAjax($("#calendar_equipe_pk"), arrCarregar, " ", "pk", "ds_equipe");
    //}    
}
function fcCarregarResponsavel(){
    
    var objParametros = {
        "pk": "",
        "equipes_pk":$("#calendar_equipe_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros);  

    
    if(arrCarregar.data.length==1){
        carregarComboAjax($("#calendar_usuarios_pk"), arrCarregar, "", "pk", "ds_usuario");
    }
    else{
        carregarComboAjax($("#calendar_usuarios_pk"), arrCarregar, "", "pk", "ds_usuario");
    }
}
function fcCarregarComboUsuarioResponsavelLogado(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 

    carregarComboAjax($("#calendar_usuarios_pk"), arrCarregar, "", "pk", "ds_usuario");
    //$("#agenda_responsavel_pk").val(arrCarregar.data[0]['pk']);
        
}
function fcCarregarOcorrencia(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros); 

    carregarComboAjax($("#calendar_ocorrencia_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");
        
}
function fcAbrirLead(leads_pk){
    
     sendPost('lead_main_form.php',{token: token, pk: leads_pk,agenda:2});
        
}

function fcGraficoRetorno(){
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
    var str_hora = hh + ':' + min;  


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
    var str_hora = hh + ':' + min;  

    var arrSeries = [];  
    var url = "../controller/grafico_agenda_retorno_controller.php?token="+token+"&dt_base_ini="+nova_v_dt_agenda+"&dt_base_fim="+nova_v_dt_agenda_fim+"&ocorrencia_pk="+$('#calendar_ocorrencia_pk').val()+"&equipes_pk="+$('#calendar_equipe_pk').val()+"&usuarios_pk="+$('#calendar_usuarios_pk').val();
    //pega as informações
    $.getJSON(url, function(result) {
        for(i = 0; i < result.series.length; i++){
           arrSeries[i] ={name: result.series[i].name,y: result.series[i].data};

        }
         Highcharts.chart('container', {
                chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ' Quantidade Retornos '
            },
            colors: [
                '#DFF0D8',
                '#e62121'
            ],
            plotOptions: {
                pie: {
                    allowPointSelect: false,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: ' ',
                colorByPoint: true,
                data: arrSeries
            }]
        });
    })
    .fail(function() {
       //alert("Deu erro. Veio nada, veio JSON inválido etc");
  });
    
   
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
    
      
     
    fcCarregarOcorrencia();
    
    fcCarregarEquipe();   
 
    fcCarregarComboUsuarioResponsavelLogado();    
    $('#calendar_usuarios_pk').click(function(){ 
            if(click==1){
                
                $('#calendar_usuarios_pk').val("");
                fcCarregarResponsavel();
            }
            click++;
        });
    
        
    $(document).on('click', '#cmdFiltrar', function () { 
       fcCarregarDatasSemanas();               
    } );    
    
    
    fcDatasCaleandario();  
    
    $("#loader").hide();
    $("#exibir").show();
    
    
});
