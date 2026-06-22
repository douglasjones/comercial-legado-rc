<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/cargo.class.php';


class cargodao{

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
    
    public function salvar($cargo){

        $fields = array();
        $fields['ds_cargo'] = $cargo->getds_cargo();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($cargo->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("cargos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("cargos", $fields, " pk = ".$cargo->getpk());
        }

    }

    public function excluir($cargo){
        $this->db->execDelete("cargos"," pk = ".$cargo->getpk());
    }

    public function carregarPorPk($pk){

        $cargo = new cargo();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_cargo ";


        $sql.="  from cargos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $cargo->setpk($query[$i]["pk"]);
                $cargo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $cargo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $cargo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $cargo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $cargo->setds_cargo($query[$i]['ds_cargo']);

            }
        }
        return $cargo;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_cargo ";

        $sql.="  from cargos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_cargo($ds_cargo){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_cargo ";

        $sql.="  from cargos ";
        $sql.=" where 1=1 ";
        if($ds_cargo != ""){
            $sql.=" and ds_cargo like '%".$ds_cargo."%' ";
        }
        $sql.=" order by ds_cargo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_descricao_cargo($ds_cargo){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_cargo ";

        $sql.="  from cargos ";
        $sql.=" where 1=1 ";
        if($ds_cargo != ""){
            $sql.=" and ds_cargo ='".$ds_cargo."' ";
        }
        $sql.=" order by ds_cargo asc ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_cargo ";

        $sql.="  from cargos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_cargo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
