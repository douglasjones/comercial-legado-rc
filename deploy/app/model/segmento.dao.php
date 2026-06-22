<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/segmento.class.php';


class segmentodao{

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
    
    public function salvar($segmento){

        $fields = array();
        $fields['ds_segmento'] = $segmento->getds_segmento();
        $fields['ic_status'] = $segmento->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($segmento->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("segmentos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("segmentos", $fields, " pk = ".$segmento->getpk());
        }

    }

    public function excluir($segmento){
        $this->db->execDelete("segmentos"," pk = ".$segmento->getpk());
    }

    public function carregarPorPk($pk){

        $segmento = new segmento();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_segmento ";
        $sql.="       ,ic_status ";


        $sql.="  from segmentos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $segmento->setpk($query[$i]["pk"]);
                $segmento->setdt_cadastro($query[$i]["dt_cadastro"]);
                $segmento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $segmento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $segmento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $segmento->setds_segmento($query[$i]['ds_segmento']);
                $segmento->setic_status($query[$i]['ic_status']);

            }
        }
        return $segmento;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_segmento ";
        $sql.="       ,ic_status ";

        $sql.="  from segmentos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_segmento($ds_segmento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_segmento ";
        $sql.="       ,ic_status ";
        $sql.="  from segmentos ";
        $sql.=" where 1=1 ";
        if($ds_segmento != ""){
            $sql.=" and ds_segmento like '%".$ds_segmento."%' ";
        }
        $sql.=" order by ds_segmento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_segmento ";
        $sql.="       ,ic_status ";

        $sql.="  from segmentos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_segmento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
