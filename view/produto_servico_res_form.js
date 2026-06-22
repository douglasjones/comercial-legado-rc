var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){

    sendPost('produto_servico_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_produto_servico){
    var arrCarregar = permissao("produto_servico", "del");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
    if (confirm("Deseja realmente excluir o registro '" + v_ds_produto_servico + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("produto_servico", "excluir", objParametros);   

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcEditar(v_pk){
    var arrCarregar = permissao("produto_servico", "upd");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    sendPost('produto_servico_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){

    
    var objParametros = {
        "ds_produto_servico": $("#ds_produto_servico").val(),
        "ic_status": $("#ic_status").val(),
        "polos_pk": $("#polos_pk").val(),
        "operador_pk": $("#operador_pk").val()
    };     
    
    var v_url = montarUrlController("produto_servico", "listarDataTable", objParametros);
  
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ic_status"},
           {"targets": -3, "data": "t_ds_produto_servico"},
           {"targets": -4, "data": "t_ds_operador"},
           {"targets": -5, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcEditar(data['t_pk']);
        
    } );   
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_ds_produto_servico']);
    } );            
    
}

function fcCarregarPolo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPkUsuario", objParametros); 
   
    carregarComboAjax($("#polos_pk"), arrCarregar, "", "pk", "ds_polo");
        
}

function fcCarregarOperador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("operador", "listarTodosPorPolo", objParametros); 
   
    carregarComboAjax($("#operador_pk"), arrCarregar, " ", "pk", "ds_operador");
        
}

$(document).ready(function(){
    var arrCarregar = permissao("produto_servico", "cons");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
    //faz a carga inicial do grid.
    
    
    fcCarregarPolo();
    
    fcCarregarOperador();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
    fcCarregarGrid();

});


