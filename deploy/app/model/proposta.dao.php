<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/proposta.class.php';

class propostadao{

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
    
    public function salvar($proposta){
        $data = date("d/m/Y");
        $fields = array();
        $fields['n_versao'] = $proposta->getn_versao();
        $fields['responsavel_pk'] = $this->arrToken['usuarios_pk'];//$proposta->getresponsavel_pk();
        $fields['vl_total'] = $proposta->getvl_total();
        $fields['ds_obs'] = $proposta->getds_obs();
        if($proposta->getdt_validade()!=""){
            $fields['dt_validade'] = $proposta->getdt_validade();
        }
        else{
            $fields['dt_validade'] = DataYMD($data);
        }
        
        $fields['dt_envio'] = $proposta->getdt_envio();
        $fields['dt_previsao_fechamento'] = $proposta->getdt_previsao_fechamento();
        //$fields['dt_fechamento'] = $proposta->getdt_fechamento();
       
        
        $fields['processos_etapas_pk'] = $proposta->getprocessos_etapas_pk();
        $fields['agendas_pk'] = $proposta->getagendas_pk();
        if($proposta->getpolos_pk()!=""){
            $fields['polos_pk'] = $proposta->getpolos_pk();
        }
        else{
            $fields['polos_pk'] = $this->arrToken['polos_pk'];
        }
        
        $fields['leads_pk'] = $proposta->getleads_pk();
        $fields['operador_pk'] = $proposta->getoperador_pk();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["contas_pk"] = $this->arrToken['contas_pk'];
        
        if($proposta->getdt_cancelamento()== 1){
            $fields['dt_cancelamento'] = "sysdate()";
        }
        if($proposta->getdt_cancelamento()== 2){
            $fields['dt_cancelamento'] = " ";
        }
        $fields['ds_obs_motivo_cancelamento'] = $proposta->getds_obs_motivo_cancelamento();
        
        if($proposta->getdt_fechamento()== 1){
            $fields['dt_fechamento'] = "sysdate()";
        }
        if($proposta->getdt_fechamento()== 2){
            $fields['dt_fechamento'] = " ";
        }
      
        if($proposta->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            // printar query
            //$this->db->execInsert("propostas", $fields);
            //echo $this->db->getLastSQL();
            
            $pk = $this->db->execInsert("propostas", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("propostas", $fields, " pk = ".$proposta->getpk());
        }

    }

    public function excluir($proposta){
        //deleta itens proposta
        $this->db->execDelete("propostas_itens"," propostas_pk = ".$proposta->getpk());

        $this->db->execDelete("propostas"," pk = ".$proposta->getpk());
    }

    public function carregarPorPk($pk){

        $proposta = new proposta();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,n_versao ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,ds_obs ";
        $sql.="       ,dt_validade ";
        $sql.="       ,dt_envio ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ds_obs_motivo_cancelamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,operador_pk ";

        $sql.="  from propostas ";
        $sql.=" where pk = $pk ";
        
  
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $proposta->setpk($query[$i]["pk"]);
                $proposta->setdt_cadastro($query[$i]["dt_cadastro"]);
                $proposta->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $proposta->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $proposta->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
                $proposta->setn_versao($query[$i]['n_versao']);
                $proposta->setresponsavel_pk($query[$i]['responsavel_pk']);
                $proposta->setvl_total($query[$i]['vl_total']);
                $proposta->setds_obs($query[$i]['ds_obs']);
                $proposta->setdt_validade($query[$i]['dt_validade']);
                $proposta->setdt_envio($query[$i]['dt_envio']);
                $proposta->setdt_previsao_fechamento($query[$i]['dt_previsao_fechamento']);
                $proposta->setdt_fechamento($query[$i]['dt_fechamento']);
                $proposta->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $proposta->setds_obs_motivo_cancelamento($query[$i]['ds_obs_motivo_cancelamento']);
                $proposta->setprocessos_etapas_pk($query[$i]['processos_etapas_pk']);
                $proposta->setagendas_pk($query[$i]['agendas_pk']);
                $proposta->setoperador_pk($query[$i]['operador_pk']);

            }
        }
        return $proposta;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,n_versao ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,ds_obs ";
        $sql.="       ,dt_validade ";
        $sql.="       ,dt_envio ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ds_obs_motivo_cancelamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,operador_pk ";

        $sql.="  from propostas ";
        $sql.=" where pk = $pk ";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeProposta($token,$usuario_pk){

        $sql ="";
        $sql.="select count('pk')registros ";

        $sql.="  from propostas p";
        $sql.="       inner join leads_responsaveis lr on p.leads_pk = lr.leads_pk";
        $sql.=" where 1=1";
        $sql.=" and lr.usuarios_pk = ".$usuario_pk;
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_rel_funil_vendas($polos_pk,$leads_pk,$responsavel_pk,$dt_envio_ini,$dt_envio_fim,$dt_prev_fechamento_ini,$dt_prev_fechamento_fim,$dt_fechamento_ini,$dt_fechamento_fim,$grupos_pk){

        $sql ="";
        $sql.=" SELECT  l.ds_lead,";
        $sql.="         pe.processos_pk,";
        $sql.="         ps.classificacao_processo_pk,";
        $sql.="         case ps.classificacao_processo_pk when 1 then '25%' when 2 then '50%' when 3 then '75%' when 4 then 'Cliente' end ds_classficacao_processo,";
        $sql.="         SUM(pi.n_qtde) n_qtde,";
        $sql.="         p.vl_total,";
        $sql.="         p.operador_pk,";
        $sql.="         date_format(p.dt_envio,'%d-%m-%Y')dt_envio,";
        $sql.="         date_format(p.dt_cancelamento,'%d-%m-%Y')dt_cancelamento,";
        $sql.="         date_format(p.dt_fechamento,'%d-%m-%Y')dt_fechamento,";
        $sql.="         date_format(p.dt_previsao_fechamento,'%d-%m-%Y')dt_previsao_fechamento,";
        $sql.="         date_format(p.dt_validade,'%d-%m-%Y')dt_validade,";
        $sql.="         (u.ds_usuario)ds_responsavel,";
        $sql.="         date_format(p.dt_cadastro,'%d-%m-%Y')dt_cadastro";
        $sql.="    FROM propostas p";
        $sql.="         INNER JOIN propostas_itens pi ON p.pk = pi.propostas_pk";
        $sql.="         INNER JOIN processos_etapas pe ON p.processos_etapas_pk = pe.pk";
        $sql.="         INNER JOIN processos ps ON pe.processos_pk = ps.pk";
        $sql.="         INNER JOIN leads l ON p.leads_pk = l.pk";
        $sql.="         inner join usuarios u on p.responsavel_pk = u.pk ";
        $sql.="   where 1 = 1";
        if($polos_pk!=""){
            $sql.=" and p.polos_pk = ".$polos_pk;
        }
        if($leads_pk!=""){
            $sql.=" and l.pk = ".$leads_pk;
        }
        if($responsavel_pk!=""){
            $sql.=" and u.pk = ".$responsavel_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and u.grupos_pk = ".$grupos_pk;
        }
        if($dt_envio_ini!=""){
            $sql.=" and date_format(p.dt_envio,'%Y-%m-%d') >= '".DataYMD($dt_envio_ini)." '";
        }
        if($dt_envio_fim!=""){
            $sql.=" and date_format(p.dt_envio,'%Y-%m-%d') <= '".DataYMD($dt_envio_fim)." '";
        }
        if($dt_prev_fechamento_ini!=""){
            $sql.=" and date_format(p.dt_previsao_fechamento,'%Y-%m-%d') >= '".DataYMD($dt_prev_fechamento_ini)." '";
        }
        if($dt_prev_fechamento_fim!=""){
            $sql.=" and date_format(p.dt_previsao_fechamento,'%Y-%m-%d') <= '".DataYMD($dt_prev_fechamento_fim)." '";
        }
        if($dt_fechamento_ini!=""){
            $sql.=" and date_format(p.dt_fechamento,'%Y-%m-%d') >= '".DataYMD($dt_fechamento_ini)." '";
        }
        if($dt_fechamento_fim!=""){
            $sql.=" and date_format(p.dt_fechamento,'%Y-%m-%d') <= '".DataYMD($dt_fechamento_fim)." '";
        }
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dt_inicio(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_fim ";
        $sql.="       ,n_versao ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,ds_obs ";
        $sql.="       ,dt_validade ";
        $sql.="       ,dt_envio ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ds_obs_motivo_cancelamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,operador_pk ";

        $sql.="  from propostas ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_envio asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,n_versao ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,ds_obs ";
        $sql.="       ,dt_validade ";
        $sql.="       ,dt_envio ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ds_obs_motivo_cancelamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,agendas_pk ";
        $sql.="       ,operador_pk ";

        $sql.="  from propostas ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_envio asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_proposta_lead_processo($leads_pk,$processos_pk){

        $sql ="";
        $sql.="SELECT p.pk ,p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk";
        $sql.="    ,p.n_versao";
        $sql.="    ,u.ds_usuario ds_responsavel";
        $sql.="    ,date_format(p.dt_cadastro, '%d/%m/%Y %H:%i') dt_cad";
        $sql.="    ,date_format(p.dt_validade, '%d/%m/%Y') dt_validade";
        $sql.="    ,date_format(p.dt_envio, '%d/%m/%Y') dt_envio";
        $sql.="    ,date_format(p.dt_previsao_fechamento, '%d/%m/%Y') dt_previsao_fechamento";
        $sql.="    ,date_format(p.dt_fechamento, '%d/%m/%Y ') dt_fechamento";        
        $sql.="    ,date_format(p.dt_cancelamento, '%d/%m/%Y ') dt_cancelamento";        
        $sql.="    ,p.vl_total";
        $sql.="    ,p.ds_obs_motivo_cancelamento";
        $sql.="    ,p.ds_obs";
        $sql.="    ,p.operador_pk";
        $sql.="    ,p.responsavel_pk";
        $sql.="    ,p.leads_pk";
        $sql.="    ,c.ds_contato";
        $sql.="    ,c.ds_email ds_email_contato";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    left join contatos c on p.leads_pk = c.leads_pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        if($processos_pk!=""){
            $sql.=" and pr.pk=".$processos_pk;
        }
        $sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";       
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPropostaDashboardConsultor(){

        $sql ="";
        $sql.="SELECT p.pk ,p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk";
        $sql.="    ,p.n_versao";
        $sql.="    ,u.ds_usuario ds_responsavel";
        $sql.="    ,date_format(p.dt_cadastro, '%d/%m/%Y %H:%i') dt_cad";
        $sql.="    ,date_format(p.dt_validade, '%d/%m/%Y') dt_validade";
        $sql.="    ,date_format(p.dt_envio, '%d/%m/%Y') dt_envio";
        $sql.="    ,date_format(p.dt_previsao_fechamento, '%d/%m/%Y') dt_previsao_fechamento";
        $sql.="    ,date_format(p.dt_fechamento, '%d/%m/%Y ') dt_fechamento";        
        $sql.="    ,date_format(p.dt_cancelamento, '%d/%m/%Y ') dt_cancelamento";        
        $sql.="    ,p.vl_total";
        $sql.="    ,p.ds_obs_motivo_cancelamento";
        $sql.="    ,p.ds_obs";
        $sql.="    ,p.operador_pk";
        $sql.="    ,p.responsavel_pk";
        $sql.="    ,p.leads_pk";
        $sql.="    ,p.polos_pk";
        $sql.="    ,c.ds_contato";
        $sql.="    ,c.ds_email ds_email_contato";
        $sql.="    ,l.ds_lead";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    left join contatos c on p.leads_pk = c.leads_pk";
        $sql.="    inner join leads l on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($this->arrToken['grupos_pk']==2){
            $sql.=" and p.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        $sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";       
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function dateDiff($dt_envio,$dt_fechamento){
        $data = date("Y-m-d");
        if($dt_fechamento==null){
            $sql="";
            $sql.="SELECT DATEDIFF('".$data."', '".DataYMD($dt_envio)."')time"; 
        }
        else{
            $sql="";
            $sql.="SELECT DATEDIFF('".DataYMD($dt_envio)."', '".DataYMD($dt_fechamento)."')time"; 
        }
       
        $query = $this->db->execQuery($sql);
        return $query;
        
    }
    public function listar_proposta_lead_processo_dashboard($token,$polos_pk){

        $sql ="";
        $sql.="SELECT p.pk ,p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk";
        $sql.="    ,p.n_versao";
        $sql.="    ,p.leads_pk";
        $sql.="    ,p.polos_pk";
        $sql.="    ,pr.pk processos_pk";
        $sql.="    ,u.ds_usuario ds_responsavel";
        $sql.="    ,date_format(p.dt_cadastro, '%d/%m/%Y %H:%i') dt_cad";
        $sql.="    ,date_format(p.dt_validade, '%d/%m/%Y') dt_validade";
        $sql.="    ,date_format(p.dt_envio, '%d/%m/%Y') dt_envio";
        $sql.="    ,date_format(p.dt_previsao_fechamento, '%d/%m/%Y') dt_previsao_fechamento";
        $sql.="    ,date_format(p.dt_fechamento, '%d/%m/%Y ') dt_fechamento";        
        $sql.="    ,p.vl_total";
        $sql.="    ,p.ds_obs";
        $sql.="    ,p.operador_pk";
        $sql.="    ,l.ds_lead";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    INNER JOIN leads l on l.pk = p.leads_pk";
        $sql.=" where 1=1 ";
        if(!permissao("meu_gepros_listar", "cons", $token)){
            $sql.=" and p.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        if($polos_pk!=""){
            $sql.=" and pr.polos_pk =".$polos_pk;
        }
        $sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";       
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarProposta50($polos_pk){

        $sql ="";
        $sql.="SELECT count(p.pk)qtde_proposta50,";
        $sql.="       sum(p.vl_total)vl_total";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    INNER JOIN leads l on l.pk = p.leads_pk";
        $sql.=" where 1=1 ";
        if($this->arrToken['grupos_pk']==2){
            $sql.=" and p.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        if($polos_pk!=""){
            $sql.=" and pr.polos_pk =".$polos_pk;
        }
        $sql.=" and p.dt_envio is not null";
        $sql.=" and p.dt_previsao_fechamento is null";
        $sql.=" and p.dt_fechamento is null";
        $sql.=" and p.dt_cancelamento is null";
        //$sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";
        
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarProposta75($polos_pk){

        $sql ="";
        $sql.="SELECT count(p.pk)qtde_proposta75,";
        $sql.="       sum(p.vl_total)vl_total";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    INNER JOIN leads l on l.pk = p.leads_pk";
        $sql.=" where 1=1 ";
        if($this->arrToken['grupos_pk']==2){
            $sql.=" and p.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        if($polos_pk!=""){
            $sql.=" and pr.polos_pk =".$polos_pk;
        }
        $sql.=" and p.dt_envio is not null";
        $sql.=" and p.dt_previsao_fechamento is not null";
        $sql.=" and p.dt_fechamento is null";
        $sql.=" and p.dt_cancelamento is null";
        //$sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";
        
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPropostaFechada($polos_pk){

        $sql ="";
        $sql.="SELECT count(p.pk)qtde_proposta_fechada,";
        $sql.="       sum(p.vl_total)vl_total";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    INNER JOIN leads l on l.pk = p.leads_pk";
        $sql.=" where 1=1 ";
        if($this->arrToken['grupos_pk']==2){
            $sql.=" and p.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        if($polos_pk!=""){
            $sql.=" and pr.polos_pk =".$polos_pk;
        }
        $sql.=" and p.dt_fechamento is not null";
        $sql.=" and p.dt_cancelamento is null";
        //$sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";
        
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPropostaCancelada($polos_pk){

        $sql ="";
        $sql.="SELECT count(p.pk)qtde_proposta_cancelada,";
        $sql.="       sum(p.vl_total)vl_total";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    INNER JOIN leads l on l.pk = p.leads_pk";
        $sql.=" where 1=1 ";
        if($this->arrToken['grupos_pk']==2){
            $sql.=" and p.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        if($polos_pk!=""){
            $sql.=" and pr.polos_pk =".$polos_pk;
        }
        $sql.=" and p.dt_cancelamento is not null";
        //$sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";
        
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function adicionarPropostaItens($propostas_itens_pk,$propostas_pk, $n_qtde, $vl_unit, $vl_total, $produtos_servicos_pk){   

        $fields = array();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $fields['propostas_pk'] = $propostas_pk;
        $fields['n_qtde'] = $n_qtde;
        $fields['vl_unit'] = $vl_unit;
        $fields['vl_total'] = $vl_total;
        $fields['produtos_servicos_pk'] = $produtos_servicos_pk;
        
        if($propostas_itens_pk  == ""){            
            $this->db->execInsert("propostas_itens", $fields);            
        }else{           
            $this->db->execUpdate("propostas_itens", $fields, " pk = ".$propostas_itens_pk);                         
        }  
        
    }
    public function excluirItemPropostaPk($pk){
        $this->db->execDelete("propostas_itens"," propostas_pk = ".$pk);
        
    }
}

?>
