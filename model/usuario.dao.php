<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/usuario.class.php';



class usuariodao{

    private $db;
    private $arrToken;

    public function __construct(){
        
        $this->db = new DataBase();
        $this->db->conectar();
        
    }
    
    public function __destruct() {
        $this->db->desconectar();
    }
    
    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }    
    
    public function salvar($usuario){

        $fields = array();
        $fields['ds_usuario'] = $usuario->getds_usuario();
        $fields['ds_login'] = $usuario->getds_login();
        $senha = $usuario->getds_senha();
        if($senha !== null && $senha !== ""){
            if(password_get_info($senha)['algo'] === 0){
                $senha = password_hash($senha, PASSWORD_BCRYPT);
            }
            $fields['ds_senha'] = $senha;
        }
        $fields['ds_email'] = $usuario->getds_email();
        $fields['ds_cel'] = $usuario->getds_cel();
        $fields['ic_status'] = $usuario->getic_status();
        $fields['grupos_pk'] = $usuario->getgrupos_pk();
        $fields['contas_pk'] = $usuario->getcontas_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($usuario->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            

            $pk = $this->db->execInsert("usuarios", $fields);
            
            
            return $pk;
        }
        else{
            return $this->db->execUpdate("usuarios", $fields, " pk = ".$usuario->getpk());
        }

    }

    public function excluir($usuario){
        $this->db->execDelete("usuarios"," pk = ".$usuario->getpk());
    }
    public function excluirPolo($usuarios_pk){
        $this->db->execDelete("usuarios_polos"," usuarios_pk = ".$usuarios_pk);
    }

    public function carregarPorPk($pk){

        $usuario = new usuario();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="  from usuarios ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $usuario->setpk($query[$i]["pk"]);
                $usuario->setdt_cadastro($query[$i]["dt_cadastro"]);
                $usuario->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $usuario->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $usuario->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
                $usuario->setds_usuario($query[$i]['ds_usuario']);
                $usuario->setds_login($query[$i]['ds_login']);
                $usuario->setds_senha($query[$i]['ds_senha']);
                $usuario->setds_email($query[$i]['ds_email']);
                $usuario->setds_cel($query[$i]['ds_cel']);
                $usuario->setic_status($query[$i]['ic_status']);
                $usuario->setgrupos_pk($query[$i]['grupos_pk']);
                $usuario->setcontas_pk($query[$i]['contas_pk']);
            }
        }
        return $usuario;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="  from usuarios ";
        $sql.=" where pk = $pk ";
      
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function pegarEmailResponsavel($pk){

        $sql ="";
        $sql.="select ds_email ";
        $sql.="  from usuarios ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query[0]['ds_email'];

    }
    public function listarUsuarioLogado(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="  from usuarios ";
        $sql.=" where pk =".$this->arrToken['usuarios_pk'];
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_nome_login($ds_login){
        $sql = "select pk from usuarios where ds_login = ?";
        $query = $this->db->execPreparedQuery($sql, "s", array($ds_login));
        return count($query) > 0 ? $query[0]['pk'] : "";

    }

    public function listar_por_ds_usuario($ds_usuario,$token){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,case u.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ic_status";
        $sql.="       ,g.ds_grupo grupos_pk ";
        $sql.="       ,u.contas_pk ";
        $sql.="  from usuarios u";
        $sql.="       left join grupos g on g.pk = u.grupos_pk";
        $sql.="       left join usuarios_polos up on up.usuarios_pk = u.pk";
        $sql.=" where 1=1 ";

        $sql.=" and u.contas_pk=".$this->arrToken['contas_pk'];
        if($this->arrToken['polos_pk']!=""){
            $sql.=" and up.polos_pk=".$this->arrToken['polos_pk'];
        }
        if(permissao("grupo_consultor_listar", "cons", $token)){
            $sql.=" and u.pk =".$this->arrToken['usuarios_pk'];
        }
       
        if($ds_usuario!=""){
            $sql.=" and u.ds_usuario like '%".$ds_usuario."%'";
        }

            
        $sql.=" group by u.pk";
        $sql.=" order by ds_usuario asc ";
        

        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_token($ds_usuario,$ic_status,$grupos_pk,$polos_pk,$token){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,case u.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ic_status";
        $sql.="       ,g.ds_grupo grupos_pk ";
        $sql.="       ,u.contas_pk ";
        $sql.="       ,g.ds_grupo";
        $sql.="       ,p.ds_polo";
        $sql.="  from usuarios u";
        $sql.="       inner join grupos g on g.pk = u.grupos_pk";
        $sql.="       left join usuarios_polos up on up.usuarios_pk = u.pk";
        $sql.="       left join polos p on up.polos_pk = p.pk";
        $sql.=" where 1=1 ";

        $sql.=" and u.contas_pk=".$this->arrToken['contas_pk'];
       
        if($ds_usuario!=""){
            $sql.=" and u.ds_usuario like '%".$ds_usuario."%'";
        }
        if($ic_status!=""){
            $sql.=" and u.ic_status  = ".$ic_status;
        }
        if($polos_pk!=""){
            $sql.=" and p.pk  = ".$polos_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and u.grupos_pk  = ".$grupos_pk;
        }
        
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and u.grupos_pk not in (1)";
        }
        if(!permissao("grupo_listar_todos", "cons", $token) && !permissao("supervisor_listar_equipes", "cons", $token)){
            $sql.=" and u.grupos_pk =".$this->arrToken['grupos_pk'];
        }
            
        $sql.=" order by ds_usuario asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    public function listar_por_grupos_pk($grupos_pk,$token){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="  from usuarios ";
        $sql.=" where 1=1 ";
        $sql.=" and contas_pk=".$this->arrToken['contas_pk'];
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and grupos_pk not in (1)";
        }
        if(!permissao("grupo_listar_todos", "cons", $token)){
            $sql.=" and grupos_pk =".$this->arrToken['grupos_pk'];
        }
        if($grupos_pk!=""){
            $sql.=" and grupos_pk=".$grupos_pk;
        }
                
        $sql.=" order by ds_usuario asc ";
       


        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_grupos_pk_equipes_pk($grupos_pk,$token){
        $usuario_logado_eh_supervisor_equipe = $this->usuario_logado_eh_supervisor_equipe();

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="       ,u.contas_pk ";
        $sql.="  from usuarios u";
        $sql.="       left join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.=" where 1=1 ";
        $sql.=" and u.contas_pk=".$this->arrToken['contas_pk'];
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and u.grupos_pk not in (1)";
        }
        if(!permissao("grupo_listar_todos", "cons", $token) && !$usuario_logado_eh_supervisor_equipe){
            $sql.=" and u.grupos_pk =".$this->arrToken['grupos_pk'];
        }
        if(!permissao("usuario_listar_todos", "cons", $token) && !$usuario_logado_eh_supervisor_equipe){
            $sql.=" and u.pk =".$this->arrToken['usuarios_pk'];
        }                
        if($grupos_pk!=""){
          $sql.=" and u.grupos_pk=".$grupos_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
       
        
        
        $sql.=" order by ds_usuario asc ";
 

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function usuario_logado_eh_supervisor_equipe(){

        $sql ="";
        $sql.="select count('0') total ";
        $sql.="  from equipes_usuarios eu";
        $sql.=" where eu.usuarios_pk = ".$this->arrToken['usuarios_pk'];
        $sql.="   and eu.ic_supervisor = 1";

        $query = $this->db->execQuery($sql);
        return isset($query[0]['total']) && intval($query[0]['total']) > 0;
    }
    public function listar_por_grupos_pk_equipes_pk_retorno($grupos_pk,$token){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="       ,u.contas_pk ";
        $sql.="  from usuarios u";
        $sql.="       left join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.=" where 1=1 ";
        $sql.=" and u.contas_pk=".$this->arrToken['contas_pk'];
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and u.grupos_pk not in (1)";
        }
        if(!permissao("grupo_listar_todos", "cons", $token)){
            $sql.=" and u.grupos_pk =".$this->arrToken['grupos_pk'];
        }
        if(!permissao("usuario_listar_todos", "cons", $token)){
            $sql.=" and u.pk =".$this->arrToken['usuarios_pk'];
        }                
        if($grupos_pk!=""){
          $sql.=" and u.grupos_pk=".$grupos_pk;
        }
        if(permissao("supervisor_listar_equipes_retorno", "cons", $token)){
            if($this->arrToken['equipes_pk']!=""){
                $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
            }
        }
       
        
        
        $sql.=" order by ds_usuario asc ";
 

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    public function listar_supervisor(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="  from usuarios u";
        $sql.="       inner join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.=" where 1=1 ";
        
        $sql.="     and u.grupos_pk = 3";
        $sql.="     and eu.ic_supervisor = 1";
        $sql.="     and u.contas_pk=".$this->arrToken['contas_pk'];
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_membro_equipe($usuario_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="  from usuarios u";
        $sql.="       inner join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.=" where 1=1 ";
        
        if($this->arrToken['equipes_pk']!=""){
            $sql.="     and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        
        $sql.="     and u.contas_pk=".$this->arrToken['contas_pk'];
        if($usuario_pk!=""){
            $sql.=" and pk = ".$usuario_pk;
        }
        $sql.=" order by ds_usuario asc ";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_atendente($token,$grupos_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="  from usuarios";
        $sql.=" where 1=1 ";
        if(!permissao("agenda_atendente", "cons", $token)){
            $sql.=" and pk = ".$this->arrToken['usuarios_pk'];
        }
        $sql.=" and grupos_pk= 6";
        $sql.="     and contas_pk=".$this->arrToken['contas_pk'];
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_equipes($equipes_pk,$token){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="       ,u.contas_pk ";
        $sql.="  from usuarios u";
        $sql.="       left join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.=" where 1=1 ";
        if($equipes_pk!=""){
            $sql.="     and eu.equipes_pk = ".$equipes_pk;
        }
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and u.grupos_pk not in (1)";
        }
        if(!permissao("grupo_listar_todos", "cons", $token)){
            $sql.=" and u.grupos_pk =".$this->arrToken['grupos_pk'];
        }
        if(!permissao("usuario_listar_todos", "cons", $token)){
            $sql.=" and u.pk =".$this->arrToken['usuarios_pk'];
        }   
        $sql.="     and u.contas_pk=".$this->arrToken['contas_pk'];
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="  from usuarios ";
        $sql.=" where 1=1 ";
        $sql.="     and contas_pk=".$this->arrToken['contas_pk'];
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function trocarSenha($usuario_pk,$ds_senha){
        $fields = array();

        $fields['ds_senha'] = password_hash($ds_senha, PASSWORD_BCRYPT);
        $this->db->execUpdate("usuarios", $fields, " pk = ".$usuario_pk);
        
        

    }

    public function listarLogin($strLogin, $strSenha){
        $strLogin = trim((string)$strLogin);
        $strSenha = trim((string)$strSenha);

        $sql  = "select u.pk, u.ds_usuario, u.ds_login, u.ds_senha, u.contas_pk, g.pk grupos_pk, eu.equipes_pk, up.polos_pk ";
        $sql .= "  from usuarios u ";
        $sql .= "  left join grupos g on u.grupos_pk = g.pk ";
        $sql .= "  inner join contas c on u.contas_pk = c.pk ";
        $sql .= "  left join equipes_usuarios eu on u.pk = eu.usuarios_pk ";
        $sql .= "  left join usuarios_polos up on u.pk = up.usuarios_pk ";
        $sql .= " where u.ds_login = ? and u.ic_status = 1 and c.ic_status = 1 ";
        $query = $this->db->execPreparedQuery($sql, "s", array($strLogin));
        if(count($query) < 1){
            return array();
        }

        $usuario = $query[0];
        $senhaBanco = $usuario['ds_senha'];
        $senhaOk = false;

        if($senhaBanco !== null && $senhaBanco !== ""){
            if(password_get_info($senhaBanco)['algo'] !== 0){
                $senhaOk = password_verify($strSenha, $senhaBanco);
            } else if(hash_equals((string)$senhaBanco, (string)$strSenha)){
                $senhaOk = true;
                // migração gradual de senha em texto para hash
                $fields = array();
                $fields['ds_senha'] = password_hash($strSenha, PASSWORD_BCRYPT);
                $this->db->execUpdate("usuarios", $fields, " pk = ".$usuario['pk']);
            }
        }

        if(!$senhaOk){
            return array();
        }

        return array(array(
            "par1" => $usuario['pk'],
            "par2" => $usuario['ds_usuario'],
            "par3" => $usuario['ds_login'],
            "par4" => date('YmdHis', time() + (10 * 3600)),
            "par5" => $usuario['contas_pk'],
            "par6" => $usuario['grupos_pk'],
            "par7" => $usuario['equipes_pk'],
            "par8" => $usuario['polos_pk']
        ));
    }
    
    public function verificarTempoLogado($strDtValidadeLogin){
        
        $sql ="";
        $sql.="select '".$strDtValidadeLogin."' >= date_format(sysdate(),'%Y%m%d%H%m%s') expirado ";
        
        $query = $this->db->execQuery($sql);
        return $query[0]['expirado'];
    }    
    
    public function pegarUltimoDiaMes($newData){
        
        $sql ="";
        $sql = "select date_format(last_day('".DataYMD($newData)."'),'%d/%m/%Y') ultimodia ";
        
        $query = $this->db->execQuery($sql);
        return $query[0]['ultimodia'];
    }   
    public function verificarPermissao($usuarios_pk,$ds_dominio_modulo,$ic_acao){
        
        $sql ="";
	$sql.="select count('0') total ";
	$sql.="  from usuarios u ";
	$sql.="	   inner join grupos g on u.grupos_pk = g.pk ";
	$sql.="	   inner join modulos_grupos mg on mg.grupos_pk = g.pk ";
	$sql.="       inner join modulos m on mg.modulos_pk = m.pk ";
	$sql.=" where u.pk = ".$usuarios_pk;
	$sql.="   and m.ds_dominio = '".$ds_dominio_modulo."' ";
	
	if($ic_acao == "ins"){
            $sql.=" and mg.ic_ins = 1 ";
	}
	else if($ic_acao == "cons"){
            $sql.=" and mg.ic_cons = 1 ";
	}
	else if($ic_acao == "upd"){
            $sql.=" and mg.ic_upd = 1 ";
	}
	else if($ic_acao == "del"){
            $sql.=" and mg.ic_del = 1 ";
	}
        $query = $this->db->execQuery($sql);
        return $query[0]['total'];
    } 
    
}

?>
