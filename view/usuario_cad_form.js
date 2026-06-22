function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_usuario:{
                required:true,
                minlength:3
            },
            ds_login:{
                required:true,
                minlength:3
            },
            ds_email:{
                required:false,
                minlength:3
            },
            ds_cel:{
                required:false,
                minlength:3
            },
            ic_status:{
                required:true
            },
            grupos_pk:{
                required:true
            }

        },
        messages:{
            ds_usuario:{
                required:"Por favor, informe Usuário",
                minlength:"Usuário deve ter pelo menos 3 caracteres"
            },
            ds_login:{
                required:"Por favor, informe Login",
                minlength:"Login deve ter pelo menos 3 caracteres"
            },
            ds_email:{
                minlength:"Email deve ter pelo menos 3 caracteres"
            },
            ds_cel:{
                minlength:"Cel deve ter pelo menos 3 caracteres"
            },
            ic_status:{
                required:"Por favor, informe Status"
            },
            grupos_pk:{
                required:"Por favor, informe Grupo"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){
    
    var strJSONDadosTabelaPolo = fcFormatarDadosPolo();
    
    var  count_polo = tblPolo.rows().data();
    if(count_polo.length < 1){
        $("#alert_polo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_polo").slideUp(500);
        });
        return false;
    }
    
    
    var v_ds_senha = "";
    var v_ds_usuario = $("#ds_usuario").val();
    var v_ds_login = $("#ds_login").val();
    
    
    if(pk==""){
         v_ds_senha = "gepros";
    }
    else{
        if($('#ic_senha').is(":checked")){
           v_ds_senha = "gepros";
        }
        else{
           v_ds_senha = $("#ds_senha").val();
        }
    }
    
    
    
    var v_ds_email = $("#ds_email").val();
    var v_ds_cel = $("#ds_cel").val();
    var v_ic_status = $("#ic_status").val();
    var v_grupos_pk = $("#grupos_pk").val();
    var v_contas_pk = $("#contas_pk").val();

    var objParametros = {
        "pk": pk,
        "ds_usuario": (v_ds_usuario),
        "ds_login": (v_ds_login),
        "ds_senha": (v_ds_senha),
        "ds_email": (v_ds_email),
        "ds_cel": (v_ds_cel),
        "ic_status": (v_ic_status),
        "grupos_pk": (v_grupos_pk),
        "contas_pk": (v_contas_pk),
        "polos_pk": (strJSONDadosTabelaPolo)  
    };    

    var arrEnviar = carregarController("usuario", "salvar", objParametros); 

    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("usuario_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){
    sendPost("usuario_res_form.php", {token: token});
}
function fcCarregar(){
    if(pk > 0){
        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("usuario", "listarPk", objParametros);

        if (arrCarregar.result == 'success'){
            
            $("#contas_pk").val(arrCarregar.data[0]['contas_pk']);
            $("#ds_usuario").val(arrCarregar.data[0]['ds_usuario']);
            $("#ds_login").val(arrCarregar.data[0]['ds_login']);
            $("#ds_email").val(arrCarregar.data[0]['ds_email']);
            $("#ds_cel").val(arrCarregar.data[0]['ds_cel']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#grupos_pk").val(arrCarregar.data[0]['grupos_pk']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcCarregarGrupos(){
    //Carrega os grupos
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("grupo", "listarGruposCadUsuario", objParametros);   

    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
    
}

function fcCarregarConta(){
    //Carrega os grupos
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("conta", "listarContasUsuarios", objParametros);   

    carregarComboAjax($("#contas_pk"), arrCarregar, "", "pk", "ds_conta");    
}

$(document).ready(function()
    {
        
        var arrCarregar = permissao("usuario", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        $("#ds_cel").keypress(function(){
            mascara(this, mascaraTelefone);

        });
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();
        
        fcCarregarConta();

        //Carregar o combo com os grupos.
        fcCarregarGrupos();  

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
    }
);
