<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/polo.dao.php";
include_once "../model/polo.class.php";

include_once "../model/polo_operador.dao.php";
include_once "../model/polo_operador.class.php";

include_once "../model/etapa_contrato.dao.php";
include_once "../model/etapa_contrato.class.php";

require_once "../model/polo_modelo_proposta.dao.php";
require_once "../model/polo_modelo_proposta.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_polo = $arrRequest['ds_polo'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$ic_status = $arrRequest['ic_status'];
$segmentos_pk = $arrRequest['segmentos_pk'];
$contas_pk = $arrRequest['contas_pk'];
$ds_cep = $arrRequest['ds_cep'];
$ds_endereco = $arrRequest['ds_endereco'];
$ds_numero = $arrRequest['ds_numero'];
$ds_complemento = $arrRequest['ds_complemento'];
$ds_bairro = $arrRequest['ds_bairro'];
$ds_cidade = $arrRequest['ds_cidade'];
$ds_uf = $arrRequest['ds_uf'];
$responsavel_pk = $arrRequest['responsavel_pk'];
$ds_tel = $arrRequest['ds_tel'];
$ds_cel = $arrRequest['ds_cel'];
$ds_site = $arrRequest['ds_site'];
$ds_email = $arrRequest['ds_email'];

// DADOS CONTA
$contas_dados_cobranca_pk = $arrRequest['contas_dados_cobranca_pk'];
$dia_vencimento = $arrRequest['dia_vencimento'];
$planos_pk = $arrRequest['planos_pk'];
$tipo_pagamentos_pk = $arrRequest['tipo_pagamentos_pk'];
$n_cartao = $arrRequest['n_cartao'];
$ds_vencimento_cartao = $arrRequest['ds_vencimento_cartao'];
$ds_nome_cartao = $arrRequest['ds_nome_cartao'];
$bandeira_cartao_pk = $arrRequest['bandeira_cartao_pk'];
$ds_email_financeiro  = $arrRequest['ds_email_financeiro'];

$polos_operadores_pk = $_REQUEST['polos_operadores_pk'];

$etapas_contratos_pk = $_REQUEST['etapas_contratos_pk'];

$modelo_proposta_pk = $_REQUEST['modelo_proposta_pk'];

$polodao = new polodao();
$polodao->setToken($token); 

$polo_operadordao = new polo_operadordao();
$polo_operadordao->setToken($token); 

$etapa_contratodao = new etapa_contratodao();
$etapa_contratodao->setToken($token); 

$polo_modelo_propostadao = new polo_modelo_propostadao();
$polo_modelo_propostadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $polo = $polodao->carregarPorPk($pk);
        if($polo->getpk()>0){
            
            $polodao->excluir($polo);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'polo nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        if($polos_operadores_pk != "")
            $arrPolosOperadores = json_decode ($polos_operadores_pk, true);
        
        if($etapas_contratos_pk != "")
            $arrPolosEtapas = json_decode ($etapas_contratos_pk, true);
        
        if($modelo_proposta_pk != "")
            $arrPolosModeloProposta = json_decode ($modelo_proposta_pk, true);
        
        $polo = $polodao->carregarPorPk($pk);
        $polo->setds_polo($ds_polo);
        $polo->setdt_cancelamento($dt_cancelamento);
        $polo->setic_status($ic_status);
        $polo->setsegmentos_pk($segmentos_pk);
        $polo->setcontas_pk($contas_pk);
        $polo->setds_cep($ds_cep);
        $polo->setds_endereco($ds_endereco);
        $polo->setds_numero($ds_numero);
        $polo->setds_complemento($ds_complemento);
        $polo->setds_bairro($ds_bairro);
        $polo->setds_cidade($ds_cidade);
        $polo->setds_uf($ds_uf);
        $polo->setresponsavel_pk($responsavel_pk);
        $polo->setds_tel($ds_tel);
        $polo->setds_cel($ds_cel);
        $polo->setds_site($ds_site);
        $polo->setds_email($ds_email);

        $polo->setdia_vencimento($dia_vencimento);      
        $polo->setplanos_pk($planos_pk);
        $polo->settipo_pagamentos_pk($tipo_pagamentos_pk);
        $polo->setn_cartao($n_cartao);
        $polo->setds_vencimento_cartao($ds_vencimento_cartao);
        $polo->setds_nome_cartao($ds_nome_cartao);
        $polo->setbandeira_cartao_pk($bandeira_cartao_pk);
        $polo->setds_email_financeiro($ds_email_financeiro);
        
        $pk = $polodao->salvar($polo);

        $mysql_data[] = array(
                "pk" => $pk
            );
            
         //Polo Operador
        if(count($arrPolosOperadores) > 0){
            for($i = 0; $i < count($arrPolosOperadores); $i++){
                
                $polo_operador = $polo_operadordao->carregarPorPk($arrPolosOperadores[$i]['polos_operadores_pk']);
                
                $polo_operador->setoperadores_pk($arrPolosOperadores[$i]['operador_pk']);
    
                $polo_operador->setic_status($arrPolosOperadores[$i]['ic_status_operador']);
                $polo_operador->setpolos_pk($pk);
                 
                $polos_operadores_pk = $polo_operadordao->salvar($polo_operador);
            }
        }  
     
        //Polo Etapas
        if(count($arrPolosEtapas) > 0){          
            for($i = 0; $i < count($arrPolosEtapas); $i++){
            
                $polo_etapa = $etapa_contratodao->carregarPorPk($arrPolosEtapas[$i]['etapas_contratos_pk']);
        
                $polo_etapa->setoperador_pk($arrPolosEtapas[$i]['operador_pk']);                
                $polo_etapa->setn_ordem($arrPolosEtapas[$i]['n_ordem']);
                $polo_etapa->setds_etapa($arrPolosEtapas[$i]['ds_etapa']);                 
                $polo_etapa->setic_status($arrPolosEtapas[$i]['ic_status_esteira']);                
                $polo_etapa->setpolos_pk($pk);
                
                $$etapa_contrato_pk = $etapa_contratodao->salvar($polo_etapa);
            }
        }  
        
        if(count($arrPolosModeloProposta) > 0){          
            for($i = 0; $i < count($arrPolosModeloProposta); $i++){
                
                
                $polo_modelo_proposta = $polo_modelo_propostadao->carregarPorPk($arrPolosModeloProposta[$i]['modelo_proposta_pk']);
                $polo_modelo_proposta->settipo_modelo_pk($arrPolosModeloProposta[$i]['tipo_modelo_pk']);
                $polo_modelo_proposta->settipo_envio_pk($arrPolosModeloProposta[$i]['tipo_envio_pk']);
                $polo_modelo_proposta->setds_email($arrPolosModeloProposta[$i]['ds_email']);
                $polo_modelo_proposta->sethtml_modelo($arrPolosModeloProposta[$i]['html_modelo']);
                $polo_modelo_proposta->setpolos_pk($pk);
                $polo_modelo_proposta->setoperador_pk($arrPolosModeloProposta[$i]['operador_pk']);
                $polo_modelo_proposta->setstatus_pk($arrPolosModeloProposta[$i]['status_pk']);
                 
                $modelo_proposta_pk = $polo_modelo_propostadao->salvar($polo_modelo_proposta);
            }
        }  
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $polodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_polo"=>$query[$i]['ds_polo'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "planos_pk"=>$query[$i]['planos_pk'],
                    "dia_vencimento"=>$query[$i]['dia_vencimento'],    
                    "tipo_pagamentos_pk"=>$query[$i]['tipo_pagamentos_pk'],
                    "bandeira_cartao_pk"=>$query[$i]['bandeira_cartao_pk'],
                    "n_cartao"=>$query[$i]['n_cartao'],
                    "ds_vencimento_cartao"=>$query[$i]['ds_vencimento_cartao'],
                    "ds_nome_cartao"=>$query[$i]['ds_nome_cartao'],
                    "ds_email_financeiro"=>$query[$i]['ds_email_financeiro']
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
        $query = $polodao->listar_por_ds_polo($ds_polo);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_polo"=>$query[$i]['ds_polo'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "ds_email"=>$query[$i]['ds_email']
                );
            }
        }
        else{
            $mysql_data = [];
        }
        break;
    }
    case 'listarPorContasPk':{
        
        $resultado = "";
        $query = $polodao->listar_por_contas();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_polo"=>$query[$i]['ds_polo'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "ds_email"=>$query[$i]['ds_email']
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    case 'listarPorContasPkSelecionado':{
        
        $resultado = "";
        $query = $polodao->listar_por_contas_selecionado($contas_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_polo"=>$query[$i]['ds_polo'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "ds_email"=>$query[$i]['ds_email']
                );
            }
        }
        else{
            $mysql_data = [];
        }	
        
        break;
    }
    
    case 'listarPorContasPkUsuario':{
        
        $resultado = "";
        $query = $polodao->listar_por_contas_usuarios();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_polo"=>$query[$i]['ds_polo'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "ds_email"=>$query[$i]['ds_email']
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
        $query = $polodao->listar_por_ds_polo($ds_polo,$ic_status,$polos_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_polo"=>$query[$i]['ds_polo'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ic_status"=>$query[$i]['ic_status'],
                    "t_segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "t_contas_pk"=>$query[$i]['contas_pk'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_responsavel_pk"=>$query[$i]['responsavel_pk'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ds_site"=>$query[$i]['ds_site'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_conta"=>$query[$i]['ds_conta'],
                    "t_ds_responsavel"=>$query[$i]['ds_responsavel'],
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

$polodao = null;

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
