<?
include_once "../inc/php/header.php";
?>

<script src="lead_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Leads</h2>
            <hr>
        </div>
    </div>
    <form id="form" class="form">
        <div class='row'>
            <div class="col-md-12">
                &nbsp;
                <input type="hidden" id="contas_pk" name="contas_pk"/>
            </div>
        </div>        
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dados-tab" data-toggle="tab" href="#dados" role="tab" aria-controls="dados" >Dados Cadastrais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="telefones-tab" data-toggle="tab" href="#telefones" role="tab" aria-controls="telefones" onclick="fcExibirTefelefone()">Telefones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="enderecos-tab" data-toggle="tab" href="#enderecos" role="tab" aria-controls="enderecos" onclick="fcExibirEndereco()">Endereços</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contatos-tab" data-toggle="tab" href="#contatos" role="tab" aria-controls="contatos" onclick="fcExibirContato()">Contatos</a>
            </li>  
            <li class="nav-item">
                <a class="nav-link" id="operador-tab" data-toggle="tab" href="#operador" role="tab" aria-controls="operador" onclick="fcExibirOperadoras()">Operadoras Atuais</a>
            </li>           
        </ul>        
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ds_lead'>Polo:&nbsp;</label>
                       <select class='form-control form-control-sm'  id='polos_pk' name='polos_pk' />
                            <option></option>
                        </select>                        
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ds_lead'>Lead:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_lead' name='ds_lead' required >
                    </div>
                </div>                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_lead'>Tipo Pessoa:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='tipo_pessoa_pk' name='tipo_pessoa_pk' requered>                            
                            <option value="PJ">PJ</option>
                            <option value="PF">PF</option>                            
                        </select>
                    </div>
                    
                </div>                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_razao_social'>Razão Social:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_razao_social' name='ds_razao_social' >
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cpf_cnpj'>Cpf/Cnpj:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="18" id='ds_cpf_cnpj' name='ds_cpf_cnpj' required >
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_ie'>IE :&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="20" id='ds_ie' name='ds_ie' >
                    </div>
                </div>
                      
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Rg:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="12" id='ds_rg' name='ds_rg' >
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cnae'>Cnae:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="18" id='ds_cnae' name='ds_cnae' >
                    </div>
                    
                </div>   
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ds_site'>Site:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="20" id='ds_site' name='ds_site' >
                    </div>                    
                    <div class='col-md-2'>
                        <label for='mailing_pk'>Mailing:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='mailing_pk' name='mailing_pk' />
                            <option></option>
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_cliente'>Cliente:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_cliente' name='ic_cliente' requered/>
                            <option value='2'>Não</option>
                            <option value='1'>Sim</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='grupos_pk'>Ciclo Uso: </label>
                        <textarea class='form-control form-control-sm'  id='ciclo_uso' name='ciclo_uso'></textarea>
                   </div>
                    <div class='col-md-4'>
                        <label for='usuarios_pk'>Log: </label>
                        <textarea class='form-control form-control-sm'  id='ds_log' name='ds_log'></textarea>
                   </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ds_obs'>Observação:&nbsp;</label>
                        <textarea class='form-control form-control-sm' id='ds_obs' name='ds_obs'></textarea>
                    </div>
                </div>
                 <!--GRID RESPONSAVEL-->
             <?php  include("inc_responsavel_lead_res_form.php"); ?>
              
                
                
            </div>
           
               
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
            <!--Telefones-->
            <div class="tab-pane fade" id="telefones" role="tabpanel" aria-labelledby="telefones-tab">
                <div id="exibir_telefone" style="display:none">
                    <?php  include("inc_telefone_res_form.php"); ?>
                </div>
                 
            </div> 
             <!--Enderecos-->
            <div class="tab-pane fade" id="enderecos" role="tabpanel" aria-labelledby="endereco-tab">
                <div id="exibir_endereco" style="display:none">
                    <?php  include("inc_endereco_res_form.php"); ?>
               </div>          
            </div>          

            <!--Contatos-->
            <div class="tab-pane fade" id="contatos" role="tabpanel" aria-labelledby="contatos-tab">
                <div id="exibir_contato" style="display:none">
                    <?php  include("inc_contato_res_form.php"); ?>
               </div>    
            </div>    
            <!--Operador-->
            <div class="tab-pane fade" id="operador" role="tabpanel" aria-labelledby="operador-tab">
                <div id="exibir_operadoras" style="display:none">
                    <?php  include("inc_lead_operador_res_form.php"); ?>
               </div>    
            </div>    
        <div class="row">
            <div class="col-md-12" align="center">
                <hr>
                <button type="submit" class="btn btn-secondary" id="cmdEnviar">Enviar</button>
                &nbsp;
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>
            </div>
        </div>
    </div>
    </form>
    
    
    <!--MODAL RESPONSAVEL-->
    <?include("inc_responsavel_lead_cad_form.php");?>
    <!--MODAL TELEFONE-->
    <?include("inc_telefone_cad_form.php");?>
    <!--MODAL ENDEREÇO-->
    <?include("inc_endereco_cad_form.php");?>
    
    <!--MODAL CONTATO-->
    <?include("inc_contato_cad_form.php");?>
    
    <!--MODAL OPERADOR-->
    <?include("inc_lead_operador_cad_form.php");?>
</div>
<?
include_once "../inc/php/footer.php";
?>
