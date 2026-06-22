<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/conta.class.php';

class migrardao {

    private $db;
    private $arrToken;

    public function __construct() {

        $this->db = new DataBase();
        $this->db->conectar();
    }

    public function __destruct() {
        $this->db->desconectar();
    }

    public function setToken($v_token) {
        $this->arrToken = tratarToken($v_token);
    }

    public function consultarGrupo($grupos_pk_old) {

        $sql = "";
        $sql .= "select pk ";
        $sql .= "  from grupos ";
        $sql .= " where pk_old = $grupos_pk_old ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function consultarTipoOcorrencia($ds_sem_interesse) {

        $sql = "";
        $sql .= "select pk ";
        $sql .= "  from tipos_ocorrencias ";
        $sql .= " where ds_tipo_ocorrencia = '$ds_sem_interesse' ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function consultarMotivoSemInteresse($ds_motivo_sem_interesse) {

        $sql = "";
        $sql .= "select pk ";
        $sql .= "  from motivo_sem_interesse ";
        $sql .= " where ds_motivo_sem_interesse = '$ds_motivo_sem_interesse' ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function salvarUsuario($pk_old,$ds_usuario,$ds_login,$ds_senha,$grupos_pk){
        
        $fields = array();
        $fields['ds_usuario'] = $ds_usuario;
        $fields['ds_login'] = $ds_login;
        $fields['ds_senha'] = $ds_senha;
        $fields['grupos_pk'] = $grupos_pk;
        $fields['ic_status'] = 1;
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['pk_old'] = $pk_old;

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $pk = $this->db->execInsert("usuarios", $fields);
        return $pk;

    }
    public function salvarPoloUsuario($usuarios_pk){
        
        $fields = array();
        $fields['polos_pk'] = $this->arrToken['polos_pk'];
        $fields['usuarios_pk'] = $usuarios_pk;
        $fields['ic_status'] = 1;

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
     
            $this->db->execInsert("usuarios_polos", $fields);            
            
    }
    
    
    //LEAD
    
    public function salvarLead($tipo_pessoa,$ds_lead,$ds_razaosocial,$ds_cpf_cnpj,$cliente_lead,$pk_old){

        $fields = array();
        $fields['tipo_pessoa_pk'] = $tipo_pessoa;
        $fields['ds_lead'] = $ds_lead;
        $fields['ds_razao_social'] = $ds_razaosocial;
        $fields['ds_cpf_cnpj'] = $ds_cpf_cnpj;
        $fields['ic_cliente'] = $cliente_lead;
        $fields['pk_old'] = $pk_old;
        $fields['mailing_pk'] = 1;
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['polos_pk'] = $this->arrToken['polos_pk'];
        

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $pk = $this->db->execInsert("leads", $fields);
        return $pk;

    }
    public function salvarResponsavel($usuarios_pk,$grupos_pk,$leads_pk){

        $fields = array();
        $fields['usuarios_pk'] = $usuarios_pk;
        $fields['grupos_pk'] = $grupos_pk;
        $fields['leads_pk'] = $leads_pk;
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['polos_pk'] = $this->arrToken['polos_pk'];
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $this->db->execInsert("leads_responsaveis", $fields);

    }
    public function salvarTelefoneLead($ds_ddd,$ds_tel,$leads_pk){

        $fields = array();
        $fields['tipo_telefone_pk'] = 1;
        $fields['ds_ddd'] = $ds_ddd;   
        $fields['ds_tel'] = $ds_tel;
        $fields['ic_status'] = 1;
        $fields['leads_pk'] = $leads_pk;
        $fields['polos_pk'] = $this->arrToken['polos_pk'];
        $fields['contas_pk'] = $this->arrToken['contas_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $this->db->execInsert("telefones", $fields);

    }
    public function salvarEnderecoLead($ds_cep,$ds_endereco,$ds_numero,$ds_complemento,$ds_bairro,$ds_cidade,$ds_uf,$leads_pk){

        $fields = array();
        $fields['tipo_endereco_pk'] = 1;
        $fields['ds_cep'] = $ds_cep;
        $fields['ds_endereco'] = $ds_endereco;
        $fields['ds_numero'] = $ds_numero;
        $fields['ds_complemento'] = $ds_complemento;
        $fields['ds_bairro'] = $ds_bairro;
        $fields['ds_cidade'] = $ds_cidade;
        $fields['ds_uf'] = $ds_uf;
        $fields['leads_pk'] = $leads_pk;
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['polos_pk'] = $this->arrToken['polos_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $this->db->execInsert("enderecos", $fields);

    }
    public function salvarContatoLead($ds_contato,$ds_cel,$ds_email,$ds_tel,$leads_pk,$pk_old){
        $fields = array();
        $fields['ds_contato'] = $ds_contato;
        $fields['ds_cel'] = $ds_cel;
        $fields['ic_whatsapp'] = 1;
        $fields['ds_email'] = $ds_email;
        $fields['ds_tel'] = $ds_tel;
        $fields['cargos_pk'] = 1;
        $fields['leads_pk'] = $leads_pk;
        $fields['polos_pk'] = $this->arrToken['polos_pk'];
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['pk_old'] = $pk_old;
        

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $this->db->execInsert("contatos", $fields);

    }
    
    public function consultarOperadora($operadora_pk_old) {

        $sql = "";
        $sql .= "select pk ";
        $sql .= "  from operadores";
        $sql .= " where pk_old = $operadora_pk_old ";
       
        

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function consultarUsuario($usuarios_pk_old) {

        $sql = "";
        $sql .= "select pk ,grupos_pk";
        $sql .= "  from usuarios";
        $sql .= " where pk_old = $usuarios_pk_old ";
       
        

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function consultarContatos($contatos_pk_old) {

        $sql = "";
        $sql .= "select pk,ds_contato,ds_cel,ds_tel ";
        $sql .= "  from contatos";
        $sql .= " where pk_old = $contatos_pk_old ";
       
        

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function pegarProcessoEtapa($processos_pk) {

        $sql = "";
        $sql .= "SELECT pk";
        $sql.="         FROM  processos_etapas";
        $sql.=" where ds_processo_etapa like '%Agenda%'";
        $sql.="       and processos_pk = $processos_pk ";
       
        

        $query = $this->db->execQuery($sql);
        return $query[0]['pk'];
    }
    
    public function salvarOperadoras($operador_pk,$leads_pk,$ic_cliente,$ic_base,$dt_ativacao,$dt_vencimento,$ds_custo_atual,$ds_qtde_voz,$ds_qtde_dados,$ic_status,$classificacao_pk){

        $fields = array();
        $fields['operador_pk'] = $operador_pk;
        $fields['leads_pk'] = $leads_pk;
        $fields['ic_cliente'] = $ic_cliente;
        $fields['ic_base'] = $ic_base;
        $fields['dt_ativacao'] = $dt_ativacao;
        $fields['dt_vencimento'] = $dt_vencimento;
        $fields['ds_custo_atual'] = $ds_custo_atual;
        $fields['ds_qtde_voz'] = $ds_qtde_voz;
        $fields['ds_qtde_dados'] = $ds_qtde_dados;
        $fields['ic_status'] = $ic_status;
        $fields['classificacao_pk'] = $classificacao_pk;


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $this->db->execInsert("leads_operadoras", $fields);

    }
    
    public function salvarOcorrencia($ds_ocorrencia,$tipo_ocorrencia_pk,$dt_fechamento,$leads_pk,$dt_cadastro,$usuario_cadastro_pk,$motivo_sem_interesse_pk){

        $fields = array();
        $fields['ds_ocorrencia'] = str_replace("<br />", "", "Tipo Ocorrência -> Migração ".$ds_ocorrencia);
        $fields['tipos_ocorrencias_pk'] = $tipo_ocorrencia_pk;
        
        $fields['leads_pk'] = $leads_pk;
        $fields['dt_fechamento'] = $dt_fechamento;
        $fields['motivo_sem_interesse_pk'] = $motivo_sem_interesse_pk;
        $fields['ds_motivo_sem_interesse'] = "Migração";
        


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
			
        $fields["dt_cadastro"] = $dt_cadastro;
        $fields["usuario_cadastro_pk"]   = $usuario_cadastro_pk;

        $pk = $this->db->execInsert("ocorrencias", $fields);
        return $pk;
	
    }
    
    public function salvarRetorno($dt_retorno,$responsavel_pk,$ds_retorno,$ocorrencias_pk,$dt_termino){

        $fields = array();
        $fields['dt_retorno'] = $dt_retorno;
        $fields['responsavel_pk'] = $responsavel_pk;
        $fields['ds_retorno'] = $ds_retorno;
        $fields['ocorrencias_pk'] = $ocorrencias_pk;
        $fields['dt_termino_retorno'] = $dt_termino;

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $pk = $this->db->execInsert("retornos", $fields);

        return $pk;
    }
    
    public function salvarProcessos($leads_pk){
        
        $fields = array();
        $fields['ds_processo'] = "Migração";
        $fields['processos_default_pk'] = 2;
        $fields['leads_pk'] = $leads_pk;
        $fields['polos_pk'] = $this->arrToken['polos_pk'];
        $fields['contas_pk'] = $this->arrToken['contas_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        

        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $pk = $this->db->execInsert("processos", $fields);

        //Inclui as etapas
        $sql = "";
        $sql.="insert into processos_etapas (dt_cadastro,contas_pk,polos_pk, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk, ds_processo_etapa, n_ordem_etapa, processos_pk) ";
        $sql.="select SYSDATE(),".$this->arrToken['contas_pk'].",".$this->arrToken['polos_pk'].", ".$this->arrToken['usuarios_pk'].", SYSDATE(), ".$this->arrToken['usuarios_pk'].", ds_processo_default_etapa, n_ordem_etapa, $pk ";
        $sql.="  from processos_default_etapas ";
        $sql.=" where processos_default_pk = 2";

        $this->db->execSQL($sql);

        return $pk;
    }
    
    public function salvarAgenda($dt_agenda,$ds_endereco,$ds_numero,$ds_complemento,$ds_cep,$ds_bairro,$ds_cidade,$ds_uf,$ds_obs,$classificacao_agenda_pk,$dt_cancelamento,$processos_etapas_pk,$ic_status,$ds_contato,$ds_tel,$ds_cel,$dt_cadastro,$pk_old,$usuario_cadastro_pk,$leads_pk){

        $fields = array();
        $fields['dt_agenda'] = $dt_agenda;
        $fields['ds_endereco'] = $ds_endereco;
        $fields['ds_numero'] = $ds_numero;
        $fields['ds_complemento'] = $ds_complemento;
        $fields['ds_cep'] = $ds_cep;
        $fields['ds_bairro'] = $ds_bairro;
        $fields['ds_cidade'] = $ds_cidade;
        $fields['ds_uf'] = $ds_uf;
        $fields['ds_obs'] = $ds_obs;
        $fields['tipo_evento_pk'] = 1;
        $fields['classificacao_agenda_pk'] = $classificacao_agenda_pk;
        $fields['dt_cancelamento'] = $dt_cancelamento;
        
       
        $fields['processos_etapas_pk'] = $processos_etapas_pk;
        $fields['tipos_agendas_pk'] = 1;
        
        $fields['ic_status'] = $ic_status;
        $fields['ds_contato'] = $ds_contato;
        $fields['ds_tel'] = $ds_tel;
        $fields['ds_cel'] = $ds_cel;
        $fields['polos_pk'] = $this->arrToken['polos_pk'];
        $fields['leads_pk'] = $leads_pk;
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = $dt_cadastro;
        $fields["usuario_cadastro_pk"]   = $usuario_cadastro_pk;
        $fields["pk_old"]   = $pk_old;

        $pk = $this->db->execInsert("agendas", $fields);




        return $pk;

    }
    
    public function salvarResponsavelAgenda($responsavel_pk,$agenda_visita_pk){
        $fields = array();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $fields['usuarios_pk'] = $responsavel_pk;
        $fields['agendas_pk'] = $agenda_visita_pk;
           
        $this->db->execInsert("agendas_responsavel", $fields);
        
    }
    
    public function salvarDocumentos($ds_documento_diretorio, $ds_documento,$usuario_cadastro_doc,$leads_pk){

        $fields = array();
        $fields['ds_documento'] = $ds_documento_diretorio;
        $fields['ds_obs'] = $ds_documento;
        $fields['ds_nome_original'] = $ds_documento;
        $fields['leads_pk'] = $leads_pk;
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $usuario_cadastro_doc;
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $usuario_cadastro_doc;

        $pk = $this->db->execInsert("documentos", $fields);
        return $pk;

    }

}

?>
