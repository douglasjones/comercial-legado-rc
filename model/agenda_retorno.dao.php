<?
ini_set('memory_limit','550M');
include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/agenda_retorno.class.php';


class agenda_retornodao{

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
    
    public function salvar($agenda_retorno){

        $fields = array();
        $fields['dt_retorno'] = $agenda_retorno->getdt_retorno();
        $fields['equipes_pk'] = $agenda_retorno->getequipes_pk();
        $fields['responsavel_pk'] = $agenda_retorno->getresponsavel_pk();
        $fields['dt_termino_retorno'] = $agenda_retorno->getdt_termino_retorno();
        $fields['ds_retorno'] = $agenda_retorno->getds_retorno();
        $fields['ocorrencias_pk	'] = $agenda_retorno->getocorrencias_pk	();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($agenda_retorno->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("retornos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("retornos", $fields, " pk = ".$agenda_retorno->getpk());
        }

    }

    public function excluir($agenda_retorno){
        $this->db->execDelete("retornos"," pk = ".$agenda_retorno->getpk());
    }

    public function carregarPorPk($pk){

        $agenda_retorno = new agenda_retorno();
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
        $sql.="       ,ocorrencias_pk	 ";


        $sql.="  from retornos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agenda_retorno->setpk($query[$i]["pk"]);
                $agenda_retorno->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agenda_retorno->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agenda_retorno->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agenda_retorno->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agenda_retorno->setdt_retorno($query[$i]['dt_retorno']);
                $agenda_retorno->setequipes_pk($query[$i]['equipes_pk']);
                $agenda_retorno->setresponsavel_pk($query[$i]['responsavel_pk']);
                $agenda_retorno->setdt_termino_retorno($query[$i]['dt_termino_retorno']);
                $agenda_retorno->setds_retorno($query[$i]['ds_retorno']);
                $agenda_retorno->setocorrencias_pk	($query[$i]['ocorrencias_pk	']);

            }
        }
        return $agenda_retorno;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk	 ";

        $sql.="  from retornos ";
        $sql.=" where pk = $pk ";
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
        $sql.="       ,ocorrencias_pk	 ";

        $sql.="  from retornos ";
        $sql.=" where 1=1 ";
        if($dt_retorno != ""){
            $sql.=" and ds_agenda_retorno like '%".$dt_retorno."%' ";
        }
        $sql.=" order by dt_retorno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_agenda_retorno($dt_base,$dt_base_fim,$ocorrencias_pk,$equipes_pk,$responsavel_pk){

        $sql ="";
        $sql.="select r.pk, r.dt_cadastro, r.usuario_cadastro_pk, r.dt_ult_atualizacao, r.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y')dt_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y')dt_termino_retorno ";
        $sql.="       ,date_format(r.dt_retorno, '%H:%i')hr_retorno ";
        $sql.="       ,date_format(r.dt_retorno, '%d/%m/%Y %H:%i')dt_hr_retorno ";
        $sql.="       ,r.equipes_pk ";
        $sql.="       ,r.responsavel_pk ";
        $sql.="       ,r.dt_termino_retorno ";
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,r.ocorrencias_pk	 ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,l.pk leads_pk";
        $sql.="       ,tpo.ds_tipo_ocorrencia ds_ocorrencia ";
        $sql.="       ,e.ds_equipe ";
        $sql.="       ,u.ds_usuario";

        $sql.="  from retornos r";
        $sql.="       inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="       inner join tipos_ocorrencias tpo on o.tipos_ocorrencias_pk = tpo.pk";
        $sql.="       left join equipes e on r.equipes_pk = e.pk";
        $sql.="       left join usuarios u on r.responsavel_pk = u.pk";
        $sql.="       inner join leads l on o.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and date_format(r.dt_retorno,'%Y-%m-%d') >= '".DataYMD($dt_base)." '";
        $sql.=" and date_format(r.dt_retorno,'%Y-%m-%d') <='".DataYMD($dt_base_fim)." '";
        if($ocorrencias_pk != ""){
            $sql.=" and o.tipos_ocorrencias_pk =".$ocorrencias_pk;
        }
        if($equipes_pk != ""){
            $sql.=" and e.pk =".$equipes_pk;
        }
        if($responsavel_pk != ""){
            $sql.=" and r.responsavel_pk =".$responsavel_pk;
        }
        $sql.=" and l.contas_pk = ".$this->arrToken['contas_pk'];

        $sql.=" order by date_format(r.dt_retorno, '%Y/%m/%d %H:%i') desc";
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
        $sql.="       ,ocorrencias_pk	 ";

        $sql.="  from retornos ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_retorno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_agenda_retorno_data($dt_base,$dt_base_fim,$equipes_pk,$responsavel_pk){
                
        $sql ="";
        $sql.="select r.pk, r.dt_cadastro, r.usuario_cadastro_pk, r.dt_ult_atualizacao, r.usuario_ult_atualizacao_pk ";
        $sql.="       ,o.leads_pk";
        $sql.="       ,date_format(r.dt_retorno, '%H:%i') hr_retorno";
        $sql.="       ,date_format(r.dt_retorno, '%H%i') hrRetorno_comparar";
        $sql.="       ,date_format(r.dt_retorno, '%d/%m/%Y') dt_retorno";
        $sql.="       ,r.dt_retorno dt_retorno_ordenacao";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y') dt_termino_retorno";        
        $sql.="       ,e.ds_equipe";
        $sql.="       ,r.equipes_pk";
        $sql.="       ,u.ds_usuario ds_responsavel ";
        $sql.="       ,r.responsavel_pk ";
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,r.ocorrencias_pk "; 
        $sql.="       ,l.ds_lead condominio ";    
        $sql.="       ,o.pk ocorrencia_pk";
        $sql.="       ,o.dt_fechamento";
        $sql.="       ,o.tipos_ocorrencias_pk";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="  from retornos r ";
        $sql.="       left join equipes e on r.equipes_pk = e.pk";
        $sql.="       left join usuarios u on r.responsavel_pk = u.pk";
        $sql.="       inner join ocorrencias o on r.ocorrencias_pk = o.pk";
        $sql.="       inner join leads l on o.leads_pk = l.pk";
        $sql.=" where 1=1 ";

       // if($dt_agenda!=""){
        $sql.=" and r.dt_retorno >= '".DataYMD($dt_base)." '";
        $sql.=" and r.dt_retorno <='".DataYMD($dt_base_fim)." '";
        
            //$sql.=" and r.dt_retorno >= '".$ano."-".$mes."-".$dia." 00:00:00'";
            //$sql.=" and r.dt_retorno <='".$ano."-".$mes."-".$dia." 23:59:59'";
        //}
        //Equipe do Retorno    
        if($equipes_pk!=""){
            $sql.=" and r.equipes_pk = ".$equipes_pk;
        }
        //Responsavel do Retorno    
        if($responsavel_pk!=""){
            $sql.=" and r.responsavel_pk = ".$responsavel_pk;
        }
           
        $sql.=" order by dt_retorno_ordenacao desc"; 
      
        $query = $this->db->execQuery($sql);
        return $query;

    }
     public function listar_data($dt_agenda){

        $sql ="";
        $sql.="select date_format('".  DataYMD($dt_agenda)."','%w')dia_semana";

        $query = $this->db->execQuery($sql);
        return $query;

    }
     public function listar_hoje(){

        $sql ="";
        $sql.=" select date_format(sysdate(), '%d/%m/%Y') data";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
