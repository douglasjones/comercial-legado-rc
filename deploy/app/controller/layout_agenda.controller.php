<?  

class layout_email{

    function layout_agendamento($dt_visita,$hr_visita,$ds_consultor,$ds_email,$ds_endereco){
        $html.='<html>';
        $html.='<head>';
        $html.='<title>Confirmação de Agendamento';
        $html.='</title>';
        $html.="<meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>";
        $html.='</head>';

        $html.='<body>';
        $html.='<p></p>';
        $html.='<p></p>';
        $html.='<div class="container" id="exibir_informativo_agenda">';
        $html.='<div class="row">';
        $html.='<div class="container">';
        $html.='<div class="modal-content">';
        $html.='<div class="modal-content">';
        $html.='<div class="modal-body" style="box-shadow: 2px 2px 5px grey;">';
        $html.='<div class="row">';
        $html.='<div class="col-md-6">';
        $html.='<i class="fa fa-calendar-check-o" aria-hidden="true" style="font-size: 25px;" > Confirmação de Agenda</i>';
        $html.='</div>';

        $html.='</div>';
        $html.='<hr>';
        $html.='<br>';
        $html.='<div class="row">';
        $html.='<div class="col-md-4">';
        $html.='Data da Visita:'.$dt_visita;
        $html.='</div>';
        $html.='<div class="col-md-4">';
        $html.='Horário da Visita:'.$hr_visita;
        $html.='</div>';
        $html.='</div>';
        $html.='<div class="row">';
        $html.='<div class="col-md-4">';
        $html.='Motivo da Visita: Visita Comercial';
        $html.='</div>';
        $html.='<div class="col-md-4">';
        $html.='Consultor:'.$ds_consultor;
        $html.='</div>';
        $html.='</div>';
        $html.='<hr>';
        $html.='<br>';
        $html.='<div class="row" align="center">';
        $html.='<div class="col-md-12">';
        $html.='    E-mail:'.$ds_email;
        $html.='</div>';

        $html.='</div>';
        $html.='<div class="row" align="center">';
        $html.='<div class="col-md-12">';
        $html.='    Endereço:'.$ds_endereco;
        $html.='</div>';


        $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        $html.='</body>';
        $html.='</html>';



         return($html);
    }   
    
    function layout_contrato($ds_lead,$etapa_contrato,$dt_etapa,$ds_usuario_cadastro,$ds_obs){
        
        $html.="<head>";
        $html.="<title>";
        $html.=" Status Contrato";
        $html.="</title>";
        $html.="<meta charset='UTF-8'>";
        $html.="<meta name='viewport' content='width=device-width, initial-scale=1'>";
        $html.="<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>";
        $html.="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>";
        $html.="<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>";
        $html.="<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>";
        $html.="</head>";

        $html.="<body>";
        $html.="<p>";
        $html.="</p>";
        $html.="<p>";
        $html.="</p>";
        $html.="<div class='container' id='exibir_informativo_agenda'>"; 
        $html.="<div class='row'>";
        $html.="<div class='container'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-content'>";
        $html.="<div class='modal-body' style='box-shadow: 2px 2px 5px grey;'>";
        $html.="<div class='row'>"; 
        $html.="<div class='col-md-6'>";                           
        $html.="<i class='fa fa-cogs' aria-hidden='true' style='font-size: 25px;' >"; 
        $html.=" Status Contrato";
        $html.="</i>"; 
        $html.="</div>";           
        $html.="</div>";
        $html.="<hr>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-12'>"; 
        $html.="  Empresa:".$ds_lead;
        $html.="</div>";                   	 
        $html.="</div>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-6'>"; 
        $html.="    Status Atual do Contrato:".$etapa_contrato;
        $html.="</div>";                         	 
        $html.="</div>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-6'>"; 
        $html.="     Data do Imput:".$dt_etapa;
        $html.="</div>";                         	 
        $html.="</div>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-6'>"; 
        $html.="    Responsável Backoffice:".$ds_usuario_cadastro;
        $html.="</div>";                         	 
        $html.="</div>";
        $html.="<br>";
        $html.="<div class='row'>";   
        $html.="<div class='col-md-6'>"; 
        $html.="    Observação: ".$ds_obs;
        $html.="</div>";                         	 
        $html.="</div>";
        $html.="<br>";
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";     
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";           
        $html.="</body>";
        $html.="</html>";
        
        return($html);

    }
}
    

