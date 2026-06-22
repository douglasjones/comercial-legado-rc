<?

class endereco{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_endereco_pk;
    private $ds_cep;
    private $ds_endereco;
    private $ds_numero;
    private $ds_complemento;
    private $ds_bairro;
    private $ds_cidade;
    private $ds_uf;
    private $leads_pk;
    private $contas_pk;
    private $polos_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_endereco_pk = null;
        $this->ds_cep = null;
        $this->ds_endereco = null;
        $this->ds_numero = null;
        $this->ds_complemento = null;
        $this->ds_bairro = null;
        $this->ds_cidade = null;
        $this->ds_uf = null;
        $this->leads_pk = null;
        $this->contas_pk = null;
        $this->polos_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_endereco_pk(){return $this->tipo_endereco_pk;}
    function getds_cep(){return $this->ds_cep;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_numero(){return $this->ds_numero;}
    function getds_complemento(){return $this->ds_complemento;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_endereco_pk($tipo_endereco_pk){ $this->tipo_endereco_pk = $tipo_endereco_pk;}
    function setds_cep($ds_cep){ $this->ds_cep = $ds_cep;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_complemento($ds_complemento){ $this->ds_complemento = $ds_complemento;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}

    
}

?>
