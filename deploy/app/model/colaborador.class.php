<?

class colaborador{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_colaborador;
    private $ds_cel;
    private $ic_whatsapp;
    private $ds_cel2;
    private $ic_whatsapp2;
    private $ds_cel3;
    private $ic_whatsapp3;
    private $ds_email;
    private $ds_rg;
    private $ds_cpf;
    private $dt_nascimento;
    private $ds_endereco;
    private $ds_numero;
    private $ds_complemento;
    private $ds_bairro;
    private $ds_cep;
    private $ds_cidade;
    private $ds_uf;
    private $ic_status;
    private $ic_funcionario;
    private $generos_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_colaborador = null;
        $this->ds_cel = null;
        $this->ic_whatsapp = null;
        $this->ds_cel2 = null;
        $this->ic_whatsapp2 = null;
        $this->ds_cel3 = null;
        $this->ic_whatsapp3 = null;
        $this->ds_email = null;
        $this->ds_rg = null;
        $this->ds_cpf = null;
        $this->dt_nascimento = null;
        $this->ds_endereco = null;
        $this->ds_numero = null;
        $this->ds_complemento = null;
        $this->ds_bairro = null;
        $this->ds_cep = null;
        $this->ds_cidade = null;
        $this->ds_uf = null;
        $this->ic_status = null;
        $this->ic_funcionario = null;
        $this->generos_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_colaborador(){return $this->ds_colaborador;}
    function getds_cel(){return $this->ds_cel;}
    function getic_whatsapp(){return $this->ic_whatsapp;}
    function getds_cel2(){return $this->ds_cel2;}
    function getic_whatsapp2(){return $this->ic_whatsapp2;}
    function getds_cel3(){return $this->ds_cel3;}
    function getic_whatsapp3(){return $this->ic_whatsapp3;}
    function getds_email(){return $this->ds_email;}
    function getds_rg(){return $this->ds_rg;}
    function getds_cpf(){return $this->ds_cpf;}
    function getdt_nascimento(){return $this->dt_nascimento;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_numero(){return $this->ds_numero;}
    function getds_complemento(){return $this->ds_complemento;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cep(){return $this->ds_cep;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getic_status(){return $this->ic_status;}
    function getic_funcionario(){return $this->ic_funcionario;}
    function getgeneros_pk(){return $this->generos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_colaborador($ds_colaborador){ $this->ds_colaborador = $ds_colaborador;}
    function setds_cel($ds_cel){ $this->ds_cel = $ds_cel;}
    function setic_whatsapp($ic_whatsapp){ $this->ic_whatsapp = $ic_whatsapp;}
    function setds_cel2($ds_cel2){ $this->ds_cel2 = $ds_cel2;}
    function setic_whatsapp2($ic_whatsapp2){ $this->ic_whatsapp2 = $ic_whatsapp2;}
    function setds_cel3($ds_cel3){ $this->ds_cel3 = $ds_cel3;}
    function setic_whatsapp3($ic_whatsapp3){ $this->ic_whatsapp3 = $ic_whatsapp3;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function setds_rg($ds_rg){ $this->ds_rg = $ds_rg;}
    function setds_cpf($ds_cpf){ $this->ds_cpf = $ds_cpf;}
    function setdt_nascimento($dt_nascimento){ $this->dt_nascimento = $dt_nascimento;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_complemento($ds_complemento){ $this->ds_complemento = $ds_complemento;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cep($ds_cep){ $this->ds_cep = $ds_cep;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setic_funcionario($ic_funcionario){ $this->ic_funcionario = $ic_funcionario;}
    function setgeneros_pk($generos_pk){ $this->generos_pk = $generos_pk;}

    
}

?>
