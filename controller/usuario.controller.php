<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/usuario.dao.php";
include_once "../model/usuario.class.php";

include_once "../model/usuario_polo.dao.php";
include_once "../model/usuario_polo.class.php";

$arrRequest = tratar_request();

function normalize_auth_value($value){
    $value = (string)$value;
    $value = str_replace("\0", "", $value);
    $value = preg_replace('/[\r\n\t]+/', '', $value);
    return trim($value);
}

$job = isset($arrRequest['job']) ? $arrRequest['job'] : "";
$token = isset($arrRequest['token']) ? $arrRequest['token'] : "";
$pk = isset($arrRequest['pk']) ? $arrRequest['pk'] : "";
$ds_usuario = isset($arrRequest['ds_usuario']) ? $arrRequest['ds_usuario'] : "";
$ds_login = isset($arrRequest['ds_login']) ? $arrRequest['ds_login'] : "";
$ds_senha = isset($arrRequest['ds_senha']) ? $arrRequest['ds_senha'] : "";
$ds_email = isset($arrRequest['ds_email']) ? $arrRequest['ds_email'] : "";
$ds_cel = isset($arrRequest['ds_cel']) ? $arrRequest['ds_cel'] : "";
$ic_status = isset($arrRequest['ic_status']) ? $arrRequest['ic_status'] : "";
$grupos_pk = isset($arrRequest['grupos_pk']) ? $arrRequest['grupos_pk'] : "";
$contas_pk = isset($arrRequest['contas_pk']) ? $arrRequest['contas_pk'] : "";

$polos_pk = $_REQUEST['polos_pk'];  

$usuario_polodao = new usuario_polodao();
$usuario_polodao->setToken($token); 

$usuariodao = new usuariodao();
$usuariodao->setToken($token);

$arrUsuarioPolo = array();

// Inicializa variáveis para garantir que sempre tenham um valor
$result = 'error';
$message = 'Requisição inválida.';
$mysql_data = [];

if($job !== "autenticarUsuario" && $job !== "trocarSenha"){
    verificarLogin($token);
}

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $usuario = $usuariodao->carregarPorPk($pk);
        if($usuario->getpk()>0){
            $usuariodao->excluirPolo($usuario->getpk());
            $usuariodao->excluir($usuario);
            
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'usuario nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        if($polos_pk != "")
            $arrUsuario_polo = json_decode ($polos_pk, true);
        
        $usuario = $usuariodao->carregarPorPk($pk);
        $usuario->setds_usuario($ds_usuario);
        $usuario->setds_login($ds_login);
        $usuario->setds_senha($ds_senha);
        $usuario->setds_email($ds_email);
        $usuario->setds_cel($ds_cel);
        $usuario->setic_status($ic_status);
        $usuario->setgrupos_pk($grupos_pk);
        $usuario->setcontas_pk($contas_pk);

        $pk = $usuariodao->salvar($usuario);
        
        /*$mysql_data[] = array(
                "pk" => $pk
        );*/
        
         if($pk!=""){
            $usuarios_pk = $pk;
        }
        else{
            $usuarios_pk = $usuario->getpk();
        }
        
        //POLO
        if(count( $arrUsuario_polo) > 0){            
            for($i = 0; $i < count($arrUsuario_polo); $i++){
                if($arrUsuario_polo[$i]['usuario_polos_pk']=="null"){
                    $arrUsuarioPolo[$i] = "";
                }
                else{
                    $arrUsuarioPolo[$i] = $arrUsuario_polo[$i]['usuario_polos_pk'];
                }
        
                $usuario_polo = $usuario_polodao->carregarPorPk($arrUsuarioPolo[$i]);
                $usuario_polo->setpk($arrUsuarioPolo[$i]);
                $usuario_polo->setpolos_pk($arrUsuario_polo[$i]['polos_pk']);
                $usuario_polo->setusuarios_pk($usuarios_pk);    
                $usuario_polo->setic_status(1);
                $usuario_polo_pk = $usuario_polodao->salvar($usuario_polo);

            }          
        }

        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $usuariodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']
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
        $query = $usuariodao->listar_por_ds_usuario($ds_usuario,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    
    case 'listarPorGrupo':{

        $grupos_pk = $_REQUEST['grupos_pk'];
        $resultado = "";
        $usuario_logado_eh_supervisor_equipe = $usuariodao->usuario_logado_eh_supervisor_equipe();
         if(permissao("responsavel_listar_todos", "cons", $token)){
            $query = $usuariodao->listar_por_grupos_pk($grupos_pk,$token);
            $result  = 'success';
            $message = 'query success';
        }
        else if(permissao("responsavel_listar_equipes", "cons", $token) || permissao("supervisor_listar_equipes", "cons", $token) || $usuario_logado_eh_supervisor_equipe){
            $query = $usuariodao->listar_por_grupos_pk_equipes_pk($grupos_pk,$token);
            $result  = 'success';
            $message = 'query success';
        }
        else{          
            $mysql_data = [];
        }
        
        
        

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']    
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarPorGrupoRetorno':{

        $grupos_pk = $_REQUEST['grupos_pk'];
        $resultado = "";
         if(permissao("responsavel_listar_todos_retorno", "cons", $token)){
            $query = $usuariodao->listar_por_grupos_pk($grupos_pk,$token);
            $result  = 'success';
            $message = 'query success';
        }
        else if(permissao("responsavel_listar_equipes_retorno", "cons", $token)){
            $query = $usuariodao->listar_por_grupos_pk_equipes_pk_retorno($grupos_pk,$token);
            $result  = 'success';
            $message = 'query success';
        }
        else{          
            $mysql_data = [];
        }
        
        
        

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']    
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarSupervisor':{
        
        $resultado = "";
        $query = $usuariodao->listar_supervisor($ds_usuario);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarMembroEquipe':{
        
        $resultado = "";
        $query = $usuariodao->listar_membro_equipe();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarAtentedente':{
        $grupos_pk = $_REQUEST['grupos_pk'];
        $resultado = "";
        $query = $usuariodao->listar_atendente($token,$grupos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarUsuarioLogado':{
        
        $resultado = "";
        $query = $usuariodao->listarUsuarioLogado();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "grupos_pk"=>$query[$i]['grupos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listar_por_equipes':{
        
        $equipes_pk = $_REQUEST['equipes_pk'];
        $resultado = "";
        $query = $usuariodao->listar_por_equipes($equipes_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_usuario"=>$query[$i]['ds_usuario'],
                    "ds_login"=>$query[$i]['ds_login'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "grupos_pk"=>$query[$i]['grupos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        $ic_status = $_REQUEST['ic_status'];
        $grupos_pk = $_REQUEST['grupos_pk'];
        $polos_pk = $_REQUEST['polos_pk'];
        $resultado = "";
        $query = $usuariodao->listar_por_token($ds_usuario,$ic_status,$grupos_pk,$polos_pk,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],
                    "t_ds_login"=>$query[$i]['ds_login'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_grupos_pk"=>$query[$i]['grupos_pk'],
                    "t_ds_grupo"=>$query[$i]['ds_grupo'],
                    "t_ds_perfil"=>$query[$i]['ds_polo'],
                    "contas_pk"=>$query[$i]['contas_pk'],    

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'autenticarUsuario':{
        
        $ds_login = normalize_auth_value(isset($_REQUEST['ds_login']) ? $_REQUEST['ds_login'] : "");
        $ds_senha = normalize_auth_value(isset($_REQUEST['ds_senha']) ? $_REQUEST['ds_senha'] : "");
        
        $query = $usuariodao->listarLogin($ds_login, $ds_senha);
        
        if(count($query)==1){
            $auth = array(
                "usuarios_pk" => $query[0]["par1"],
                "ds_usuario" => $query[0]["par2"],
                "ds_login" => $query[0]["par3"],
                "dt_validade_login" => $query[0]["par4"],
                "contas_pk" => $query[0]["par5"],
                "grupos_pk" => $query[0]["par6"],
                "equipes_pk" => $query[0]["par7"],
                "polos_pk" => $query[0]["par8"]
            );
            $_SESSION['auth'] = $auth;
            $_SESSION['auth_exp'] = time() + (10 * 3600);
            session_regenerate_id(true);
            $mysql_data[] = array(
                "token" => session_id()
            );
            $result  = 'success';
            $message = 'query success';

        }
        else{
            $result  = 'error';
            $message = 'Usuário ou Senha Incorreto';
        }
        break;
    }
    case 'verificarPermissao':{
        
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $ds_dominio_modulo = $_REQUEST['ds_dominio_modulo'];
        $ic_acao = $_REQUEST['ic_acao'];
        $arrToken = tratarToken($token);
        
	$usuarios_pk = $arrToken['usuarios_pk'];
        
        $total = $usuariodao->verificarPermissao($usuarios_pk,$ds_dominio_modulo,$ic_acao);
        
	if($total > 0){
            $result  = 'success';
            $message = 'query success';
        }
	else{
            $result  = 'error';
            $message = 'Você não tem permissão';
        }
        break;
    }     
    case 'trocarSenha':{
        
        $ds_login_novo = normalize_auth_value(isset($_REQUEST['ds_login']) ? $_REQUEST['ds_login'] : "");
        $ds_senha_novo = normalize_auth_value(isset($_REQUEST['ds_nova_senha']) ? $_REQUEST['ds_nova_senha'] : "");
        $ds_confirar_senha_novo = normalize_auth_value(isset($_REQUEST['ds_cofirmar_senha']) ? $_REQUEST['ds_cofirmar_senha'] : "");
        
        
        
        if($ds_senha_novo != $ds_confirar_senha_novo){
            $result  = 'error';
            $message = 'Senhas Diferentes';
        }
        else{
            
            $usuario_pk = $usuariodao->listar_nome_login($ds_login_novo);
            if($usuario_pk==""){
                $result  = 'error';
                $message = 'Usuário não encontrado';
            }
            $query = $usuariodao->trocarSenha($usuario_pk,$ds_senha_novo);
        }
        
        
        //verifica login e senha
        $query = $usuariodao->listarLogin($ds_login_novo, $ds_senha_novo);

        if(count($query)==1){
            $auth = array(
                "usuarios_pk" => $query[0]["par1"],
                "ds_usuario" => $query[0]["par2"],
                "ds_login" => $query[0]["par3"],
                "dt_validade_login" => $query[0]["par4"],
                "contas_pk" => $query[0]["par5"],
                "grupos_pk" => $query[0]["par6"],
                "equipes_pk" => $query[0]["par7"],
                "polos_pk" => $query[0]["par8"]
            );
            $_SESSION['auth'] = $auth;
            $_SESSION['auth_exp'] = time() + (10 * 3600);
            session_regenerate_id(true);

            $mysql_data[] = array(
                "token" => session_id()
            );
            $result  = 'success';
            $message = 'query success';

        }
        
        break;
    }     
    default:{
        break;
    }
}

$usuariodao = null;

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
