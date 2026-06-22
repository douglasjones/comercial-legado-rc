<?

class proposta_item{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $produtos_servicos_pk;
    private $n_qtde;
    private $n_qtde_dias_semana;
    private $vl_unit;
    private $vl_total;
    private $propostas_pk;
  
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->produtos_servicos_pk = null;
        $this->n_qtde = null;
        $this->n_qtde_dias_semana = null;
        $this->vl_unit = null;
        $this->vl_total = null;
        $this->propostas_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getprodutos_servicos_pk(){return $this->produtos_servicos_pk;}
    function getn_qtde(){return $this->n_qtde;}
    function getn_qtde_dias_semana(){return $this->n_qtde_dias_semana;}    
    function getvl_unit(){return $this->vl_unit;}
    function getvl_total(){return $this->vl_total;}
    function getpropostas_pk(){return $this->propostas_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setprodutos_servicos_pk($produtos_servicos_pk){ $this->produtos_servicos_pk = $produtos_servicos_pk;}
    function setn_qtde($n_qtde){ $this->n_qtde = $n_qtde;}
    function setn_qtde_dias_semana($n_qtde_dias_semana){ $this->n_qtde_dias_semana = $n_qtde_dias_semana;}
    
    function setvl_unit($vl_unit){ $this->vl_unit = $vl_unit;}
    function setvl_total($vl_total){ $this->vl_total = $vl_total;}
    function setpropostas_pk($propostas_pk){ $this->propostas_pk = $propostas_pk;}

    
}

?>
