<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/processo_default.dao.php";
include_once "../model/processo_default.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_processo_default = $arrRequest['ds_processo_default'];
$ic_status = $arrRequest['ic_status'];
$polos_pk = $arrRequest['polos_pk'];


$processo_defaultdao = new processo_defaultdao();
$processo_defaultdao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $processo_default = $processo_defaultdao->carregarPorPk($pk);
        if($processo_default->getpk()>0){
            $processo_defaultdao->excluirProcessosDefaultEtapasPk($processo_default->getpk());
            $processo_defaultdao->excluir($processo_default);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'processo_default nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $arrProcessoEtapa = $_REQUEST['arrProcessoEtapa'];
        
        if($arrProcessoEtapa != "")
            $arrProcessosEtapasDefaultPk = json_decode ($arrProcessoEtapa, true);
                      
        $processo_default = $processo_defaultdao->carregarPorPk($pk);
        $processo_default->setds_processo_default($ds_processo_default);
        $processo_default->setic_status($ic_status);
        $processo_default->setpolos_pk($polos_pk);
        $pk = $processo_defaultdao->salvar($processo_default);
        
        if($pk!=""){           
   
            $processo_defaultdao->excluirProcessosDefaultEtapasPk($pk);
        
            if(count($arrProcessosEtapasDefaultPk) > 0){
                for($i = 0; $i < count($arrProcessosEtapasDefaultPk); $i++){
                    $processo_defaultdao->adicionarProcessosDefaultEtapas($pk,$arrProcessosEtapasDefaultPk[$i]['tipos_ocorrencias_pk'], $arrProcessosEtapasDefaultPk[$i]['ds_processo_default_etapa'], $arrProcessosEtapasDefaultPk[$i]["n_ordem_etapa"],1,$arrProcessosEtapasDefaultPk[$i]["classificacao_processo_etapa_pk"],$arrProcessosEtapasDefaultPk[$i]["ic_ev_email_responsavel"],$arrProcessosEtapasDefaultPk[$i]["ic_ev_email_lead"],$arrProcessosEtapasDefaultPk[$i]["email_saida_grupos_pk"],$arrProcessosEtapasDefaultPk[$i]["ds_email_saida"]);
                }
            }
        }else{

            $processo_defaultdao->excluirProcessosDefaultEtapasPk($processo_default->getpk());
        
            if(count($arrProcessosEtapasDefaultPk) > 0){
                for($i = 0; $i < count($arrProcessosEtapasDefaultPk); $i++){
                    $processo_defaultdao->adicionarProcessosDefaultEtapas($processo_default->getpk(),$arrProcessosEtapasDefaultPk[$i]['tipos_ocorrencias_pk'], $arrProcessosEtapasDefaultPk[$i]['ds_processo_default_etapa'], $arrProcessosEtapasDefaultPk[$i]["n_ordem_etapa"],1,$arrProcessosEtapasDefaultPk[$i]["classificacao_processo_etapa_pk"],$arrProcessosEtapasDefaultPk[$i]["ic_ev_email_responsavel"],$arrProcessosEtapasDefaultPk[$i]["ic_ev_email_lead"],$arrProcessosEtapasDefaultPk[$i]["email_saida_grupos_pk"],$arrProcessosEtapasDefaultPk[$i]["ds_email_saida"]);
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
        $query = $processo_defaultdao->listarPorPk($pk,$token);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo_default"=>$query[$i]['ds_processo_default'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "polos_pk"=>$query[$i]['polos_pk']
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
        $query = $processo_defaultdao->listar_por_ds_processo_default($ds_processo_default,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo_default"=>$query[$i]['ds_processo_default'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorPolosPk':{
        $polos_pk = $_REQUEST['polos_pk'];
        $resultado = "";
        $query = $processo_defaultdao->listar_por_polos_pk($polos_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_processo_default"=>$query[$i]['ds_processo_default'],
                    "ic_status"=>$query[$i]['ic_status']
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
        $query = $processo_defaultdao->listar_por_ds_processo_default($ds_processo_default,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_processo_default"=>$query[$i]['ds_processo_default'],
                    "t_ic_status"=>$query[$i]['ic_status'],

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

$processo_defaultdao = null;

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
