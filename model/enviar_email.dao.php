<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';


class enviar_emaildao{

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
    
    function envia_email_agendamento($html,$emailde,$emailpara,$assunto){       
       
        $from = $emailde;//de:
        $to = $emailpara;//para:
        $body = $html;
        //$cc = "douglas.lopes@gepros.com.br";
        $mailheaders = "From: $from\n";
        $mailheaders .= "Reply-To: $ReplyTo\n";
        $mailheaders .= "Cc: $emailde\n";
        $mailheaders .= "Bcc: $bcc\n";
        $mailheaders .= "X-Mailer: $assunto \n";

        $msg_body = stripslashes($body);

        $mailheaders .= "MIME-version: 1.0\n";
        //$mailheaders .= "Content-type: multipart/mixed; ";
        $mailheaders .= "Content-type: text/html; charset=utf-8\n";
        $mailheaders .= "boundary=\"Message-Boundary\"\n";
        $mailheaders .= "Content-transfer-encoding: 7BIT\n";
        //if(!empty($anexo)){
        //	$mailheaders .= "X-attachments: $attach_name";
        //}
        $body_top = "--Message-Boundary\n";
        $body_top .= "Content-type: text/html; charset=US-ASCII\n";
        $body_top .= "Content-transfer-encoding: 7BIT\n";
        $body_top .= "Content-description: Mail message body\n\n";

        $msg_body = $body_top . $msg_body;

        $msg_body .= "\n\n--Message-Boundary\n";
        $msg_body .= "Content-Transfer-Encoding: BASE64\n";
        //$msg_body .= "Content-disposition: attachment; filename=\"$attach_name\"\n\n";
        //$msg_body .= "$encoded_attach\n";
        $msg_body .= "--Message-Boundary--\n";

        mail($to, stripslashes($assunto), $msg_body, $mailheaders);           
        
    }

}

?>
