<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/mailing.class.php';


class mailingdao{

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
    
    public function salvar($mailing){

        $fields = array();
        $fields['ds_mailing'] = $mailing->getds_mailing();
        $fields['ic_status'] = $mailing->getic_status();
        $fields['contas_pk'] =  $this->arrToken['contas_pk'];
        $fields['polos_pk'] = $mailing->getpolos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($mailing->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("mailing", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("mailing", $fields, " pk = ".$mailing->getpk());
        }

    }

    public function excluir($mailing){
        $this->db->execDelete("mailing"," pk = ".$mailing->getpk());
    }

    public function carregarPorPk($pk){

        $mailing = new mailing();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_mailing ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";


        $sql.="  from mailing ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $mailing->setpk($query[$i]["pk"]);
                $mailing->setdt_cadastro($query[$i]["dt_cadastro"]);
                $mailing->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $mailing->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $mailing->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $mailing->setds_mailing($query[$i]['ds_mailing']);
                $mailing->setic_status($query[$i]['ic_status']);
                $mailing->setcontas_pk($query[$i]['contas_pk']);
                $mailing->setpolos_pk($query[$i]['polos_pk']);

            }
        }
        return $mailing;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_mailing ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from mailing ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_mailing($ds_mailing = "", $ic_status = "", $polos_pk = ""){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_mailing ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,case ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";
        $sql.="  from mailing ";
        $sql.=" where 1=1 ";
        if($ds_mailing != ""){
            $sql.=" and ds_mailing like '%".$ds_mailing."%' ";
        }
        if($ic_status!=""){
            $sql.=" and ic_status = ".$ic_status;
        }
        if($polos_pk != ""){
            $sql.=" and polos_pk = ".$polos_pk;
        }
        else if($this->arrToken['polos_pk'] != ""){
            $sql.=" and polos_pk = ".$this->arrToken['polos_pk'];
        }
        if($this->arrToken['contas_pk'] != ""){
            $sql.=" and contas_pk = ".$this->arrToken['contas_pk'];
        }
        $sql.=" order by ds_mailing asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_mailing_conta(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_mailing ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,case ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";
        $sql.="  from mailing ";
        $sql.=" where 1=1 ";
        
        $sql.=" and contas_pk = ".$this->arrToken['contas_pk'];
        $sql.=" and polos_pk = ".$this->arrToken['polos_pk'];
        $sql.=" and ic_status=1";
        
        $sql.=" order by ds_mailing asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_mailing ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from mailing ";
        $sql.=" where 1=1 ";
        $sql.=" and contas_pk = ";$this->arrToken['contas_pk'];
        $sql.=" and polos_pk = ";$this->arrToken['polos_pk'];
        $sql.=" and ic_status=1";
        $sql.=" order by ds_mailing asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
