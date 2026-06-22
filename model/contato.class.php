<?

class contato{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_contato;
    private $ds_cel;
    private $ic_whatsapp;
    private $ds_email;
    private $ds_tel;
    private $cargos_pk;
    private $leads_pk;
    private $polos_pk;
    private $contas_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_contato = null;
        $this->ds_cel = null;
        $this->ic_whatsapp = null;
        $this->ds_email = null;
        $this->ds_tel = null;
        $this->cargos_pk = null;
        $this->leads_pk = null;
        $this->polos_pk = null;
        $this->contas_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_contato(){return $this->ds_contato;}
    function getds_cel(){return $this->ds_cel;}
    function getic_whatsapp(){return $this->ic_whatsapp;}
    function getds_email(){return $this->ds_email;}
    function getds_tel(){return $this->ds_tel;}
    function getcargos_pk(){return $this->cargos_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_contato($ds_contato){ $this->ds_contato = $ds_contato;}
    function setds_cel($ds_cel){ $this->ds_cel = $ds_cel;}
    function setic_whatsapp($ic_whatsapp){ $this->ic_whatsapp = $ic_whatsapp;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function setds_tel($ds_tel){ $this->ds_tel = $ds_tel;}
    function setcargos_pk($cargos_pk){ $this->cargos_pk = $cargos_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}

    
}

?>
