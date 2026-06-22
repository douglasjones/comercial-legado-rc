<?

class polo{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_polo;
    private $dt_cancelamento;
    private $ic_status;
    private $segmentos_pk;
    private $contas_pk;
    private $ds_cep;
    private $ds_endereco;
    private $ds_numero;
    private $ds_complemento;
    private $ds_bairro;
    private $ds_cidade;
    private $ds_uf;
    private $responsavel_pk;
    private $ds_tel;
    private $ds_cel;
    private $ds_site;
    private $ds_email;
    
    private $dia_vencimento;
    private $planos_pk;
    private $tipo_pagamentos_pk;
    private $n_cartao;
    private $ds_vencimento_cartao;
    private $ds_nome_cartao;
    private $bandeira_cartao_pk;
    private $ds_email_financeiro;  
   
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_polo = null;
        $this->dt_cancelamento = null;
        $this->ic_status = null;
        $this->segmentos_pk = null;
        $this->contas_pk = null;
        $this->ds_cep = null;
        $this->ds_endereco = null;
        $this->ds_numero = null;
        $this->ds_complemento = null;
        $this->ds_bairro = null;
        $this->ds_cidade = null;
        $this->ds_uf = null;
        $this->responsavel_pk = null;
        $this->ds_tel = null;
        $this->ds_cel = null;
        $this->ds_site = null;
        $this->ds_email = null;
        
        $this->dia_vencimento = null;        
        $this->planos_pk = null;
        $this->tipo_pagamentos_pk = null;
        $this->n_cartao = null;
        $this->ds_vencimento_cartao = null;
        $this->ds_nome_cartao = null;
        $this->bandeira_cartao_pk = null;
        $this->ds_email_financeiro = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_polo(){return $this->ds_polo;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getic_status(){return $this->ic_status;}
    function getsegmentos_pk(){return $this->segmentos_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getds_cep(){return $this->ds_cep;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_numero(){return $this->ds_numero;}
    function getds_complemento(){return $this->ds_complemento;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getresponsavel_pk(){return $this->responsavel_pk;}
    function getds_tel(){return $this->ds_tel;}
    function getds_cel(){return $this->ds_cel;}
    function getds_site(){return $this->ds_site;}
    function getds_email(){return $this->ds_email;}
    
    function getdia_vencimento(){return $this->dia_vencimento;}
    function getplanos_pk(){return $this->planos_pk;}
    function gettipo_pagamentos_pk(){return $this->tipo_pagamentos_pk;}
    function getn_cartao(){return $this->n_cartao;}
    function getds_vencimento_cartao(){return $this->ds_vencimento_cartao;}
    function getds_nome_cartao(){return $this->ds_nome_cartao;}
    function getbandeira_cartao_pk(){return $this->bandeira_cartao_pk;}
    function getds_email_financeiro(){return $this->ds_email_financeiro;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_polo($ds_polo){ $this->ds_polo = $ds_polo;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setsegmentos_pk($segmentos_pk){ $this->segmentos_pk = $segmentos_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setds_cep($ds_cep){ $this->ds_cep = $ds_cep;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_complemento($ds_complemento){ $this->ds_complemento = $ds_complemento;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setresponsavel_pk($responsavel_pk){ $this->responsavel_pk = $responsavel_pk;}
    function setds_tel($ds_tel){ $this->ds_tel = $ds_tel;}
    function setds_cel($ds_cel){ $this->ds_cel = $ds_cel;}
    function setds_site($ds_site){ $this->ds_site = $ds_site;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    
    function setdia_vencimento($dia_vencimento){ $this->dia_vencimento = $dia_vencimento;}
    function setplanos_pk($planos_pk){ $this->planos_pk = $planos_pk;}
    function settipo_pagamentos_pk($tipo_pagamentos_pk){ $this->tipo_pagamentos_pk = $tipo_pagamentos_pk;}
    function setn_cartao($n_cartao){ $this->n_cartao = $n_cartao;}
    function setds_vencimento_cartao($ds_vencimento_cartao){ $this->ds_vencimento_cartao = $ds_vencimento_cartao;}
    function setds_nome_cartao($ds_nome_cartao){ $this->ds_nome_cartao = $ds_nome_cartao;}
    function setbandeira_cartao_pk($bandeira_cartao_pk){ $this->bandeira_cartao_pk = $bandeira_cartao_pk;}
    function setds_email_financeiro($ds_email_financeiro){ $this->ds_email_financeiro = $ds_email_financeiro;}    
}

?>
