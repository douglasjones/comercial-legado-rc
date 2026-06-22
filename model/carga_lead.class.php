<?

class carga_lead{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_pessoa_pk;
    private $ds_lead;
    private $ds_razao_social;
    private $ds_cpf_cnpj;
    private $ds_ie;
    private $ds_rg;
    private $ds_cnae;
    private $ic_cliente;
    private $ds_site;
    private $ds_obs;
    private $mailing_pk;
    private $tipo_telefone_pk;
    private $tipo_telefone_pk1;
    private $ds_ddd;
    private $ds_tel;
    private $ds_ddd1;
    private $ds_tel1;
    private $tipo_endereco_pk;
    private $ds_endereco;
    private $ds_numero;
    private $ds_complmento;
    private $ds_bairro;
    private $ds_cidade;
    private $ds_uf;
    private $ds_contato;
    private $ds_cel_contato;
    private $ds_tel_contato;
    private $ds_email_contato;
    private $ds_contato1;
    private $ds_cel_contato1;
    private $ds_tel_contato1;
    private $contas_pk;
    private $polos_pk;
    private $dt_sinconizacao;
    private $ic_status;
    private $arquivo;
    private $ds_email_contato1;
    private $grupos_pk;
    private $usuarios_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_pessoa_pk = null;
        $this->ds_lead = null;
        $this->ds_razao_social = null;
        $this->ds_cpf_cnpj = null;
        $this->ds_ie = null;
        $this->ds_rg = null;
        $this->ds_cnae = null;
        $this->ic_cliente = null;
        $this->ds_site = null;
        $this->ds_obs = null;
        $this->mailing_pk = null;
        $this->tipo_telefone_pk = null;
        $this->tipo_telefone_pk1 = null;
        $this->ds_ddd = null;
        $this->ds_tel = null;
        $this->ds_ddd1 = null;
        $this->ds_tel1 = null;
        $this->tipo_endereco_pk = null;
        $this->ds_endereco = null;
        $this->ds_numero = null;
        $this->ds_complmento = null;
        $this->ds_bairro = null;
        $this->ds_cidade = null;
        $this->ds_uf = null;
        $this->ds_contato = null;
        $this->ds_cel_contato = null;
        $this->ds_tel_contato = null;
        $this->ds_email_contato = null;
        $this->ds_contato1 = null;
        $this->ds_cel_contato1 = null;
        $this->ds_tel_contato1 = null;
        $this->contas_pk = null;
        $this->polos_pk = null;
        $this->dt_sinconizacao = null;
        $this->ic_status = null;
        $this->arquivo = null;
        $this->ds_email_contato1 = null;
        $this->grupos_pk = null;
        $this->usuarios_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_pessoa_pk(){return $this->tipo_pessoa_pk;}
    function getds_lead(){return $this->ds_lead;}
    function getds_razao_social(){return $this->ds_razao_social;}
    function getds_cpf_cnpj(){return $this->ds_cpf_cnpj;}
    function getds_ie(){return $this->ds_ie;}
    function getds_rg(){return $this->ds_rg;}
    function getds_cnae(){return $this->ds_cnae;}
    function getic_cliente(){return $this->ic_cliente;}
    function getds_site(){return $this->ds_site;}
    function getds_obs(){return $this->ds_obs;}
    function getmailing_pk(){return $this->mailing_pk;}
    function gettipo_telefone_pk(){return $this->tipo_telefone_pk;}
    function gettipo_telefone_pk1(){return $this->tipo_telefone_pk1;}
    function getds_ddd(){return $this->ds_ddd;}
    function getds_tel(){return $this->ds_tel;}
    function getds_ddd1(){return $this->ds_ddd1;}
    function getds_tel1(){return $this->ds_tel1;}
    function gettipo_endereco_pk(){return $this->tipo_endereco_pk;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_numero(){return $this->ds_numero;}
    function getds_complmento(){return $this->ds_complmento;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getds_contato(){return $this->ds_contato;}
    function getds_cel_contato(){return $this->ds_cel_contato;}
    function getds_tel_contato(){return $this->ds_tel_contato;}
    function getds_email_contato(){return $this->ds_email_contato;}
    function getds_contato1(){return $this->ds_contato1;}
    function getds_cel_contato1(){return $this->ds_cel_contato1;}
    function getds_tel_contato1(){return $this->ds_tel_contato1;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}
    function getdt_sinconizacao(){return $this->dt_sinconizacao;}
    function getic_status(){return $this->ic_status;}
    function getarquivo(){return $this->arquivo;}
    function getds_email_contato1(){return $this->ds_email_contato1;}
    function getusuarios_pk(){return $this->usuarios_pk;}
    function getgrupos_pk(){return $this->grupos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_pessoa_pk($tipo_pessoa_pk){ $this->tipo_pessoa_pk = $tipo_pessoa_pk;}
    function setds_lead($ds_lead){ $this->ds_lead = $ds_lead;}
    function setds_razao_social($ds_razao_social){ $this->ds_razao_social = $ds_razao_social;}
    function setds_cpf_cnpj($ds_cpf_cnpj){ $this->ds_cpf_cnpj = $ds_cpf_cnpj;}
    function setds_ie($ds_ie){ $this->ds_ie = $ds_ie;}
    function setds_rg($ds_rg){ $this->ds_rg = $ds_rg;}
    function setds_cnae($ds_cnae){ $this->ds_cnae = $ds_cnae;}
    function setic_cliente($ic_cliente){ $this->ic_cliente = $ic_cliente;}
    function setds_site($ds_site){ $this->ds_site = $ds_site;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setmailing_pk($mailing_pk){ $this->mailing_pk = $mailing_pk;}
    function settipo_telefone_pk($tipo_telefone_pk){ $this->tipo_telefone_pk = $tipo_telefone_pk;}
    function settipo_telefone_pk1($tipo_telefone_pk1){ $this->tipo_telefone_pk1= $tipo_telefone_pk1;}
    function setds_ddd($ds_ddd){ $this->ds_ddd = $ds_ddd;}
    function setds_tel($ds_tel){ $this->ds_tel = $ds_tel;}
    function setds_ddd1($ds_ddd1){ $this->ds_ddd1 = $ds_ddd1;}
    function setds_tel1($ds_tel1){ $this->ds_tel1 = $ds_tel1;}
    function settipo_endereco_pk($tipo_endereco_pk){ $this->tipo_endereco_pk = $tipo_endereco_pk;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_complmento($ds_complmento){ $this->ds_complmento = $ds_complmento;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setds_contato($ds_contato){ $this->ds_contato = $ds_contato;}
    function setds_cel_contato($ds_cel_contato){ $this->ds_cel_contato = $ds_cel_contato;}
    function setds_tel_contato($ds_tel_contato){ $this->ds_tel_contato = $ds_tel_contato;}
    function setds_email_contato($ds_email_contato){ $this->ds_email_contato = $ds_email_contato;}
    function setds_contato1($ds_contato1){ $this->ds_contato1 = $ds_contato1;}
    function setds_cel_contato1($ds_cel_contato1){ $this->ds_cel_contato1 = $ds_cel_contato1;}
    function setds_tel_contato1($ds_tel_contato1){ $this->ds_tel_contato1 = $ds_tel_contato1;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setdt_sinconizacao($dt_sinconizacao){ $this->dt_sinconizacao = $dt_sinconizacao;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setarquivo($arquivo){ $this->arquivo = $arquivo;}
    function setds_email_contato1($ds_email_contato1){ $this->ds_email_contato1 = $ds_email_contato1;}
    function setusuarios_pk($usuarios_pk){ $this->usuarios_pk = $usuarios_pk;}
    function setgrupos_pk($grupos_pk){ $this->grupos_pk = $grupos_pk;}

    
}

?>
