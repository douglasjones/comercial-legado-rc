<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/grupo.class.php';


class grupodao{

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
    
    public function salvar($grupo){

        $fields = array();
        $fields['ds_grupo'] = $grupo->getds_grupo();
        $fields['polos_pk'] = $grupo->getpolos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["contas_pk"] = $this->arrToken['contas_pk'];
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($grupo->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("grupos", $fields);
            return $pk;
        }
        else{
            $this->db->execUpdate("grupos", $fields, " pk = ".$grupo->getpk());
            return $grupo->getpk();
        }

    }

    public function excluir($grupo){
        $this->db->execDelete("grupos"," pk = ".$grupo->getpk());
    }

    public function carregarPorPk($pk){

        $grupo = new grupo();
        if($pk != ""){
            $sql ="select pk ";
            $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
            $sql.="      , usuario_cadastro_pk ";
            $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
            $sql.="      , usuario_ult_atualizacao_pk ";

            $sql.="       ,ds_grupo ";


            $sql.="  from grupos ";
            $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $grupo->setpk($query[$i]["pk"]);
                $grupo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $grupo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $grupo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $grupo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $grupo->setds_grupo($query[$i]['ds_grupo']);

            }
        }
        return $grupo;
    }
    
    public function listar_permissoes($pk){        
        $sql ="";
        $sql.="select modulos_pk, ic_ins, ic_upd, ic_del, ic_cons ";
        $sql.="  from modulos_grupos mg ";
        $sql.=" where grupos_pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_grupo ";
        $sql.="       ,polos_pk";

        $sql.="  from grupos ";
        if($pk!=""){
            $sql.=" where pk = $pk ";
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_grupos_permissa($ds_grupo,$polos_pk,$token){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_grupo ";

        $sql.="  from grupos ";
        $sql.=" where 1=1 ";
        if($ds_grupo != ""){
            $sql.=" and ds_grupo like '%".$ds_grupo."%' ";
        }
        if($polos_pk != ""){
            $sql.=" and polos_pk=".$polos_pk;
        }
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and pk not in (1)";
        }
        
        if(!permissao("grupo_listar_todos", "cons", $token)){
            $sql.=" and pk =".$this->arrToken['grupos_pk'];
        }
        
        $sql.=" order by ds_grupo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_ds_grupo($ds_grupo,$polos_pk){
    
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_grupo ";

        $sql.="  from grupos ";
        $sql.=" where 1=1 ";
        if($ds_grupo != ""){
            $sql.=" and ds_grupo like '%".$ds_grupo."%' ";
        }
        if($polos_pk != ""){
            $sql.=" and polos_pk=".$polos_pk;
        }
        
        $sql.=" order by ds_grupo asc ";
   
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_grupos_cad_usuario($ds_grupo,$polos_pk,$token){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_grupo ";

        $sql.="  from grupos ";
        $sql.=" where 1=1 ";
        if($ds_grupo != ""){
            $sql.=" and ds_grupo like '%".$ds_grupo."%' ";
        }
        if($polos_pk != ""){
            $sql.=" and polos_pk=".$polos_pk;
        }
        
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and pk not in (1)";
        }
        
        $sql.=" order by ds_grupo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }    

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_grupo ";
        $sql.="  from grupos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_grupo asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    function excluirGruposModulosPk($grupos_pk){
        $this->db->execDelete("modulos_grupos", " grupos_pk = " . $grupos_pk);
    }
    
    public function adicionarGruposModulos($grupo_pk, $modulos_pk, $ic_ins, $ic_upd, $ic_del, $ic_cons){
        
        $fields = array();
        $fields['grupos_pk'] = $grupo_pk;
        $fields['modulos_pk'] = $modulos_pk;
        $fields['ic_ins'] = $ic_ins;
        $fields['ic_upd'] = $ic_upd;
        $fields['ic_del'] = $ic_del;
        $fields['ic_cons'] = $ic_cons;
        
        $this->db->execInsert("modulos_grupos", $fields);
        
    }
}

?>
