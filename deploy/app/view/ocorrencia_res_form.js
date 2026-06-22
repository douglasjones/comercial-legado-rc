var tblResultado;
function fcPesquisar(){
    tblResultado.clear().destroy();
    fcCarregarGrid();    
}

function fcIncluir(){
    var arrCarregar = permissao("ocorrencia", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    sendPost('ocorrencia_cad_form.php',{token: token, pk: ''});
}

function fcExcluir(v_pk, v_ds_ocorrencia){
    var arrCarregar = permissao("ocorrencia", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if (confirm("Deseja realmente excluir o registro '" + v_ds_ocorrencia + "'?")){
        if(v_pk != ""){
            var objParametros = {
                "pk": v_pk
            }; 
            var arrExcluir = carregarController("ocorrencia", "excluir", objParametros);  
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



function fcCarregarGrid(){

    var objParametros = {
        "ds_lead": $("#ds_lead").val(),
        "tipos_ocorrencias_pk": $("#tipo_ocorrencia_res_pk").val(),
        "ic_status": $("#ic_status").val(),
        "usuario_cadastro_pk": $("#usuario_cadastro_res_pk").val(),
        "dt_cadastro": $("#dt_cadastro").val(),
        "dt_cadastro_fim": $("#dt_cadastro_fim").val()
    };     
    
    var v_url = montarUrlController("ocorrencia", "listarDataTableGrid", objParametros);
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_dt_termino_retorno"}, 
           {"targets": -3, "data": "t_ds_retorno"},
           {"targets": -4, "data": "t_dt_retorno"},
           {"targets": -5, "data": "t_agendado_para"},
           {"targets": -6, "data": "t_dt_fechamento"}, 
           {"targets": -7, "data": "t_nome_usuario_cadastro"},
           {"targets": -8, "data": "t_ds_ocorrencia"},
           {"targets": -9, "data": "t_tipos_ocorrencias_pk" ,"visible":false},
           {"targets": -10, "data": "t_ds_tipo_ocorrencia"},           
           {"targets": -11, "data": "t_dt_cadastro"},           
           {"targets": -12, "data": "t_ds_lead"},
           {"targets": -13, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
        
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        
        var data;
        
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirOcorrencia(data['t_pk']);
        }
    } );
    
    $('#tblResultado tbody').on('click', '.function_edit', function () {
      
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarOcorrencia(data);        
    } );             
    
}


function fcCarregarTipoOcorrenciaRes(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros);    
    carregarComboAjax($("#tipo_ocorrencia_res_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");        
}
function fcCarregarComboUsuarioRes(){    
    var objParametros = {
        "pk": ""
    };  
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#usuario_cadastro_res_pk"), arrCarregar, " ", "pk", "ds_usuario");        
}

$(document).ready(function(){
    var arrCarregar = permissao("ocorrencia", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    //carrega cadastro ini
    $('#dt_cadastro').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_cadastro").keypress(function(){
       mascara(this,mdata);
    });
        
    //carrega cadastro fim
    $('#dt_cadastro_fim').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_cadastro_fim").keypress(function(){
       mascara(this,mdata);
    });
    
    fcCarregarTipoOcorrenciaRes();    
    fcCarregarComboUsuarioRes();    
    //faz a carga inicial do grid.
    fcCarregarGrid();
    
    //Valida Campos Ocorrencia
    fcValidarFormOcorrencia();
    
    //fcValidarFormOcorrencia();
    ///fcValidarFormOcorrencia();
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);  

});


