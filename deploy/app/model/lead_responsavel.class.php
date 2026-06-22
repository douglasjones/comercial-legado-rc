<?

class lead_responsavel{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $grupos_pk;
    private $leads_pk;
    private $usuarios_pk;
    private $contas_pk;
    private $polos_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->grupos_pk = null;
        $this->leads_pk = null;
        $this->usuarios_pk = null;
        $this->contas_pk = null;
        $this->polos_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getgrupos_pk(){return $this->grupos_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getusuarios_pk(){return $this->usuarios_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setgrupos_pk($grupos_pk){ $this->grupos_pk = $grupos_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setusuarios_pk($usuarios_pk){ $this->usuarios_pk = $usuarios_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}

    
}

?>
