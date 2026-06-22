<?

class contrato{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dt_inicio_contrato;
    private $dt_fim_contrato;
    private $processos_etapas_pk;
    private $ic_tipo_contrato;
    private $contratos_pk;
    private $contas_pk;
    private $polos_pk;
    private $propostas_pk;
    private $responsavel_pk;
    private $operador_pk;
    private $ds_numero_pedido_operador;
    private $ds_obs;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dt_inicio_contrato = null;
        $this->dt_fim_contrato = null;
        $this->processos_etapas_pk = null;
        $this->ic_tipo_contrato = null;
        $this->contratos_pk = null;
        $this->contas_pk = null;
        $this->polos_pk = null;
        $this->propostas_pk = null;
        $this->responsavel_pk = null;
        $this->operador_pk = null;
        $this->ds_numero_pedido_operador = null;
        $this->ds_obs = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdt_inicio_contrato(){return $this->dt_inicio_contrato;}
    function getdt_fim_contrato(){return $this->dt_fim_contrato;}
    function getprocessos_etapas_pk(){return $this->processos_etapas_pk;}
    function getic_tipo_contrato(){return $this->ic_tipo_contrato;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}
    function getpropostas_pk(){return $this->propostas_pk;}
    function getresponsavel_pk(){return $this->responsavel_pk;}
    function getoperador_pk(){return $this->operador_pk;}
    function getds_numero_pedido_operador(){return $this->ds_numero_pedido_operador;}
    function getds_obs(){return $this->ds_obs;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    public function setic_tipo_contrato($ic_tipo_contrato){$this->ic_tipo_contrato = $ic_tipo_contrato;}
    
    function setdt_inicio_contrato($dt_inicio_contrato){ $this->dt_inicio_contrato = $dt_inicio_contrato;}
    function setdt_fim_contrato($dt_fim_contrato){ $this->dt_fim_contrato = $dt_fim_contrato;}
    function setprocessos_etapas_pk($processos_etapas_pk){ $this->processos_etapas_pk = $processos_etapas_pk;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setpropostas_pk($propostas_pk){ $this->propostas_pk = $propostas_pk;}
    function setresponsavel_pk($responsavel_pk){ $this->responsavel_pk = $responsavel_pk;}
    function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
    function setds_numero_pedido_operador($ds_numero_pedido_operador){ $this->ds_numero_pedido_operador = $ds_numero_pedido_operador;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}

    
}

?>
