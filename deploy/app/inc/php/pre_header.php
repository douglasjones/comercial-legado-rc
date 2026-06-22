<?php
    //recebe o token 
    $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
    //função para determinar o path dos arquivos de include.
    function encontrarMainInclude(){
        $arrURL = explode("/", $_SERVER["REQUEST_URI"]);
        $strURL = "";
        $url = "";


        $intRetorno = 0;
        for($i = (count($arrURL)-1); $i > 0; $i--){

            $strURL .= "../";
            $url = $strURL."inc/php/maininclude.php";

            //Verifica se o arquivo libs/maininclude existe;
            if(is_file($url)){
                break;
            }
        }
        return $strURL;
    }
    //Determina o caminho de todos os includes
    $strPath = encontrarMainInclude();

    define("PATH", $strPath);

    require_once PATH."inc/php/config.php";
    require_once PATH."inc/php/public.php";

    //Verifica se o login é válido.
    verificarLogin($token);
?>
<!--<body>
    <head>
        <style>
            .modal {
              text-align: center;
              padding: 0!important;
            }
            .modal:before {
              content: '';
              display: inline-block;
              height: 100%;
              vertical-align: middle;
              margin-right: -4px;
            }
            .modal-dialog {
              display: inline-block;
              text-align: left;
              vertical-align: middle;
            }
        </style>
    </head>
<body>-->
