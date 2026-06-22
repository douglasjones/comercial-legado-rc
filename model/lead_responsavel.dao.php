<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/lead_responsavel.class.php';


class lead_responsaveldao{

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
    
    public function salvar($lead_responsavel){

        $fields = array();
        $fields['usuarios_pk'] = $lead_responsavel->getusuarios_pk();
        $fields['grupos_pk'] = $lead_responsavel->getgrupos_pk();
        $fields['leads_pk'] = $lead_responsavel->getleads_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['polos_pk'] = $lead_responsavel->getpolos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($lead_responsavel->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("leads_responsaveis", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("leads_responsaveis", $fields, " pk = ".$lead_responsavel->getpk());
        }

    }

    public function excluir($lead_responsavel){
        $this->db->execDelete("leads_responsaveis"," pk = ".$lead_responsavel->getpk());
    }
    public function excluirPorLead($leads_pk){
        $this->db->execDelete("leads_responsaveis"," leads_pk = ".$leads_pk);
    }

    public function carregarPorPk($pk){

        $lead_responsavel = new lead_responsavel();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,usuarios_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";


        $sql.="  from leads_responsaveis ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $lead_responsavel->setpk($query[$i]["pk"]);
                $lead_responsavel->setdt_cadastro($query[$i]["dt_cadastro"]);
                $lead_responsavel->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $lead_responsavel->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $lead_responsavel->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $lead_responsavel->setusuarios_pk($query[$i]['usuarios_pk']);
                $lead_responsavel->setgrupos_pk($query[$i]['grupos_pk']);
                $lead_responsavel->setleads_pk($query[$i]['leads_pk']);
                $lead_responsavel->setcontas_pk($query[$i]['contas_pk']);
                $lead_responsavel->setpolos_pk($query[$i]['polos_pk']);

            }
        }
        return $lead_responsavel;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from leads_responsaveis ";
        
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorResponsavelPk($pk,$leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from leads_responsaveis ";
        
        $sql.=" where usuarios_pk = $pk ";
        $sql.="     and leads_pk = ".$leads_pk;
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorLeadsPk($leads_pk){
        if($this->arrToken['grupos_pk']!="" && $this->arrToken['grupos_pk']!= 1 && $leads_pk==""){
            $sql ="";
            $sql.="select  ";
            $sql.="         u.pk usuarios_pk ";
            $sql.="       ,g.pk grupos_pk ";
            //$sql.="       ,lr.leads_pk ";
            $sql.="       ,u.contas_pk ";
            $sql.="       ,g.polos_pk ";
            $sql.="       ,u.ds_usuario ";
            $sql.="       ,g.ds_grupo ";

            $sql.="  from usuarios u";
            $sql.="       inner join grupos g on u.grupos_pk = g.pk";
            $sql.=" where 1=1";
            //$sql.=" and lr.leads_pk = ".$leads_pk;
            $sql.=" and u.pk = ".$this->arrToken['usuarios_pk'];
          
        }
        else{
            $sql ="";
            $sql.="select lr.pk, lr.dt_cadastro, lr.usuario_cadastro_pk, lr.dt_ult_atualizacao, lr.usuario_ult_atualizacao_pk  ";
            $sql.="       ,lr.usuarios_pk ";
            $sql.="       ,lr.grupos_pk ";
            $sql.="       ,lr.leads_pk ";
            $sql.="       ,lr.contas_pk ";
            $sql.="       ,lr.polos_pk ";
            $sql.="       ,u.ds_usuario ";
            $sql.="       ,g.ds_grupo ";

            $sql.="  from leads_responsaveis lr";
            $sql.="       inner join usuarios u on lr.usuarios_pk = u.pk";
            $sql.="       inner join grupos g on lr.grupos_pk = g.pk";
            $sql.=" where 1=1";
            $sql.=" and lr.leads_pk = ".$leads_pk;
        }
        
        
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorLeadsPkEDsGrupo($leads_pk,$ds_grupo){

        $sql ="";
        $sql.="select lr.pk, lr.dt_cadastro, lr.usuario_cadastro_pk, lr.dt_ult_atualizacao, lr.usuario_ult_atualizacao_pk  ";
        $sql.="       ,lr.usuarios_pk ";
        $sql.="       ,lr.grupos_pk ";
        $sql.="       ,lr.leads_pk ";
        $sql.="       ,lr.contas_pk ";
        $sql.="       ,lr.polos_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,g.ds_grupo ";

        $sql.="  from leads_responsaveis lr";
        $sql.="       inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.="       inner join grupos g on lr.grupos_pk = g.pk";
        $sql.=" where 1=1";
        if($leads_pk!=""){
            $sql.=" and lr.leads_pk = ".$leads_pk;
        }
        if($ds_grupo!=""){
            $sql.=" and g.ds_grupo like '%".$ds_grupo."%'";
        }
    
        
        
        
       
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_usuarios_pk($usuarios_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from leads_responsaveis ";
        $sql.=" where 1=1 ";
        if($usuarios_pk != ""){
            $sql.=" and ds_lead_responsavel like '%".$usuarios_pk."%' ";
        }
        $sql.=" order by usuarios_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from leads_responsaveis ";
        $sql.=" where 1=1 ";
        $sql.=" order by usuarios_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarResponsavelLeadPk($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";

        $sql.="  from leads_responsaveis ";
        $sql.=" where 1=1 ";
        $sql.="        and leads_pk = ".$leads_pk;
        $sql.=" order by usuarios_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
