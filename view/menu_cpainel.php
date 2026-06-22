<?php
include "../inc/php/header.php";
$token = $_REQUEST['token'];
?>



<div class="container">  

    <div class="row">
        <div class="col-sm">
            <h3>Cpainel</h3> 
        </div>
    </div>  
    <div class="row">
        <div class="container" >
            <div class="modal-content" style="box-shadow: 2px 2px 5px grey;">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm"> 
                           <h5><b>Permissões de acesso / Módulos</b></h5>                          
                           <a href="javascript: abrirMenu('modulo_res_form.php');">    
                               <div class="text-left">
                                   <p><i class="fa fa-cogs" style="font-size: 20px;"></i> Módulos do Sistema</p> 
                               </div>  
                           </a>   
                           <a href="javascript: abrirMenu('grupo_res_form.php');">  
                               <div class="text-left">
                                   <p><i class="fa fa-users" style="font-size: 20px;"></i> Grupo de usuários</p> 
                               </div>
                           </a>  
                       </div>                        
                       <div class="col-sm"> 
                          
                       </div>
                       <div class="col-sm"> 
                          
                       </div>
                   </div>                                            
                    <div class="row">
                       <div class="col-sm"> 
                           <h5><b>Migração</b></h5>                          
                           <a href="javascript: abrirMenu('migracao_50_75.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-users" style="font-size: 15px;"></i> Migração Status</p> 
                               </div>
                           </a> 
                       </div>                        
                       <div class="col-sm"> 
                          
                       </div>
                       <div class="col-sm"> 
                          
                       </div>
                   </div>                                            
                </div>
            </div>                     
        </div>
    </div>    
</div>    


<?php
include "../inc/php/footer.php";
?>
