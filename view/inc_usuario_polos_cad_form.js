var tblPolo;

function fcCarregarGridPolo(){
    
    var objParametros = {
        "usuarios_pk": pk
    };     
    
    var v_url = montarUrlController("usuario_polo", "listarPolosUsuario", objParametros);
    
    //Trata a tabela
    tblPolo = $('#tblPolo').DataTable({
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
           
           {"targets": -2, "data": "ds_polo"},
           {"targets": -3, "data": "polos_pk","visible":false},
           {"targets": -4, "data": "pk"},
           
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblPolo tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblPolo.row( $(this).parents('li')).data()){
            data = tblPolo.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblPolo.row( $(this).parents('tr')).data()){
            data = tblPolo.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarPolo(data);        
    } );   
    
    $('#tblPolo tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblPolo.row( $(this).parents('li') ).data()){
            data = tblPolo.row( $(this).parents('li') ).data();
        }
        else if(tblPolo.row( $(this).parents('tr') ).data()){
            data = tblPolo.row( $(this).parents('tr') ).data();
        }
        if(data['pk'] != null){
            fcExcluirPolo(data['pk']);
        }
        tblPolo.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}


function fcEditarPolo(objRegistro){

    fcLimparFormPolo();
   
    $("#janela_polo").modal();
    $("#usuario_polos_pk").val("");
    $("#acao").val("upd");
    fcCarregarPolo(); 
    //Carrega as informações da linha selecionada.    
    $("#polos_pk").val(objRegistro['polos_pk']);
    $("#usuario_polos_pk").val(objRegistro['pk']);
}

function fcExcluirPolo(v_pk){
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("usuario_polo", "excluir", objParametros);   

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

function fcBotoesGridPolo(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcEnviarPolo(){
        if(pk == ""){
            if($("#acao").val() == "ins"){         
                fcIncluirPoloSemPk();
            }
            else if($("#acao").val() == "upd"){       
                fcEditarPoloSemPk();
            }
        }
        else{
             fcSalvarPolo();
        }   
        $("#janela_polo").modal("hide");
}

function fcRecarregarGridPolo(){
    tblPolo.clear().destroy();    
    fcCarregarGridPolo();
}

function fcSalvarPolo(){   
    
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#usuario_polos_pk").val(),
        "usuarios_pk": pk,
        "polos_pk": $("#polos_pk").val()
    }; 
    
    var arrEnviar = carregarController("usuario_polo", "salvar", objParametros);
    
    if (arrEnviar.result == 'success'){
        fcRecarregarGridPolo();
    }    
    else{
        alert(arrEnviar.result);
    }
    
}

function fcIncluirPoloSemPk(){    
    
    tblPolo.row.add(
        {
            "pk":"",
            "polos_pk":$("#polos_pk").val(),
            "ds_polo":$("#polos_pk option:selected").text(),
            "t_functions":""
        }
    ).draw();
    
    return false;
}

function fcExcluiPoloSemPk(){
   tblPolo.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcEditarPoloSemPk(){
    
    fcIncluirPoloSemPk();
    tblPolo.row(rLinhaSelecionada).remove().draw();
    return false;
}

function fcFormatarDadosPolo(){   
    
    try{
        var usuario_polos_pk = "";
        var polos_pk = "";

        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "usuario_polos_pk";
        arrKeys[1] = "polos_pk";
        
        var  data = tblPolo.rows().data();
        
        for(i = 0; i< data.length; i++){
            usuario_polos_pk = data[i]['pk'];
            polos_pk = data[i]['polos_pk'];
                      
            arrDados[i] = [usuario_polos_pk, polos_pk];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}


function fcLimparFormPolo(){
    $("#acao").val("");
    $("#usuario_polos_pk").val("");
    $("#polos_pk").val("");  
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoPolo(){
    
    //limpa os dados de qualquer registro existe
    fcLimparFormPolo();
    
    $("#janela_polo").modal();    
    $("#acao").val("ins");
    $("#usuario_polos_pk").val("");
}

function fcValidarFormPolo(){
    
    $("#form_usuario_polo").validate({
        rules :{
            polos_pk:{
                required:true
            }
        },
        messages:{
            polos_pk:{
                required:"Por favor, informe Polo"
            }
        },
        submitHandler: function(form){
            fcEnviarPolo(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}
function fcCarregarPolo(){

    var objParametros = {
        "contas_pk": $("#contas_pk").val()
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPkSelecionado", objParametros); 

   
    carregarComboAjax($("#polos_pk"), arrCarregar, " ", "pk", "ds_polo");
        
}

$(document).ready(function(){      

    $(document).on('click', '#btn_modal', fcAbrirFormNovoPolo);

    fcCarregarPolo();
    $("#contas_pk").change(function(){
        fcCarregarPolo();
    });
        
    fcValidarFormPolo();
    
    fcCarregarGridPolo();
});