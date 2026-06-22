<?

class processo{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_processo;
    private $processos_default_pk;
    private $leads_pk;
    private $contas_pk;
    private $polos_pk;
    private $dt_fim;
    private $dt_cancelamento;
    private $motivo_cancelamento_processo_pk;
    private $ds_motivo_cancelamento;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_processo = null;
        $this->processos_default_pk = null;
        $this->leads_pk = null;
        $this->contas_pk = null;
        $this->polos_pk = null;
        $this->dt_fim = null;
        $this->dt_cancelamento = null;
        $this->motivo_cancelamento_processo_pk = null;
        $this->ds_motivo_cancelamento = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_processo(){return $this->ds_processo;}
    function getprocessos_default_pk(){return $this->processos_default_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}
    function getdt_fim(){return $this->dt_fim;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getmotivo_cancelamento_processo_pk(){return $this->motivo_cancelamento_processo_pk;}
    function getds_motivo_cancelamento(){return $this->ds_motivo_cancelamento;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_processo($ds_processo){ $this->ds_processo = $ds_processo;}
    function setprocessos_default_pk($processos_default_pk){ $this->processos_default_pk = $processos_default_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk= $leads_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk= $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk= $polos_pk;}
    function setdt_fim($dt_fim){ $this->dt_fim= $dt_fim;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento= $dt_cancelamento;}
    function setmotivo_cancelamento_processo_pk($motivo_cancelamento_processo_pk){ $this->motivo_cancelamento_processo_pk= $motivo_cancelamento_processo_pk;}
    function setds_motivo_cancelamento($ds_motivo_cancelamento){ $this->ds_motivo_cancelamento= $ds_motivo_cancelamento;}
    
}

?>
