var tblResultado;
var tblCargaNaoRealizada;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){

    sendPost('carga_lead_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_equipe){
    if (confirm("Deseja realmente excluir o registro '" + v_ds_equipe + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("equipe", "excluir", objParametros);   

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
    sendPost('equipe_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){

    
    var objParametros = {
        "mailing_pk": $("#mailing_pk").val(),
        "polos_pk": $("#polos_pk").val(),
        "dt_carga_ini":$("#dt_carga_ini").val(),
        "dt_carga_fim":$("#dt_carga_fim").val(),
        "usuario_cadastro_pk":$("#usuario_cadastro_pk").val()
    };     
    
    var v_url = montarUrlController("carga_lead", "listarDataTable", objParametros);
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [
            {
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/painel.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_mailing"},
           {"targets": -3, "data": "t_dt_sinconizacao"},
           {"targets": -4, "data": "t_ds_usuario"},
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
        fcAbrirRelatorio(data['t_pk']);
        
    } );   
               
    
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
    
    var arrCarregar = carregarController("mailing", "listarTodos", objParametros); 
   
    carregarComboAjax($("#mailing_pk"), arrCarregar, " ", "pk", "ds_mailing");
        
}
function fcCarregarUsuario(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros); 
   
    carregarComboAjax($("#usuario_cadastro_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}

function fcAbrirRelatorio(pk){
    tblCargaNaoRealizada.clear().destroy();
    fcCarregarGridNaoRealizada(pk);
    $("#janela_carga_nao_realizada").modal();
   
    
    
    
}

function fcCarregarGridNaoRealizada(pk){

    
    var objParametros = {
        "cargas_pk": pk
    };     
    
    var v_url = montarUrlController("carga_lead", "listarNaoRealizado", objParametros);
    //Trata a tabela
    tblCargaNaoRealizada = $('#tblCargaNaoRealizada').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [
           {"targets": -1, "data": "dt_cadastro"},
           {"targets": -2, "data": "ds_usuario"},
           {"targets": -3, "data": "ds_mailing"},
           {"targets": -4, "data": "ds_cpf_cnpj"},
           {"targets": -5, "data": "ds_lead"},
           {"targets": -6, "data": "pk"}
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
       
               
    
}

$(document).ready(function(){
    
    $('#dt_carga_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_carga_ini").keypress(function(){
       mascara(this,mdata);
    }); 
    $('#dt_carga_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_carga_fim").keypress(function(){
       mascara(this,mdata);
    }); 
    
    fcCarregarPolo();
    
    fcCarregarMailing();
    
    fcCarregarUsuario();
    
    //faz a carga inicial do grid.
    fcCarregarGrid();
    
    fcCarregarGridNaoRealizada("");

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});


