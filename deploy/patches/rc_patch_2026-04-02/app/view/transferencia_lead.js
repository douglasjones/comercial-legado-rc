var tblResultado;
function fcPesquisar(){
    
    
    var v_ic_status_1 = 0;
    var v_ic_status_2 = 0;
    var v_ic_status_3 = 0;
    var v_ic_status_4 = 0;
	
    if($('#ic_status_1').is(":checked")){
        v_ic_status_1 = 1;
    }
    if($('#ic_status_2').is(":checked")){
        v_ic_status_2 = 2;
    }
    if($('#ic_status_3').is(":checked")){
        v_ic_status_3 = 3;
    }
    if($('#ic_status_4').is(":checked")){
        v_ic_status_4 = 4;
    }



    sendPost('transferencia_lead2.php', {token: token, polos_pk: $("#polos_pk").val(),
        ds_razao_social: $("#ds_razao_social").val(),
        ic_status_1: v_ic_status_1,
        ic_status_2: v_ic_status_2,
        ic_status_3: v_ic_status_3,
        ic_status_4: v_ic_status_4,
        grupos_pk: $("#grupos_pk").val(),
        usuarios_pk: $("#usuarios_pk").val(),
        tipo_pessoa_pk: $("#tipo_pessoa_pk").val(),
        mailing_pk: $("#mailing_pk").val(),
        operador_pk: $("#operador_pk").val(),
        classificacao_operador_pk: $("#classificacao_operador_pk").val(),
        tempo_contrato_pk: $("#tempo_contrato_pk").val(),
        qtde_linhas_ini: $("#qtde_linhas_ini").val(),
        qtde_linhas_fim: $("#qtde_linhas_fim").val()
    });
    
}

function fcCarregarPolo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros); 
   
    carregarComboAjax($("#polos_pk"), arrCarregar, "", "pk", "ds_polo");
        
}

function fcCarregarMailing(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("mailing", "listarPorContasPk", objParametros); 
   
    carregarComboAjax($("#mailing_pk"), arrCarregar, " ", "pk", "ds_mailing");
        
}

function fcCarregarPerfil(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);   

    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
        
}

function fcCarregarOperador(){
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("operador", "listarTodos", objParametros);

    carregarComboAjax($("#operador_pk"), arrCarregar, " ", "pk", "ds_operador");
}

function fcCarregarClassificacaoOperador(){
    var objParametros = {
        "operadoras_pk": $("#operador_pk").val()
    };

    var arrCarregar = carregarController("operador", "listarClassificacaoOPerador", objParametros);

    carregarComboAjax($("#classificacao_operador_pk"), arrCarregar, " ", "pk", "ds_classificacao");
}

function fcCarregarResponsavel(){
    
    var objParametros = {
        "pk": "",
        "grupos_pk":$("#grupos_pk").val()
    };      
    
    var arrCarregar = carregarController("usuario", "listarPorGrupo", objParametros);    
    carregarComboAjax($("#usuarios_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}

$(document).ready(function(){
    
    /*var arrCarregar = permissao("transferencia", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }*/
        
    fcCarregarPolo();
    fcCarregarMailing();
    fcCarregarPerfil();
    fcCarregarOperador();
    fcCarregarClassificacaoOperador();
    
    $("#grupos_pk").change(function(){
        fcCarregarResponsavel();
    });
    $("#operador_pk").change(function(){
        fcCarregarClassificacaoOperador();
    });
    $("#qtde_linhas_ini").keypress(function(){
        mascara(this,soNumeros);
    });
    $("#qtde_linhas_fim").keypress(function(){
        mascara(this,soNumeros);
    });
    

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);

});


