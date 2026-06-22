<?

class etapa_contrato{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_etapa;
    private $operador_pk;
    private $ic_status;
    private $polos_pk;
    private $operadores_pk;
    private $n_ordem;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_etapa = null;
        $this->operador_pk = null;
        $this->ic_status = null;
        $this->polos_pk = null;
        $this->operadores_pk = null;
        $this->n_ordem = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_etapa(){return $this->ds_etapa;}
    function getoperador_pk(){return $this->operador_pk;}
    function getic_status(){return $this->ic_status;}
    function getpolos_pk(){return $this->polos_pk;}
    function getoperadores_pk(){return $this->operadores_pk;}
    function getn_ordem(){return $this->n_ordem;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_etapa($ds_etapa){ $this->ds_etapa = $ds_etapa;}
    function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setoperadores_pk($operadores_pk){ $this->operadores_pk = $operadores_pk;}
    function setn_ordem($n_ordem){ $this->n_ordem = $n_ordem;}

    
}

?>
