<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/etapa_contrato.class.php';


class etapa_contratodao{

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
    
    public function salvar($etapa_contrato){

        $fields = array();
        $fields['ds_etapa'] = $etapa_contrato->getds_etapa();
        $fields['operador_pk'] = $etapa_contrato->getoperador_pk();
        $fields['ic_status'] = $etapa_contrato->getic_status();
        $fields['polos_pk'] = $etapa_contrato->getpolos_pk();

        $fields['n_ordem'] = $etapa_contrato->getn_ordem();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($etapa_contrato->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("etapas_contratos", $fields);
            //$this->db->execInsert("etapas_contratos", $fields);
            //echo $this->db->getLastSQL();
            //exit;    
            return $pk;
        }
        else{
            return $this->db->execUpdate("etapas_contratos", $fields, " pk = ".$etapa_contrato->getpk());
            //$this->db->execUpdate("etapas_contratos", $fields, " pk = ".$etapa_contrato->getpk());
            //echo $this->db->getLastSQL();
            //exit;  
            
        }

    }

    public function excluir($etapa_contrato){
        $this->db->execDelete("etapas_contratos"," pk = ".$etapa_contrato->getpk());
    }

    public function carregarPorPk($pk){

        $etapa_contrato = new etapa_contrato();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_etapa ";
        $sql.="       ,operador_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,polos_pk ";

        $sql.="       ,n_ordem ";


        $sql.="  from etapas_contratos ";
        $sql.=" where pk = $pk ";

            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $etapa_contrato->setpk($query[$i]["pk"]);
                $etapa_contrato->setdt_cadastro($query[$i]["dt_cadastro"]);
                $etapa_contrato->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $etapa_contrato->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $etapa_contrato->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $etapa_contrato->setds_etapa($query[$i]['ds_etapa']);
                $etapa_contrato->setoperador_pk($query[$i]['operador_pk']);
                $etapa_contrato->setic_status($query[$i]['ic_status']);
                $etapa_contrato->setpolos_pk($query[$i]['polos_pk']);
                $etapa_contrato->setn_ordem($query[$i]['n_ordem']);
            }
        }
        return $etapa_contrato;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,operador_pk ";
        $sql.="       ,ds_etapa";
        $sql.="       ,ic_status ";
        $sql.="       ,polos_pk ";
        //$sql.="       ,operadores_pk ";
        $sql.="       ,n_ordem ";

        $sql.="  from etapas_contratos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorPk80(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,operador_pk ";
        $sql.="       ,ds_etapa";
        $sql.="       ,ic_status ";
        $sql.="       ,polos_pk ";
        //$sql.="       ,operadores_pk ";
        $sql.="       ,n_ordem ";

        $sql.="  from etapas_contratos ";
        $sql.=" where ds_etapa like '%80%'";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorPk90(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,operador_pk ";
        $sql.="       ,ds_etapa";
        $sql.="       ,ic_status ";
        $sql.="       ,polos_pk ";
        //$sql.="       ,operadores_pk ";
        $sql.="       ,n_ordem ";

        $sql.="  from etapas_contratos ";
        $sql.=" where ds_etapa like '%90%'";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorPkCliente(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,operador_pk ";
        $sql.="       ,ds_etapa";
        $sql.="       ,ic_status ";
        $sql.="       ,polos_pk ";
        //$sql.="       ,operadores_pk ";
        $sql.="       ,n_ordem ";

        $sql.="  from etapas_contratos ";
        $sql.=" where ds_etapa like '%Cliente%'";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_etapa($ds_etapa){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_etapa ";
        $sql.="       ,operador_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operadores_pk ";
        $sql.="       ,n_ordem ";

        $sql.="  from etapas_contratos ";
        $sql.=" where 1=1 ";
        if($ds_etapa != ""){
            $sql.=" and ds_etapa_contrato like '%".$ds_etapa."%' ";
        }
        $sql.=" order by ds_etapa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarPorPolo($polos_pk){

        $sql ="";
        $sql.="select ec.pk, ec.dt_cadastro, ec.usuario_cadastro_pk, ec.dt_ult_atualizacao, ec.usuario_ult_atualizacao_pk ";
        $sql.="       ,ec.ds_etapa ";
        $sql.="       ,ec.operador_pk ";
        $sql.="       ,ec.ic_status ";
        $sql.="       ,CASE ec.ic_status WHEN 1 THEN 'Ativo' WHEN 2 THEN 'Inativo' END ds_status"; 
        $sql.="       ,ec.polos_pk ";
        $sql.="       ,o.ds_operador ";
        $sql.="       ,ec.n_ordem ";
        $sql.="       ,s.ds_segmento ";
        $sql.="       ,o.segmentos_pk ";
        $sql.="  from etapas_contratos ec ";
        $sql.="  inner join operadores o on ec.operador_pk = o.pk ";   
        $sql.="  inner join segmentos s on o.segmentos_pk = s.pk";
        $sql.=" where 1=1 ";
        if($polos_pk != ""){
            $sql.=" and ec.polos_pk = ".$polos_pk;
        }
        else{
             $sql.=" and ec.polos_pk = 0";
        }
        $sql.=" order by ec.ds_etapa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }    

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_etapa ";
        $sql.="       ,operador_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operadores_pk ";
        $sql.="       ,n_ordem ";

        $sql.="  from etapas_contratos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_etapa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
