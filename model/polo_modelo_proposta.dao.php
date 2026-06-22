<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/polo_modelo_proposta.class.php';


class polo_modelo_propostadao{

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
    
    public function salvar($polo_modelo_proposta){

        $fields = array();
        $fields['tipo_modelo_pk'] = $polo_modelo_proposta->gettipo_modelo_pk();
        $fields['tipo_envio_pk'] = $polo_modelo_proposta->gettipo_envio_pk();
        $fields['ds_email'] = $polo_modelo_proposta->getds_email();
        $fields['html_modelo'] = $polo_modelo_proposta->gethtml_modelo();
        $fields['polos_pk'] = $polo_modelo_proposta->getpolos_pk();
        $fields['operador_pk'] = $polo_modelo_proposta->getoperador_pk();
        $fields['status_pk'] = $polo_modelo_proposta->getstatus_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($polo_modelo_proposta->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("polos_modelos_propostas", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("polos_modelos_propostas", $fields, " pk = ".$polo_modelo_proposta->getpk());
        }

    }

    public function excluir($polo_modelo_proposta){
        $this->db->execDelete("polos_modelos_propostas"," pk = ".$polo_modelo_proposta->getpk());
    }

    public function carregarPorPk($pk){

        $polo_modelo_proposta = new polo_modelo_proposta();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_modelo_pk ";
        $sql.="       ,tipo_envio_pk ";
        $sql.="       ,ds_email ";
        $sql.="       ,html_modelo ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operador_pk ";
        $sql.="       ,status_pk ";


        $sql.="  from polos_modelos_propostas ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $polo_modelo_proposta->setpk($query[$i]["pk"]);
                $polo_modelo_proposta->setdt_cadastro($query[$i]["dt_cadastro"]);
                $polo_modelo_proposta->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $polo_modelo_proposta->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $polo_modelo_proposta->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $polo_modelo_proposta->settipo_modelo_pk($query[$i]['tipo_modelo_pk']);
                $polo_modelo_proposta->settipo_envio_pk($query[$i]['tipo_envio_pk']);
                $polo_modelo_proposta->setds_email($query[$i]['ds_email']);
                $polo_modelo_proposta->sethtml_modelo($query[$i]['html_modelo']);
                $polo_modelo_proposta->setpolos_pk($query[$i]['polos_pk']);
                $polo_modelo_proposta->setoperador_pk($query[$i]['operador_pk']);
                $polo_modelo_proposta->setstatus_pk($query[$i]['status_pk']);

            }
        }
        return $polo_modelo_proposta;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_modelo_pk ";
        $sql.="       ,tipo_envio_pk ";
        $sql.="       ,ds_email ";
        $sql.="       ,html_modelo ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operador_pk ";
        $sql.="       ,status_pk ";

        $sql.="  from polos_modelos_propostas ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_tipo_modelo_pk($tipo_modelo_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_modelo_pk ";
        $sql.="       ,tipo_envio_pk ";
        $sql.="       ,ds_email ";
        $sql.="       ,html_modelo ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operador_pk ";
        $sql.="       ,status_pk ";

        $sql.="  from polos_modelos_propostas ";
        $sql.=" where 1=1 ";
        if($tipo_modelo_pk != ""){
            $sql.=" and ds_polo_modelo_proposta like '%".$tipo_modelo_pk."%' ";
        }
        $sql.=" order by tipo_modelo_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_modelo_pk ";
        $sql.="       ,tipo_envio_pk ";
        $sql.="       ,ds_email ";
        $sql.="       ,html_modelo ";
        $sql.="       ,polos_pk ";
        $sql.="       ,operador_pk ";
        $sql.="       ,status_pk ";

        $sql.="  from polos_modelos_propostas ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_modelo_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_polo($polos_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.tipo_modelo_pk ";
        $sql.="       ,p.tipo_envio_pk ";
        $sql.="       ,p.ds_email ";
        $sql.="       ,p.html_modelo ";
        $sql.="       ,p.polos_pk ";
        $sql.="       ,p.operador_pk ";
        $sql.="       ,p.status_pk ";
        $sql.="       ,o.ds_operador";
        $sql.="       ,case p.status_pk when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";

        $sql.="  from polos_modelos_propostas p";
        $sql.="        inner join operadores o on p.operador_pk = o.pk";
        $sql.=" where 1=1 ";
        if($polos_pk!=""){
            $sql.="  and p.polos_pk = ".$polos_pk;
        }
        $sql.=" order by p.tipo_modelo_pk asc ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_operador($operador_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.tipo_modelo_pk ";
        $sql.="       ,p.tipo_envio_pk ";
        $sql.="       ,p.ds_email ";
        $sql.="       ,p.html_modelo ";
        $sql.="       ,p.polos_pk ";
        $sql.="       ,p.operador_pk ";
        $sql.="       ,p.status_pk ";
        $sql.="       ,o.ds_operador";
        $sql.="       ,case p.status_pk when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";

        $sql.="  from polos_modelos_propostas p";
        $sql.="        inner join operadores o on p.operador_pk = o.pk";
        $sql.=" where 1=1 ";
        if($operador_pk!=""){
            $sql.="  and p.operador_pk = ".$operador_pk;
        }
        $sql.=" order by p.tipo_modelo_pk asc ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
