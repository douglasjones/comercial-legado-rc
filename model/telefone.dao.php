<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/telefone.class.php';


class telefonedao{

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
    
    public function salvar($telefone){

        $fields = array();
        $fields['tipo_telefone_pk'] = $telefone->gettipo_telefone_pk();
        $fields['ds_ddd'] = substr($telefone->getds_tel(), 1, 2);   
        $fields['ds_tel'] = trim(substr($telefone->getds_tel(), 4, 14));
        $fields['ic_status'] = $telefone->getic_status();
        $fields['leads_pk'] = $telefone->getleads_pk();
        $fields['polos_pk'] = $telefone->getpolos_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        if($telefone->getdt_naoperturbe()==""){
            $fields['dt_naoperturbe'] = null;
        }
        else{
            $fields['dt_naoperturbe'] = DataYMD($telefone->getdt_naoperturbe());
        }
        
        $fields['ds_naoperturbe'] = $telefone->getds_naoperturbe();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($telefone->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("telefones", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("telefones", $fields, " pk = ".$telefone->getpk());
        }

    }

    public function excluir($telefone){
        $this->db->execDelete("telefones"," pk = ".$telefone->getpk());
    }
    public function excluirPorLead($leads_pk){
        $this->db->execDelete("telefones"," leads_pk = ".$leads_pk);
    }

    public function carregarPorPk($pk){

        $telefone = new telefone();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_telefone_pk ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ic_status ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";


        $sql.="  from telefones ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $telefone->setpk($query[$i]["pk"]);
                $telefone->setdt_cadastro($query[$i]["dt_cadastro"]);
                $telefone->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $telefone->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $telefone->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $telefone->settipo_telefone_pk($query[$i]['tipo_telefone_pk']);
                $telefone->setds_tel($query[$i]['ds_tel']);
                $telefone->setds_ddd($query[$i]['ds_ddd']);
                $telefone->setic_status($query[$i]['ic_status']);
                $telefone->setleads_pk($query[$i]['leads_pk']);
                $telefone->setcontas_pk($query[$i]['contas_pk']);
                $telefone->setpolos_pk($query[$i]['polos_pk']);

            }
        }
        return $telefone;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_telefone_pk ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ic_status ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from telefones ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorLeadPk($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_telefone_pk ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ic_status ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,ds_naoperturbe";
        $sql.="       ,dt_naoperturbe";
        $sql.="       ,case tipo_telefone_pk when 1 then 'Fixo' when 2 then 'Celular' when 3 then 'WhatsApp' end ds_tipo_telefone";
        $sql.="       ,concat('(',ds_ddd,') ',ds_tel)ds_ddd_tel";

        $sql.="  from telefones ";
        $sql.=" where leads_pk = $leads_pk ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_tipo_telefone_pk($tipo_telefone_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_telefone_pk ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ic_status ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from telefones ";
        $sql.=" where 1=1 ";
        if($tipo_telefone_pk != ""){
            $sql.=" and ds_telefone like '%".$tipo_telefone_pk."%' ";
        }
        $sql.=" order by tipo_telefone_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_telefone_pk ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ic_status ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from telefones ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_telefone_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function updateNaoPerturbe($ds_naoperturbe,$dt_naoperturbe,$pk){
        $fields = array();
        $fields['ds_naoperturbe'] = $ds_naoperturbe;
        $fields['dt_naoperturbe'] = $dt_naoperturbe;
        
        $this->db->execUpdate("telefones", $fields, " pk = ".$pk);
    }

}

?>
