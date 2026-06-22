<?

class usuario{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_usuario;
    private $ds_login;
    private $ds_senha;
    private $ds_email;
    private $ds_cel;
    private $ic_status;
    private $grupos_pk;
    private $contas_pk;
    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_usuario = null;
        $this->ds_login = null;
        $this->ds_senha = null;
        $this->ds_email = null;
        $this->ds_cel = null;
        $this->ic_status = null;
        $this->grupos_pk = null;
        $this->contas_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_usuario(){return $this->ds_usuario;}
    function getds_login(){return $this->ds_login;}
    function getds_senha(){return $this->ds_senha;}
    function getds_email(){return $this->ds_email;}
    function getds_cel(){return $this->ds_cel;}
    function getic_status(){return $this->ic_status;}
    function getgrupos_pk(){return $this->grupos_pk;}
    function getcontas_pk(){return $this->contas_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_usuario($ds_usuario){ $this->ds_usuario = $ds_usuario;}
    function setds_login($ds_login){ $this->ds_login = $ds_login;}
    function setds_senha($ds_senha){ $this->ds_senha = $ds_senha;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function setds_cel($ds_cel){ $this->ds_cel = $ds_cel;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setgrupos_pk($grupos_pk){ $this->grupos_pk = $grupos_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}    
}

?>
