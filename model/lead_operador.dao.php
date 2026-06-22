<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/lead_operador.class.php';


class lead_operadordao{

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
    
    public function salvar($lead_operador){

        $fields = array();
        $fields['operador_pk'] = $lead_operador->getoperador_pk();
        $fields['leads_pk'] = $lead_operador->getleads_pk();
        $fields['ic_cliente'] = $lead_operador->getic_cliente();
        $fields['ic_base'] = $lead_operador->getic_base();
        $fields['dt_ativacao'] = $lead_operador->getdt_ativacao();
        $fields['dt_vencimento'] = $lead_operador->getdt_vencimento();
        $fields['ds_custo_atual'] = $lead_operador->getds_custo_atual();
        $fields['ds_qtde_voz'] = $lead_operador->getds_qtde_voz();
        $fields['ds_qtde_dados'] = $lead_operador->getds_qtde_dados();
        $fields['ic_status'] = $lead_operador->getic_status();
        $fields['classificacao_pk'] = $lead_operador->getclassificacao_pk();
        $fields['tempo_contrato_pk'] = $lead_operador->gettempo_contrato_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($lead_operador->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("leads_operadoras", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("leads_operadoras", $fields, " pk = ".$lead_operador->getpk());
        }

    }

    public function excluir($lead_operador){
        $this->db->execDelete("leads_operadoras"," pk = ".$lead_operador->getpk());
    }

    public function carregarPorPk($pk){

        $lead_operador = new lead_operador();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,operador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ic_base ";
        $sql.="       ,dt_ativacao ";
        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_custo_atual ";
        $sql.="       ,ds_qtde_voz ";
        $sql.="       ,ds_qtde_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,tempo_contrato_pk";


        $sql.="  from leads_operadoras ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $lead_operador->setpk($query[$i]["pk"]);
                $lead_operador->setdt_cadastro($query[$i]["dt_cadastro"]);
                $lead_operador->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $lead_operador->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $lead_operador->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $lead_operador->setoperador_pk($query[$i]['operador_pk']);
                $lead_operador->setleads_pk($query[$i]['leads_pk']);
                $lead_operador->setic_cliente($query[$i]['ic_cliente']);
                $lead_operador->setic_base($query[$i]['ic_base']);
                $lead_operador->setdt_ativacao($query[$i]['dt_ativacao']);
                $lead_operador->setdt_vencimento($query[$i]['dt_vencimento']);
                $lead_operador->setds_custo_atual($query[$i]['ds_custo_atual']);
                $lead_operador->setds_qtde_voz($query[$i]['ds_qtde_voz']);
                $lead_operador->setds_qtde_dados($query[$i]['ds_qtde_dados']);
                $lead_operador->setic_status($query[$i]['ic_status']);

            }
        }
        return $lead_operador;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,operador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ic_base ";
        $sql.="       ,dt_ativacao ";
        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_custo_atual ";
        $sql.="       ,ds_qtde_voz ";
        $sql.="       ,ds_qtde_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,classificacao_pk";
        $sql.="       ,tempo_contrato_pk";

        $sql.="  from leads_operadoras ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_operador_pk($operador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,operador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ic_base ";
        $sql.="       ,dt_ativacao ";
        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_custo_atual ";
        $sql.="       ,ds_qtde_voz ";
        $sql.="       ,ds_qtde_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,classificacao_pk";
        $sql.="       ,tempo_contrato_pk";

        $sql.="  from leads_operadoras ";
        $sql.=" where 1=1 ";
        if($operador_pk != ""){
            $sql.=" and ds_lead_operador like '%".$operador_pk."%' ";
        }
        $sql.=" order by operador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_leads_pk($leads_pk){

        $sql ="";
        $sql.="select lo.pk, lo.dt_cadastro, lo.usuario_cadastro_pk, lo.dt_ult_atualizacao, lo.usuario_ult_atualizacao_pk ";
        $sql.="       ,lo.operador_pk ";
        $sql.="       ,lo.ic_base ";
        $sql.="       ,lo.ic_cliente ";
        $sql.="       ,lo.ic_status ";
        $sql.="       ,lo.leads_pk ";
        $sql.="       ,case lo.ic_base when 1 then 'Sim' when 2 then 'Não' end ds_base";
        $sql.="       ,case lo.ic_cliente when 1 then 'Sim' when 2 then 'Não' end ds_cliente";
        $sql.="       ,case lo.ic_status when 1 then 'Ativo' when 2 then 'Desativado' end ds_status";
        $sql.="       ,date_format(lo.dt_ativacao, '%d/%m/%Y') dt_ativacao";
        $sql.="       ,date_format(lo.dt_vencimento, '%d/%m/%Y') dt_vencimento";
        $sql.="       ,lo.ds_custo_atual ";
        $sql.="       ,lo.ds_qtde_voz ";
        $sql.="       ,lo.ds_qtde_dados ";
        $sql.="       ,lo.classificacao_pk";
        $sql.="       ,lo.tempo_contrato_pk";
        $sql.="       ,o.ds_operador";
        $sql.="       ,co.ds_classificacao";

        $sql.="  from leads_operadoras lo ";
        $sql.="       inner join operadores o on lo.operador_pk = o.pk";
        $sql.="       left join classificacao_operadoras co on co.pk = lo.classificacao_pk ";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and lo.leads_pk = ".$leads_pk;
        }
        $sql.=" group by lo.pk";
        $sql.=" order by lo.operador_pk asc ";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_grid_of($membro_equipe_pk,$dt_inicio,$dt_fim){

        $sql ="";
        $sql.="select lo.pk, lo.dt_cadastro, lo.usuario_cadastro_pk, lo.dt_ult_atualizacao, lo.usuario_ult_atualizacao_pk ";
        $sql.="       ,lo.operador_pk ";
        $sql.="       ,lo.ic_base ";
        $sql.="       ,lo.ic_cliente ";
        $sql.="       ,lo.ic_status ";
        $sql.="       ,lo.leads_pk ";
        $sql.="       ,case lo.ic_base when 1 then 'Sim' when 2 then 'Não' end ds_base";
        $sql.="       ,case lo.ic_cliente when 1 then 'Sim' when 2 then 'Não' end ds_cliente";
        $sql.="       ,case lo.ic_status when 1 then 'Ativo' when 2 then 'Desativado' end ds_status";
        $sql.="       ,date_format(lo.dt_ativacao, '%d/%m/%Y') dt_ativacao";
        $sql.="       ,date_format(lo.dt_vencimento, '%d/%m/%Y') dt_vencimento";
        $sql.="       ,lo.ds_custo_atual ";
        $sql.="       ,lo.ds_qtde_voz ";
        $sql.="       ,lo.ds_qtde_dados ";
        $sql.="       ,lo.classificacao_pk";
        $sql.="       ,lo.tempo_contrato_pk";
        $sql.="       ,o.ds_operador";
        $sql.="       ,l.ds_lead";
        $sql.="       ,o.ds_operador";
        $sql.="       ,u.ds_usuario";

        $sql.="  from leads_operadoras lo ";
        $sql.="       inner join operadores o on lo.operador_pk = o.pk";
        $sql.="       inner join leads l on lo.leads_pk = l.pk";
        $sql.="       inner join leads_responsaveis lr on lr.leads_pk = l.pk";
        $sql.="       inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="       inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.=" where 1=1 ";
        if($membro_equipe_pk != ""){
            $sql.=" and lr.usuarios_pk = ".$membro_equipe_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk =".$this->arrToken['equipes_pk'];
        }
        if($dt_inicio!=""){
            $sql.=" and lo.dt_vencimento between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        }
        $sql.=" group by lr.usuarios_pk";
        $sql.=" order by lo.operador_pk asc ";
   
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,operador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ic_base ";
        $sql.="       ,dt_ativacao ";
        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_custo_atual ";
        $sql.="       ,ds_qtde_voz ";
        $sql.="       ,ds_qtde_dados ";
        $sql.="       ,ic_status ";
        $sql.="       ,classificacao_pk";
        $sql.="       ,tempo_contrato_pk";

        $sql.="  from leads_operadoras ";
        $sql.=" where 1=1 ";
        $sql.=" order by operador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeOportunidadeSupervisor($token,$usuario_pk){

        $sql ="";
        $sql.="select count('pk')registros";

        $sql.="  from leads_operadoras ";
        $sql.=" where 1=1 ";
        $sql.="     and usuario_cadastro_pk =".$usuario_pk;
        //$sql.=" and dt_vencimento between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        $sql.=" order by operador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_grafico($token,$responsavel_pk,$dt_inicio,$dt_fim,$operador_pk){

        $sql ="";
        $sql.="select COUNT('0') total_leads";

        $sql.="  from leads_operadoras lo ";
        $sql.="       inner join operadores o on lo.operador_pk = o.pk";
        $sql.="       inner join leads_responsaveis lr on lr.leads_pk = lo.leads_pk";
        $sql.=" where 1=1 ";
        if($responsavel_pk != ""){
            $sql.=" and lr.usuarios_pk = ".$responsavel_pk;
        }
        if($operador_pk != ""){
            $sql.=" and lo.operador_pk = ".$operador_pk;
        }
        $sql.=" and lo.dt_vencimento between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        $sql.=" order by lo.operador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_grafico_supervisor($token,$membro_equipe_pk,$dt_inicio,$dt_fim,$operador_pk){

        $sql ="";
        $sql.="select COUNT('0') total_leads";
        $sql.="       ,u.ds_usuario";
        $sql.="  from leads_operadoras lo ";
        $sql.="       inner join operadores o on lo.operador_pk = o.pk";
        $sql.="       inner join leads_responsaveis lr on lr.leads_pk = lo.leads_pk";
        $sql.="       inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="       inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.=" where 1=1 ";
        if($membro_equipe_pk != ""){
            $sql.=" and lr.usuarios_pk = ".$membro_equipe_pk;
        }
        if($operador_pk != ""){
            $sql.=" and lo.operador_pk = ".$operador_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.="     and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        $sql.=" and lo.dt_vencimento between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        $sql.=" group by lr.usuarios_pk";
        $sql.=" order by lo.operador_pk asc ";
        
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_grid_relatorio($responsavel_pk){

        $sql ="";
        $sql.="select lo.pk, lo.dt_cadastro, lo.usuario_cadastro_pk, lo.dt_ult_atualizacao, lo.usuario_ult_atualizacao_pk ";
        $sql.="       ,lo.operador_pk ";
        $sql.="       ,lo.ic_base ";
        $sql.="       ,lo.ic_cliente ";
        $sql.="       ,lo.ic_status ";
        $sql.="       ,lo.leads_pk ";
        $sql.="       ,case lo.ic_base when 1 then 'Sim' when 2 then 'Não' end ds_base";
        $sql.="       ,case lo.ic_cliente when 1 then 'Sim' when 2 then 'Não' end ds_cliente";
        $sql.="       ,case lo.ic_status when 1 then 'Ativo' when 2 then 'Desativado' end ds_status";
        $sql.="       ,date_format(lo.dt_ativacao, '%d/%m/%Y') dt_ativacao";
        $sql.="       ,group_concat(date_format(lo.dt_vencimento, '%d/%m/%Y')) dt_vencimento";
        $sql.="       ,lo.ds_custo_atual ";
        $sql.="       ,group_concat(lo.ds_qtde_voz)ds_qtde_voz ";
        $sql.="       ,group_concat(lo.ds_qtde_dados)ds_qtde_dados ";
        $sql.="       ,lo.classificacao_pk";
        $sql.="       ,lo.tempo_contrato_pk";
        $sql.="       ,group_concat(o.ds_operador)ds_operador";
        $sql.="       ,l.ds_lead";

        $sql.="  from leads_operadoras lo ";
        $sql.="       inner join operadores o on lo.operador_pk = o.pk";
        $sql.="       inner join leads_responsaveis lr on lr.leads_pk = lo.leads_pk";
        $sql.="       inner join leads l on l.pk = lo.leads_pk";
        $sql.=" where 1=1 ";
        if($responsavel_pk != ""){
            $sql.=" and lr.usuarios_pk = ".$responsavel_pk;
        }
        $sql.=" group by lo.leads_pk";
        $sql.=" order by l.ds_lead asc ";
        
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
