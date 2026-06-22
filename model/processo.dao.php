<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/processo.class.php';


class processodao{

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
    
    public function salvar($processo){
        
        $fields = array();
        $fields['ds_processo'] = $processo->getds_processo();
        $fields['processos_default_pk'] = $processo->getprocessos_default_pk();
        $fields['leads_pk'] = $processo->getleads_pk();
        $fields['polos_pk'] = $processo->getpolos_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['motivo_cancelamento_processo_pk'] = $processo->getmotivo_cancelamento_processo_pk();
        $fields['ds_motivo_cancelamento'] = $processo->getds_motivo_cancelamento();
        if($processo->getmotivo_cancelamento_processo_pk()!=""){
            $fields['dt_cancelamento'] = "sysdate()";
        }

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        
        if($processo->getpk()  == ""){
        
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            
            $pk = $this->db->execInsert("processos", $fields);

            //Inclui as etapas
            $sql = "";
            $sql.="insert into processos_etapas (dt_cadastro,contas_pk,polos_pk, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk, ds_processo_etapa, n_ordem_etapa, processos_pk) ";
            $sql.="select SYSDATE(),".$this->arrToken['contas_pk'].",".$processo->getpolos_pk().", ".$this->arrToken['usuarios_pk'].", SYSDATE(), ".$this->arrToken['usuarios_pk'].", ds_processo_default_etapa, n_ordem_etapa, $pk ";
            $sql.="  from processos_default_etapas ";
            $sql.=" where processos_default_pk = ".$processo->getprocessos_default_pk();
           
            $this->db->execSQL($sql);
                    
            return $pk;
        }
        else{
            
            return $this->db->execUpdate("processos", $fields, " pk = ".$processo->getpk());
        }
    }

    public function excluir($processo){
        $this->db->execDelete("processos"," pk = ".$processo->getpk());
    }
    public function excluirProcessoMigracao($pk){
        $this->db->execDelete("processos"," pk = ".$pk);
    }

    public function carregarPorPk($pk){

        $processo = new processo();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_processo";
        $sql.="       ,processos_default_pk";
        $sql.="       ,leads_pk ";

        $sql.="  from processos";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $processo->setpk($query[$i]["pk"]);
                $processo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $processo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $processo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $processo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $processo->setds_processo($query[$i]['ds_processo']);
                $processo->setprocessos_default_pk($query[$i]['processos_default_pk']);
                $processo->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $processo;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk  ";
        $sql.="       ,p.ds_processo ";
        $sql.="       ,p.processos_default_pk ";
        $sql.="       ,p.leads_pk ";
        $sql.="       ,case p.classificacao_processo_pk when 1 then '25%' when 2 then '50%' when 3 then '75%' when 4 then 'Cliente' when 5 then '80%' when 6 then '90%' end ds_classificacao_processo";
        $sql.="       ,l.tipo_pessoa_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,p.classificacao_processo_pk";
        $sql.="       ,po.ds_polo";
        $sql.="  from processos p";
        $sql.="       inner join leads l on p.leads_pk = l.pk";
        $sql.="       inner join polos po on l.polos_pk = po.pk";
        $sql.=" where p.pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function carregarClassificacaoProcesso($pk){

        $sql ="";
        $sql.="select p.classificacao_processo_pk ";
        $sql.="       from processos_default_etapas pde";
        $sql.="       inner join processos_default pd on pde.processos_default_pk = pd.pk";
        $sql.="       inner join processos p on pd.pk = p.processos_default_pk";
        $sql.="    where p.pk =".$pk;
        $sql.="    group by p.pk";
        
      
       
      
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarEtapasPorPk($pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk  ";
        $sql.="       ,p.ds_processo_etapa ";
        $sql.="       ,p.n_ordem_etapa ";
        $sql.="       ,CONCAT( p.n_ordem_etapa, '. ', p.ds_processo_etapa )etapas ";
        $sql.="  from processos_etapas p";
        $sql.=" where p.processos_pk = $pk ";
        $sql.=" group by etapas";
        $sql.=" order by etapas";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarProcessoPorEtapasPk($processos_etapas_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk  ";
        $sql.="       ,p.ds_processo_etapa ";
        $sql.="       ,p.processos_pk ";
        $sql.="       ,p.n_ordem_etapa ";
        $sql.="       ,CONCAT( p.n_ordem_etapa, '. ', p.ds_processo_etapa )etapas ";
        $sql.="  from processos_etapas p";
        $sql.=" where p.pk = $processos_etapas_pk ";
        $sql.=" group by etapas";
        $sql.=" order by etapas";
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarEtapasPorLeadsPk($leads_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk  ";
        $sql.="       ,p.ds_processo_etapa ";
        $sql.="       ,p.n_ordem_etapa ";
        $sql.="       ,CONCAT( p.n_ordem_etapa, '. ', p.ds_processo_etapa )etapas ";
        $sql.="  from processos_etapas p";
        $sql.="       inner join processos ps on ps.pk = p.processos_pk";
        $sql.=" where ps.leads_pk = $leads_pk ";
        $sql.="   and p.ds_processo_etapa = 'Agenda do Condomínio'";
        $sql.=" group by etapas";
        $sql.=" order by etapas";
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorLeadsPk($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_processo ";
        $sql.="       ,processos_default_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,date_format(dt_cadastro,'%d/%m/%Y')dt_inicio";
        $sql.="       ,date_format(dt_fim,'%d/%m/%Y')dt_fim";
        $sql.="       ,date_format(dt_cancelamento,'%d/%m/%Y')dt_cancelamento";
        $sql.="       ,motivo_cancelamento_processo_pk";
        $sql.="       ,ds_motivo_cancelamento";
        $sql.="       ,case classificacao_processo_pk when 1 then '25%' when 2 then '50%' when 3 then '75%' when 4 then 'Cliente' when 5 then '80%' when 6 then '90%' end ds_classificacao ";
        $sql.="  from processos ";
        $sql.=" where leads_pk = $leads_pk ";
        $sql.=" and contas_pk = ".$this->arrToken['contas_pk'];
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_processo_default($ds_processo_default){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_processo ";
        $sql.="       ,processos_default_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from processos_default ";
        $sql.=" where 1=1 ";
        if($ds_processo_default != ""){
            $sql.=" and ds_processo_default like '%".$ds_processo_default."%' ";
        }
        $sql.=" order by ds_processo_default asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_processo ";
        $sql.="       ,processos_default_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from processos_default ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_processo_default asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQuantidadeProcesso($token,$usuario_pk){

        $sql ="";
        $sql.="select count('0')registros ";

        $sql.="  from processos p";
        $sql.="       inner join leads_responsaveis lr on lr.leads_pk = p.leads_pk";
        $sql.=" where 1=1 ";
        $sql.="     and lr.usuarios_pk = ".$usuario_pk;

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function GraficolistarQuantidadePorClassificacao($token,$polos_pk){

        $sql ="";
        $sql.="SELECT COUNT(0) qtde_processos,";
        $sql.="       CASE classificacao_processo_pk WHEN 1 THEN '25%' WHEN 2 THEN '50%' WHEN 3 THEN '75%' WHEN 4 THEN 'Cliente' END ds_classificacao";
        $sql.="  FROM processos";
        $sql.=" where contas_pk = ".$this->arrToken['contas_pk'];
        if($polos_pk!=""){
            $sql.=" and polos_pk = ".$polos_pk;
        }
        $sql.=" GROUP BY classificacao_processo_pk ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function adicionarProcessosEtapas($processo_pk, $ds_processo_etapa, $n_ordem_etapa,$dt_fim,$equipes_pk){
        
        $fields = array();
        $fields["dt_cadastro"] = "sysdate()";
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_cadastro_pk"] = $this->arrToken['usuarios_pk'];
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields['ds_processo_etapa'] = $ds_processo_etapa;
        $fields['n_ordem_etapa'] = $n_ordem_etapa;
        $fields['processos_pk'] = $processo_pk;
        $fields['dt_fim'] = $dt_fim;
        $fields['equipes_pk'] = $equipes_pk;
        
        $this->db->execInsert("processos_etapas", $fields);
        
    }
    
    function excluirProcessosEtapasPk($processo_pk){
      
        $this->db->execDelete("processos_etapas", " processos_pk = " . $processo_pk);
    }
    function excluirContratos($processo_etapas_pk){
      
        $this->db->execDelete("contratos", " processos_etapas_pk = " . $processo_etapas_pk);
    }
   
    function excluirAgenda($processo_etapas_pk){
      
        $this->db->execDelete("agendas", " processos_etapas_pk = " . $processo_etapas_pk);
    }
    
    function excluirPropostas($processo_etapas_pk){
      
        $this->db->execDelete("propostas", " processos_etapas_pk = " . $processo_etapas_pk);
    }
    
    function excluirOcorrencias($processo_etapas_pk){
      
        $this->db->execDelete("ocorrencias", " processos_etapas_pk = " . $processo_etapas_pk);
    }
    
     function updClassificacao($processo_pk,$classificacao_processo_pk){
         
        $fields = array();
        $fields["classificacao_processo_pk"] = $classificacao_processo_pk;
        if($classificacao_processo_pk==4){
            $fields["dt_fim"] = 'sysdate()';
        }
        
      
        $this->db->execUpdate("processos", $fields, " pk = ".$processo_pk);
    }

}

?>
