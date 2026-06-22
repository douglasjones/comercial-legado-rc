<?

class agenda_visita{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dt_agenda;
    private $dt_termino;
    private $ds_endereco;
    private $ds_numero;
    private $ds_complemento;
    private $ds_cep;
    private $ds_bairro;
    private $ds_cidade;
    private $ds_uf;
    private $ds_obs;
    private $classificacao_agenda_pk;
    private $dt_cancelamento;
    private $motivo_cancelamento_pk;
    private $ds_obs_cancelamento;
    private $dt_reagendamento;
    private $motivo_reagendamento_pk;
    private $ds_obs_reagendamento;
    private $processos_etapas_pk;
    private $tipos_agendas_pk;
    private $ds_obs_classificacao;
    private $ic_status;
    private $agenda_reagendamento_pk;
    private $ds_contato;
    private $ds_cel;
    private $ds_tel;
    private $cargos_pk;
    private $ds_email;
    private $polos_pk;
    private $leads_pk;
    private $contas_pk;
    private $tipo_evento_pk;
    private $ds_titulo_agenda;
    private $aviso_pk;
    private $atendente_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dt_agenda = null;
        $this->dt_termino = null;
        $this->ds_endereco = null;
        $this->ds_numero = null;
        $this->ds_complemento = null;
        $this->ds_cep = null;
        $this->ds_bairro = null;
        $this->ds_cidade = null;
        $this->ds_uf = null;
        $this->ds_obs = null;
        $this->classificacao_agenda_pk = null;
        $this->dt_cancelamento = null;
        $this->motivo_cancelamento_pk = null;
        $this->ds_obs_cancelamento = null;
        $this->dt_reagendamento = null;
        $this->motivo_reagendamento_pk = null;
        $this->ds_obs_reagendamento = null;
        $this->processos_etapas_pk = null;
        $this->tipos_agendas_pk = null;
        $this->ds_obs_classificacao = null;
        $this->ic_status = null;
        $this->agenda_reagendamento_pk = null;
        $this->ds_contato = null;
        $this->ds_cel = null;
        $this->ds_tel = null;
        $this->cargos_pk = null;
        $this->ds_email = null;
        $this->polos_pk = null;
        $this->leads_pk = null;
        $this->contas_pk = null;
        $this->tipo_evento_pk = null;
        $this->ds_titulo_agenda = null;
        $this->aviso_pk = null;
        $this->atendente_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdt_agenda(){return $this->dt_agenda;}
    function getdt_termino(){return $this->dt_termino;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_numero(){return $this->ds_numero;}
    function getds_complemento(){return $this->ds_complemento;}
    function getds_cep(){return $this->ds_cep;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getds_obs(){return $this->ds_obs;}
    function getclassificacao_agenda_pk(){return $this->classificacao_agenda_pk;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getmotivo_cancelamento_pk(){return $this->motivo_cancelamento_pk;}
    function getds_obs_cancelamento(){return $this->ds_obs_cancelamento;}
    function getdt_reagendamento(){return $this->dt_reagendamento;}
    function getmotivo_reagendamento_pk(){return $this->motivo_reagendamento_pk;}
    function getds_obs_reagendamento(){return $this->ds_obs_reagendamento;}
    function getprocessos_etapas_pk(){return $this->processos_etapas_pk;}
    function gettipos_agendas_pk(){return $this->tipos_agendas_pk;}
    function getds_obs_classificacao(){return $this->ds_obs_classificacao;}
    function getic_status(){return $this->ic_status;}
    function getagenda_reagendamento_pk(){return $this->agenda_reagendamento_pk;}
    function getds_contato(){return $this->ds_contato;}
    function getds_tel(){return $this->ds_tel;}
    function getds_cel(){return $this->ds_cel;}
    function getcargos_pk(){return $this->cargos_pk;}
    function getds_email(){return $this->ds_email;}
    function getpolos_pk(){return $this->polos_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontas_pk(){return $this->contas_pk;}
    function gettipo_evento_pk(){return $this->tipo_evento_pk;}
    function getds_titulo_agenda(){return $this->ds_titulo_agenda;}
    function getaviso_pk(){return $this->aviso_pk;}
    function getatendente_pk(){return $this->atendente_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setdt_agenda($dt_agenda){ $this->dt_agenda = $dt_agenda;}
    function setdt_termino($dt_termino){ $this->dt_termino = $dt_termino;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_complemento($ds_complemento){ $this->ds_complemento = $ds_complemento;}
    function setds_cep($ds_cep){ $this->ds_cep = $ds_cep;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setclassificacao_agenda_pk($classificacao_agenda_pk){ $this->classificacao_agenda_pk = $classificacao_agenda_pk;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setmotivo_cancelamento_pk($motivo_cancelamento_pk){ $this->motivo_cancelamento_pk = $motivo_cancelamento_pk;}
    function setds_obs_cancelamento($ds_obs_cancelamento){ $this->ds_obs_cancelamento = $ds_obs_cancelamento;}
    function setdt_reagendamento($dt_reagendamento){ $this->dt_reagendamento = $dt_reagendamento;}
    function setmotivo_reagendamento_pk($motivo_reagendamento_pk){ $this->motivo_reagendamento_pk = $motivo_reagendamento_pk;}
    function setds_obs_reagendamento($ds_obs_reagendamento){ $this->ds_obs_reagendamento = $ds_obs_reagendamento;}
    function setprocessos_etapas_pk($processos_etapas_pk){ $this->processos_etapas_pk = $processos_etapas_pk;}
    function settipos_agendas_pk($tipos_agendas_pk){ $this->tipos_agendas_pk = $tipos_agendas_pk;}
    function setds_obs_classificacao($ds_obs_classificacao){ $this->ds_obs_classificacao = $ds_obs_classificacao;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setagenda_reagendamento_pk($agenda_reagendamento_pk){ $this->agenda_reagendamento_pk = $agenda_reagendamento_pk;}
    function setds_contato($ds_contato){ $this->ds_contato = $ds_contato;}
    function setds_tel($ds_tel){ $this->ds_tel = $ds_tel;}
    function setds_cel($ds_cel){ $this->ds_cel = $ds_cel;}
    function setcargos_pk($cargos_pk){ $this->cargos_pk = $cargos_pk;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setcontas_pk($contas_pk){ $this->contas_pk = $contas_pk;}
    function settipo_evento_pk($tipo_evento_pk){ $this->tipo_evento_pk = $tipo_evento_pk;}
    function setds_titulo_agenda($ds_titulo_agenda){ $this->ds_titulo_agenda = $ds_titulo_agenda;}
    function setaviso_pk($aviso_pk){ $this->aviso_pk = $aviso_pk;}
    function setatendente_pk($atendente_pk){ $this->atendente_pk = $atendente_pk;}
  
}

?>
