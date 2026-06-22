<?

class conta{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_tipo_pessoa;
    private $ds_conta;
    private $ds_razao_social;
    private $ds_cpf_cnpj;
    private $ds_cnae;
    private $ds_rg;
    private $ds_ddd;
    private $ds_tel;
    private $ds_ddd_cel;
    private $ds_email;
    private $ds_cel;
    private $ds_cep;
    private $ds_endereco;
    private $ds_numero;
    private $ds_complemento;
    private $ds_bairro;
    private $ds_cidade;
    private $ds_uf;
    private $segmentos_pk;
    private $dt_ativacao;
    private $dt_cancelamento;
    private $ic_status;
  
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_tipo_pessoa = null;
        $this->ds_conta = null;
        $this->ds_razao_social = null;
        $this->ds_cpf_cnpj = null;
        $this->ds_cnae = null;
        $this->ds_rg = null;
        $this->ds_ddd = null;
        $this->ds_tel = null;
        $this->ds_ddd_cel = null;
        $this->ds_email = null;
        $this->ds_cel = null;
        $this->ds_cep = null;
        $this->ds_endereco = null;
        $this->ds_numero = null;
        $this->ds_complemento = null;
        $this->ds_bairro = null;
        $this->ds_cidade = null;
        $this->ds_uf = null;
        $this->segmentos_pk = null;
        $this->dt_ativacao = null;
        $this->dt_cancelamento = null;
        $this->ic_status = null;
        
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_tipo_pessoa(){return $this->ds_tipo_pessoa;}
    function getds_conta(){return $this->ds_conta;}
    function getds_razao_social(){return $this->ds_razao_social;}
    function getds_cpf_cnpj(){return $this->ds_cpf_cnpj;}
    function getds_cnae(){return $this->ds_cnae;}
    function getds_rg(){return $this->ds_rg;}
    function getds_ddd(){return $this->ds_ddd;}
    function getds_tel(){return $this->ds_tel;}
    function getds_ddd_cel(){return $this->ds_ddd_cel;}
    function getds_email(){return $this->ds_email;}
    function getds_cel(){return $this->ds_cel;}
    function getds_cep(){return $this->ds_cep;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_numero(){return $this->ds_numero;}
    function getds_complemento(){return $this->ds_complemento;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getsegmentos_pk(){return $this->segmentos_pk;}
    function getdt_ativacao(){return $this->dt_ativacao;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getic_status(){return $this->ic_status;}
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_tipo_pessoa($ds_tipo_pessoa){ $this->ds_tipo_pessoa = $ds_tipo_pessoa;}
    function setds_conta($ds_conta){ $this->ds_conta = $ds_conta;}
    function setds_razao_social($ds_razao_social){ $this->ds_razao_social = $ds_razao_social;}
    function setds_cpf_cnpj($ds_cpf_cnpj){ $this->ds_cpf_cnpj = $ds_cpf_cnpj;}
    function setds_cnae($ds_cnae){ $this->ds_cnae = $ds_cnae;}
    function setds_rg($ds_rg){ $this->ds_rg = $ds_rg;}
    function setds_ddd($ds_ddd){ $this->ds_ddd = $ds_ddd;}
    function setds_tel($ds_tel){ $this->ds_tel = $ds_tel;}
    function setds_ddd_cel($ds_ddd_cel){ $this->ds_ddd_cel = $ds_ddd_cel;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function setds_cel($ds_cel){ $this->ds_cel = $ds_cel;}
    function setds_cep($ds_cep){ $this->ds_cep = $ds_cep;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_complemento($ds_complemento){ $this->ds_complemento = $ds_complemento;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setsegmentos_pk($segmentos_pk){ $this->segmentos_pk = $segmentos_pk;}
    function setdt_ativacao($dt_ativacao){ $this->dt_ativacao = $dt_ativacao;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    
}

?>
