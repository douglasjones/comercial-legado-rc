<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/endereco.dao.php";
include_once "../model/endereco.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_endereco_pk = $arrRequest['tipo_endereco_pk'];
$ds_cep = $arrRequest['ds_cep'];
$ds_endereco = $arrRequest['ds_endereco'];
$ds_numero = $arrRequest['ds_numero'];
$ds_complemento = $arrRequest['ds_complemento'];
$ds_bairro = $arrRequest['ds_bairro'];
$ds_cidade = $arrRequest['ds_cidade'];
$ds_uf = $arrRequest['ds_uf'];
$leads_pk = $arrRequest['leads_pk'];
$contas_pk = $arrRequest['contas_pk'];
$polos_pk = $arrRequest['polos_pk'];


$enderecodao = new enderecodao();
$enderecodao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $endereco = $enderecodao->carregarPorPk($pk);
        if($endereco->getpk()>0){
            
            $enderecodao->excluir($endereco);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'endereco nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $endereco = $enderecodao->carregarPorPk($pk);
        $endereco->settipo_endereco_pk($tipo_endereco_pk);
        $endereco->setds_cep($ds_cep);
        $endereco->setds_endereco($ds_endereco);
        $endereco->setds_numero($ds_numero);
        $endereco->setds_complemento($ds_complemento);
        $endereco->setds_bairro($ds_bairro);
        $endereco->setds_cidade($ds_cidade);
        $endereco->setds_uf($ds_uf);
        $endereco->setleads_pk($leads_pk);
        $endereco->setcontas_pk($contas_pk);
        $endereco->setpolos_pk($polos_pk);

        
        $pk = $enderecodao->salvar($endereco);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarCidade':{
        
        $resultado = "";
        $query = $enderecodao->listarCidade();
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "ds_cidade"=>$query[$i]['ds_cidade']
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
    case 'listarPk':{
        
        $resultado = "";
        $query = $enderecodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_endereco_pk"=>$query[$i]['tipo_endereco_pk'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "polos_pk"=>$query[$i]['polos_pk']
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
    case 'listarPorLead':{
        if($_REQUEST['leads_pk']==""){
            $leads_pk = 0;
        }
        else{
            $leads_pk = $_REQUEST['leads_pk'];
        }
        $resultado = "";
        $query = $enderecodao->listarPorLeadPk($leads_pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_endereco_pk"=>$query[$i]['tipo_endereco_pk'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "ds_tipo_entrega"=>$query[$i]['ds_tipo_entrega'],
                    "polos_pk"=>$query[$i]['polos_pk']
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
        $query = $enderecodao->listar_por_tipo_endereco_pk($tipo_endereco_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_endereco_pk"=>$query[$i]['tipo_endereco_pk'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "polos_pk"=>$query[$i]['polos_pk']
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
        $query = $enderecodao->listar_por_tipo_endereco_pk($tipo_endereco_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_tipo_endereco_pk"=>$query[$i]['tipo_endereco_pk'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_ds_uf"=>$query[$i]['ds_uf'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],
                    "t_contas_pk"=>$query[$i]['contas_pk'],
                    "t_polos_pk"=>$query[$i]['polos_pk'],

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

$enderecodao = null;

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
