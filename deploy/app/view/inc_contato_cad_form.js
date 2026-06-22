var tblLeadContatos;
function fcCarregarGridContato(){
   
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
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 src='../img/whatsapp.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_cargos_pk","visible":false},
           {"targets": -3, "data": "t_ds_cargos_pk"},
           {"targets": -4, "data": "t_ds_tel"},
           {"targets": -5, "data": "t_ic_whatsapp","visible":false},
           {"targets": -6, "data": "t_ds_whatsapp"},
           
           {"targets": -7, "data": "t_ds_cel"},
           {"targets": -8, "data": "t_ds_email"},
           {"targets": -9, "data": "t_ds_contato"},
           {"targets": -10, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblLeadContatos tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblLeadContatos.row( $(this).parents('li')).data()){
            data = tblLeadContatos.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblLeadContatos.row( $(this).parents('tr')).data()){
            data = tblLeadContatos.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarContato(data);
        
    } );   
    
    $('#tblLeadContatos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblLeadContatos.row( $(this).parents('li') ).data()){
            data = tblLeadContatos.row( $(this).parents('li') ).data();
        }
        else if(tblLeadContatos.row( $(this).parents('tr') ).data()){
            data = tblLeadContatos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirContato(data['t_pk']);
        }
        tblLeadContatos.row($(this).parents('tr')).remove().draw();
    } ); 
    $('#tblLeadContatos tbody').on('click', '.function_painel', function () {
        var data;
        
        if(tblLeadContatos.row( $(this).parents('li') ).data()){
            data = tblLeadContatos.row( $(this).parents('li') ).data();
        }
        else if(tblLeadContatos.row( $(this).parents('tr') ).data()){
            data = tblLeadContatos.row( $(this).parents('tr') ).data();
        }
        if(data['t_ic_whatsapp']==1){
            fcAbrirMensagemWhatsApp(data);
        }
        
    } ); 
    
    return false;
}

function fcAbrirMensagemWhatsApp(objRegistro){
    var str =  objRegistro['t_ds_cel'];
    var telefone = str.replace(/[^\d]+/g,'');
    
    var url = "https://api.whatsapp.com/send?phone=55"+telefone+"&text=Olá"
    
    window.open(url, '_blank');
}
function fcEditarContato(objRegistro){
    var arrCarregar = permissao("contato", "upd");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    fcLimparFormContato();
    $("#janela_contatos").modal();
    $("#contatos_pk").val("");
    $("#acao").val("upd");
    
    //Carrega as informações da linha selecionada.
    $("#contatos_pk").val(objRegistro['t_pk']);
    $("#ds_contato").val(objRegistro['t_ds_contato']);
    $("#ds_email").val(objRegistro['t_ds_email']);
    $("#ds_cel").val(objRegistro['t_ds_cel']);
    $("#ic_whatsapp").val(objRegistro['t_ic_whatsapp']);
    $("#ds_tel_contato").val(objRegistro['t_ds_tel']);
    $("#cargos_pk").val(objRegistro['t_cargos_pk']);  
    
}

function fcExcluirContato(v_pk){
    var arrCarregar = permissao("contato", "del");        

    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("contato", "excluir", objParametros);   
     
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

function fcBotoesGridContatos(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcEnviarContato(){
        if(pk == ""){
            if($("#acao").val() == "ins"){
                fcIncluirContatoSemPk();
            }
            else if($("#acao").val() == "upd"){
                fcEditarContatoSemPk();
            }
        }
        else{
            fcSalvarContato();
        }   
        $("#janela_contatos").modal("hide");
}

function fcRecarregarGridContatos(){
   
    tblLeadContatos.clear().destroy();    
    fcCarregarGridContato();
}

function fcSalvarContato(){
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#contatos_pk").val(),
        "leads_pk": pk,
        "ds_contato": $("#ds_contato").val(),
        "ds_email": $("#ds_email").val(),
        "ds_cel": $("#ds_cel").val(),
        "ds_tel": $("#ds_tel_contato").val(),
        "ic_whatsapp": $("#ic_whatsapp").val(),
        "cargos_pk": $("#cargos_pk").val(), 
        "polos_pk": $("#polos_pk").val()
        
    }; 
    var arrEnviar = carregarController("contato", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        fcRecarregarGridContatos();
    }    
    else{
        alert(arrEnviar.result);
    }
    
}

function fcIncluirContatoSemPk(){      
    tblLeadContatos.row.add(
        {
            "t_pk":"",
            "t_ds_contato":$("#ds_contato").val(),
            "t_ds_email":$("#ds_email").val(),
            "t_ds_cel":$("#ds_cel").val(),
            "t_ic_whatsapp":$("#ic_whatsapp").val(),
            "t_ds_whatsapp":$("#ic_whatsapp option:selected").text(),
            "t_ds_tel":$("#ds_tel_contato").val(),
            "t_cargos_pk":$("#cargos_pk").val(),
            "t_ds_cargos_pk":$("#cargos_pk option:selected").text(),
            "t_functions":""
        }
    ).draw();
    
    return false;
}

function fcExcluirContatoSemPk(){
   tblLeadContatos.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcEditarContatoSemPk(){
    
    fcIncluirContatoSemPk();
    tblLeadContatos.row(rLinhaSelecionada).remove().draw();
    return false;
}


function fcCarregarCargo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("cargo", "listarTodos", objParametros);    
    carregarComboAjax($("#cargos_pk"), arrCarregar, " ", "pk", "ds_cargo");
        
}


function fcFormatarDadosContato(){
    
    
    try{


        var contatosPk = "";
        var dsContato = "";
        var dsEmail =  "";
        var dsCel = "";
        var icWhatsapp = "";
        var dsTelContato = "";
        var cboCargosPk = "";


        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "contatos_pk";
        arrKeys[1] = "ds_contato";
        arrKeys[2] = "ds_email";
        arrKeys[3] = "ds_cel";
        arrKeys[4] = "ic_whatsapp";
        arrKeys[5] = "ds_tel_contato";
        arrKeys[6] = "cargos_pk";
        
        var  data = tblLeadContatos.rows().data();
        
        for(i = 0; i< data.length; i++){

            contatosPk = data[i]['t_pk'];
            dsContato = data[i]['t_ds_contato'];
            dsEmail =  data[i]['t_ds_email'];
            dsCel = data[i]['t_ds_cel'];
            icWhatsapp = data[i]['t_ic_whatsapp'];
            dsTelContato = data[i]['t_ds_tel'];
            cboCargosPk = data[i]['t_cargos_pk'];
            
            
            arrDados[i] = [contatosPk, dsContato, dsEmail, dsCel, icWhatsapp, dsTelContato, cboCargosPk];
                        
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}


function fcLimparFormContato(){
    $("#acao").val("");
    $("#contatos_pk").val("");
    $("#ds_contato").val("");
    $("#ds_email").val("");
    $("#ds_cel").val("");
    $("#ic_whatsapp").val("");
    $("#ds_tel_contato").val("");
    $("#cargos_pk").val("");        
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoContato(){
    
    //limpa os dados de qualquer registro existe
    fcLimparFormContato();
    
    $("#janela_contatos").modal();
    $("#acao").val("ins");
    $("#contatos_pk").val("");
}

function fcValidarFormContato(){
    
    $("#form_contato").validate({
        rules :{
            ds_contato:{
                required:true,
                minlength:3
            },
            ds_cel:{
                minlength:13
            },
            ds_tel_contato:{
                minlength:13
            },
            ds_email:{
                email: true
            }
        },
        messages:{
            ds_contato:{
                required:"Por favor, informe Contato",
                minlength:"Contato deve ter pelo menos 3 caracteres"
            },
            ds_cel:{
                minlength:"Por favor, informe Celular válido"
            },
            ds_tel_contato:{
                minlength:"Por favor, informe Telefone válido"
            },
            ds_email:{
                email:"Por favor, informe E-mail válido"
            }

        },
        submitHandler: function(form){
            fcEnviarContato(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}
$(document).ready(function()
    {
        //Carrega os dados do campo de Cargo na tela modal dos contatos
        fcCarregarCargo();
        
        //Formata a grid de contatoss
        fcCarregarGridContato();
        
        var arrCarregar = permissao("contato", "cons");        
        
        if (arrCarregar.result != 'success'){            
            alert('Você não tem permissão');
            return false;
        }
        //Atribui os eventos - Leads
        $(document).on('click', '#btn_modal_contato', fcAbrirFormNovoContato);
        //atribui mascara aos campos - Lead        
        fcValidarFormContato();  
        //---------------------------------------------
        //atribui mascara aos campos - Contato
        $("#ds_tel_contato").keypress(function(){
          mascara(this, mascaraTelefone);
        });
        $("#ds_cel").keypress(function(){
          mascara(this, mascaraTelefone);
        });        
        
       
    }
);