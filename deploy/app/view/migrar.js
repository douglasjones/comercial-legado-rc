function fcEnviar(){
    
    var objParametros = {
        "pk": ""      
    };    

    var arrEnviar = carregarController("migrar", "salvar", objParametros); 
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("migrar.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}
function fcEnviarLead(){
    
    var objParametros = {
        "pk": ""      
    };    

    var arrEnviarLead = carregarController("migrar", "salvarLead", objParametros); 
           
    if (arrEnviarLead.result == 'success'){
        // Reload datable
        alert(arrEnviarLead.message);
        sendPost("migrar.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("menu_administracao.php", {token: token});
}


$(document).ready(function()
    {
        var arrCarregar = permissao("tipo_ocorrencia", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);

        //Atribui a validação do formulário dos campos obrigatórios
        
        $(document).on('click', '#cmdEnviarLead', fcEnviarLead);
        $(document).on('click', '#cmdEnviar', fcEnviar);

    }
);
