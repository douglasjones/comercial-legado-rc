<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/usuario_polo.class.php';


class usuario_polodao{

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
    
    public function salvar($usuario_polo){
        
        $fields = array();
        $fields['pk'] = $usuario_polo->getpk();
        $fields['polos_pk'] = $usuario_polo->getpolos_pk();
        $fields['usuarios_pk'] = $usuario_polo->getusuarios_pk();
        $fields['ic_status'] = 1;

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        
        if($usuario_polo->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
     
            $pk = $this->db->execInsert("usuarios_polos", $fields);
            //$this->db->execInsert("usuarios_polos", $fields);
            //echo $this->db->getLastSQL();              
            return $pk;
        }else{
            return $this->db->execUpdate("usuarios_polos", $fields, " pk = ".$usuario_polo->getpk());
        }
    }

    public function excluir($usuario_polo){
        $this->db->execDelete("usuarios_polos"," pk = ".$usuario_polo->getpk());
    }

    public function carregarPorPk($pk){
   
        $usuario_polo = new usuario_polo();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,polos_pk ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,ic_status ";


        $sql.="  from usuarios_polos ";        
        $sql.=" where pk = $pk ";

            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $usuario_polo->setpk($query[$i]["pk"]);
                $usuario_polo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $usuario_polo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $usuario_polo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $usuario_polo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $usuario_polo->setpolos_pk($query[$i]['polos_pk']);
                $usuario_polo->setusuarios_pk($query[$i]['usuarios_pk']);
                $usuario_polo->setic_status($query[$i]['ic_status']);

            }
        }

        return $usuario_polo;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,polos_pk ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from usuarios_polos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_polos_pk($polos_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from usuarios_polos ";
        $sql.=" where 1=1 ";
        if($polos_pk != ""){
            $sql.=" and ds_usuario_polo like '%".$polos_pk."%' ";
        }
        $sql.=" order by polos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_polos_por_usuario($polos_pk,$usuarios_pk){
        
        $sql ="";
        $sql.="select up.pk, up.dt_cadastro, up.usuario_cadastro_pk, up.dt_ult_atualizacao, up.usuario_ult_atualizacao_pk ";
        $sql.="       ,up.polos_pk ";
        $sql.="       ,up.usuarios_pk ";
        $sql.="       ,up.ic_status ";
        $sql.="       ,p.ds_polo";
        $sql.="  from usuarios_polos up";
        $sql.="  inner join polos p on up.polos_pk = p.pk";
        $sql.=" where 1=1 ";
        if($polos_pk != ""){
            $sql.=" and up.ds_usuario_polo like '%".$polos_pk."%' ";
        }
        if($usuarios_pk != ""){
            $sql.=" and up.usuarios_pk=".$usuarios_pk;
        }
        $sql.=" order by polos_pk asc ";

        
       

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,ic_status ";

        $sql.="  from usuarios_polos ";
        $sql.=" where 1=1 ";
        $sql.=" order by polos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
