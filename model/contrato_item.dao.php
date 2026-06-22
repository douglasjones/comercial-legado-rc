<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/contrato_item.class.php';


class contrato_itemdao{

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
    
    public function salvar($contrato_item){

        $fields = array();
        $fields['n_qtde'] = $contrato_item->getn_qtde();
        $fields['vl_unit'] = $contrato_item->getvl_unit();
        $fields['vl_total'] = $contrato_item->getvl_total();
        $fields['contratos_pk'] = $contrato_item->getcontratos_pk();
        $fields['produtos_servicos_pk'] = $contrato_item->getprodutos_servicos_pk();
        $fields['n_qtde_dias_semana'] = $contrato_item->getn_qtde_dias_semana();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($contrato_item->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("contratos_itens", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("contratos_itens", $fields, " pk = ".$contrato_item->getpk());
        }

    }

    public function excluir($contrato_item){
        $this->db->execDelete("contratos_itens"," pk = ".$contrato_item->getpk());
    }

    public function carregarPorPk($pk){

        $contrato_item = new contrato_item();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde_dias_semana ";


        $sql.="  from contratos_itens ";
        $sql.=" where pk = $pk ";
     
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $contrato_item->setpk($query[$i]["pk"]);
                $contrato_item->setdt_cadastro($query[$i]["dt_cadastro"]);
                $contrato_item->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $contrato_item->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $contrato_item->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
                $contrato_item->setn_qtde_dias_semana($query[$i]["n_qtde_dias_semana"]);

                $contrato_item->setn_qtde($query[$i]['n_qtde']);
                $contrato_item->setvl_unit($query[$i]['vl_unit']);
                $contrato_item->setvl_total($query[$i]['vl_total']);
                $contrato_item->setcontratos_pk($query[$i]['contratos_pk']);
                $contrato_item->setprodutos_servicos_pk($query[$i]['produtos_servicos_pk']);

            }
        }
        return $contrato_item;
    }
    
    public function carregarPorContratosPk($contratos_pk){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde_dias_semana ";


        $sql.="  from contratos_itens ";
        $sql.=" where contratos_pk = $contratos_pk ";
       
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde_dias_semana ";

        $sql.="  from contratos_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarContratoItem($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde_dias_semana";

        $sql.="  from contratos_itens ";
        if($pk!=""){
            $sql.=" where contratos_pk = $pk ";
        }
       
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_n_qtde($n_qtde){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde_dias_semana ";

        $sql.="  from contratos_itens ";
        $sql.=" where 1=1 ";
        if($n_qtde != ""){
            $sql.=" and ds_contrato_item like '%".$n_qtde."%' ";
        }
        $sql.=" order by n_qtde asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,n_qtde ";
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde_dias_semana";

        $sql.="  from contratos_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by n_qtde asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function excluirPorContrato($contrato_pk){
        $this->db->execDelete("contratos_itens"," contratos_pk = ".$contrato_pk);
    }

}

?>
