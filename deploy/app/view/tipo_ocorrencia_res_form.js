var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){

    sendPost('tipo_ocorrencia_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_tipo_ocorrencia){
    var arrCarregar = permissao("tipo_ocorrencia", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    
    if (confirm("Deseja realmente excluir o registro '" + v_ds_tipo_ocorrencia + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("tipo_ocorrencia", "excluir", objParametros);   

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
    var arrCarregar = permissao("tipo_ocorrencia", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    
    sendPost('tipo_ocorrencia_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){

    
    var objParametros = {
        "ds_tipo_ocorrencia": $("#ds_tipo_ocorrencia").val(),
        "ic_status": $("#ic_status").val(),
        "ic_fechar_ocorrencia_auto": $("#ic_fechar_ocorrencia_auto").val()
    };     
    
    var v_url = montarUrlController("tipo_ocorrencia", "listarDataTable", objParametros);

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
           {"targets": -2, "data": "t_ds_status"},
           {"targets": -3, "data": "t_ic_fechar_ocorrencia_auto"},
           {"targets": -4, "data": "t_ds_tipo_ocorrencia"},
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
        
        fcExcluir(data['t_pk'], data['t_ds_tipo_ocorrencia']);
    } );            
    
}



$(document).ready(function(){
    var arrCarregar = permissao("tipo_ocorrencia", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


