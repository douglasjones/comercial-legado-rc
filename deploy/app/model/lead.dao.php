<?php
ini_set('memory_limit','550M');
require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/lead.class.php';


class leaddao{

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
    
    public function salvar($lead){

        $fields = array();
        $fields['tipo_pessoa_pk'] = $lead->gettipo_pessoa_pk();
        $fields['ds_lead'] = $lead->getds_lead();
        $fields['ds_razao_social'] = $lead->getds_razao_social();
        $fields['ds_cpf_cnpj'] = $lead->getds_cpf_cnpj();
        $fields['ds_ie'] = $lead->getds_ie();
        $fields['ds_rg'] = $lead->getds_rg();
        $fields['ds_cnae'] = $lead->getds_cnae();
        $fields['ic_cliente'] = $lead->getic_cliente();
        $fields['ds_obs'] = $lead->getds_obs();
        $fields['ds_site'] = $lead->getds_site();
        $fields['mailing_pk'] = $lead->getmailing_pk();
        $fields['contas_pk'] = $this->arrToken['contas_pk'];
        $fields['polos_pk'] = $lead->getpolos_pk();
        $fields['ciclo_uso'] = $lead->getciclo_uso();
        $fields['ds_log'] = $lead->getds_log();
        

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($lead->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("leads", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("leads", $fields, " pk = ".$lead->getpk());
        }

    }

    public function excluir($lead){
        $this->db->execDelete("leads"," pk = ".$lead->getpk());
    }
    public function excluirAgendas($leads_pk){
        $this->db->execDelete("agendas"," leads_pk = ".$leads_pk);
    }
    public function excluirProposta($leads_pk){
        $this->db->execDelete("propostas"," leads_pk = ".$leads_pk);
    }
    public function excluirProcesso($leads_pk){
        $this->db->execDelete("processos"," leads_pk = ".$leads_pk);
    }
    public function excluirRetorno($ocorrencias_pk){
        $this->db->execDelete("retornos"," ocorrencias_pk = ".$ocorrencias_pk);
    }
    public function excluirDocumento($leads_pk){
        $this->db->execDelete("documentos"," leads_pk = ".$leads_pk);
    }
    public function excluirOcorrencia($leads_pk){
        $this->db->execDelete("ocorrencias"," leads_pk = ".$leads_pk);
    }

    public function carregarPorPk($pk){

        $lead = new lead();
        if($pk != ""){
            
        $sql ="select pk ";
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
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_site ";
        $sql.="       ,mailing_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";


        $sql.="  from leads ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $lead->setpk($query[$i]["pk"]);
                $lead->setdt_cadastro($query[$i]["dt_cadastro"]);
                $lead->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $lead->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $lead->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $lead->settipo_pessoa_pk($query[$i]['tipo_pessoa_pk']);
                $lead->setds_lead($query[$i]['ds_lead']);
                $lead->setds_razao_social($query[$i]['ds_razao_social']);
                $lead->setds_cpf_cnpj($query[$i]['ds_cpf_cnpj']);
                $lead->setds_ie($query[$i]['ds_ie']);
                $lead->setds_rg($query[$i]['ds_rg']);
                $lead->setds_cnae($query[$i]['ds_cnae']);
                $lead->setic_cliente($query[$i]['ic_cliente']);
                $lead->setds_obs($query[$i]['ds_obs']);
                $lead->setds_site($query[$i]['ds_site']);
                $lead->setmailing_pk($query[$i]['mailing_pk']);
                $lead->setcontas_pk($query[$i]['contas_pk']);
                $lead->setpolos_pk($query[$i]['polos_pk']);

            }
        }
        return $lead;
    }
    
    public function listarIntervaloMenos2Meses($data){
        $sql.=" select date_format(DATE_ADD('".DataYMD($data)."',INTERVAL -2  MONTH), '%d/%m/%Y') data";
        $query = $this->db->execQuery($sql);
        return $query[0]['data'];
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk  ";
        $sql.="       ,l.tipo_pessoa_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,l.ds_razao_social ";
        $sql.="       ,l.ds_cpf_cnpj ";
        $sql.="       ,l.ds_ie ";
        $sql.="       ,l.ds_rg ";
        $sql.="       ,l.ds_cnae ";
        $sql.="       ,l.ic_cliente ";
        $sql.="       ,case l.ic_cliente when 1 then 'Sim' when 2 then 'Não' end ds_cliente ";
        $sql.="       ,l.ds_obs ";
        $sql.="       ,l.ds_site ";
        $sql.="       ,l.mailing_pk ";
        $sql.="       ,l.contas_pk ";
        $sql.="       ,l.polos_pk ";
        $sql.="       ,l.ciclo_uso";
        $sql.="       ,l.ds_log";
        $sql.="       ,p.ds_polo";
        $sql.="       ,m.ds_mailing";

        $sql.="  from leads l";
        $sql.="     inner join polos p on l.polos_pk = p.pk";
        $sql.="     left join mailing m on l.mailing_pk = m.pk";
        $sql.=" where l.pk = $pk ";
        $sql.=" and l.contas_pk = ".$this->arrToken['contas_pk'];
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeLeadCadastradoSupervisor($token,$usuario_pk){

        $sql ="";
        $sql.="select count('pk')registros";
        $sql.="  from leads l";
        $sql.=" where 1=1 ";
        $sql.=" and l.usuario_cadastro_pk = ".$usuario_pk;
        
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorPkOld($pk_old){

        $sql ="";
        $sql.="select l.pk";

        $sql.="  from leads l";
        $sql.=" where l.pk_old in(".$pk_old.",0)";
        $sql.=" and l.contas_pk = ".$this->arrToken['contas_pk'];
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatusSemInteresse($pk){

        $sql ="";
        $sql.="select count('0')registro";
        $sql.="  from leads l";
        $sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.=" where l.pk = $pk ";
        $sql.="       and tio.ds_tipo_ocorrencia like '%Sem Interesse%' ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatusContactado($pk){

        $sql ="";
        $sql.="select count('0')registro";
        $sql.="  from leads l";
        $sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.="     left join processos p on p.leads_pk = l.pk";
        $sql.=" where l.pk = $pk ";
        $sql.="       and tio.ds_tipo_ocorrencia not like '%Sem Interesse%' ";
        $sql.=" and o.pk is not null";
        $sql.=" and p.pk is null";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatusNaoContactado($pk){

        $sql ="";
        $sql.="select count('0')registro";
        $sql.="  from leads l";
        $sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     left join processos p on p.leads_pk = l.pk";
        $sql.=" where l.pk = $pk ";
        $sql.=" and o.pk is  null";
        $sql.=" and p.pk is null";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatus($pk){

        $sql ="";
        $sql.=" SELECT count('0')registro,";
        $sql.="        case prs.classificacao_processo_pk when 1 then 'Lead 25%' when 2 then 'Lead 50%' when 3 then 'Lead 75%' when 4 then 'Cliente' when 5 then 'Lead 80%' when 6 then 'Lead 90%' end ds_classificacao_processo ";
        $sql.="   FROM leads l ";
        $sql.="  inner join processos prs on prs.leads_pk = l.pk";
        $sql.="  WHERE prs.dt_cancelamento IS NULL ";
        $sql.="    and prs.classificacao_processo_pk is not null";
        $sql.="    and l.pk = ".$pk;
        $sql.="  order by prs.dt_cadastro desc limit 1";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorOcorrenciaLeadPk($leads_pk){

        $sql ="";
        $sql.="select o.pk";

        $sql.="  from ocorrencias o";
        $sql.=" where o.leads_pk = $leads_pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPkSubMenu($pk){

        $sql ="";
        $sql.="select l.pk ";
        $sql.="       ,l.tipo_pessoa_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,l.ciclo_uso";
        $sql.="       ,l.ds_log";
        $sql.="       ,p.ds_polo";

        $sql.="  from leads l ";
        $sql.="     inner join polos p on l.polos_pk = p.pk";
        $sql.=" where l.pk = $pk ";
        $sql.=" and l.contas_pk =". $this->arrToken['contas_pk'];
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarLeadsRes($token,$pk,$ds_lead,$polos_pk,$ds_razao_social,$tipo_pessoa_pk,$mailing_pk,$ds_processo_pk,$processo_default_pk,$ic_cliente,$responsavel_pk,$grupos_pk,$equipes_pk,$status_processo_pk,$operador_pk,$qtde_linhas_ini,$qtde_linhas_fim,$dt_ativacao_ini,$dt_ativacao_fim,$dt_vencimento_ini,$dt_vencimento_fim,$classificacao_operador_pk,$ds_cpf_cnpj,$tempo_contrato_pk,$ciclo_uso,$ds_log,$ds_cidade,$dt_transf_ini,$dt_transf_fim,$dt_cadastro_ini,$dt_cadastro_fim,$qtde_ult_oc){
        $sql = "";
        $sql.= "SELECT l.pk";
        $sql.= "        , SUBSTR(l.ds_lead,1, 25)ds_lead";
        $sql.= "        , ANY_VALUE(p.classificacao_processo_pk) classificacao_processo_pk";
        $sql.= "        ,ANY_VALUE(u.ds_usuario) ds_usuario";
        $sql.= "        ,ANY_VALUE(lo.ds_qtde_voz) ds_qtde_voz";
        $sql.= "        ,ANY_VALUE(lo.tempo_contrato_pk) tempo_contrato_pk";
        $sql.= "        ,DATEDIFF(sysdate(), max(l.dt_ult_ocorrencia)) qtde_dias";
        $sql.= "        ,date_format(max(l.dt_ult_ocorrencia), '%d/%m/%Y %H:%i:%s') ultcontato";
        $sql.= "        ,ANY_VALUE(lr.usuarios_pk) responsavel_pk";
        $sql.= "        ,ANY_VALUE(tio_ult.ds_tipo_ocorrencia) ds_status_oc";
        $sql.= "    FROM leads l";
        $sql.= "          Left JOIN leads_responsaveis lr ON lr.leads_pk = l.pk";
        $sql.= "          Left JOIN usuarios u ON lr.usuarios_pk = u.pk";
        $sql.= "          Left JOIN leads_operadoras lo ON lo.leads_pk = l.pk";
        $sql.= "          LEFT JOIN tipos_ocorrencias tio_ult ON tio_ult.pk = l.ocorrencias_ult_pk";
        if(!empty($equipes_pk)){
            $sql.= "          LEFT JOIN equipes_usuarios eu ON lr.usuarios_pk = eu.usuarios_pk";
        }
        $filtrarLeadOperadora = !empty($operador_pk)
            || !empty($tempo_contrato_pk)
            || !empty($classificacao_operador_pk)
            || !empty($qtde_linhas_ini)
            || !empty($qtde_linhas_fim)
            || !empty($dt_ativacao_ini)
            || !empty($dt_vencimento_ini);
        //if(!empty($status_processo_pk)){
            $sql.="  left join processos p  on l.pk = p.leads_pk ";
        //}        
        if($status_processo_pk!=''){
            $sql.= "          Inner JOIN ocorrencias o ON o.leads_pk = l.pk";
            $sql.= "          LEFT JOIN tipos_ocorrencias tio ON tio.pk = o.tipos_ocorrencias_pk";
        }
        $sql.= "     WHERE 1 = 1";   
        if($ds_lead != ""){
            $sql.=" and l.ds_lead like '%".$ds_lead."%' ";
        }
        if($ds_razao_social != ""){
            $sql.=" and l.ds_razao_social like '%".$ds_razao_social."%' ";
        }
        if($ds_cpf_cnpj != ""){
            $ds_cpf_cnpj_numerico = preg_replace('/\D+/', '', $ds_cpf_cnpj);
            $sql.=" and REPLACE(REPLACE(REPLACE(REPLACE(l.ds_cpf_cnpj, '.', ''), '-', ''), '/', ''), ' ', '') like '%".$ds_cpf_cnpj_numerico."%' ";
        }
        if($polos_pk != ""){
            $sql.=" and l.polos_pk = ".$polos_pk;
        }
        if($pk != ""){
            $sql.=" and l.pk = ".$pk;
        }        
        if($equipes_pk != ""){
                $sql.=" and eu.equipes_pk= ".$equipes_pk;
        }
        if($operador_pk!= ""){
                $sql.=" and lo.operador_pk= ".$operador_pk;
        }
        if($tipo_pessoa_pk != ""){
            $sql.=" and l.tipo_pessoa_pk = '".$tipo_pessoa_pk."'";
        }
        if($mailing_pk != ""){
            $sql.=" and l.mailing_pk = ".$mailing_pk;
        }
            if($status_processo_pk != ""){
                if($status_processo_pk<=4){
                    $sql.=" and p.classificacao_processo_pk = ".$status_processo_pk;
                }
                //classificação processo 80%
                if($status_processo_pk==8){
                    //80%
                    $sql.=" and p.classificacao_processo_pk = 5";
                }
                //classificação processo 90%
                if($status_processo_pk==9){
                    //90%
                    $sql.=" and p.classificacao_processo_pk = 6";
                }
                if($status_processo_pk==5){
                    $sql.=" and o.pk is not null";
                    $sql.=" and p.pk is null";
                }
                else if($status_processo_pk==6){
                    $sql.=" and o.pk is null";
                    $sql.=" and p.pk is null";
                }  
                else if($status_processo_pk==7){
                    $sql.=" and tio.ds_tipo_ocorrencia like '%Sem Interesse%'";
                    $sql.=" AND (SELECT COUNT(0) FROM processos pr WHERE pr.dt_cancelamento IS NULL and pr.leads_pk = l.pk) >= 1 ";
                }  
            }
        
        if($ic_cliente != ""){
            $sql.=" and l.ic_cliente = ".$ic_cliente;
        }
        if(!permissao("lead_grupo_listar_todos", "cons", $token)){
            $sql.=" and lr.grupos_pk not in (1)";
        }
        if(permissao("grupo_consultor_listar", "cons", $token)){
            $sql.=" and lr.grupos_pk =".$this->arrToken['grupos_pk'];
        }
        if($responsavel_pk != ""){
            $sql.=" and lr.usuarios_pk = ".$responsavel_pk;
        }
        if($grupos_pk!= ""){
            $sql.=" and lr.grupos_pk= ".$grupos_pk;
        }
        if($operador_pk!= ""){
            $sql.=" and lo.operador_pk= ".$operador_pk;
        }
        if($tempo_contrato_pk!= ""){
            $sql.=" and lo.tempo_contrato_pk = ".$tempo_contrato_pk;
        }
        if($classificacao_operador_pk!= ""){
            $sql.=" and lo.classificacao_pk= ".$classificacao_operador_pk;
        }
        if($qtde_linhas_ini != "" && $qtde_linhas_fim != ""){
            $sql.=" and CAST(lo.ds_qtde_voz AS UNSIGNED) between ".intval($qtde_linhas_ini)." and ".intval($qtde_linhas_fim);
        }
        else if($qtde_linhas_ini != ""){
            $sql.=" and CAST(lo.ds_qtde_voz AS UNSIGNED) >= ".intval($qtde_linhas_ini);
        }
        else if($qtde_linhas_fim != ""){
            $sql.=" and CAST(lo.ds_qtde_voz AS UNSIGNED) <= ".intval($qtde_linhas_fim);
        }
        if($ds_cidade!= ""){
            $sql.=" and e.ds_cidade= '".$ds_cidade."'";
        }
        if($dt_vencimento_ini!= ""){
            $sql.=" and lo.dt_vencimento between '".DataYMD($dt_vencimento_ini)." 00:00:00' and '".DataYMD($dt_vencimento_fim)." 23:59:59'";
        }
        if($dt_ativacao_ini!= ""){
            $sql.=" and lo.dt_ativacao between '".DataYMD($dt_ativacao_ini)." 00:00:00' and '".DataYMD($dt_ativacao_fim)." 23:59:59'";
        }
        if($pk != ""){
            $sql.=" and l.pk = ".$pk;
        }
       /* if($dt_transf_ini!=""){
            $sql.=" and o.dt_cadastro between '". DataYMD($dt_transf_ini)." 00:00:00' and '". DataYMD($dt_transf_fim)." 23:59:59'";
            $sql.=" and tio.ds_tipo_ocorrencia like '%Transfer%'";

        }*/
        if($dt_cadastro_ini!= ""){
            $sql.=" and l.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
        $sql.=" and l.contas_pk=".$this->arrToken['contas_pk'];
        if(!empty($qtde_ult_oc)){
           // $sql.= "    and o.pk in (Select ocorrencias.pk from ocorrencias where ocorrencias.dt_cadastro <= date_add(sysdate(), interval -".$qtde_ult_oc." day))";
        } 

        $sql.= "     GROUP BY l.pk";
        if(!empty($qtde_ult_oc)){
        $sql.=" having  date_add(sysdate(), interval -".$qtde_ult_oc." day) >= max(l.dt_ult_ocorrencia) ";
        }
        if(!empty($qtde_ult_oc)){
            $sql.= "     ORDER BY l.dt_ult_ocorrencia ASC";
        }else{
            $sql.= "     ORDER BY l.ds_lead ASC";
        }
        
        $sql.="  limit 140000";
 
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarLeadsResAntiga($token,$pk,$ds_lead,$polos_pk,$ds_razao_social,$tipo_pessoa_pk,$mailing_pk,$ds_processo_pk,$processo_default_pk,$ic_cliente,$responsavel_pk,$grupos_pk,$equipes_pk,$status_processo_pk,$operador_pk,$qtde_linhas_ini,$qtde_linhas_fim,$dt_ativacao_ini,$dt_ativacao_fim,$dt_vencimento_ini,$dt_vencimento_fim,$classificacao_operador_pk,$ds_cpf_cnpj,$tempo_contrato_pk,$ciclo_uso,$ds_log,$ds_cidade,$dt_transf_ini,$dt_transf_fim,$dt_cadastro_ini,$dt_cadastro_fim,$qtde_ult_oc){
        $sql = "";
        $sql.= "SELECT l.pk";
        $sql.= "        , SUBSTR(l.ds_lead,1, 25)ds_lead";
        $sql.= "        ,MAX(p.classificacao_processo_pk) classificacao_processo_pk";
        $sql.= "        ,MAX(u.ds_usuario) ds_usuario";        
        $sql.= "        ,DATEDIFF(sysdate(), max(o.dt_cadastro)) qtde_dias";
        $sql.= "        ,date_format(max(o.dt_cadastro), '%d/%m/%Y %H:%i:%s') ultcontato";
        $sql.= "        ,MAX(lr.usuarios_pk) responsavel_pk";
        $sql.= "    FROM leads l";
        $sql.= "          Left JOIN leads_responsaveis lr ON lr.leads_pk = l.pk";
        $sql.= "          Left JOIN usuarios u ON lr.usuarios_pk = u.pk";
        if(!empty($equipes_pk)){
            $sql.= "          LEFT JOIN equipes_usuarios eu ON lr.usuarios_pk = eu.usuarios_pk";
        }
        $filtrarLeadOperadora = !empty($operador_pk)
            || !empty($tempo_contrato_pk)
            || !empty($classificacao_operador_pk)
            || !empty($qtde_linhas_ini)
            || !empty($qtde_linhas_fim)
            || !empty($dt_ativacao_ini)
            || !empty($dt_vencimento_ini);
        if($filtrarLeadOperadora){
            $sql.= "          LEFT JOIN leads_operadoras lo ON lo.leads_pk = l.pk";
        }
        //if(!empty($status_processo_pk)){
            $sql.="  left join processos p  on l.pk = p.leads_pk ";
        //}        
        
        $sql.= "          LEFT JOIN ocorrencias o ON o.leads_pk = l.pk";
        $sql.= "          LEFT JOIN tipos_ocorrencias tio ON tio.pk = o.tipos_ocorrencias_pk";
        $sql.= "     WHERE 1 = 1";   
        if($ds_lead != ""){
            $sql.=" and l.ds_lead like '%".$ds_lead."%' ";
        }
        if($ds_razao_social != ""){
            $sql.=" and l.ds_razao_social like '%".$ds_razao_social."%' ";
        }
        if($ds_cpf_cnpj != ""){
            $ds_cpf_cnpj_numerico = preg_replace('/\D+/', '', $ds_cpf_cnpj);
            $sql.=" and REPLACE(REPLACE(REPLACE(REPLACE(l.ds_cpf_cnpj, '.', ''), '-', ''), '/', ''), ' ', '') like '%".$ds_cpf_cnpj_numerico."%' ";
        }
        if($polos_pk != ""){
            $sql.=" and l.polos_pk = ".$polos_pk;
        }
        if($pk != ""){
            $sql.=" and l.pk = ".$pk;
        }        
        if($equipes_pk != ""){
                $sql.=" and eu.equipes_pk= ".$equipes_pk;
        }
        if($operador_pk!= ""){
                $sql.=" and lo.operador_pk= ".$operador_pk;
        }
        if($tipo_pessoa_pk != ""){
            $sql.=" and l.tipo_pessoa_pk = '".$tipo_pessoa_pk."'";
        }
        if($mailing_pk != ""){
            $sql.=" and l.mailing_pk = ".$mailing_pk;
        }
            if($status_processo_pk != ""){
                if($status_processo_pk<=4){
                    $sql.=" and p.classificacao_processo_pk = ".$status_processo_pk;
                }
                //classificação processo 80%
                if($status_processo_pk==8){
                    //80%
                    $sql.=" and p.classificacao_processo_pk = 5";
                }
                //classificação processo 90%
                if($status_processo_pk==9){
                    //90%
                    $sql.=" and p.classificacao_processo_pk = 6";
                }
                if($status_processo_pk==5){
                    $sql.=" and o.pk is not null";
                    $sql.=" and p.pk is null";
                }
                else if($status_processo_pk==6){
                    $sql.=" and o.pk is null";
                    $sql.=" and p.pk is null";
                }  
                else if($status_processo_pk==7){
                    $sql.=" and tio.ds_tipo_ocorrencia like '%Sem Interesse%'";
                    $sql.=" AND (SELECT COUNT(0) FROM processos pr WHERE pr.dt_cancelamento IS NULL and pr.leads_pk = l.pk) >= 1 ";
                }  
            }
        
        if($ic_cliente != ""){
            $sql.=" and l.ic_cliente = ".$ic_cliente;
        }
        if(!permissao("lead_grupo_listar_todos", "cons", $token)){
            $sql.=" and lr.grupos_pk not in (1)";
        }
        if(permissao("grupo_consultor_listar", "cons", $token)){
            $sql.=" and lr.grupos_pk =".$this->arrToken['grupos_pk'];
        }
        if($responsavel_pk != ""){
            $sql.=" and lr.usuarios_pk = ".$responsavel_pk;
        }
        if($grupos_pk!= ""){
            $sql.=" and lr.grupos_pk= ".$grupos_pk;
        }
        if($operador_pk!= ""){
            $sql.=" and lo.operador_pk= ".$operador_pk;
        }
        if($tempo_contrato_pk!= ""){
            $sql.=" and lo.tempo_contrato_pk = ".$tempo_contrato_pk;
        }
        if($classificacao_operador_pk!= ""){
            $sql.=" and lo.classificacao_pk= ".$classificacao_operador_pk;
        }
        if($qtde_linhas_ini != "" && $qtde_linhas_fim != ""){
            $sql.=" and CAST(lo.ds_qtde_voz AS UNSIGNED) between ".intval($qtde_linhas_ini)." and ".intval($qtde_linhas_fim);
        }
        else if($qtde_linhas_ini != ""){
            $sql.=" and CAST(lo.ds_qtde_voz AS UNSIGNED) >= ".intval($qtde_linhas_ini);
        }
        else if($qtde_linhas_fim != ""){
            $sql.=" and CAST(lo.ds_qtde_voz AS UNSIGNED) <= ".intval($qtde_linhas_fim);
        }
        if($ds_cidade!= ""){
            $sql.=" and e.ds_cidade= '".$ds_cidade."'";
        }
        if($dt_vencimento_ini!= ""){
            $sql.=" and lo.dt_vencimento between '".DataYMD($dt_vencimento_ini)." 00:00:00' and '".DataYMD($dt_vencimento_fim)." 23:59:59'";
        }
        if($dt_ativacao_ini!= ""){
            $sql.=" and lo.dt_ativacao between '".DataYMD($dt_ativacao_ini)." 00:00:00' and '".DataYMD($dt_ativacao_fim)." 23:59:59'";
        }
        if($pk != ""){
            $sql.=" and l.pk = ".$pk;
        }
        if($dt_transf_ini!=""){
            $sql.=" and o.dt_cadastro between '". DataYMD($dt_transf_ini)." 00:00:00' and '". DataYMD($dt_transf_fim)." 23:59:59'";
            $sql.=" and tio.ds_tipo_ocorrencia like '%Transfer%'";

        }
        if($dt_cadastro_ini!= ""){
            $sql.=" and l.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
        $sql.=" and l.contas_pk=".$this->arrToken['contas_pk'];
        if(!empty($qtde_ult_oc)){
           // $sql.= "    and o.pk in (Select ocorrencias.pk from ocorrencias where ocorrencias.dt_cadastro <= date_add(sysdate(), interval -".$qtde_ult_oc." day))";
        } 

        $sql.= "     GROUP BY l.pk";
        if(!empty($qtde_ult_oc)){
        $sql.=" having  date_add(sysdate(), interval -".$qtde_ult_oc." day) >= max(o.dt_cadastro) ";
        }
    if(!empty($qtde_ult_oc)){
                $sql.= "     ORDER BY max(l.dt_ult_ocorrencia) ASC";
                    }else{
                      $sql.= "     ORDER BY l.ds_lead ASC";
                   }

        
        $sql.="  limit 140000";
        // echo $sql;
        // exit;
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listar_por_tipo_pessoa_pk($token,$pk,$ds_lead,$polos_pk,$ds_razao_social,$tipo_pessoa_pk,$mailing_pk,$ds_processo_pk,$processo_default_pk,$ic_cliente,$responsavel_pk,$grupos_pk,$equipes_pk,$status_processo_pk,$operador_pk,$qtde_linhas_ini,$qtde_linhas_fim,$dt_ativacao_ini,$dt_ativacao_fim,$dt_vencimento_ini,$dt_vencimento_fim,$classificacao_operador_pk,$ds_cpf_cnpj,$tempo_contrato_pk,$ciclo_uso,$ds_log,$ds_cidade,$dt_transf_ini,$dt_transf_fim,$dt_cadastro_ini,$dt_cadastro_fim,$qtde_ult_oc){
        
        $ds_cnpj = formatCnpjCpf($ds_cpf_cnpj); 
        
        if($ds_cnpj!="" || $ds_lead!="" || $ds_razao_social!=""){
            
            $sql ="";
            $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
            $sql.="       ,l.tipo_pessoa_pk ";
            $sql.="       ,l.ds_lead ";
            $sql.="       ,l.ds_razao_social ";
            $sql.="       ,l.ds_cpf_cnpj ";
            $sql.="       ,l.ds_ie ";
            $sql.="       ,l.ds_rg ";
            $sql.="       ,l.ds_cnae ";
            $sql.="       ,case l.ic_cliente when 1 then 'Sim' when 2 then 'Não' end ic_cliente";
            $sql.="       ,l.ds_obs ";
            $sql.="       ,l.ds_site ";
            $sql.="       ,l.mailing_pk ";
            $sql.="       ,l.contas_pk ";
            $sql.="       ,l.polos_pk ";
            $sql.="       ,l.ciclo_uso";
            $sql.="       ,l.ds_log";
            $sql.="       ,DATEDIFF(sysdate(),max(o.dt_cadastro)) qtde_dias";
            $sql.="       ,group_concat(DISTINCT lr.usuarios_pk)responsavel_pk";
            /*$sql.="       ,e.ds_endereco ";
            $sql.="       ,e.ds_bairro ";
            $sql.="       ,e.ds_cidade ";*/

            $sql.="  from leads l";
            //$sql.="  left join processos p  on l.pk = p.leads_pk ";
           // $sql.="  left join processos_default pd  on p.processos_default_pk = pd.pk";
            $sql.="  left join leads_responsaveis lr  on lr.leads_pk = l.pk";
            $sql.="  left join equipes_usuarios eu  on lr.usuarios_pk = eu.usuarios_pk";
            if($operador_pk!=""){
                $sql.="  left join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($tempo_contrato_pk!=""){
                $sql.="  inner join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($classificacao_operador_pk!=""){
                $sql.="  left join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($qtde_linhas_ini!=""){
                $sql.="  left join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($dt_vencimento_ini!=""){
                $sql.="  left join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($dt_ativacao_ini!=""){
                $sql.="  left join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            $sql.="  left join enderecos e  on e.leads_pk = l.pk";
            //$sql.="  left join ocorrencias o  on o.leads_pk = l.pk";
            $sql.="  left join tipos_ocorrencias tio  on tio.pk = o.tipos_ocorrencias_pk";

            $sql.=" where 1=1 ";
            if($ds_lead != ""){
                $ds_lead_like = "%".$ds_lead."%";
                $sql.=" and l.ds_lead like ".$this->db->mysqlnull($ds_lead_like)." ";
            }
            if($ds_razao_social != ""){
                $ds_razao_like = "%".$ds_razao_social."%";
                $sql.=" and l.ds_razao_social like ".$this->db->mysqlnull($ds_razao_like)." ";
            }
            if($ds_cpf_cnpj != ""){
                $ds_cnpj_like = "%".$ds_cnpj."%";
                $sql.=" and l.ds_cpf_cnpj like ".$this->db->mysqlnull($ds_cnpj_like)." ";
            }
            if($polos_pk != ""){
                $sql.=" and l.polos_pk = ".$polos_pk;
            }
            if($pk != ""){
                $sql.=" and l.pk = ".$pk;
            }
            if($equipes_pk != ""){
                $sql.=" and eu.equipes_pk= ".$equipes_pk;
            }
            if($tipo_pessoa_pk != ""){
                $sql.=" and l.tipo_pessoa_pk = ".$this->db->mysqlnull($tipo_pessoa_pk);
            }
            if($mailing_pk != ""){
                $sql.=" and l.mailing_pk = ".$mailing_pk;
            }
            if($ciclo_uso != ""){
                $sql.=" and l.ciclo_uso = ".$this->db->mysqlnull($ciclo_uso);
            }
            if($ds_log != ""){
                $sql.=" and l.ds_log = ".$this->db->mysqlnull($ds_log);
            }
            if($ds_processo_pk != ""){
                $sql.=" and p.pk = ".$ds_processo_pk;
            }
            /*if($status_processo_pk != ""){
                if($status_processo_pk<=4){
                    $sql.=" and p.classificacao_processo_pk = ".$status_processo_pk;
                }
                //classificação processo 80%
                if($status_processo_pk==8){
                    //80%
                    $sql.=" and p.classificacao_processo_pk = 5";
                }
                //classificação processo 90%
                if($status_processo_pk==9){
                    //90%
                    $sql.=" and p.classificacao_processo_pk = 6";
                }
                if($status_processo_pk==5){
                    $sql.=" and o.pk is not null";
                    $sql.=" and p.pk is null";
                }
                else if($status_processo_pk==6){
                    $sql.=" and o.pk is null";
                    $sql.=" and p.pk is null";
                }  
                else if($status_processo_pk==7){
                    $sql.=" and tio.ds_tipo_ocorrencia like '%Sem Interesse%'";
                    $sql.=" AND (SELECT COUNT(0) FROM processos pr WHERE pr.dt_cancelamento IS NULL and pr.leads_pk = l.pk) >= 1 ";
                }  
            }
            if($processo_default_pk != ""){
                $sql.=" and pd.pk = ".$processo_default_pk;
            }*/
            if($ic_cliente != ""){
                $sql.=" and l.ic_cliente = ".$ic_cliente;
            }
            /*if(!permissao("lead_grupo_listar_todos", "cons", $token)){
                $sql.=" and lr.grupos_pk not in (1)";
            }*/
            /*if(permissao("grupo_consultor_listar", "cons", $token)){
                $sql.=" and lr.grupos_pk =".$this->arrToken['grupos_pk'];
            }*/
            if($operador_pk!= ""){
                $sql.=" and lo.operador_pk= ".$operador_pk;
            }
            if($tempo_contrato_pk!= ""){
                $sql.=" and lo.tempo_contrato_pk = ".$tempo_contrato_pk;
            }
            if($classificacao_operador_pk!= ""){
                $sql.=" and lo.classificacao_pk= ".$classificacao_operador_pk;
            }
            if($qtde_linhas_ini!= ""){
                $sql.=" and lo.ds_qtde_voz between ".$this->db->mysqlnull($qtde_linhas_ini)." and ".$this->db->mysqlnull($qtde_linhas_fim);
            }
            if($ds_cidade!= ""){
                $sql.=" and e.ds_cidade= ".$this->db->mysqlnull($ds_cidade);
            }
            if($dt_vencimento_ini!= ""){
                $sql.=" and lo.dt_vencimento between '".DataYMD($dt_vencimento_ini)." 00:00:00' and '".DataYMD($dt_vencimento_fim)." 23:59:59'";
            }
            if($dt_ativacao_ini!= ""){
                $sql.=" and lo.dt_ativacao between '".DataYMD($dt_ativacao_ini)." 00:00:00' and '".DataYMD($dt_ativacao_fim)." 23:59:59'";
            }
            if($dt_cadastro_ini!= ""){
                $sql.=" and l.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
            }
            $sql.=" and l.contas_pk=".$this->arrToken['contas_pk'];
            $sql.=" and l.polos_pk=".$this->arrToken['polos_pk'];
            $sql.=" group by l.pk";    
               if($qtde_ult_oc!=''){
                $sql.="  having DATEDIFF(sysdate(),max(o.dt_cadastro)) >=".$qtde_ult_oc;
            }
            $sql.=" order by l.ds_lead asc ";
            $sql.="  limit 140000";
          
        }else{
 
            $sql ="";
            $sql.="select l.pk";
            $sql.="       ,l.ds_lead";
            $sql.="       ,l.ciclo_uso";
            $sql.="       ,l.ds_log";
            $sql.="       ,case l.ic_cliente when 1 then 'Sim' when 2 then 'Não' end ic_cliente";
            
            $sql.="       ,lr.usuarios_pk responsavel_pk";
            $sql.="       ,DATEDIFF(sysdate(),max(o.dt_cadastro)) qtde_dias";
            /*$sql.="       ,e.ds_endereco ";
            $sql.="       ,e.ds_bairro ";
            $sql.="       ,e.ds_cidade ";*/

            $sql.="  from leads l";
            /*if($ds_processo_pk != ""){
                $sql.="  left join processos p  on l.pk = p.leads_pk ";
                if($processo_default_pk != ""){
                    
                    $sql.="  left join processos_default pd  on p.processos_default_pk = pd.pk";

                }
            }
            else if($status_processo_pk != ""){
                $sql.="  left join processos p  on l.pk = p.leads_pk ";
                if($processo_default_pk != ""){
                    
                    $sql.="  left join processos_default pd  on p.processos_default_pk = pd.pk";

                }
            }
            
            if($processo_default_pk != ""){
                 $sql.="  left join processos p  on l.pk = p.leads_pk ";
                if($ds_processo_pk == ""){
                    $sql.="  left join processos_default pd  on p.processos_default_pk = pd.pk";
                }
                else if($status_processo_pk==""){
                    $sql.="  left join processos_default pd  on p.processos_default_pk = pd.pk";
                }
                
            }*/
            $sql.="  left join leads_responsaveis lr  on lr.leads_pk = l.pk";
            $sql.="  left join equipes_usuarios eu  on lr.usuarios_pk = eu.usuarios_pk";
            
            if($operador_pk!=""){
                $sql.="  inner join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($tempo_contrato_pk!=""){
                $sql.="  inner join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($classificacao_operador_pk!=""){
                $sql.="  inner join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($qtde_linhas_ini!=""){
                $sql.="  inner join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($dt_vencimento_ini!=""){
                $sql.="  inner join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            else if($dt_ativacao_ini!=""){
                $sql.="  inner join leads_operadoras lo  on lo.leads_pk = l.pk";
            }
            if($ds_cidade!= ""){
                $sql.="  inner join enderecos e  on e.leads_pk = l.pk";
            }
            if($status_processo_pk==5){
                $sql.="  left join ocorrencias o  on o.leads_pk = l.pk";
                $sql.="  left join tipos_ocorrencias tio  on tio.pk = o.tipos_ocorrencias_pk";
            }
            else if($status_processo_pk==6){
                $sql.="  left join ocorrencias o  on o.leads_pk = l.pk";
                $sql.="  left join tipos_ocorrencias tio  on tio.pk = o.tipos_ocorrencias_pk";
            }  
            else if($status_processo_pk==7){
                $sql.="  left join ocorrencias o  on o.leads_pk = l.pk";
                $sql.="  left join tipos_ocorrencias tio  on tio.pk = o.tipos_ocorrencias_pk";
            }
            else if($dt_transf_ini!=""){
                $sql.="  left join ocorrencias o  on o.leads_pk = l.pk";
                $sql.="  left join tipos_ocorrencias tio  on tio.pk = o.tipos_ocorrencias_pk";
            }
            $sql.=" where 1=1 ";
            if($ds_lead != ""){
                $sql.=" and l.ds_lead like '%".$ds_lead."%' ";
            }
            if($ds_razao_social != ""){
                $sql.=" and l.ds_razao_social like '%".$ds_razao_social."%' ";
            }
            if($ds_cpf_cnpj != ""){
                $ds_cpf_cnpj_numerico = preg_replace('/\D+/', '', $ds_cpf_cnpj);
                $sql.=" and REPLACE(REPLACE(REPLACE(REPLACE(l.ds_cpf_cnpj, '.', ''), '-', ''), '/', ''), ' ', '') like '%".$ds_cpf_cnpj_numerico."%' ";
            }
            if($polos_pk != ""){
                $sql.=" and l.polos_pk = ".$polos_pk;
            }
            if($equipes_pk != ""){
                $sql.=" and eu.equipes_pk = ".$equipes_pk;
            }
            if($tipo_pessoa_pk != ""){
                $sql.=" and l.tipo_pessoa_pk = '".$tipo_pessoa_pk."'";
            }
            if($ciclo_uso != ""){
                $sql.=" and l.ciclo_uso = '".$ciclo_uso."'";
            }
            if($ds_log != ""){
                $sql.=" and l.ds_log = '".$ds_log."'";
            }
            if($mailing_pk != ""){
                $sql.=" and l.mailing_pk = ".$mailing_pk;
            }
            if($ds_processo_pk != ""){
                $sql.=" and p.pk = ".$ds_processo_pk;
            }
            if($status_processo_pk != ""){
                if($status_processo_pk<=4){
                    $sql.=" and p.classificacao_processo_pk = ".$status_processo_pk;
                }
                //classificação processo 80%
                if($status_processo_pk==8){
                    //80%
                    $sql.=" and p.classificacao_processo_pk = 5";
                }
                //classificação processo 90%
                if($status_processo_pk==9){
                    //90%
                    $sql.=" and p.classificacao_processo_pk = 6";
                }
                if($status_processo_pk==5){
                    $sql.=" and o.pk is not null";
                    $sql.=" and p.pk is null";
                }
                else if($status_processo_pk==6){
                    $sql.=" and o.pk is null";
                    $sql.=" and p.pk is null";
                }  
                else if($status_processo_pk==7){
                    $sql.=" and tio.ds_tipo_ocorrencia like '%Sem Interesse%'";
                    $sql.=" AND (SELECT COUNT(0) FROM processos pr WHERE pr.dt_cancelamento IS NULL and pr.leads_pk = l.pk) >= 1 ";
                }  
            }
            if($processo_default_pk != ""){
                $sql.=" and pd.pk = ".$processo_default_pk;
            }
            if($ic_cliente != ""){
                $sql.=" and l.ic_cliente = ".$ic_cliente;
            }
            if(!permissao("lead_grupo_listar_todos", "cons", $token)){
                $sql.=" and lr.grupos_pk not in (1)";
            }
            if(permissao("grupo_consultor_listar", "cons", $token)){
                $sql.=" and lr.usuarios_pk =".$this->arrToken['usuarios_pk'];
            }
            if($responsavel_pk != ""){
                $sql.=" and lr.usuarios_pk = ".$responsavel_pk;
            }
            if($grupos_pk!= ""){
                $sql.=" and lr.grupos_pk= ".$grupos_pk;
            }
            if($operador_pk!= ""){
                $sql.=" and lo.operador_pk= ".$operador_pk;
            }
            if($tempo_contrato_pk!= ""){
                $sql.=" and lo.tempo_contrato_pk = ".$tempo_contrato_pk;
            }
            if($classificacao_operador_pk!= ""){
                $sql.=" and lo.classificacao_pk= ".$classificacao_operador_pk;
            }
            if($qtde_linhas_ini!= ""){
                $sql.=" and lo.ds_qtde_voz between '".$qtde_linhas_ini."' and '".$qtde_linhas_fim."'";
            }
            if($ds_cidade!= ""){
                $sql.=" and e.ds_cidade= '".$ds_cidade."'";
            }
            if($dt_vencimento_ini!= ""){
                $sql.=" and lo.dt_vencimento between '".DataYMD($dt_vencimento_ini)." 00:00:00' and '".DataYMD($dt_vencimento_fim)." 23:59:59'";
            }
            if($dt_ativacao_ini!= ""){
                $sql.=" and lo.dt_ativacao between '".DataYMD($dt_ativacao_ini)." 00:00:00' and '".DataYMD($dt_ativacao_fim)." 23:59:59'";
            }
            if($pk != ""){
                $sql.=" and l.pk = ".$pk;
            }
            if($dt_transf_ini!=""){
                $sql.=" and o.dt_cadastro between '". DataYMD($dt_transf_ini)." 00:00:00' and '". DataYMD($dt_transf_fim)." 23:59:59'";
                $sql.=" and tio.ds_tipo_ocorrencia like '%Transfer%'";
                        
            }
            if($dt_cadastro_ini!= ""){
                $sql.=" and l.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
            }
            $sql.=" and l.contas_pk=".$this->arrToken['contas_pk'];
            //$sql.=" and l.polos_pk=".$this->arrToken['polos_pk'];
            $sql.=" and l.ic_cliente is not null ";
            $sql.=" and l.pk  not in(0)";
            $sql.=" group by l.pk";    
            
            if($qtde_ult_oc!=''){
                $sql.="  having DATEDIFF(sysdate(),max(o.dt_cadastro)) >=".$qtde_ult_oc;
            }
            
            
            $sql.=" order by l.ds_lead asc ";
            $sql.="  limit 140000";

            
            
        }
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarCarteiraLead($token,$responsavel_pk,$status_processo_pk){
        
        $sql ="";
            $sql.="select count('0')total_leads";
            $sql.="  from leads l";
            $sql.="  left join processos p  on l.pk = p.leads_pk ";
            $sql.="  left join processos_default pd  on p.processos_default_pk = pd.pk";
            $sql.="  left join leads_responsaveis lr  on lr.leads_pk = l.pk";
            $sql.="  left join equipes_usuarios eu  on lr.usuarios_pk = eu.usuarios_pk";
            
            if($status_processo_pk==5){
                $sql.="  left join ocorrencias o  on o.leads_pk = l.pk";
                $sql.="  left join tipos_ocorrencias tio  on tio.pk = o.tipos_ocorrencias_pk";
            }
            else if($status_processo_pk==6){
                $sql.="  left join ocorrencias o  on o.leads_pk = l.pk";
                $sql.="  left join tipos_ocorrencias tio  on tio.pk = o.tipos_ocorrencias_pk";
            }  
            else if($status_processo_pk==7){
                $sql.="  left join ocorrencias o  on o.leads_pk = l.pk";
                $sql.="  left join tipos_ocorrencias tio  on tio.pk = o.tipos_ocorrencias_pk";
            }
            $sql.=" where 1=1 ";
            if($status_processo_pk != ""){
                if($status_processo_pk<=4){
                    $sql.=" and p.classificacao_processo_pk = ".$status_processo_pk;
                }
                //classificação processo 80%
                if($status_processo_pk==8){
                    //80%
                    $sql.=" and p.classificacao_processo_pk = 5";
                }
                //classificação processo 90%
                if($status_processo_pk==9){
                    //90%
                    $sql.=" and p.classificacao_processo_pk = 6";
                }
                if($status_processo_pk==5){
                    $sql.=" and o.pk is not null";
                    $sql.=" and p.pk is null";
                }
                else if($status_processo_pk==6){
                    $sql.=" and o.pk is null";
                    $sql.=" and p.pk is null";
                }  
                else if($status_processo_pk==7){
                    $sql.=" and tio.ds_tipo_ocorrencia like '%Sem Interesse%'";
                    $sql.=" AND (SELECT COUNT(0) FROM processos pr WHERE pr.dt_cancelamento IS NULL and pr.leads_pk = l.pk) >= 1 ";
                }  
            }
            if(!permissao("lead_grupo_listar_todos", "cons", $token)){
                $sql.=" and lr.grupos_pk not in (1)";
            }
            if(permissao("grupo_consultor_listar", "cons", $token)){
                $sql.=" and lr.usuarios_pk =".$this->arrToken['usuarios_pk'];
            }
            if($responsavel_pk != ""){
                $sql.=" and lr.usuarios_pk = ".$responsavel_pk;
            }
            $sql.=" and l.contas_pk=".$this->arrToken['contas_pk'];
            //$sql.=" and l.polos_pk=".$this->arrToken['polos_pk'];
            $sql.=" and l.ic_cliente is not null ";
            $sql.=" and l.pk  not in(0)";   
            $sql.=" order by l.ds_lead asc ";
        
        
       
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
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_site ";
        $sql.="       ,mailing_pk ";
        $sql.="       ,contas_pk ";
        $sql.="       ,polos_pk ";
        $sql.="       ,ciclo_uso ";
        $sql.="       ,ds_log ";

        $sql.="  from leads ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_pessoa_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarLeadPesquisa($strPesquisar,$token){   
        if (strlen(intval($strPesquisar)) >= 10) {
            $pesquisar = formatCnpjCpf($strPesquisar);
        }
        else{
             $pesquisar = ($strPesquisar);
        }
       
        
        $query = $this->listarEquipes("");
        
        if(count($query) > 0){
            $ic_supervisor = $query[0]['ic_supervisor'];
            $equipes_pk = $query[0]['equipes_pk'];
        }
                       
        $sql ="";
        $sql.="select l.pk";
        $sql.="       ,ANY_VALUE(l.ds_lead) ds_lead";
        $sql.="       ,ANY_VALUE(l.ciclo_uso) ciclo_uso";
        $sql.="       ,ANY_VALUE(l.ds_log) ds_log";
        $sql.="       ,group_concat(DISTINCT lr.usuarios_pk)responsavel_pk";
        $sql.="       ,GROUP_CONCAT(DISTINCT concat(e.ds_endereco,' - ',e.ds_bairro))ds_endereco";
        $sql.="       ,group_concat(DISTINCT u.ds_usuario)ds_responsavel";
        $sql.="       ,group_concat(DISTINCT case p.classificacao_processo_pk when 1 then '25%' when 2 then '50%' when 3 then '75%' when 4 then 'Cliente' end) ds_classificacao_processo";
        $sql.="  from leads l";
        $sql.="       left join leads_responsaveis lr on lr.leads_pk = l.pk";
        $sql.="       left join usuarios u on u.pk = lr.usuarios_pk";
        
        //if($ic_supervisor==1){
            $sql.="   left join equipes_usuarios eu on lr.usuarios_pk = eu.usuarios_pk";
        //}
        
        $sql.="       left join processos p on p.leads_pk = l.pk";
        $sql.="       left join telefones t on t.leads_pk = l.pk";
        $sql.="       left join enderecos e on e.leads_pk = l.pk";
        $sql.="       left join contatos c on c.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        
        $types = "";
        $params = array();
        if(!empty($pesquisar)){
                $sql.=" and (l.ds_cpf_cnpj like ? ";
                $sql.="     or l.ds_razao_social like ? ";
                $sql.="     or l.ds_lead Like ? ";
                $sql.="     or e.ds_endereco Like ? ";
                $sql.="     or c.ds_contato Like ? ";
                $types .= "sssss";
                $params[] = "%".$pesquisar."%";
                $params[] = "%".$pesquisar."%";
                $params[] = "%".$pesquisar."%";
                $params[] = "%".$pesquisar."%";
                $params[] = "%".$pesquisar."%";

                if(!permissao("lead_listar_todos", "cons", $token)){
                    $sql.="     or u.ds_usuario Like ? ";
                    $types .= "s";
                    $params[] = "%".$pesquisar."%";
                }
                $sql.="     or l.pk = ?) ";
                $types .= "s";
                $params[] = "".$pesquisar."";
        }
        
        if(!permissao("supervisor_listar_equipes", "cons", $token)){
            if($this->arrToken['equipes_pk']!=""){
                $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
            }
        }
        $sql.=" and l.contas_pk = ".$this->arrToken['contas_pk'];
        $sql.=" group by l.pk";
        $sql.=" order by l.pk asc ";
        $sql.="  limit 140000";

        if($types !== ""){
            $query = $this->db->execPreparedQuery($sql, $types, $params);
        } else {
            $query = $this->db->execQuery($sql);
        }
        return $query;

    }
    public function relListarLead($leads_pk,$ds_lead,$polo_pk,$grupo_pk,$responsavel_pk,$equipes_pk,$token){
                       
        $sql ="";
        $sql.="select l.pk";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ciclo_uso";
        $sql.="       ,l.ds_log";
        $sql.="       ,concat(e.ds_endereco,' - ',e.ds_bairro)ds_endereco";
        $sql.="       ,group_concat(DISTINCT u.ds_usuario)ds_responsavel";
        $sql.="       ,group_concat(DISTINCT case p.classificacao_processo_pk when 1 then '25%' when 2 then '50%' when 3 then '75%' when 4 then 'Cliente' end) ds_classificacao_processo";
        $sql.="  from leads l";
        $sql.="       left join leads_responsaveis lr on lr.leads_pk = l.pk";
        $sql.="       left join usuarios u on u.pk = lr.usuarios_pk";
        $sql.="   left join equipes_usuarios eu on lr.usuarios_pk = eu.usuarios_pk";
        $sql.="       left join processos p on p.leads_pk = l.pk";
        $sql.="       left join telefones t on t.leads_pk = l.pk";
        $sql.="       left join enderecos e on e.leads_pk = l.pk";
        $sql.="       left join contatos c on c.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and l.pk=".$leads_pk;
        }
        if($polo_pk!=""){
            $sql.=" and l.polos_pk=".$polo_pk;
        }
        if($grupo_pk!=""){
            $sql.=" and lr.grupo_pk=".$grupo_pk;
        }
        if($responsavel_pk!=""){
            $sql.=" and lr.usuarios_pk=".$responsavel_pk;
        }
        if($ds_lead!=""){
            $sql.=" and l.ds_lead like '%".$ds_lead."%'";
        }
        if($equipes_pk > 0){
            $sql.=" and eu.equipes_pk = ".$equipes_pk;
        }
        $sql.=" and l.contas_pk = ".$this->arrToken['contas_pk'];
        $sql.=" group by l.pk";
        $sql.=" order by l.pk asc ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarCpfCnpj($ds_cpf_cnpj){
        return $this->listarCpfCnpjDuplicado($ds_cpf_cnpj);
    }

    public function listarCpfCnpjDuplicado($ds_cpf_cnpj, $pkIgnorar = ""){
        $ds_cpf_cnpj_numerico = preg_replace('/\D+/', '', $ds_cpf_cnpj);
        if($ds_cpf_cnpj_numerico == ""){
            return array();
        }

        $sql  = "select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql .= "      ,tipo_pessoa_pk ";
        $sql .= "      ,ds_lead ";
        $sql .= "      ,ds_razao_social ";
        $sql .= "      ,ds_cpf_cnpj ";
        $sql .= "      ,ds_ie ";
        $sql .= "      ,ds_rg ";
        $sql .= "      ,ds_cnae ";
        $sql .= "      ,ic_cliente ";
        $sql .= "      ,ds_obs ";
        $sql .= "      ,ds_site ";
        $sql .= "      ,mailing_pk ";
        $sql .= "      ,contas_pk ";
        $sql .= "      ,polos_pk ";
        $sql .= "      ,ciclo_uso ";
        $sql .= "      ,ds_log ";
        $sql .= "  from leads ";
        $sql .= " where REPLACE(REPLACE(REPLACE(REPLACE(ds_cpf_cnpj, '.', ''), '-', ''), '/', ''), ' ', '') = ? ";
        $sql .= "   and contas_pk = ? ";

        $params = array($ds_cpf_cnpj_numerico, intval($this->arrToken['contas_pk']));
        $types = "si";

        if($pkIgnorar !== "" && intval($pkIgnorar) > 0){
            $sql .= " and pk <> ? ";
            $params[] = intval($pkIgnorar);
            $types .= "i";
        }

        $sql .= " order by pk asc ";

        return $this->db->execPreparedQuery($sql, $types, $params);
    }
    public function listarEquipes($ds_cpf_cnpj){
        $sql ="";
        $sql.="select eu.ic_supervisor,eu.equipes_pk";
        $sql.=" from equipes_usuarios eu";
        $sql.=" where 1=1 ";
        $sql.="  and eu.usuarios_pk = ".$this->arrToken['usuarios_pk'];
    

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    public function listarStatusSemInteresseDashboard($usuarios_pk){

        $sql ="";
        $sql.="select count('0')registro";
        $sql.="  from leads l";
        $sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.=" where 1=1";
        $sql.="       and tio.ds_tipo_ocorrencia like '%Sem Interesse%' ";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        //$sql.=" group by lr.usuarios_pk";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatusContactadoDashboard($usuarios_pk){

        $sql ="";
        $sql.="select (l.pk)";
        $sql.="  from leads l";
        $sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     left join processos p on p.leads_pk = l.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.=" where 1=1 ";
        $sql.=" and o.pk is not null";
        $sql.=" and p.pk is null";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        $sql.=" group by l.pk";

        
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatusNaoContactadoDashboard($usuarios_pk){

        $sql ="";
        $sql.="select count(l.pk)registro";
        $sql.="  from leads l";
        $sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.="     inner join processos p on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and o.pk is  null";
        $sql.=" and p.pk is null";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        //$sql.=" group by lr.usuarios_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatus25Dashboard($usuarios_pk){

        $sql ="";
        $sql.="select count(l.pk)registro";
        $sql.="  from leads l";
        //$sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.="     inner join processos p on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and p.classificacao_processo_pk = 1";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        //$sql.=" group by lr.usuarios_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatus50Dashboard($usuarios_pk){

        $sql ="";
        $sql.="select count(l.pk)registro";
        $sql.="  from leads l";
        //$sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.="     inner join processos p on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and p.classificacao_processo_pk = 2";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        //$sql.=" group by lr.usuarios_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatus75Dashboard($usuarios_pk){

        $sql ="";
        $sql.="select count(l.pk)registro";
        $sql.="  from leads l";
        //$sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.="     inner join processos p on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and p.classificacao_processo_pk = 3";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        //$sql.=" group by lr.usuarios_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatus80Dashboard($usuarios_pk){

        $sql ="";
        $sql.="select count(l.pk)registro";
        $sql.="  from leads l";
        //$sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.="     inner join processos p on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and p.classificacao_processo_pk = 5";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        //$sql.=" group by lr.usuarios_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatus90Dashboard($usuarios_pk){

        $sql ="";
        $sql.="select count(l.pk)registro";
        $sql.="  from leads l";
        //$sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.="     inner join processos p on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and p.classificacao_processo_pk = 6";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        //$sql.=" group by lr.usuarios_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarStatusClienteDashboard($usuarios_pk){

        $sql ="";
        $sql.="select count(l.pk)registro";
        $sql.="  from leads l";
        //$sql.="     inner join ocorrencias o on o.leads_pk = l.pk";
        $sql.="     inner join leads_responsaveis lr on l.pk = lr.leads_pk";
        $sql.="     inner join equipes_usuarios eu on eu.usuarios_pk = lr.usuarios_pk";
        $sql.="     inner join usuarios u on lr.usuarios_pk = u.pk";
        $sql.="     inner join processos p on p.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        $sql.=" and p.classificacao_processo_pk = 4";
        if($usuarios_pk!=""){
            $sql.="       and lr.usuarios_pk = ".$usuarios_pk;
        }
        if($this->arrToken['equipes_pk']!=""){
            $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
        }
        //$sql.=" group by lr.usuarios_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
