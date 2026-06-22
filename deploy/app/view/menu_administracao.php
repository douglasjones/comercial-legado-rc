<?php
include "../inc/php/header.php";
$token = $_REQUEST['token'];
?>
<div class="container">  
    <div class="row">
        <div class="col-sm">
            <h3>Administração</h3> 
        </div>
    </div>  
    <div class="row">
        <div class="container">
            <div class="modal-content" style="box-shadow: 2px 2px 5px grey;">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm"> 
                           <h5><b>Conta / Polo(s)</b></h5> 
                           <a href="javascript: abrirMenu('conta_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-user-circle" aria-hidden="true" style="font-size: 15px;"></i> Conta</p> 
                               </div>  
                           </a>   
                           <a href="javascript: abrirMenu('polo_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-sitemap" style="font-size: 15px;"></i> Polos</p> 
                               </div>
                           </a>  
                       </div>                        
                       <div class="col-sm"> 
                           <h5><b>Usuarios / Equipes </b></h5> 
                           <a href="javascript: abrirMenu('usuario_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-user" style="font-size: 15px;"></i>  Usuários</p> 
                               </div>  
                           </a> 
                           
                           <a href="javascript: abrirMenu('equipe_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-users" style="font-size: 15px;"></i> Equipes</p> 
                               </div>
                           </a> 
                       </div>
                       <div class="col-sm"> 
                           <h5><b> Logs</b></h5>                                           
                            
                               <div class="text-left">
                                   <p><i class="fa fa-clone" style="font-size: 15px;"></i> Log</p> 
                               </div>                
                            
                       </div>
                   </div>                                            
                </div>
            </div>             
        </div>
    </div>    
</div>    
<br>
<div class="container">  
    <div class="row">
        <div class="col-sm">
            <h4>Config Operacional </h4> 
        </div>
    </div>  
    <div class="row">
        <div class="container">
            <div class="modal-content" style="box-shadow: 2px 2px 5px grey;">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm"> 
                           <h5><b>Processos</b></h5>
                            <a href="javascript: abrirMenu('processo_default_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-cog" style="font-size: 15px;"></i> Processo</p> 
                               </div>  
                           </a>                             
                       </div>                        
                       <div class="col-sm"> 
                           <h5><b>Tipos OC</b> </h5>
                            <a href="javascript: abrirMenu('tipo_ocorrencia_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-list" style="font-size: 15px;"></i> Tipos de OC</p> 
                               </div>  
                            </a>                            
                       </div>
                       <div class="col-sm"> 
                           <h5><b>Produtos e Serviços </b></h5>
                            <a href="javascript: abrirMenu('produto_servico_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-network-wired" style="font-size: 15px;"></i> Produtos</p> 
                               </div> 
                           </a>                            
                                                           
                       </div>
                   </div>     
                   <div class="row">
                       <div class="col-sm"> 
                           <h5><b>Operadores</b></h5>
                           <a href="javascript: abrirMenu('operador_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-list" style="font-size: 15px;"></i> Operador</p> 
                               </div> 
                           </a>     
                                            
                       </div>                        
                       <div class="col-sm"> 
                          &nbsp;                         
                       </div>
                       <div class="col-sm"> 
                           &nbsp;
                       </div>
                   </div>  
                </div>
            </div>             
        </div>
    </div>    
</div>
<br>
<div class="container">  
    <div class="row">
        <div class="col-sm">
            <h4>Operacional </h4> 
        </div>
    </div>  
    <div class="row">
        <div class="container">
            <div class="modal-content" style="box-shadow: 2px 2px 5px grey;">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-sm"> 
                           <h5><b>Mailing / Cargas</b></h5>
                            <a href="javascript: abrirMenu('mailing_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-book" style="font-size: 15px;"></i> Mailing</p> 
                               </div>  
                           </a>        
                            <a href="javascript: abrirMenu('carga_lead_res_form.php');">
                               <div class="text-left">
                                   <p><i class="fa fa-share" style="font-size: 15px;"></i> Carga Lead</p> 
                               </div>  
                           </a>        
                           <a href="javascript: abrirMenu('transferencia_lead.php');">
                               <div class="text-left">
                           
                                   <p><i class="fa fa-arrow-left" style="font-size: 15px;"></i><i class="fa fa-arrow-right" style="font-size: 15px;"></i> Transferencia de Leads</p> 
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
