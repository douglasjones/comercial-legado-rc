var tblTelefone;

function fcCarregarGridTelefone(){
    
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
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 src='../img/whatsapp.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "ic_status", visible:false},
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
    
    
    //Atribui os eventos na coluna ação.
    $('#tblTelefone tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblTelefone.row( $(this).parents('li')).data()){
            data = tblTelefone.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblTelefone.row( $(this).parents('tr')).data()){
            data = tblTelefone.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarTelefone(data);
        
    } );   
    
    $('#tblTelefone tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblTelefone.row( $(this).parents('li') ).data()){
            data = tblTelefone.row( $(this).parents('li') ).data();
        }
        else if(tblTelefone.row( $(this).parents('tr') ).data()){
            data = tblTelefone.row( $(this).parents('tr') ).data();
        }
        
        if(data['pk'] != ""){
            fcExcluirTelefone(data['pk']);
        }
        tblTelefone.row($(this).parents('tr')).remove().draw();
    } );
    $('#tblTelefone tbody').on('click', '.function_painel', function () {
        var data;
        
        if(tblTelefone.row( $(this).parents('li') ).data()){
            data = tblTelefone.row( $(this).parents('li') ).data();
        }
        else if(tblTelefone.row( $(this).parents('tr') ).data()){
            data = tblTelefone.row( $(this).parents('tr') ).data();
        }
        if(data['tipo_telefone_pk']!=1){
            fcAbrirMensagemWhatsAppTel(data);
        }
            
        
    } ); 
    
    
    return false;
}

function fcAbrirMensagemWhatsAppTel(objRegistro){
    var str =  objRegistro['ds_ddd_tel'];
    var telefone = str.replace(/[^\d]+/g,'');
    var url = "https://api.whatsapp.com/send?phone=55"+telefone+"&text=Olá"
    
    window.open(url, '_blank');
}

function fcEditarTelefone(objRegistro){
     var arrCarregar = permissao("telefone", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    fcLimparFormTelefone();
    $("#janela_telefone").modal();
    $("#lead_telefone_pk").val("");
    $("#acao").val("upd");
    
    //Carrega as informações da linha selecionada.
    $("#lead_telefone_pk").val(objRegistro['pk']);
    $("#tipo_telefone_pk").val(objRegistro['tipo_telefone_pk']);
    $("#ds_tel").val(objRegistro['ds_ddd_tel']); 
    $("#ic_status").val(objRegistro['ic_status']); 
}

function fcExcluirTelefone(v_pk){
    var arrCarregar = permissao("telefone", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("telefone", "excluir", objParametros);   

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

function fcBotoesGridTelefone(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcEnviarTelefone(){
        if(pk == ""){
            if($("#acao").val() == "ins"){
                fcIncluirTelefoneSemPk();
            }
            else if($("#acao").val() == "upd"){
                fcEditarTelefoneSemPk();
            }
        }
        else{
            fcSalvarTelefone();
        }   
        $("#janela_telefone").modal("hide");
}

function fcRecarregarGridTelefone(){
    tblTelefone.clear().destroy();    
    fcCarregarGridTelefone();
}

function fcSalvarTelefone(){
    
    
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#lead_telefone_pk").val(),
        "leads_pk": pk,
        "ds_tel": $("#ds_tel").val(),
        "tipo_telefone_pk": $("#tipo_telefone_pk").val(),
        "ic_status": $("#ic_status").val(),
        "polos_pk": $("#polos_pk").val()
    }; 
    var arrEnviar = carregarController("telefone", "salvar", objParametros);
    if (arrEnviar.result == 'success'){
        fcRecarregarGridTelefone();
    }    
    else{
        alert(arrEnviar.result);
    }
    
}

function fcIncluirTelefoneSemPk(){  
    tblTelefone.row.add(
        {
            "pk":"",
            "tipo_telefone_pk":$("#tipo_telefone_pk").val(),
            "ds_tipo_telefone":$("#tipo_telefone_pk option:selected").text(),
            "ds_ddd_tel":$("#ds_tel").val(),
            "ic_status":$("#ic_status").val(),
            "t_functions":""
        }
    ).draw();
    
    return false;
}

function fcExcluirTelefoneSemPk(){
   tblTelefone.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcEditarTelefoneSemPk(){
    
    fcIncluirTelefoneSemPk();
    tblTelefone.row(rLinhaSelecionada).remove().draw();
    return false;
}



function fcFormatarDadosTelefone(){
    
    
    try{


        var lead_telefone_pk = "";
        var ds_tel = "";
        var ic_status = "";
        var tipo_telefone_pk = "";


        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "lead_telefone_pk";
        arrKeys[1] = "ds_tel";
        arrKeys[2] = "ic_status";
        arrKeys[3] = "tipo_telefone_pk";
        
        var  data = tblTelefone.rows().data();
        
        for(i = 0; i< data.length; i++){

            lead_telefone_pk = data[i]['pk'];
            ds_tel =  data[i]['ds_ddd_tel'];
            tipo_telefone_pk =  data[i]['tipo_telefone_pk'];
            ic_status =  data[i]['ic_status'];

            
            
            arrDados[i] = [lead_telefone_pk, ds_tel,ic_status,tipo_telefone_pk];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}


function fcLimparFormTelefone(){
    $("#acao").val("");
    $("#lead_telefone_pk").val("");
    $("#ds_ddd").val("");
    $("#ds_tel").val("");      
    $("#tipo_telefone_pk").val("");      
    //$("#ic_status").val("");      
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoTelefone(){
    //limpa os dados de qualquer registro existe
    fcLimparFormTelefone();
    
    $("#janela_telefone").modal();
    $("#acao").val("ins");
    $("#lead_telefone_pk").val("");
}

function fcValidarFormTelefone(){
    
    $("#form_lead_telefone").validate({
        rules :{
            tipo_telefone_pk:{
                required:true
            },
            ds_tel:{
                required:true
            }

        },
        messages:{
            tipo_telefone_pk:{
                required:"Por favor, informe Tipo Telefone"
            },
            ds_tel:{
                required:"Por favor, informe Telefone"
            }

        },
        submitHandler: function(form){
            fcEnviarTelefone(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}
$(document).ready(function(){  

    fcCarregarGridTelefone();
    var arrCarregar = permissao("telefone", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
        
    $(document).on('click', '#btn_modal_telefone', fcAbrirFormNovoTelefone);
     $("#ds_tel").keypress(function(){
        mascara(this, mascaraTelefone);
        
      });
    
    fcValidarFormTelefone();
});
