<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/documento.dao.php";
include_once "../model/documento.class.php";

$arrRequest = tratar_request();

$job = isset($arrRequest['job']) ? $arrRequest['job'] : "";
$token = isset($arrRequest['token']) ? $arrRequest['token'] : "";
$pk = isset($arrRequest['pk']) ? $arrRequest['pk'] : "";
$ds_documento = isset($arrRequest['ds_documento']) ? $arrRequest['ds_documento'] : "";
$ds_obs = isset($arrRequest['ds_obs']) ? $arrRequest['ds_obs'] : "";
$ds_nome_original = isset($arrRequest['ds_nome_original']) ? $arrRequest['ds_nome_original'] : "";
$leads_pk = isset($arrRequest['leads_pk']) ? $arrRequest['leads_pk'] : "";
$contratos_pk = isset($arrRequest['contratos_pk']) ? $arrRequest['contratos_pk'] : "";
$ocorrencias_pk = isset($arrRequest['ocorrencias_pk']) ? $arrRequest['ocorrencias_pk'] : "";

verificarLogin($token);
ensureUploadBaseDir();

$documentodao = new documentodao();
$documentodao->setToken($token); 

switch($job){

    
    case 'download':{
        set_time_limit(0);
        $fileId = isset($_REQUEST['file_id']) ? $_REQUEST['file_id'] : $pk;
        $documento = $documentodao->carregarPorPk($fileId);
        if(!$documento || $documento->getpk() == ""){
            http_response_code(404);
            exit;
        }

        $savedName = $documento->getds_documento();
        $baseDir = getUploadBaseDir();
        $arquivoLocal = safePath($baseDir, $savedName);
        if($arquivoLocal === false || !file_exists($arquivoLocal)){
            http_response_code(404);
            exit;
        }
        $novoNome = $documento->getds_nome_original() ? safeFilename($documento->getds_nome_original()) : safeFilename($savedName);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="'.$novoNome.'"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($arquivoLocal));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');
        readfile($arquivoLocal);
        break;
    }
    
    case 'excluir':{
        
        $resultdo = "";
        
        $documento = $documentodao->carregarPorPk($pk);
        if($documento->getpk()>0){
            
            $documentodao->excluir($documento);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'documento nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        
            $ds_arquivo = isset($_REQUEST['ds_arquivo']) ? $_REQUEST['ds_arquivo'] : "";
            $documento = $documentodao->carregarPorPk($pk);
            if($ds_arquivo != "")
                $arrDsArquivos = json_decode ($ds_arquivo, true);
            
            if(count($arrDsArquivos) > 0){
                for($i = 0; $i < count($arrDsArquivos); $i++){
                    
                    
                    $documento->setds_documento($arrDsArquivos[$i]['ds_documento']);
                    $documento->setds_obs($ds_obs);
                    $documento->setds_nome_original($arrDsArquivos[$i]['ds_nome_original']);
                    $documento->setleads_pk($leads_pk);
                    $documento->setcontratos_pk($contratos_pk);
                    $documento->setocorrencias_pk($ocorrencias_pk);

                    $pk = $documentodao->salvar($documento);  
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
        $query = $documentodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_documento"=>$query[$i]['ds_documento'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk']
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
        $query = $documentodao->listar_por_ds_documento($ds_documento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_documento"=>$query[$i]['ds_documento'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contratos_pk"=>$query[$i]['contratos_pk'],
                    "ocorrencias_pk"=>$query[$i]['ocorrencias_pk']
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
        $query = $documentodao->listar_por_ds_documento($ds_documento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarDocumentosLead':{
        
        $leads_pk = isset($_REQUEST['leads_pk']) ? $_REQUEST['leads_pk'] : "";
        $resultado = "";
        if($leads_pk!=""){
            $query = $documentodao->listar_documetos_lead($leads_pk);
        }
        else{
            $mysql_data = [];
        }
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_documento"=>$query[$i]['ds_documento'],
                    "t_ds_obs"=>$query[$i]['ds_obs'],
                    "t_ds_nome_original"=>$query[$i]['ds_nome_original'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contratos_pk"=>$query[$i]['contratos_pk'],
                    "t_ocorrencias_pk"=>$query[$i]['ocorrencias_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }     
    case 'renomearArquivo':{
        
        $leads_pk = isset($_REQUEST['leads_pk']) ? $_REQUEST['leads_pk'] : "";
        $ds_arquivo = isset($_REQUEST['ds_arquivo']) ? $_REQUEST['ds_arquivo'] : "";
        $ds_arquivo = safeFilename($ds_arquivo);
        
        $resultado = "";
        $query = $documentodao->listarQuantidadeDocumentosLead($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        /*if(count($query) > 0){*/
            $novoNome = "L".$leads_pk."-".($query[0]['total']+1)."-".$ds_arquivo;
            $origem = safePath(getUploadBaseDir(), $ds_arquivo);
            $destino = safePath(getUploadBaseDir(), $novoNome);
            if($origem !== false && $destino !== false && file_exists($origem)){
                rename($origem, $destino);
            }
            $mysql_data[] = array(
                "t_ds_nome_salvo" => $novoNome,

                "t_functions" => ""
            );
        /*}
        else{
            $mysql_data = [];
        }*/
		
        break;
    }    
     
    
    case 'removerArquivo':{
        $fileId = isset($_REQUEST['file_id']) ? $_REQUEST['file_id'] : "";
        $nome_arquivo = "";
        if($fileId !== ""){
            $documento = $documentodao->carregarPorPk($fileId);
            if($documento && $documento->getpk() != ""){
                $nome_arquivo = $documento->getds_documento();
            }
        }
        if($nome_arquivo === ""){
            $nome_arquivo = isset($_REQUEST['nome_arquivo']) ? $_REQUEST['nome_arquivo'] : "";
        }
        $nome_arquivo = safeFilename($nome_arquivo);
        $arquivo = safePath(getUploadBaseDir(), $nome_arquivo);
        if($arquivo !== false && file_exists($arquivo)){
            unlink($arquivo);
        }
        $result  = 'success';
        $message = 'query success';
        break;
    }    
    default:{
        break;
    }
}

$documentodao = null;

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
