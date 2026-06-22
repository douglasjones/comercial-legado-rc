<?

class lead_operador{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $operador_pk;
    private $leads_pk;
    private $ic_cliente;
    private $ic_base;
    private $dt_ativacao;
    private $dt_vencimento;
    private $ds_custo_atual;
    private $ds_qtde_voz;
    private $ds_qtde_dados;
    private $ic_status;
    private $classificacao_pk;
    private $tempo_contrato_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->operador_pk = null;
        $this->leads_pk = null;
        $this->ic_cliente = null;
        $this->ic_base = null;
        $this->dt_ativacao = null;
        $this->dt_vencimento = null;
        $this->ds_custo_atual = null;
        $this->ds_qtde_voz = null;
        $this->ds_qtde_dados = null;
        $this->ic_status = null;
        $this->classificacao_pk = null;
        $this->tempo_contrato_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getoperador_pk(){return $this->operador_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getic_cliente(){return $this->ic_cliente;}
    function getic_base(){return $this->ic_base;}
    function getdt_ativacao(){return $this->dt_ativacao;}
    function getdt_vencimento(){return $this->dt_vencimento;}
    function getds_custo_atual(){return $this->ds_custo_atual;}
    function getds_qtde_voz(){return $this->ds_qtde_voz;}
    function getds_qtde_dados(){return $this->ds_qtde_dados;}
    function getic_status(){return $this->ic_status;}
    function getclassificacao_pk(){return $this->classificacao_pk;}
    function gettempo_contrato_pk(){return $this->tempo_contrato_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setoperador_pk($operador_pk){ $this->operador_pk = $operador_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setic_cliente($ic_cliente){ $this->ic_cliente = $ic_cliente;}
    function setic_base($ic_base){ $this->ic_base = $ic_base;}
    function setdt_ativacao($dt_ativacao){ $this->dt_ativacao = $dt_ativacao;}
    function setdt_vencimento($dt_vencimento){ $this->dt_vencimento = $dt_vencimento;}
    function setds_custo_atual($ds_custo_atual){ $this->ds_custo_atual = $ds_custo_atual;}
    function setds_qtde_voz($ds_qtde_voz){ $this->ds_qtde_voz = $ds_qtde_voz;}
    function setds_qtde_dados($ds_qtde_dados){ $this->ds_qtde_dados = $ds_qtde_dados;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setclassificacao_pk($classificacao_pk){ $this->classificacao_pk= $classificacao_pk;}
    function settempo_contrato_pk($tempo_contrato_pk){ $this->tempo_contrato_pk= $tempo_contrato_pk;}

    
}

?>
