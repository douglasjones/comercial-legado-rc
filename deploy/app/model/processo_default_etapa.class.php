<?

class processo_default_etapa{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_processo_default_etapa;
    private $n_ordem_etapa;
    private $processos_default_pk;
    private $tipos_ocorrencias_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_processo_default_etapa = null;
        $this->n_ordem_etapa = null;
        $this->processos_default_pk = null;
        $this->tipos_ocorrencias_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_processo_default_etapa(){return $this->ds_processo_default_etapa;}
    function getn_ordem_etapa(){return $this->n_ordem_etapa;}
    function getprocessos_default_pk(){return $this->processos_default_pk;}
    function gettipos_ocorrencias_pk(){return $this->tipos_ocorrencias_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_processo_default_etapa($ds_processo_default_etapa){ $this->ds_processo_default_etapa = $ds_processo_default_etapa;}
    function setn_ordem_etapa($n_ordem_etapa){ $this->n_ordem_etapa = $n_ordem_etapa;}
    function setprocessos_default_pk($processos_default_pk){ $this->processos_default_pk = $processos_default_pk;}
    function settipos_ocorrencias_pk($tipos_ocorrencias_pk){ $this->tipos_ocorrencias_pk = $tipos_ocorrencias_pk;}

    
}

?>
