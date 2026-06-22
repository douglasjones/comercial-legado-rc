<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/agenda_colaborador_padrao.class.php';


class agenda_colaborador_padraodao{

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
    
    public function salvar($agenda_colaborador_padrao){

        $fields = array();
        $fields['ds_agenda'] = $agenda_colaborador_padrao->getds_agenda();
        $fields['dt_inicio_agenda'] = $agenda_colaborador_padrao->getdt_inicio_agenda();
        $fields['dt_fim_agenda'] = $agenda_colaborador_padrao->getdt_fim_agenda();
        $fields['colaboradores_pk'] = $agenda_colaborador_padrao->getcolaboradores_pk();
        $fields['processos_etapas_pk'] = $agenda_colaborador_padrao->getprocessos_etapas_pk();
        $fields['contratos_itens_pk'] = $agenda_colaborador_padrao->getcontratos_itens_pk();
        $fields['ic_dom'] = $agenda_colaborador_padrao->getic_dom();
        $fields['ic_seg'] = $agenda_colaborador_padrao->getic_seg();
        $fields['ic_ter'] = $agenda_colaborador_padrao->getic_ter();
        $fields['ic_qua'] = $agenda_colaborador_padrao->getic_qua();
        $fields['ic_qui'] = $agenda_colaborador_padrao->getic_qui();
        $fields['ic_sex'] = $agenda_colaborador_padrao->getic_sex();
        $fields['ic_sab'] = $agenda_colaborador_padrao->getic_sab();
        //TURNOS DOM
        if($agenda_colaborador_padrao->getdom_turnos_pk()!=""){
            $fields['dom_turnos_pk'] = $agenda_colaborador_padrao->getdom_turnos_pk();
        }
        else{
            $fields['dom_turnos_pk'] = "null";
        }
        
        //TURNOS SEG
        if($agenda_colaborador_padrao->getseg_turnos_pk()!=""){
            $fields['seg_turnos_pk'] = $agenda_colaborador_padrao->getseg_turnos_pk();
        }
        else{
            $fields['seg_turnos_pk'] = "null";
        }
        
        //TURNOS TER
        if($agenda_colaborador_padrao->getter_turnos_pk()!=""){
            $fields['ter_turnos_pk'] = $agenda_colaborador_padrao->getter_turnos_pk();
        }
        else{
            $fields['ter_turnos_pk'] = "null";
        }
        
        //TURNOS QUA
        if($agenda_colaborador_padrao->getqua_turnos_pk()!=""){
            $fields['qua_turnos_pk'] = $agenda_colaborador_padrao->getqua_turnos_pk();
        }
        else{
            $fields['qua_turnos_pk'] = "null";
        }
        
        //TURNOS QUI
        if($agenda_colaborador_padrao->getqui_turnos_pk()!=""){
            $fields['qui_turnos_pk'] = $agenda_colaborador_padrao->getqui_turnos_pk();
        }
        else{
            $fields['qui_turnos_pk'] = "null";
        }
        
        //TURNOS SEX
        if($agenda_colaborador_padrao->getsex_turnos_pk()!=""){
            $fields['sex_turnos_pk'] = $agenda_colaborador_padrao->getsex_turnos_pk();
        }
        else{
            $fields['sex_turnos_pk'] = "null";
        }
        
        //TURNOS SAB
        if($agenda_colaborador_padrao->getsab_turnos_pk()!=""){
            $fields['sab_turnos_pk'] = $agenda_colaborador_padrao->getsab_turnos_pk();
        }
        else{
            $fields['sab_turnos_pk'] = "null";
        }
        


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($agenda_colaborador_padrao->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("agenda_colaborador_padrao", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("agenda_colaborador_padrao", $fields, " pk = ".$agenda_colaborador_padrao->getpk());
        }

    }

    public function excluir($agenda_colaborador_padrao){
        $this->db->execDelete("agenda_colaborador_padrao"," pk = ".$agenda_colaborador_padrao->getpk());
    }

    public function carregarPorPk($pk){

        $agenda_colaborador_padrao = new agenda_colaborador_padrao();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_agenda ";
        $sql.="       ,dt_inicio_agenda ";
        $sql.="       ,dt_fim_agenda ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,ic_dom";
        $sql.="       ,ic_seg";
        $sql.="       ,ic_ter";
        $sql.="       ,ic_qua";
        $sql.="       ,ic_qui";
        $sql.="       ,ic_sex";
        $sql.="       ,ic_sab";
        $sql.="       ,dom_turnos_pk";
        $sql.="       ,seg_turnos_pk";
        $sql.="       ,ter_turnos_pk";
        $sql.="       ,qua_turnos_pk";
        $sql.="       ,qui_turnos_pk";
        $sql.="       ,sex_turnos_pk";
        $sql.="       ,sab_turnos_pk";
        $sql.="       ,contratos_itens_pk";


        $sql.="  from agenda_colaborador_padrao ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agenda_colaborador_padrao->setpk($query[$i]["pk"]);
                $agenda_colaborador_padrao->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agenda_colaborador_padrao->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agenda_colaborador_padrao->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agenda_colaborador_padrao->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agenda_colaborador_padrao->setds_agenda($query[$i]['ds_agenda']);
                $agenda_colaborador_padrao->setdt_inicio_agenda($query[$i]['dt_inicio_agenda']);
                $agenda_colaborador_padrao->setdt_fim_agenda($query[$i]['dt_fim_agenda']);
                $agenda_colaborador_padrao->setcolaboradores_pk($query[$i]['colaboradores_pk']);
                $agenda_colaborador_padrao->setprocessos_etapas_pk($query[$i]['processos_etapas_pk']);
                $agenda_colaborador_padrao->setic_dom($query[$i]['ic_dom']);
                $agenda_colaborador_padrao->setic_seg($query[$i]['ic_seg']);
                $agenda_colaborador_padrao->setic_ter($query[$i]['ic_ter']);
                $agenda_colaborador_padrao->setic_qua($query[$i]['ic_qua']);
                $agenda_colaborador_padrao->setic_qui($query[$i]['ic_qui']);
                $agenda_colaborador_padrao->setic_sex($query[$i]['ic_sex']);
                $agenda_colaborador_padrao->setic_sab($query[$i]['ic_sab']);
                $agenda_colaborador_padrao->setdom_turnos_pk($query[$i]['dom_turnos_pk']);
                $agenda_colaborador_padrao->setseg_turnos_pk($query[$i]['seg_turnos_pk']);
                $agenda_colaborador_padrao->setter_turnos_pk($query[$i]['ter_turnos_pk']);
                $agenda_colaborador_padrao->setqua_turnos_pk($query[$i]['qua_turnos_pk']);
                $agenda_colaborador_padrao->setqui_turnos_pk($query[$i]['qui_turnos_pk']);
                $agenda_colaborador_padrao->setsex_turnos_pk($query[$i]['sex_turnos_pk']);
                $agenda_colaborador_padrao->setsab_turnos_pk($query[$i]['sab_turnos_pk']);
                $agenda_colaborador_padrao->setcontratos_itens_pk($query[$i]['contratos_itens_pk']);

            }
        }
        return $agenda_colaborador_padrao;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_agenda ";
        $sql.="       ,dt_inicio_agenda ";
        $sql.="       ,dt_fim_agenda ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,ic_dom";
        $sql.="       ,ic_seg";
        $sql.="       ,ic_ter";
        $sql.="       ,ic_qua";
        $sql.="       ,ic_qui";
        $sql.="       ,ic_sex";
        $sql.="       ,ic_sab";
        $sql.="       ,dom_turnos_pk";
        $sql.="       ,seg_turnos_pk";
        $sql.="       ,ter_turnos_pk";
        $sql.="       ,qua_turnos_pk";
        $sql.="       ,qui_turnos_pk";
        $sql.="       ,sex_turnos_pk";
        $sql.="       ,sab_turnos_pk";
        $sql.="       ,contratos_itens_pk";

        $sql.="  from agenda_colaborador_padrao ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarAgendaPorContratosPk($contratos_pk){

        $sql ="";
        $sql.="select a.pk, a.dt_cadastro, a.usuario_cadastro_pk, a.dt_ult_atualizacao, a.usuario_ult_atualizacao_pk  ";
        $sql.="       ,a.ds_agenda ";
        $sql.="       ,a.dt_inicio_agenda ";
        $sql.="       ,a.dt_fim_agenda ";
        $sql.="       ,a.colaboradores_pk ";
        $sql.="       ,a.processos_etapas_pk ";
        $sql.="       ,a.ic_dom";
        $sql.="       ,a.ic_seg";
        $sql.="       ,a.ic_ter";
        $sql.="       ,a.ic_qua";
        $sql.="       ,a.ic_qui";
        $sql.="       ,a.ic_sex";
        $sql.="       ,a.ic_sab";
        $sql.="       ,a.dom_turnos_pk";
        $sql.="       ,a.seg_turnos_pk";
        $sql.="       ,a.ter_turnos_pk";
        $sql.="       ,a.qua_turnos_pk";
        $sql.="       ,a.qui_turnos_pk";
        $sql.="       ,a.sex_turnos_pk";
        $sql.="       ,a.sab_turnos_pk";
        $sql.="       ,a.contratos_itens_pk";

        $sql.="  from agenda_colaborador_padrao a";
        $sql.="       left join contratos_itens ci on ci.pk = a.contratos_itens_pk";
        $sql.="       left join contratos c on c.pk = ci.contratos_pk";
        
        $sql.=" where c.pk = $contratos_pk ";
     
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_agenda($ds_agenda){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_agenda ";
        $sql.="       ,dt_inicio_agenda ";
        $sql.="       ,dt_fim_agenda ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,ic_dom";
        $sql.="       ,ic_seg";
        $sql.="       ,ic_ter";
        $sql.="       ,ic_qua";
        $sql.="       ,ic_qui";
        $sql.="       ,ic_sex";
        $sql.="       ,ic_sab";
        $sql.="       ,dom_turnos_pk";
        $sql.="       ,seg_turnos_pk";
        $sql.="       ,ter_turnos_pk";
        $sql.="       ,qua_turnos_pk";
        $sql.="       ,qui_turnos_pk";
        $sql.="       ,sex_turnos_pk";
        $sql.="       ,sab_turnos_pk";
        $sql.="       ,contratos_itens_pk";

        $sql.="  from agenda_colaborador_padrao ";
        $sql.=" where 1=1 ";
        if($ds_agenda != ""){
            $sql.=" and ds_agenda_colaborador_padrao like '%".$ds_agenda."%' ";
        }
        $sql.=" order by ds_agenda asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_agenda ";
        $sql.="       ,dt_inicio_agenda ";
        $sql.="       ,dt_fim_agenda ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,ic_dom";
        $sql.="       ,ic_seg";
        $sql.="       ,ic_ter";
        $sql.="       ,ic_qua";
        $sql.="       ,ic_qui";
        $sql.="       ,ic_sex";
        $sql.="       ,ic_sab";
        $sql.="       ,dom_turnos_pk";
        $sql.="       ,seg_turnos_pk";
        $sql.="       ,ter_turnos_pk";
        $sql.="       ,qua_turnos_pk";
        $sql.="       ,qui_turnos_pk";
        $sql.="       ,sex_turnos_pk";
        $sql.="       ,sab_turnos_pk";
        $sql.="       ,contratos_itens_pk";

        $sql.="  from agenda_colaborador_padrao ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_agenda asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_agenda_colaborador_lead_processo($leads_pk,$processos_pk){

        $sql ="";
        $sql.="select a.pk, a.dt_cadastro, a.usuario_cadastro_pk, a.dt_ult_atualizacao, a.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(a.dt_inicio_agenda,'%d/%m/%Y') dt_inicio_agenda";
        $sql.="       ,date_format(a.dt_fim_agenda,'%d/%m/%Y') dt_fim_agenda";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,a.colaboradores_pk ";
        $sql.="       ,a.ic_dom";
        $sql.="       ,a.ic_seg";
        $sql.="       ,a.ic_ter";
        $sql.="       ,a.ic_qua";
        $sql.="       ,a.ic_qui";
        $sql.="       ,a.ic_sex";
        $sql.="       ,a.ic_sab";
        $sql.="       ,ps.ds_produto_servico";
        $sql.="       ,ct.pk contratos_pk";
        $sql.="       ,a.dom_turnos_pk";
        $sql.="       ,a.seg_turnos_pk";
        $sql.="       ,a.ter_turnos_pk";
        $sql.="       ,a.qua_turnos_pk";
        $sql.="       ,a.qui_turnos_pk";
        $sql.="       ,a.sex_turnos_pk";
        $sql.="       ,a.sab_turnos_pk";
        $sql.="       ,a.contratos_itens_pk";
        $sql.="       ,t_dom.ds_turno ds_turno_dom";
        $sql.="       ,t_seg.ds_turno ds_turno_seg";
        $sql.="       ,t_ter.ds_turno ds_turno_ter";
        $sql.="       ,t_qua.ds_turno ds_turno_qua";
        $sql.="       ,t_qui.ds_turno ds_turno_qui";
        $sql.="       ,t_sex.ds_turno ds_turno_sex";
        $sql.="       ,t_sab.ds_turno ds_turno_sab";
        $sql.="  from agenda_colaborador_padrao a ";
        $sql.="       inner join colaboradores c on a.colaboradores_pk = c.pk";
        $sql.="       inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.="       inner join contratos_itens ci on a.contratos_itens_pk = ci.pk";
        $sql.="       inner join contratos ct on ci.contratos_pk = ct.pk";
        $sql.="       inner join produtos_servicos ps on ci.produtos_servicos_pk = ps.pk";
        $sql.="       left join turnos t_dom on a.dom_turnos_pk = t_dom.pk";
        $sql.="       left join turnos t_seg on a.seg_turnos_pk = t_seg.pk";
        $sql.="       left join turnos t_ter on a.ter_turnos_pk = t_ter.pk";
        $sql.="       left join turnos t_qua on a.qua_turnos_pk = t_qua.pk";
        $sql.="       left join turnos t_qui on a.qui_turnos_pk = t_qui.pk";
        $sql.="       left join turnos t_sex on a.sex_turnos_pk = t_sex.pk";
        $sql.="       left join turnos t_sab on a.sab_turnos_pk = t_sab.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk=".$leads_pk;
        }
        if($processos_pk!=""){
            $sql.=" and p.pk=".$processos_pk;
        }
        $sql.=" and c.pk NOT IN (SELECT acp.colaboradores_pk FROM agenda_colaborador_pausa acp where acp.dt_inicio_pausa = a.dt_inicio_agenda and acp.dt_fim_pausa = a.dt_fim_agenda and acp.colaboradores_pk = c.pk)";
        $sql.=" order by a.dt_inicio_agenda asc ";
      
        
        $query = $this->db->execQuery($sql);
        
        return $query;

    }
    
    public function listar_agenda_colaborador($leads_pk,$processos_pk,$qtde_dias_contrato,$contratos_pk){

        $sql ="";
        $sql.="select a.pk, ANY_VALUE(a.dt_cadastro) dt_cadastro, ANY_VALUE(a.usuario_cadastro_pk) usuario_cadastro_pk, ANY_VALUE(a.dt_ult_atualizacao) dt_ult_atualizacao, ANY_VALUE(a.usuario_ult_atualizacao_pk) usuario_ult_atualizacao_pk ";
        $sql.="       ,ANY_VALUE(date_format(a.dt_inicio_agenda,'%d/%m/%Y')) dt_inicio_agenda";
        $sql.="       ,ANY_VALUE(date_format(a.dt_fim_agenda,'%d/%m/%Y')) dt_fim_agenda";
        $sql.="       ,ANY_VALUE(c.ds_colaborador) ds_colaborador";
        $sql.="       ,ANY_VALUE(a.colaboradores_pk) colaboradores_pk ";
        $sql.="       ,ANY_VALUE(a.ic_dom) ic_dom";
        $sql.="       ,ANY_VALUE(a.ic_seg) ic_seg";
        $sql.="       ,ANY_VALUE(a.ic_ter) ic_ter";
        $sql.="       ,ANY_VALUE(a.ic_qua) ic_qua";
        $sql.="       ,ANY_VALUE(a.ic_qui) ic_qui";
        $sql.="       ,ANY_VALUE(a.ic_sex) ic_sex";
        $sql.="       ,ANY_VALUE(a.ic_sab) ic_sab";
        $sql.="       ,ANY_VALUE(a.dom_turnos_pk) dom_turnos_pk";
        $sql.="       ,ANY_VALUE(a.seg_turnos_pk) seg_turnos_pk";
        $sql.="       ,ANY_VALUE(a.ter_turnos_pk) ter_turnos_pk";
        $sql.="       ,ANY_VALUE(a.qua_turnos_pk) qua_turnos_pk";
        $sql.="       ,ANY_VALUE(a.qui_turnos_pk) qui_turnos_pk";
        $sql.="       ,ANY_VALUE(a.sex_turnos_pk) sex_turnos_pk";
        $sql.="       ,ANY_VALUE(a.sab_turnos_pk) sab_turnos_pk";
        $sql.="       ,ANY_VALUE(t_dom.ds_turno) ds_turno_dom";
        $sql.="       ,ANY_VALUE(t_seg.ds_turno) ds_turno_seg";
        $sql.="       ,ANY_VALUE(t_ter.ds_turno) ds_turno_ter";
        $sql.="       ,ANY_VALUE(t_qua.ds_turno) ds_turno_qua";
        $sql.="       ,ANY_VALUE(t_qui.ds_turno) ds_turno_qui";
        $sql.="       ,ANY_VALUE(t_sex.ds_turno) ds_turno_sex";
        $sql.="       ,ANY_VALUE(t_sab.ds_turno) ds_turno_sab";
        $sql.="  from agenda_colaborador_padrao a ";
        $sql.="       inner join colaboradores c on a.colaboradores_pk = c.pk";
        $sql.="       inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.="       left join turnos t_dom on a.dom_turnos_pk = t_dom.pk";
        $sql.="       left join turnos t_seg on a.seg_turnos_pk = t_seg.pk";
        $sql.="       left join turnos t_ter on a.ter_turnos_pk = t_ter.pk";
        $sql.="       left join turnos t_qua on a.qua_turnos_pk = t_qua.pk";
        $sql.="       left join turnos t_qui on a.qui_turnos_pk = t_qui.pk";
        $sql.="       left join turnos t_sex on a.sex_turnos_pk = t_sex.pk";
        $sql.="       left join turnos t_sab on a.sab_turnos_pk = t_sab.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk=".$leads_pk;
        }
        if($processos_pk!=""){
            $sql.=" and p.pk=".$processos_pk;
        }
        if($contratos_pk!=""){
            $sql.=" and a.contratos_itens_pk=".$contratos_pk;
        }
        $sql.=" group by a.pk";
        if($qtde_dias_contrato!=""){
            $sql.="  having SUM(case a.ic_dom when 1 then 1 ELSE 0 END + case a.ic_seg when 1 then 1 ELSE 0 END + case a.ic_ter when 1 then 1 ELSE 0 end + case a.ic_qua when 1 then 1 ELSE 0 end + case a.ic_qui when 1 then 1 ELSE 0 end + case a.ic_sex when 1 then 1 ELSE 0 end + case a.ic_sab when 1 then 1 ELSE 0 end) = ".$qtde_dias_contrato;
        }
        $sql.=" order by c.ds_colaborador, a.dt_inicio_agenda asc ";
     
     
        $query = $this->db->execQuery($sql);
        
        return $query;

    }
    public function rel_listar_agenda_colaborador_data($leads_pk,$dt_base,$produtos_servicos_pk,$qtde_dias_contrato,$dia_semana){

        $sql ="";
        $sql.="select a.pk, a.dt_cadastro, a.usuario_cadastro_pk, a.dt_ult_atualizacao, a.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(a.dt_inicio_agenda,'%d/%m/%Y') dt_inicio_agenda";
        $sql.="       ,date_format(a.dt_fim_agenda,'%d/%m/%Y') dt_fim_agenda";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,a.colaboradores_pk ";
        $sql.="       ,ps.ds_produto_servico ";
        $sql.="       ,a.ic_dom";
        $sql.="       ,a.ic_seg";
        $sql.="       ,a.ic_ter";
        $sql.="       ,a.ic_qua";
        $sql.="       ,a.ic_qui";
        $sql.="       ,a.ic_sex";
        $sql.="       ,a.ic_sab";
        $sql.="       ,a.contratos_itens_pk";
        $sql.="       ,a.dom_turnos_pk";
        $sql.="       ,a.seg_turnos_pk";
        $sql.="       ,a.ter_turnos_pk";
        $sql.="       ,a.qua_turnos_pk";
        $sql.="       ,a.qui_turnos_pk";
        $sql.="       ,a.sex_turnos_pk";
        $sql.="       ,a.sab_turnos_pk";
        $sql.="       ,t_dom.ds_turno ds_turno_dom";
        $sql.="       ,t_seg.ds_turno ds_turno_seg";
        $sql.="       ,t_ter.ds_turno ds_turno_ter";
        $sql.="       ,t_qua.ds_turno ds_turno_qua";
        $sql.="       ,t_qui.ds_turno ds_turno_qui";
        $sql.="       ,t_sex.ds_turno ds_turno_sex";
        $sql.="       ,t_sab.ds_turno ds_turno_sab";
        $sql.="  from agenda_colaborador_padrao a ";
        $sql.="       inner join colaboradores c on a.colaboradores_pk = c.pk";
        $sql.="       inner join colaboradores_produtos_servicos cps ON c.pk = cps.colaboradores_pk";
        $sql.="       inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.="       inner join contratos_itens ci on a.contratos_itens_pk = ci.pk";
        $sql.="       inner join contratos ct on ci.contratos_pk = ct.pk";
        $sql.="       inner join produtos_servicos ps on ci.produtos_servicos_pk = ps.pk";
        $sql.="       left join turnos t_dom on a.dom_turnos_pk = t_dom.pk";
        $sql.="       left join turnos t_seg on a.seg_turnos_pk = t_seg.pk";
        $sql.="       left join turnos t_ter on a.ter_turnos_pk = t_ter.pk";
        $sql.="       left join turnos t_qua on a.qua_turnos_pk = t_qua.pk";
        $sql.="       left join turnos t_qui on a.qui_turnos_pk = t_qui.pk";
        $sql.="       left join turnos t_sex on a.sex_turnos_pk = t_sex.pk";
        $sql.="       left join turnos t_sab on a.sab_turnos_pk = t_sab.pk";
        $sql.=" where 1=1 ";
        $sql.=" AND a.dt_inicio_agenda <= '".DataYMD($dt_base)."'";
        $sql.=" AND a.dt_fim_agenda >= '".DataYMD($dt_base)."'";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk=".$leads_pk;
        }
        $sql.=" and c.pk NOT IN (SELECT acp.colaboradores_pk FROM agenda_colaborador_pausa acp where acp.dt_inicio_pausa ='".DataYMD($dt_base)."')";
        if($produtos_servicos_pk!=""){
            $sql.=" and ps.pk = ".$produtos_servicos_pk;
        }
        if($qtde_dias_contrato == 7){
            $sql.="  group by a.pk";
            $sql.="  having SUM(case a.ic_dom when 1 then 1 ELSE 0 END + case a.ic_seg when 1 then 1 ELSE 0 END + case a.ic_ter when 1 then 1 ELSE 0 end + case a.ic_qua when 1 then 1 ELSE 0 end + case a.ic_qui when 1 then 1 ELSE 0 end + case a.ic_sex when 1 then 1 ELSE 0 end + case a.ic_sab when 1 then 1 ELSE 0 end) >= ".$qtde_dias_contrato;
        }
        
        if($dia_semana==0){
            $sql.=" and a.ic_dom =1";
        }
        else if($dia_semana==1){
            $sql.=" and a.ic_seg =1";
        }
        else if($dia_semana==2){
            $sql.=" and a.ic_ter =1";
        }
        else if($dia_semana==3){
            
            $sql.=" and a.ic_qua =1";
        }
        else if($dia_semana==4){
            $sql.=" and a.ic_qui =1";
        }
        else if($dia_semana==5){
            $sql.=" and a.ic_sex =1";
        }
        else if($dia_semana==6){
            $sql.=" and a.ic_sab =1";
        }
        $sql.=" order by c.ds_colaborador, a.dt_inicio_agenda asc ";
       
   
        $query = $this->db->execQuery($sql);
        
        return $query;

    }
    public function listar_qtde_itens_profissionais_contratados($leads_pk,$contratos_pk){
        
        $sql ="";
        $sql.="select   ps.ds_produto_servico,";
        $sql.="         ci.pk contratos_itens_pk,";
        $sql.="         c.pk contratos_pk,";
        $sql.="         ci.n_qtde_dias_semana,";
        $sql.="         ps.pk produtos_itens_pk,";
        $sql.="         (select sum(ci.n_qtde) from contratos_itens ci  inner join contratos ct on ct.pk = ci.contratos_pk INNER JOIN processos_etapas pes ON pes.pk = ct.processos_etapas_pk  inner join processos pse on pes.processos_pk = pse.pk where ps.pk = ci.produtos_servicos_pk  and c.pk = ci.contratos_pk and  pse.leads_pk=$leads_pk) qtde_contratado";
        $sql.="    from leads l";
        $sql.="         inner join processos p on p.leads_pk = l.pk";
        $sql.="         inner join processos_etapas pe on pe.processos_pk = p.pk";
        $sql.="         inner join contratos c on c.processos_etapas_pk = pe.pk";
        $sql.="         inner join contratos_itens ci on ci.contratos_pk = c.pk";
        $sql.="         inner join produtos_servicos ps on ci.produtos_servicos_pk = ps.pk";                     
        $sql.="   where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and l.pk=".$leads_pk;
        }
        if($contratos_pk!=""){
            $sql.=" and c.pk=".$contratos_pk;
        }
        $sql.=" order by ps.ds_produto_servico "; 
        
      
       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }  
    
    public function listar_profissionais_qtde_dia($leads_pk,$contratos_itens_pk,$qtde_dia_semana,$contratos_itens_pk){
        
        $sql ="";
        $sql.=" SELECT COUNT(DISTINCT c.pk)qtde_profissionais";
        $sql.="   FROM agenda_colaborador_padrao acp";
        $sql.="        INNER JOIN colaboradores c ON acp.colaboradores_pk = c.pk";
        $sql.="        INNER JOIN contratos_itens ci on acp.contratos_itens_pk = ci.pk";
        $sql.="        INNER JOIN colaboradores_produtos_servicos cps ON c.pk = cps.colaboradores_pk";
        $sql.="        INNER JOIN processos_etapas pes ON pes.pk = acp.processos_etapas_pk";
        $sql.="        INNER JOIN processos pse ON pes.processos_pk = pse.pk";
        $sql.="  WHERE pse.leads_pk =".$leads_pk;
        if($contratos_itens_pk!=""){
            $sql.=" and acp.contratos_itens_pk = ".$contratos_itens_pk;
        }
	$sql.="        group by acp.pk";
        if($qtde_dia_semana!=""){
            $sql.="        having SUM(CASE acp.ic_dom";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_seg";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_ter";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_qua";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_qui";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_sex";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_sab";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END)=".$qtde_dia_semana;
        }
        $sql.="      order by c.pk";       

        $query = $this->db->execQuery($sql);
        return $query;

    }    
    public function listar_qtde_itens_profissionais_contratados_data($leads_pk,$dt_agenda_inicio,$dt_agenda_fim){
        
        $sql ="";
        $sql.="select   ps.ds_produto_servico,";
        $sql.="         (select sum(ci.n_qtde) from contratos_itens ci  inner join contratos ct on ct.pk = ci.contratos_pk INNER JOIN processos_etapas pes ON pes.pk = ct.processos_etapas_pk  inner join processos pse on pes.processos_pk = pse.pk where ci.produtos_servicos_pk = ps.pk and  pse.leads_pk=$leads_pk) qtde_contratado,";
        $sql.="         (SELECT  count( DISTINCT c.pk) FROM agenda_colaborador_padrao acp  inner join colaboradores c on acp.colaboradores_pk = c.pk  inner join colaboradores_produtos_servicos cps on c.pk = cps.colaboradores_pk inner join processos_etapas pes ON pes.pk = acp.processos_etapas_pk inner join processos pse on pes.processos_pk = pse.pk WHERE cps.produtos_servicos_pk= ps.pk and  pse.leads_pk=$leads_pk)qtde_profissional,"; 
        $sql.="        ((select sum(ci.n_qtde) from contratos_itens ci  inner join contratos ct on ct.pk = ci.contratos_pk INNER JOIN processos_etapas pes ON pes.pk = ct.processos_etapas_pk  inner join processos pse on pes.processos_pk = pse.pk where ci.produtos_servicos_pk = ps.pk and  pse.leads_pk=$leads_pk) - (SELECT  count( DISTINCT c.pk) FROM agenda_colaborador_padrao acp  inner join colaboradores c on acp.colaboradores_pk = c.pk  inner join colaboradores_produtos_servicos cps on c.pk = cps.colaboradores_pk inner join processos_etapas pes ON pes.pk = acp.processos_etapas_pk inner join processos pse on pes.processos_pk = pse.pk WHERE cps.produtos_servicos_pk= ps.pk and  pse.leads_pk=$leads_pk))diferenca";
        $sql.="    from leads l";
        $sql.="         inner join processos p on p.leads_pk = l.pk";
        $sql.="         inner join processos_etapas pe on pe.processos_pk = p.pk";
        $sql.="         inner join contratos c on c.processos_etapas_pk = pe.pk";
        $sql.="         inner join contratos_itens ci on ci.contratos_pk = c.pk";
        $sql.="         inner join produtos_servicos ps on ci.produtos_servicos_pk = ps.pk";                     
        $sql.="   where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and l.pk=".$leads_pk;
        }
        if($dt_agenda_inicio!=""){
            $sql.=" and '".DataYMD($dt_agenda_inicio)."' and '".DataYMD($dt_agenda_fim)."' between c.dt_inicio_contrato and c.dt_fim_contrato";
            
        }
        
        $sql.=" group by ps.ds_produto_servico";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }    
    public function listar_agenda_colaborador_lead_data($leads_pk,$dt_agenda,$dia_semana){
      
        
        $sql ="";
        $sql.="select a.pk, a.dt_cadastro, a.usuario_cadastro_pk, a.dt_ult_atualizacao, a.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(a.dt_inicio_agenda,'%d/%m/%Y') dt_inicio_agenda";
        $sql.="       ,date_format(a.dt_fim_agenda,'%d/%m/%Y') dt_fim_agenda";
        $sql.="       ,a.ds_agenda";
        $sql.="       ,a.processos_etapas_pk ";
        $sql.="       ,a.colaboradores_pk ";
        $sql.="       ,a.ic_dom";
        $sql.="       ,a.ic_seg";
        $sql.="       ,a.ic_ter";
        $sql.="       ,a.ic_qua";
        $sql.="       ,a.ic_qui";
        $sql.="       ,a.ic_sex";
        $sql.="       ,a.ic_sab";
        $sql.="       ,a.dom_turnos_pk";
        $sql.="       ,a.seg_turnos_pk";
        $sql.="       ,a.ter_turnos_pk";
        $sql.="       ,a.qua_turnos_pk";
        $sql.="       ,a.qui_turnos_pk";
        $sql.="       ,a.sex_turnos_pk";
        $sql.="       ,a.sab_turnos_pk";
        $sql.="       ,t_dom.ds_turno ds_turno_dom";
        $sql.="       ,t_seg.ds_turno ds_turno_seg";
        $sql.="       ,t_ter.ds_turno ds_turno_ter";
        $sql.="       ,t_qua.ds_turno ds_turno_qua";
        $sql.="       ,t_qui.ds_turno ds_turno_qui";
        $sql.="       ,t_sex.ds_turno ds_turno_sex";
        $sql.="       ,t_sab.ds_turno ds_turno_sab";
        
        //$sql.="       ,d.ds_dia_semana";
        //$sql.="       ,t.ds_turno";
        $sql.="       ,concat(c.ds_colaborador,' (',ps.ds_produto_servico,' -> ',t_dom.ds_turno,')')ds_colaborador_dom";
        $sql.="       ,concat(c.ds_colaborador,' (',ps.ds_produto_servico,' -> ',t_seg.ds_turno,')')ds_colaborador_seg";
        $sql.="       ,concat(c.ds_colaborador,' (',ps.ds_produto_servico,' -> ',t_ter.ds_turno,')')ds_colaborador_ter";
        $sql.="       ,concat(c.ds_colaborador,' (',ps.ds_produto_servico,' -> ',t_qua.ds_turno,')')ds_colaborador_qua";
        $sql.="       ,concat(c.ds_colaborador,' (',ps.ds_produto_servico,' -> ',t_qui.ds_turno,')')ds_colaborador_qui";
        $sql.="       ,concat(c.ds_colaborador,' (',ps.ds_produto_servico,' -> ',t_sex.ds_turno,')')ds_colaborador_sex";
        $sql.="       ,concat(c.ds_colaborador,' (',ps.ds_produto_servico,' -> ',t_sab.ds_turno,')')ds_colaborador_sab";
        $sql.="       ,concat(c.ds_colaborador,' (',ps.ds_produto_servico,')')ds_colaborador_grid";
        $sql.="       ,l.ds_lead";
        //$sql.="       ,c.ds_colaborador";
        $sql.="       ,ps.ds_produto_servico";
        $sql.="  from agenda_colaborador_padrao a ";
        $sql.="       inner join colaboradores c on a.colaboradores_pk = c.pk";
        $sql.="       inner join colaboradores_produtos_servicos cps on c.pk = cps.colaboradores_pk";
        $sql.="       inner join produtos_servicos ps on cps.produtos_servicos_pk = ps.pk";
        $sql.="       left join turnos t_dom on a.dom_turnos_pk = t_dom.pk";
        $sql.="       left join turnos t_seg on a.seg_turnos_pk = t_seg.pk";
        $sql.="       left join turnos t_ter on a.ter_turnos_pk = t_ter.pk";
        $sql.="       left join turnos t_qua on a.qua_turnos_pk = t_qua.pk";
        $sql.="       left join turnos t_qui on a.qui_turnos_pk = t_qui.pk";
        $sql.="       left join turnos t_sex on a.sex_turnos_pk = t_sex.pk";
        $sql.="       left join turnos t_sab on a.sab_turnos_pk = t_sab.pk";
        $sql.="       inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.="       inner join leads l on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk=".$leads_pk;
        }
        if($dt_agenda!=""){

            $sql.=" and a.dt_inicio_agenda <= '".DataYMD($dt_agenda)."'";
            $sql.=" and a.dt_fim_agenda >='".DataYMD($dt_agenda)."'";
        }
        if($dia_semana==0){
            $sql.=" and a.ic_dom =1";
        }
        else if($dia_semana==1){
            $sql.=" and a.ic_seg =1";
        }
        else if($dia_semana==2){
            $sql.=" and a.ic_ter =1";
        }
        else if($dia_semana==3){
            
            $sql.=" and a.ic_qua =1";
        }
        else if($dia_semana==4){
            $sql.=" and a.ic_qui =1";
        }
        else if($dia_semana==5){
            $sql.=" and a.ic_sex =1";
        }
        else if($dia_semana==6){
            $sql.=" and a.ic_sab =1";
        }
        $sql.=" and c.pk NOT IN (SELECT acp.colaboradores_pk FROM agenda_colaborador_pausa acp where acp.dt_inicio_pausa ='".DataYMD($dt_agenda)."'";
        if($dia_semana==0){
            $sql.=" and acp.turnos_pk = t_dom.pk ";
        }
        else if($dia_semana==1){
            $sql.=" and acp.turnos_pk = t_seg.pk";
        }
        else if($dia_semana==2){
            $sql.=" and acp.turnos_pk = t_ter.pk";
        }
        else if($dia_semana==3){
            
           $sql.=" and acp.turnos_pk = t_qua.pk";
        }
        else if($dia_semana==4){
           $sql.=" and acp.turnos_pk = t_qui.pk";
        }
        else if($dia_semana==5){
            $sql.=" and acp.turnos_pk = t_sex.pk";
        }
        else if($dia_semana==6){
            $sql.=" and acp.turnos_pk = t_sab.pk";
        }
        
        $sql.=")";
        $sql.=" order by a.dt_inicio_agenda asc "; 
       
      
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
   public function rel_agenda_lead($leads_pk,$dt_base){
        
        
        $sql ="";
        $sql.="SELECT  (ci.n_qtde) n_itens_contratados,";
        $sql.="         ps.ds_produto_servico,";
        $sql.="         ps.pk produtos_servicos_pk,";
        $sql.="         ci.n_qtde_dias_semana";
        $sql.="   FROM leads l";
        $sql.=" INNER JOIN processos p ON p.leads_pk = l.pk";
        $sql.=" INNER JOIN processos_etapas pe ON pe.processos_pk = p.pk";
        $sql.=" INNER JOIN contratos c ON c.processos_etapas_pk = pe.pk";
        $sql.=" INNER JOIN contratos_itens ci ON ci.contratos_pk = c.pk";
        $sql.=" INNER JOIN produtos_servicos ps ON ci.produtos_servicos_pk = ps.pk";
        $sql.="  where ps.pk = ci.produtos_servicos_pk  and c.pk = ci.contratos_pk ";
        $sql.=" AND l.pk =".$leads_pk;
        $sql.=" AND c.dt_inicio_contrato <= '".DataYMD($dt_base)."'";
        $sql.=" AND c.dt_fim_contrato >= '".DataYMD($dt_base)."'";
       
      
        
      
      
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function rel_agenda_lead_qtde_profissiomais($leads_pk,$dt_base,$produtos_servicos_pk,$qtde_dia_semana){
        
        $sql ="";
        $sql.=" SELECT COUNT(DISTINCT c.pk)qtde_profissionais";
        $sql.="   FROM agenda_colaborador_padrao acp";
        $sql.="        INNER JOIN colaboradores c ON acp.colaboradores_pk = c.pk";
        $sql.="        INNER JOIN colaboradores_produtos_servicos cps ON c.pk = cps.colaboradores_pk";
        $sql.="        INNER JOIN processos_etapas pes ON pes.pk = acp.processos_etapas_pk";
        $sql.="        INNER JOIN processos pse ON pes.processos_pk = pse.pk";
        $sql.="  WHERE pse.leads_pk =".$leads_pk;
        $sql.="        AND acp.dt_inicio_agenda <='".DataYMD($dt_base)."'";
        $sql.="        AND acp.dt_fim_agenda >= '".DataYMD($dt_base)."'"; 
        $sql.="       and c.pk NOT IN (SELECT acp.colaboradores_pk FROM agenda_colaborador_pausa acp where acp.dt_inicio_pausa ='".DataYMD($dt_base)."')";
        if($qtde_dia_semana==7){
            $sql.="        group by acp.pk";
        
            $sql.="        having SUM(CASE acp.ic_dom";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_seg";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_ter";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_qua";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_qui";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_sex";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END + CASE acp.ic_sab";
            $sql.="                   WHEN 1 THEN 1";
            $sql.="                   ELSE 0";
            $sql.="                   END)=".$qtde_dia_semana;
        }
        $sql.="      order by c.pk";
     
      
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
      
    
    public function rel_agenda_colaborador($colaboradores_pk,$dt_base,$dia_semana){
        
        
        $sql ="";
        $sql.="select l.ds_lead";
	$sql.="       ,a.ic_dom";
        $sql.="       ,a.ic_seg";
        $sql.="       ,a.ic_ter";
        $sql.="       ,a.ic_qua";
        $sql.="       ,a.ic_qui";
        $sql.="       ,a.ic_sex";
        $sql.="       ,a.ic_sab";
        $sql.="       ,a.dom_turnos_pk";
        $sql.="       ,a.seg_turnos_pk";
        $sql.="       ,a.ter_turnos_pk";
        $sql.="       ,a.qua_turnos_pk";
        $sql.="       ,a.qui_turnos_pk";
        $sql.="       ,a.sex_turnos_pk";
        $sql.="       ,a.sab_turnos_pk";
        $sql.="       ,t_dom.ds_turno ds_turno_dom";
        $sql.="       ,t_seg.ds_turno ds_turno_seg";
        $sql.="       ,t_ter.ds_turno ds_turno_ter";
        $sql.="       ,t_qua.ds_turno ds_turno_qua";
        $sql.="       ,t_qui.ds_turno ds_turno_qui";
        $sql.="       ,t_sex.ds_turno ds_turno_sex";
        $sql.="       ,t_sab.ds_turno ds_turno_sab";
	$sql.="  from agenda_colaborador_padrao a";
        $sql.="       inner join colaboradores c on a.colaboradores_pk = c.pk";
	$sql.="       left join turnos t_dom on a.dom_turnos_pk = t_dom.pk";
        $sql.="       left join turnos t_seg on a.seg_turnos_pk = t_seg.pk";
        $sql.="       left join turnos t_ter on a.ter_turnos_pk = t_ter.pk";
        $sql.="       left join turnos t_qua on a.qua_turnos_pk = t_qua.pk";
        $sql.="       left join turnos t_qui on a.qui_turnos_pk = t_qui.pk";
        $sql.="       left join turnos t_sex on a.sex_turnos_pk = t_sex.pk";
        $sql.="       left join turnos t_sab on a.sab_turnos_pk = t_sab.pk";
	$sql.="       inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
	$sql.="       inner join processos p on pe.processos_pk = p.pk";
	$sql.="	      inner join leads l on p.leads_pk = l.pk";
	$sql.="	where 1= 1";
	$sql.="	      and a.colaboradores_pk =".$colaboradores_pk;
	$sql.="	      AND a.dt_inicio_agenda <= '".DataYMD($dt_base)."'";
	$sql.="	      AND a.dt_fim_agenda >= '".DataYMD($dt_base)."'";
        if($dia_semana==0){
            $sql.=" and a.ic_dom =1";
        }
        else if($dia_semana==1){
            $sql.=" and a.ic_seg =1";
        }
        else if($dia_semana==2){
            $sql.=" and a.ic_ter =1";
        }
        else if($dia_semana==3){
            
            $sql.=" and a.ic_qua =1";
        }
        else if($dia_semana==4){
            $sql.=" and a.ic_qui =1";
        }
        else if($dia_semana==5){
            $sql.=" and a.ic_sex =1";
        }
        else if($dia_semana==6){
            $sql.=" and a.ic_sab =1";
        }
        $sql.="       and c.pk NOT IN (SELECT acp.colaboradores_pk FROM agenda_colaborador_pausa acp where acp.dt_inicio_pausa ='".DataYMD($dt_base)."'";
        if($dia_semana==0){
            $sql.=" and acp.turnos_pk = t_dom.pk ";
        }
        else if($dia_semana==1){
            $sql.=" and acp.turnos_pk = t_seg.pk";
        }
        else if($dia_semana==2){
            $sql.=" and acp.turnos_pk = t_ter.pk";
        }
        else if($dia_semana==3){
            
           $sql.=" and acp.turnos_pk = t_qua.pk";
        }
        else if($dia_semana==4){
           $sql.=" and acp.turnos_pk = t_qui.pk";
        }
        else if($dia_semana==5){
            $sql.=" and acp.turnos_pk = t_sex.pk";
        }
        else if($dia_semana==6){
            $sql.=" and acp.turnos_pk = t_sab.pk";
        }
        
        $sql.=")";


        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_agenda_colaborador_data($colaborador_pk,$dt_base,$dia_semana){
        
        
        $sql ="";
        $sql.="select a.pk, a.dt_cadastro, a.usuario_cadastro_pk, a.dt_ult_atualizacao, a.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(a.dt_inicio_agenda,'%d/%m/%Y') dt_inicio_agenda";
        $sql.="       ,date_format(a.dt_fim_agenda,'%d/%m/%Y') dt_fim_agenda";
        $sql.="       ,a.ds_agenda";
        $sql.="       ,a.processos_etapas_pk ";
        $sql.="       ,a.colaboradores_pk ";
        $sql.="       ,a.ic_dom";
        $sql.="       ,a.ic_seg";
        $sql.="       ,a.ic_ter";
        $sql.="       ,a.ic_qua";
        $sql.="       ,a.ic_qui";
        $sql.="       ,a.ic_sex";
        $sql.="       ,a.ic_sab";
        $sql.="       ,a.dom_turnos_pk";
        $sql.="       ,a.seg_turnos_pk";
        $sql.="       ,a.ter_turnos_pk";
        $sql.="       ,a.qua_turnos_pk";
        $sql.="       ,a.qui_turnos_pk";
        $sql.="       ,a.sex_turnos_pk";
        $sql.="       ,a.sab_turnos_pk";
        $sql.="       ,t_dom.ds_turno ds_turno_dom";
        $sql.="       ,t_seg.ds_turno ds_turno_seg";
        $sql.="       ,t_ter.ds_turno ds_turno_ter";
        $sql.="       ,t_qua.ds_turno ds_turno_qua";
        $sql.="       ,t_qui.ds_turno ds_turno_qui";
        $sql.="       ,t_sex.ds_turno ds_turno_sex";
        $sql.="       ,t_sab.ds_turno ds_turno_sab";
        //$sql.="       ,d.ds_dia_semana";
        //$sql.="       ,t.ds_turno";
        //$sql.="       ,concat(l.ds_lead,' -> ',t.ds_turno)ds_lead";
        $sql.="       ,l.ds_lead condominio";
        $sql.="       ,l.pk leads_pk ";
        $sql.="       ,ps.ds_produto_servico";
        $sql.="  from agenda_colaborador_padrao a ";
        $sql.="       inner join colaboradores c on a.colaboradores_pk = c.pk";
        $sql.="       inner join colaboradores_produtos_servicos cps on c.pk = cps.colaboradores_pk";
        $sql.="       inner join produtos_servicos ps on cps.produtos_servicos_pk = ps.pk";
        $sql.="       left join turnos t_dom on a.dom_turnos_pk = t_dom.pk";
        $sql.="       left join turnos t_seg on a.seg_turnos_pk = t_seg.pk";
        $sql.="       left join turnos t_ter on a.ter_turnos_pk = t_ter.pk";
        $sql.="       left join turnos t_qua on a.qua_turnos_pk = t_qua.pk";
        $sql.="       left join turnos t_qui on a.qui_turnos_pk = t_qui.pk";
        $sql.="       left join turnos t_sex on a.sex_turnos_pk = t_sex.pk";
        $sql.="       left join turnos t_sab on a.sab_turnos_pk = t_sab.pk";
        $sql.="       inner join processos_etapas pe on a.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.="       inner join leads l on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($colaborador_pk!=""){
            $sql.=" and c.pk=".$colaborador_pk;
        }
        if($dia_semana==0){
            $sql.=" and a.ic_dom =1";
        }
        else if($dia_semana==1){
            $sql.=" and a.ic_seg =1";
        }
        else if($dia_semana==2){
            $sql.=" and a.ic_ter =1";
        }
        else if($dia_semana==3){
            
            $sql.=" and a.ic_qua =1";
        }
        else if($dia_semana==4){
            $sql.=" and a.ic_qui =1";
        }
        else if($dia_semana==5){
            $sql.=" and a.ic_sex =1";
        }
        else if($dia_semana==6){
            $sql.=" and a.ic_sab =1";
        }

        $sql.=" and a.dt_inicio_agenda <= '".DataYMD($dt_base)." '";
        $sql.=" and a.dt_fim_agenda >='".DataYMD($dt_base)." '";
        $sql.=" and c.pk NOT IN (SELECT acp.colaboradores_pk FROM agenda_colaborador_pausa acp where acp.dt_inicio_pausa ='".DataYMD($dt_base)."'";
        if($dia_semana==0){
            $sql.=" and acp.turnos_pk = t_dom.pk ";
        }
        else if($dia_semana==1){
            $sql.=" and acp.turnos_pk = t_seg.pk";
        }
        else if($dia_semana==2){
            $sql.=" and acp.turnos_pk = t_ter.pk";
        }
        else if($dia_semana==3){
            
           $sql.=" and acp.turnos_pk = t_qua.pk";
        }
        else if($dia_semana==4){
           $sql.=" and acp.turnos_pk = t_qui.pk";
        }
        else if($dia_semana==5){
            $sql.=" and acp.turnos_pk = t_sex.pk";
        }
        else if($dia_semana==6){
            $sql.=" and acp.turnos_pk = t_sab.pk";
        }
        
        $sql.=")";
        $sql.=" order by a.dt_inicio_agenda asc "; 
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_data($dt_agenda){

        $sql ="";
        $sql.="select date_format('".  DataYMD($dt_agenda)."','%w')dia_semana";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
