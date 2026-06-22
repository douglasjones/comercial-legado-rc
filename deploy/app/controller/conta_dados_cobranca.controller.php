<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/conta_dados_cobranca.dao.php";
include_once "../model/conta_dados_cobranca.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$dia_vencimento = $arrRequest['dia_vencimento'];
$n_qtde = $arrRequest['n_qtde'];
$vl_unit = $arrRequest['vl_unit'];
$vl_total = $arrRequest['vl_total'];
$planos_pk = $arrRequest['planos_pk'];
$tipo_pagamentos_pk = $arrRequest['tipo_pagamentos_pk'];
$n_cartao = $arrRequest['n_cartao'];
$ds_vencimento_cartao = $arrRequest['ds_vencimento_cartao'];
$ds_nome_cartao = $arrRequest['ds_nome_cartao'];
$bandeira_cartao_pk = $arrRequest['bandeira_cartao_pk'];
$ds_email_financeiro = $arrRequest['ds_email_financeiro'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$ic_status = $arrRequest['ic_status'];
$contas_pk = $arrRequest['contas_pk'];
$planos_pk = $arrRequest['planos_pk'];


$conta_dados_cobrancadao = new conta_dados_cobrancadao();
$conta_dados_cobrancadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $conta_dados_cobranca = $conta_dados_cobrancadao->carregarPorPk($pk);
        if($conta_dados_cobranca->getpk()>0){
            
            $conta_dados_cobrancadao->excluir($conta_dados_cobranca);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'conta_dados_cobranca nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $conta_dados_cobranca = $conta_dados_cobrancadao->carregarPorPk($pk);
        $conta_dados_cobranca->setdia_vencimento($dia_vencimento);
        $conta_dados_cobranca->setn_qtde($n_qtde);
        $conta_dados_cobranca->setvl_unit($vl_unit);
        $conta_dados_cobranca->setvl_total($vl_total);
        $conta_dados_cobranca->setplanos_pk($planos_pk);
        $conta_dados_cobranca->settipo_pagamentos_pk($tipo_pagamentos_pk);
        $conta_dados_cobranca->setn_cartao($n_cartao);
        $conta_dados_cobranca->setds_vencimento_cartao($ds_vencimento_cartao);
        $conta_dados_cobranca->setds_nome_cartao($ds_nome_cartao);
        $conta_dados_cobranca->setbandeira_cartao_pk($bandeira_cartao_pk);
        $conta_dados_cobranca->setds_email_financeiro($ds_email_financeiro);
        $conta_dados_cobranca->setdt_cancelamento($dt_cancelamento);
        $conta_dados_cobranca->setic_status($ic_status);
        $conta_dados_cobranca->setcontas_pk($contas_pk);
        $conta_dados_cobranca->setplanos_pk($planos_pk);

        
        $pk = $conta_dados_cobrancadao->salvar($conta_dados_cobranca);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $conta_dados_cobrancadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dia_vencimento"=>$query[$i]['dia_vencimento'],
                    "n_qtde"=>$query[$i]['n_qtde'],
                    "vl_unit"=>$query[$i]['vl_unit'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "planos_pk"=>$query[$i]['planos_pk'],
                    "tipo_pagamentos_pk"=>$query[$i]['tipo_pagamentos_pk'],
                    "n_cartao"=>$query[$i]['n_cartao'],
                    "ds_vencimento_cartao"=>$query[$i]['ds_vencimento_cartao'],
                    "ds_nome_cartao"=>$query[$i]['ds_nome_cartao'],
                    "bandeira_cartao_pk"=>$query[$i]['bandeira_cartao_pk'],
                    "ds_email_financeiro"=>$query[$i]['ds_email_financeiro'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "planos_pk"=>$query[$i]['planos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $conta_dados_cobrancadao->listar_por_dia_vencimento($dia_vencimento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "dia_vencimento"=>$query[$i]['dia_vencimento'],
                    "n_qtde"=>$query[$i]['n_qtde'],
                    "vl_unit"=>$query[$i]['vl_unit'],
                    "vl_total"=>$query[$i]['vl_total'],
                    "planos_pk"=>$query[$i]['planos_pk'],
                    "tipo_pagamentos_pk"=>$query[$i]['tipo_pagamentos_pk'],
                    "n_cartao"=>$query[$i]['n_cartao'],
                    "ds_vencimento_cartao"=>$query[$i]['ds_vencimento_cartao'],
                    "ds_nome_cartao"=>$query[$i]['ds_nome_cartao'],
                    "bandeira_cartao_pk"=>$query[$i]['bandeira_cartao_pk'],
                    "ds_email_financeiro"=>$query[$i]['ds_email_financeiro'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "planos_pk"=>$query[$i]['planos_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $conta_dados_cobrancadao->listar_por_dia_vencimento($dia_vencimento);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dia_vencimento"=>$query[$i]['dia_vencimento'],
                    "t_n_qtde"=>$query[$i]['n_qtde'],
                    "t_vl_unit"=>$query[$i]['vl_unit'],
                    "t_vl_total"=>$query[$i]['vl_total'],
                    "t_planos_pk"=>$query[$i]['planos_pk'],
                    "t_tipo_pagamentos_pk"=>$query[$i]['tipo_pagamentos_pk'],
                    "t_n_cartao"=>$query[$i]['n_cartao'],
                    "t_ds_vencimento_cartao"=>$query[$i]['ds_vencimento_cartao'],
                    "t_ds_nome_cartao"=>$query[$i]['ds_nome_cartao'],
                    "t_bandeira_cartao_pk"=>$query[$i]['bandeira_cartao_pk'],
                    "t_ds_email_financeiro"=>$query[$i]['ds_email_financeiro'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_contas_pk"=>$query[$i]['contas_pk'],
                    "t_planos_pk"=>$query[$i]['planos_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    default:{
        break;
    }
}

$conta_dados_cobrancadao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
