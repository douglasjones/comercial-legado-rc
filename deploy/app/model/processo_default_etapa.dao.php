<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/processo_default_etapa.class.php';


class processo_default_etapadao{

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
    
    public function salvar($processo_default_etapa){

        $fields = array();
        $fields['ds_processo_default_etapa'] = $processo_default_etapa->getds_processo_default_etapa();
        $fields['n_ordem_etapa'] = $processo_default_etapa->getn_ordem_etapa();
        $fields['processos_default_pk'] = $processo_default_etapa->getprocessos_default_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($processo_default_etapa->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("processos_default_etapas", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("processos_default_etapas", $fields, " pk = ".$processo_default_etapa->getpk());
        }

    }

    public function excluir($processo_default_etapa){
        $this->db->execDelete("processos_default_etapas"," pk = ".$processo_default_etapa->getpk());
    }

    public function carregarPorPk($pk){

        $processo_default_etapa = new processo_default_etapa();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_processo_default_etapa ";
        $sql.="       ,n_ordem_etapa ";
        $sql.="       ,processos_default_pk ";


        $sql.="  from processos_default_etapas ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $processo_default_etapa->setpk($query[$i]["pk"]);
                $processo_default_etapa->setdt_cadastro($query[$i]["dt_cadastro"]);
                $processo_default_etapa->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $processo_default_etapa->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $processo_default_etapa->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $processo_default_etapa->setds_processo_default_etapa($query[$i]['ds_processo_default_etapa']);
                $processo_default_etapa->setn_ordem_etapa($query[$i]['n_ordem_etapa']);
                $processo_default_etapa->setprocessos_default_pk($query[$i]['processos_default_pk']);

            }
        }
        return $processo_default_etapa;
    }

    public function listarPorPk($processo_pk,$ds_processo_etapa){

        $sql ="";
        $sql.="select pde.classificacao_processo_etapa_pk,pde.tipos_ocorrencias_pk ";
        $sql.="       from processos_etapas pe";
        $sql.="         inner join processos p on pe.processos_pk = p.pk";
        $sql.="         inner join processos_default pd on p.processos_default_pk = pd.pk";
        $sql.="         inner join processos_default_etapas pde on pd.pk = pde.processos_default_pk";
        $sql.="         where pe.processos_pk =".$processo_pk;
        $sql.="               and pde.ds_processo_default_etapa like '%".$ds_processo_etapa."%'";
        $sql.="        group by pde.pk,pde.classificacao_processo_etapa_pk";
       
     
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_processo_default_pk($processo_default_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_processo_default_etapa ";
        $sql.="       ,n_ordem_etapa ";
        $sql.="       ,processos_default_pk ";
        $sql.="       ,classificacao_processo_etapa_pk ";
        $sql.="       ,tipos_ocorrencias_pk ";
        
        $sql.="       ,ic_ev_email_responsavel";
        $sql.="       ,ic_ev_email_lead";
        $sql.="       ,email_saida_grupos_pk";
        $sql.="       ,ds_email_saida";
        

        $sql.="  from processos_default_etapas ";
        $sql.=" where 1=1 ";
        if($processo_default_pk != ""){
            $sql.=" and processos_default_pk  = ".$processo_default_pk;
        }
        $sql.=" order by n_ordem_etapa asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_processo_default_etapa ";
        $sql.="       ,n_ordem_etapa ";
        $sql.="       ,processos_default_pk ";

        $sql.="  from processos_default_etapas ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_processo_default_etapa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
