var tblOperador;

function fcCarregarGridOperador(){

    var objParametros = {
        "polos_pk": pk
    };     
    
    var v_url = montarUrlController("polo_operador", "listarPorPolo", objParametros);


    //Trata a tabela
    tblOperador = $('#tblOperador').DataTable({
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
           {"targets": -3, "data": "ic_status_operador", visible:false}, 
           {"targets": -4, "data": "ds_operador"},
           {"targets": -5, "data": "operador_pk", visible:false},           
           {"targets": -6, "data": "ds_segmento"},
           {"targets": -7, "data": "segmentos_pk", visible:false},
           {"targets": -8, "data": "pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });   
    
    //Atribui os eventos na coluna ação.
    $('#tblOperador tbody').on('click', '.function_edit', function () {
        var data;    
      
        rLinhaSelecionada = null;
        
        if(tblOperador.row( $(this).parents('li')).data()){
            data = tblOperador.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblOperador.row( $(this).parents('tr')).data()){
            data = tblOperador.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarOperador(data);        
    } );   
    
    $('#tblOperador tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblOperador.row( $(this).parents('li') ).data()){
            data = tblOperador.row( $(this).parents('li') ).data();
        }
        else if(tblOperador.row( $(this).parents('tr') ).data()){
            data = tblOperador.row( $(this).parents('tr') ).data();
        }
        if(data['pk'] != ""){
            fcExcluirOperador(data['pk']);
        }
        tblOperador.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}


function fcEditarOperador(objRegistro){
    fcLimparFormOperador();
    $("#janela_operador").modal();
    $("#polos_operadores_pk").val("");
    $("#acao").val("upd");
    
    //Carrega as informações da linha selecionada.
    $("#polos_operadores_pk").val(objRegistro['pk']);
    $("#segmentos_pk").val(objRegistro['segmentos_pk']);
    fcCarregarOperador();
    $("#operador_pk").val(objRegistro['operador_pk']);
    $("#ic_status_operador").val(objRegistro['ic_status_operador']);     
}

function fcExcluirOperador(v_pk){
    
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("polo_operador", "excluir", objParametros);   
  
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

function fcEnviarOperador(){
    
    if(pk == ""){
       if($("#acao").val() == "ins"){
           fcIncluirOperadorSemPk();
       }else if($("#acao").val() == "upd"){
           fcEditarOperadorSemPk();
       }
   }else{
       fcSalvarOperador();
   }   
   $("#janela_operador").modal("hide");
}

function fcRecarregarGridOperador(){
    tblOperador.clear().destroy();    
    fcCarregarGridOperador();
}

function fcSalvarOperador(){   

    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#polos_operadores_pk").val(),
        "polos_pk": pk,
        "segmentos_pk": $("#segmentos_pk").val(),
        "operador_pk": $("#operador_pk").val(),
        "ic_status_operador": $("#ic_status_operador").val()
     
    }; 
    var arrEnviar = carregarController("polo_operador", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        fcRecarregarGridOperador();
    }    
    else{
        alert(arrEnviar.result);
    }
}

function fcIncluirOperadorSemPk(){   

    tblOperador.row.add(
        {
            "pk":"",
            "segmentos_pk":$("#segmentos_pk").val(),
            "ds_segmento":$("#segmentos_pk option:selected").text(),
            "operador_pk":$("#operador_pk").val(),
            "ds_operador":$("#operador_pk option:selected").text(),
            "ic_status_operador":$("#ic_status_operador").val(),
            "ds_status":$("#ic_status_operador option:selected").text(),
            "t_functions":""
        }
    ).draw();    
    return false;
}

function fcBotoesGridOperador(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcRecarregarGridOperador(){
    tblOperador.clear().destroy();    
    fcCarregarGridOperador();
}

function fcExcluirOperadorSemPk(){
   tblOperador.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcFormatarDadosOperador(){      
    try{
        var polos_operadores_pk = "";
        var segmentos_pk = "";
        var ic_status_operador = "";
        var operador_pk = "";


        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "polos_operadores_pk";
        arrKeys[1] = "segmentos_pk";
        arrKeys[2] = "operador_pk";
        arrKeys[3] = "ic_status_operador";
        
        var  data = tblOperador.rows().data();
        
        for(i = 0; i< data.length; i++){

            polos_operadores_pk = data[i]['pk'];
            segmentos_pk =  data[i]['segmentos_pk'];
            operador_pk =  data[i]['operador_pk'];
            ic_status_operador =  data[i]['ic_status_operador'];          
            
            arrDados[i] = [polos_operadores_pk,segmentos_pk,operador_pk,ic_status_operador];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}

function fcLimparFormOperador(){
    $("#acao").val("");
    $("#polos_operadores_pk").val("");
    $("#segmentos_pk").val("");
    $("#operador_pk").val("");
    //$("#ic_status_operador").val("");      
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoOperador(){
    
    //limpa os dados de qualquer registro existe
    fcLimparFormOperador();
    
    $("#janela_operador").modal();
    $("#acao").val("ins");
    $("#polos_operadores_pk").val("");
}

function fcValidarFormOperador(){
    
    $("#form_polo_operador").validate({
        rules :{
            segmento_pk:{
                required:true
            },
            operador_pk:{
                required:true
            },
            ic_status_operador:{
                required:true
            }
        },
        messages:{
            segmento_pk:{
                required:"Por favor, informe o Segmento"
            },
            operador_pk:{
                required:"Por favor, informe o Operador"
            },
            ic_status_operador:{
                required:"Por favor, informe o Status"
            }   
        },
        submitHandler: function(form){
            fcEnviarOperador(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function fcCarregarSegmento(){
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("segmento", "listarTodos", objParametros);    
  
    carregarComboAjax($("#segmentos_pk"), arrCarregar, " ", "pk", "ds_segmento");
        
}

function fcCarregarOperador(){ 
    var objParametros = {
        "pk": "",
        "segmentos_pk":$("#segmentos_pk").val()
    };       
    var arrCarregar = carregarController("operador", "listarTodos", objParametros); 
   
    carregarComboAjax($("#operador_pk"), arrCarregar, " ", "pk", "ds_operador");        
}

$(document).ready(function(){      
    var arrCarregar = permissao("polos_operadores", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    
    fcCarregarSegmento();

     $("#segmentos_pk").change(function(){
        fcCarregarOperador();
    });    

    $(document).on('click', '#btn_modal_operador', fcAbrirFormNovoOperador);  
    
    fcCarregarGridOperador();
    
   fcValidarFormOperador();
});