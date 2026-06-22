<?
ini_set('default_charset','URT-8');
include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/carga_lead.class.php';

include_once "../model/lead.dao.php";
include_once "../model/lead.class.php";

include_once "contato.dao.php";
include_once "contato.class.php";

include_once "endereco.dao.php";
include_once "endereco.class.php";

include_once "telefone.dao.php";
include_once "telefone.class.php";


$leaddao = new leaddao();
$leaddao->setToken($v_token);

$contatodao = new contatodao();
$contatodao->setToken($v_token); 

$enderecodao = new enderecodao();
$enderecodao->setToken($v_token); 

$telefonedao = new telefonedao();
$telefonedao->setToken($v_token); 
        
class carga_leaddao{

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
    
    public function salvar($carga_lead){
        $delimitador = ';';
        $cerca = '"';
        
        
        $fields = array();
        $fields['mailing_pk'] = $carga_lead->getmailing_pk();
        $fields['arquivo'] = $carga_lead->getarquivo();
        $fields['grupos_pk'] = $carga_lead->getgrupos_pk();
        $fields['responsavel_pk'] = $carga_lead->getusuarios_pk();

        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['polos_pk'] = $carga_lead->getpolos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
        $fields['dt_sincronizacao'] = 'sysdate()';
        $fields['ic_status'] = 1;

        $carga = $this->db->execInsert("cargas", $fields);
        

        $arquivoSeguro = safePath(getUploadBaseDir(), $carga_lead->getarquivo());
        if($arquivoSeguro === false || !file_exists($arquivoSeguro)){
            return $carga;
        }
        $fd = fopen($arquivoSeguro, 'r');
        
        $cabecalho = fgetcsv($fd, 0, $delimitador, $cerca);
        
        while (!feof ($fd)){
                $linha = fgetcsv($fd, 0, $delimitador, $cerca);
                
                $registro = array_combine($cabecalho, $linha);
                
                
                if(($registro)!=NULL){
                        //SEPARA DDD DO TELEFONE
                        $numero = trim($registro['Tel'].PHP_EOL);

                        $order   = array("(", ")", " ");
                        $replace = ' ';

                        $numero_sem_nada = str_replace($order, "", $numero);
                        $sodddtel = substr($numero_sem_nada, 0, 2);
                        $sonumerotel = substr($numero_sem_nada, 2);

                        $numero1 = trim($registro['Tel1'].PHP_EOL);

                        $numero_sem_nada1 = str_replace($order, "", $numero1);
                        $sodddtel1 = substr($numero_sem_nada1, 0, 2);
                        $sonumerotel1 = substr($numero_sem_nada1, 2);


                       $ds_cnpj = formatCnpjCpf(trim($registro['CPF / CNPJ'].PHP_EOL)); 



                        $fields = array();
                        $fields['tipo_pessoa_pk'] = trim($registro['TipoPessoa'].PHP_EOL);
                        $fields['ds_lead'] = trim($registro['Lead'].PHP_EOL);
                        $fields['ds_razao_social'] = trim($registro['Razao Social'].PHP_EOL);
                        $fields['ds_cpf_cnpj'] = $ds_cnpj;
                        $fields['ds_ie'] = trim($registro['IE'].PHP_EOL);
                        $fields['ds_rg'] = trim($registro['RG'].PHP_EOL);
                        $fields['ds_cnae'] = trim($registro['CNAE'].PHP_EOL);
                        //$fields['ic_cliente'] = $carga_lead->getic_cliente();
                        $fields['ds_site'] = trim($registro['Site'].PHP_EOL);
                        $fields['ds_obs'] = trim($registro['Observacao'].PHP_EOL);
                        $fields['mailing_pk'] = $carga_lead->getmailing_pk();

                        $fields['tipo_telefone_pk'] = 1;
                        $fields['ds_ddd'] = $sodddtel;
                        $fields['ds_tel'] = $sonumerotel;
                        $fields['tipo_telefone_pk1'] = 1;
                        $fields['ds_ddd1'] = $sodddtel1;
                        $fields['ds_tel1'] = $sonumerotel1;

                        $fields['tipo_endereco_pk'] = 1;
                        $fields['ds_endereco'] = utf8_encode(trim($registro['Logradouro'].PHP_EOL));
                        $fields['ds_numero'] = trim($registro['Numero'].PHP_EOL);
                        $fields['ds_complemento'] = trim($registro['Complemento'].PHP_EOL);
                        $fields['ds_bairro'] = utf8_encode(trim($registro['Bairro'].PHP_EOL));
                        $fields['ds_cidade'] = utf8_encode(trim($registro['Cidade'].PHP_EOL));
                        $fields['ds_uf'] = trim($registro['UF'].PHP_EOL);

                        $fields['ds_contato'] = utf8_encode(trim($registro['Contato'].PHP_EOL));
                        $fields['ds_cel_contato'] = trim($registro['Celular Contato'].PHP_EOL);
                        $fields['ds_tel_contato'] = trim($registro['Tel Contato'].PHP_EOL);
                        $fields['ds_email_contato'] = trim($registro['Email Contato'].PHP_EOL);
                        $fields['ds_contato1'] = trim($registro['Contato 1'].PHP_EOL);
                        $fields['ds_cel_contato1'] = trim($registro['Celular Contato1'].PHP_EOL);
                        $fields['ds_tel_contato1'] = trim($registro['Tel Contato1'].PHP_EOL);
                        $fields['ds_email_contato1'] = trim($registro['Email Contato1'].PHP_EOL);

                        $fields['contas_pk'] = $this->arrToken['contas_pk'];
                        $fields['polos_pk'] = $carga_lead->getpolos_pk();


                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                        $carga_realizada_pk = $this->db->execInsert("cargas_lead", $fields);
                        


                        // CADASTRO LEAD
                        $fields_leads = array();            


                        $fields_leads['tipo_pessoa_pk'] = trim($registro['TipoPessoa'].PHP_EOL);
                        $fields_leads['ds_lead'] = utf8_encode(trim($registro['Lead'].PHP_EOL));
                        $fields_leads['ds_razao_social'] = utf8_encode(trim($registro['Razao Social'].PHP_EOL));
                        $fields_leads['ds_cpf_cnpj'] = $ds_cnpj;
                        $fields_leads['ds_ie'] = trim($registro['IE'].PHP_EOL);
                        $fields_leads['ds_rg'] = trim($registro['RG'].PHP_EOL);
                        $fields_leads['ds_cnae'] = trim($registro['CNAE'].PHP_EOL);
                        $fields_leads['ic_cliente'] = $carga_lead->getic_cliente();
                        $fields_leads['ds_site'] = trim($registro['Site'].PHP_EOL);
                        $fields_leads['ds_obs'] = utf8_encode(trim($registro['Observacao'].PHP_EOL));
                        $fields_leads['mailing_pk'] = $carga_lead->getmailing_pk();
                        $fields_leads['contas_pk'] = $this->arrToken['contas_pk'];
                        $fields_leads['polos_pk'] = $carga_lead->getpolos_pk();
                        $fields_leads["dt_ult_atualizacao"] = "sysdate()";
                        $fields_leads["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
                        $fields_leads["dt_cadastro"] = "sysdate()";
                        $fields_leads["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                        $leads_pk = $this->db->execInsert("leads", $fields_leads); 
                        
                        if($leads_pk==$carga_realizada_pk){
                            $fields_sem_carga = array();
                            $fields_sem_carga['cargas_pk'] = $carga;
                            $fields_sem_carga['ds_lead'] = utf8_encode(trim($registro['Lead'].PHP_EOL));
                            $fields_sem_carga['ds_cpf_cnpj'] = $ds_cnpj;
                            $fields_sem_carga['usuario_cadastro_pk'] = $this->arrToken['usuarios_pk'];
                            $fields_sem_carga['usuario_ult_atualizacao_pk'] = $this->arrToken['usuarios_pk'];
                            $fields_sem_carga['dt_cadastro'] = "sysdate()";
                            $fields_sem_carga['dt_ult_atualizacao'] = "sysdate()";


                            $carga_nao_realizada_pk = $this->db->execInsert("carga_nao_realizada", $fields_sem_carga);

                        }
                        // CADASTRO CONTATO
                       if(trim($registro['Celular Contato'].PHP_EOL)!=null){


                            $fields_contatos = array();
                            $fields_contatos['ds_contato'] = utf8_encode(trim($registro['Contato'].PHP_EOL));
                            $fields_contatos['ds_cel'] = trim($registro['Celular Contato'].PHP_EOL);
                            $fields_contatos['ic_whatsapp'] = 2;
                            $fields_contatos['ds_email'] = trim($registro['Email Contato'].PHP_EOL);
                            $fields_contatos['ds_tel'] = trim($registro['Tel Contato'].PHP_EOL);
                            $fields_contatos['cargos_pk'] = " ";
                            $fields_contatos['leads_pk'] = $leads_pk;
                            $fields_contatos['polos_pk'] = $carga_lead->getpolos_pk();
                            $fields_contatos['contas_pk'] = $this->arrToken['contas_pk'];


                            $fields_contatos["dt_ult_atualizacao"] = "sysdate()";
                            $fields_contatos["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                            $fields_contatos["dt_cadastro"] = "sysdate()";
                            $fields_contatos["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                            $contatos_pk = $this->db->execInsert("contatos", $fields_contatos);
                       } 
                       if(trim($registro['Celular Contato1'].PHP_EOL)!=null){

                            $fields_contatos1 = array();
                            $fields_contatos1['ds_contato'] = utf8_encode(trim($registro['Contato1'].PHP_EOL));
                            $fields_contatos1['ds_cel'] = trim($registro['Celular Contato1'].PHP_EOL);
                            $fields_contatos1['ic_whatsapp'] = 2;
                            $fields_contatos1['ds_email'] = trim($registro['Email Contato1'].PHP_EOL);
                            $fields_contatos1['ds_tel'] = trim($registro['Tel Contato1'].PHP_EOL);
                            $fields_contatos1['cargos_pk'] = " ";
                            $fields_contatos1['leads_pk'] = $leads_pk;
                            $fields_contatos1['polos_pk'] = $carga_lead->getpolos_pk();
                            $fields_contatos1['contas_pk'] = $this->arrToken['contas_pk'];


                            $fields_contatos1["dt_ult_atualizacao"] = "sysdate()";
                            $fields_contatos1["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                            $fields_contatos1["dt_cadastro"] = "sysdate()";
                            $fields_contatos1["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                            $contatos_pk = $this->db->execInsert("contatos", $fields_contatos1);

                       } 

                        //ENDERECO
                       if(trim($registro['Logradouro'].PHP_EOL)!=null){
                            $fields_endereco = array();
                            $fields_endereco['tipo_endereco_pk'] = 1;
                            $fields_endereco['ds_cep'] = str_replace("-","",trim($registro['Cep'].PHP_EOL));
                            $fields_endereco['ds_endereco'] = utf8_encode(trim($registro['Logradouro'].PHP_EOL));
                            $fields_endereco['ds_numero'] = trim($registro['Numero'].PHP_EOL);
                            $fields_endereco['ds_complemento'] = utf8_encode(trim($registro['Complemento'].PHP_EOL));
                            $fields_endereco['ds_bairro'] = utf8_encode(trim($registro['Bairro'].PHP_EOL));
                            $fields_endereco['ds_cidade'] = utf8_encode(trim($registro['Cidade'].PHP_EOL));
                            $fields_endereco['ds_uf'] = trim($registro['UF'].PHP_EOL);
                            $fields_endereco['leads_pk'] = $leads_pk;
                            $fields_endereco['contas_pk'] = $this->arrToken['contas_pk'];
                            $fields_endereco['polos_pk'] = $carga_lead->getpolos_pk();


                            $fields_endereco["dt_ult_atualizacao"] = "sysdate()";
                            $fields_endereco["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                            $fields_endereco["dt_cadastro"] = "sysdate()";
                            $fields_endereco["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                            $enderecos_pk = $this->db->execInsert("enderecos", $fields_endereco);
                       }

                       //TELEFONE
                       if(trim($registro['Tel'].PHP_EOL)!=null){
                            $fields_telefone = array();
                            $fields_telefone['tipo_telefone_pk'] = 1;
                            $fields_telefone['ds_ddd'] = $sodddtel;
                            $fields_telefone['ds_tel'] = trim($sonumerotel);
                            $fields_telefone['ic_status'] = 1;
                            $fields_telefone['leads_pk'] = $leads_pk;
                            $fields_telefone['contas_pk'] = $this->arrToken['contas_pk'];
                            $fields_telefone['polos_pk'] = $carga_lead->getpolos_pk();


                            $fields_telefone["dt_ult_atualizacao"] = "sysdate()";
                            $fields_telefone["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                            $fields_telefone["dt_cadastro"] = "sysdate()";
                            $fields_telefone["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                            $telefones_pk = $this->db->execInsert("telefones", $fields_telefone);
                       }
                       if(trim($registro['Tel1'].PHP_EOL)!=null){

                            $fields_telefone1 = array();
                            $fields_telefone1['tipo_telefone_pk'] = 1;
                            $fields_telefone1['ds_ddd'] = $sodddtel1;
                            $fields_telefone1['ds_tel'] = trim($sonumerotel1);
                            $fields_telefone1['ic_status'] = 1;
                            $fields_telefone1['leads_pk'] = $leads_pk;
                            $fields_telefone1['contas_pk'] = $this->arrToken['contas_pk'];
                            $fields_telefone1['polos_pk'] = $carga_lead->getpolos_pk();


                            $fields_telefone1["dt_ult_atualizacao"] = "sysdate()";
                            $fields_telefone1["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                            $fields_telefone1["dt_cadastro"] = "sysdate()";
                            $fields_telefone1["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                            $telefones_pk = $this->db->execInsert("telefones", $fields_telefone1);
                       }




                        //RESPONSAVEL
                       if(trim($registro['Responsavel'].PHP_EOL)!=null && trim($registro['Responsavel'].PHP_EOL)!=" "){

                            $sql =" ";
                            $sql.="select pk,grupos_pk ";
                            $sql.="  from usuarios ";
                            $sql.=" where 1=1 ";
                            $sql.=" and contas_pk=".$this->arrToken['contas_pk'];
                            $sql.=" and ds_usuario like '%".trim($registro['Responsavel'].PHP_EOL)."%'";
                            if(trim($registro['Tipo de Responsavel'])!=null){
                                $sql.=" and grupos_pk=".trim($registro['Tipo de Responsavel'].PHP_EOL);
                            }
                            $sql.=" order by ds_usuario asc ";  

                            $query = $this->db->execQuery($sql);

                            $responsavel_pk = $query[0]['pk'];
                            $grupos_responsavel_pk = $query[0]['grupos_pk'];

                            $fields_responsavel = array();

                            $fields_responsavel['usuarios_pk'] = $responsavel_pk;
                            $fields_responsavel['grupos_pk'] = $grupos_responsavel_pk;
                            $fields_responsavel['leads_pk'] = $leads_pk;
                            $fields_responsavel['contas_pk'] = $this->arrToken['contas_pk'];
                            $fields_responsavel['polos_pk'] = $carga_lead->getpolos_pk();

                            $fields_responsavel["dt_ult_atualizacao"] = "sysdate()";
                            $fields_responsavel["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                            $fields_responsavel["dt_cadastro"] = "sysdate()";
                            $fields_responsavel["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                            $responsavel_leads_pk = $this->db->execInsert("leads_responsaveis", $fields_responsavel);
                       }
                       else if($carga_lead->getusuarios_pk()!=""){

                            $fields_responsavel = array();

                            $fields_responsavel['usuarios_pk'] = $carga_lead->getusuarios_pk();
                            $fields_responsavel['grupos_pk'] = $carga_lead->getgrupos_pk();
                            $fields_responsavel['leads_pk'] = $leads_pk;
                            $fields_responsavel['contas_pk'] = $this->arrToken['contas_pk'];
                            $fields_responsavel['polos_pk'] = $carga_lead->getpolos_pk();

                            $fields_responsavel["dt_ult_atualizacao"] = "sysdate()";
                            $fields_responsavel["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                            $fields_responsavel["dt_cadastro"] = "sysdate()";
                            $fields_responsavel["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                            $responsavel_leads_pk = $this->db->execInsert("leads_responsaveis", $fields_responsavel);
                       }


                       //LEAD OPERADOR
                       if(trim($registro['Operadora'].PHP_EOL)!=null){


                            $sql=" ";
                            $sql.="select o.pk ";

                            $sql.="  from operadores o";
                            $sql.="       left join segmentos s on o.segmentos_pk = s.pk";
                            //$sql.="       inner join polos_operadores po on po.operadores_pk = o.pk";
                            $sql.=" where 1=1 ";
                            $sql.=" and o.ic_status= 1";
                            //$sql.=" and po.polos_pk = ".$this->arrToken['polos_pk'];
                            $sql.=" and o.ds_operador like '%".trim($registro['Operadora'].PHP_EOL)."%'";
                            $sql.=" order by o.ds_operador asc ";




                            $query = $this->db->execQuery($sql);

                            $operador_pk = $query[0]['pk'];
                            if(trim($registro['Classificacao'].PHP_EOL)!=null){


                                $sql ="";
                                $sql.="select co.pk,co.ds_classificacao ";

                                $sql.="  from classificacao_operadoras co ";
                                $sql.="       inner join operadores o on co.operadoras_pk = o.pk";
                                $sql.=" where 1=1 ";
                                if(trim($registro['Classificacao'].PHP_EOL)!=""){
                                    $sql.=" and co.ds_classificacao like '%".trim($registro['Classificacao'].PHP_EOL)."%'";
                                }

                                $sql.=" order by co.ds_classificacao asc";
                                $query = $this->db->execQuery($sql);

                                $classificacao_pk = $query[0]['pk'];   
                            }
                            else{
                                $classificacao_pk = " ";
                            }

                            if(trim($registro['Cliente Operadora'].PHP_EOL)=="sim"){

                                $ic_cliente = 1;
                            }
                            else{
                                $ic_cliente = 2;
                            }




                            $ic_cliente_base = "";
                            if(trim($registro['Cliente da Base'].PHP_EOL)=="Sim" || trim($registro['Cliente da Base'].PHP_EOL)=="sim"){
                                $ic_cliente_base = 1;
                            }
                            else{
                                $ic_cliente_base = 2;
                            }
                            $fields_operadoras = array();
                            $fields_operadoras['operador_pk'] = $operador_pk;
                            $fields_operadoras['leads_pk'] = $leads_pk;
                            $fields_operadoras['ic_cliente'] = $ic_cliente;
                            $fields_operadoras['ic_base'] = $ic_cliente_base;
                            if(trim($registro['Data Ativacao'].PHP_EOL)!=null){
                                $fields_operadoras['dt_ativacao'] = DataYMD(trim($registro['Data Ativacao'].PHP_EOL));
                            }
                            if(trim($registro['Data Vencimento'].PHP_EOL)!=null){
                                $fields_operadoras['dt_vencimento'] = DataYMD(trim($registro['Data Vencimento'].PHP_EOL));
                            }

                            $fields_operadoras['ds_custo_atual'] = trim($registro['Custo Atual'].PHP_EOL);
                            $fields_operadoras['ds_qtde_voz'] = trim($registro['Qtde Linhas Voz'].PHP_EOL);
                            $fields_operadoras['ds_qtde_dados'] = trim($registro['Qtde Linhas Dados'].PHP_EOL);
                            $fields_operadoras['ic_status'] = 1;
                            $fields_operadoras['classificacao_pk'] = $classificacao_pk;

                            $fields_operadoras["dt_ult_atualizacao"] = "sysdate()";
                            $fields_operadoras["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                            $fields_operadoras["dt_cadastro"] = "sysdate()";
                            $fields_operadoras["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                            $operador_leads_pk = $this->db->execInsert("leads_operadoras", $fields_operadoras);
                       }
                }
            
        }
        
        
        
        

    }

    public function excluir($carga_lead){
        $this->db->execDelete("cargas_lead"," pk = ".$carga_lead->getpk());
    }

    public function carregarPorPk($pk){

        $carga_lead = new carga_lead();
        if($pk != ""){
            
        $sql =" ";
        $sql.="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_pessoa_pk ";
        $sql.="       ,ds_lead ";
        $sql.="       ,ds_razao_social ";
        $sql.="       ,ds_cpf_cnpj ";
        $sql.="       ,ds_ie ";
        $sql.="       ,ds_rg ";
        $sql.="       ,ds_cnae ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ds_site ";
        $sql.="       ,ds_obs ";
        $sql.="       ,mailing_pk ";
        $sql.="       ,tipo_telefone_pk ";
        $sql.="       ,tipo_telefone_pk1 ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_ddd1 ";
        $sql.="       ,ds_tel1 ";
        $sql.="       ,tipo_endereco_pk ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ds_contato ";
        $sql.="       ,ds_cel_contato ";
        $sql.="       ,ds_tel_contato ";
        $sql.="       ,ds_email_contato ";
        $sql.="       ,ds_email_contato1";
        $sql.="       ,ds_contato1 ";
        $sql.="       ,ds_cel_contato1 ";
        $sql.="       ,ds_tel_contato1 ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,dt_sinconizacao ";
        $sql.="       ,ic_status ";


        $sql.="  from cargas_lead ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $carga_lead->setpk($query[$i]["pk"]);
                $carga_lead->setdt_cadastro($query[$i]["dt_cadastro"]);
                $carga_lead->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $carga_lead->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $carga_lead->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $carga_lead->settipo_pessoa_pk($query[$i]['tipo_pessoa_pk']);
                $carga_lead->setds_lead($query[$i]['ds_lead']);
                $carga_lead->setds_razao_social($query[$i]['ds_razao_social']);
                $carga_lead->setds_cpf_cnpj($query[$i]['ds_cpf_cnpj']);
                $carga_lead->setds_ie($query[$i]['ds_ie']);
                $carga_lead->setds_rg($query[$i]['ds_rg']);
                $carga_lead->setds_cnae($query[$i]['ds_cnae']);
                $carga_lead->setic_cliente($query[$i]['ic_cliente']);
                $carga_lead->setds_site($query[$i]['ds_site']);
                $carga_lead->setds_obs($query[$i]['ds_obs']);
                $carga_lead->setmailing_pk($query[$i]['mailing_pk']);
                $carga_lead->settipo_telefone_pk($query[$i]['tipo_telefone_pk']);
                $carga_lead->settipo_telefone_pk1($query[$i]['tipo_telefone_pk1']);
                $carga_lead->setds_ddd($query[$i]['ds_ddd']);
                $carga_lead->setds_tel($query[$i]['ds_tel']);
                $carga_lead->setds_ddd1($query[$i]['ds_ddd1']);
                $carga_lead->setds_tel1($query[$i]['ds_tel1']);
                $carga_lead->settipo_endereco_pk($query[$i]['tipo_endereco_pk']);
                $carga_lead->setds_endereco($query[$i]['ds_endereco']);
                $carga_lead->setds_numero($query[$i]['ds_numero']);
                $carga_lead->setds_complemento($query[$i]['ds_complemento']);
                $carga_lead->setds_bairro($query[$i]['ds_bairro']);
                $carga_lead->setds_cidade($query[$i]['ds_cidade']);
                $carga_lead->setds_uf($query[$i]['ds_uf']);
                $carga_lead->setds_contato($query[$i]['ds_contato']);
                $carga_lead->setds_cel_contato($query[$i]['ds_cel_contato']);
                $carga_lead->setds_tel_contato($query[$i]['ds_tel_contato']);
                $carga_lead->setds_email_contato($query[$i]['ds_email_contato']);
                $carga_lead->setds_email_contato1($query[$i]['ds_email_contato1']);
                $carga_lead->setds_contato1($query[$i]['ds_contato1']);
                $carga_lead->setds_cel_contato1($query[$i]['ds_cel_contato1']);
                $carga_lead->setds_tel_contato1($query[$i]['ds_tel_contato1']);
                $carga_lead->setcontas_pk($query[$i]['contas_pk']);
                $carga_lead->setpolos_pk($query[$i]['polos_pk']);
                $carga_lead->setdt_sinconizacao($query[$i]['dt_sinconizacao']);
                $carga_lead->setic_status($query[$i]['ic_status']);

            }
        }
        return $carga_lead;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_pessoa_pk ";
        $sql.="       ,ds_lead ";
        $sql.="       ,ds_razao_social ";
        $sql.="       ,ds_cpf_cnpj ";
        $sql.="       ,ds_ie ";
        $sql.="       ,ds_rg ";
        $sql.="       ,ds_cnae ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ds_site ";
        $sql.="       ,ds_obs ";
        $sql.="       ,mailing_pk ";
        $sql.="       ,tipo_telefone_pk ";
        $sql.="       ,tipo_telefone_pk1 ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_ddd1 ";
        $sql.="       ,ds_tel1 ";
        $sql.="       ,tipo_endereco_pk ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ds_contato ";
        $sql.="       ,ds_cel_contato ";
        $sql.="       ,ds_tel_contato ";
        $sql.="       ,ds_email_contato ";
        $sql.="       ,ds_email_contato1 ";
        $sql.="       ,ds_contato1 ";
        $sql.="       ,ds_cel_contato1 ";
        $sql.="       ,ds_tel_contato1 ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,dt_sinconizacao ";
        $sql.="       ,ic_status ";

        $sql.="  from cargas_lead ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_tipo_pessoa_pk($polos_pk,$mailing_pk,$dt_carga_ini,$dt_carga_fim,$usuario_cadastro_pk){

        $sql ="";
        $sql.="select cl.pk, date_format(cl.dt_cadastro,'%d/%m/%Y')dt_cadastro, cl.usuario_cadastro_pk, cl.dt_ult_atualizacao, cl.usuario_ult_atualizacao_pk ";
        $sql.="       ,cl.mailing_pk ";
        $sql.="       ,cl.contas_pk ";
        $sql.="       ,cl.polos_pk ";
        $sql.="       ,date_format(cl.dt_sincronizacao,'%d/%m/%Y %H:%i:%s')dt_sinconizacao ";
        $sql.="       ,cl.ic_status ";
        $sql.="       ,cl.arquivo";
        $sql.="       ,m.ds_mailing";
        $sql.="       ,u.ds_usuario";
        $sql.="  from cargas cl ";
        $sql.="         inner join mailing m on m.pk = cl.mailing_pk";
        $sql.="         inner join usuarios u on u.pk = cl.usuario_cadastro_pk";
        $sql.=" where 1=1 ";
        if($polos_pk != ""){
            $sql.=" and cl.polos_pk=".$polos_pk;
        }
        if($mailing_pk != ""){
            $sql.=" and cl.mailing_pk=".$mailing_pk;
        }
        if($usuario_cadastro_pk != ""){
            $sql.=" and cl.usuario_cadastro_pk=".$usuario_cadastro_pk;
        }
        if($dt_carga_ini != ""){
            $sql.=" and cl.dt_cadastro between '".DataYMD($dt_carga_ini)." 00:00:00' and '".DataYMD($dt_carga_fim)." 23:59:59' ";
        }
        $sql.=" and u.contas_pk = ".$this->arrToken['contas_pk']; 
        //$sql.=" group by cl.mailing_pk ";  
       
        
      

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarNaoRealizado($cargas_pk){

        $sql ="";
        $sql.="select cnr.ds_lead,cnr.ds_cpf_cnpj,m.ds_mailing,u.ds_usuario,date_format(cl.dt_cadastro,'%d/%m/%Y')dt_cadastro";
        $sql.="  from cargas cl ";
        $sql.="         inner join mailing m on m.pk = cl.mailing_pk";
        $sql.="         inner join usuarios u on u.pk = cl.usuario_cadastro_pk";
        $sql.="         inner join carga_nao_realizada cnr on cl.pk = cnr.cargas_pk";
        $sql.=" where 1=1 ";
        if($cargas_pk != ""){
            $sql.=" and cl.pk=".$cargas_pk;
        }
        $sql.=" and u.contas_pk = ".$this->arrToken['contas_pk'];   
        
      

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_pessoa_pk ";
        $sql.="       ,ds_lead ";
        $sql.="       ,ds_razao_social ";
        $sql.="       ,ds_cpf_cnpj ";
        $sql.="       ,ds_ie ";
        $sql.="       ,ds_rg ";
        $sql.="       ,ds_cnae ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ds_site ";
        $sql.="       ,ds_obs ";
        $sql.="       ,mailing_pk ";
        $sql.="       ,tipo_telefone_pk ";
        $sql.="       ,tipo_telefone_pk1 ";
        $sql.="       ,ds_ddd ";
        $sql.="       ,ds_tel ";
        $sql.="       ,ds_ddd1 ";
        $sql.="       ,ds_tel1 ";
        $sql.="       ,tipo_endereco_pk ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ds_contato ";
        $sql.="       ,ds_cel_contato ";
        $sql.="       ,ds_tel_contato ";
        $sql.="       ,ds_email_contato ";
        $sql.="       ,ds_email_contato1 ";
        $sql.="       ,ds_contato1 ";
        $sql.="       ,ds_cel_contato1 ";
        $sql.="       ,ds_tel_contato1 ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,dt_sinconizacao ";
        $sql.="       ,ic_status ";

        $sql.="  from cargas_lead ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_pessoa_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
