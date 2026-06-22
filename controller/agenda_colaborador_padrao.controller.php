<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/agenda_colaborador_padrao.dao.php";
include_once "../model/agenda_colaborador_padrao.class.php";
include_once "../model/colaborador.dao.php";
include_once "../model/colaborador.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_agenda = $arrRequest['ds_agenda'];
$dt_inicio_agenda = DataYMD($arrRequest['dt_inicio_agenda']);
$dt_fim_agenda = DataYMD($arrRequest['dt_fim_agenda']);
$colaboradores_pk = $arrRequest['colaboradores_pk'];
$processos_etapas_pk = $arrRequest['processos_etapas_pk'];
$contratos_itens_pk = $arrRequest['contratos_itens_pk'];
$ic_dom = $arrRequest['ic_dom'];
$ic_seg = $arrRequest['ic_seg'];
$ic_ter = $arrRequest['ic_ter'];
$ic_qua = $arrRequest['ic_qua'];
$ic_qui = $arrRequest['ic_qui'];
$ic_sex = $arrRequest['ic_sex'];
$ic_sab = $arrRequest['ic_sab'];
if($ic_dom==""){
    $ic_dom= 2;
}

if($ic_seg==""){
    $ic_seg= 2;
}

if($ic_ter==""){
    $ic_ter= 2;
}

if($ic_qua==""){
    $ic_qua= 2;
}

if($ic_qui==""){
    $ic_qui= 2;
}

if($ic_sex==""){
    $ic_sex= 2;
}

if($ic_sab==""){
    $ic_sab= 2;
}

$dom_turnos_pk = $arrRequest['dom_turnos_pk'];
$seg_turnos_pk = $arrRequest['seg_turnos_pk'];
$ter_turnos_pk = $arrRequest['ter_turnos_pk'];
$qua_turnos_pk = $arrRequest['qua_turnos_pk'];
$qui_turnos_pk = $arrRequest['qui_turnos_pk'];
$sex_turnos_pk = $arrRequest['sex_turnos_pk'];
$sab_turnos_pk = $arrRequest['sab_turnos_pk'];


$agenda_colaborador_padraodao = new agenda_colaborador_padraodao();
$agenda_colaborador_padraodao->setToken($token); 

$colaboradordao = new colaboradordao();
$colaboradordao->setToken($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $agenda_colaborador_padrao = $agenda_colaborador_padraodao->carregarPorPk($pk);
        if($agenda_colaborador_padrao->getpk()>0){
            
            $agenda_colaborador_padraodao->excluir($agenda_colaborador_padrao);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agenda_colaborador_padrao nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $agenda_colaborador_padrao = $agenda_colaborador_padraodao->carregarPorPk($pk);
        $agenda_colaborador_padrao->setds_agenda($ds_agenda);
        $agenda_colaborador_padrao->setdt_inicio_agenda($dt_inicio_agenda);
        $agenda_colaborador_padrao->setdt_fim_agenda($dt_fim_agenda);
        $agenda_colaborador_padrao->setcolaboradores_pk($colaboradores_pk);
        $agenda_colaborador_padrao->setprocessos_etapas_pk($processos_etapas_pk);
        $agenda_colaborador_padrao->setic_dom($ic_dom);
        $agenda_colaborador_padrao->setic_seg($ic_seg);
        $agenda_colaborador_padrao->setic_ter($ic_ter);
        $agenda_colaborador_padrao->setic_qua($ic_qua);
        $agenda_colaborador_padrao->setic_qui($ic_qui);
        $agenda_colaborador_padrao->setic_sex($ic_sex);
        $agenda_colaborador_padrao->setic_sab($ic_sab);
        $agenda_colaborador_padrao->setdom_turnos_pk($dom_turnos_pk);
        $agenda_colaborador_padrao->setseg_turnos_pk($seg_turnos_pk);
        $agenda_colaborador_padrao->setter_turnos_pk($ter_turnos_pk);
        $agenda_colaborador_padrao->setqua_turnos_pk($qua_turnos_pk);
        $agenda_colaborador_padrao->setqui_turnos_pk($qui_turnos_pk);
        $agenda_colaborador_padrao->setsex_turnos_pk($sex_turnos_pk);
        $agenda_colaborador_padrao->setsab_turnos_pk($sab_turnos_pk);
        $agenda_colaborador_padrao->setcontratos_itens_pk($contratos_itens_pk);
        
        
        $pk = $agenda_colaborador_padraodao->salvar($agenda_colaborador_padrao);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $agenda_colaborador_padraodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agenda"=>$query[$i]['ds_agenda'],
                    "dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "contratos_itens_pk"=>$query[$i]['contratos_itens_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $agenda_colaborador_padraodao->listar_por_ds_agenda($ds_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agenda"=>$query[$i]['ds_agenda'],
                    "dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "turnos_pk"=>$query[$i]['turnos_pk'],
                    "dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],
                    "ic_dom"=>$query[$i]['ic_dom'],
                    "ic_seg"=>$query[$i]['ic_seg'],
                    "ic_ter"=>$query[$i]['ic_ter'],
                    "ic_qua"=>$query[$i]['ic_qua'],
                    "ic_qui"=>$query[$i]['ic_qui'],
                    "ic_sex"=>$query[$i]['ic_sex'],
                    "ic_sab"=>$query[$i]['ic_sab'],
                    "dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    "contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $agenda_colaborador_padraodao->listar_por_ds_agenda($ds_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarAgendaColaboradorLeadProcesso':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_agenda_colaborador_lead_processo($leads_pk,$processos_pk);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_dia_semana = "";
                if($query[$i]['ic_dom']==1){
                    $ds_dia_semana.= "Dom (".$query[$i]['ds_turno_dom'].")<br> ";
                }
                if($query[$i]['ic_seg']==1){
                    $ds_dia_semana.= "Seg (".$query[$i]['ds_turno_seg'].")<br> ";
                }
                if($query[$i]['ic_ter']==1){
                    $ds_dia_semana.= "Ter (".$query[$i]['ds_turno_ter'].")<br> ";
                }
                if($query[$i]['ic_qua']==1){
                    $ds_dia_semana.= "Qua (".$query[$i]['ds_turno_qua'].")<br>";
                }
                if($query[$i]['ic_qui']==1){
                    $ds_dia_semana.= "Qui (".$query[$i]['ds_turno_qui'].")<br> ";
                }
                if($query[$i]['ic_sex']==1){
                    $ds_dia_semana.= "Sex (".$query[$i]['ds_turno_sex'].")<br> ";
                }
                if($query[$i]['ic_sab']==1){
                    $ds_dia_semana.= "Sab (".$query[$i]['ds_turno_sab'].")<br>";
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_ds_turno"=>$query[$i]['ds_turno'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_ds_dia_semana"=>$query[$i]['ds_dia_semana'],
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_ic_dom"=>$query[$i]['ic_dom'],
                    "t_ic_seg"=>$query[$i]['ic_seg'],
                    "t_ic_ter"=>$query[$i]['ic_ter'],
                    "t_ic_qua"=>$query[$i]['ic_qua'],
                    "t_ic_qui"=>$query[$i]['ic_qui'],
                    "t_ic_sex"=>$query[$i]['ic_sex'],
                    "t_ic_sab"=>$query[$i]['ic_sab'],
                    "t_dom_turnos_pk"=>$query[$i]['dom_turnos_pk'],
                    "t_seg_turnos_pk"=>$query[$i]['seg_turnos_pk'],
                    "t_ter_turnos_pk"=>$query[$i]['ter_turnos_pk'],
                    "t_qua_turnos_pk"=>$query[$i]['qua_turnos_pk'],
                    "t_qui_turnos_pk"=>$query[$i]['qui_turnos_pk'],
                    "t_sex_turnos_pk"=>$query[$i]['sex_turnos_pk'],
                    "t_sab_turnos_pk"=>$query[$i]['sab_turnos_pk'],
                    "t_contratos_itens_pk"=>$query[$i]['contratos_itens_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ds_dia_semana"=>$ds_dia_semana,
                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }  
    
    case 'listarAgendaColaboradorLeadProdutosServicos':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $qtde_dias_contrato = $_REQUEST['qtde_dias_contrato'];
        $contratos_pk = $_REQUEST['contratos_pk'];
    
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_agenda_colaborador($leads_pk,$processos_pk,$qtde_dias_contrato,$contratos_pk);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_dia_semana = "";
                if($query[$i]['ic_dom']==1){
                    $ds_dia_semana.= "Dom (".$query[$i]['ds_turno_dom'].")<br> ";
                }
                if($query[$i]['ic_seg']==1){
                    $ds_dia_semana.= "Seg (".$query[$i]['ds_turno_seg'].")<br> ";
                }
                if($query[$i]['ic_ter']==1){
                    $ds_dia_semana.= "Ter (".$query[$i]['ds_turno_ter'].")<br> ";
                }
                if($query[$i]['ic_qua']==1){
                    $ds_dia_semana.= "Qua (".$query[$i]['ds_turno_qua'].")<br> ";
                }
                if($query[$i]['ic_qui']==1){
                    $ds_dia_semana.= "Qui (".$query[$i]['ds_turno_qui'].")<br> ";
                }
                if($query[$i]['ic_sex']==1){
                    $ds_dia_semana.= "Sex (".$query[$i]['ds_turno_sex'].")<br> ";
                }
                if($query[$i]['ic_sab']==1){
                    $ds_dia_semana.= "Sab (".$query[$i]['ds_turno_sab'].")<br> ";
                }
                    
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_ds_dia_semana"=>$ds_dia_semana,
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }     
    case 'RellistarAgendaColaboradorLeadProdutosServicos':{
        $leads_pk = $_REQUEST['leads_pk'];
        $processos_pk = $_REQUEST['processos_pk'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        $qtde_dias_contrato = $_REQUEST['qtde_dias_contrato'];
        $dt_base = $_REQUEST['dt_base'];
        $n_dia_semana = $_REQUEST['n_dia_semana'];
    
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->rel_listar_agenda_colaborador_data($leads_pk,$dt_base,$produtos_servicos_pk,$qtde_dias_contrato,$n_dia_semana);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_dia_semana = "";
                if($query[$i]['ic_dom']==1){
                    $ds_dia_semana.= "Dom (".$query[$i]['ds_turno_dom'].")<br> ";
                }
                if($query[$i]['ic_seg']==1){
                    $ds_dia_semana.= "Seg (".$query[$i]['ds_turno_seg'].")<br> ";
                }
                if($query[$i]['ic_ter']==1){
                    $ds_dia_semana.= "Ter (".$query[$i]['ds_turno_ter'].")<br> ";
                }
                if($query[$i]['ic_qua']==1){
                    $ds_dia_semana.= "Qua (".$query[$i]['ds_turno_qua'].")<br> ";
                }
                if($query[$i]['ic_qui']==1){
                    $ds_dia_semana.= "Qui (".$query[$i]['ds_turno_qui'].")<br> ";
                }
                if($query[$i]['ic_sex']==1){
                    $ds_dia_semana.= "Sex (".$query[$i]['ds_turno_sex'].")<br> ";
                }
                if($query[$i]['ic_sab']==1){
                    $ds_dia_semana.= "Sab (".$query[$i]['ds_turno_sab'].")<br> ";
                }
                    
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_ds_dia_semana"=>$ds_dia_semana,
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }     
    case 'listarData':{
        $dt_agenda = $_REQUEST['dt_agenda'];
        
        $resultado = "";
        $query = $agenda_colaborador_padraodao->listar_data($dt_agenda);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "dia_semana" => $query[$i]["dia_semana"],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarItensContratados':{
        $leads_pk = $_REQUEST['leads_pk'];
        $contratos_pk = $_REQUEST['contratos_pk'];
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_qtde_itens_profissionais_contratados($leads_pk,$contratos_pk);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                
                //RETORNA A QUANTIDADE DE FUNCIONARIOS DA AGENDA
                $query1 = $agenda_colaborador_padraodao->listar_profissionais_qtde_dia($leads_pk,$query[$i]["contratos_pk"],$query[$i]["n_qtde_dias_semana"],$query[$i]["contratos_itens_pk"]);
                $qtde_profissionais = 0;
                if(count($query1) > 0){
                    for($j = 0; $j < count($query1); $j++){
                        if($query1[$j]["qtde_profissionais"]=="" || $query1[$j]["qtde_profissionais"]=="null"){
                            $qtde_profissionais = 0;
                        }
                        else{
                            $qtde_profissionais += $query1[$j]["qtde_profissionais"];
                        }
                        
                    }
                }
                
                
                
                $mysql_data[] = array(
                    "t_ds_produto_servico" => $query[$i]["ds_produto_servico"],
                    "t_qtde_contratado" => $query[$i]["qtde_contratado"],
                    "t_qtde_profissional" => $qtde_profissionais,
                    "t_diferenca" => ($query[$i]["qtde_contratado"] - $qtde_profissionais),
                    "t_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"],
                    "t_contratos_pk" => $query[$i]["contratos_pk"],
                    "t_contratos_itens_pk" => $query[$i]["contratos_itens_pk"],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarItensContratadosData':{
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda_inicio = $_REQUEST['dt_agenda_inicio'];
        $dt_agenda_fim = $_REQUEST['dt_agenda_fim'];
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_qtde_itens_profissionais_contratados_data($leads_pk,$dt_agenda_inicio,$dt_agenda_fim);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_ds_produto_servico" => $query[$i]["ds_produto_servico"],
                    "t_qtde_contratado" => $query[$i]["qtde_contratado"],
                    "t_qtde_profissional" => $query[$i]["qtde_profissional"],
                    "t_diferenca" => $query[$i]["diferenca"],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'relatorioAgendaLead':{
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_base = $_REQUEST['dt_base'];
        
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->rel_agenda_lead($leads_pk,$dt_base);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                    $query1 = $agenda_colaborador_padraodao->rel_agenda_lead_qtde_profissiomais($leads_pk,$dt_base,$query[$i]["produtos_servicos_pk"],$query[$i]["n_qtde_dias_semana"]);
                    $qtde_profissionais = 0;
                    if(count($query1) > 0){
                        for($j = 0; $j < count($query1); $j++){
                            if($query1[$j]["qtde_profissionais"]=="" || $query1[$j]["qtde_profissionais"]=="null"){
                                $qtde_profissionais = 0;
                            }
                            else{
                                $qtde_profissionais += $query1[$j]["qtde_profissionais"];
                            }

                        }
                    }
                $mysql_data[] = array(
                    "t_n_itens_contratados" => $query[$i]["n_itens_contratados"],
                    "t_n_profissionais_contratados" => $qtde_profissionais,
                    "t_n_diferenca" => ($query[$i]["n_itens_contratados"] - $qtde_profissionais),
                    "t_ds_produto_servico" => $query[$i]["ds_produto_servico"],
                    "t_produtos_servicos_pk" => $query[$i]["produtos_servicos_pk"],
                    "t_n_qtde_dias_semana" => $query[$i]["n_qtde_dias_semana"],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'relatorioAgendaColaborador':{
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];
        $dt_base = $_REQUEST['dt_base'];
        $dia_semana = $_REQUEST['dia_semana'];
        
        $resultado = "";
        if($colaboradores_pk!=""){
            $query = $agenda_colaborador_padraodao->rel_agenda_colaborador($colaboradores_pk,$dt_base,$dia_semana);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($dia_semana==0){
                    $ds_turno = $query[$i]['ds_turno_dom'];
                    if($query[$i]['ic_dom']==1){
                        $ds_dia_semana ="Domingo";
                    }
                }
                else if($dia_semana==1){
                    $ds_turno = $query[$i]['ds_turno_seg'];
                    if($query[$i]['ic_seg']==1){
                        $ds_dia_semana ="Segunda";
                    }
                }
                else if($dia_semana==2){
                    $ds_turno = $query[$i]['ds_turno_ter'];
                    if($query[$i]['ic_ter']==1){
                        $ds_dia_semana ="Terça";
                    }
                }
                else if($dia_semana==3){
                    $ds_turno = $query[$i]['ds_turno_qua'];
                    if($query[$i]['ic_qua']==1){
                        $ds_dia_semana ="Quarta";
                    }
                }
                else if($dia_semana==4){
                    $ds_turno = $query[$i]['ds_turno_qui'];
                    if($query[$i]['ic_qui']==1){
                        $ds_dia_semana ="Quinta";
                    }
                }
                else if($dia_semana==5){
                    $ds_turno = $query[$i]['ds_turno_sex'];
                    if($query[$i]['ic_sex']==1){
                        $ds_dia_semana ="Sexta";
                    }
                }
                else if($dia_semana==6){
                    $ds_turno = $query[$i]['ds_turno_sab'];
                    if($query[$i]['ic_sab']==1){
                        $ds_dia_semana ="Sabado";
                    }
                }
                $mysql_data[] = array(
                    
                    "t_ds_lead" => $query[$i]["ds_lead"],
                    "t_ds_turno" => $ds_turno,
                    "t_ds_dia_semana" => $ds_dia_semana,

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    
    case 'listarAgendaLeadData':{
        $leads_pk = $_REQUEST['leads_pk'];
        $dt_agenda = $_REQUEST['dt_agenda'];
        $dia_semana = $_REQUEST['dia_semana'];
      
        $resultado = "";
        if($leads_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_agenda_colaborador_lead_data($leads_pk,$dt_agenda,$dia_semana);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($dia_semana==0){
                    $ds_turno_escala = $query[$i]['ds_turno_dom'];
                    $turnos_pk_escala = $query[$i]['dom_turnos_pk'];
                }
                else if($dia_semana==1){
                    $ds_turno_escala = $query[$i]['ds_turno_seg'];
                    $turnos_pk_escala = $query[$i]['seg_turnos_pk'];
                }
                else if($dia_semana==2){
                    $ds_turno_escala = $query[$i]['ds_turno_ter'];
                    $turnos_pk_escala = $query[$i]['ter_turnos_pk'];
                }
                else if($dia_semana==3){
                    $ds_turno_escala = $query[$i]['ds_turno_qua'];
                    $turnos_pk_escala = $query[$i]['qua_turnos_pk'];
                }
                else if($dia_semana==4){
                    $ds_turno_escala = $query[$i]['ds_turno_qui'];
                    $turnos_pk_escala = $query[$i]['qui_turnos_pk'];
                }
                else if($dia_semana==5){
                    $ds_turno_escala = $query[$i]['ds_turno_sex'];
                    $turnos_pk_escala = $query[$i]['sex_turnos_pk'];
                }
                else if($dia_semana==6){
                    $ds_turno_escala = $query[$i]['ds_turno_sab'];
                    $turnos_pk_escala = $query[$i]['sab_turnos_pk'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$turnos_pk_escala,
                    "t_ds_turnos"=>$ds_turno_escala,
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    
                    "t_dom_ds_turnos"=>$query[$i]['ds_turno_dom'],
                    "t_seg_ds_turnos"=>$query[$i]['ds_turno_seg'],
                    "t_ter_ds_turnos"=>$query[$i]['ds_turno_ter'],
                    "t_qua_ds_turnos"=>$query[$i]['ds_turno_qua'],
                    "t_qui_ds_turnos"=>$query[$i]['ds_turno_qui'],
                    "t_sex_ds_turnos"=>$query[$i]['ds_turno_sex'],
                    "t_sab_ds_turnos"=>$query[$i]['ds_turno_sab'],
                    
                    
                    
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    
                    "t_ds_colaboradores_dom"=>$query[$i]['ds_colaborador_dom'],
                    "t_ds_colaboradores_seg"=>$query[$i]['ds_colaborador_seg'],
                    "t_ds_colaboradores_ter"=>$query[$i]['ds_colaborador_ter'],
                    "t_ds_colaboradores_qua"=>$query[$i]['ds_colaborador_qua'],
                    "t_ds_colaboradores_qui"=>$query[$i]['ds_colaborador_qui'],
                    "t_ds_colaboradores_sex"=>$query[$i]['ds_colaborador_sex'],
                    "t_ds_colaboradores_sab"=>$query[$i]['ds_colaborador_sab'],
                    
                    "t_ds_colaborador_grid"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarAgendaColaboradorData':{
 
        $colaborador_pk = $_REQUEST['colaborador_pk'];
        $dt_base = $_REQUEST['dt_base'];
        $dia = $_REQUEST['Dia'];
        $mes = $_REQUEST['Mes'];
        $ano = $_REQUEST['Ano'];
        $dia_semana = $_REQUEST['dia_semana'];
        
        $resultado = "";
        if($colaborador_pk!=""){
            $query = $agenda_colaborador_padraodao->listar_agenda_colaborador_data($colaborador_pk,$dt_base,$dia_semana);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                if($dia_semana==0){
                    $ds_turno = $query[$i]['ds_turno_dom'];
                }
                else if($dia_semana==1){
                    $ds_turno = $query[$i]['ds_turno_seg'];
                }
                else if($dia_semana==2){
                    $ds_turno = $query[$i]['ds_turno_ter'];
                }
                else if($dia_semana==3){
                    $ds_turno = $query[$i]['ds_turno_qua'];
                }
                else if($dia_semana==4){
                    $ds_turno = $query[$i]['ds_turno_qui'];
                }
                else if($dia_semana==5){
                    $ds_turno = $query[$i]['ds_turno_sex'];
                }
                else if($dia_semana==6){
                    $ds_turno = $query[$i]['ds_turno_sab'];
                }
                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda"=>$query[$i]['ds_agenda'],
                    "t_dt_inicio_agenda"=>$query[$i]['dt_inicio_agenda'],
                    "t_dt_fim_agenda"=>$query[$i]['dt_fim_agenda'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],
                    "t_ds_turnos_pk"=>$ds_turno,
                    "t_dias_semana_pk"=>$query[$i]['dias_semana_pk'],
                    "t_ds_dias_semana_pk"=>$query[$i]['ds_dia_semana'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_ds_colaboradores_pk"=>$query[$i]['ds_colaborador'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_ds_colaborador_grid"=>$query[$i]['ds_colaborador_grid'],
                    "t_ds_lead"=>$query[$i]['ds_lead'],
                    "t_condominio"=>$query[$i]['condominio'],
                    "t_ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    "t_qtde_colaborador"=>$query[$i]['qtde_colaborador'],
                    "t_processos_etapas_pk"=>$query[$i]['processos_etapas_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
           
            $mysql_data = [];
        }
		
        break;
    }     
    default:{
        break;
    }
}

$agenda_colaborador_padraodao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
