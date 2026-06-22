<?php
class agenda_retorno{
    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dt_retorno;
    private $equipes_pk;
    private $responsavel_pk;
    private $dt_termino_retorno;
    private $ds_retorno;
    private $ocorrencias_pk;
   
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dt_retorno = null;
        $this->equipes_pk = null;
        $this->responsavel_pk = null;
        $this->dt_termino_retorno = null;
        $this->ds_retorno = null;
        $this->ocorrencias_pk	 = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdt_retorno(){return $this->dt_retorno;}
    function getequipes_pk(){return $this->equipes_pk;}
    function getresponsavel_pk(){return $this->responsavel_pk;}
    function getdt_termino_retorno(){return $this->dt_termino_retorno;}
    function getds_retorno(){return $this->ds_retorno;}
    function getocorrencias_pk	(){return $this->ocorrencias_pk	;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setdt_retorno($dt_retorno){ $this->dt_retorno = $dt_retorno;}
    function setequipes_pk($equipes_pk){ $this->equipes_pk = $equipes_pk;}
    function setresponsavel_pk($responsavel_pk){ $this->responsavel_pk = $responsavel_pk;}
    function setdt_termino_retorno($dt_termino_retorno){ $this->dt_termino_retorno = $dt_termino_retorno;}
    function setds_retorno($ds_retorno){ $this->ds_retorno = $ds_retorno;}
    function setocorrencias_pk	($ocorrencias_pk){ $this->ocorrencias_pk = $ocorrencias_pk;}    
}
?>
