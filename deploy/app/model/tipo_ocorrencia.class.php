<?

class tipo_ocorrencia{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_tipo_ocorrencia;
    private $ic_fechar_ocorrencia_auto;
    private $contas_pk;
    private $polos_pk;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_tipo_ocorrencia = null;
        $this->ic_fechar_ocorrencia_auto = null;
        $this->contas_pk = null;
        $this->polos_pk = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_tipo_ocorrencia(){return $this->ds_tipo_ocorrencia;}
    function getic_fechar_ocorrencia_auto(){return $this->ic_fechar_ocorrencia_auto;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_tipo_ocorrencia($ds_tipo_ocorrencia){ $this->ds_tipo_ocorrencia = $ds_tipo_ocorrencia;}
    function setic_fechar_ocorrencia_auto($ic_fechar_ocorrencia_auto){ $this->ic_fechar_ocorrencia_auto = $ic_fechar_ocorrencia_auto;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setic_status($ic_status){ $this->ic_status= $ic_status;}

    
}

?>
