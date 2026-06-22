<?
session_start();
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

?>
<!DOCTYPE html>

<html lang="pr">
    					
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM - Login</title>

    <!-- Custom fonts for this template-->
    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../inc/css/themas/sb-admin-2.min.css" rel="stylesheet">
	
    <?require_once '../inc/php/scripts.php';?>
</head>  
<script src="login_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script> 
<style>
	.logo{
		display: flex;
	    justify-content: center;
	    align-items: center;
	    height: 25rem;
	    width: 50%;
	}
</style>
<body style="background-color:#14074F;">
    <br> <br> <br> <br> <br> <br> <br> <br>
	
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
		
            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="logo align="center">
								<img src="https://gepros.com.br/comercial/condominios/img/nlogo.png" width="70%" >                                
							</div>                            
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div >
                                        <h1 class="h4 text-gray-900 mb-4">Bem Vindo!</h1>
                                    </div>
                                   <form id="form" class="user"> 
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="ds_login" name="ds_login" placeholder="Insira Login...">
											 <div align="center" id="alert_login" style="display:none">
												<span style="color: red">Por favor o informe Login</span>
											</div>
										</div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="ds_senha" name="ds_senha" placeholder="Password">
											 <div align="center" id="alert_senha" style="display:none">
												<span style="color: red">Por favor a informe Senha</span>
											</div>
										</div>
                                        <!--<div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>-->
                                        
										<button class="btn btn-primary btn-user btn-block" id="cmdEnviar">Login</button>                                   
										
										<hr>
										<!--<div class="row">
											<div class="col" align="right" >
												Interno
											</div> 
										</div>-->
										<!--<div class="row">
											<div class="col" align="right" style="font-size:12px;">
												<label><span id="ds_versao"></span></label>
											</div>               
										</div> -->
									
									</form>
                                    
                                    <!--<div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>-->
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>