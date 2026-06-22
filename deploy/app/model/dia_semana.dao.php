<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/dia_semana.class.php';


class dia_semanadao{

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
    
    public function salvar($dia_semana){

        $fields = array();
        $fields['ds_dia_semana'] = $dia_semana->getds_dia_semana();



        if($dia_semana->getpk()  == ""){


            $pk = $this->db->execInsert("dias_semana", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("dias_semana", $fields, " pk = ".$dia_semana->getpk());
        }

    }

    public function excluir($dia_semana){
        $this->db->execDelete("dias_semana"," pk = ".$dia_semana->getpk());
    }

    public function carregarPorPk($pk){

        $dia_semana = new dia_semana();
        if($pk != ""){
            
        $sql ="select pk ";

        $sql.="       ,ds_dia_semana ";


        $sql.="  from dias_semana ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $dia_semana->setpk($query[$i]["pk"]);

                $dia_semana->setds_dia_semana($query[$i]['ds_dia_semana']);

            }
        }
        return $dia_semana;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk";
        $sql.="       ,ds_dia_semana ";

        $sql.="  from dias_semana ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_dia_semana($ds_dia_semana){

        $sql ="";
        $sql.="select pk";
        $sql.="       ,ds_dia_semana ";

        $sql.="  from dias_semana ";
        $sql.=" where 1=1 ";
        if($ds_dia_semana != ""){
            $sql.=" and ds_dia_semana like '%".$ds_dia_semana."%' ";
        }
        $sql.=" order by pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk";
        $sql.="       ,ds_dia_semana ";

        $sql.="  from dias_semana ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_dia_semana asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
