var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}
function fcCarregarGrupos(){
    //Carrega os grupos
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("grupo", "listarGruposCadUsuario", objParametros);   

    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");
    
}
function fcIncluir(){

    sendPost('usuario_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_usuario){

    if (confirm("Deseja realmente excluir o registro '" + v_ds_usuario + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("usuario", "excluir", objParametros);   

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
    sendPost('usuario_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){

    
    var objParametros = {
        "ds_usuario": $("#ds_usuario").val(),
        "ic_status": $("#ic_status").val(),
        "grupos_pk":$("#grupos_pk").val(),
        "polos_pk":$("#polos_pk").val()
    };     
    
    var v_url = montarUrlController("usuario", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_perfil"},
           {"targets": -3, "data": "t_grupos_pk"},
           {"targets": -4, "data": "t_ic_status"},
           {"targets": -5, "data": "t_ds_cel"},
           {"targets": -6, "data": "t_ds_email"},
           //{"targets": -6, "data": "t_ds_senha"},
           {"targets": -7, "data": "t_ds_login"},
           {"targets": -8, "data": "t_ds_usuario"},
           {"targets": -9, "data": "t_pk"}

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
        fcExcluir(data['t_pk'], data['t_ds_usuario']);
    } );            
    
}

function fcCarregarPolo(){

    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("polo", "listarPorContasPk", objParametros); 
   
    carregarComboAjax($("#polos_pk"), arrCarregar, " ", "pk", "ds_polo");
        
}

$(document).ready(function(){
    
    var arrCarregar = permissao("usuario", "cons");        

     if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
    }

    //faz a carga inicial do grid.
    fcCarregarGrid();
    
    fcCarregarGrupos();
    
    fcCarregarPolo();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


