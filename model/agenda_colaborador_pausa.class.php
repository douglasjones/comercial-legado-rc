<?

class agenda_colaborador_pausa{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_agenda_colaborador_pausa;
    private $dt_inicio_pausa;
    private $dt_fim_pausa;
    private $motivos_pausas_pk;
    private $colaboradores_pk;
    private $turnos_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_agenda_colaborador_pausa = null;
        $this->dt_inicio_pausa = null;
        $this->dt_fim_pausa = null;
        $this->motivos_pausas_pk = null;
        $this->colaboradores_pk = null;
        $this->turnos_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_agenda_colaborador_pausa(){return $this->ds_agenda_colaborador_pausa;}
    function getdt_inicio_pausa(){return $this->dt_inicio_pausa;}
    function getdt_fim_pausa(){return $this->dt_fim_pausa;}
    function getmotivos_pausas_pk(){return $this->motivos_pausas_pk;}
    function getcolaboradores_pk(){return $this->colaboradores_pk;}
    function getturnos_pk(){return $this->turnos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa){ $this->ds_agenda_colaborador_pausa = $ds_agenda_colaborador_pausa;}
    function setdt_inicio_pausa($dt_inicio_pausa){ $this->dt_inicio_pausa = $dt_inicio_pausa;}
    function setdt_fim_pausa($dt_fim_pausa){ $this->dt_fim_pausa = $dt_fim_pausa;}
    function setmotivos_pausas_pk($motivos_pausas_pk){ $this->motivos_pausas_pk = $motivos_pausas_pk;}
    function setcolaboradores_pk($colaboradores_pk){ $this->colaboradores_pk = $colaboradores_pk;}
    function setturnos_pk($turnos_pk){ $this->turnos_pk = $turnos_pk;}

    
}

?>
