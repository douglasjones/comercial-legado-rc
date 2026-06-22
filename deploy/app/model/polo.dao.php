<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/polo.class.php';


class polodao{

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
    
    public function salvar($polo){

        $fields = array();
        $fields['ds_polo'] = $polo->getds_polo();
        $fields['dt_cancelamento'] = $polo->getdt_cancelamento();
        $fields['ic_status'] = $polo->getic_status();
        //$fields['segmentos_pk'] =  $polo->getsegmentos_pk();
        $fields['contas_pk'] = $polo->getcontas_pk(); //$this->arrToken['contas_pk'];
        $fields['ds_cep'] = $polo->getds_cep();
        $fields['ds_endereco'] = $polo->getds_endereco();
        $fields['ds_numero'] = $polo->getds_numero();
        $fields['ds_complemento'] = $polo->getds_complemento();
        $fields['ds_bairro'] = $polo->getds_bairro();
        $fields['ds_cidade'] = $polo->getds_cidade();
        $fields['ds_uf'] = $polo->getds_uf();
        //$fields['responsavel_pk'] = $polo->getresponsavel_pk();
        $fields['ds_tel'] = $polo->getds_tel();
        $fields['ds_cel'] = $polo->getds_cel();
        $fields['ds_site'] = $polo->getds_site();
        $fields['ds_email'] = $polo->getds_email();

        
        $fields['dia_vencimento'] = $polo->getdia_vencimento();        
        $fields['planos_pk'] = $polo->getplanos_pk();
        $fields['tipo_pagamentos_pk'] = $polo->gettipo_pagamentos_pk();
        $fields['n_cartao'] = $polo->getn_cartao();
        $fields['ds_vencimento_cartao'] = $polo->getds_vencimento_cartao();
        $fields['ds_nome_cartao'] = $polo->getds_nome_cartao();
        $fields['bandeira_cartao_pk'] = $polo->getbandeira_cartao_pk();
        $fields['ds_email_financeiro'] = $polo->getds_email_financeiro();
                
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($polo->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("polos", $fields);
            //$this->db->execInsert("polos", $fields);
            //echo $this->db->getLastSQL();
            //exit;
            return $pk;
        }
        else{
            return $this->db->execUpdate("polos", $fields, " pk = ".$polo->getpk());
        }

    }

    public function excluir($polo){
        $this->db->execDelete("polos"," pk = ".$polo->getpk());
    }

    public function carregarPorPk($pk){

        $polo = new polo();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_polo ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ds_site ";
        $sql.="       ,ds_email ";


        $sql.="  from polos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $polo->setpk($query[$i]["pk"]);
                $polo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $polo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $polo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $polo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $polo->setds_polo($query[$i]['ds_polo']);
                $polo->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $polo->setic_status($query[$i]['ic_status']);
                $polo->setsegmentos_pk($query[$i]['segmentos_pk']);
                $polo->setcontas_pk($query[$i]['contas_pk']);
                $polo->setds_cep($query[$i]['ds_cep']);
                $polo->setds_endereco($query[$i]['ds_endereco']);
                $polo->setds_numero($query[$i]['ds_numero']);
                $polo->setds_complemento($query[$i]['ds_complemento']);
                $polo->setds_bairro($query[$i]['ds_bairro']);
                $polo->setds_cidade($query[$i]['ds_cidade']);
                $polo->setds_uf($query[$i]['ds_uf']);
                $polo->setresponsavel_pk($query[$i]['responsavel_pk']);
                $polo->setds_tel($query[$i]['ds_tel']);
                $polo->setds_cel($query[$i]['ds_cel']);
                $polo->setds_site($query[$i]['ds_site']);
                $polo->setds_email($query[$i]['ds_email']);

            }
        }
        return $polo;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_polo ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ds_site ";
        $sql.="       ,ds_email ";
        $sql.="       ,planos_pk ";
        $sql.="       ,dia_vencimento";
        $sql.="       ,tipo_pagamentos_pk";
        $sql.="       ,bandeira_cartao_pk";
        $sql.="       ,n_cartao";
        $sql.="       ,ds_vencimento_cartao";
        $sql.="       ,ds_nome_cartao";
        $sql.="       ,ds_email_financeiro";

        $sql.="  from polos ";
        $sql.=" where pk = $pk ";
        $sql.=" and contas_pk= ".$this->arrToken['contas_pk'];
 
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_ds_polo($ds_polo,$ic_status,$polos_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_polo ";
        $sql.="       ,p.dt_cancelamento ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,CASE p.ic_status WHEN 1 THEN 'Ativo' WHEN 2 THEN 'Inativo' END ic_status ";
        $sql.="       ,p.contas_pk ";
        $sql.="       ,p.ds_cep ";
        $sql.="       ,p.ds_endereco ";
        $sql.="       ,p.ds_numero ";
        $sql.="       ,p.ds_complemento ";
        $sql.="       ,p.ds_bairro ";
        $sql.="       ,p.ds_cidade ";
        $sql.="       ,p.ds_uf ";
        $sql.="       ,p.responsavel_pk ";
        $sql.="       ,p.ds_tel ";
        $sql.="       ,p.ds_cel ";
        $sql.="       ,p.ds_site ";
        $sql.="       ,p.ds_email ";
        $sql.="       ,c.ds_conta ";
        $sql.="       ,u.ds_usuario ds_responsavel ";
        $sql.="       ,p.planos_pk ";
        $sql.="       ,p.dia_vencimento";
        $sql.="       ,p.tipo_pagamentos_pk";
        $sql.="       ,p.bandeira_cartao_pk";
        $sql.="       ,p.n_cartao";
        $sql.="       ,p.ds_vencimento_cartao";
        $sql.="       ,p.ds_nome_cartao";
        $sql.="       ,p.ds_email_financeiro";
        $sql.="  from polos p";
        $sql.=" INNER JOIN contas c ON c.pk = p.contas_pk";
        $sql.=" LEFT JOIN usuarios u ON u.pk = p.responsavel_pk";
        $sql.=" where 1=1 ";
        
        if($polos_pk != ""){
            $sql.=" and polos_pk =".$polos_pk;
        }
                
        if($ds_polo != ""){
            $sql.=" and ds_polo like '%".$ds_polo."%' ";
        }
        if($ic_status != ""){
            $sql.=" and p.ic_status =".$ic_status;
        }
        $sql.=" and p.contas_pk= ".$this->arrToken['contas_pk'];
        $sql.=" order by ds_polo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_parGrid($pk,$ic_status){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_polo ";
        $sql.="       ,p.dt_cancelamento ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,CASE p.ic_status WHEN 1 THEN 'Ativo' WHEN 2 THEN 'Inativo' END ic_status ";
        $sql.="       ,p.contas_pk ";
        $sql.="       ,p.ds_cep ";
        $sql.="       ,p.ds_endereco ";
        $sql.="       ,p.ds_numero ";
        $sql.="       ,p.ds_complemento ";
        $sql.="       ,p.ds_bairro ";
        $sql.="       ,p.ds_cidade ";
        $sql.="       ,p.ds_uf ";
        $sql.="       ,p.responsavel_pk ";
        $sql.="       ,p.ds_tel ";
        $sql.="       ,p.ds_cel ";
        $sql.="       ,p.ds_site ";
        $sql.="       ,p.ds_email ";
        $sql.="       ,c.ds_conta ";
        $sql.="       ,u.ds_usuario ds_responsavel ";
        $sql.="       ,p.planos_pk ";
        $sql.="       ,p.dia_vencimento";
        $sql.="       ,p.tipo_pagamentos_pk";
        $sql.="       ,p.bandeira_cartao_pk";
        $sql.="       ,p.n_cartao";
        $sql.="       ,p.ds_vencimento_cartao";
        $sql.="       ,p.ds_nome_cartao";
        $sql.="       ,p.ds_email_financeiro";
        $sql.="  from polos p";
        $sql.=" INNER JOIN contas c ON c.pk = p.contas_pk";
        $sql.=" LEFT JOIN usuarios u ON u.pk = p.responsavel_pk";
        $sql.=" where 1=1 ";
        if($pk != ""){
            $sql.=" and p.pk =".$pk;
        }
        if($ic_status != ""){
            $sql.=" and p.ic_status =".$ic_status;
        }
        $sql.=" and p.contas_pk= ".$this->arrToken['contas_pk'];
        $sql.=" order by p.ds_polo asc ";
    
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
     public function listar_por_contas(){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_polo ";
        $sql.="       ,p.dt_cancelamento ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,p.segmentos_pk ";
        $sql.="       ,p.contas_pk ";
        $sql.="       ,p.ds_cep ";
        $sql.="       ,p.ds_endereco ";
        $sql.="       ,p.ds_numero ";
        $sql.="       ,p.ds_complemento ";
        $sql.="       ,p.ds_bairro ";
        $sql.="       ,p.ds_cidade ";
        $sql.="       ,p.ds_uf ";
        $sql.="       ,p.responsavel_pk ";
        $sql.="       ,p.ds_tel ";
        $sql.="       ,p.ds_cel ";
        $sql.="       ,p.ds_site ";
        $sql.="       ,p.ds_email ";
        $sql.="  from polos p ";
        $sql.="  inner join usuarios_polos up on up.polos_pk = p.pk";
        $sql.=" where p.contas_pk = ".$this->arrToken['contas_pk'];
        $sql.="       and up.usuarios_pk = ".$this->arrToken['usuarios_pk'];
        $sql.=" group by p.pk ";
        $sql.=" order by p.ds_polo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
     public function listar_por_contas_selecionado($contas_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_polo ";
        $sql.="       ,p.dt_cancelamento ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,p.segmentos_pk ";
        $sql.="       ,p.contas_pk ";
        $sql.="       ,p.ds_cep ";
        $sql.="       ,p.ds_endereco ";
        $sql.="       ,p.ds_numero ";
        $sql.="       ,p.ds_complemento ";
        $sql.="       ,p.ds_bairro ";
        $sql.="       ,p.ds_cidade ";
        $sql.="       ,p.ds_uf ";
        $sql.="       ,p.responsavel_pk ";
        $sql.="       ,p.ds_tel ";
        $sql.="       ,p.ds_cel ";
        $sql.="       ,p.ds_site ";
        $sql.="       ,p.ds_email ";
        $sql.="  from polos p ";
        $sql.="  left join usuarios_polos up on up.polos_pk = p.pk";
        $sql.=" where 1=1";
        if($contas_pk!=""){
            $sql.=" and p.contas_pk = ".$contas_pk;
        }
        //$sql.="       and up.usuarios_pk = ".$this->arrToken['usuarios_pk'];
        $sql.=" group by p.pk ";
        $sql.=" order by p.ds_polo asc ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_contas_usuarios(){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_polo ";
        $sql.="       ,p.dt_cancelamento ";
        $sql.="       ,p.ic_status ";
        $sql.="       ,p.segmentos_pk ";
        $sql.="       ,p.contas_pk ";
        $sql.="       ,p.ds_cep ";
        $sql.="       ,p.ds_endereco ";
        $sql.="       ,p.ds_numero ";
        $sql.="       ,p.ds_complemento ";
        $sql.="       ,p.ds_bairro ";
        $sql.="       ,p.ds_cidade ";
        $sql.="       ,p.ds_uf ";
        $sql.="       ,p.responsavel_pk ";
        $sql.="       ,p.ds_tel ";
        $sql.="       ,p.ds_cel ";
        $sql.="       ,p.ds_site ";
        $sql.="       ,p.ds_email ";
        $sql.="  from polos p ";
        $sql.=" inner join usuarios_polos up on p.pk = up.polos_pk ";
        $sql.=" where p.contas_pk = ".$this->arrToken['contas_pk'];
        $sql.=" and up.usuarios_pk=".$this->arrToken['usuarios_pk'];
        $sql.=" group by p.pk ";
        $sql.=" order by p.ds_polo asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_polo ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ic_status ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ds_site ";
        $sql.="       ,ds_email ";
        $sql.="  from polos ";
        $sql.=" where 1=1 ";
         $sql.=" and contas_pk= ".$this->arrToken['contas_pk'];
        $sql.=" order by ds_polo asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
