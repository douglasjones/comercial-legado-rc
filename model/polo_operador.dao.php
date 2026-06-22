<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/polo_operador.class.php';


class polo_operadordao{

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
    
    public function salvar($polo_operador){

        $fields = array();
        $fields['polos_pk'] = $polo_operador->getpolos_pk();
        $fields['operadores_pk'] = $polo_operador->getoperadores_pk();
        $fields['ic_status'] = $polo_operador->getic_status();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
   
        if($polo_operador->getpk()  == ""){
      
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("polos_operadores", $fields);
            //$this->db->execInsert("polos_operadores", $fields);
            //echo $this->db->getLastSQL();
            //exit;            
            
            return $pk;
        }
        else{  
            return $this->db->execUpdate("polos_operadores", $fields, " pk = ".$polo_operador->getpk());
            
            //$this->db->execUpdate("polos_operadores", $fields, " pk = ".$polo_operador->getpk());
            //echo $this->db->getLastSQL();
            //exit;  
        }

    }
    public function salvarPolo($polo_operador){

        $fields = array();
        $fields['polos_pk'] = $this->arrToken['polos_pk'];
        $fields['operadores_pk'] = $polo_operador->getoperadores_pk();
        $fields['ic_status'] = $polo_operador->getic_status();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
   
        if($polo_operador->getpk()  == ""){
      
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("polos_operadores", $fields);
            //$this->db->execInsert("polos_operadores", $fields);
            //echo $this->db->getLastSQL();
            //exit;            
            
            return $pk;
        }
        else{  
            return $this->db->execUpdate("polos_operadores", $fields, " pk = ".$polo_operador->getpk());
            
            //$this->db->execUpdate("polos_operadores", $fields, " pk = ".$polo_operador->getpk());
            //echo $this->db->getLastSQL();
            //exit;  
        }

    }

    public function excluir($polo_operador){
        $this->db->execDelete("polos_operadores"," pk = ".$polo_operador->getpk());
    }

    public function carregarPorPk($pk){

        $polo_operador = new polo_operador();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operadores_pk ";
        $sql.="       ,ic_status ";
        $sql.="  from polos_operadores ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $polo_operador->setpk($query[$i]["pk"]);
                $polo_operador->setdt_cadastro($query[$i]["dt_cadastro"]);
                $polo_operador->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $polo_operador->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $polo_operador->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $polo_operador->setpolos_pk($query[$i]['polos_pk']);
                $polo_operador->setoperadores_pk($query[$i]['operadores_pk']);
                $polo_operador->setic_status($query[$i]['ic_status']);

            }
        }
        return $polo_operador;
    }
    public function carregarPorOperadorPk($operador_pk){

        $polo_operador = new polo_operador();
        if($operador_pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operadores_pk ";
        $sql.="       ,ic_status ";
        $sql.="  from polos_operadores ";
        $sql.=" where operadores_pk = $operador_pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $polo_operador->setpk($query[$i]["pk"]);
                $polo_operador->setdt_cadastro($query[$i]["dt_cadastro"]);
                $polo_operador->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $polo_operador->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $polo_operador->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $polo_operador->setpolos_pk($query[$i]['polos_pk']);
                $polo_operador->setoperadores_pk($query[$i]['operadores_pk']);
                $polo_operador->setic_status($query[$i]['ic_status']);

            }
        }
        return $polo_operador;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operadores_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from polos_operadores ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_polos_pk($polos_pk){

        $sql ="";
        $sql.="select po.pk, po.dt_cadastro, po.usuario_cadastro_pk, po.dt_ult_atualizacao, po.usuario_ult_atualizacao_pk ";
        $sql.="       ,po.polos_pk ";
        $sql.="       ,po.operadores_pk ";
        $sql.="       ,o.ds_operador ";
        $sql.="       ,s.ds_segmento ";
        $sql.="       ,o.segmentos_pk ";
        $sql.="       ,po.ic_status ";
        $sql.="      ,CASE po.ic_status WHEN 1 THEN 'Ativo' WHEN 2 THEN 'Inativo' END ds_status"; 
        $sql.="  from polos_operadores po ";
        $sql.="  inner join operadores o on po.operadores_pk = o.pk ";   
        $sql.="  inner join segmentos s on o.segmentos_pk = s.pk";
        $sql.=" where 1=1 ";
        if($polos_pk != ""){
            $sql.=" and po.polos_pk =".$polos_pk;   
        }
        else{
            $sql.=" and po.polos_pk = 0 ";
        }
        $sql.=" order by polos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }   

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operadores_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from polos_operadores ";
        $sql.=" where 1=1 ";
        $sql.=" order by polos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
