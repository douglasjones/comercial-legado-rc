<?

include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/agenda_colaborador_pausa.dao.php";
include_once "../model/agenda_colaborador_pausa.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_agenda_colaborador_pausa = $arrRequest['ds_agenda_colaborador_pausa'];
$dt_inicio_pausa = $arrRequest['dt_inicio_pausa'];
$dt_fim_pausa = $arrRequest['dt_fim_pausa'];
$motivos_pausas_pk = $arrRequest['motivos_pausas_pk'];
$colaboradores_pk = $arrRequest['colaboradores_pk'];
$turnos_pk = $arrRequest['turnos_pk'];


$agenda_colaborador_pausadao = new agenda_colaborador_pausadao();
$agenda_colaborador_pausadao->setToken($token); 

switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarPorPk($pk);
        if($agenda_colaborador_pausa->getpk()>0){
            
            $agenda_colaborador_pausadao->excluir($agenda_colaborador_pausa);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'agenda_colaborador_pausa nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $agenda_colaborador_pausa = $agenda_colaborador_pausadao->carregarPorPk($pk);
        $agenda_colaborador_pausa->setds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa);
        $agenda_colaborador_pausa->setdt_inicio_pausa(DataYMD($dt_inicio_pausa));
        $agenda_colaborador_pausa->setdt_fim_pausa(DataYMD($dt_fim_pausa));
        $agenda_colaborador_pausa->setmotivos_pausas_pk($motivos_pausas_pk);
        $agenda_colaborador_pausa->setcolaboradores_pk($colaboradores_pk);
        $agenda_colaborador_pausa->setturnos_pk($turnos_pk);

        
        $pk = $agenda_colaborador_pausadao->salvar($agenda_colaborador_pausa);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $agenda_colaborador_pausadao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "turnos_pk"=>$query[$i]['turnos_pk']
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
        $query = $agenda_colaborador_pausadao->listar_por_ds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "turnos_pk"=>$query[$i]['turnos_pk']
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
        $query = $agenda_colaborador_pausadao->listar_por_ds_agenda_colaborador_pausa($ds_agenda_colaborador_pausa);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_agenda_colaborador_pausa"=>$query[$i]['ds_agenda_colaborador_pausa'],
                    "t_dt_inicio_pausa"=>$query[$i]['dt_inicio_pausa'],
                    "t_dt_fim_pausa"=>$query[$i]['dt_fim_pausa'],
                    "t_motivos_pausas_pk"=>$query[$i]['motivos_pausas_pk'],
                    "t_colaboradores_pk"=>$query[$i]['colaboradores_pk'],
                    "t_turnos_pk"=>$query[$i]['turnos_pk'],

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

$agenda_colaborador_pausadao = null;

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
