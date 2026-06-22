var tblPermissoes;
var strComboModulos = "";

function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_grupo:{
                required:true,
                minlength:3
            }
        },
        messages:{
            ds_grupo:{
                required:"Por favor, informe o Grupo do grupo",
                minlength:"O nome deve ter pelo menos 3 caracteres"
            }
        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}
function fcEnviar(){

    var strJSONDadosTabela = fcFormatarDadosModulos();

    var v_ds_grupo = $("#ds_grupo").val();
    var v_polos_pk = $("#polos_pk").val();

    var url = '../controller/grupo.controller.php?job=salvar&token='+token+'&pk=' + pk + '&ds_grupo=' + (v_ds_grupo) +'&polos_pk='+v_polos_pk+ '&grupos_modulos_pk='+(strJSONDadosTabela);
    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            // Reload datable
            alert(output.message);
            sendPost("grupo_res_form.php", {token: token});
        }
        else{
            alert('Falhou a requisição para salvar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falhou a requisição para salvar o registro: ' + textStatus);
    });

}

function fcCancelar(){
    sendPost("grupo_res_form.php", {token: token});
}

function fcFormatarGrid(){
        
    tblPermissoes = $("#tblPermissoes").DataTable({
        "scrollX": true,
        "responsive": true,
        "searching": false,
        "paging": false,
        "columnDefs" : [{
            orderable: false,
            targets: [1,2,3,4,5]
        }],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    
    return false;
    
}

function carregarListaCombo(){

    var url = '../controller/modulo.controller.php?job=listarTodos&token='+token;

    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            strComboModulos = "<select id='modulos_pk' name='modulos_pk'><option></option>";
            for(i = 0; i < output.data.length; i++){
                strComboModulos = strComboModulos + "<option value='"+output.data[i]['pk']+"'>"+output.data[i]['ds_modulo']+"</option>";
            }
            strComboModulos += "</select>";
            
            //Carrega os dados no combo.
            fcFormatarGrid();
            
            fcAtualizarDadosGrid();
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}






function fcAtualizarDadosGrid(){
    
    var v_url = "../controller/grupo.controller.php?job=listarPermissoesGrupo&token="+token+"&pk="+pk;
    var request = $.ajax({
        url:          v_url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    
    request.done(function(output){
        if (output.result == 'success'){
            for(i = 0; i < output.data.length; i++){

                //Adiciona a linha.
                fcIncluirPermissao();

                //Pega as variaveis 
                var cboModulosPk = $("select[id='modulos_pk']");
                var chkIns = $("input[id='ic_ins']");
                var chkUpd = $("input[id='ic_upd']");
                var chkDel = $("input[id='ic_del']");
                var chkCons = $("input[id='ic_cons']");
                
                cboModulosPk.get(i).value = output.data[i]['t_modulos_pk'];
                if(output.data[i]['t_ic_ins'] == 1)
                    chkIns.get(i).checked = true;
                if(output.data[i]['t_ic_upd'] == 1)
                    chkUpd.get(i).checked = true;
                if(output.data[i]['t_ic_del'] == 1)
                    chkDel.get(i).checked = true;
                if(output.data[i]['t_ic_cons'] == 1)
                    chkCons.get(i).checked = true;
            }
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });    
    
}

function fcIncluirPermissao(){
    
    tblPermissoes.row.add(
            [strComboModulos,
             "<input type='checkbox' id='ic_cons' />",
             "<input type='checkbox' id='ic_ins' />",
             "<input type='checkbox' id='ic_upd' />",
             "<input type='checkbox' id='ic_del' />",
             "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcExcluirLinha);
    
    return false;
}

function fcExcluirLinha(){
    
    tblPermissoes.row($(this).parents('tr')).remove().draw();
    
    return false;
}

function fcCarregar(){

    if(pk > 0){
        var url = '../controller/grupo.controller.php?job=listarPk&token='+token+'&pk=' + pk;
        var request = $.ajax({
            url:          url,
            cache:        false,
            dataType:     'json',
            contentType:  'application/json; charset=utf-8',
            type:         'post'
        });
        request.done(function(output){
            if (output.result == 'success'){
                $("#ds_grupo").val(output.data[0]['ds_grupo']);
                $("#polos_pk").val(output.data[0]['polos_pk']);
            }
            else{
                alert('Falhar ao carregar o registro');
            }
        });
        request.fail(function(jqXHR, textStatus){
            alert('Falha ao carregar o registro: ' + textStatus);
        });
    }
}

function fcFormatarDadosModulos(){

    var cboModulosPk = $("select[id='modulos_pk']");
    var chkIns = $("input[id='ic_ins']");
    var chkUpd = $("input[id='ic_upd']");
    var chkDel = $("input[id='ic_del']");
    var chkCons = $("input[id='ic_cons']");
    
    var arrKeys = [];
    arrKeys[0] = "modulos_pk";
    arrKeys[1] = "ic_ins";
    arrKeys[2] = "ic_upd";
    arrKeys[3] = "ic_del";
    arrKeys[4] = "ic_cons";
    
    var arrDados = [];

    var v_ic_ins = 2;
    var v_ic_upd = 2;
    var v_ic_del = 2;
    var v_ic_cons = 2;    
    
    for(i = 0; i < cboModulosPk.length; i++){
        
        if(cboModulosPk.get(i).value == ""){
            cboModulosPk.get(i).focus();
            return false;
        }
        
        v_ic_ins = 2;
        v_ic_upd = 2;
        v_ic_del = 2;
        v_ic_cons = 2;          
        
        if(chkIns.get(i).checked)
            v_ic_ins = 1;
        if(chkUpd.get(i).checked)
            v_ic_upd = 1;
        if(chkDel.get(i).checked)
            v_ic_del = 1;
        if(chkCons.get(i).checked)
            v_ic_cons = 1;
        
        arrDados[i] = [cboModulosPk.get(i).value, v_ic_ins, v_ic_upd, v_ic_del, v_ic_cons];
        
    }
    
    return arrayToJson(arrKeys, arrDados);
    
}

function fcCarregarPolo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPk", objParametros); 
   
    carregarComboAjax($("#polos_pk"), arrCarregar, " ", "pk", "ds_polo");
        
}

$(document).ready(function()
    {
        var arrCarregar = permissao("grupo", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
        
        $(document).on('click', '#cmdIncluir', fcIncluirPermissao);
        
        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();
       
        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregarPolo();
         
        fcCarregar();
       
        //Monta a string com o combo dos módulos.
        carregarListaCombo();
  
        //Carrega o grid com os módulos e suas atribuições.
    }
);
