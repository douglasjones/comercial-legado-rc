<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/plano.class.php';


class planodao{

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
    
    public function salvar($plano){

        $fields = array();
        $fields['ds_plano'] = $plano->getds_plano();
        $fields['vl_plano'] = $plano->getvl_plano();
        $fields['segmentos_pk'] = $plano->getsegmentos_pk();
        $fields['ic_status'] = $plano->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($plano->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("planos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("planos", $fields, " pk = ".$plano->getpk());
        }

    }

    public function excluir($plano){
        $this->db->execDelete("planos"," pk = ".$plano->getpk());
    }

    public function carregarPorPk($pk){

        $plano = new plano();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_plano ";
        $sql.="       ,vl_plano ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,ic_status ";


        $sql.="  from planos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $plano->setpk($query[$i]["pk"]);
                $plano->setdt_cadastro($query[$i]["dt_cadastro"]);
                $plano->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $plano->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $plano->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $plano->setds_plano($query[$i]['ds_plano']);
                $plano->setvl_plano($query[$i]['vl_plano']);
                $plano->setsegmentos_pk($query[$i]['segmentos_pk']);
                $plano->setic_status($query[$i]['ic_status']);

            }
        }
        return $plano;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_plano ";
        $sql.="       ,vl_plano ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from planos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_plano($ds_plano){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_plano ";
        $sql.="       ,vl_plano ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from planos ";
        $sql.=" where 1=1 ";
        if($ds_plano != ""){
            $sql.=" and ds_plano like '%".$ds_plano."%' ";
        }
        $sql.=" order by ds_plano asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,CONCAT(ds_plano,' - R$',  vl_plano) ds_plano ";
        $sql.="       ,vl_plano ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from planos ";
        $sql.=" where 1=1 ";
        $sql.=" and ic_status=1 ";
        $sql.=" order by ds_plano asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
