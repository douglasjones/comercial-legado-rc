<?

class plano{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_plano;
    private $vl_plano;
    private $segmentos_pk;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_plano = null;
        $this->vl_plano = null;
        $this->segmentos_pk = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_plano(){return $this->ds_plano;}
    function getvl_plano(){return $this->vl_plano;}
    function getsegmentos_pk(){return $this->segmentos_pk;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_plano($ds_plano){ $this->ds_plano = $ds_plano;}
    function setvl_plano($vl_plano){ $this->vl_plano = $vl_plano;}
    function setsegmentos_pk($segmentos_pk){ $this->segmentos_pk = $segmentos_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

    
}

?>
