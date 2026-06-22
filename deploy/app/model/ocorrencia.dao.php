<?php

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/ocorrencia.class.php';


class ocorrenciadao{

    private $db;
    private $arrToken;

    public function __construct(){
        
        $this->db = new DataBase();
        $this->db->conectar();
        
    }
    
    public function __destruct() {
        $this->db->desconectar();
    }
    
    
    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }       
    
    public function salvar($ocorrencia){

        $fields = array();
        $fields['ds_ocorrencia'] = $ocorrencia->getds_ocorrencia();
        $fields['tipos_ocorrencias_pk'] = $ocorrencia->gettipos_ocorrencias_pk();
        $fields['processos_etapas_pk'] = $ocorrencia->getprocessos_etapas_pk();
        $fields['leads_pk'] = $ocorrencia->getleads_pk();
        $fields['motivo_sem_interesse_pk'] = $ocorrencia->getmotivo_sem_interesse_pk();
        $fields['ds_motivo_sem_interesse'] = $ocorrencia->getds_motivo_sem_interesse();
        
        if($ocorrencia->getdt_fechamento()== 1){
            $fields['dt_fechamento'] = "sysdate()";
        }
        if($ocorrencia->getdt_fechamento()== 2){
            $fields['dt_fechamento'] = " ";
        }
        


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];


        $fieldsLeads["dt_ult_ocorrencia"] = "sysdate()";
        $this->db->execUpdate("leads", $fieldsLeads, " pk = ".$ocorrencia->getleads_pk());

        if($ocorrencia->getpk()  == ""){
			
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("ocorrencias", $fields);
            return $pk;
        }else{						
            return $this->db->execUpdate("ocorrencias", $fields, " pk = ".$ocorrencia->getpk());			
        }

     
	
    }

    public function excluirRetorno($ocorrencias_pk){
        $this->db->execDelete("retornos"," ocorrencias_pk = ".$ocorrencias_pk);
    }
    public function excluirOcMigracao($ocorrencias_pk){
        $this->db->execDelete("ocorrencias"," pk= ".$ocorrencias_pk);
    }
    public function excluir($ocorrencia){
        $this->db->execDelete("ocorrencias"," pk = ".$ocorrencia->getpk());
    }

    public function carregarPorPk($pk){

        $ocorrencia = new ocorrencia();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,tipos_ocorrencias_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,leads_pk ";


        $sql.="  from ocorrencias ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $ocorrencia->setpk($query[$i]["pk"]);
                $ocorrencia->setdt_cadastro($query[$i]["dt_cadastro"]);
                $ocorrencia->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $ocorrencia->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $ocorrencia->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $ocorrencia->setds_ocorrencia($query[$i]['ds_ocorrencia']);
                $ocorrencia->settipos_ocorrencias_pk($query[$i]['tipos_ocorrencias_pk']);
                $ocorrencia->setprocessos_etapas_pk($query[$i]['processos_etapas_pk']);
                $ocorrencia->setdt_fechamento($query[$i]['dt_fechamento']);
                $ocorrencia->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $ocorrencia;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,tipos_ocorrencias_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,leads_pk ";

        $sql.="  from ocorrencias ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorLeadsPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,tipos_ocorrencias_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,leads_pk ";

        $sql.="  from ocorrencias ";
        $sql.=" where leads_pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_ocorrencia($ds_lead,$tipos_ocorrencias_pk,$ic_status,$usuario_cadastro_pk,$dt_cadastro,$dt_cadastro_fim,$polos_pk){
        
        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y <br>%H:%i:%s')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="       ,u.ds_usuario nome_usuario_cadastro ";
        $sql.="       ,date_format(o.dt_fechamento,'%d/%m/%Y<br>%H:%i:%s')dt_fechamento ";  
        $sql.="       ,u1.ds_usuario nome_agendado_para ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_retorno "; 
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_termino_retorno ";
        $sql.="       ,o.tipos_ocorrencias_pk ";
        $sql.="       ,o.processos_etapas_pk ";     
        $sql.="       ,o.leads_pk ";  
        $sql.="  from ocorrencias o";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN usuarios u on o.usuario_cadastro_pk = u.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  LEFT JOIN retornos r on o.pk = r.ocorrencias_pk ";
        $sql.="  LEFT JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        
        $sql.=" where 1=1 ";
        
        //Lead
        if($ds_lead != ""){
            $sql.=" and l.ds_lead like '%".$ds_lead."%' ";
        }
        //Tipo Ocorrencia
        if(!empty($tipos_ocorrencias_pk)){
            $sql.=" and o.tipos_ocorrencias_pk=".$tipos_ocorrencias_pk;
        }
        if($ic_status==1){
            $sql.=" and o.dt_fechamento is null";
        }elseif ($ic_status==2) {
            $sql.=" and o.dt_fechamento is not null";            
        }
        
        if(!empty($usuario_cadastro_pk)){
            $sql.=" and o.usuario_cadastro_pk=".$usuario_cadastro_pk;
        }
        
        if(!empty($dt_cadastro)){
            $sql.=" and o.dt_cadastro >='".DataYMD($dt_cadastro)." 00:00:00'";
        }
        if(!empty($dt_cadastro_fim)){
            $sql.=" and o.dt_cadastro <='".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
        if(!empty($polos_pk)){
            $sql.=" and l.polos_pk =".$polos_pk;
        }
        
        $sql.=" order by ds_ocorrencia asc ";
 
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_ocorrencia_processo_lead($leads_pk){

        
        $sql ="";
        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y <br>%H:%i:%s')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="       ,u.ds_usuario nome_usuario_cadastro ";
        $sql.="       ,date_format(o.dt_fechamento,'%d/%m/%Y<br>%H:%i:%s')dt_fechamento ";  
        $sql.="       ,u1.ds_usuario nome_agendado_para ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_retorno "; 
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_termino_retorno ";
        $sql.="       ,o.tipos_ocorrencias_pk ";
        $sql.="       ,o.processos_etapas_pk ";     
        $sql.="       ,o.leads_pk ";  
        $sql.="       ,o.motivo_sem_interesse_pk";  
        $sql.="       ,o.ds_motivo_sem_interesse";  
        $sql.="  from ocorrencias o";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN usuarios u on o.usuario_cadastro_pk = u.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  LEFT JOIN retornos r on o.pk = r.ocorrencias_pk ";
        $sql.="  LEFT JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
                
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and o.leads_pk = ".$leads_pk;
        }
        //$sql.=" and tio.contas_pk = ".$this->arrToken['contas_pk'];
        //$sql.=" and tio.polos_pk = ".$this->arrToken['polos_pk'];
        $sql.=" and tio.ic_status =1 ";
        $sql.=" Group by o.pk ";
        $sql.="       ORDER BY o.dt_cadastro desc";
        $query = $this->db->execQuery($sql);
        return $query;

        
    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,tipos_ocorrencias_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,leads_pk ";

        $sql.="  from ocorrencias ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_ocorrencia asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarqtdeOcorrenciaRegistrada($token,$usuario_pk){

        $sql ="";
        $sql.="select count('0')registros ";

        $sql.="  from ocorrencias ";
        $sql.=" where 1=1 ";
        if($usuario_pk!=""){
            $sql.=" and usuario_cadastro_pk = ".$usuario_pk;
        }
        $sql.=" order by ds_ocorrencia asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarMotivoSemInteresse($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_motivo_sem_interesse ";

        $sql.="  from motivo_sem_interesse ";
        $sql.=" where 1=1 ";
        $sql.=" and ic_status = 1 ";
        if($pk!=""){
            $sql.=" and pk = ".$pk;
        }

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarMotivoSemInteresseMigracao(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_motivo_sem_interesse ";

        $sql.="  from motivo_sem_interesse ";
        $sql.=" where 1=1 ";
        $sql.=" and ic_status = 1 ";
        $sql.=" and ds_motivo_sem_interesse like '%Migração%'";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    function excluirRetornos($ocorrencias_pk){
     
        $this->db->execDelete("retornos", " ocorrencias_pk = " . $ocorrencias_pk);
    }

}

?>
