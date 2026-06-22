<?

class produto_servico{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_produto_servico;
    private $contas_pk;
    private $polos_pk;
    private $tipo_produto_pk;
    private $book_pk;
    private $vl_produto_servico;
    private $operador_pk;
    private $ic_valor_aberto;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_produto_servico = null;
        $this->contas_pk = null;
        $this->polos_pk = null;
        $this->tipo_produto_pk = null;
        $this->book_pk = null;
        $this->vl_produto_servico = null;
        $this->operador_pk= null;
        $this->ic_valor_aberto= null;
        $this->ic_status= null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_produto_servico(){return $this->ds_produto_servico;}
    function getcontas_pk(){return $this->contas_pk;}
    function getpolos_pk(){return $this->polos_pk;}
    function gettipo_produto_pk(){return $this->tipo_produto_pk;}
    function getbook_pk(){return $this->book_pk;}
    function getvl_produto_servico(){return $this->vl_produto_servico;}
    function getoperador_pk(){return $this->operador_pk;}
    function getic_valor_aberto(){return $this->ic_valor_aberto;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_produto_servico($ds_produto_servico){ $this->ds_produto_servico = $ds_produto_servico;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function settipo_produto_pk($tipo_produto_pk){ $this->tipo_produto_pk = $tipo_produto_pk;}
    function setbook_pk($book_pk){ $this->book_pk = $book_pk;}
    function setvl_produto_servico($vl_produto_servico){ $this->vl_produto_servico = $vl_produto_servico;}
    function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
    function setic_valor_aberto($ic_valor_aberto){ $this->ic_valor_aberto = $ic_valor_aberto;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

}
?>
