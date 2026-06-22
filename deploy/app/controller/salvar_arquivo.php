<?php
include_once "../inc/php/config.php";
include_once "../inc/php/public.php";

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
verificarLogin($token);

header('Content-Type: application/json; charset=utf-8');

$response = array(
    "result" => "error",
    "message" => "upload_failed",
    "data" => array()
);

if(!isset($_FILES['FilesPic'])){
    echo json_encode($response);
    exit;
}

$upload = $_FILES['FilesPic'];
if(!isset($upload['error']) || $upload['error'] !== UPLOAD_ERR_OK){
    $response["message"] = "invalid_upload_error";
    echo json_encode($response);
    exit;
}

$maxSize = getenv("UPLOAD_MAX_SIZE") ? (int)getenv("UPLOAD_MAX_SIZE") : (5 * 1024 * 1024);
if(!isset($upload['size']) || $upload['size'] <= 0 || $upload['size'] > $maxSize){
    $response["message"] = "invalid_upload_size";
    echo json_encode($response);
    exit;
}

$originalName = isset($upload['name']) ? $upload['name'] : "arquivo";
$safeOriginalName = safeFilename($originalName);
$ext = strtolower(pathinfo($safeOriginalName, PATHINFO_EXTENSION));

$allowedExt = array("pdf", "jpg", "jpeg", "png", "csv");
$blockedExt = array("php", "phtml", "php5", "phar", "cgi", "pl", "sh");

if($ext === "" || in_array($ext, $blockedExt, true) || !in_array($ext, $allowedExt, true)){
    $response["message"] = "invalid_upload_extension";
    echo json_encode($response);
    exit;
}

if(preg_match('/\.(php|phtml|php5|phar|cgi|pl|sh)\./i', $safeOriginalName)){
    $response["message"] = "double_extension_blocked";
    echo json_encode($response);
    exit;
}

$tmpName = $upload['tmp_name'];
if(!is_uploaded_file($tmpName)){
    $response["message"] = "invalid_uploaded_file";
    echo json_encode($response);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = $finfo ? finfo_file($finfo, $tmpName) : "";
if($finfo){
    finfo_close($finfo);
}

$allowedMime = array(
    "pdf" => array("application/pdf"),
    "jpg" => array("image/jpeg"),
    "jpeg" => array("image/jpeg"),
    "png" => array("image/png"),
    "csv" => array("text/plain", "text/csv", "application/csv", "application/vnd.ms-excel")
);

if(!isset($allowedMime[$ext]) || !in_array($mime, $allowedMime[$ext], true)){
    $response["message"] = "invalid_upload_mime";
    echo json_encode($response);
    exit;
}

$baseDir = ensureUploadBaseDir();
$savedName = bin2hex(random_bytes(16)) . "." . $ext;
$targetPath = safePath($baseDir, $savedName);
if($targetPath === false){
    $response["message"] = "invalid_upload_target";
    echo json_encode($response);
    exit;
}

if(!move_uploaded_file($tmpName, $targetPath)){
    $response["message"] = "move_upload_failed";
    echo json_encode($response);
    exit;
}

$arrToken = tratarToken($token);
$response["result"] = "success";
$response["message"] = "ok";
$response["data"][] = array(
    "ds_documento" => $savedName,
    "ds_nome_original" => $safeOriginalName,
    "mime_type" => $mime,
    "file_size" => (int)$upload['size'],
    "owner_usuario_pk" => isset($arrToken['usuarios_pk']) ? $arrToken['usuarios_pk'] : "",
    "contas_pk" => isset($arrToken['contas_pk']) ? $arrToken['contas_pk'] : ""
);

echo json_encode($response);
