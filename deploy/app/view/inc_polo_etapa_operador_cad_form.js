var tblEsteira;

function fcCarregarGridEsteira(){

    var objParametros = {
        "polos_pk": pk
    };     
    
    var v_url = montarUrlController("etapa_contrato", "listarPorPolo", objParametros);

    //Trata a tabela
    tblEsteira = $('#tblEsteira').DataTable({
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
           {"targets": -2, "data": "ds_status"},  
           {"targets": -3, "data": "ic_status_esteira", visible:false}, 
           {"targets": -4, "data": "ds_etapa"},
           {"targets": -5, "data": "n_ordem"},
           {"targets": -6, "data": "ds_operador"},
           {"targets": -7, "data": "operador_pk", visible:false},           
           {"targets": -8, "data": "ds_segmento"},
           {"targets": -9, "data": "segmentos_pk", visible:false},
           {"targets": -10, "data": "pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });   
    
    //Atribui os eventos na coluna ação.
    $('#tblEsteira tbody').on('click', '.function_edit', function () {
        var data;    
      
        rLinhaSelecionada = null;
        
        if(tblEsteira.row( $(this).parents('li')).data()){
            data = tblEsteira.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblEsteira.row( $(this).parents('tr')).data()){
            data = tblEsteira.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarEsteira(data);        
    } );   
    
    $('#tblEsteira tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblEsteira.row( $(this).parents('li') ).data()){
            data = tblEsteira.row( $(this).parents('li') ).data();
        }
        else if(tblEsteira.row( $(this).parents('tr') ).data()){
            data = tblEsteira.row( $(this).parents('tr') ).data();
        }
        if(data['pk'] != ""){
            fcExcluirEsteira(data['pk']);
        }
        tblEsteira.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}


function fcEditarEsteira(objRegistro){
    fcLimparFormEsteira();
    $("#janela_esteira").modal();
    $("#etapas_contratos_pk").val("");
    $("#acao").val("upd");

    //Carrega as informações da linha selecionada.
    $("#etapas_contratos_pk").val(objRegistro['pk']);
    $("#etapa_segmentos_pk").val(objRegistro['segmentos_pk']);
    fcCarregarOperadorEtapa();
    $("#etapa_operador_pk").val(objRegistro['operador_pk']);
    $("#n_ordem").val(objRegistro['n_ordem']);
    $("#ds_etapa").val(objRegistro['ds_etapa']);
    $("#ic_status_esteira").val(objRegistro['ic_status_esteira']);     
}

function fcExcluirEsteira(v_pk){
    
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("polo_esteira", "excluir", objParametros);   
  
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

function fcBotoesGriOperdor(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcEnviarEsteira(){    

    if(pk == ""){
       if($("#acao").val() == "ins"){           
           fcIncluirEsteiraSemPk();
       }else if($("#acao").val() == "upd"){
           fcEditarEsteiraSemPk();
       }
   }else{
       fcSalvarEsteira();
   }   
   
   $("#janela_esteira").modal("hide");
}

function fcRecarregarGridEsteira(){
    tblEsteira.clear().destroy();    
    fcCarregarGridEsteira();
}

function fcSalvarEsteira(){   

    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#etapas_contratos_pk").val(),
        "polos_pk": pk,
        "segmentos_pk": $("#etapa_segmentos_pk").val(),
        "operador_pk": $("#etapa_operador_pk").val(),
        "n_ordem": $("#n_ordem").val(),
        "ds_etapa": $("#ds_etapa").val(),        
        "ic_status": $("#ic_status_esteira").val()
     
    }; 
    var arrEnviar = carregarController("etapa_contrato", "salvar", objParametros);
    if (arrEnviar.result == 'success'){
        fcRecarregarGridEsteira();
    }    
    else{
        alert(arrEnviar.result);
    }
}

function fcIncluirEsteiraSemPk(){   

    tblEsteira.row.add(
        {
            "pk":"",
            "segmentos_pk":$("#etapa_segmentos_pk").val(),
            "ds_segmento":$("#etapa_segmentos_pk option:selected").text(),
            "operador_pk":$("#etapa_operador_pk").val(),
            "ds_operador":$("#etapa_operador_pk option:selected").text(),
            "n_ordem":$("#n_ordem").val(),
            "ds_etapa":$("#ds_etapa").val(),
            "ic_status_esteira":$("#ic_status_esteira").val(),
            "ds_status":$("#ic_status_esteira option:selected").text(),
            "t_functions":""
        }
    ).draw();    
    return false;
}

function fcBotoesGridEsteira(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcRecarregarGridEsteira(){
    tblEsteira.clear().destroy();    
    fcCarregarGridEsteira();
}

function fcExcluirEsteiraSemPk(){
   tblEsteira.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcFormatarDadosEsteira(){      
    try{
        var etapas_contratos_pk = "";
        var etapa_segmentos_pk = "";
        var ic_status_esteira = "";
        var operador_pk = "";
        var n_ordem = "";
        var ds_etapa = "";


        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "etapas_contratos_pk";
        arrKeys[1] = "segmentos_pk";
        arrKeys[2] = "operador_pk";
        arrKeys[3] = "n_ordem";
        arrKeys[4] = "ds_etapa";
        arrKeys[5] = "ic_status_esteira";
        
        var  data = tblEsteira.rows().data();
        
        for(i = 0; i< data.length; i++){

            etapas_contratos_pk = data[i]['pk'];
            etapa_segmentos_pk =  data[i]['segmentos_pk'];
            operador_pk =  data[i]['operador_pk'];
            n_ordem =  data[i]['n_ordem'];
            ds_etapa =  data[i]['ds_etapa'];
            ic_status_esteira =  data[i]['ic_status_esteira'];          
            
            arrDados[i] = [etapas_contratos_pk,etapa_segmentos_pk,operador_pk,n_ordem,ds_etapa,ic_status_esteira];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}

function fcLimparFormEsteira(){
    $("#acao").val("");
    $("#etapas_contratos_pk").val("");
    $("#etapa_segmentos_pk").val("");
    $("#etapa_operador_pk").val("");
    $("#n_ordem").val("");
    $("#ds_etapa").val("");
    $("#ic_status_esteira").val("");      
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoEsteira(){

    //limpa os dados de qualquer registro existe
    fcLimparFormEsteira();
    
    $("#janela_esteira").modal();
    $("#acao").val("ins");
    $("#etapas_contratos_pk").val("");
}

function fcValidarFormEsteira(){
    
    $("#form_polo_etapa").validate({
        rules :{
            etapa_segmentos_pk:{
                required:true
            },
            etapa_operador_pk:{
                required:true
            },
            n_ordem:{
                required:true
            },
            ds_etapa:{
                required:true
            },
            ic_status_esteira:{
                required:true
            }
        },
        messages:{
            etapa_segmentos_pk:{
                required:"Por favor, informe o Segmento"
            },
            etapa_operador_pk:{
                required:"Por favor, informe o Esteira"
            },
            n_ordem:{
                required:"Por favor, informe a Oerdem"
            },
            ds_etapa:{
                required:"Por favor, informe a Etapa"
            },
            ic_status_esteira:{
                required:"Por favor, informe o Status"
            }   
        },
        submitHandler: function(form){
            fcEnviarEsteira(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcCarregarSegmentoEtapa(){
    
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("segmento", "listarTodos", objParametros);    

    carregarComboAjax($("#etapa_segmentos_pk"), arrCarregar, " ", "pk", "ds_segmento");
        
}

function fcCarregarOperadorEtapa(){ 
    var objParametros = {
        "pk": "",
        "segmentos_pk":$("#etapa_segmentos_pk").val()
    };       
    var arrCarregar = carregarController("operador", "listarTodos", objParametros); 
    carregarComboAjax($("#etapa_operador_pk"), arrCarregar, " ", "pk", "ds_operador");        
}

$(document).ready(function(){  
    
    //var arrCarregar = permissao("polos_esteiraes", "cons");        
        
    /*if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/

    fcCarregarSegmentoEtapa();
    
     $("#etapa_segmentos_pk").change(function(){
        fcCarregarOperadorEtapa();
    });    

    $(document).on('click', '#btn_modal_esteira', fcAbrirFormNovoEsteira);  
    
    fcCarregarGridEsteira();
    
   fcValidarFormEsteira();
});