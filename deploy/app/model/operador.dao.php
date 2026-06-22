<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/operador.class.php';


class operadordao{

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
    
    public function salvar($operador){

        $fields = array();
        $fields['ds_operador'] = $operador->getds_operador();
        $fields['segmentos_pk'] = $operador->getsegmentos_pk();
        $fields['ic_status'] = $operador->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($operador->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("operadores", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("operadores", $fields, " pk = ".$operador->getpk());
        }

    }
    public function salvarPolo($operador_pk,$ic_status){

        $fields = array();
        $fields['operador_pk'] = $operador_pk;
        $fields['ic_status'] = $ic_status;


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($operador->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("operadores", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("operadores", $fields, " pk = ".$operador->getpk());
        }

    }

    public function excluir($operador){
        $this->db->execDelete("operadores"," pk = ".$operador->getpk());
    }
    public function excluirPolo($pk){
        $this->db->execDelete("polos_operadores"," operadores_pk = ".$pk);
    }

    public function carregarPorPk($pk){

        $operador = new operador();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_operador ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,ic_status ";


        $sql.="  from operadores ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $operador->setpk($query[$i]["pk"]);
                $operador->setdt_cadastro($query[$i]["dt_cadastro"]);
                $operador->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $operador->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $operador->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $operador->setds_operador($query[$i]['ds_operador']);
                $operador->setsegmentos_pk($query[$i]['segmentos_pk']);
                $operador->setic_status($query[$i]['ic_status']);

            }
        }
        return $operador;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_operador ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from operadores ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_operador($ds_operador,$segmneto_pk,$ic_status){
        $sql ="";
        $sql.="select o.pk, o.dt_cadastro, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,o.ds_operador ";
        $sql.="       ,o.segmentos_pk ";
        $sql.="       ,o.ic_status ";
        $sql.="       ,case o.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";
       // $sql.="       ,s.ds_segmento";

        $sql.="  from operadores o";
        $sql.="       left join segmentos s on o.segmentos_pk = s.pk";
        //$sql.="       left join polos_operadores po on po.operadores_pk = o.pk";
        $sql.=" where 1=1 ";
        if($ds_operador != ""){
            $sql.=" and o.ds_operador like '%".$ds_operador."%' ";
        }
        if($segmneto_pk != ""){
            $sql.=" and s.pk=".$segmneto_pk;
        }
        /*if($this->arrToken['polos_pk']!=""){
            $sql.=" and po.polos_pk = ".$this->arrToken['polos_pk'];
        }*/
        if($ic_status!=""){
            $sql.= " and o.ic_status = ".$ic_status;
        }
        else{
            $sql.= " and o.ic_status = 1";
        }
        
        $sql.=" order by o.ds_operador asc ";   

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_polo(){
        $sql ="";
        $sql.="select o.pk, o.dt_cadastro, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,o.ds_operador ";
        $sql.="       ,o.segmentos_pk ";
        $sql.="       ,o.ic_status ";
        $sql.="       ,case o.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";
        $sql.="       ,s.ds_segmento";

        $sql.="  from operadores o";
        $sql.="       left join segmentos s on o.segmentos_pk = s.pk";
        $sql.="       inner join polos_operadores po on po.operadores_pk = o.pk";
        $sql.=" where 1=1 ";
        $sql.=" and o.ic_status= 1";
        $sql.=" and po.polos_pk = ".$this->arrToken['polos_pk'];
        $sql.=" order by o.ds_operador asc ";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_operador ";
        $sql.="       ,segmentos_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from operadores ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_operador asc ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarClassificacaoOperador($operador_pk,$ds_operador){

        $sql ="";
        $sql.="select co.pk,co.ds_classificacao ";

        $sql.="  from classificacao_operadoras co ";
        $sql.="       inner join operadores o on co.operadoras_pk = o.pk";
        $sql.=" where 1=1 ";
        if($operador_pk!=""){
            $sql.=" and o.pk  =".$operador_pk;
        }
        if($ds_operador!=""){
            $sql.=" and o.ds_operador like '%".$ds_operador."%'";
        }
        
        $sql.=" order by co.ds_classificacao asc";


        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
