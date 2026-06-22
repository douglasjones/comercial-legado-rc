<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/conta.class.php';

class contadao {

    private $db;
    private $arrToken;

    public function __construct() {

        $this->db = new DataBase();
        $this->db->conectar();
    }

    public function __destruct() {
        $this->db->desconectar();
    }

    public function setToken($v_token) {
        $this->arrToken = tratarToken($v_token);
    }

    public function salvar($conta) {
    
        $fields = array();
        $fields['ds_tipo_pessoa'] = $conta->getds_tipo_pessoa();
        $fields['ds_conta'] = $conta->getds_conta();
        $fields['ds_razao_social'] = $conta->getds_razao_social();
        $fields['ds_cpf_cnpj'] = $conta->getds_cpf_cnpj();
        $fields['ds_cnae'] = $conta->getds_cnae();
        $fields['ds_rg'] = $conta->getds_rg();
        //$fields['ds_ddd'] = $conta->getds_ddd();
        $fields['ds_tel'] = $conta->getds_tel();
        //$fields['ds_ddd_cel'] = $conta->getds_ddd_cel();
        $fields['ds_email'] = $conta->getds_email();
        $fields['ds_cel'] = $conta->getds_cel();
        $fields['ds_cep'] = $conta->getds_cep();
        $fields['ds_endereco'] = $conta->getds_endereco();
        $fields['ds_numero'] = $conta->getds_numero();
        $fields['ds_complemento'] = $conta->getds_complemento();
        $fields['ds_bairro'] = $conta->getds_bairro();
        $fields['ds_cidade'] = $conta->getds_cidade();
        $fields['ds_uf'] = $conta->getds_uf();
        //$fields['segmentos_pk'] = $conta->getsegmentos_pk();
        if(!empty($conta->getdt_ativacao())){
            $fields['dt_ativacao'] = DataYMD($conta->getdt_ativacao());
        }
        if(!empty($conta->getdt_cancelamento())){
            $fields['dt_cancelamento'] = DataYMD($conta->getdt_cancelamento());
        }
        $fields['ic_status'] = $conta->getic_status();
        


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if ($conta->getpk() == "") {

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"] = $this->arrToken['usuarios_pk'];
                     
            $pk = $this->db->execInsert("contas", $fields);
            return $pk;
        } else {      
            //$this->db->execUpdate("contas", $fields, " pk = " . $conta->getpk());
            //echo $this->db->getLastSQL();
            //exit;
            return $this->db->execUpdate("contas", $fields, " pk = " . $conta->getpk());
        }
    }

    public function excluir($conta) {
        $this->db->execDelete("contas", " pk = " . $conta->getpk());
    }

    public function carregarPorPk($pk) {

        $conta = new conta();
        if ($pk != "") {

            $sql = "select pk ";
            $sql .= "      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
            $sql .= "      , usuario_cadastro_pk ";
            $sql .= "      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
            $sql .= "      , usuario_ult_atualizacao_pk ";

            $sql .= "       ,ds_tipo_pessoa ";
            $sql .= "       ,ds_conta ";
            $sql .= "       ,ds_razao_social ";
            $sql .= "       ,ds_cpf_cnpj ";
            $sql .= "       ,ds_cnae ";
            $sql .= "       ,ds_rg ";
            $sql .= "       ,ds_tel ";
            $sql .= "       ,ds_email ";
            $sql .= "       ,ds_cel ";
            $sql .= "       ,ds_cep ";
            $sql .= "       ,ds_endereco ";
            $sql .= "       ,ds_numero ";
            $sql .= "       ,ds_complemento ";
            $sql .= "       ,ds_bairro ";
            $sql .= "       ,ds_cidade ";
            $sql .= "      , date_format(dt_ativacao,'%d/%m/%Y') dt_ativacao ";
            $sql .= "      , date_format(dt_cancelamento,'%d/%m/%Y') dt_cancelamento ";            
            $sql .= "       ,ic_status ";

            $sql .= "  from contas ";
            $sql .= " where pk = $pk ";
      
            $query = $this->db->execQuery($sql);
            for ($i = 0; $i < count($query); $i++) {
                $conta->setpk($query[$i]["pk"]);
                $conta->setdt_cadastro($query[$i]["dt_cadastro"]);
                $conta->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $conta->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $conta->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $conta->setds_tipo_pessoa($query[$i]['ds_tipo_pessoa']);
                $conta->setds_conta($query[$i]['ds_conta']);
                $conta->setds_razao_social($query[$i]['ds_razao_social']);
                $conta->setds_cpf_cnpj($query[$i]['ds_cpf_cnpj']);
                $conta->setds_cnae($query[$i]['ds_cnae']);
                $conta->setds_rg($query[$i]['ds_rg']);
                $conta->setds_ddd($query[$i]['ds_ddd']);
                $conta->setds_tel($query[$i]['ds_tel']);
                $conta->setds_ddd_cel($query[$i]['ds_ddd_cel']);
                $conta->setds_email($query[$i]['ds_email']);
                $conta->setds_cel($query[$i]['ds_cel']);
                $conta->setds_cep($query[$i]['ds_cep']);
                $conta->setds_endereco($query[$i]['ds_endereco']);
                $conta->setds_numero($query[$i]['ds_numero']);
                $conta->setds_complemento($query[$i]['ds_complemento']);
                $conta->setds_bairro($query[$i]['ds_bairro']);
                $conta->setds_cidade($query[$i]['ds_cidade']);
                $conta->setsegmentos_pk($query[$i]['segmentos_pk']);
                $conta->setdt_ativacao($query[$i]['dt_ativacao']);
                $conta->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $conta->setic_status($query[$i]['ic_status']);
            }
        }
        return $conta;
    }

    public function listarPorPk($pk) {

        $sql = "";
        $sql .= "select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql .= "       ,ds_tipo_pessoa ";
        $sql .= "       ,ds_conta ";
        $sql .= "       ,ds_razao_social ";
        $sql .= "       ,ds_cpf_cnpj ";
        $sql .= "       ,ds_cnae ";
        $sql .= "       ,ds_rg ";
        $sql .= "       ,ds_tel ";
        $sql .= "       ,ds_email ";
        $sql .= "       ,ds_cel ";
        $sql .= "       ,ds_cep ";
        $sql .= "       ,ds_endereco ";
        $sql .= "       ,ds_numero ";
        $sql .= "       ,ds_complemento ";
        $sql .= "       ,ds_bairro ";
        $sql .= "       ,ds_cidade ";
        $sql .= "       ,ds_uf ";
        $sql .= "      , date_format(dt_ativacao,'%d/%m/%Y') dt_ativacao ";
        $sql .= "      , date_format(dt_cancelamento,'%d/%m/%Y') dt_cancelamento "; 
        $sql .= "       ,ic_status ";
        $sql .= "  from contas ";
        $sql .= " where pk = $pk ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function verificarConta() {

        $sql = "";
        $sql .= "select pk,ic_status,ds_conta ";
        $sql .= "  from contas ";
        $sql .= " where pk =". $this->arrToken['contas_pk'];
        

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function desativarPolo($contas_pk) {
        $fields = array();
        $fields['ic_status'] = 2 ;
        
        $this->db->execUpdate("polos", $fields, " contas_pk = " . $contas_pk);
    }
    public function desativarUsuarios($contas_pk) {
        $fields = array();
        $fields['ic_status'] = 2 ;
        
        $this->db->execUpdate("usuarios", $fields, " contas_pk = " . $contas_pk);
    }
    
    public function listar_contas_usuarios($pk,$token) {
                        
        $sql = "";
        $sql .= "select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql .= "       ,ds_tipo_pessoa ";
        $sql .= "       ,ds_conta ";
        $sql .= "       ,ds_razao_social ";
        $sql .= "       ,ds_cpf_cnpj ";
        $sql .= "       ,ds_cnae ";
        $sql .= "       ,ds_rg ";
        $sql .= "       ,ds_tel ";
        $sql .= "       ,ds_email ";
        $sql .= "       ,ds_cel ";
        $sql .= "       ,ds_cep ";
        $sql .= "       ,ds_endereco ";
        $sql .= "       ,ds_numero ";
        $sql .= "       ,ds_complemento ";
        $sql .= "       ,ds_bairro ";
        $sql .= "       ,ds_cidade ";
        $sql .= "       ,ds_uf ";
        $sql .= "      , date_format(dt_ativacao,'%d/%m/%Y') dt_ativacao ";
        $sql .= "      , date_format(dt_cancelamento,'%d/%m/%Y') dt_cancelamento "; 
        $sql .= "       ,ic_status ";
        $sql .= "  from contas ";
        $sql .= " where 1=1";
        if(!permissao("contas_todas", "cons", $token)){
            $sql .= " and pk=".$this->arrToken['contas_pk'];
        }

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listar_por_pesquisa_grid($ds_tipo_pessoa,$ds_conta,$ds_cpf_cnpj,$ic_status) {

        $sql = "";
        $sql .= "select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql .= "       ,CASE ds_tipo_pessoa WHEN 1 THEN 'PF' WHEN 2 THEN 'PJ' END ds_tipo_pessoa";        
        $sql .= "       ,ds_conta ";
        $sql .= "       ,ds_razao_social ";
        $sql .= "       ,ds_cpf_cnpj ";
        $sql .= "       ,ds_cnae ";
        $sql .= "       ,ds_rg ";
        $sql .= "       ,ds_tel ";
        $sql .= "       ,ds_email ";
        $sql .= "       ,ds_cel ";
        $sql .= "       ,ds_cep ";
        $sql .= "       ,ds_endereco ";
        $sql .= "       ,ds_numero ";
        $sql .= "       ,ds_complemento ";
        $sql .= "       ,ds_bairro ";
        $sql .= "       ,ds_cidade ";
        $sql .= "       ,date_format(dt_ativacao,'%d/%m/%Y')dt_ativacao";
        $sql .= "       ,dt_cancelamento ";
        $sql .= "       ,CASE ic_status WHEN 1 THEN 'Ativo' WHEN 2 THEN 'Inativo' END ic_status"; 

        $sql .= "  from contas ";
        $sql .= " where 1=1 ";
        if ($ds_tipo_pessoa != "") {
            $sql .= " and ds_tipo_pessoa =" . $ds_tipo_pessoa ;
        }
        
        if ($ds_conta != "") {
            $sql .= " and ds_conta like '%" . $ds_conta."%'"; ;
        }
        
        if ($ds_razao_social != "") {
            $sql .= " and ds_razao_social like '%" . $ds_razao_social."%'"; 
        }
        
        if ($ds_cpf_cnpj != "") {
            $sql .= " and ds_cpf_cnpj = '" . $ds_cpf_cnpj."'"; 
        }
        
        if ($ic_status != "") {
            $sql .= " and ic_status = " . $ic_status; 
        }        
        
        $sql .= " order by ds_tipo_pessoa asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarTodos() {

        $sql = "";
        $sql .= "select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql .= "       ,ds_tipo_pessoa ";
        $sql .= "       ,ds_conta ";
        $sql .= "       ,ds_razao_social ";
        $sql .= "       ,ds_cpf_cnpj ";
        $sql .= "       ,ds_cnae ";
        $sql .= "       ,ds_rg ";
        $sql .= "       ,ds_ddd ";
        $sql .= "       ,ds_tel ";
        $sql .= "       ,ds_ddd_cel ";
        $sql .= "       ,ds_email ";
        $sql .= "       ,ds_cel ";
        $sql .= "       ,ds_cep ";
        $sql .= "       ,ds_endereco ";
        $sql .= "       ,ds_numero ";
        $sql .= "       ,ds_complemento ";
        $sql .= "       ,ds_bairro ";
        $sql .= "       ,ds_cidade ";
        $sql .= "       ,segmentos_pk ";
        $sql .= "       ,dt_ativacao ";
        $sql .= "       ,dt_cancelamento ";
        $sql .= "       ,ic_status ";

        $sql .= "  from contas ";
        $sql .= " where 1=1 ";
        $sql .= " order by ds_tipo_pessoa asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }

}

?>
