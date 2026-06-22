<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/proposta_item.class.php';


class proposta_itemdao{

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
    
    public function salvar($proposta_item){

        $fields = array();
        $fields['produtos_servicos_pk'] = $proposta_item->getprodutos_servicos_pk();
        $fields['n_qtde'] = $proposta_item->getn_qtde();
        
        $fields['vl_unit'] = $proposta_item->getvl_unit();
        $fields['vl_total'] = $proposta_item->getvl_total();
        $fields['propostas_pk'] = $proposta_item->getpropostas_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($proposta_item->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("propostas_itens", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("propostas_itens", $fields, " pk = ".$proposta_item->getpk());
        }

    }

    public function excluir($proposta_item){
        $this->db->execDelete("propostas_itens"," pk = ".$proposta_item->getpk());
    }

    public function carregarPorPk($pk){

        $proposta_item = new proposta_item();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde ";      
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,propostas_pk ";


        $sql.="  from propostas_itens ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $proposta_item->setpk($query[$i]["pk"]);
                $proposta_item->setdt_cadastro($query[$i]["dt_cadastro"]);
                $proposta_item->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $proposta_item->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $proposta_item->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $proposta_item->setprodutos_servicos_pk($query[$i]['produtos_servicos_pk']);
                $proposta_item->setn_qtde($query[$i]['n_qtde']);
                $proposta_item->setvl_unit($query[$i]['vl_unit']);
                $proposta_item->setvl_total($query[$i]['vl_total']);
                $proposta_item->setpropostas_pk($query[$i]['propostas_pk']);

            }
        }
        return $proposta_item;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde ";      
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,propostas_pk ";

        $sql.="  from propostas_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_produtos_servicos_pk($produtos_servicos_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde ";      
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,propostas_pk ";

        $sql.="  from propostas_itens ";
        $sql.=" where 1=1 ";
        if($produtos_servicos_pk != ""){
            $sql.=" and ds_proposta_item like '%".$produtos_servicos_pk."%' ";
        }
        $sql.=" order by produtos_servicos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,produtos_servicos_pk ";
        $sql.="       ,n_qtde ";       
        $sql.="       ,vl_unit ";
        $sql.="       ,vl_total ";
        $sql.="       ,propostas_pk ";

        $sql.="  from propostas_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by produtos_servicos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPropostaItem($pk){
     
        $sql ="";
        $sql.="select pi.pk, pi.dt_cadastro, pi.usuario_cadastro_pk, pi.dt_ult_atualizacao, pi.usuario_ult_atualizacao_pk  ";
        $sql.="       ,pi.vl_unit ";
        $sql.="       ,pi.vl_total ";
        $sql.="       ,pi.propostas_pk ";
        $sql.="       ,pi.produtos_servicos_pk ";
        $sql.="       ,pi.n_qtde";
        $sql.="       ,ps.ds_produto_servico";

        $sql.="  from propostas_itens pi ";
        $sql.="       left join produtos_servicos ps on pi.produtos_servicos_pk = ps.pk";
        if($pk!=""){
            $sql.=" where pi.propostas_pk = $pk ";
        }

        $query = $this->db->execQuery($sql);
        return $query;
    }   

}
?>
