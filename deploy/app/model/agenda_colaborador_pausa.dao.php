<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/agenda_colaborador_pausa.class.php';


class agenda_colaborador_pausadao{

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
    
    public function salvar($agenda_colaborador_pausa){

        $fields = array();
        $fields['ds_agenda_colaborador_pausa'] = $agenda_colaborador_pausa->getds_agenda_colaborador_pausa();
        $fields['dt_inicio_pausa'] = $agenda_colaborador_pausa->getdt_inicio_pausa();
        $fields['dt_fim_pausa'] = $agenda_colaborador_pausa->getdt_fim_pausa();
        $fields['motivos_pausas_pk'] = $agenda_colaborador_pausa->getmotivos_pausas_pk();
        $fields['colaboradores_pk'] = $agenda_colaborador_pausa->getcolaboradores_pk();
        $fields['turnos_pk'] = $agenda_colaborador_pausa->getturnos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($agenda_colaborador_pausa->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("agenda_colaborador_pausa", $fields);
            
            return $pk;
        }
        else{
            return $this->db->execUpdate("agenda_colaborador_pausa", $fields, " pk = ".$agenda_colaborador_pausa->getpk());
        }

    }

    public function excluir($agenda_colaborador_pausa){
        $this->db->execDelete("agenda_colaborador_pausa"," pk = ".$agenda_colaborador_pausa->getpk());
    }

    public function carregarPorPk($pk){

        $agenda_colaborador_pausa = new agenda_colaborador_pausa();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_agenda_colaborador_pausa ";
        $sql.="       ,dt_inicio_pausa ";
        $sql.="       ,dt_fim_pausa ";
        $sql.="       ,motivos_pausas_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,turnos_pk ";


        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agenda_colaborador_pausa->setpk($query[$i]["pk"]);
                $agenda_colaborador_pausa->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agenda_colaborador_pausa->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agenda_colaborador_pausa->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agenda_colaborador_pausa->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agenda_colaborador_pausa->setds_agenda_colaborador_pausa($query[$i]['ds_agenda_colaborador_pausa']);
                $agenda_colaborador_pausa->setdt_inicio_pausa($query[$i]['dt_inicio_pausa']);
                $agenda_colaborador_pausa->setdt_fim_pausa($query[$i]['dt_fim_pausa']);
                $agenda_colaborador_pausa->setmotivos_pausas_pk($query[$i]['motivos_pausas_pk']);
                $agenda_colaborador_pausa->setcolaboradores_pk($query[$i]['colaboradores_pk']);
                $agenda_colaborador_pausa->setturnos_pk($query[$i]['turnos_pk']);

            }
        }
        return $agenda_colaborador_pausa;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_agenda_colaborador_pausa ";
        $sql.="       ,dt_inicio_pausa ";
        $sql.="       ,dt_fim_pausa ";
        $sql.="       ,motivos_pausas_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,turnos_pk ";

        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_agenda_colaborador_pausa ";
        $sql.="       ,dt_inicio_pausa ";
        $sql.="       ,dt_fim_pausa ";
        $sql.="       ,motivos_pausas_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,turnos_pk ";

        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where 1=1 ";
        if($ds_agenda_colaborador_pausa != ""){
            $sql.=" and ds_agenda_colaborador_pausa like '%".$ds_agenda_colaborador_pausa."%' ";
        }
        $sql.=" order by ds_agenda_colaborador_pausa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_agenda_colaborador_pausa ";
        $sql.="       ,dt_inicio_pausa ";
        $sql.="       ,dt_fim_pausa ";
        $sql.="       ,motivos_pausas_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,turnos_pk ";

        $sql.="  from agenda_colaborador_pausa ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_agenda_colaborador_pausa asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
