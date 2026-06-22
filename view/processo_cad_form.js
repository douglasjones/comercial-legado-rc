function fcCancelarProcesso(){

    sendPost("lead_main_form.php", {token: token,pk:leads_pk});
}

function fcCarregar(){

    if(pk > 0){
        var objParametros = {
            "pk": pk,
        };       
        
        var arrCarregar = carregarController("processo", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            
            $("#ds_processo").text(arrCarregar.data[0]['ds_processo']);  
            $(".leads_pk_cad").text(leads_pk);
            $(".ds_lead_cad").text(arrCarregar.data[0]['ds_lead']);
            $(".ds_tipo_pessoa_cad").text(arrCarregar.data[0]['tipo_pessoa_pk']);
            $(".ds_polo_cad").text(arrCarregar.data[0]['ds_polo']);
            $(".status_lead").text(arrCarregar.data[0]['ds_classificacao_processo']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcCarregarEtapasProcesso(){

    var objParametros = {
        "pk": pk
    };        

    var arrCarregar = carregarController("processo", "listarEtapas", objParametros);
    if (arrCarregar.result == 'success'){
        for(i = 0; i < arrCarregar.data.length; i++){
            if(/Agenda/.test(arrCarregar.data[i]['etapas'])){  
                $('#etapas_1').html(arrCarregar.data[i]['etapas']); 
                //include da pagina
                $("#inc_etapas_1").load('inc_agenda_visita_res_form.php');             
                $('#processos_etapas_pk_1').val(arrCarregar.data[i]['pk']);
            }
            if(/Proposta/.test(arrCarregar.data[i]['etapas'])){
                $('#etapas_2').html(arrCarregar.data[i]['etapas']);    
                //include da pagina
                $("#inc_etapas_2").load('inc_proposta_res_form.php');
                $('#processos_etapas_pk_2').val(arrCarregar.data[i]['pk']);
            }
            if(/Contrato/.test(arrCarregar.data[i]['etapas'])){
                $('#etapas_3').html(arrCarregar.data[i]['etapas']);    
                //include da pagina            
                $("#inc_etapas_3").load('inc_contrato_res_form.php');
                $('#processos_etapas_pk_3').val(arrCarregar.data[i]['pk']);
            }
            /*if(i==3){
                $('#etapas_4').html(arrCarregar.data[3]['etapas']);    
                //include da pagina            
                //$("#inc_etapas_4").load('inc_cadastro_agenda_colaborador_res_form.php');
                $('#processos_etapas_pk_4').val(arrCarregar.data[1]['pk']);
            }*/
        }
    }      
    else{
        alert('Falhar ao carregar o registro');
    }
}

$(document).ready(function() {
    
    
    //Atribui os eventos
    $(document).on('click', '#cmdCancelarProcesso', fcCancelarProcesso);       
    $(document).on('click', '#cmdCancelarProcesso1', fcCancelarProcesso);       
    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();

    fcCarregarEtapasProcesso();
    
} );
