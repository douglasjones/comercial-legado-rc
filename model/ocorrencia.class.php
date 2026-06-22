<?php

class ocorrencia{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_ocorrencia;
    private $tipos_ocorrencias_pk;
    private $processos_etapas_pk;
    private $dt_fechamento;
    private $leads_pk;
    private $motivo_sem_interesse_pk;
    private $ds_motivo_sem_interesse;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_ocorrencia = null;
        $this->tipos_ocorrencias_pk = null;
        $this->processos_etapas_pk = null;
        $this->dt_fechamento = null;
        $this->leads_pk = null;
        $this->motivo_sem_interesse_pk = null;
        $this->ds_motivo_sem_interesse = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_ocorrencia(){return $this->ds_ocorrencia;}
    function gettipos_ocorrencias_pk(){return $this->tipos_ocorrencias_pk;}
    function getprocessos_etapas_pk(){return $this->processos_etapas_pk;}
    function getdt_fechamento(){return $this->dt_fechamento;}
    function getleads_pk(){return $this->leads_pk;}
    function getmotivo_sem_interesse_pk(){return $this->motivo_sem_interesse_pk;}
    function getds_motivo_sem_interesse(){return $this->ds_motivo_sem_interesse;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_ocorrencia($ds_ocorrencia){ $this->ds_ocorrencia = $ds_ocorrencia;}
    function settipos_ocorrencias_pk($tipos_ocorrencias_pk){ $this->tipos_ocorrencias_pk = $tipos_ocorrencias_pk;}
    function setprocessos_etapas_pk($processos_etapas_pk){ $this->processos_etapas_pk = $processos_etapas_pk;}
    function setdt_fechamento($dt_fechamento){ $this->dt_fechamento = $dt_fechamento;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setmotivo_sem_interesse_pk($motivo_sem_interesse_pk){ $this->motivo_sem_interesse_pk = $motivo_sem_interesse_pk;}
    function setds_motivo_sem_interesse($ds_motivo_sem_interesse){ $this->ds_motivo_sem_interesse = $ds_motivo_sem_interesse;}

    
}

?>
