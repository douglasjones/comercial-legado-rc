<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/contrato.class.php';


class contratodao{

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
    
    public function salvar($contrato){

        $fields = array();
        $fields['dt_inicio_contrato'] = $contrato->getdt_inicio_contrato();
        $fields['dt_fim_contrato'] = $contrato->getdt_fim_contrato();
        $fields['processos_etapas_pk'] = $contrato->getprocessos_etapas_pk();
        $fields['ic_tipo_contrato'] = $contrato->getic_tipo_contrato();
        $fields['contratos_pk'] = $contrato->getcontratos_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        if($contrato->getpolos_pk()!=""){
           $fields['polos_pk'] = $contrato->getpolos_pk(); 
        }
        else{
            $fields['polos_pk'] = $this->arrToken['polos_pk'];
        }
        $fields['propostas_pk'] = $contrato->getpropostas_pk();
        $fields['responsavel_pk'] = $contrato->getresponsavel_pk();
        $fields['operador_pk'] = $contrato->getoperador_pk();
        $fields['ds_numero_pedido_operador'] = $contrato->getds_numero_pedido_operador();
        $fields['ds_obs'] = $contrato->getds_obs();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($contrato->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("contratos", $fields);
            return $pk;
        }
        else{
             $this->db->execUpdate("contratos", $fields, " pk = ".$contrato->getpk());
             return $contrato->getpk();
            
        }

    }

    public function excluir($contrato){
        $this->db->execDelete("contratos"," pk = ".$contrato->getpk());
    }

    public function carregarPorPk($pk){

        $contrato = new contrato();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,dt_inicio_contrato ";
        $sql.="       ,dt_fim_contrato ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,ic_tipo_contrato";
        $sql.="       ,contratos_pk";


        $sql.="  from contratos ";
        $sql.=" where pk = $pk ";
        
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $contrato->setpk($query[$i]["pk"]);
                $contrato->setdt_cadastro($query[$i]["dt_cadastro"]);
                $contrato->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $contrato->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $contrato->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $contrato->setdt_inicio_contrato($query[$i]['dt_inicio_contrato']);
                $contrato->setdt_fim_contrato($query[$i]['dt_fim_contrato']);
                $contrato->setprocessos_etapas_pk($query[$i]['processos_etapas_pk']);
                $contrato->setic_tipo_contrato($query[$i]['ic_tipo_contrato']);
                $contrato->setcontratos_pk($query[$i]['contratos_pk']);

            }
        }
        return $contrato;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,date_format(dt_inicio_contrato, '%d/%m/%Y')dt_inicio_contrato";
        $sql.="       ,date_format(dt_fim_contrato, '%d/%m/%Y')dt_fim_contrato";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,ic_tipo_contrato ";
        $sql.="       ,contratos_pk ";

        $sql.="  from contratos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarPorLeadsPk($leads_pk){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk  ";
        $sql.="       ,c.dt_inicio_contrato ";
        $sql.="       ,c.dt_fim_contrato ";
        $sql.="       ,c.processos_etapas_pk ";
        $sql.="       ,c.ic_tipo_contrato ";
        $sql.="       ,c.contratos_pk ";
        $sql.="       ,concat('Contrato ',c.pk)ds_combo_contrato";

        $sql.="  from contratos c ";
        $sql.="       inner join contratos_itens ci on ci.contratos_pk = c.pk";
        $sql.="       inner join processos_etapas pe on c.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk=".$leads_pk;
        }
        $sql.=" group by c.pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dt_inicio_contrato($dt_inicio_contrato){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_inicio_contrato ";
        $sql.="       ,dt_fim_contrato ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,ic_tipo_contrato ";
        $sql.="       ,contratos_pk ";

        $sql.="  from contratos ";
        $sql.=" where 1=1 ";
        if($dt_inicio_contrato != ""){
            $sql.=" and ds_contrato like '%".$dt_inicio_contrato."%' ";
        }
        $sql.=" order by dt_inicio_contrato asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_qtde_dias_contratados_produtos_servicos($contratos_pk,$contratos_itens_pk,$produtos_servicos_pk){
        $sql ="";
        $sql.=" select ci.n_qtde_dias_semana from contratos c";
        $sql.="        inner join contratos_itens ci on ci.contratos_pk = c.pk";
        $sql.="  where c.pk = ".$contratos_pk;
        $sql.="        and ci.pk =".$contratos_itens_pk;
        $sql.="        and ci.produtos_servicos_pk =".$produtos_servicos_pk;
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_contrato_pai($leads_pk,$contratos_pk,$contrato_pai_pk){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.dt_inicio_contrato ";
        $sql.="       ,c.dt_fim_contrato ";
        $sql.="       ,c.processos_etapas_pk ";
        $sql.="       ,c.ic_tipo_contrato ";
        $sql.="       ,c.contratos_pk ";
        $sql.="       ,concat('Contrato ',c.pk)ds_combo_contrato";

        $sql.="  from contratos c";
        $sql.="       inner join processos_etapas pe on c.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk=".$leads_pk;
        }
        if($contrato_pai_pk!=""){
            $sql.="   and and c.contratos_pk IS NULL OR c.contratos_pk=".$contrato_pai_pk;
        }
        else{
            if($contratos_pk!=""){
                $sql.="   and c.pk not in(".$contratos_pk.")";
            }
            $sql.="   and c.contratos_pk IS NULL";
        }
        
        $sql.="   group by c.pk";
        $sql.=" order by c.pk asc ";
    
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_contrato_lead_processo($leads_pk,$processos_pk){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(c.dt_inicio_contrato,'%d/%m/%Y') dt_inicio_contrato";
        $sql.="       ,date_format(c.dt_fim_contrato,'%d/%m/%Y') dt_fim_contrato";
        $sql.="       ,c.processos_etapas_pk ";
        $sql.="       ,case c.ic_tipo_contrato when 1 then 'Contrato' when 2 then 'Aditivo' end ds_tipo_contrato";
        $sql.="       ,c.ic_tipo_contrato ";
        $sql.="       ,c.contratos_pk";
        $sql.="       ,c.operador_pk";
        $sql.="       ,sum(ci.vl_total)vl_total ";

        $sql.="  from contratos c ";
        $sql.="       left join contratos_itens ci on ci.contratos_pk = c.pk";
        $sql.="       inner join processos_etapas pe on c.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk=".$leads_pk;
        }
        if($processos_pk!=""){
            $sql.=" and p.pk=".$processos_pk;
        }
        $sql.=" and p.contas_pk = ".$this->arrToken['contas_pk'];
        $sql.="  group by c.pk ";
        $sql.=" order by c.pk asc ";
   
        

       
    
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_contrato_dashboard($token,$polos_pk){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(c.dt_inicio_contrato,'%d/%m/%Y') dt_inicio_contrato";
        $sql.="       ,date_format(c.dt_fim_contrato,'%d/%m/%Y') dt_fim_contrato";
        $sql.="       ,c.processos_etapas_pk ";
        $sql.="       ,case c.ic_tipo_contrato when 1 then 'Contrato' when 2 then 'Aditivo' end ds_tipo_contrato";
        $sql.="       ,c.ic_tipo_contrato ";
        $sql.="       ,c.contratos_pk";
        $sql.="       ,p.pk processos_pk";
        $sql.="       ,c.operador_pk";
        $sql.="       ,l.ds_lead";
        $sql.="       ,sum(ci.vl_total)vl_total ";

        $sql.="  from contratos c ";
        $sql.="       left join contratos_itens ci on ci.contratos_pk = c.pk";
        $sql.="       inner join processos_etapas pe on c.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.="       inner join leads l on l.pk = p.leads_pk";
        $sql.="       inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.=" where 1=1 ";
        $sql.=" and p.contas_pk = ".$this->arrToken['contas_pk'];
        
        if($polos_pk!=""){
            $sql.=" and p.polos_pk = ".$polos_pk;
        }
        $sql.="     and lr.usuarios_pk = ".$this->arrToken['usuarios_pk'];
        $sql.="  group by c.pk ";
        $sql.=" order by c.pk asc ";
   
        

       
    
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_inicio_contrato ";
        $sql.="       ,dt_fim_contrato ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,ic_tipo_contrato ";
        $sql.="       ,contratos_pk ";

        $sql.="  from contratos ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_inicio_contrato asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarContratoEtapa($operador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_etapa ";
        $sql.="  from etapas_contratos ";
        $sql.=" where 1=1 ";
        if($operador_pk!=""){
            $sql.=" and operador_pk = ".$operador_pk;
        }
        if($this->arrToken['polos_pk']!=""){
            $sql.=" and polos_pk = ".$this->arrToken['polos_pk'];
        }
        $sql.=" and contas_pk = ".$this->arrToken['contas_pk'];
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarContratoEtapaCadastrado($contratos_pk){

        $sql ="";
        $sql.="select date_format(cec.dt_etapa,'%d/%m/%Y')dt_etapa";
        $sql.="        ,date_format(cec.dt_cadastro,'%d/%m/%Y')dt_cadastro";
        $sql.="        ,cec.ds_obs";
        $sql.="        ,cec.etapas_contratos_pk";
        $sql.="        ,u.ds_usuario usuario_cadastro";
        $sql.="        ,cec.pk";
        $sql.="  from contratos_etapas_contratos cec ";
        $sql.="  inner join etapas_contratos ec on cec.etapas_contratos_pk = ec.pk";
        $sql.="  inner join usuarios u on cec.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($contratos_pk!=""){
            $sql.=" and contratos_pk = ".$contratos_pk;
        }

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    function excluirContratoItens($contratos_pk){
        $this->db->execDelete("contratos_itens", " contratos_pk = " . $contratos_pk);
    }
    function excluirContratoEtapas($contratos_etapas_pk){
        $this->db->execDelete("contratos_etapas_contratos", "pk = " . $contratos_etapas_pk);
    }
    function excluirContratoEtapasContratosPk($contratos_etapas_pk){
        $this->db->execDelete("contratos_etapas_contratos", "contratos_pk = " . $contratos_etapas_pk);
    }
    
    public function adicionarContratoItens($contratos_itens_pk,$contratos_pk,$n_qtde_dias_semana, $n_qtde, $vl_unit, $vl_total, $produtos_servicos_pk){
        
        $fields = array();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $fields['contratos_pk'] = $contratos_pk;
        $fields['n_qtde'] = $n_qtde;
        //$fields['n_qtde_dias_semana'] = $n_qtde_dias_semana;
        $fields['vl_unit'] = $vl_unit;
        $fields['vl_total'] = $vl_total;
        $fields['produtos_servicos_pk'] = $produtos_servicos_pk;
        
        if($contratos_itens_pk  == " "){
           
            $this->db->execInsert("contratos_itens", $fields);
        }
        else{
           
            $this->db->execUpdate("contratos_itens", $fields, " pk = ".$contratos_itens_pk);
        }
        
    }
    public function adicionarContratoEtapas($contratos_etapas_pk_2,$contratos_pk,$combo_contratos_etapas_pk, $dt_etapa, $ds_obs){
        $data = date("d/m/Y");
        $fields = array();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $fields['contratos_pk'] = $contratos_pk;
        $fields['etapas_contratos_pk'] = $combo_contratos_etapas_pk;
        if($dt_etapa!=""){
            $fields['dt_etapa'] = DataYMD($dt_etapa);
        }
        else{
            $fields['dt_etapa'] = DataYMD($data);
        }
        
        $fields['ds_obs'] = $ds_obs;
        if($contratos_etapas_pk_2  == ""){
           
            $this->db->execInsert("contratos_etapas_contratos", $fields);
        }
        else{
           
            $this->db->execUpdate("contratos_etapas_contratos", $fields, " pk = ".$contratos_etapas_pk_2);
        }
        
    }
    public function icClienteLead($ic_cliente,$leads_pk){
        
        $fields = array();
        $fields["ic_cliente"] = $ic_cliente;
           
        $this->db->execUpdate("leads", $fields, " pk = ".$leads_pk);
        
    }

}

?>
