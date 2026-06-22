var tblResponsavel;

function fcCarregarGridResponsavel(){
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("lead_responsavel", "listarPorLead", objParametros);
   
    //Trata a tabela
    tblResponsavel = $('#tblResponsavel').DataTable({
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
           
           {"targets": -2, "data": "ds_usuario"},
           {"targets": -3, "data": "ds_grupo"},
           {"targets": -4, "data": "usuarios_pk","visible":false},
           {"targets": -5, "data": "grupos_pk","visible":false},
           {"targets": -6, "data": "pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblResponsavel tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblResponsavel.row( $(this).parents('li')).data()){
            data = tblResponsavel.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblResponsavel.row( $(this).parents('tr')).data()){
            data = tblResponsavel.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarResponsavel(data);
        
    } );   
    
    $('#tblResponsavel tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblResponsavel.row( $(this).parents('li') ).data()){
            data = tblResponsavel.row( $(this).parents('li') ).data();
        }
        else if(tblResponsavel.row( $(this).parents('tr') ).data()){
            data = tblResponsavel.row( $(this).parents('tr') ).data();
        }
        
        if(data['pk'] != ""){
            fcExcluirResponsavel(data['pk']);
        }
        tblResponsavel.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}


function fcEditarResponsavel(objRegistro){
    var arrCarregar = permissao("responsavel", "upd");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    fcLimparFormResponsavel();
    $("#janela_responsavel").modal();
    $("#lead_responsavel_pk").val("");
    $("#acao").val("upd");
    //Carrega as informações da linha selecionada.
    
    $("#grupos_pk").val(objRegistro['grupos_pk']);
    fcCarregarResponsavel();
    $("#usuarios_pk").val(objRegistro['usuarios_pk']);
    
    
    
    $("#lead_responsavel_pk").val(objRegistro['pk']); 
    
}

function fcExcluirResponsavel(v_pk){
    /* var arrCarregar = permissao("responsavel", "del");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("lead_responsavel", "excluir", objParametros);   

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

function fcBotoesGridResponsavel(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcEnviarResponsavel(){
        if(pk == ""){
            if($("#acao").val() == "ins"){
                fcIncluirResponsavelSemPk();
            }
            else if($("#acao").val() == "upd"){
                fcEditarResponsavelSemPk();
            }
        }
        else{
            fcSalvarResponsavel();
        }   
        $("#janela_responsavel").modal("hide");
}

function fcRecarregarGridResponsavel(){
    tblResponsavel.clear().destroy();    
    fcCarregarGridResponsavel();
}

function fcSalvarResponsavel(){
    
    
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#lead_responsavel_pk").val(),
        "leads_pk": pk,
        "usuarios_pk": $("#usuarios_pk").val(),
        "grupos_pk": $("#grupos_pk").val(),
        "polos_pk": $("#polos_pk").val()
    }; 
    var arrEnviar = carregarController("lead_responsavel", "salvar", objParametros);
    if (arrEnviar.result == 'success'){
        fcRecarregarGridResponsavel();
    }    
    else{
        alert(arrEnviar.result);
    }
    
}

function fcIncluirResponsavelSemPk(){      
    tblResponsavel.row.add(
        {
            "pk":"",
            "usuarios_pk":$("#usuarios_pk").val(),
            "grupos_pk":$("#grupos_pk").val(),
            "ds_usuario":$("#usuarios_pk option:selected").text(),
            "ds_grupo":$("#grupos_pk option:selected").text(),
            "t_functions":""
        }
    ).draw();
    
    return false;
}

function fcExcluirResponsavelSemPk(){
   tblResponsavel.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcEditarResponsavelSemPk(){
    var arrCarregar = permissao("responsavel", "upd");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    fcIncluirResponsavelSemPk();
    tblResponsavel.row(rLinhaSelecionada).remove().draw();
    return false;
}


function fcCarregarResponsavel(){
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros); 
    
    carregarComboAjax($("#usuarios_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}

function fcCarregarPerfil(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);    
    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
        
}

function fcFormatarDadosResponsavel(){
    
    
    try{


        var lead_responsavel_pk = "";
        var usuarios_pk = "";
        var grupos_pk = "";


        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "lead_responsavel_pk";
        arrKeys[1] = "usuarios_pk";
        arrKeys[2] = "grupos_pk";
        
        var  data = tblResponsavel.rows().data();
        
        for(i = 0; i< data.length; i++){

            lead_responsavel_pk = data[i]['pk'];
            usuarios_pk = data[i]['usuarios_pk'];
            grupos_pk =  data[i]['grupos_pk'];

            
            
            arrDados[i] = [lead_responsavel_pk, usuarios_pk, grupos_pk];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}


function fcLimparFormResponsavel(){
    $("#acao").val("");
    $("#lead_responsavel_pk").val("");
    $("#usuarios_pk").val("");
    $("#grupos_pk").val("");      
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoResponsavel(){
    
    //limpa os dados de qualquer registro existe
    fcLimparFormResponsavel();
    
    $("#janela_responsavel").modal();
    $("#acao").val("ins");
    $("#lead_responsavel_pk").val("");
}

function fcValidarFormResponsavel(){
    
    $("#form_lead_responsavel").validate({
        rules :{
            usuarios_pk:{
                required:true
            },
            grupos_pk:{
                required:true
            }

        },
        messages:{
            usuarios_pk:{
                required:"Por favor, informe Responsável"
            },
            grupos_pk:{
                required:"Por favor, informe Perfil"
            }

        },
        submitHandler: function(form){
            fcEnviarResponsavel(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}

$(document).ready(function(){      
    fcCarregarGridResponsavel();
    var arrCarregar1 = permissao("responsavel", "ins");       

    if (arrCarregar1.result == 'success'){            
        $(document).on('click', '#btn_modal', fcAbrirFormNovoResponsavel);
    }   

   fcCarregarPerfil();  
        
    $("#grupos_pk").change(function(){
        fcCarregarResponsavel();
    });
    
    fcValidarFormResponsavel();
    
    
});