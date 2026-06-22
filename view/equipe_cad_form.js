var tblUsuario;
function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_equipe:{
                required:true,
                minlength:3
            },
            polos_pk:{
                required:true
            }

        },
        messages:{
            ds_equipe:{
                required:"Por favor, informe Equipe",
                minlength:"Equipe deve ter pelo menos 3 caracteres"
            },
            polos_pk:{
                required:"Por favor, selecione Polo"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_equipe = $("#ds_equipe").val();
    var v_polos_pk = $("#polos_pk").val();
    var strJSONDadosTabela = fcFormatarDadosUsuario();

    var objParametros = {
        "pk": pk,
        "ds_equipe": (v_ds_equipe),
        "polos_pk": (v_polos_pk),
        "equipes_usuarios":strJSONDadosTabela
    };    

    var arrEnviar = carregarController("equipe", "salvar", objParametros);  
    
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("equipe_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("equipe_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("equipe", "listarPk", objParametros);
        if (arrCarregar.result == 'success'){
        
            $("#ds_equipe").val(arrCarregar.data[0]['ds_equipe']);
            $("#polos_pk").val(arrCarregar.data[0]['polos_pk']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcCarregarPolo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPk", objParametros); 
   
    carregarComboAjax($("#polos_pk"), arrCarregar, " ", "pk", "ds_polo");
        
}


function carregarListaCombo(){
    
    var objParametros = {
            "pk": ""
        };        
        
        var arrCarregar = carregarController("usuario", "listarTodos", objParametros);
        
        
        if (arrCarregar.result == 'success'){
        
            strComboUsuarios = "<select class='form-control form-control-sm' id='usuarios_pk' name='usuarios_pk'><option></option>";
            for(i = 0; i < arrCarregar.data.length; i++){
                strComboUsuarios = strComboUsuarios + "<option value='"+arrCarregar.data[i]['pk']+"'>"+arrCarregar.data[i]['ds_usuario']+"</option>";
            }
            strComboUsuarios += "</select>";
            
            fcFormatarGrid();
            
            fcAtualizarDadosGrid();
          
        }
        else{
            alert('Falhar ao carregar o registro');
        }
}

function fcFormatarGrid(){
    tblUsuario = $("#tblUsuario").DataTable({
        "responsive": true,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs" : [{
            orderable: false,
            targets: [0,1,2,3]
        }],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    return false;
    
}

function fcAtualizarDadosGrid(){
         var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("equipe", "listarEquipesUsuarios", objParametros);
        
        if (arrCarregar.result == 'success'){
             for(i = 0; i < arrCarregar.data.length; i++){
                fcIncluirUsuario();
                var cboUsuariosPk = $("select[id='usuarios_pk']");
                var chkBko = $("input[id='ic_bko']");
                var chkSupervisor = $("input[id='ic_supervisor']");
                 
                 
                 
                cboUsuariosPk.get(i).value = arrCarregar.data[i]['t_usuarios_pk'];
                if(arrCarregar.data[i]['t_ic_bko'] == 1)
                    chkBko.get(i).checked = true;
                if(arrCarregar.data[i]['t_ic_supervisor'] == 1)
                   chkSupervisor.get(i).checked = true;
             }
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
}

function fcIncluirUsuario(){
    
    tblUsuario.row.add(
            [strComboUsuarios,
            "<input type='checkbox' id='ic_bko' />",
            "<input type='checkbox' id='ic_supervisor' />",
             "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcExcluirLinha);
    
    return false;
}

function fcExcluirLinha(){
    
    tblUsuario.row($(this).parents('tr')).remove().draw();
    
    return false;
}

function fcFormatarDadosUsuario(){

    var cboUsuarioPk = $("select[id='usuarios_pk']");
    var chkBko = $("input[id='ic_bko']");
    var chkSupervisor = $("input[id='ic_supervisor']");
    
    var arrKeys = [];
    arrKeys[0] = "usuarios_pk";
    arrKeys[1] = "ic_bko";
    arrKeys[2] = "ic_supervisor";
    
    var arrDados = []; 
    var v_ic_bko = 2;
    var v_ic_supervisor = 2;
    
    for(i = 0; i < cboUsuarioPk.length; i++){
        
        if(cboUsuarioPk.get(i).value == ""){
            cboUsuarioPk.get(i).focus();
            return false;
        }
        
        v_ic_bko = 2;
        v_ic_supervisor = 2;
        
         if(chkBko.get(i).checked)
            v_ic_bko = 1;
        if(chkSupervisor.get(i).checked)
            v_ic_supervisor = 1;
        
        
 
        arrDados[i] = [cboUsuarioPk.get(i).value,v_ic_bko,v_ic_supervisor];
        
    }
    
    return arrayToJson(arrKeys, arrDados);
    
}

$(document).ready(function()
    {
        var arrCarregar = permissao("equipe", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
        $(document).on('click', '#cmdIncluir', fcIncluirUsuario);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();
        
        carregarListaCombo();
        fcCarregarPolo();

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
