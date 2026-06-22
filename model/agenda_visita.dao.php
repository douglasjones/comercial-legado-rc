<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/agenda_visita.class.php';
date_default_timezone_set('America/Sao_Paulo');

class agenda_visitadao{

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
    
    public function salvar($agenda_visita){

        $fields = array();
        $fields['dt_agenda'] = $agenda_visita->getdt_agenda();
        $fields['dt_termino'] = $agenda_visita->getdt_termino();
        $fields['ds_endereco'] = $agenda_visita->getds_endereco();
        $fields['ds_numero'] = $agenda_visita->getds_numero();
        $fields['ds_complemento'] = $agenda_visita->getds_complemento();
        $fields['ds_cep'] = $agenda_visita->getds_cep();
        $fields['ds_bairro'] = $agenda_visita->getds_bairro();
        $fields['ds_cidade'] = $agenda_visita->getds_cidade();
        $fields['ds_uf'] = $agenda_visita->getds_uf();
        $fields['ds_obs'] = $agenda_visita->getds_obs();
        $fields['tipo_evento_pk'] = $agenda_visita->gettipo_evento_pk();
        $fields['ds_titulo_agenda'] = $agenda_visita->getds_titulo_agenda();
        $fields['aviso_pk'] = $agenda_visita->getaviso_pk();
        $fields['classificacao_agenda_pk'] = $agenda_visita->getclassificacao_agenda_pk();
        
        if($agenda_visita->getmotivo_cancelamento_pk()!="" || $agenda_visita->getic_status()==4){
             $fields['dt_cancelamento'] = "sysdate()";
        }
        
       
        $fields['motivo_cancelamento_pk'] = $agenda_visita->getmotivo_cancelamento_pk();
        $fields['ds_obs_cancelamento'] = $agenda_visita->getds_obs_cancelamento();
        $fields['dt_reagendamento'] = $agenda_visita->getdt_reagendamento();
        //$fields['motivo_reagendamento_pk'] = $agenda_visita->getmotivo_reagendamento_pk();
        //$fields['ds_obs_reagendamento'] = $agenda_visita->getds_obs_reagendamento();
        $fields['processos_etapas_pk'] = $agenda_visita->getprocessos_etapas_pk();
        $fields['tipos_agendas_pk'] = $agenda_visita->gettipos_agendas_pk();
        $fields['ds_obs_classificacao'] = $agenda_visita->getds_obs_classificacao();
        $fields['ic_status'] = $agenda_visita->getic_status();
        $fields['agenda_reagendamento_pk'] = $agenda_visita->getagenda_reagendamento_pk();
        $fields['ds_contato'] = $agenda_visita->getds_contato();
        $fields['ds_tel'] = $agenda_visita->getds_tel();
        $fields['ds_cel'] = $agenda_visita->getds_cel();
        $fields['ds_email'] = $agenda_visita->getds_email();
        $fields['cargos_pk'] = $agenda_visita->getcargos_pk();
        $fields['polos_pk'] = $agenda_visita->getpolos_pk();
        $fields['leads_pk'] = $agenda_visita->getleads_pk();
        $fields['atendente_pk'] = $agenda_visita->getatendente_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        
        if($agenda_visita->getagenda_reagendamento_pk()!=" "){
            
            $fields_status = array();
            $fields_status['motivo_cancelamento_pk'] = $agenda_visita->getmotivo_cancelamento_pk();
            $fields_status['ds_obs_cancelamento'] = $agenda_visita->getds_obs_cancelamento();
            $fields_status['motivo_reagendamento_pk'] = $agenda_visita->getmotivo_reagendamento_pk();
            $fields_status['ds_obs_reagendamento'] = $agenda_visita->getds_obs_reagendamento();
            $fields_status['ic_status'] = 3 ;

            $this->db->execUpdate("agendas", $fields_status, " pk = ".$agenda_visita->getagenda_reagendamento_pk());
            $fields['ic_status'] = " ";
        }
        if($agenda_visita->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            
            
            
            
            
            $pk = $this->db->execInsert("agendas", $fields);
            

            return $pk;
        }
        else{
            return $this->db->execUpdate("agendas", $fields, " pk = ".$agenda_visita->getpk());
        }

    }

    public function excluir($agenda_visita){
        $this->db->execDelete("agendas"," pk = ".$agenda_visita->getpk());
        
    }

    public function carregarPorPk($pk){

        $agenda_visita = new agenda_visita();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,dt_agenda ";
        $sql.="       ,dt_termino ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ds_obs ";
        $sql.="       ,classificacao_agenda_pk ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,motivo_cancelamento_pk ";
        $sql.="       ,ds_obs_cancelamento ";
        $sql.="       ,dt_reagendamento ";
        $sql.="       ,motivo_reagendamento_pk ";
        $sql.="       ,ds_obs_reagendamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,tipos_agendas_pk";
        $sql.="       ,ds_obs_classificacao";
        $sql.="       ,ic_status";
        $sql.="       ,agenda_reagendamento_pk";
        $sql.="       ,ds_contato";
        $sql.="       ,ds_cel";
        $sql.="       ,ds_tel";
        $sql.="       ,cargos_pk";
        $sql.="       ,atendente_pk";


        $sql.="  from agendas ";
        $sql.=" where pk = $pk ";
       
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agenda_visita->setpk($query[$i]["pk"]);
                $agenda_visita->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agenda_visita->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agenda_visita->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agenda_visita->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agenda_visita->setdt_agenda($query[$i]['dt_agenda']);
                $agenda_visita->setdt_termino($query[$i]['dt_termino']);
                $agenda_visita->setds_endereco($query[$i]['ds_endereco']);
                $agenda_visita->setds_numero($query[$i]['ds_numero']);
                $agenda_visita->setds_complemento($query[$i]['ds_complemento']);
                $agenda_visita->setds_cep($query[$i]['ds_cep']);
                $agenda_visita->setds_bairro($query[$i]['ds_bairro']);
                $agenda_visita->setds_cidade($query[$i]['ds_cidade']);
                $agenda_visita->setds_uf($query[$i]['ds_uf']);
                $agenda_visita->setds_obs($query[$i]['ds_obs']);
                $agenda_visita->setclassificacao_agenda_pk($query[$i]['classificacao_agenda_pk']);
                $agenda_visita->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $agenda_visita->setmotivo_cancelamento_pk($query[$i]['motivo_cancelamento_pk']);
                $agenda_visita->setds_obs_cancelamento($query[$i]['ds_obs_cancelamento']);
                $agenda_visita->setdt_reagendamento($query[$i]['dt_reagendamento']);
                $agenda_visita->setmotivo_reagendamento_pk($query[$i]['motivo_reagendamento_pk']);
                $agenda_visita->setds_obs_reagendamento($query[$i]['ds_obs_reagendamento']);
                $agenda_visita->setprocessos_etapas_pk($query[$i]['processos_etapas_pk']);
                $agenda_visita->settipos_agendas_pk($query[$i]['tipos_agendas_pk']);
                $agenda_visita->setds_obs_classificacao($query[$i]['ds_obs_classificacao']);
                $agenda_visita->setic_status($query[$i]['ic_status']);
                $agenda_visita->setagenda_reagendamento_pk($query[$i]['agenda_reagendamento_pk']);
                $agenda_visita->setds_contato($query[$i]['ds_contato']);
                $agenda_visita->setds_cel($query[$i]['ds_cel']);
                $agenda_visita->setds_tel($query[$i]['ds_tel']);
                $agenda_visita->setcargos_pk($query[$i]['cargos_pk']);
                $agenda_visita->setatendente_pk($query[$i]['atendente_pk']);

            }
        }
        return $agenda_visita;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_agenda ";
        $sql.="       ,dt_termino ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ds_obs ";
        $sql.="       ,classificacao_agenda_pk ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,motivo_cancelamento_pk ";
        $sql.="       ,ds_obs_cancelamento ";
        $sql.="       ,dt_reagendamento ";
        $sql.="       ,motivo_reagendamento_pk ";
        $sql.="       ,ds_obs_reagendamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,tipos_agendas_pk ";
        $sql.="       ,ds_obs_classificacao ";
        $sql.="       ,ic_status";
        $sql.="       ,agenda_reagendamento_pk";
        $sql.="       ,ds_contato";
        $sql.="       ,ds_cel";
        $sql.="       ,ds_tel";
        $sql.="       ,cargos_pk";
        $sql.="       ,atendente_pk";

        $sql.="  from agendas ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dt_agenda($dt_agenda){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_agenda ";
        $sql.="       ,dt_termino ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ds_obs ";
        $sql.="       ,classificacao_agenda_pk ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,motivo_cancelamento_pk ";
        $sql.="       ,ds_obs_cancelamento ";
        $sql.="       ,dt_reagendamento ";
        $sql.="       ,motivo_reagendamento_pk ";
        $sql.="       ,ds_obs_reagendamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,tipos_agendas_pk ";
        $sql.="       ,ds_obs_classificacao ";
        $sql.="       ,ic_status ";
        $sql.="       ,agenda_reagendamento_pk ";
        $sql.="       ,ds_contato";
        $sql.="       ,ds_cel";
        $sql.="       ,ds_tel";
        $sql.="       ,cargos_pk";
        $sql.="       ,atendente_pk";

        $sql.="  from agendas ";
        $sql.=" where 1=1 ";
        if($dt_agenda != ""){
            $sql.=" and ds_agenda_visita like '%".$dt_agenda."%' ";
        }
        $sql.=" order by dt_agenda asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_agenda_visita_para_hoje($polos_pk,$token){
        
        $data = date("d/m/Y");
        
        
        $sql ="";
        $sql.="select count('0') qtde_registros ";
        $sql.="       from agendas a ";
        if(!permissao("meu_gepros_listar", "cons", $token)){
            $sql.="       inner join agendas_responsavel ar on ar.agendas_pk = a.pk";
        }
        else{
            $sql.="       left join agendas_responsavel ar on ar.agendas_pk = a.pk";
        }
        $sql.="     where a.dt_agenda between '".DataYMD($data)." 00:00:00' and  '".DataYMD($data)." 23:59:59'";
        if(!permissao("meu_gepros_listar", "cons", $token)){
            $sql.=" and ar.usuarios_pk = ".$this->arrToken['usuarios_pk'];
        }
        if($polos_pk !=""){
            $sql.=" and a.polos_pk =".$polos_pk;
        }
        else{
            $sql.=" and a.polos_pk =".$this->arrToken['polos_pk'];
        }

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_agenda_visita_agendadas_hoje($polos_pk,$token){
    
        $data = date("d/m/Y");
      
        $sql ="";
        $sql.="select count('0') qtde_registros ";
        $sql.="       from agendas a";
        if(!permissao("meu_gepros_listar", "cons", $token)){
            $sql.="       inner join agendas_responsavel ar on ar.agendas_pk = a.pk";
        }
        else{
            $sql.="       left join agendas_responsavel ar on ar.agendas_pk = a.pk";
        }
        $sql.="     where a.dt_cadastro between '".DataYMD($data)." 00:00:00' and  '".DataYMD($data)." 23:59:59'";
          
        if(!permissao("meu_gepros_listar", "cons", $token)){
            $sql.=" and ar.usuarios_pk = ".$this->arrToken['usuarios_pk'];
        }
        if($polos_pk !=""){
            $sql.=" and a.polos_pk =".$polos_pk;
        }
        else{
            $sql.=" and a.polos_pk =".$this->arrToken['polos_pk'];
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_agenda_visita_lead_processo($leads_pk,$processos_pk){

        $sql ="";
        $sql.="select av.pk, av.dt_cadastro, av.usuario_cadastro_pk, av.dt_ult_atualizacao, av.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(av.dt_agenda, '%d/%m/%Y')dt_agenda_visita ";
        $sql.="       ,date_format(av.dt_agenda, '%H:%i:%s')hr_agenda_visita ";
        $sql.="       ,date_format(av.dt_agenda, '%d/%m/%Y %H:%i:%s')dt_agenda ";
        $sql.="       ,date_format(av.dt_reagendamento, '%d/%m/%Y')dt_reagenda_visita ";
        $sql.="       ,date_format(av.dt_reagendamento, '%H:%i:%s')hr_reagenda_visita ";
        $sql.="       ,date_format(av.dt_reagendamento, '%d/%m/%Y %H:%i:%s')dt_reagendamento ";
        $sql.="       ,av.dt_termino ";
        $sql.="       ,av.ds_endereco ";
        $sql.="       ,av.ds_numero ";
        $sql.="       ,av.ds_complemento ";
        $sql.="       ,av.ds_cep ";
        $sql.="       ,av.ds_bairro ";
        $sql.="       ,av.ds_cidade ";
        $sql.="       ,av.ds_uf ";
        $sql.="       ,av.ds_obs ";
        $sql.="       ,av.classificacao_agenda_pk ";
        $sql.="       ,case av.classificacao_agenda_pk when 1 then 'Produtiva' when 2 then 'Improdutiva' end ds_classificacao_agenda ";
        $sql.="       ,case av.tipos_agendas_pk when 1 then 'Prospecção' when 2 then 'Reunião' when 3 then 'Fechamento' end ds_tipo_agenda ";
        $sql.="       ,av.dt_cancelamento ";
        $sql.="       ,av.motivo_cancelamento_pk ";
        $sql.="       ,av.ds_obs_cancelamento ";
        $sql.="       ,av.dt_reagendamento ";
        $sql.="       ,av.motivo_reagendamento_pk ";
        $sql.="       ,av.ds_obs_reagendamento ";
        $sql.="       ,av.processos_etapas_pk ";
        $sql.="       ,av.tipos_agendas_pk ";
        $sql.="       ,av.ds_obs_classificacao ";
        $sql.="       ,av.ic_status ";
        $sql.="       ,case av.ic_status when 1 then 'Produtivo' when 2 then 'Improdutivo' when 3 then 'Reagendamento' when 4 then 'Cancelado' end ds_status ";
        $sql.="       ,av.agenda_reagendamento_pk ";
        $sql.="       ,av.ds_contato";
        $sql.="       ,av.ds_cel";
        $sql.="       ,av.ds_tel";
        $sql.="       ,av.cargos_pk";
        $sql.="       ,av.ds_email";
        $sql.="       ,case av.tipo_evento_pk when 1 then 'Agenda de Visita' when 2 then 'Lembrete' when 3 then 'Retorno' end ds_tipo_evento";
        $sql.="       ,c.ds_cargo";
        $sql.="       ,av.tipo_evento_pk";
        $sql.="       ,av.aviso_pk";
        $sql.="       ,av.ds_titulo_agenda";
        $sql.="       ,av.atendente_pk";

        $sql.="  from agendas av ";
        $sql.="       inner join processos_etapas pe on av.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.="       left join cargos c on av.cargos_pk = c.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and p.leads_pk=".$leads_pk;
        }
        if($processos_pk!=""){
            $sql.=" and p.pk=".$processos_pk;
        }
        $sql.=" order by av.dt_agenda asc ";
      
      
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_agenda_visita_dashboard($polos_pk){

        $sql ="";
        $sql.="select av.pk, av.dt_cadastro, av.usuario_cadastro_pk, av.dt_ult_atualizacao, av.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(av.dt_agenda, '%d/%m/%Y')dt_agenda_visita ";
        $sql.="       ,date_format(av.dt_agenda, '%H:%i:%s')hr_agenda_visita ";
        $sql.="       ,date_format(av.dt_agenda, '%d/%m/%Y %H:%i:%s')dt_agenda ";
        $sql.="       ,date_format(av.dt_reagendamento, '%d/%m/%Y')dt_reagenda_visita ";
        $sql.="       ,date_format(av.dt_reagendamento, '%H:%i:%s')hr_reagenda_visita ";
        $sql.="       ,date_format(av.dt_reagendamento, '%d/%m/%Y %H:%i:%s')dt_reagendamento ";
        $sql.="       ,av.dt_termino ";
        $sql.="       ,av.ds_endereco ";
        $sql.="       ,av.ds_numero ";
        $sql.="       ,av.ds_complemento ";
        $sql.="       ,av.ds_cep ";
        $sql.="       ,av.ds_bairro ";
        $sql.="       ,av.ds_cidade ";
        $sql.="       ,av.ds_uf ";
        $sql.="       ,av.ds_obs ";
        $sql.="       ,av.classificacao_agenda_pk ";
        $sql.="       ,case av.classificacao_agenda_pk when 1 then 'Produtiva' when 2 then 'Improdutiva' end ds_classificacao_agenda ";
        $sql.="       ,case av.tipos_agendas_pk when 1 then 'Prospecção' when 2 then 'Reunião' when 3 then 'Fechamento' end ds_tipo_agenda ";
        $sql.="       ,av.dt_cancelamento ";
        $sql.="       ,av.motivo_cancelamento_pk ";
        $sql.="       ,av.ds_obs_cancelamento ";
        $sql.="       ,av.dt_reagendamento ";
        $sql.="       ,av.motivo_reagendamento_pk ";
        $sql.="       ,av.ds_obs_reagendamento ";
        $sql.="       ,av.processos_etapas_pk ";
        $sql.="       ,av.tipos_agendas_pk ";
        $sql.="       ,av.ds_obs_classificacao ";
        $sql.="       ,av.ic_status ";
        $sql.="       ,case av.ic_status when 1 then 'Produtivo' when 2 then 'Improdutivo' when 3 then 'Reagendamento' when 4 then 'Cancelado' end ds_status ";
        $sql.="       ,av.agenda_reagendamento_pk ";
        $sql.="       ,av.ds_contato";
        $sql.="       ,av.ds_cel";
        $sql.="       ,av.ds_tel";
        $sql.="       ,av.cargos_pk";
        $sql.="       ,case av.tipo_evento_pk when 1 then 'Agenda de Visita' when 2 then 'Lembrete' when 3 then 'Retorno' end ds_tipo_evento";
        $sql.="       ,c.ds_cargo";
        $sql.="       ,av.tipo_evento_pk";
        $sql.="       ,av.aviso_pk";
        $sql.="       ,av.ds_titulo_agenda";
        $sql.="       ,l.ds_lead";
        $sql.="       ,av.leads_pk";
        $sql.="       ,av.polos_pk";
        $sql.="       ,av.atendente_pk";
        $sql.="       ,p.pk processos_pk";

        $sql.="  from agendas av ";
        $sql.="       inner join processos_etapas pe on av.processos_etapas_pk = pe.pk";
        $sql.="       inner join processos p on pe.processos_pk = p.pk";
        $sql.="       inner join leads l on av.leads_pk = l.pk";
        $sql.="       INNER JOIN agendas_responsavel ar ON ar.agendas_pk = av.pk";
        $sql.="       left join cargos c on av.cargos_pk = c.pk";
        $sql.=" where 1=1 ";
        if($this->arrToken['grupos_pk']!=2){
            $sql.=" and av.classificacao_agenda_pk is null";
        }
        if($polos_pk!=""){
            $sql.=" and av.polos_pk = ".$polos_pk;
        }
        $sql.=" and ar.usuarios_pk = ".$this->arrToken['usuarios_pk'];
        $sql.=" order by av.dt_agenda asc ";
        
      
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_agenda_visita_responsavel($pk,$token){
        if(permissao("grupo_consultor_listar", "cons", $token)){
            $sql ="";
            $sql.="select  a.pk,";
            $sql.="       u.pk usuarios_pk ";

            $sql.="  from usuarios u";
            $sql.="       inner join grupos g on u.grupos_pk = g.pk";
            $sql.="       inner join agendas_responsavel ar on u.pk = ar.usuarios_pk";
            $sql.="       inner join agendas a on a.pk = ar.agendas_pk";
            $sql.=" where 1=1";
            //$sql.=" and lr.leads_pk = ".$leads_pk;
            $sql.=" and ar.usuarios_pk = ".$this->arrToken['usuarios_pk'];
            $sql.=" group by u.pk";
        }
            
        else{
            $sql ="";
            $sql.="select av.pk, av.dt_cadastro, av.usuario_cadastro_pk, av.dt_ult_atualizacao, av.usuario_ult_atualizacao_pk ";
            $sql.="       ,u.pk usuarios_pk";
            $sql.="       ,av.ds_contato";
            $sql.="       ,av.ds_cel";
            $sql.="       ,av.ds_tel";
            $sql.="       ,av.cargos_pk";
            $sql.="       ,av.atendente_pk";
            $sql.="  from agendas av ";
            $sql.="       left join agendas_responsavel ar on av.pk = ar.agendas_pk";
            $sql.="       inner join usuarios u on ar.usuarios_pk = u.pk";
            $sql.=" where 1=1 ";
            if($pk!=""){
                $sql.=" and av.pk=".$pk;
            }

            $sql.=" order by av.dt_agenda asc ";
            
        }
        
        


        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_agenda ";
        $sql.="       ,dt_termino ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ds_obs ";
        $sql.="       ,classificacao_agenda_pk ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,motivo_cancelamento_pk ";
        $sql.="       ,ds_obs_cancelamento ";
        $sql.="       ,dt_reagendamento ";
        $sql.="       ,motivo_reagendamento_pk ";
        $sql.="       ,ds_obs_reagendamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,tipos_agendas_pk ";
        $sql.="       ,ds_obs_classificacao ";
        $sql.="       ,ic_status ";
        $sql.="       ,agenda_reagendamento_pk ";
        $sql.="       ,ds_contato";
        $sql.="       ,ds_cel";
        $sql.="       ,ds_tel";
        $sql.="       ,cargos_pk";
        $sql.="       ,atendente_pk";

        $sql.="  from agendas ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_agenda asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeVisita($token,$usuario_pk){

        $sql ="";
        $sql.="select count('0')registros";

        $sql.="  from agendas a";
        $sql.="        inner join agendas_responsavel ar on a.pk = ar.agendas_pk";
        $sql.=" where 1=1 ";
        $sql.=" and ar.usuarios_pk =".$usuario_pk;
        $sql.=" order by dt_agenda asc ";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarGraficoAgendamento($token,$dt_inicio,$dt_fim,$classificacao_agenda_pk,$polos_pk){

        $sql ="";
        $sql.="SELECT COUNT('0') total_agendas,";
        $sql.="       CASE IF(ic_status IS NULL,0,ic_status ) WHEN 0 THEN 'Sem Classificação' WHEN 1 THEN 'Produtivo' WHEN 2 THEN 'Improdutivo' WHEN 3 THEN 'Reagendado' WHEN 4 THEN 'Cancelado' END ds_classificacao";
        $sql.="  FROM agendas";
        $sql.=" where dt_agenda between '".DataYMD($dt_inicio)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59'";
        $sql.=" and contas_pk = ".$this->arrToken['contas_pk'];
        if($classificacao_agenda_pk==0){
            $sql.=" and ic_status is null";
        }
        else{
            $sql.=" and ic_status =".$classificacao_agenda_pk;
        }
        if($polos_pk!=""){
            $sql.=" and polos_pk = ".$this->arrToken['polos_pk'];
        }
        $sql.=" GROUP BY ic_status ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RellistarGraficoAgendamento($token,$polos_pk,$ds_razao_social,$tipos_agendas_pk,$ic_status_1,$ic_status_2,$ic_status_3,$dt_agenda_ini,$dt_agenda_fim,$mailing_pk,$responsavel_pk,$grupos_pk){
        
        
        
        $sql.=" select COUNT('0') total_agendas,";
        $sql.="        CASE IF(av.ic_status IS NULL,0,av.ic_status ) WHEN 0 THEN 'Sem Classificação' WHEN 1 THEN 'Produtivo' WHEN 2 THEN 'Improdutivo' WHEN 3 THEN 'Reagendado' WHEN 4 THEN 'Cancelado' END ds_classificacao";
        $sql.="  from agendas av ";
        $sql.="       left join agendas_responsavel ar on av.pk = ar.agendas_pk";
        $sql.="       left join usuarios u on ar.usuarios_pk = u.pk";
        $sql.="       inner join usuarios usu on av.usuario_cadastro_pk = usu.pk";
        $sql.="       inner join leads l on av.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($dt_agenda_ini!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') >= '".DataYMD($dt_agenda_ini)." '";
        }
        if($dt_agenda_fim!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') <='".DataYMD($dt_agenda_fim)." '";
        }
        if($polos_pk!=""){
            $sql.=" and av.polos_pk =".$polos_pk;
        }
        if($mailing_pk!=""){
            $sql.=" and av.mailing_pk =".$mailing_pk;
        }
        if($ds_razao_social!=""){
            $sql.=" and l.ds_razao_social like '%".$ds_razao_social."%'";
        }
        if($tipos_agendas_pk!=""){
            $sql.=" and av.tipos_agendas_pk =".$tipos_agendas_pk;
        }
        if($responsavel_pk!=""){
            $sql.=" and ar.usuarios_pk =".$responsavel_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and u.grupos_pk =".$grupos_pk;
        }
        
        $sql.=" group by av.ic_status";
        $sql.=" order by av.ic_status asc";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RellistarGraficoAgendamentoDashboard($token,$responsavel_pk,$dt_inicio,$dt_fim){
        
        
        
        $sql.=" select COUNT('0') total_agendas,";
        $sql.="        CASE IF(av.ic_status IS NULL,0,av.ic_status ) WHEN 0 THEN 'Sem Classificação' WHEN 1 THEN 'Produtivo' WHEN 2 THEN 'Improdutivo' WHEN 3 THEN 'Reagendado' WHEN 4 THEN 'Cancelado' END ds_classificacao";
        $sql.="  from agendas av ";
        $sql.="       left join agendas_responsavel ar on av.pk = ar.agendas_pk";
        $sql.="       left join usuarios u on ar.usuarios_pk = u.pk";
        $sql.="       inner join usuarios usu on av.usuario_cadastro_pk = usu.pk";
        $sql.="       inner join leads l on av.leads_pk = l.pk";
        $sql.="       inner join equipes_usuarios eu on ar.usuarios_pk = eu.usuarios_pk";
        $sql.=" where 1=1 ";
        if($dt_inicio!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') >= '".DataYMD($dt_inicio)." '";
        }
        if($dt_fim!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') <='".DataYMD($dt_fim)." '";
        }
        if($responsavel_pk!=""){
            $sql.=" and ar.usuarios_pk =".$responsavel_pk;
        }

        $sql.=" group by av.ic_status";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RellistarGraficoDashboardSupervisorAgendadoPor($token,$responsavel_pk,$dt_ini,$dt_fim){
        
        
        
        $sql.=" select COUNT('0') total_agendas,";
        $sql.="        usu.ds_usuario ds_usuario_cadastro";
        $sql.="  from agendas av ";
        $sql.="       left join agendas_responsavel ar on av.pk = ar.agendas_pk";
        $sql.="       left join usuarios u on ar.usuarios_pk = u.pk";
        $sql.="       inner join usuarios usu on av.usuario_cadastro_pk = usu.pk";
        $sql.="       inner join equipes_usuarios eu on ar.usuarios_pk = eu.usuarios_pk";
        $sql.="       inner join leads l on av.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($dt_ini!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') >= '".DataYMD($dt_ini)." '";
        }
        if($dt_fim!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') <='".DataYMD($dt_fim)." '";
        }
        if($responsavel_pk!=""){
            $sql.=" and ar.usuarios_pk =".$responsavel_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.="     eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        $sql.=" group by av.usuario_cadastro_pk";
       
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RellistarGraficoAgendadoPor($token,$polos_pk,$ds_razao_social,$tipos_agendas_pk,$ic_status_1,$ic_status_2,$ic_status_3,$dt_agenda_ini,$dt_agenda_fim,$mailing_pk,$responsavel_pk,$grupos_pk){
        
        
        
        $sql.=" select COUNT('0') total_agendas,";
        $sql.="        usu.ds_usuario ds_usuario_cadastro";
        $sql.="  from agendas av ";
        $sql.="       left join agendas_responsavel ar on av.pk = ar.agendas_pk";
        $sql.="       left join usuarios u on ar.usuarios_pk = u.pk";
        $sql.="       inner join usuarios usu on av.usuario_cadastro_pk = usu.pk";
        $sql.="       inner join leads l on av.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($dt_agenda_ini!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') >= '".DataYMD($dt_agenda_ini)." '";
        }
        if($dt_agenda_fim!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') <='".DataYMD($dt_agenda_fim)." '";
        }
        if($polos_pk!=""){
            $sql.=" and av.polos_pk =".$polos_pk;
        }
        if($mailing_pk!=""){
            $sql.=" and av.mailing_pk =".$mailing_pk;
        }
        if($ds_razao_social!=""){
            $sql.=" and l.ds_razao_social like '%".$ds_razao_social."%'";
        }
        if($tipos_agendas_pk!=""){
            $sql.=" and av.tipos_agendas_pk =".$tipos_agendas_pk;
        }
        if($responsavel_pk!=""){
            $sql.=" and ar.usuarios_pk =".$responsavel_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and u.grupos_pk =".$grupos_pk;
        }

        $sql.=" group by av.usuario_cadastro_pk";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function PegarData($data,$mes){

        $sql.=" select date_format(DATE_ADD('".DataYMD($data)."',INTERVAL -".$mes."  MONTH), '%d/%m/%Y') data";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function adicionarResponsavel($responsavel_pk,$agenda_visita_pk){
        $fields = array();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $fields['usuarios_pk'] = $responsavel_pk;
        $fields['agendas_pk'] = $agenda_visita_pk;
           
        $this->db->execInsert("agendas_responsavel", $fields);
        
    }
    public function excluirResponsavel($agenda_visita_pk){
        $this->db->execDelete("agendas_responsavel"," agendas_pk = ".$agenda_visita_pk);
        
        
    }
    
    public function excluirResponsavelPk($pk){
        $this->db->execDelete("agendas_responsavel"," pk = ".$pk);
        
    }
    public function excluirAgendaResponsavelPk($pk){
        $this->db->execDelete("agendas_responsavel"," agendas_pk = ".$pk);
        
    }
     public function listar_data($dt_agenda){

        $sql ="";
        $sql.="select date_format('".  DataYMD($dt_agenda)."','%w')dia_semana";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    public function listar_agenda_visita_data($token,$dt_base,$dt_base_fim,$tipo_evento_pk,$tipos_agendas_pk,$classificacao_agenda_pk,$polos_pk,$grupos_pk,$usuarios_pk,$usuario_cadastro_pk,$equipes_pk,$atendente_pk){
        $sql ="";
        $sql.=" select av.pk ";
        $sql.="       ,date_format(av.dt_agenda, '%d/%m/%Y')dt_agenda_visita ";
        $sql.="       ,date_format(av.dt_agenda, '%H:%i')hr_agenda_visita ";
        $sql.="       ,date_format(av.dt_agenda, '%d/%m/%Y %H:%i:%s')dt_agenda ";
        
        $sql.="       ,date_format(av.dt_reagendamento, '%d/%m/%Y')dt_reagenda_visita ";
        $sql.="       ,date_format(av.dt_reagendamento, '%H:%i')hr_reagenda_visita ";
        $sql.="       ,date_format(av.dt_reagendamento, '%d/%m/%Y %H:%i:%s')dt_reagendamento ";
        
        
        $sql.="       ,av.dt_termino ";
        $sql.="       ,av.ds_endereco ";
        $sql.="       ,av.ds_numero ";
        $sql.="       ,av.ds_complemento ";
        $sql.="       ,av.ds_cep ";
        $sql.="       ,av.ds_bairro ";
        $sql.="       ,av.ds_cidade ";
        $sql.="       ,av.ds_uf ";
        $sql.="       ,av.ds_obs ";
        $sql.="       ,av.leads_pk ";
        $sql.="       ,av.polos_pk ";
        $sql.="       ,av.processos_etapas_pk";
        $sql.="       ,av.classificacao_agenda_pk ";
        $sql.="       ,case av.classificacao_agenda_pk when 1 then 'Produtiva' when 2 then 'Improdutiva' end ds_classificacao_agenda ";
        $sql.="       ,case av.tipos_agendas_pk when 1 then 'Prospecção' when 2 then 'Reunião' when 3 then 'Fechamento' end ds_tipo_agenda ";
        $sql.="       ,av.dt_cancelamento ";
        $sql.="       ,av.motivo_cancelamento_pk ";
        $sql.="       ,av.ds_obs_cancelamento ";
        $sql.="       ,av.dt_reagendamento ";
        $sql.="       ,av.motivo_reagendamento_pk ";
        $sql.="       ,av.ds_obs_reagendamento ";
        $sql.="       ,av.processos_etapas_pk ";
        $sql.="       ,av.tipos_agendas_pk ";
        $sql.="       ,av.ds_obs_classificacao ";
        $sql.="       ,av.ic_status ";
        $sql.="       ,case av.ic_status when 1 then 'Produtivo' when 2 then 'Improdutivo' when 3 then 'Reagendamento' when 4 then 'Cancelado' end ds_status ";
        $sql.="       ,case av.tipo_evento_pk when 1 then 'Agenda Visita' when 2 then 'Lembrete' when 3 then 'Retorno' end ds_tipo_evento ";
        $sql.="       ,av.agenda_reagendamento_pk ";
        $sql.="       ,av.tipo_evento_pk";
        $sql.="       ,av.ds_titulo_agenda";
        $sql.="       ,av.aviso_pk";
        $sql.="       ,l.ds_lead";
        $sql.="       ,group_concat(u.ds_usuario)ds_responsavel";
        $sql.="       ,group_concat(ar.usuarios_pk)responsavel_pk";
        
        
        $sql.="       ,usu.ds_usuario ds_usuario_cadastro";
        $sql.="       ,av.ds_contato";
        $sql.="       ,av.ds_cel";
        $sql.="       ,av.ds_tel";
        $sql.="       ,av.cargos_pk";
        $sql.="       ,av.ds_email";
        $sql.="       ,av.atendente_pk";
        $sql.="       ,usua.ds_usuario ds_atendente";
        
        
        $sql.="       ,c.ds_cargo";
        $sql.="       ,av.usuario_cadastro_pk";
        $sql.="  from agendas av ";
        $sql.="       left join agendas_responsavel ar on av.pk = ar.agendas_pk";
        $sql.="       left join usuarios u on ar.usuarios_pk = u.pk";
        $sql.="       left join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.="       left join cargos c on av.cargos_pk = c.pk";
        $sql.="       left join usuarios usu on av.usuario_cadastro_pk = usu.pk";
        $sql.="       left join usuarios usua on av.atendente_pk = usua.pk";
        
        $sql.="       inner join leads l on av.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') >= '".DataYMD($dt_base)." '";
        $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') <='".DataYMD($dt_base_fim)." '";
        $sql.=" and av.contas_pk=".$this->arrToken['contas_pk'];
        
        if(!empty($tipo_evento_pk)){
            $sql.=" and av.tipo_evento_pk=".$tipo_evento_pk;
        } 
    
        if(!empty($tipos_agendas_pk)){
            $sql.=" and av.tipos_agendas_pk=".$tipos_agendas_pk;
        } 
        
        
        if(!empty($classificacao_agenda_pk)){
            $sql.=" and av.classificacao_agenda_pk=".$classificacao_agenda_pk;
        }   
        
        if(!empty($polos_pk)){
            $sql.=" and av.polos_pk=".$polos_pk;
        }   
        if(!empty($atendente_pk)){
            $sql.=" and av.atendente_pk=".$atendente_pk;
        }   
        
        if(!empty($grupos_pk)){
            $sql.=" and u.grupos_pk=".$grupos_pk;
        }  
        if($usuarios_pk=="Null"){
            $sql.=" and ar.usuarios_pk is null";
        }
        else{
            if(!empty($usuarios_pk)){
                $sql.=" and ar.usuarios_pk=".$usuarios_pk;
            }  
        }
        if(!empty($usuario_cadastro_pk)){
            $sql.=" and av.usuario_cadastro_pk =".$usuario_cadastro_pk;
        }  
        if(!empty($usuarios_pk)){
            $sql.=" and ar.usuarios_pk=".$usuarios_pk;
        }  
        if(!empty($equipes_pk)){
           $sql.=" and eu.equipes_pk = ".$equipes_pk;
        }  
        if(!permissao("supervisor_listar_equipes", "cons", $token)){
            if($this->arrToken['equipes_pk']!=""){
                $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
            }
        }
        
        $sql.=" group by av.pk"; 
        $sql.=" order by av.dt_agenda desc"; 
       

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    public function listar_responsavel_agenda($agenda_visita_pk){
        $sql.=" select group_concat(u.ds_usuario) ds_consultor ";
        $sql.="        from agendas_responsavel ar";
        $sql.="           inner join usuarios u on ar.usuarios_pk = u.pk";
        $sql.="         where ar.agendas_pk = ".$agenda_visita_pk;
        
                
        $query = $this->db->execQuery($sql);
        return $query;
        
        
    }
    public function listar_qtde_agenda_visita($token,$dt_base,$dt_base_fim,$tipo_evento_pk,$tipos_agendas_pk,$classificacao_agenda_pk,$polos_pk,$grupos_pk,$usuarios_pk,$usuario_cadastro_pk,$equipes_pk,$atendente_pk){
        $sql ="";
        $sql.=" select count('0')registro ";
        $sql.="       ,case av.ic_status when 1 then 'Produtivo' when 2 then 'Improdutivo' when 3 then 'Reagendamento' when 4 then 'Cancelado' end ds_status ";
        $sql.="       ,av.ic_status";
        $sql.="  from agendas av ";
        if($usuarios_pk!=""){
            $sql.="       inner join agendas_responsavel ar on av.pk = ar.agendas_pk";
            $sql.="       inner join usuarios u on ar.usuarios_pk = u.pk";
            $sql.="       inner join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        }
        else if(!empty($grupos_pk)){
            $sql.="       inner join agendas_responsavel ar on av.pk = ar.agendas_pk";
            $sql.="       inner join usuarios u on ar.usuarios_pk = u.pk";
            $sql.="       inner join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        }
        else if(!empty($equipes_pk)){
            $sql.="       inner join agendas_responsavel ar on av.pk = ar.agendas_pk";
            $sql.="       inner join usuarios u on ar.usuarios_pk = u.pk";
            $sql.="       inner join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        }
        else if(!permissao("supervisor_listar_equipes", "cons", $token)){
            if($this->arrToken['equipes_pk']!=""){
                $sql.="       inner join agendas_responsavel ar on av.pk = ar.agendas_pk";
                $sql.="       inner join usuarios u on ar.usuarios_pk = u.pk";
                $sql.="       inner join equipes_usuarios eu on u.pk = eu.usuarios_pk";
            }
        }
        
        
        $sql.="       inner join usuarios usu on av.usuario_cadastro_pk = usu.pk";
        $sql.=" where 1=1 ";
        $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') >= '".DataYMD($dt_base)." '";
        $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') <='".DataYMD($dt_base_fim)." '";
        $sql.=" and av.contas_pk=".$this->arrToken['contas_pk'];
        
        if(!empty($tipo_evento_pk)){
            $sql.=" and av.tipo_evento_pk=".$tipo_evento_pk;
        } 
    
        if(!empty($tipos_agendas_pk)){
            $sql.=" and av.tipos_agendas_pk=".$tipos_agendas_pk;
        } 
        if(!empty($atendente_pk)){
            $sql.=" and av.atendente_pk =".$atendente_pk;
        } 
        
        
        if(!empty($classificacao_agenda_pk)){
            $sql.=" and av.classificacao_agenda_pk=".$classificacao_agenda_pk;
        }   
        
        if(!empty($polos_pk)){
            $sql.=" and av.polos_pk=".$polos_pk;
        }   
        if(!empty($usuario_cadastro_pk)){
            $sql.=" and av.usuario_cadastro_pk=".$usuario_cadastro_pk;
        }   
        
        if(!empty($grupos_pk)){
            $sql.=" and u.grupos_pk=".$grupos_pk;
        }  
        if($usuarios_pk=="Null"){
            $sql.=" and ar.usuarios_pk is null";
        }
        else{
            if(!empty($usuarios_pk)){
                $sql.=" and ar.usuarios_pk=".$usuarios_pk;
            }  
        }
        
        if($equipes_pk!=""){
            $sql.=" and eu.equipes_pk = ".$equipes_pk;
        }
        
        if(!permissao("supervisor_listar_equipes", "cons", $token)){
            if($this->arrToken['equipes_pk']!=""){
                $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
            }
        }

        $sql.=" GROUP BY av.ic_status"; 
        $sql.=" order by av.dt_agenda desc";
       
    
        
       

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listar_rel_agenda_visita($polos_pk,$ds_razao_social,$tipos_agendas_pk,$ic_status_1,$ic_status_2,$ic_status_3,$dt_agenda_ini,$dt_agenda_fim,$mailing_pk,$responsavel_pk,$grupos_pk,$dt_visita_ini,$dt_visita_fim){
        
        
        $sql.=" select av.pk ";
        $sql.="       ,date_format(av.dt_agenda, '%d/%m/%Y')dt_agenda_visita ";
        $sql.="       ,date_format(av.dt_agenda, '%H:%i:%s')hr_agenda_visita ";
        $sql.="       ,date_format(av.dt_agenda, '%d/%m/%Y %H:%i:%s')dt_agenda ";
        $sql.="       ,date_format(av.dt_cadastro, '%d/%m/%Y %H:%i:%s')dt_cadastro ";
        
        $sql.="       ,date_format(av.dt_reagendamento, '%d/%m/%Y')dt_reagenda_visita ";
        $sql.="       ,date_format(av.dt_reagendamento, '%H:%i:%s')hr_reagenda_visita ";
        $sql.="       ,date_format(av.dt_reagendamento, '%d/%m/%Y %H:%i:%s')dt_reagendamento ";
        
        
        $sql.="       ,av.dt_termino ";
        $sql.="       ,av.ds_endereco ";
        $sql.="       ,av.ds_numero ";
        $sql.="       ,av.ds_complemento ";
        $sql.="       ,av.ds_cep ";
        $sql.="       ,av.ds_bairro ";
        $sql.="       ,av.ds_cidade ";
        $sql.="       ,av.ds_uf ";
        $sql.="       ,av.ds_obs ";
        $sql.="       ,av.leads_pk ";
        $sql.="       ,av.polos_pk ";
        $sql.="       ,av.processos_etapas_pk";
        $sql.="       ,av.classificacao_agenda_pk ";
        $sql.="       ,case av.classificacao_agenda_pk when 1 then 'Produtiva' when 2 then 'Improdutiva' end ds_classificacao_agenda ";
        $sql.="       ,case av.tipos_agendas_pk when 1 then 'Prospecção' when 2 then 'Reunião' when 3 then 'Fechamento' end ds_tipo_agenda ";
        $sql.="       ,av.dt_cancelamento ";
        $sql.="       ,av.motivo_cancelamento_pk ";
        $sql.="       ,av.ds_obs_cancelamento ";
        $sql.="       ,av.dt_reagendamento ";
        $sql.="       ,av.motivo_reagendamento_pk ";
        $sql.="       ,av.ds_obs_reagendamento ";
        $sql.="       ,av.processos_etapas_pk ";
        $sql.="       ,av.tipos_agendas_pk ";
        $sql.="       ,av.ds_obs_classificacao ";
        $sql.="       ,av.ic_status ";
        $sql.="       ,case av.ic_status when 1 then 'Produtivo' when 2 then 'Improdutivo' when 3 then 'Reagendamento' when 4 then 'Cancelado' end ds_status ";
        $sql.="       ,case av.tipo_evento_pk when 1 then 'Agenda Visita' when 2 then 'Lembrete' when 3 then 'Retorno' end ds_tipo_evento ";
        $sql.="       ,av.agenda_reagendamento_pk ";
        $sql.="       ,av.tipo_evento_pk";
        $sql.="       ,av.ds_titulo_agenda";
        $sql.="       ,av.aviso_pk";
        $sql.="       ,group_concat(u.ds_usuario)ds_responsavel";
        $sql.="       ,usu.ds_usuario ds_usuario_cadastro";
        $sql.="       ,av.ds_contato";
        $sql.="       ,av.ds_cel";
        $sql.="       ,av.ds_tel";
        $sql.="       ,av.cargos_pk";
        $sql.="       ,av.atendente_pk";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,l.ds_razao_social";
        $sql.="  from agendas av ";
        $sql.="       left join agendas_responsavel ar on av.pk = ar.agendas_pk";
        $sql.="       left join usuarios u on ar.usuarios_pk = u.pk";
        $sql.="       inner join usuarios usu on av.usuario_cadastro_pk = usu.pk";
        $sql.="       inner join leads l on av.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($dt_agenda_ini!=""){
            $sql.=" and date_format(av.dt_cadastro,'%Y-%m-%d') >= '".DataYMD($dt_agenda_ini)." '";
        }
        if($dt_agenda_fim!=""){
            $sql.=" and date_format(av.dt_cadastro,'%Y-%m-%d') <='".DataYMD($dt_agenda_fim)." '";
        }
        if($dt_visita_ini!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') >= '".DataYMD($dt_visita_ini)." '";
        }
        if($dt_visita_fim!=""){
            $sql.=" and date_format(av.dt_agenda,'%Y-%m-%d') <='".DataYMD($dt_visita_fim)." '";
        }
        if($polos_pk!=""){
            $sql.=" and av.polos_pk =".$polos_pk;
        }
        if($mailing_pk!=""){
            $sql.=" and av.mailing_pk =".$mailing_pk;
        }
        if($ds_razao_social!=""){
            $sql.=" and l.ds_razao_social like '%".$ds_razao_social."%'";
        }
        if($tipos_agendas_pk!=""){
            $sql.=" and av.tipos_agendas_pk =".$tipos_agendas_pk;
        }
        if($responsavel_pk!=""){
            $sql.=" and ar.usuarios_pk =".$responsavel_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and u.grupos_pk =".$grupos_pk;
        }
        if($ic_status_1!="" || $ic_status_2!=""||$ic_status_3!=""){
            $sql.=" and av.ic_status in(";
            if($ic_status_1!=""){
                $sql.=$ic_status_1.",";
            }
            if($ic_status_2!=""){
                 $sql.=$ic_status_2.",";
            }
            if($ic_status_3!=""){
                 $sql.=$ic_status_3.",";
            }
            $sql.="0)";
        }
        
        
        
        $sql.=" group by av.pk"; 
        $sql.=" order by av.dt_agenda desc"; 
        
        $query = $this->db->execQuery($sql);
        return $query;
        
        
    }
    

}

?>
