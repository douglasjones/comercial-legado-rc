<?

class proposta{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dt_inicio;
    private $dt_fim;
    private $n_versao;
    private $responsavel_pk;
    private $vl_total;
    private $ds_obs;
    private $dt_validade;
    private $dt_envio;
    private $dt_previsao_fechamento;
    private $dt_fechamento;
    private $dt_cancelamento;
    private $ds_obs_motivo_cancelamento;
    private $processos_etapas_pk;
    private $agendas_pk;
    private $operador_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dt_inicio = null;
        $this->dt_fim = null;
        $this->n_versao = null;
        $this->responsavel_pk = null;
        $this->vl_total = null;
        $this->ds_obs = null;
        $this->dt_validade = null;
        $this->dt_envio = null;
        $this->dt_previsao_fechamento = null;
        $this->dt_fechamento = null;
        $this->dt_cancelamento = null;
        $this->ds_obs_motivo_cancelamento = null;
        $this->processos_etapas_pk = null;
        $this->agendas_pk = null;
        $this->polos_pk = null;
        $this->leads_pk = null;
        $this->contas_pk = null;
        $this->operador_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdt_inicio(){return $this->dt_inicio;}
    function getdt_fim(){return $this->dt_fim;}
    function getn_versao(){return $this->n_versao;}
    function getresponsavel_pk(){return $this->responsavel_pk;}
    function getvl_total(){return $this->vl_total;}
    function getds_obs(){return $this->ds_obs;}
    function getdt_validade(){return $this->dt_validade;}
    function getdt_envio(){return $this->dt_envio;}
    function getdt_previsao_fechamento(){return $this->dt_previsao_fechamento;}
    function getdt_fechamento(){return $this->dt_fechamento;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getds_obs_motivo_cancelamento(){return $this->ds_obs_motivo_cancelamento;}
    function getprocessos_etapas_pk(){return $this->processos_etapas_pk;}
    function getagendas_pk(){return $this->agendas_pk;}
    function getpolos_pk(){return $this->polos_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getoperador_pk(){return $this->operador_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setdt_inicio($dt_inicio){ $this->dt_inicio = $dt_inicio;}
    function setdt_fim($dt_fim){ $this->dt_fim = $dt_fim;}
    function setn_versao($n_versao){ $this->n_versao = $n_versao;}
    function setresponsavel_pk($responsavel_pk){ $this->responsavel_pk = $responsavel_pk;}
    function setvl_total($vl_total){ $this->vl_total = $vl_total;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setdt_validade($dt_validade){ $this->dt_validade = $dt_validade;}
    function setdt_envio($dt_envio){ $this->dt_envio = $dt_envio;}
    function setdt_previsao_fechamento($dt_previsao_fechamento){ $this->dt_previsao_fechamento = $dt_previsao_fechamento;}
    function setdt_fechamento($dt_fechamento){ $this->dt_fechamento = $dt_fechamento;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setds_obs_motivo_cancelamento($ds_obs_motivo_cancelamento){ $this->ds_obs_motivo_cancelamento = $ds_obs_motivo_cancelamento;}
    function setprocessos_etapas_pk($processos_etapas_pk){ $this->processos_etapas_pk = $processos_etapas_pk;}
    function setagendas_pk($agendas_pk){ $this->agendas_pk = $agendas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}

    
}

?>
