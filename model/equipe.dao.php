<? error_reporting(0);

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/equipe.class.php';


class equipedao{

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
    
    public function salvar($equipe){

        $fields = array();
        $fields['ds_equipe'] = $equipe->getds_equipe();
        $fields['polos_pk'] = $equipe->getpolos_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($equipe->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("equipes", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("equipes", $fields, " pk = ".$equipe->getpk());
        }

    }

    public function excluir($equipe){
        $this->db->execDelete("equipes"," pk = ".$equipe->getpk());
    }

    public function carregarPorPk($pk){

        $equipe = new equipe();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_equipe ";


        $sql.="  from equipes ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $equipe->setpk($query[$i]["pk"]);
                $equipe->setdt_cadastro($query[$i]["dt_cadastro"]);
                $equipe->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $equipe->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $equipe->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $equipe->setds_equipe($query[$i]['ds_equipe']);

            }
        }
        return $equipe;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_equipe ";
        $sql.="       ,polos_pk ";
        
        $sql.="  from equipes ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_equipe($ds_equipe,$polos_pk,$token){
        
        $sql ="";
        $sql.="select e.pk, e.dt_cadastro, e.usuario_cadastro_pk, e.dt_ult_atualizacao, e.usuario_ult_atualizacao_pk ";
        $sql.="       ,e.ds_equipe ";

        $sql.="  from equipes e";
        $sql.="       inner join equipes_usuarios eu on eu.equipes_pk = e.pk";
        $sql.=" where 1=1 ";
        if($ds_equipe != ""){
            $sql.=" and e.ds_equipe like '%".$ds_equipe."%' ";
        }
        if($polos_pk!=""){
            $sql.=" and e.polos_pk = ".$polos_pk;
        }
        if(!permissao("equipes_listar_todos", "cons", $token)){  
            if($this->arrToken['equipes_pk']!=""){
                $sql.=" and e.pk=".$this->arrToken['equipes_pk'];
            }
            $sql.="     and eu.usuarios_pk=".$this->arrToken['usuarios_pk'];
        }
        $sql.="     and e.contas_pk=".$this->arrToken['contas_pk'];
        
        $sql.=" group by e.pk";
        $sql.=" order by e.ds_equipe asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_conta(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_equipe ";

        $sql.="  from equipes ";
        $sql.=" where 1=1 ";
        $sql.=" and contas_pk=".$this->arrToken['contas_pk'];
        $sql.=" order by ds_equipe asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_usuarios_equipe($pk){

        $sql ="";
        $sql.="select e.pk, e.dt_cadastro, e.usuario_cadastro_pk, e.dt_ult_atualizacao, e.usuario_ult_atualizacao_pk ";
        $sql.="       ,e.ds_equipe ";
        $sql.="       ,eu.usuarios_pk";
        $sql.="       ,eu.ic_bko";
        $sql.="       ,eu.ic_supervisor";

        $sql.="  from equipes e";
        $sql.="       inner join equipes_usuarios eu on e.pk = eu.equipes_pk";
        $sql.=" where 1=1 ";
        if($pk != ""){
            $sql.=" and eu.equipes_pk=".$pk;
        }
        $sql.=" order by e.ds_equipe asc ";
  

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_usuarios_equipe_calendario($token){

        $sql ="";
        $sql.="select e.pk, e.dt_cadastro, e.usuario_cadastro_pk, e.dt_ult_atualizacao, e.usuario_ult_atualizacao_pk ";
        $sql.="       ,e.ds_equipe ";
        //$sql.="       ,eu.usuarios_pk";
        //$sql.="       ,eu.ic_bko";
        //$sql.="       ,eu.ic_supervisor";

        $sql.="  from equipes e";
        $sql.="       inner join equipes_usuarios eu on e.pk = eu.equipes_pk";
        $sql.=" where 1=1 ";
        if(!permissao("supervisor_listar_equipes", "cons", $token)){
            if($this->arrToken['equipes_pk']!=""){
                $sql.=" and e.pk = ".$this->arrToken['equipes_pk'];
            }
        }
        if(!permissao("equipes_listar_todos", "cons", $token)){  
            if($this->arrToken['equipes_pk']!=""){
                $sql.=" and e.pk=".$this->arrToken['equipes_pk'];
            }
            $sql.=" and eu.usuarios_pk = ".$this->arrToken['usuarios_pk'];
        }
        $sql.=" order by e.ds_equipe asc ";
  

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_equipe ";

        $sql.="  from equipes ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_equipe asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function adicionarEquipesUsuarios($equipes_pk,$usuarios_pk,$ic_bko,$ic_supervisor){
        
        
        $fields["equipes_pk"] = $equipes_pk;
        $fields["usuarios_pk"] = $usuarios_pk;
        $fields["ic_bko"] = $ic_bko;
        $fields["ic_supervisor"] = $ic_supervisor;
        
        $this->db->execInsert("equipes_usuarios", $fields);

    }
    public function excluirEquipeUsuario($pk){
        $this->db->execDelete("equipes_usuarios"," equipes_pk = ".$pk);
    }

}

?>
