var tblModeloProposta;

function fcCarregarGridModeloProposta(){

    var objParametros = {
        "polos_pk": pk
    };     
    
    var v_url = montarUrlController("polo_modelo_proposta", "listarPorPolo", objParametros);
    //Trata a tabela
    tblModeloProposta = $('#tblModeloProposta').DataTable({
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
           {"targets": -2, "data": "t_html_modelo", visible:false},  
           {"targets": -3, "data": "t_ds_email", visible:false},  
           {"targets": -4, "data": "t_tipo_envio_pk", visible:false},  
           {"targets": -5, "data": "t_tipo_modelo_pk", visible:false},  
           {"targets": -6, "data": "ds_status"},  
           {"targets": -7, "data": "t_status_pk", visible:false}, 
           {"targets": -8, "data": "ds_operador"},
           {"targets": -9, "data": "t_operador_pk", visible:false},           
           {"targets": -10, "data": "t_pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });   
    
    //Atribui os eventos na coluna ação.
    $('#tblModeloProposta tbody').on('click', '.function_edit', function () {
        var data;    
      
        rLinhaSelecionada = null;
        
        if(tblModeloProposta.row( $(this).parents('li')).data()){
            data = tblModeloProposta.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblModeloProposta.row( $(this).parents('tr')).data()){
            data = tblModeloProposta.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarModeloProposta(data);        
    } );   
    
    $('#tblModeloProposta tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblModeloProposta.row( $(this).parents('li') ).data()){
            data = tblModeloProposta.row( $(this).parents('li') ).data();
        }
        else if(tblModeloProposta.row( $(this).parents('tr') ).data()){
            data = tblModeloProposta.row( $(this).parents('tr') ).data();
        }
        if(data['pk'] != ""){
            fcExcluirModeloProposta(data['pk']);
        }
        tblModeloProposta.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}


function fcEditarModeloProposta(objRegistro){
    fcLimparFormModeloProposta();
    
    $("#janela_modelo_proposta").modal();
    $("#modelo_proposta_pk").val("");
    $("#acao").val("upd");

    //Carrega as informações da linha selecionada.
    $("#modelo_proposta_pk").val(objRegistro['t_pk']);
    fcCarregarOperadorModeloProposta();
    $("#modelo_operador_pk").val(objRegistro['t_operador_pk']);
    $("#tipo_modelo_pk").val(objRegistro['t_tipo_modelo_pk']);
    $("#tipo_envio_pk").val(objRegistro['t_tipo_envio_pk']);
    $("#modelo_ds_email").val(objRegistro['t_ds_email']);     
    $("#ic_status_modelo").val(objRegistro['t_status_pk']);     
    $("#html_modelo").val(objRegistro['t_html_modelo']);     
}

function fcExcluirModeloProposta(v_pk){
    
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("polo_modelo_proposta", "excluir", objParametros);   
  
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

function fcEnviarModeloProposta(){    
    if(pk == ""){
       if($("#acao").val() == "ins"){   
           fcIncluirModeloPropostaSemPk();
       }else if($("#acao").val() == "upd"){
           fcEditarModeloPropostaSemPk();
       }
   }else{
       fcSalvarModeloProposta();
   }   
   
   $("#janela_modelo_proposta").modal("hide");
}
function fcEditarModeloPropostaSemPk(){
    
    fcIncluirModeloPropostaSemPk();
    tblModeloProposta.row(rLinhaSelecionada).remove().draw();
    return false;
}

function fcRecarregarGridEsteira(){
    tblModeloProposta.clear().destroy();    
    fcCarregarGridModeloProposta();
}

function fcSalvarModeloProposta(){   

    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#modelo_proposta_pk").val(),
        "polos_pk": pk,
        "operador_pk": $("#modelo_operador_pk").val(),      
        "status_pk": $("#ic_status_modelo").val(),
        "tipo_modelo_pk": $("#tipo_modelo_pk").val(),
        "tipo_envio_pk": $("#tipo_envio_pk").val(),
        "ds_email": $("#modelo_ds_email").val(),
        "html_modelo": $("#html_modelo").val(),
     
    }; 
    var arrEnviar = carregarController("polo_modelo_proposta", "salvar", objParametros);
    alert(v_last_url);
    if (arrEnviar.result == 'success'){
        fcRecarregarGridEsteira();
    }    
    else{
        alert(arrEnviar.result);
    }
}

function fcIncluirModeloPropostaSemPk(){   

    tblModeloProposta.row.add(
        {
                  
            "t_pk":"",
            "t_operador_pk":$("#modelo_operador_pk").val(),
            "ds_operador":$("#modelo_operador_pk option:selected").text(),
            "t_status_pk":$("#ic_status_modelo").val(),
            "ds_status":$("#ic_status_modelo option:selected").text(),
            "t_tipo_modelo_pk":$("#tipo_modelo_pk").val(),
            "t_tipo_envio_pk":$("#tipo_envio_pk").val(),
            "t_ds_email":$("#modelo_ds_email").val(),
            "t_html_modelo":$("#html_modelo").val(),
            "t_functions":""
        }
    ).draw();    
    return false;
}

function fcBotoesGridEsteira(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcRecarregarGridModeloProposta(){
    tblModeloProposta.clear().destroy();    
    fcCarregarGridModeloProposta();
}

function fcExcluirModeloPropostaSemPk(){
   tblModeloProposta.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcFormatarDadosModeloProposta(){      
    try{
        var modelos_etapas_pk = "";
        var ic_status_modelo = "";
        var operador_pk = "";
        var tipo_modelo_pk = "";
        var tipo_envio_pk = "";
        var modelo_ds_email = "";
        var html_modelo = "";


        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "modelo_proposta_pk";
        arrKeys[1] = "operador_pk";
        arrKeys[2] = "status_pk";
        arrKeys[3] = "tipo_modelo_pk";
        arrKeys[4] = "tipo_envio_pk";
        arrKeys[5] = "ds_email";
        arrKeys[6] = "html_modelo";
        
        var  data = tblModeloProposta.rows().data();
        
        for(i = 0; i< data.length; i++){

            modelos_etapas_pk = data[i]['t_pk'];
            operador_pk =  data[i]['t_operador_pk'];
            tipo_modelo_pk =  data[i]['t_tipo_modelo_pk'];
            tipo_envio_pk =  data[i]['t_tipo_envio_pk'];
            modelo_ds_email =  data[i]['t_ds_email'];
            html_modelo =  data[i]['t_html_modelo'];
            ic_status_modelo =  data[i]['t_status_pk'];          
            
            arrDados[i] = [modelos_etapas_pk,operador_pk,ic_status_modelo,tipo_modelo_pk,tipo_envio_pk,modelo_ds_email,html_modelo];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}

function fcLimparFormModeloProposta(){
    $("#acao").val("");
    $("#modelo_proposta_pk").val("");
    $("#modelo_operador_pk").val("");
    $("#tipo_modelo_pk").val("");
    $("#tipo_envio_pk").val("");
    $("#modelo_ds_email").val("");         
    $("#html_modelo").val("");          
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoModeloProposta(){

    //limpa os dados de qualquer registro existe
    fcLimparFormModeloProposta();
    
    $("#janela_modelo_proposta").modal();
    $("#acao").val("ins");
    $("#modelo_proposta_pk").val("");
}

function fcValidarFormModeloProposta(){
    
    $("#form_polo_modelo_proposta").validate({
        rules :{
            tipo_modelo_pk:{
                required:true
            },
            tipo_envio_pk:{
                required:true
            },
            html_modelo:{
                required:true
            },
            modelo_operador_pk:{
                required:true
            },
            ic_status_modelo:{
                required:true
            }
        },
        messages:{
            tipo_modelo_pk:{
                required:"Por favor, informe o Tipo Modelo"
            },
            tipo_envio_pk:{
                required:"Por favor, informe o Tipo Envio"
            },
            html_modelo:{
                required:"Por favor, informe a HTML"
            },
            modelo_operador_pk:{
                required:"Por favor, informe a Operadora"
            },
            ic_status_modelo:{
                required:"Por favor, informe o Status"
            }   
        },
        submitHandler: function(form){
            fcEnviarModeloProposta(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcCarregarOperadorModeloProposta(){ 
    var objParametros = {
        "pk": ""
    };       
    var arrCarregar = carregarController("operador", "listarTodos", objParametros); 
    carregarComboAjax($("#modelo_operador_pk"), arrCarregar, " ", "pk", "ds_operador");        
}

$(document).ready(function(){  
    
    //var arrCarregar = permissao("polos_esteiraes", "cons");        
        
    /*if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/

    fcCarregarOperadorModeloProposta();  

    $(document).on('click', '#btn_modal_modelo_proposta', fcAbrirFormNovoModeloProposta);  
    
    fcCarregarGridModeloProposta();
    
   fcValidarFormModeloProposta();
});