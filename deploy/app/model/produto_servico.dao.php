<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/produto_servico.class.php';


class produto_servicodao{

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
    
    public function salvar($produto_servico){

        $fields = array();
        $fields['ds_produto_servico'] = $produto_servico->getds_produto_servico();
        $fields['polos_pk'] = $produto_servico->getpolos_pk();
        $fields['tipo_produto_pk'] = $produto_servico->gettipo_produto_pk();
        $fields['book_pk'] = $produto_servico->getbook_pk();
        $fields['operador_pk'] = $produto_servico->getoperador_pk();
        $fields['ic_valor_aberto'] = $produto_servico->getic_valor_aberto();
        $fields['ic_status'] = $produto_servico->getic_status();
        
        
        $fields['vl_produto_servico'] = $produto_servico->getvl_produto_servico();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($produto_servico->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("produtos_servicos", $fields);
            
            return $pk;
        }
        else{
            return $this->db->execUpdate("produtos_servicos", $fields, " pk = ".$produto_servico->getpk());
        }

    }

    public function excluir($produto_servico){
        $this->db->execDelete("produtos_servicos"," pk = ".$produto_servico->getpk());
    }

    public function carregarPorPk($pk){

        $produto_servico = new produto_servico();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_produto_servico ";
        $sql.="       ,operador_pk ";
        $sql.="       ,ic_valor_aberto ";


        $sql.="  from produtos_servicos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $produto_servico->setpk($query[$i]["pk"]);
                $produto_servico->setdt_cadastro($query[$i]["dt_cadastro"]);
                $produto_servico->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $produto_servico->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $produto_servico->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $produto_servico->setds_produto_servico($query[$i]['ds_produto_servico']);
                $produto_servico->setic_valor_aberto($query[$i]['ic_valor_aberto']);

            }
        }
        return $produto_servico;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_produto_servico ";
        $sql.="       ,polos_pk";
        $sql.="       ,tipo_produto_pk";
        $sql.="       ,book_pk";
        $sql.="       ,vl_produto_servico";
        $sql.="       ,operador_pk";
        $sql.="       ,ic_valor_aberto";
        $sql.="       ,ic_status";

        $sql.="  from produtos_servicos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarPorOperadorPk($operador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_produto_servico ";
        $sql.="       ,polos_pk";
        $sql.="       ,tipo_produto_pk";
        $sql.="       ,book_pk";
        $sql.="       ,vl_produto_servico";
        $sql.="       ,operador_pk";
        $sql.="       ,ic_valor_aberto";

        $sql.="  from produtos_servicos ";
        $sql.=" where 1=1";
        if($operador_pk!=""){
           $sql.=" and operador_pk = $operador_pk ";
        }
        $sql.=" and ic_status = 1";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_produto_servico($ds_produto_servico,$polos_pk,$ic_status,$operador_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_produto_servico ";
        $sql.="       ,p.operador_pk ";
        $sql.="       ,o.ds_operador ";
        $sql.="       ,p.ic_valor_aberto ";
        $sql.="       ,case p.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ic_status";

        $sql.="  from produtos_servicos p ";
        $sql.="       inner join operadores o on p.operador_pk = o.pk";
        $sql.=" where 1=1 ";
        if($ds_produto_servico != ""){
            $sql.=" and p.ds_produto_servico like '%".$ds_produto_servico."%' ";
        }
       if($polos_pk!="" && $polos_pk != "null" ){
            $sql.=" and p.polos_pk = ".$polos_pk;
        }
        if($ic_status!=""){
            $sql.=" and p.ic_status = ".$ic_status;
            
        }
        if($operador_pk!=""){
            $sql.=" and p.operador_pk = ".$operador_pk;
            
        }
        $sql.=" order by p.ds_produto_servico asc ";
        
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_leads_pk($leads_pk,$contratos_pk){

        $sql ="";
        $sql.="select  p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_produto_servico ";
        $sql.="       ,p.operador_pk";
        $sql.="       ,p.ic_valor_aberto";
        $sql.="       ,ci.pk ";
        $sql.="  from produtos_servicos p ";
        $sql.="     inner join contratos_itens ci on p.pk = ci.produtos_servicos_pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.pk in (SELECT  cti.produtos_servicos_pk FROM  contratos ctt INNER JOIN contratos_itens cti ON ctt.pk = cti.contratos_pk inner JOIN processos_etapas pet ON pet.pk = ctt.processos_etapas_pk INNER JOIN   processos prs ON prs.pk = pet.processos_pk WHERE prs.leads_pk = $leads_pk ";
            if($contratos_pk!=""){
                $sql.=" and ctt.pk = ".$contratos_pk;
            }
            
            $sql.=" GROUP BY cti.produtos_servicos_pk)";
        }
        $sql.=" group by p.pk";
        $sql.=" order by p.ds_produto_servico asc ";       
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_produto_servico ";
        $sql.="       ,operador_pk";
        $sql.="       ,ic_valor_aberto";

        $sql.="  from produtos_servicos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_produto_servico asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_qualificacao_colaboradores($colaboradores_pk){

        $sql ="";
        $sql.="select produtos_servicos_pk, colaboradores_pk, ic_possui_treinamento, ic_possui_certificado";
        $sql.="  from colaboradores_produtos_servicos ";
        $sql.=" where 1=1 ";
        if($colaboradores_pk!=""){
            $sql.=" and colaboradores_pk = ".$colaboradores_pk;
        }
        $sql.=" order by produtos_servicos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function adicionarProdutosServicosColaboradores($colaboradores_pk, $produtos_servicos_pk, $ic_possui_treinamento,$ic_possui_certificado){
        
        $fields = array();
        $fields['colaboradores_pk'] = $colaboradores_pk;
        $fields['produtos_servicos_pk'] = $produtos_servicos_pk;
        $fields['ic_possui_treinamento'] = $ic_possui_treinamento;
        $fields['ic_possui_certificado'] = $ic_possui_certificado;
        
        $this->db->execInsert("colaboradores_produtos_servicos", $fields);
        
    }
    
    function excluirProdutosServicosColaboradoresPk($colaboradores_pk){
        $this->db->execDelete("colaboradores_produtos_servicos", " colaboradores_pk = " . $colaboradores_pk);
    }

}

?>
