<script src="http://leandrolisura.com.br/wp-content/uploads/2017/07/printThis.js"></script>
<style type="text/css">
    .starter-template {
        padding: 40px 15px;
        text-align: center;
    }
    .printable {
        display: none;
    }
    /* print styles*/
    @media print {
        .printable {
            display: block;
        }
        .screen {
            display: none;
        }
    }
</style>
<div class="container">    
    <div class="modal fade bd-example-modal-lg" id="janela_impressao" data-backdrop='static'>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Impressão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <br>                    
                <div class="modal-content bd-example-modal-lg-12">
                    <div class="modal-body" >    
                        <div class='container' id='exibir_informativo_agenda'>  
                            <div class='row'> 
                                <div class='container'> 
                                    <div class='modal-content'> 
                                        <div class='modal-content'>

                                            <div class='modal-body' style='box-shadow: 2px 2px 5px grey;'> 
                                                <div class='row'>  
                                                    <div class='col-md-6'>                            
                                                        <i aria-hidden='true' style='font-size: 25px;' > 
                                                            Proposta Comercial
                                                        </i>  
                                                    </div>             
                                                </div> 
                                                <hr> 
                                                <br> 
                                                <div class='row'>    
                                                    <div class='col-md-12'>  

                                                    </div>                    	 
                                                </div> 
                                                <div class='row'>
                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">Empresa:</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div id='ds_empresa_imp'></div>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">AC:</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div id='ds_contato_imp'></div>
                                                    </div>
                                                </div>
                                                <div class='row'>     
                                                    <div class='col-md-9' align='right'>  
                                                       São Paulo
                                                    </div>      	 
                                                    <div class='col-md-3' id="ds_data_hoje" align='left'> 
                                                    </div>      	 
                                                </div> 
                                                <p> 
                                                </p> 
                                                <div class='row'>    
                                                    <div class='col-md-12' align='center'>  
                                                        <b>Proposta Comercial <div id='ds_operadora_impressao'></div>
                                                        </b>                                
                                                    </div>                	 
                                                </div> 
                                                <hr> 
                                                <br> 
                                                <div class='row'> 
                                                    <div class='col-md-12'> 
                                                        <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblPropostaItensImprimir'> 
                                                            <thead> 
                                                                <tr> 
                                                                    <th>
                                                                       CÓD
                                                                    </th> 
                                                                    <th>
                                                                        Prod/Serv 
                                                                    </th> 
                                                                    <th>
                                                                        Qtde.Prod 
                                                                    </th> 
                                                                    <th>
                                                                        Vl. Unitarios 
                                                                    </th> 
                                                                    <th>
                                                                        Vl. Total 
                                                                    </th> 
                                                                </tr> 
                                                            </thead> 
                                                            <tbody>                                             
                                                            </tbody> 
                                                            <tfoot> 
                                                                <tr> 
                                                                    <th colspan='3'>&nbsp; 
                                                                    </th>                                                 
                                                                    <th> 
                                                                        <div id='qtde_itens_proposta_imp'> 
                                                                        </div> 
                                                                    </th>                                                  
                                                                    <th> 
                                                                        <div id='vl_total_proposta_imp'> 
                                                                        </div> 
                                                                    </th>  
                                                                </tr> 
                                                            </tfoot>    
                                                        </table> 
                                                    </div> 
                                                </div>    
                                                <div class='row'>    
                                                    <div class='col-md-12'  align='center'>  
                                                        <div class='row' > 
                                                            <div class='col-md-6'>
                                                                &nbsp; 
                                                            </div> 
                                                            <div class='col-md-2'> 
                                                                &nbsp;
                                                            </div> 
                                                            <div class='col-md-2'>
                                                                &nbsp; 
                                                            </div> 
                                                            <div class='col-md-2'>
                                                                &nbsp; 
                                                            </div> 
                                                        </div>                         
                                                    </div>                	 
                                                </div> 
                                                <hr> 
                                                <br>   
                                                <div class='row'>    
                                                    <div class='col-md-3'>  
                                                    Consultor: 
                                                    </div>      	 
                                                    <div class='col-md-3' id="ds_responsavel_imp">  
                                                    </div>      	 
                                                </div>           
                                                <div class='row'>    
                                                    <div class='col-md-3'>  
                                                        E-mail:
                                                    </div> 
                                                    <div class='col-md-3' id="ds_email_imp">  
                                                    </div>                                     
                                                </div>  
                                                <div class='row'>    
                                                    <div class='col-md-3'>  
                                                        Telefone:
                                                    </div>
                                                    <div class='col-md-3' id="ds_tel_imp">  
                                                    </div>                                    
                                                </div>  
                                                <hr> 
                                                <br>
                                                <div class="modal-footer">
                                                    <button type="button" align="right" class="btn btn-primary" id="btnImprimirModal">Imprimir</button>
                                                </div>
                                            </div> 
                                        </div> 
                                    </div>      
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="printable"></div>
                <br>
            </div>  
        </div> 
    </div>
</div>

