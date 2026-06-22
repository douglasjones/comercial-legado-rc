<?

class agenda_colaborador_padrao{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_agenda;
    private $dt_inicio_agenda;
    private $dt_fim_agenda;
    private $colaboradores_pk;
    private $processos_etapas_pk;
    private $ic_dom;
    private $ic_seg;
    private $ic_ter;
    private $ic_qua;
    private $ic_qui;
    private $ic_sex;
    private $ic_sab;
    private $dom_turnos_pk;
    private $seg_turnos_pk;
    private $ter_turnos_pk;
    private $qua_turnos_pk;
    private $qui_turnos_pk;
    private $sex_turnos_pk;
    private $sab_turnos_pk;
    private $contratos_itens_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_agenda = null;
        $this->dt_inicio_agenda = null;
        $this->dt_fim_agenda = null;
        $this->colaboradores_pk = null;
        $this->processos_etapas_pk = null;
        $this->produtos_servicos_pk = null;
        $this->ic_dom = null;
        $this->ic_seg = null;
        $this->ic_ter = null;
        $this->ic_qua = null;
        $this->ic_qui = null;
        $this->ic_sex = null;
        $this->ic_sab = null;
        $this->dom_turnos_pk = null;
        $this->seg_turnos_pk = null;
        $this->ter_turnos_pk = null;
        $this->qua_turnos_pk = null;
        $this->qui_turnos_pk = null;
        $this->sex_turnos_pk = null;
        $this->sab_turnos_pk = null;
        $this->contratos_itens_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_agenda(){return $this->ds_agenda;}
    function getdt_inicio_agenda(){return $this->dt_inicio_agenda;}
    function getdt_fim_agenda(){return $this->dt_fim_agenda;}
    function getcolaboradores_pk(){return $this->colaboradores_pk;}
    function getprocessos_etapas_pk(){return $this->processos_etapas_pk;}
    function getic_dom(){return $this->ic_dom;}
    function getic_seg(){return $this->ic_seg;}
    function getic_ter(){return $this->ic_ter;}
    function getic_qua(){return $this->ic_qua;}
    function getic_qui(){return $this->ic_qui;}
    function getic_sex(){return $this->ic_sex;}
    function getic_sab(){return $this->ic_sab;}
    function getdom_turnos_pk(){return $this->dom_turnos_pk;}
    function getseg_turnos_pk(){return $this->seg_turnos_pk;}
    function getter_turnos_pk(){return $this->ter_turnos_pk;}
    function getqua_turnos_pk(){return $this->qua_turnos_pk;}
    function getqui_turnos_pk(){return $this->qui_turnos_pk;}
    function getsex_turnos_pk(){return $this->sex_turnos_pk;}
    function getsab_turnos_pk(){return $this->sab_turnos_pk;}
    function getcontratos_itens_pk(){return $this->contratos_itens_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_agenda($ds_agenda){ $this->ds_agenda = $ds_agenda;}
    function setdt_inicio_agenda($dt_inicio_agenda){ $this->dt_inicio_agenda = $dt_inicio_agenda;}
    function setdt_fim_agenda($dt_fim_agenda){ $this->dt_fim_agenda = $dt_fim_agenda;}
    function setcolaboradores_pk($colaboradores_pk){ $this->colaboradores_pk = $colaboradores_pk;}
    function setprocessos_etapas_pk($processos_etapas_pk){ $this->processos_etapas_pk = $processos_etapas_pk;}
    function setic_dom($ic_dom){ $this->ic_dom = $ic_dom;}
    function setic_seg($ic_seg){ $this->ic_seg = $ic_seg;}
    function setic_ter($ic_ter){ $this->ic_ter = $ic_ter;}
    function setic_qua($ic_qua){ $this->ic_qua = $ic_qua;}
    function setic_qui($ic_qui){ $this->ic_qui = $ic_qui;}
    function setic_sex($ic_sex){ $this->ic_sex = $ic_sex;}
    function setic_sab($ic_sab){ $this->ic_sab = $ic_sab;}
    function setdom_turnos_pk($dom_turnos_pk){ $this->dom_turnos_pk = $dom_turnos_pk;}
    function setseg_turnos_pk($seg_turnos_pk){ $this->seg_turnos_pk = $seg_turnos_pk;}
    function setter_turnos_pk($ter_turnos_pk){ $this->ter_turnos_pk = $ter_turnos_pk;}
    function setqua_turnos_pk($qua_turnos_pk){ $this->qua_turnos_pk = $qua_turnos_pk;}
    function setqui_turnos_pk($qui_turnos_pk){ $this->qui_turnos_pk = $qui_turnos_pk;}
    function setsex_turnos_pk($sex_turnos_pk){ $this->sex_turnos_pk = $sex_turnos_pk;}
    function setsab_turnos_pk($sab_turnos_pk){ $this->sab_turnos_pk = $sab_turnos_pk;}
    function setcontratos_itens_pk($contratos_itens_pk){ $this->contratos_itens_pk = $contratos_itens_pk;}

    
}

?>
