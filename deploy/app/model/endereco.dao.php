<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/endereco.class.php';


class enderecodao{

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
    
    public function salvar($endereco){

        $fields = array();
        $fields['tipo_endereco_pk'] = $endereco->gettipo_endereco_pk();
        $fields['ds_cep'] = $endereco->getds_cep();
        $fields['ds_endereco'] = $endereco->getds_endereco();
        $fields['ds_numero'] = $endereco->getds_numero();
        $fields['ds_complemento'] = $endereco->getds_complemento();
        $fields['ds_bairro'] = $endereco->getds_bairro();
        $fields['ds_cidade'] = $endereco->getds_cidade();
        $fields['ds_uf'] = $endereco->getds_uf();
        $fields['leads_pk'] = $endereco->getleads_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['polos_pk'] = $endereco->getpolos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($endereco->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("enderecos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("enderecos", $fields, " pk = ".$endereco->getpk());
        }

    }

    public function excluir($endereco){
        $this->db->execDelete("enderecos"," pk = ".$endereco->getpk());
    }
    public function excluirPorLead($leads_pk){
        $this->db->execDelete("enderecos"," leads_pk = ".$leads_pk);
    }
    
    public function carregarPorPk($pk){

        $endereco = new endereco();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_endereco_pk ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";


        $sql.="  from enderecos ";
        $sql.=" where pk = $pk ";
      
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $endereco->setpk($query[$i]["pk"]);
                $endereco->setdt_cadastro($query[$i]["dt_cadastro"]);
                $endereco->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $endereco->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $endereco->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $endereco->settipo_endereco_pk($query[$i]['tipo_endereco_pk']);
                $endereco->setds_cep($query[$i]['ds_cep']);
                $endereco->setds_endereco($query[$i]['ds_endereco']);
                $endereco->setds_numero($query[$i]['ds_numero']);
                $endereco->setds_complemento($query[$i]['ds_complemento']);
                $endereco->setds_bairro($query[$i]['ds_bairro']);
                $endereco->setds_cidade($query[$i]['ds_cidade']);
                $endereco->setds_uf($query[$i]['ds_uf']);
                $endereco->setleads_pk($query[$i]['leads_pk']);
                $endereco->setcontas_pk($query[$i]['contas_pk']);
                $endereco->setpolos_pk($query[$i]['polos_pk']);

            }
        }
        return $endereco;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_endereco_pk ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from enderecos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarCidade(){

        $sql ="";
        $sql.="select ds_cidade ";
        $sql.="  from enderecos ";
        $sql.=" group by ds_cidade";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorLeadPk($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_endereco_pk ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,case tipo_endereco_pk when 1 then 'Matriz' when 2 then 'Filial' when 3 then 'Cobrança' when 4 then 'Entrega' end ds_tipo_entrega ";

        $sql.="  from enderecos ";
        $sql.=" where leads_pk = $leads_pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_tipo_endereco_pk($tipo_endereco_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_endereco_pk ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from enderecos ";
        $sql.=" where 1=1 ";
        if($tipo_endereco_pk != ""){
            $sql.=" and ds_endereco like '%".$tipo_endereco_pk."%' ";
        }
        $sql.=" order by tipo_endereco_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_endereco_pk ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from enderecos ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_endereco_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
