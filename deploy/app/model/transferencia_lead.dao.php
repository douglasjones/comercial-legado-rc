<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';


class transferencia_leaddao{

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
    public function listarQtdeLead($polos_pk,$ds_razao_social,$ic_status_1,$ic_status_2,$ic_status_3,$ic_status_4,$grupos_pk,$usuarios_pk,$tipo_pessoa_pk,$mailing_pk,$operador_pk,$classificacao_operador_pk,$tempo_contrato_ini,$tempo_contrato_fim,$qtde_linhas_ini,$qtde_linhas_fim){

        $sql ="";
        $sql.="SELECT COUNT('0') qtde_registros,";
        $sql.="       CASE p.classificacao_processo_pk  WHEN 1 THEN '25%'  WHEN 2 THEN '50%' WHEN 3 THEN '75%' WHEN 4 THEN 'Cliente' END ds_classificacao";
        $sql.="  FROM leads l";
        $sql.="       LEFT JOIN processos p ON p.leads_pk = l.pk";
        $sql.="       LEFT JOIN leads_responsaveis lr ON lr.leads_pk = l.pk";
        if($operador_pk != "" || $classificacao_operador_pk != "" || $tempo_contrato_ini != "" || $tempo_contrato_fim != "" || $qtde_linhas_ini != "" || $qtde_linhas_fim != ""){
            $sql.="       INNER JOIN leads_operadoras lo ON lo.leads_pk = l.pk";
        }
        $sql.=" where l.contas_pk =".$this->arrToken['contas_pk'];
        if($ic_status_1!='0' || $ic_status_2!='0'|| $ic_status_3!='0'|| $ic_status_4!='0'){
        $sql.=" and p.classificacao_processo_pk in(";
            if($ic_status_1!=0){
                $sql.=$ic_status_1.",";
            }
            if($ic_status_2!=0){
                $sql.=$ic_status_2.",";
            }
            if($ic_status_3!=0){
                $sql.=$ic_status_3.",";
            }
            if($ic_status_4!=0){
                $sql.=$ic_status_4.",";
            }
            $sql.="0)";
        }
        /*else{
            $sql.=" and p.classificacao_processo_pk is null";
        }*/
        
        if($polos_pk!=""){
            $sql.=" and l.polos_pk = ".$polos_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and lr.grupos_pk= ".$grupos_pk;
        }
        if($usuarios_pk!=""){
            $sql.=" and lr.usuarios_pk= ".$usuarios_pk;
        }
        else{
             $sql.=" and lr.usuarios_pk is null";
        }
        if($mailing_pk!=""){
            $sql.=" and l.mailing_pk= ".$mailing_pk;
        }
        if($operador_pk!=""){
            $sql.=" and lo.operador_pk = ".$operador_pk;
        }
        if($classificacao_operador_pk!=""){
            $sql.=" and lo.classificacao_pk = ".$classificacao_operador_pk;
        }
        if($tempo_contrato_ini != "" && $tempo_contrato_fim != ""){
            $sql.=" and lo.tempo_contrato_pk between ".intval($tempo_contrato_ini)." and ".intval($tempo_contrato_fim);
        }
        else if($tempo_contrato_ini != ""){
            $sql.=" and lo.tempo_contrato_pk >= ".intval($tempo_contrato_ini);
        }
        else if($tempo_contrato_fim != ""){
            $sql.=" and lo.tempo_contrato_pk <= ".intval($tempo_contrato_fim);
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
        if($tipo_pessoa_pk!=""){
            $sql.=" and l.tipo_pessoa_pk = '".$tipo_pessoa_pk."'";
        }
        if($ds_razao_social!=""){
            $sql.=" and l.ds_lead like '%".$ds_razao_social."%'";
        }
        
        $sql.=" GROUP BY p.classificacao_processo_pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function TransferirLead($polos_pk,$ds_razao_social,$ic_status_1,$ic_status_2,$ic_status_3,$ic_status_4,$grupos_pk,$usuarios_pk,$tipo_pessoa_pk,$mailing_pk,$operador_pk,$classificacao_operador_pk,$tempo_contrato_ini,$tempo_contrato_fim,$qtde_linhas_ini,$qtde_linhas_fim,$selected_leads_pk){

        $sql ="";
        $sql.="SELECT l.pk";
        $sql.="       ,lr.pk lead_responsavel_pk";
        $sql.="  FROM leads l";
        $sql.="       LEFT JOIN processos p ON p.leads_pk = l.pk";
        $sql.="       LEFT JOIN leads_responsaveis lr ON lr.leads_pk = l.pk";
        if($operador_pk != "" || $classificacao_operador_pk != "" || $tempo_contrato_ini != "" || $tempo_contrato_fim != "" || $qtde_linhas_ini != "" || $qtde_linhas_fim != ""){
            $sql.="       INNER JOIN leads_operadoras lo ON lo.leads_pk = l.pk";
        }
        $sql.=" where l.contas_pk =".$this->arrToken['contas_pk'];
        if($polos_pk!=""){
            $sql.=" and l.polos_pk = ".$polos_pk;
        }
       if($ic_status_1!='0' || $ic_status_2!='0'|| $ic_status_3!='0'|| $ic_status_4!='0'){
        $sql.=" and p.classificacao_processo_pk in(";
            if($ic_status_1!=0){
                $sql.=$ic_status_1.",";
            }
            if($ic_status_2!=0){
                $sql.=$ic_status_2.",";
            }
            if($ic_status_3!=0){
                $sql.=$ic_status_3.",";
            }
            if($ic_status_4!=0){
                $sql.=$ic_status_4.",";
            }
            $sql.="0)";
        }
        
        if($polos_pk!=""){
            $sql.=" and l.polos_pk = ".$polos_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and lr.grupos_pk= ".$grupos_pk;
        }
        if($usuarios_pk!=""){
            $sql.=" and lr.usuarios_pk= ".$usuarios_pk;
        }
        else{
             $sql.=" and lr.usuarios_pk is null";
        }
        if($mailing_pk!=""){
            $sql.=" and l.mailing_pk= ".$mailing_pk;
        }
        if($operador_pk!=""){
            $sql.=" and lo.operador_pk = ".$operador_pk;
        }
        if($classificacao_operador_pk!=""){
            $sql.=" and lo.classificacao_pk = ".$classificacao_operador_pk;
        }
        if($tempo_contrato_ini != "" && $tempo_contrato_fim != ""){
            $sql.=" and lo.tempo_contrato_pk between ".intval($tempo_contrato_ini)." and ".intval($tempo_contrato_fim);
        }
        else if($tempo_contrato_ini != ""){
            $sql.=" and lo.tempo_contrato_pk >= ".intval($tempo_contrato_ini);
        }
        else if($tempo_contrato_fim != ""){
            $sql.=" and lo.tempo_contrato_pk <= ".intval($tempo_contrato_fim);
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
        if($tipo_pessoa_pk!=""){
            $sql.=" and l.tipo_pessoa_pk = '".$tipo_pessoa_pk."'";
        }
        if($ds_razao_social!=""){
            $sql.=" and l.ds_lead like'%".$ds_razao_social."%'";
        }
        if($selected_leads_pk != ""){
            $arrSelected = array_filter(array_map('intval', explode(',', $selected_leads_pk)));
            if(count($arrSelected) > 0){
                $sql.=" and l.pk in (".implode(",", $arrSelected).")";
            }
        }
        
        $sql.="     GROUP BY l.pk";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarLeadsTransferencia($polos_pk,$ds_razao_social,$ic_status_1,$ic_status_2,$ic_status_3,$ic_status_4,$grupos_pk,$usuarios_pk,$tipo_pessoa_pk,$mailing_pk,$operador_pk,$classificacao_operador_pk,$tempo_contrato_ini,$tempo_contrato_fim,$qtde_linhas_ini,$qtde_linhas_fim,$status_consulta,$qtde_consulta){

        $qtde_consulta = intval($qtde_consulta);
        if($qtde_consulta <= 0){
            return array();
        }

        $sql ="";
        $sql.="SELECT l.pk";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,CASE p.classificacao_processo_pk WHEN 1 THEN '25%' WHEN 2 THEN '50%' WHEN 3 THEN '75%' WHEN 4 THEN 'Cliente' END ds_classificacao";
        $sql.="  FROM leads l";
        $sql.="       LEFT JOIN processos p ON p.leads_pk = l.pk";
        $sql.="       LEFT JOIN leads_responsaveis lr ON lr.leads_pk = l.pk";
        if($operador_pk != "" || $classificacao_operador_pk != "" || $tempo_contrato_ini != "" || $tempo_contrato_fim != "" || $qtde_linhas_ini != "" || $qtde_linhas_fim != ""){
            $sql.="       INNER JOIN leads_operadoras lo ON lo.leads_pk = l.pk";
        }
        $sql.=" where l.contas_pk =".$this->arrToken['contas_pk'];
        if($ic_status_1!='0' || $ic_status_2!='0'|| $ic_status_3!='0'|| $ic_status_4!='0'){
            $sql.=" and p.classificacao_processo_pk in(";
            if($ic_status_1!=0){
                $sql.=$ic_status_1.",";
            }
            if($ic_status_2!=0){
                $sql.=$ic_status_2.",";
            }
            if($ic_status_3!=0){
                $sql.=$ic_status_3.",";
            }
            if($ic_status_4!=0){
                $sql.=$ic_status_4.",";
            }
            $sql.="0)";
        }
        if($polos_pk!=""){
            $sql.=" and l.polos_pk = ".$polos_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and lr.grupos_pk= ".$grupos_pk;
        }
        if($usuarios_pk!=""){
            $sql.=" and lr.usuarios_pk= ".$usuarios_pk;
        }
        else{
            $sql.=" and lr.usuarios_pk is null";
        }
        if($mailing_pk!=""){
            $sql.=" and l.mailing_pk= ".$mailing_pk;
        }
        if($operador_pk!=""){
            $sql.=" and lo.operador_pk = ".$operador_pk;
        }
        if($classificacao_operador_pk!=""){
            $sql.=" and lo.classificacao_pk = ".$classificacao_operador_pk;
        }
        if($tempo_contrato_ini != "" && $tempo_contrato_fim != ""){
            $sql.=" and lo.tempo_contrato_pk between ".intval($tempo_contrato_ini)." and ".intval($tempo_contrato_fim);
        }
        else if($tempo_contrato_ini != ""){
            $sql.=" and lo.tempo_contrato_pk >= ".intval($tempo_contrato_ini);
        }
        else if($tempo_contrato_fim != ""){
            $sql.=" and lo.tempo_contrato_pk <= ".intval($tempo_contrato_fim);
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
        if($tipo_pessoa_pk!=""){
            $sql.=" and l.tipo_pessoa_pk = '".$tipo_pessoa_pk."'";
        }
        if($ds_razao_social!=""){
            $sql.=" and l.ds_lead like'%".$ds_razao_social."%'";
        }
        if($status_consulta === "0"){
            $sql.=" and p.classificacao_processo_pk is null";
        }
        else{
            $sql.=" and p.classificacao_processo_pk = ".intval($status_consulta);
        }

        $sql.=" GROUP BY l.pk, l.ds_lead, l.ds_cpf_cnpj, p.classificacao_processo_pk";
        $sql.=" ORDER BY l.pk";
        $sql.=" limit ".$qtde_consulta;

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarResumoOperadoraPorLeads($arrLeadsPk){

        $arrLeadsPk = array_filter(array_map('intval', (array)$arrLeadsPk));

        if(count($arrLeadsPk) <= 0){
            return array();
        }

        $sql ="";
        $sql.="SELECT lo.leads_pk";
        $sql.="       ,ANY_VALUE(lo.tempo_contrato_pk) tempo_contrato_pk";
        $sql.="       ,ANY_VALUE(lo.ds_qtde_voz) ds_qtde_voz";
        $sql.="  FROM leads_operadoras lo";
        $sql.=" WHERE lo.leads_pk in (".implode(",", $arrLeadsPk).")";
        $sql.=" GROUP BY lo.leads_pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }
   
}

?>
