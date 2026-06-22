<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/contato.dao.php";
include_once "../model/contato.class.php";



$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_contato = $arrRequest['ds_contato'];
$ds_cel = $arrRequest['ds_cel'];
$ic_whatsapp = $arrRequest['ic_whatsapp'];
$ds_email = $arrRequest['ds_email'];
$ds_tel = $arrRequest['ds_tel'];
$cargos_pk = $arrRequest['cargos_pk'];
$leads_pk = $arrRequest['leads_pk'];
$contas_pk = $arrRequest['contas_pk'];
$polos_pk = $arrRequest['polos_pk'];


$contatodao = new contatodao();
$contatodao->setToken($token); 

 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $contato = $contatodao->carregarPorPk($pk);
        if($contato->getpk()>0){
            
            $contatodao->excluirContato($contato);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'contato nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $contato = $contatodao->carregarPorPk($pk);
        $contato->setds_contato($ds_contato);
        $contato->setds_cel($ds_cel);
        $contato->setic_whatsapp($ic_whatsapp);
        $contato->setds_email($ds_email);
        $contato->setds_tel($ds_tel);
        $contato->setcargos_pk($cargos_pk);
        $contato->setleads_pk($leads_pk);
        $contato->setcontas_pk($contas_pk);
        $contato->setpolos_pk($polos_pk);

        
        $pk = $contatodao->salvar($contato);
        
        
        
        
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $contatodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_whatsapp"=>$query[$i]['ic_whatsapp'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "cargos_pk"=>$query[$i]['cargos_pk'],
                    "ds_cargos"=>$query[$i]['ds_cargos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk']
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
        $query = $contatodao->listar_por_ds_contato($ds_contato);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_whatsapp"=>$query[$i]['ic_whatsapp'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "cargos_pk"=>$query[$i]['cargos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    
    case 'listarPorLeadPk':{
        $leads_pk = $_REQUEST['leads_pk'];
        $resultado = "";
        $query = $contatodao->listarPorLeadsPk($leads_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_contato"=>$query[$i]['ds_contato'],
                    "ds_cel"=>$query[$i]['ds_cel'],
                    "ic_whatsapp"=>$query[$i]['ic_whatsapp'],
                    "ds_email"=>$query[$i]['ds_email'],
                    "ds_tel"=>$query[$i]['ds_tel'],
                    "cargos_pk"=>$query[$i]['cargos_pk'],
                    "leads_pk"=>$query[$i]['leads_pk']
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
        $query = $contatodao->listar_por_ds_contato($ds_contato);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_contato"=>$query[$i]['ds_contato'],
                    "t_ds_cel"=>$query[$i]['ds_cel'],
                    "t_ic_whatsapp"=>$query[$i]['ic_whatsapp'],
                    "t_ds_email"=>$query[$i]['ds_email'],
                    "t_ds_tel"=>$query[$i]['ds_tel'],
                    "t_cargos_pk"=>$query[$i]['cargos_pk'],
                    "t_leads_pk"=>$query[$i]['leads_pk'],

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

$contatodao = null;

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
