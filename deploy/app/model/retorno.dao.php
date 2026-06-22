<?php
date_default_timezone_set('America/Sao_Paulo');

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/retorno.class.php';


class retornodao{

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
    
    public function salvar($retorno){

        $fields = array();
        $fields['dt_retorno'] = $retorno->getdt_retorno();
        $fields['equipes_pk'] = $retorno->getequipes_pk();
        $fields['responsavel_pk'] = $retorno->getresponsavel_pk();
        //$fields['dt_termino_retorno'] =  $retorno->getdt_termino_retorno();
        $fields['ds_retorno'] = $retorno->getds_retorno();
        $fields['ocorrencias_pk'] = $retorno->getocorrencias_pk();
        
        if($retorno->getdt_termino_retorno()== 1){
            $fields['dt_termino_retorno'] = "sysdate()";
        }
        if($retorno->getdt_termino_retorno()== 2){
            $fields['dt_termino_retorno'] = " ";
        }

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($retorno->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            
			//$this->db->execInsert("retornos", $fields);
			//echo $this->db->getLastSQL();
			
            $pk = $this->db->execInsert("retornos", $fields);
            
            return $pk;
        }else{
			//$this->db->execUpdate("retornos", $fields, " pk = ".$retorno->getpk());
			//echo $this->db->getLastSQL();
			
            return $this->db->execUpdate("retornos", $fields, " pk = ".$retorno->getpk());           
        }
    }

    public function excluir($retorno){
        $this->db->execDelete("retornos"," pk = ".$retorno->getpk());
    }

    public function carregarPorPk($pk){

        $retorno = new retorno();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";


        $sql.="  from retornos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $retorno->setpk($query[$i]["pk"]);
                $retorno->setdt_cadastro($query[$i]["dt_cadastro"]);
                $retorno->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $retorno->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $retorno->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $retorno->setdt_retorno($query[$i]['dt_retorno']);
                $retorno->setequipes_pk($query[$i]['equipes_pk']);
                $retorno->setresponsavel_pk($query[$i]['responsavel_pk']);
                $retorno->setdt_termino_retorno($query[$i]['dt_termino_retorno']);
                $retorno->setds_retorno($query[$i]['ds_retorno']);
                $retorno->setocorrencias_pk($query[$i]['ocorrencias_pk']);

            }
        }
        return $retorno;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";

        $sql.="  from retornos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarRetornoEmAberto(){
        //date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = date('Y-m-d', time());
        
        $sql ="";
        $sql.="select r.pk,";
        $sql.="       l.ds_lead,";
        $sql.="       l.pk leads_pk,";
        $sql.="       date_format(r.dt_retorno, '%d/%m/%Y')dt_retorno,";
        $sql.="       tio.ds_tipo_ocorrencia,";
        $sql.="       o.pk ocorrencias_pk,";
        $sql.="       o.ds_ocorrencia,";
        $sql.="       r.ds_retorno ";
        $sql.="  from retornos r ";
        $sql.="       inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="       inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.="       inner join leads l on o.leads_pk = l.pk";
        $sql.="       inner join usuarios_polos up on r.responsavel_pk = up.usuarios_pk";
        $sql.=" where 1=1";
        //$sql.=" where l.polos_pk = ".$this->arrToken['polos_pk'];
        $sql.="       and r.dt_retorno <= '".$dataLocal." 23:59:59'";
        $sql.="       and r.dt_termino_retorno is null";
        
        $sql.="       and r.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        $sql.="       ORDER BY date_format(r.dt_retorno, '%Y/%M/%D') asc";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarRetornoAtrasado($token){
        /*$sql1="";
        $sql1.="select sysdate() dt_atual";
        $dt_atual = $this->db->execQuery($sql1);*/
        $dataLocal = date('Y-m-d', time());
        
        $sql ="";
        $sql.="select count(0)total_atraso from retornos r";
        $sql.="  INNER JOIN ocorrencias o on o.pk = r.ocorrencias_pk ";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.=" where r.dt_retorno <= '".$dataLocal." 23:59:59'";
        $sql.="       and r.dt_termino_retorno is null";
        if(!permissao("meu_gepros_listar", "cons", $token)){
            $sql.=" and r.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        if($this->arrToken['grupos_pk']==2){
            $sql.=" and r.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        //$sql.="       and l.polos_pk = ".$this->arrToken['polos_pk'];
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarPorOcorrenciasPk($ocorrencias_pk,$pk){

        $sql ="";
        $sql.="select r.pk, r.dt_cadastro, r.usuario_cadastro_pk, r.dt_ult_atualizacao, r.usuario_ult_atualizacao_pk  ";
        $sql.="       ,date_format(r.dt_retorno, '%d/%m/%Y') dt_retorno";
        $sql.="       ,date_format(r.dt_retorno, '%H:%i') hr_retorno";
        $sql.="       ,date_format(r.dt_termino_retorno, '%d/%m/%Y') dt_termino_retorno";
        $sql.="       ,date_format(r.dt_termino_retorno, '%H:%i:%s') hr_termino_retorno";
        $sql.="       ,r.equipes_pk ";
        $sql.="       ,r.responsavel_pk ";
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,r.ocorrencias_pk ";
        $sql.="       ,tio.pk tipo_ocorrencia_pk";

        $sql.="  from retornos r";
        $sql.="         inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="         inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.=" where r.ocorrencias_pk =  ".$ocorrencias_pk;
        if($pk!=""){
            $sql.="       and r.pk = ".$pk;
        }
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dt_retorno($dt_retorno){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";

        $sql.="  from retornos ";
        $sql.=" where 1=1 ";
        if($dt_retorno != ""){
            $sql.=" and ds_retorno like '%".$dt_retorno."%' ";
        }
        $sql.=" order by dt_retorno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_qtde_retorno_aberto(){

        //date_default_timezone_set('America/Sao_Paulo');
        $hora = date('H:i:s');			

        $data =  date('Y-m-d');
        $horarioverao = $data." ".$hora; 
        
        $sql ="";
         $sql.="select COUNT(r.pk) qtde_retorno";
        $sql.="  from retornos r ";
        $sql.="       inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="       inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.="       inner join leads l on o.leads_pk = l.pk";
        $sql.="       inner join usuarios_polos up on r.responsavel_pk = up.usuarios_pk";
        $sql.=" where l.polos_pk = ".$this->arrToken['polos_pk'];
        $sql.="       and r.dt_retorno < sysdate()";
        $sql.="       and r.dt_termino_retorno is null";
        
        $sql.="       and r.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        $sql.="       ORDER BY date_format(r.dt_retorno, '%Y/%M/%D') asc";
  
        
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarGraficoRetornoPendente($token,$membro_equipe_pk){

        //date_default_timezone_set('America/Sao_Paulo');
        $hora = date('H:i:s');			

        $data =  date('Y-m-d');
        $horarioverao = $data." ".$hora; 
        
        $sql ="";
         $sql.="select COUNT(r.pk) qtde_retorno";
        $sql.="  from retornos r ";
        $sql.="       inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="       inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.="       inner join leads l on o.leads_pk = l.pk";
        $sql.="       inner join equipes_usuarios eu on r.responsavel_pk = eu.usuarios_pk";
        $sql.=" where l.polos_pk = ".$this->arrToken['polos_pk'];
        $sql.="       and r.dt_retorno < sysdate()";
        $sql.="       and r.dt_termino_retorno is null";
        if($membro_equipe_pk!=""){
            $sql.="       and r.responsavel_pk = ".$membro_equipe_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        $sql.="       ORDER BY date_format(r.dt_retorno, '%Y/%M/%D') asc";
      
        
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_retorno_aberto_Popup(){

        //date_default_timezone_set('America/Sao_Paulo');
        $data =  date('d/m/Y');
        $hora = date('H:i:s');			

        $data =  date('Y-m-d');
        $horarioverao = $data." ".$hora; 
        
        $sql ="";
        $sql.="select o.pk, o.dt_cadastro, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="  ,l.pk leads_pk";
        $sql.="  ,l.ds_lead ";
        $sql.="  ,date_format(r.dt_retorno,'%d/%m/%Y <br>%H:%i:%s')dt_retorno "; 
        $sql.="  ,tio.ds_tipo_ocorrencia";
        $sql.="  ,u1.ds_usuario ds_agendado_para ";  
        $sql.="  ,u1.ds_cel";  
        $sql.="  ,r.ds_retorno ";  
        $sql.="  from retornos r";
        $sql.="  INNER JOIN ocorrencias o on o.pk = r.ocorrencias_pk ";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  INNER JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        $sql.="  inner join usuarios_polos up on r.responsavel_pk = up.usuarios_pk";
        $sql.=" where r.responsavel_pk=".$this->arrToken['usuarios_pk'];
        $sql.=" and r.dt_retorno <= '".$horarioverao."'";
        $sql.=" and r.dt_termino_retorno is null";
        $sql.=" and l.polos_pk = ".$this->arrToken['polos_pk'];
        
        $sql.=" order by r.dt_retorno desc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";

        $sql.="  from retornos ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_retorno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeRetornosConcluidos($token,$usuario_pk){

        $sql ="";
        $sql.="select count(pk)registros ";

        $sql.="  from retornos ";
        $sql.=" where 1=1 ";
        if($usuario_pk){
            $sql.=" and responsavel_pk = ".$usuario_pk;
        }
        $sql.=" and dt_termino_retorno is not null";
        $sql.=" order by dt_retorno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarQtdeRetornoPendente24($usuario_pk){

        //date_default_timezone_set('America/Sao_Paulo');
        $hora = date('H:i:s');			

        $data =  date('Y-m-d');
        
        $sqld.=" select date_format(DATE_ADD('".($data)."',INTERVAL -1  DAY), '%d/%m/%Y') data";

        $query_data = $this->db->execQuery($sqld);
        
        $sql ="";
        $sql.="select COUNT(r.pk) qtde_retorno";
        $sql.="  from retornos r ";
        $sql.="       inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="       inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.="       inner join leads l on o.leads_pk = l.pk";
        $sql.="       inner join equipes_usuarios eu on r.responsavel_pk = eu.usuarios_pk";
        $sql.=" where l.polos_pk = ".$this->arrToken['polos_pk'];
        $sql.="       and r.dt_retorno < sysdate()";
        $sql.="       and r.dt_retorno >= '".DataYMD($query_data[0]['data'])."'";
        $sql.="       and r.dt_termino_retorno is null";
        if($usuario_pk!=""){
            $sql.="       and r.responsavel_pk = ".$usuario_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.="       and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        
        $sql.="       ORDER BY date_format(r.dt_retorno, '%Y/%M/%D') asc";
        
  
        
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeRetornoPendente48($usuario_pk){

        //date_default_timezone_set('America/Sao_Paulo');
        $hora = date('H:i:s');			

        $data =  date('Y-m-d');
        
        $sqld1.=" select date_format(DATE_ADD('".($data)."',INTERVAL -2  DAY), '%d/%m/%Y') data";
        $sqld2.=" select date_format(DATE_ADD('".($data)."',INTERVAL -3  DAY), '%d/%m/%Y') data";

        $query_data1 = $this->db->execQuery($sqld1);
        $query_data2 = $this->db->execQuery($sqld2);
        
        $sql ="";
        $sql.="select COUNT(r.pk) qtde_retorno";
        $sql.="  from retornos r ";
        $sql.="       inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="       inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.="       inner join leads l on o.leads_pk = l.pk";
        $sql.="       inner join equipes_usuarios eu on r.responsavel_pk = eu.usuarios_pk";
        $sql.=" where l.polos_pk = ".$this->arrToken['polos_pk'];
        $sql.="       and r.dt_retorno <= '".DataYMD($query_data1[0]['data'])."'";
        $sql.="       and r.dt_retorno > '".DataYMD($query_data2[0]['data'])."'";
        $sql.="       and r.dt_termino_retorno is null";
        if($usuario_pk!=""){
            $sql.="       and r.responsavel_pk = ".$usuario_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.="       and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        
        $sql.="       ORDER BY date_format(r.dt_retorno, '%Y/%M/%D') asc";
        
  
        
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeRetornoPendente72($usuario_pk){

        //date_default_timezone_set('America/Sao_Paulo');
        $hora = date('H:i:s');			

        $data =  date('Y-m-d');
        
        $sqld.=" select date_format(DATE_ADD('".($data)."',INTERVAL -3  DAY), '%d/%m/%Y') data";

        $query_data = $this->db->execQuery($sqld);
        
        $sql ="";
        $sql.="select COUNT(r.pk) qtde_retorno";
        $sql.="  from retornos r ";
        $sql.="       inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="       inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.="       inner join leads l on o.leads_pk = l.pk";
        $sql.="       inner join equipes_usuarios eu on r.responsavel_pk = eu.usuarios_pk";
        $sql.=" where l.polos_pk = ".$this->arrToken['polos_pk'];
        $sql.="       and r.dt_retorno <= '".DataYMD($query_data[0]['data'])."'";
        $sql.="       and r.dt_termino_retorno is null";
        if($usuario_pk!=""){
            $sql.="       and r.responsavel_pk = ".$usuario_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.="       and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        
        $sql.="       ORDER BY date_format(r.dt_retorno, '%Y/%M/%D') asc";
  
        
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
