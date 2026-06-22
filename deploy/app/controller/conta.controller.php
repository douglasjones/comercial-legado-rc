<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/conta.dao.php";
include_once "../model/conta.class.php";
   
$arrRequest = tratar_request();


$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_tipo_pessoa = $arrRequest['ds_tipo_pessoa'];
$ds_conta = $arrRequest['ds_conta'];
$ds_razao_social = $arrRequest['ds_razao_social'];
$ds_cpf_cnpj = $arrRequest['ds_cpf_cnpj'];
$ds_cnae = $arrRequest['ds_cnae'];
$ds_rg = $arrRequest['ds_rg'];
$ds_tel = $arrRequest['ds_tel'];
$ds_email = $arrRequest['ds_email'];
$ds_cel = $arrRequest['ds_cel'];
$ds_cep = $arrRequest['ds_cep'];
$ds_endereco = $arrRequest['ds_endereco'];
$ds_numero = $arrRequest['ds_numero'];
$ds_complemento = $arrRequest['ds_complemento'];
$ds_bairro = $arrRequest['ds_bairro'];
$ds_cidade = $arrRequest['ds_cidade'];
$ds_uf = $arrRequest['ds_uf'];
$dt_ativacao = $arrRequest['dt_ativacao'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$ic_status = $arrRequest['ic_status'];


$contadao = new contadao();

$contadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $conta = $contadao->carregarPorPk($pk);
        if($conta->getpk()>0){
            
            $contadao->excluir($conta);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'conta nao encontrado';
        }
        break;
    }
    case 'salvar':{
  
        $conta = $contadao->carregarPorPk($pk);

        $conta->setds_tipo_pessoa($ds_tipo_pessoa);
        $conta->setds_conta($ds_conta);
        $conta->setds_razao_social($ds_razao_social);
        $conta->setds_cpf_cnpj($ds_cpf_cnpj);
        $conta->setds_cnae($ds_cnae);
        $conta->setds_rg($ds_rg);
        $conta->setds_tel($ds_tel);
        $conta->setds_email($ds_email);

        $conta->setds_cel($ds_cel);
        $conta->setds_cep($ds_cep);
        $conta->setds_endereco($ds_endereco);
        $conta->setds_numero($ds_numero);
        $conta->setds_complemento($ds_complemento);
        $conta->setds_bairro($ds_bairro);
        $conta->setds_cidade($ds_cidade);
        $conta->setds_uf($ds_uf);
        $conta->setdt_ativacao($dt_ativacao);
        $conta->setdt_cancelamento($dt_cancelamento);
        $conta->setic_status($ic_status);
      
        $pk = $contadao->salvar($conta);
        
        $mysql_data[] = array(
                "pk" => $pk
        );        
      
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
    
        $resultado = "";
        $query = $contadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_pessoa"=>$query[$i]['ds_tipo_pessoa'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_cnae"=>$query[$i]['ds_cnae'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status']
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
    case 'listarContasUsuarios':{
        
        $resultado = "";
        $query = $contadao->listar_contas_usuarios($ds_tipo_pessoa,$token);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_pessoa"=>$query[$i]['ds_tipo_pessoa'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_cnae"=>$query[$i]['ds_cnae'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_ddd_cel"=>$query[$i]['ds_ddd_cel'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
        break;
    }
    
    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $contadao->listar_por_ds_tipo_pessoa($ds_tipo_pessoa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_tipo_pessoa"=>$query[$i]['ds_tipo_pessoa'],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_cnae"=>$query[$i]['ds_cnae'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_ddd_cel"=>$query[$i]['ds_ddd_cel'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ds_cep"=>$query[$i]['ds_cep'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "segmentos_pk"=>$query[$i]['segmentos_pk'],
                    "dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
        break;
    }
    case 'verificarConta':{
        
        $resultado = "";
        $query = $contadao->verificarConta();
        
        
        if($query[0]['ic_status']==2){
           /*$contadao->desativarPolo($query[0]['pk']);
           $contadao->desativarUsuarios($query[0]['pk']);*/
        }
        
        $result  = 'success';
        $message = 'query success';
                $mysql_data[] = array(
                    "ic_status"=>$query[0]['ic_status'],
                    "ds_conta"=>$query[0]['ds_conta']
                );
        break;
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $contadao->listar_por_pesquisa_grid($ds_tipo_pessoa,$ds_conta,$ds_cpf_cnpj,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_tipo_pessoa"=>$query[$i]['ds_tipo_pessoa'],
                    "t_ds_conta"=>$query[$i]['ds_conta'],
                    "t_ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "t_ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "t_ds_cnae"=>$query[$i]['ds_cnae'],
                    "t_ds_rg"=>$query[$i]['ds_rg'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],       
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ds_cep"=>$query[$i]['ds_cep'],
                    "t_ds_endereco"=>$query[$i]['ds_endereco'],
                    "t_ds_numero"=>$query[$i]['ds_numero'],
                    "t_ds_complemento"=>$query[$i]['ds_complemento'],
                    "t_ds_bairro"=>$query[$i]['ds_bairro'],
                    "t_ds_cidade"=>$query[$i]['ds_cidade'],
                    "t_dt_ativacao"=>$query[$i]['dt_ativacao'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_ic_status"=>$query[$i]['ic_status'],

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

$contadao = null;

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
