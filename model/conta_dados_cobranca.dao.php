<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/conta_dados_cobranca.class.php';


class conta_dados_cobrancadao{

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
    
    public function salvar($conta_dados_cobranca){

        $fields = array();
        $fields['dia_vencimento'] = $conta_dados_cobranca->getdia_vencimento();
        $fields['n_qtde'] = $conta_dados_cobranca->getn_qtde();
        $fields['vl_unit'] = $conta_dados_cobranca->getvl_unit();
        $fields['vl_total'] = $conta_dados_cobranca->getvl_total();
        $fields['planos_pk'] = $conta_dados_cobranca->getplanos_pk();
        $fields['tipo_pagamentos_pk'] = $conta_dados_cobranca->gettipo_pagamentos_pk();
        $fields['n_cartao'] = $conta_dados_cobranca->getn_cartao();
        $fields['ds_vencimento_cartao'] = $conta_dados_cobranca->getds_vencimento_cartao();
        $fields['ds_nome_cartao'] = $conta_dados_cobranca->getds_nome_cartao();
        $fields['bandeira_cartao_pk'] = $conta_dados_cobranca->getbandeira_cartao_pk();
        $fields['ds_email_financeiro'] = $conta_dados_cobranca->getds_email_financeiro();
        $fields['dt_cancelamento'] = $conta_dados_cobranca->getdt_cancelamento();
        $fields['ic_status'] = $conta_dados_cobranca->getic_status();
        $fields['contas_pk'] = $conta_dados_cobranca->getcontas_pk();
        $fields['planos_pk'] = $conta_dados_cobranca->getplanos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($conta_dados_cobranca->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("contas_dados_cobranca", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("contas_dados_cobranca", $fields, " pk = ".$conta_dados_cobranca->getpk());
        }

    }

    public function excluir($conta_dados_cobranca){
        $this->db->execDelete("contas_dados_cobranca"," pk = ".$conta_dados_cobranca->getpk());
    }

    public function carregarPorPk($pk){

        $conta_dados_cobranca = new conta_dados_cobranca();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,dia_vencimento ";
        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,planos_pk ";
        $sql.="       ,tipo_pagamentos_pk ";
        $sql.="       ,n_cartao ";
        $sql.="       ,ds_vencimento_cartao ";
        $sql.="       ,ds_nome_cartao ";
        $sql.="       ,bandeira_cartao_pk ";
        $sql.="       ,ds_email_financeiro ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,planos_pk ";


        $sql.="  from contas_dados_cobranca ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $conta_dados_cobranca->setpk($query[$i]["pk"]);
                $conta_dados_cobranca->setdt_cadastro($query[$i]["dt_cadastro"]);
                $conta_dados_cobranca->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $conta_dados_cobranca->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $conta_dados_cobranca->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $conta_dados_cobranca->setdia_vencimento($query[$i]['dia_vencimento']);
                $conta_dados_cobranca->setn_qtde($query[$i]['n_qtde']);
                $conta_dados_cobranca->setvl_unit($query[$i]['vl_unit']);
                $conta_dados_cobranca->setvl_total($query[$i]['vl_total']);
                $conta_dados_cobranca->setplanos_pk($query[$i]['planos_pk']);
                $conta_dados_cobranca->settipo_pagamentos_pk($query[$i]['tipo_pagamentos_pk']);
                $conta_dados_cobranca->setn_cartao($query[$i]['n_cartao']);
                $conta_dados_cobranca->setds_vencimento_cartao($query[$i]['ds_vencimento_cartao']);
                $conta_dados_cobranca->setds_nome_cartao($query[$i]['ds_nome_cartao']);
                $conta_dados_cobranca->setbandeira_cartao_pk($query[$i]['bandeira_cartao_pk']);
                $conta_dados_cobranca->setds_email_financeiro($query[$i]['ds_email_financeiro']);
                $conta_dados_cobranca->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $conta_dados_cobranca->setic_status($query[$i]['ic_status']);
                $conta_dados_cobranca->setcontas_pk($query[$i]['contas_pk']);
                $conta_dados_cobranca->setplanos_pk($query[$i]['planos_pk']);

            }
        }
        return $conta_dados_cobranca;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dia_vencimento ";
        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,planos_pk ";
        $sql.="       ,tipo_pagamentos_pk ";
        $sql.="       ,n_cartao ";
        $sql.="       ,ds_vencimento_cartao ";
        $sql.="       ,ds_nome_cartao ";
        $sql.="       ,bandeira_cartao_pk ";
        $sql.="       ,ds_email_financeiro ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,planos_pk ";

        $sql.="  from contas_dados_cobranca ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dia_vencimento($dia_vencimento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dia_vencimento ";
        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,planos_pk ";
        $sql.="       ,tipo_pagamentos_pk ";
        $sql.="       ,n_cartao ";
        $sql.="       ,ds_vencimento_cartao ";
        $sql.="       ,ds_nome_cartao ";
        $sql.="       ,bandeira_cartao_pk ";
        $sql.="       ,ds_email_financeiro ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,planos_pk ";

        $sql.="  from contas_dados_cobranca ";
        $sql.=" where 1=1 ";
        if($dia_vencimento != ""){
            $sql.=" and ds_conta_dados_cobranca like '%".$dia_vencimento."%' ";
        }
        $sql.=" order by dia_vencimento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dia_vencimento ";
        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,planos_pk ";
        $sql.="       ,tipo_pagamentos_pk ";
        $sql.="       ,n_cartao ";
        $sql.="       ,ds_vencimento_cartao ";
        $sql.="       ,ds_nome_cartao ";
        $sql.="       ,bandeira_cartao_pk ";
        $sql.="       ,ds_email_financeiro ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,contas_pk ";
        $sql.="       ,planos_pk ";

        $sql.="  from contas_dados_cobranca ";
        $sql.=" where 1=1 ";
        $sql.=" order by dia_vencimento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
