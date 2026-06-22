<?

class telefone{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_telefone_pk;
    private $ds_tel;
    private $ds_ddd;
    private $ic_status;
    private $leads_pk;
    private $contas_pk;
    private $polos_pk;
    private $dt_naoperturbe;
    private $ds_naoperturbe;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_telefone_pk = null;
        $this->ds_tel = null;
        $this->ds_ddd = null;
        $this->ic_status = null;
        $this->leads_pk = null;
        $this->contas_pk = null;
        $this->polos_pk = null;
        $this->dt_naoperturbe = null;
        $this->ds_naoperturbe = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_telefone_pk(){return $this->tipo_telefone_pk;}
    function getds_tel(){return $this->ds_tel;}
    function getds_ddd(){return $this->ds_ddd;}
    function getic_status(){return $this->ic_status;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}
    function getdt_naoperturbe(){return $this->dt_naoperturbe;}
    function getds_naoperturbe(){return $this->ds_naoperturbe;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_telefone_pk($tipo_telefone_pk){ $this->tipo_telefone_pk = $tipo_telefone_pk;}
    function setds_tel($ds_tel){ $this->ds_tel = $ds_tel;}
    function setds_ddd($ds_ddd){ $this->ds_ddd = $ds_ddd;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setdt_naoperturbe($dt_naoperturbe){ $this->dt_naoperturbe = $dt_naoperturbe;}
    function setds_naoperturbe($ds_naoperturbe){ $this->ds_naoperturbe = $ds_naoperturbe;}

    
}

?>
