<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/modulo.class.php';


class modulodao{

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
    
    
    public function salvar($modulo){

        $fields = array();
        $fields['ds_modulo'] = $modulo->getds_modulo();
        $fields['ds_dominio'] = $modulo->getds_dominio();
        $fields['polos_pk'] = $modulo->getpolos_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($modulo->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("modulos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("modulos", $fields, " pk = ".$modulo->getpk());
        }

    }

    public function excluir($modulo){
        $this->db->execDelete("modulos"," pk = ".$modulo->getpk());
    }

    public function carregarPorPk($pk){

        $modulo = new modulo();
        if($pk != ""){
            $sql ="select pk ";
            $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
            $sql.="      , usuario_cadastro_pk ";
            $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
            $sql.="      , usuario_ult_atualizacao_pk ";
            $sql.="       ,ds_modulo ";
            $sql.="       ,ds_dominio ";
            $sql.="  from modulos ";
            $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $modulo->setpk($query[$i]["pk"]);
                $modulo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $modulo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $modulo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $modulo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
                $modulo->setds_modulo($query[$i]['ds_modulo']);
                $modulo->setds_dominio($query[$i]['ds_dominio']);

            }
        }
        return $modulo;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,ds_dominio ";
        $sql.="       ,polos_pk ";
        $sql.="  from modulos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_modulo($ds_modulo,$polos_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,ds_dominio ";
        $sql.="  from modulos ";
        $sql.=" where 1=1 ";
        if($ds_modulo != ""){
            $sql.=" and ds_modulo like '%".$ds_modulo."%' ";
        }
        if($polos_pk != ""){
            $sql.=" and polos_pk = ".$polos_pk;
        }
        $sql.=" order by ds_modulo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_modulo ";
        $sql.="       ,ds_dominio ";
        $sql.="  from modulos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_modulo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
