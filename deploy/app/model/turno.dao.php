<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/turno.class.php';


class turnodao{

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
    
    public function salvar($turno){

        $fields = array();
        $fields['ds_turno'] = $turno->getds_turno();

        if($turno->getpk()  == ""){


            $pk = $this->db->execInsert("turnos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("turnos", $fields, " pk = ".$turno->getpk());
        }

    }

    public function excluir($turno){
        $this->db->execDelete("turnos"," pk = ".$turno->getpk());
    }

    public function carregarPorPk($pk){

        $turno = new turno();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="       ,ds_turno ";


        $sql.="  from turnos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $turno->setpk($query[$i]["pk"]);

                $turno->setds_turno($query[$i]['ds_turno']);

            }
        }
        return $turno;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk";
        $sql.="       ,ds_turno ";

        $sql.="  from turnos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_turno($ds_turno){

        $sql ="";
        $sql.="select pk ";
        $sql.="       ,ds_turno ";

        $sql.="  from turnos ";
        $sql.=" where 1=1 ";
        if($ds_turno != ""){
            $sql.=" and ds_turno like '%".$ds_turno."%' ";
        }
        $sql.=" order by ds_turno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk ";
        $sql.="       ,ds_turno ";

        $sql.="  from turnos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_turno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
