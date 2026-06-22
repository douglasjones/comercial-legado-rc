<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/contato.class.php';


class contatodao{

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
    
    public function salvar($contato){

        $fields = array();
        $fields['ds_contato'] = $contato->getds_contato();
        $fields['ds_cel'] = $contato->getds_cel();
        $fields['ic_whatsapp'] = $contato->getic_whatsapp();
        $fields['ds_email'] = $contato->getds_email();
        $fields['ds_tel'] = $contato->getds_tel();
        $fields['cargos_pk'] = $contato->getcargos_pk();
        $fields['leads_pk'] = $contato->getleads_pk();
        $fields['polos_pk'] = $contato->getpolos_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($contato->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("contatos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("contatos", $fields, " pk = ".$contato->getpk());
        }

    }

    public function excluirContato($contato){
        $this->db->execDelete("contatos"," pk = ".$contato->getpk());
        echo $sql;
    }
    public function excluirPorLead($leads_pk){
        $this->db->execDelete("contatos"," leads_pk = ".$leads_pk);
    }
    public function carregarPorPk($pk){

        $contato = new contato();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_contato ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_whatsapp ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_tel ";
        $sql.="       ,cargos_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from contatos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $contato->setpk($query[$i]["pk"]);
                $contato->setdt_cadastro($query[$i]["dt_cadastro"]);
                $contato->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $contato->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $contato->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $contato->setds_contato($query[$i]['ds_contato']);
                $contato->setds_cel($query[$i]['ds_cel']);
                $contato->setic_whatsapp($query[$i]['ic_whatsapp']);
                $contato->setds_email($query[$i]['ds_email']);
                $contato->setds_tel($query[$i]['ds_tel']);
                $contato->setcargos_pk($query[$i]['cargos_pk']);
                $contato->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $contato;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
            $sql.="       ,c.ds_contato ";
            $sql.="       ,c.ds_cel ";
            $sql.="       ,case c.ic_whatsapp when 1 then 'Sim' when 2 then 'Não' end ds_whatsapp ";
            $sql.="       ,c.ic_whatsapp ";
            $sql.="       ,c.ds_email ";
            $sql.="       ,c.ds_tel ";
            $sql.="       ,c.cargos_pk ";
            $sql.="       ,cg.ds_cargo ds_cargos_pk ";
            $sql.="       ,c.leads_pk ";
            $sql.="  from contatos c";
            $sql.="     left join cargos cg on c.cargos_pk = cg.pk";
            $sql.=" where 1=1 ";
            if($pk != ""){
                $sql.=" and c.pk  =".$pk;
            }
            $sql.=" order by c.ds_contato asc ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarPorLeadsPk($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_contato ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_whatsapp ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_tel ";
        $sql.="       ,cargos_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from contatos ";
        $sql.=" where leads_pk = $leads_pk ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_contato($ds_contato){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_contato ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_whatsapp ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_tel ";
        $sql.="       ,cargos_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from contatos ";
        $sql.=" where 1=1 ";
        if($ds_contato != ""){
            $sql.=" and ds_contato like '%".$ds_contato."%' ";
        }
        $sql.=" order by ds_contato asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_contato ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_whatsapp ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_tel ";
        $sql.="       ,cargos_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from contatos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_contato asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function carregarPorLeadsPk($leads_pk){
       
        if($leads_pk != ""){
            
            $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
            $sql.="       ,c.ds_contato ";
            $sql.="       ,c.ds_cel ";
            $sql.="       ,case c.ic_whatsapp when 1 then 'Sim' when 2 then 'Não' end ds_whatsapp ";
            $sql.="       ,c.ic_whatsapp ";
            $sql.="       ,c.ds_email ";
            $sql.="       ,c.ds_tel ";
            $sql.="       ,c.cargos_pk ";
            $sql.="       ,cg.ds_cargo ds_cargos_pk ";
            $sql.="       ,c.leads_pk ";
            $sql.="  from contatos c";
            $sql.="     left join cargos cg on c.cargos_pk = cg.pk";
            $sql.=" where 1=1 ";
            if($leads_pk != ""){
                $sql.=" and leads_pk  =".$leads_pk;
            }
            $sql.=" order by ds_contato asc ";
        
            
   
        }

        
        $query = $this->db->execQuery($sql);
        return $query;
      
    }
    public function carregarEmailContato($pk,$ds_contato){
            
            $sql.="select ";
            $sql.="      c.ds_email ";     
            $sql.="  from contatos c";
            $sql.=" where 1=1";
            if($pk!=""){
                $sql.="   and c.pk = ".$pk;
            }
            else{
                $sql.="    and c.ds_contato = '".$ds_contato."'";
            }
            $sql.=" order by ds_contato asc ";
       

        
        $query = $this->db->execQuery($sql);
        return $query[0]['ds_email'];
      
    }

}

?>
