<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/colaborador.dao.php";
include_once "../model/colaborador.class.php";
include_once "../model/produto_servico.dao.php";
include_once "../model/produto_servico.class.php";
include_once "../model/documento.dao.php";
include_once "../model/documento.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_colaborador = $arrRequest['ds_colaborador'];
$ds_cel = $arrRequest['ds_cel'];
$ic_whatsapp = $arrRequest['ic_whatsapp'];
$ds_cel2 = $arrRequest['ds_cel2'];
$ic_whatsapp2 = $arrRequest['ic_whatsapp2'];
$ds_cel3 = $arrRequest['ds_cel3'];
$ic_whatsapp3 = $arrRequest['ic_whatsapp3'];
$ds_email = $arrRequest['ds_email'];
$ds_rg = $arrRequest['ds_rg'];
$ds_cpf = $arrRequest['ds_cpf'];
$dt_nascimento = $arrRequest['dt_nascimento'];
$ds_endereco = $arrRequest['ds_endereco'];
$ds_numero = $arrRequest['ds_numero'];
$ds_complemento = $arrRequest['ds_complemento'];
$ds_bairro = $arrRequest['ds_bairro'];
$ds_cep = $arrRequest['ds_cep'];
$ds_cidade = $arrRequest['ds_cidade'];
$ds_uf = $arrRequest['ds_uf'];
$ic_status = $arrRequest['ic_status'];
$ic_funcionario = $arrRequest['ic_funcionario'];
$generos_pk = $arrRequest['generos_pk'];


$colaboradordao = new colaboradordao();
$colaboradordao->setToken($token);

$produto_servicodao = new produto_servicodao();
$produto_servicodao->setToken($token);

$documentodao = new documentodao();
$documentodao->setToken($token); 




switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $colaborador = $colaboradordao->carregarPorPk($pk);
        if($colaborador->getpk()>0){
            
            $produto_servicodao->excluirProdutosServicosColaboradoresPk($colaborador->getpk());
            
            //remove os documentos
            $query = $documentodao->listar_por_colaboradores_pk($ds_colaborador);
            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $nome_arquivo = safeFilename($query[$i]['ds_documento']);
                    $arquivo = safePath(getUploadBaseDir(), $nome_arquivo);
                    if($arquivo !== false && file_exists($arquivo)){
                        unlink($arquivo);
                    }
                }
            }
            //exclui os documentos do BD
            $documentodao->excluirDocumentoColaboradoresPk($colaborador->getpk());
            
            $colaboradordao->excluir($colaborador);
            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'colaborador nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        
        $produtos_servicos_colaboradores = $_REQUEST['produtos_servicos_colaboradores'];
        
        if($produtos_servicos_colaboradores != "")
            $arrProdutosServicosColaboradores = json_decode ($produtos_servicos_colaboradores, true);
        
        $colaborador = $colaboradordao->carregarPorPk($pk);
        $colaborador->setds_colaborador($ds_colaborador);
        $colaborador->setds_cel($ds_cel);
        $colaborador->setic_whatsapp($ic_whatsapp);
        $colaborador->setds_cel2($ds_cel2);
        $colaborador->setic_whatsapp2($ic_whatsapp2);
        $colaborador->setds_cel3($ds_cel3);
        $colaborador->setic_whatsapp3($ic_whatsapp3);
        $colaborador->setds_email($ds_email);
        $colaborador->setds_rg($ds_rg);
        $colaborador->setds_cpf($ds_cpf);
        $colaborador->setdt_nascimento(DataYMD($dt_nascimento));
        $colaborador->setds_endereco($ds_endereco);
        $colaborador->setds_numero($ds_numero);
        $colaborador->setds_complemento($ds_complemento);
        $colaborador->setds_bairro($ds_bairro);
        $colaborador->setds_cep($ds_cep);
        $colaborador->setds_cidade($ds_cidade);
        $colaborador->setds_uf($ds_uf);
        $colaborador->setic_status($ic_status);
        $colaborador->setic_funcionario($ic_funcionario);
        $colaborador->setgeneros_pk($generos_pk);

        
        $pk = $colaboradordao->salvar($colaborador);
        
        if($pk!=""){
            $produto_servicodao->excluirProdutosServicosColaboradoresPk($pk);
        
            if(count($arrProdutosServicosColaboradores) > 0){
                for($i = 0; $i < count($arrProdutosServicosColaboradores); $i++){
                    $produto_servicodao->adicionarProdutosServicosColaboradores($pk, $arrProdutosServicosColaboradores[$i]['produtos_servicos_pk'], $arrProdutosServicosColaboradores[$i]["ic_possui_treinamento"],$arrProdutosServicosColaboradores[$i]["ic_possui_certificado"]);
                }
            }
        }
        else{
            $produto_servicodao->excluirProdutosServicosColaboradoresPk($colaborador->getpk());
        
            if(count($arrProdutosServicosColaboradores) > 0){
                for($i = 0; $i < count($arrProdutosServicosColaboradores); $i++){
                    $produto_servicodao->adicionarProdutosServicosColaboradores($colaborador->getpk(), $arrProdutosServicosColaboradores[$i]['produtos_servicos_pk'], $arrProdutosServicosColaboradores[$i]["ic_possui_treinamento"],$arrProdutosServicosColaboradores[$i]["ic_possui_certificado"]);
                }
            }
        }
        
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $colaboradordao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_whatsapp"=>$query[$i]['ic_whatsapp'],
                    "ds_cel2"=>$query[$i]['ds_cel2'],
                    "ic_whatsapp2"=>$query[$i]['ic_whatsapp2'],
                    "ds_cel3"=>$query[$i]['ds_cel3'],
                    "ic_whatsapp3"=>$query[$i]['ic_whatsapp3'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "dt_nascimento"=>$query[$i]['dt_nascimento'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "ic_funcionario"=>$query[$i]['ic_funcionario'],
                    "generos_pk"=>$query[$i]['generos_pk']
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
        $query = $colaboradordao->listar_por_ds_colaborador($ds_colaborador);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_whatsapp"=>$query[$i]['ic_whatsapp'],
                    "ds_cel2"=>$query[$i]['ds_cel2'],
                    "ic_whatsapp2"=>$query[$i]['ic_whatsapp2'],
                    "ds_cel3"=>$query[$i]['ds_cel3'],
                    "ic_whatsapp3"=>$query[$i]['ic_whatsapp3'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "dt_nascimento"=>$query[$i]['dt_nascimento'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "generos_pk"=>$query[$i]['generos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listarTodosRel':{
        
        $resultado = "";
        $query = $colaboradordao->listarTodosColaboradoresEServicos($ds_colaborador);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_colaborador"=>$query[$i]['ds_colaborador']." (".$query[$i]['ds_produto_servico'].")"
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listarTodosColaboradoresEServico':{
        
        
        $dt_inicio_agenda = $_REQUEST['dt_inicio_agenda'];
        $dt_fim_agenda = $_REQUEST['dt_fim_agenda'];
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        $agenda_colaborador_padrao_pk = $_REQUEST['agenda_colaborador_padrao_pk'];
        $ic_dom = $_REQUEST['ic_dom'];
        $ic_seg = $_REQUEST['ic_seg'];
        $ic_ter = $_REQUEST['ic_ter'];
        $ic_qua = $_REQUEST['ic_qua'];
        $ic_qui = $_REQUEST['ic_qui'];
        $ic_sex = $_REQUEST['ic_sex'];
        $ic_sab = $_REQUEST['ic_sab'];
        $dom_turnos_pk = $_REQUEST['dom_turnos_pk'];
        $seg_turnos_pk = $_REQUEST['seg_turnos_pk'];
        $ter_turnos_pk = $_REQUEST['ter_turnos_pk'];
        $qua_turnos_pk = $_REQUEST['qua_turnos_pk'];
        $qui_turnos_pk = $_REQUEST['qui_turnos_pk'];
        $sex_turnos_pk = $_REQUEST['sex_turnos_pk'];
        $sab_turnos_pk = $_REQUEST['sab_turnos_pk'];
        $resultado = "";
        $query = $colaboradordao->listar_por_ds_colaborador_e_servico($ic_dom,$ic_seg,$ic_ter,$ic_qua,$ic_qui,$ic_sex,$ic_sab,$dom_turnos_pk,$seg_turnos_pk,$ter_turnos_pk,$qua_turnos_pk,$qui_turnos_pk,$sex_turnos_pk,$sab_turnos_pk,$dt_inicio_agenda,$dt_fim_agenda,$produtos_servicos_pk,$agenda_colaborador_padrao_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_colaborador"=>$query[$i]['ds_colaborador']
                );
            }
        }
        else{
            $mysql_data = [];
        }
        
        break;
    }
    
    case 'listarTodosColaboradoresEServicoAgenda':{  
        
        $dias_semanas_pk = $_REQUEST['dia_semana_pk'];
        if($dias_semanas_pk==1){
            $ic_dom = 1;
            $dom_turnos_pk = $_REQUEST['turnos_pk'];
        }
        if($dias_semanas_pk==2){
            $ic_seg = 1;
            $seg_turnos_pk = $_REQUEST['turnos_pk'];
        }
        if($dias_semanas_pk==3){
            $ic_ter = 1;
            $ter_turnos_pk = $_REQUEST['turnos_pk'];
        }
        if($dias_semanas_pk==4){
            $ic_qua = 1;
            $qua_turnos_pk = $_REQUEST['turnos_pk'];
        }
        if($dias_semanas_pk==5){
            $ic_qui = 1;
            $qui_turnos_pk = $_REQUEST['turnos_pk'];
        }
        if($dias_semanas_pk==6){
            $ic_sex = 1;
            $sex_turnos_pk = $_REQUEST['turnos_pk'];
        }
        if($dias_semanas_pk==7){
            $ic_sab = 1;
            $sab_turnos_pk = $_REQUEST['turnos_pk'];
        }
        
        $dt_inicio_agenda = $_REQUEST['dt_inicio_agenda'];
        $dt_fim_agenda = $_REQUEST['dt_inicio_agenda'];
        $contratos_itens_pk = $_REQUEST['contratos_itens_pk'];
        $agenda_colaborador_padrao_pk = $_REQUEST['agenda_colaborador_padrao_pk'];

        $resultado = "";
        $query = $colaboradordao->listar_por_ds_colaborador_e_servico($ic_dom,$ic_seg,$ic_ter,$ic_qua,$ic_qui,$ic_sex,$ic_sab,$dom_turnos_pk,$seg_turnos_pk,$ter_turnos_pk,$qua_turnos_pk,$qui_turnos_pk,$sex_turnos_pk,$sab_turnos_pk,$dt_inicio_agenda,$dt_fim_agenda,$contratos_itens_pk,$agenda_colaborador_padrao_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "ds_produto_colaborador"=>$query[$i]['ds_produto_colaborador'],
                );
            }
        }
        else{
            $mysql_data = [];
        }
        break;
    }
    case 'listarDataTable':{
        
        $produtos_servicos_pk = $_REQUEST['produtos_servicos_pk'];
        $resultado = "";
        $query = $colaboradordao->listar_por_ds_colaborador($ds_colaborador,$ic_status,$produtos_servicos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ic_whatsapp"=>$query[$i]['ic_whatsapp'],
                    "t_ds_cel2"=>$query[$i]['ds_cel2'],
                    "t_ic_whatsapp2"=>$query[$i]['ic_whatsapp2'],
                    "t_ds_cel3"=>$query[$i]['ds_cel3'],
                    "t_ic_whatsapp3"=>$query[$i]['ic_whatsapp3'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_rg"=>$query[$i]['ds_rg'],
                    "t_ds_cpf"=>$query[$i]['ds_cpf'],
                    "t_dt_nascimento"=>$query[$i]['dt_nascimento'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_generos_pk"=>$query[$i]['generos_pk'],

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

$colaboradordao = null;

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
