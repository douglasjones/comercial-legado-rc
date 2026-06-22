<?

class conta_dados_cobranca{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dia_vencimento;
    private $n_qtde;
    private $vl_unit;
    private $vl_total;
    private $planos_pk;
    private $tipo_pagamentos_pk;
    private $n_cartao;
    private $ds_vencimento_cartao;
    private $ds_nome_cartao;
    private $bandeira_cartao_pk;
    private $ds_email_financeiro;
    private $dt_cancelamento;
    private $ic_status;
    private $contas_pk;
    private $planos_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dia_vencimento = null;
        $this->n_qtde = null;
        $this->vl_unit = null;
        $this->vl_total = null;
        $this->planos_pk = null;
        $this->tipo_pagamentos_pk = null;
        $this->n_cartao = null;
        $this->ds_vencimento_cartao = null;
        $this->ds_nome_cartao = null;
        $this->bandeira_cartao_pk = null;
        $this->ds_email_financeiro = null;
        $this->dt_cancelamento = null;
        $this->ic_status = null;
        $this->contas_pk = null;
        $this->planos_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdia_vencimento(){return $this->dia_vencimento;}
    function getn_qtde(){return $this->n_qtde;}
    function getvl_unit(){return $this->vl_unit;}
    function getvl_total(){return $this->vl_total;}
    function getplanos_pk(){return $this->planos_pk;}
    function gettipo_pagamentos_pk(){return $this->tipo_pagamentos_pk;}
    function getn_cartao(){return $this->n_cartao;}
    function getds_vencimento_cartao(){return $this->ds_vencimento_cartao;}
    function getds_nome_cartao(){return $this->ds_nome_cartao;}
    function getbandeira_cartao_pk(){return $this->bandeira_cartao_pk;}
    function getds_email_financeiro(){return $this->ds_email_financeiro;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getic_status(){return $this->ic_status;}
    function getcontas_pk(){return $this->contas_pk;}
    function getplanos_pk(){return $this->planos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setdia_vencimento($dia_vencimento){ $this->dia_vencimento = $dia_vencimento;}
    function setn_qtde($n_qtde){ $this->n_qtde = $n_qtde;}
    function setvl_unit($vl_unit){ $this->vl_unit = $vl_unit;}
    function setvl_total($vl_total){ $this->vl_total = $vl_total;}
    function setplanos_pk($planos_pk){ $this->planos_pk = $planos_pk;}
    function settipo_pagamentos_pk($tipo_pagamentos_pk){ $this->tipo_pagamentos_pk = $tipo_pagamentos_pk;}
    function setn_cartao($n_cartao){ $this->n_cartao = $n_cartao;}
    function setds_vencimento_cartao($ds_vencimento_cartao){ $this->ds_vencimento_cartao = $ds_vencimento_cartao;}
    function setds_nome_cartao($ds_nome_cartao){ $this->ds_nome_cartao = $ds_nome_cartao;}
    function setbandeira_cartao_pk($bandeira_cartao_pk){ $this->bandeira_cartao_pk = $bandeira_cartao_pk;}
    function setds_email_financeiro($ds_email_financeiro){ $this->ds_email_financeiro = $ds_email_financeiro;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setplanos_pk($planos_pk){ $this->planos_pk = $planos_pk;}

    
}

?>
