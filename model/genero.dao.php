<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/genero.class.php';


class generodao{

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
    
    public function salvar($genero){

        $fields = array();
        $fields['ds_genero'] = $genero->getds_genero();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($genero->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("generos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("generos", $fields, " pk = ".$genero->getpk());
        }

    }

    public function excluir($genero){
        $this->db->execDelete("generos"," pk = ".$genero->getpk());
    }

    public function carregarPorPk($pk){

        $genero = new genero();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_genero ";


        $sql.="  from generos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $genero->setpk($query[$i]["pk"]);
                $genero->setdt_cadastro($query[$i]["dt_cadastro"]);
                $genero->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $genero->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $genero->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $genero->setds_genero($query[$i]['ds_genero']);

            }
        }
        return $genero;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_genero ";

        $sql.="  from generos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_genero($ds_genero){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_genero ";

        $sql.="  from generos ";
        $sql.=" where 1=1 ";
        if($ds_genero != ""){
            $sql.=" and ds_genero like '%".$ds_genero."%' ";
        }
        $sql.=" order by ds_genero asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_genero ";

        $sql.="  from generos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_genero asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
