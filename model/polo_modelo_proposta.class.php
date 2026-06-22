<?

class polo_modelo_proposta{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_modelo_pk;
    private $tipo_envio_pk;
    private $ds_email;
    private $html_modelo;
    private $polos_pk;
    private $operador_pk;
    private $status_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_modelo_pk = null;
        $this->tipo_envio_pk = null;
        $this->ds_email = null;
        $this->html_modelo = null;
        $this->polos_pk = null;
        $this->operador_pk = null;
        $this->status_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_modelo_pk(){return $this->tipo_modelo_pk;}
    function gettipo_envio_pk(){return $this->tipo_envio_pk;}
    function getds_email(){return $this->ds_email;}
    function gethtml_modelo(){return $this->html_modelo;}
    function getpolos_pk(){return $this->polos_pk;}
    function getoperador_pk(){return $this->operador_pk;}
    function getstatus_pk(){return $this->status_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_modelo_pk($tipo_modelo_pk){ $this->tipo_modelo_pk = $tipo_modelo_pk;}
    function settipo_envio_pk($tipo_envio_pk){ $this->tipo_envio_pk = $tipo_envio_pk;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function sethtml_modelo($html_modelo){ $this->html_modelo = $html_modelo;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
    function setstatus_pk($status_pk){ $this->status_pk = $status_pk;}

    
}

?>
