<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/colaborador.class.php';


class colaboradordao{

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
    
    public function salvar($colaborador){

        $fields = array();
        $fields['ds_colaborador'] = $colaborador->getds_colaborador();
        $fields['ds_cel'] = $colaborador->getds_cel();
        $fields['ic_whatsapp'] = $colaborador->getic_whatsapp();
        $fields['ds_cel2'] = $colaborador->getds_cel2();
        $fields['ic_whatsapp2'] = $colaborador->getic_whatsapp2();
        $fields['ds_cel3'] = $colaborador->getds_cel3();
        $fields['ic_whatsapp3'] = $colaborador->getic_whatsapp3();
        $fields['ds_email'] = $colaborador->getds_email();
        $fields['ds_rg'] = $colaborador->getds_rg();
        $fields['ds_cpf'] = $colaborador->getds_cpf();
        $fields['dt_nascimento'] = $colaborador->getdt_nascimento();
        $fields['ds_endereco'] = $colaborador->getds_endereco();
        $fields['ds_numero'] = $colaborador->getds_numero();
        $fields['ds_complemento'] = $colaborador->getds_complemento();
        $fields['ds_bairro'] = $colaborador->getds_bairro();
        $fields['ds_cep'] = $colaborador->getds_cep();
        $fields['ds_cidade'] = $colaborador->getds_cidade();
        $fields['ds_uf'] = $colaborador->getds_uf();
        $fields['ic_status'] = $colaborador->getic_status();
        $fields['ic_funcionario'] = $colaborador->getic_funcionario();
        $fields['generos_pk'] = $colaborador->getgeneros_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaborador->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("colaboradores", $fields, " pk = ".$colaborador->getpk());
        }

    }

    public function excluir($colaborador){
        $this->db->execDelete("colaboradores"," pk = ".$colaborador->getpk());
    }

    public function carregarPorPk($pk){

        $colaborador = new colaborador();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_colaborador ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_whatsapp ";
        $sql.="       ,ds_cel2 ";
        $sql.="       ,ic_whatsapp2 ";
        $sql.="       ,ds_cel3 ";
        $sql.="       ,ic_whatsapp3 ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_rg ";
        $sql.="       ,ds_cpf ";
        $sql.="       ,dt_nascimento ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ic_status ";
        $sql.="       ,ic_funcionario ";
        $sql.="       ,generos_pk ";


        $sql.="  from colaboradores ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaborador->setpk($query[$i]["pk"]);
                $colaborador->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaborador->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaborador->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaborador->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaborador->setds_colaborador($query[$i]['ds_colaborador']);
                $colaborador->setds_cel($query[$i]['ds_cel']);
                $colaborador->setic_whatsapp($query[$i]['ic_whatsapp']);
                $colaborador->setds_cel2($query[$i]['ds_cel2']);
                $colaborador->setic_whatsapp2($query[$i]['ic_whatsapp2']);
                $colaborador->setds_cel3($query[$i]['ds_cel3']);
                $colaborador->setic_whatsapp3($query[$i]['ic_whatsapp3']);
                $colaborador->setds_email($query[$i]['ds_email']);
                $colaborador->setds_rg($query[$i]['ds_rg']);
                $colaborador->setds_cpf($query[$i]['ds_cpf']);
                $colaborador->setdt_nascimento($query[$i]['dt_nascimento']);
                $colaborador->setds_endereco($query[$i]['ds_endereco']);
                $colaborador->setds_numero($query[$i]['ds_numero']);
                $colaborador->setds_complemento($query[$i]['ds_complemento']);
                $colaborador->setds_bairro($query[$i]['ds_bairro']);
                $colaborador->setds_cep($query[$i]['ds_cep']);
                $colaborador->setds_cidade($query[$i]['ds_cidade']);
                $colaborador->setds_uf($query[$i]['ds_uf']);
                $colaborador->setic_status($query[$i]['ic_status']);
                $colaborador->setic_funcionario($query[$i]['ic_funcionario']);
                $colaborador->setgeneros_pk($query[$i]['generos_pk']);

            }
        }
        return $colaborador;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk  ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,c.ds_cel ";
        $sql.="       ,c.ic_whatsapp ";
        $sql.="       ,c.ds_cel2 ";
        $sql.="       ,c.ic_whatsapp2 ";
        $sql.="       ,c.ds_cel3 ";
        $sql.="       ,c.ic_whatsapp3 ";
        $sql.="       ,c.ds_email ";
        $sql.="       ,c.ds_rg ";
        $sql.="       ,c.ds_cpf ";
        $sql.="       ,date_format(c.dt_nascimento,'%d/%m/%Y')dt_nascimento ";
        $sql.="       ,c.ds_endereco ";
        $sql.="       ,c.ds_numero ";
        $sql.="       ,c.ds_complemento ";
        $sql.="       ,c.ds_bairro ";
        $sql.="       ,c.ds_cep ";
        $sql.="       ,c.ds_cidade ";
        $sql.="       ,c.ds_uf ";
        $sql.="       ,c.ic_status ";
        $sql.="       ,c.ic_funcionario ";
        $sql.="       ,c.generos_pk ";
        $sql.="       ,cps.produtos_servicos_pk ";
        $sql.="  from colaboradores c ";
        $sql.=" left join colaboradores_produtos_servicos cps  on c.pk = cps.colaboradores_pk";
        $sql.=" where pk = $pk ";
        
      
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTodosColaboradoresEServicos(){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk  ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,c.ds_cel ";
        $sql.="       ,c.ic_whatsapp ";
        $sql.="       ,c.ds_cel2 ";
        $sql.="       ,c.ic_whatsapp2 ";
        $sql.="       ,c.ds_cel3 ";
        $sql.="       ,c.ic_whatsapp3 ";
        $sql.="       ,c.ds_email ";
        $sql.="       ,c.ds_rg ";
        $sql.="       ,c.ds_cpf ";
        $sql.="       ,date_format(c.dt_nascimento,'%d/%m/%Y')dt_nascimento ";
        $sql.="       ,c.ds_endereco ";
        $sql.="       ,c.ds_numero ";
        $sql.="       ,c.ds_complemento ";
        $sql.="       ,c.ds_bairro ";
        $sql.="       ,c.ds_cep ";
        $sql.="       ,c.ds_cidade ";
        $sql.="       ,c.ds_uf ";
        $sql.="       ,c.ic_status ";
        $sql.="       ,c.ic_funcionario ";
        $sql.="       ,c.generos_pk ";
        $sql.="       ,cps.produtos_servicos_pk ";
        $sql.="       ,ps.ds_produto_servico ";
        $sql.="  from colaboradores c ";
        $sql.=" left join colaboradores_produtos_servicos cps  on c.pk = cps.colaboradores_pk";
        $sql.=" inner join produtos_servicos ps  on ps.pk = cps.produtos_servicos_pk";
        
      
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_colaborador($ds_colaborador,$ic_status,$produtos_servicos_pk){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,c.ds_cel ";
        $sql.="       ,case c.ic_whatsapp when 1 then 'Sim' when 2 then 'Não' end ic_whatsapp ";
        $sql.="       ,c.ds_cel2 ";
        $sql.="       ,case c.ic_whatsapp2 when 1 then 'Sim' when 2 then 'Não' end ic_whatsapp2 ";
        $sql.="       ,c.ds_cel3 ";
        $sql.="       ,case c.ic_whatsapp3 when 1 then 'Sim' when 2 then 'Não' end ic_whatsapp3 ";
        $sql.="       ,c.ds_email ";
        $sql.="       ,c.ds_rg ";
        $sql.="       ,c.ds_cpf ";
        $sql.="       ,date_format(c.dt_nascimento,'%d/%m/%Y')dt_nascimento ";
        $sql.="       ,c.ds_endereco ";
        $sql.="       ,c.ds_numero ";
        $sql.="       ,c.ds_complemento ";
        $sql.="       ,c.ds_bairro ";
        $sql.="       ,c.ds_cep ";
        $sql.="       ,c.ds_cidade ";
        $sql.="       ,c.ds_uf ";
        $sql.="       ,case c.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ic_status ";
        $sql.="       ,c.ic_funcionario";
        //$sql.="       ,c.generos_pk ";
        $sql.="       ,g.ds_genero generos_pk ";

        $sql.="  from colaboradores c";
        $sql.=" inner join generos g on c.generos_pk = g.pk";
        $sql.=" left join colaboradores_produtos_servicos cps  on c.pk = cps.colaboradores_pk";
        $sql.=" where 1=1 ";
        if($ds_colaborador != ""){
            $sql.=" and c.ds_colaborador like '%".$ds_colaborador."%' ";
        }
        if($ic_status != ""){
            $sql.=" and c.ic_status =".$ic_status;
        }
        if($produtos_servicos_pk != ""){
            $sql.=" and cps.produtos_servicos_pk=".$produtos_servicos_pk;
        }
        $sql.=" order by c.ds_colaborador asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    
    
    
    public function listar_por_ds_colaborador_e_servico($ic_dom,$ic_seg,$ic_ter,$ic_qua,$ic_qui,$ic_sex,$ic_sab,$dom_turnos_pk,$seg_turnos_pk,$ter_turnos_pk,$qua_turnos_pk,$qui_turnos_pk,$sex_turnos_pk,$sab_turnos_pk,$dt_inicio_agenda,$dt_fim_agenda,$contratos_itens_pk,$agenda_colaborador_padrao_pk){

        
        $sql.=" select c.pk,c.ds_colaborador ";
        $sql.="   from colaboradores c ";
        $sql.="        inner join colaboradores_produtos_servicos cps on cps.colaboradores_pk = c.pk";
        $sql.="        inner join contratos_itens ci on cps.produtos_servicos_pk = ci.produtos_servicos_pk";
        $sql.="        left join agenda_colaborador_padrao a on a.colaboradores_pk = c.pk";
        $sql.="  where a.pk is null";
        if($contratos_itens_pk!=""){
            $sql.=" and ci.pk = ".$contratos_itens_pk;
        }
        
        $sql.=" union ";

        $sql.=" select c.pk,c.ds_colaborador "; 
        $sql.="   from colaboradores c ";
        $sql.="        inner join agenda_colaborador_padrao a on a.colaboradores_pk = c.pk ";
        $sql.="        inner join colaboradores_produtos_servicos cps on cps.colaboradores_pk = c.pk";
        $sql.="        inner join contratos_itens ci on cps.produtos_servicos_pk = ci.produtos_servicos_pk";
        
        if($contratos_itens_pk!=""){
            $sql.=" where ci.pk = ".$contratos_itens_pk;
        }
        $sql.=" group by c.pk, c.ds_colaborador ";
        $sql.=" having max(a.dt_fim_agenda) <'".  DataYMD($dt_inicio_agenda)."'";
        

        $sql.=" union"; 

        $sql.=" select c.pk, c.ds_colaborador ";
        $sql.="   from colaboradores c ";
        $sql.="        inner join agenda_colaborador_padrao a on a.colaboradores_pk = c.pk";
        $sql.="        inner join colaboradores_produtos_servicos cps on cps.colaboradores_pk = c.pk";
        $sql.="        inner join contratos_itens ci on cps.produtos_servicos_pk = ci.produtos_servicos_pk";
        $sql.="  where a.dt_inicio_agenda < '".  DataYMD($dt_fim_agenda)."'";
        
        if($contratos_itens_pk!=""){
            $sql.=" and ci.pk = ".$contratos_itens_pk;
        }
        
        if($ic_dom==1){
            $sql.=" and (a.ic_dom = 2 )";
        }
        if($dom_turnos_pk!=""){
            $sql.=" AND(  a.dom_turnos_pk <> $dom_turnos_pk or a.dom_turnos_pk is null)";
        }
        if($ic_seg==1){
            $sql.="	AND (a.ic_seg = 2 )";
        }
        if($seg_turnos_pk!=""){
            $sql.=" AND(  a.seg_turnos_pk <> $seg_turnos_pk or a.seg_turnos_pk is null)";
        }
        if($ic_ter==1){
            $sql.=" and (a.ic_ter = 2 )";
        }
        if($ter_turnos_pk!=""){
            $sql.=" AND(  a.ter_turnos_pk <> $ter_turnos_pk or a.ter_turnos_pk is null)";
        }

        if($ic_qua==1){
            $sql.=" and (a.ic_qua = 2 )";
        }
        if($qua_turnos_pk!=""){
			$sql.=" AND(  a.qua_turnos_pk <> $qua_turnos_pk or a.qua_turnos_pk is null)";
        }
        if($ic_qui==1){
            $sql.=" and (a.ic_qui = 2 )";
        }
        if($qui_turnos_pk!=""){
            $sql.=" AND( a.qui_turnos_pk <> $qui_turnos_pk or a.qui_turnos_pk is null)";
        }
        if($ic_sex==1){
            $sql.=" and (a.ic_sex = 2 )";
        }
        if($sex_turnos_pk!=""){
            $sql.=" AND( a.sex_turnos_pk <> $sex_turnos_pk or a.sex_turnos_pk is null)";
        }
        if($ic_sab==1){
            $sql.=" and (a.ic_sab = 2 )";
        }
        if($sab_turnos_pk!=""){
		$sql.=" AND( a.sab_turnos_pk <> $sab_turnos_pk or a.sab_turnos_pk is null)";
        }
        if($agenda_colaborador_padrao_pk!=""){
            $sql.=" union";
            $sql.="       select c.pk, c.ds_colaborador";
            $sql.="              from colaboradores c";
            $sql.="                   inner join agenda_colaborador_padrao acp on acp.colaboradores_pk = c.pk";
            $sql.="                   inner join colaboradores_produtos_servicos cps on cps.colaboradores_pk = c.pk";
            $sql.="                   inner join contratos_itens ci on cps.produtos_servicos_pk = ci.produtos_servicos_pk";
            $sql.="        where acp.pk =".$agenda_colaborador_padrao_pk;
            if($contratos_itens_pk!=""){
                $sql.=" and ci.pk = $contratos_itens_pk";
            }
        }
        $sql.=" order by 2";
       
 
       $query = $this->db->execQuery($sql);
        return $query;

    }
    

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_colaborador ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_whatsapp ";
        $sql.="       ,ds_cel2 ";
        $sql.="       ,ic_whatsapp2 ";
        $sql.="       ,ds_cel3 ";
        $sql.="       ,ic_whatsapp3 ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_rg ";
        $sql.="       ,ds_cpf ";
        $sql.="       ,dt_nascimento ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ic_status ";
        $sql.="       ,ic_funcionario ";
        $sql.="       ,generos_pk ";

        $sql.="  from colaboradores ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_colaborador asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
