<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/documento.class.php';


class documentodao{

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
    
    public function salvar($documento){

        $fields = array();
        $fields['ds_documento'] = $documento->getds_documento();
        $fields['ds_obs'] = $documento->getds_obs();
        $fields['ds_nome_original'] = $documento->getds_nome_original();
        $fields['leads_pk'] = $documento->getleads_pk();
        $fields['contratos_pk'] = $documento->getcontratos_pk();
        $fields['ocorrencias_pk'] = $documento->getocorrencias_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($documento->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("documentos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("documentos", $fields, " pk = ".$documento->getpk());
        }

    }

    public function excluir($documento){
        $this->db->execDelete("documentos"," pk = ".$documento->getpk());
    }
    

    public function carregarPorPk($pk){

        $documento = new documento();
        if($pk != ""){
            $pk = (int)$pk;
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";


        $sql.="  from documentos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $documento->setpk($query[$i]["pk"]);
                $documento->setdt_cadastro($query[$i]["dt_cadastro"]);
                $documento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $documento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $documento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $documento->setds_documento($query[$i]['ds_documento']);
                $documento->setds_obs($query[$i]['ds_obs']);
                $documento->setds_nome_original($query[$i]['ds_nome_original']);
                $documento->setleads_pk($query[$i]['leads_pk']);
                $documento->setcontratos_pk($query[$i]['contratos_pk']);
                $documento->setocorrencias_pk($query[$i]['ocorrencias_pk']);

            }
        }
        return $documento;
    }

    public function listarPorPk($pk){
        $pk = (int)$pk;

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";

        $sql.="  from documentos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_documento($ds_documento){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="  from documentos ";
        $sql.=" where 1=1 ";
        $types = "";
        $params = array();
        if($ds_documento != ""){
            $sql.=" and ds_documento like ? ";
            $types .= "s";
            $params[] = "%".$ds_documento."%";
        }
        $sql.=" order by ds_documento asc ";
        if($types === ""){
            return $this->db->execQuery($sql);
        }
        return $this->db->execPreparedQuery($sql, $types, $params);

    }
    public function listar_documetos_lead($leads_pk){

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.="       ,d.ds_documento ";
        $sql.="       ,d.ds_obs ";
        $sql.="       ,d.ds_nome_original ";
        $sql.="       ,d.leads_pk ";
        $sql.="       ,d.contratos_pk ";
        $sql.="       ,d.ocorrencias_pk ";

        $sql.="  from documentos d";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and d.leads_pk =".((int)$leads_pk);
        }
        $sql.=" order by d.ds_documento asc ";
        $query = $this->db->execQuery($sql);
        return $query;
    }
        

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";

        $sql.="  from documentos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_documento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQuantidadeDocumentosLead($leads_pk){
        $sql = "select count(*) total from documentos where leads_pk = ?";
        return $this->db->execPreparedQuery($sql, "i", array((int)$leads_pk));

    }   
}

?>
