var tblPesquisa;


function fcEditar(v_pk){
    var arrCarregar = permissao("lead", "upd");        

    if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
    }
     var arrCarregar = permissao("lead", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    sendPost('lead_cad_form.php', {token: token, pk: v_pk,editar:''});
}

function fcCarregarGrid(){

    var arrPermissao = permissao("acessar_todos_lead", "cons");
    var objParametros = {
        "pesquisar": pesquisar
    };     
    
    var v_url = montarUrlController("lead", "listarLeadPesquisa", objParametros);
    //Trata a tabela
    tblPesquisa = $('#tblPesquisa').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_painel'><span><img width=16 height=16 src='../img/painel.png'></span></a>\n\
                                  &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_classificacao_processo"},
           {"targets": -3, "data": "t_ds_responsavel"},
           {"targets": -4, "data": "t_ds_endereco"},
           {"targets": -5, "data": "t_ds_lead"},
           {"targets": -6, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    
    $('#tblPesquisa tbody').on('click', '.function_painel', function () {
        var data;
        if(tblPesquisa.row( $(this).parents('li') ).data()){
            data = tblPesquisa.row( $(this).parents('li') ).data();
        }
        else if(tblPesquisa.row( $(this).parents('tr') ).data()){
            data = tblPesquisa.row( $(this).parents('tr') ).data();
        }
        if(arrPermissao.result == 'success'){
            fcAbrirPainel(data['t_pk'],data['t_responsavel_pk']);
        }
        else{
            if(data['t_responsavel_pk'].match($("#usuario_logado_pk").val())){
                 fcAbrirPainel(data['t_pk'],data['t_responsavel_pk']);                
            }
            else{          
                if(data['t_responsavel_pk'].match($("#usuario_logado_pk").val())){
                    fcAbrirPainel(data['t_pk'],data['t_responsavel_pk']);
                }
                else if( data['t_responsavel_pk']!=null){
                    $("#alert").fadeTo(3000, 500).slideUp(500, function(){                 
                        $("#alert").slideUp(500);
                    });
                }
            }    
            
        }
        
    } );   
    
    $('#tblPesquisa tbody').on('click', '.function_edit', function () {
        var data;
        if(tblPesquisa.row( $(this).parents('li')).data()){
            data = tblPesquisa.row( $(this).parents('li')).data();
        }
        else if(tblPesquisa.row( $(this).parents('tr')).data()){
            data = tblPesquisa.row( $(this).parents('tr')).data();
        }
                
        if(arrPermissao.result == 'success'){
             fcEditar(data['t_pk']);
        }
        else{
            if(data['t_responsavel_pk'].match($("#usuario_logado_pk").val())){
                  fcEditar(data['t_pk']);           
            }
            else{          
                if(data['t_responsavel_pk'].match($("#usuario_logado_pk").val())){
                     fcEditar(data['t_pk']);
                }
                else if( data['t_responsavel_pk']!=null){
                    $("#alert").fadeTo(3000, 500).slideUp(500, function(){                 
                        $("#alert").slideUp(500);
                    });
                }
            }    
            
        }
        
        
    } );   
             
    
}
function fcAbrirPainel(v_pk){
    sendPost('lead_main_form.php', {token: token, pk: v_pk});
}

function fcCarregarUsuarioLogin(){
    
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros); 
    $("#usuario_logado_pk").val(arrCarregar.data[0]['pk']);
    
        
}

$(document).ready(function(){
    fcCarregarUsuarioLogin();
    var arrCarregar = permissao("lead_pesquisar", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Você não tem permissão');
        return false;
    }
    
    //faz a carga inicial do grid.
    fcCarregarGrid();
});


