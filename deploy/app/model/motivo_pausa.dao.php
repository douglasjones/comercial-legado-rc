<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/motivo_pausa.class.php';


class motivo_pausadao{

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
    
    public function salvar($motivo_pausa){

        $fields = array();
        $fields['ds_motivo_pausa'] = $motivo_pausa->getds_motivo_pausa();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($motivo_pausa->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("motivos_pausas", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("motivos_pausas", $fields, " pk = ".$motivo_pausa->getpk());
        }

    }

    public function excluir($motivo_pausa){
        $this->db->execDelete("motivos_pausas"," pk = ".$motivo_pausa->getpk());
    }

    public function carregarPorPk($pk){

        $motivo_pausa = new motivo_pausa();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_motivo_pausa ";


        $sql.="  from motivos_pausas ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $motivo_pausa->setpk($query[$i]["pk"]);
                $motivo_pausa->setdt_cadastro($query[$i]["dt_cadastro"]);
                $motivo_pausa->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $motivo_pausa->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $motivo_pausa->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $motivo_pausa->setds_motivo_pausa($query[$i]['ds_motivo_pausa']);

            }
        }
        return $motivo_pausa;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_motivo_pausa ";

        $sql.="  from motivos_pausas ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_motivo_pausa($ds_motivo_pausa){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_motivo_pausa ";

        $sql.="  from motivos_pausas ";
        $sql.=" where 1=1 ";
        if($ds_motivo_pausa != ""){
            $sql.=" and ds_motivo_pausa like '%".$ds_motivo_pausa."%' ";
        }
        $sql.=" order by ds_motivo_pausa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_motivo_pausa ";

        $sql.="  from motivos_pausas ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_motivo_pausa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
