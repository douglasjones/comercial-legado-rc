<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/carga_lead.dao.php";
include_once "../model/carga_lead.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_pessoa_pk = $arrRequest['tipo_pessoa_pk'];
$ds_lead = $arrRequest['ds_lead'];
$ds_razao_social = $arrRequest['ds_razao_social'];
$ds_cpf_cnpj = $arrRequest['ds_cpf_cnpj'];
$ds_ie = $arrRequest['ds_ie'];
$ds_rg = $arrRequest['ds_rg'];
$ds_cnae = $arrRequest['ds_cnae'];

$ds_site = $arrRequest['ds_site'];
$ds_obs = $arrRequest['ds_obs'];
$mailing_pk = $arrRequest['mailing_pk'];
$tipo_telefone_pk = $arrRequest['tipo_telefone_pk'];
$tipo_telefone_pk1 = $arrRequest['tipo_telefone_pk1'];
$ds_ddd = $arrRequest['ds_ddd'];
$ds_tel = $arrRequest['ds_tel'];
$ds_ddd1 = $arrRequest['ds_ddd1'];
$ds_tel1 = $arrRequest['ds_tel1'];
$tipo_endereco_pk = $arrRequest['tipo_endereco_pk'];
$ds_endereco = $arrRequest['ds_endereco'];
$ds_numero = $arrRequest['ds_numero'];
$ds_complemento = $arrRequest['ds_complemento'];
$ds_bairro = $arrRequest['ds_bairro'];
$ds_cidade = $arrRequest['ds_cidade'];
$ds_uf = $arrRequest['ds_uf'];
$ds_contato = $arrRequest['ds_contato'];
$ds_cel_contato = $arrRequest['ds_cel_contato'];
$ds_tel_contato = $arrRequest['ds_tel_contato'];
$ds_email_contato = $arrRequest['ds_email_contato'];
$ds_email_contato1 = $arrRequest['ds_email_contato1'];
$ds_contato1 = $arrRequest['ds_contato1'];
$ds_cel_contato1 = $arrRequest['ds_cel_contato1'];
$ds_tel_contato1 = $arrRequest['ds_tel_contato1'];
$contas_pk = $arrRequest['contas_pk'];
$polos_pk = $arrRequest['polos_pk'];
$dt_sinconizacao = $arrRequest['dt_sinconizacao'];
$ic_status = $arrRequest['ic_status'];

$ds_arquivo = $arrRequest['ds_arquivo'];

$ic_cliente = $arrRequest['ic_cliente'];
$grupos_pk = $arrRequest['grupos_pk'];
$usuarios_pk = $arrRequest['usuarios_pk'];


$carga_leaddao = new carga_leaddao();
$carga_leaddao->setToken($token); 

verificarLogin($token);

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $carga_lead = $carga_leaddao->carregarPorPk($pk);
        if($carga_lead->getpk()>0){
            
            $carga_leaddao->excluir($carga_lead);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'carga_lead nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        
        
        $carga_lead = $carga_leaddao->carregarPorPk($pk);
        $carga_lead->setmailing_pk($mailing_pk);
        $carga_lead->setpolos_pk($polos_pk);
        $carga_lead->setarquivo($ds_arquivo);
        $carga_lead->setic_cliente($ic_cliente);
        $carga_lead->setgrupos_pk($grupos_pk);
        $carga_lead->setusuarios_pk($usuarios_pk);

        
        $pk = $carga_leaddao->salvar($carga_lead);
        
        
        
        /*$mysql_data[] = array(
            "pk" => $pk
        );*/
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $carga_leaddao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_pessoa_pk"=>$query[$i]['tipo_pessoa_pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_ie"=>$query[$i]['ds_ie'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_cnae"=>$query[$i]['ds_cnae'],
                    "ic_cliente"=>$query[$i]['ic_cliente'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "mailing_pk"=>$query[$i]['mailing_pk'],
                    "tipo_telefone_pk"=>$query[$i]['tipo_telefone_pk'],
                    "tipo_telefone_pk1"=>$query[$i]['tipo_telefone_pk1'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_ddd1"=>$query[$i]['ds_ddd1'],
                    "ds_tel1"=>$query[$i]['ds_tel1'],
                    "tipo_endereco_pk"=>$query[$i]['tipo_endereco_pk'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "ds_cel_contato"=>$query[$i]['ds_cel_contato'],
                    "ds_tel_contato"=>$query[$i]['ds_tel_contato'],
                    "ds_email_contato"=>$query[$i]['ds_email_contato'],
                    "ds_email_contato1"=>$query[$i]['ds_email_contato1'],
                    "ds_contato1"=>$query[$i]['ds_contato1'],
                    "ds_cel_contato1"=>$query[$i]['ds_cel_contato1'],
                    "ds_tel_contato1"=>$query[$i]['ds_tel_contato1'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "dt_sinconizacao"=>$query[$i]['dt_sinconizacao'],
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
    case 'listarTodos':{
        
        $resultado = "";
        $query = $carga_leaddao->listar_por_tipo_pessoa_pk($tipo_pessoa_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_pessoa_pk"=>$query[$i]['tipo_pessoa_pk'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_razao_social"=>$query[$i]['ds_razao_social'],
                    "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                    "ds_ie"=>$query[$i]['ds_ie'],
                    "ds_rg"=>$query[$i]['ds_rg'],
                    "ds_cnae"=>$query[$i]['ds_cnae'],
                    "ic_cliente"=>$query[$i]['ic_cliente'],
                    "ds_site"=>$query[$i]['ds_site'],
                    "ds_obs"=>$query[$i]['ds_obs'],
                    "mailing_pk"=>$query[$i]['mailing_pk'],
                    "tipo_telefone_pk"=>$query[$i]['tipo_telefone_pk'],
                    "tipo_telefone_pk1"=>$query[$i]['tipo_telefone_pk1'],
                    "ds_ddd"=>$query[$i]['ds_ddd'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "ds_ddd1"=>$query[$i]['ds_ddd1'],
                    "ds_tel1"=>$query[$i]['ds_tel1'],
                    "tipo_endereco_pk"=>$query[$i]['tipo_endereco_pk'],
                    "ds_endereco"=>$query[$i]['ds_endereco'],
                    "ds_numero"=>$query[$i]['ds_numero'],
                    "ds_complemento"=>$query[$i]['ds_complemento'],
                    "ds_bairro"=>$query[$i]['ds_bairro'],
                    "ds_cidade"=>$query[$i]['ds_cidade'],
                    "ds_uf"=>$query[$i]['ds_uf'],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "ds_cel_contato"=>$query[$i]['ds_cel_contato'],
                    "ds_tel_contato"=>$query[$i]['ds_tel_contato'],
                    "ds_email_contato"=>$query[$i]['ds_email_contato'],
                    "ds_email_contato1"=>$query[$i]['ds_email_contato1'],
                    "ds_contato1"=>$query[$i]['ds_contato1'],
                    "ds_cel_contato1"=>$query[$i]['ds_cel_contato1'],
                    "ds_tel_contato1"=>$query[$i]['ds_tel_contato1'],
                    "contas_pk"=>$query[$i]['contas_pk'],
                    "polos_pk"=>$query[$i]['polos_pk'],
                    "dt_sinconizacao"=>$query[$i]['dt_sinconizacao'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarNaoRealizado':{
        
        $cargas_pk = $_REQUEST['cargas_pk'];
        
        
        
        if($cargas_pk!=""){
            $resultado = "";
            $query = $carga_leaddao->listarNaoRealizado($cargas_pk);

            $result  = 'success';
            $message = 'query success';

            if(count($query) > 0){
                for($i = 0; $i < count($query); $i++){
                    $mysql_data[] = array(
                        "pk" => $query[$i]["pk"],
                        "ds_lead" => $query[$i]["ds_lead"],
                        "ds_cpf_cnpj" => $query[$i]["ds_cpf_cnpj"],
                        "ds_mailing" => $query[$i]["ds_mailing"],
                        "ds_usuario" => $query[$i]["ds_usuario"],
                        "dt_cadastro" => $query[$i]["dt_cadastro"],
                    );
                }
            }
            else{
                $mysql_data = [];
            }
        }
        else{
            $mysql_data = [];
        }
        
			
        
        break;
    }
    case 'listarDataTable':{
        $polos_pk = $_REQUEST['polos_pk'];
        $mailing_pk = $_REQUEST['mailing_pk'];
        $dt_carga_ini = $_REQUEST['dt_carga_ini'];
        $dt_carga_fim = $_REQUEST['dt_carga_fim'];
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
        
        $resultado = "";
        $query = $carga_leaddao->listar_por_tipo_pessoa_pk($polos_pk,$mailing_pk,$dt_carga_ini,$dt_carga_fim,$usuario_cadastro_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_sinconizacao"=>$query[$i]['dt_sinconizacao'],
                    "t_ds_mailing"=>$query[$i]['ds_mailing'],
                    "t_ds_usuario"=>$query[$i]['ds_usuario'],

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

$carga_leaddao = null;

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
