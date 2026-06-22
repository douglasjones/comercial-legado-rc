<?

class lead{

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
    private $ds_obs;
    private $ds_site;
    private $mailing_pk;
    private $contas_pk;
    private $polos_pk;
    private $ciclo_uso;
    private $ds_log;

    
    
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
        $this->ds_obs = null;
        $this->ds_site = null;
        $this->mailing_pk = null;
        $this->contas_pk = null;
        $this->polos_pk = null;
        $this->ciclo_uso = null;
        $this->ds_log = null;

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
    function getds_obs(){return $this->ds_obs;}
    function getds_site(){return $this->ds_site;}
    function getmailing_pk(){return $this->mailing_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}
    function getciclo_uso(){return $this->ciclo_uso;}
    function getds_log(){return $this->ds_log;}

    
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
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setds_site($ds_site){ $this->ds_site = $ds_site;}
    function setmailing_pk($mailing_pk){ $this->mailing_pk = $mailing_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setciclo_uso($ciclo_uso){ $this->ciclo_uso = $ciclo_uso;}
    function setds_log($ds_log){ $this->ds_log = $ds_log;}

    
}

?>
