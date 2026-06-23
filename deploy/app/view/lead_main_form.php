<?php
include_once "../inc/php/header.php";
?>

<script src="lead_main_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
</style>
<div id="loader"></div>
<div class="container col-sm-8" id="exibir" style="display:none">
    
        <div class="row">
        <div class="col-md-12">
            <h3 style="display: inline-block;">Leads</h3>
            <button type="button" class="btn btn-primary btn-sm" id="cmdVoltar" style="float: right; margin-top: 10px;">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Retornar a Lista
            </button>
            <hr>
        </div>
    </div>
    <div class="modal-content " >
        <div class="modal-body" style="box-shadow: 2px 2px 5px grey;">
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
            <br>
            <div class="tab-content" id="myTabContent">
                <!--div class='row'>
                    <div class='col-md-3' align="center " style="color: #007bff">
                        &nbsp;<i class="fas fa-info-circle status_lead" ></i>
                    </div>
                </div-->
                <br>
                <div class="tab-pane fade show active" align="left" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>ID Lead: </b></label>
                        </div>
                        <div class='col-md-2'>
                            <div class=' leads_pk_cad'></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-8'>
                            <label >Polo:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_polo' name='ds_polo' ></div>
                            <input type='hidden' class='form-control form-control-sm' id='polos_pk' name='polos_pk' disabled >
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-3'>
                            <label >Tipo Pessoa:&nbsp;</label>
                            <div class='form-control form-control-sm' id='tipo_pessoa_pk' name='tipo_pessoa_pk' ></div>

                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-8'>
                            <label >Lead:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_lead' name='ds_lead' ></div>
                        </div>
                    </div>

                    
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='ds_razao_social'>Razão Social:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_razao_social' name='ds_razao_social' ></div>

                        </div>
                        <div class='col-md-3'>
                            <label for='ds_cpf_cnpj'>Cpf/Cnpj:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_cpf_cnpj' name='ds_cpf_cnpj' ></div>

                        </div>
                        <div class='col-md-2'>
                            <label for='ds_ie'>IE :&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_ie' name='ds_ie' ></div>

                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-3'>
                            <label for='ds_rg'>Rg:&nbsp;</label>                    
                            <div class='form-control form-control-sm' id='ds_rg' name='ds_rg' ></div>
                        </div>
                        <div class='col-md-3'>
                            <label for='ds_cnae'>Cnae:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_cnae' name='ds_cnae' ></div>

                        </div>
                        <div class='col-md-3'>
                            <label for='ds_cnae'>Mailing:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_mailing' name='ds_mailing' ></div>
                       </div>
                    </div>   
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='ds_site'>Site:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_site' name='ds_site' ></div>

                        </div>                    
                        <div class='col-md-2'>
                            <label for='ic_cliente'>Cliente:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_cliente' name='ds_cliente' ></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-4'>
                            <label for='grupos_pk'>Ciclo Uso: </label>
                            <div class='form-control form-control-sm' id='ciclo_uso' name='ciclo_uso'></div>
                       </div>
                        <div class='col-md-4'>
                            <label for='usuarios_pk'>Log: </label>
                            <div class='form-control form-control-sm' id='ds_log' name='ds_log'></div>
                       </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-8'>
                            <label for='ds_obs'>Observação:&nbsp;</label>
                            <div class='form-control form-control-sm' id='ds_obs' name='ds_obs' ></div>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Responsável</h5>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class='col-md-12'>
                            <button type="button" id="btn_modal" class="btn btn-secondary" >Novo Responsável</button>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="ic_grid">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblResponsavel">
                                <thead >
                                    <tr>
                                        <th>Código</th>   
                                        <th>Perfil_pk</th>   
                                        <th>Responsável_pk</th>     
                                        <th>Perfil</th>   
                                        <th>Responsável</th>     
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container">
                        <form id="form_lead_responsavel" class="form">
                        <!-- Inicio janeja modal para edicao do registro -->
                        <div class="modal fade bd-example-modal-lg" id="janela_responsavel" data-backdrop='static'>
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="janela_responsavelLabel">Novo Responsavel</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type='hidden' class='form-control form-control-sm'  id='lead_responsavel_pk' name='lead_responsavel_pk'>
                                        <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>

                                        <div class="row">
                                            <div class='col-md-4'>
                                                <label for='grupos_pk'>Perfil: </label>
                                                <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk' required>
                                                    <option></option>
                                                </select>
                                           </div>
                                            <div class='col-md-4'>
                                                <label for='usuarios_pk'>Responsável: </label>
                                                <select class='form-control form-control-sm'  id='usuarios_pk' name='usuarios_pk' required>
                                                    <option></option>
                                                </select>
                                           </div>
                                        </div>
                                        <br>                                              
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn" id="cmdEnviarResponsavel"  name="cmdEnviarResponsavel">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>            
                    </form>
                    </div>
                    <br>
                    <div class="row">
                       <div class="col-md-12" align="center">
                           <button type="button" class="btn" id="cmdEditarLead">Editar Lead</button>
                       </div>
                   </div> 

                </div>                 
                <div class="tab-pane fade" id="telefones" role="tabpanel" aria-labelledby="telefones-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Telefone</h5>
                        </div>
                    </div>  
                    <br>
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>ID Lead: </b></label>
                        </div>
                        <div class='col-md-2'>
                            <div class=' leads_pk_cad'></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>Polo: </b></label>
                        </div>
                        <div class='col-md-3'>
                            <div class=' ds_polo_cad'></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>Tipo Pessoa: </b></label>
                        </div>
                        <div class='col-md-2'>
                            <div class=' ds_tipo_pessoa_cad'></div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="form-group">
                            <label class="col-md-12 control-label"><b>Lead: </b></label>
                        </div>
                        <div class='col-md-2'>
                            <div class=' ds_lead_cad'></div>
                        </div>
                    </div>
                    <br>
                     <div class='row'>
                        <div class='col-md-12'>
                            <button type="button" id="btn_modal_telefone" class="btn btn-secondary" >Incluir Telefone</button>
                        </div>
                    </div>
                    <div id="exibir_telefone" style="display:none">
                        <div class="row" id="ic_grid">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblTelefone">
                                    <thead >
                                        <tr>
                                        <th>Código</th>
                                        <th>Tipo Fone_pk</th>   
                                        <th>Tipo Fone</th>   
                                        <th>Tel</th>    
                                        <th>ic_status</th>     
                                        <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>      
                    </div>      
                    <?include("inc_telefone_cad_form.php");?>
                   </div> 
                    <!--Enderecos-->
                   <div class="tab-pane fade" id="enderecos" role="tabpanel" aria-labelledby="endereco-tab">
                       <div class="row">
                            <div class="col-md-12">
                                <h5>Endereço</h5>
                            </div>
                        </div>
                       <br>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>ID Lead: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' leads_pk_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Polo: </b></label>
                            </div>
                            <div class='col-md-3'>
                                <div class=' ds_polo_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Tipo Pessoa: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' ds_tipo_pessoa_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Lead: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' ds_lead_cad'></div>
                            </div>
                        </div>
                        <br>
                        <div class='row'>
                            <div class='col-md-12'>
                                <button type="button" id="btn_modal_endereco" class="btn btn-secondary" >Incluir Endereço</button>
                            </div>
                        </div>
                        <div id="exibir_endereco" style="display:none">
                            <div class="row" id="ic_grid">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap " style="width:90%" id="tblEndereco">
                                        <thead >
                                            <tr>
                                            <th>Código</th>
                                            <th>CEP</th>
                                            <th>Endereço</th>
                                            <th>Cidade</th>
                                            <th>UF</th>
                                            <th>Numero</th>
                                            <th>Complemento</th>
                                            <th>Bairro</th>
                                            <th>Tipo Endereço</th>
                                            <th>Tipo Endereço_pk</th>
                                            <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>                
                        </div>                
                        <!--MODAL ENDEREÇO-->
                        <?include("inc_endereco_cad_form.php");?>
                   </div>   
                   <!--Contatos-->
                   <div class="tab-pane fade" id="contatos" role="tabpanel" aria-labelledby="contatos-tab">
                       <div class="row">
                            <div class="col-md-12">
                                <h5>Contatos</h5>
                            </div>
                        </div>
                        <br>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>ID Lead: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' leads_pk_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Polo: </b></label>
                            </div>
                            <div class='col-md-3'>
                                <div class=' ds_polo_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Tipo Pessoa: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' ds_tipo_pessoa_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Lead: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' ds_lead_cad'></div>
                            </div>
                        </div>
                        <br>
                        <div class='row'>
                            <div class='col-md-12'>
                                <button type="button" id="btn_modal_contato" class="btn btn-secondary" >Incluir Contato</button>
                            </div>
                        </div>
                        <div id="exibir_contato" style="display:none">
                            <div class="row" id="ic_grid">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblLeadContatos">
                                        <thead >
                                            <tr>
                                            <th>Código</th>
                                            <th>Contato</th>
                                            <th>Email</th>
                                            <th>Cel</th>
                                            <th>Whatsapp</th>
                                            <th>ic_whatsapp</th>
                                            <th>Tel</th>
                                            <th>Função</th>
                                            <th>cargos_pk</th>
                                            <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?include("inc_contato_cad_form.php");?>                
                   </div>           
                    <div class="tab-pane fade" id="operador" role="tabpanel" aria-labelledby="operador-tab">
                       <div class="row">
                            <div class="col-md-12">
                                <h5>Operador</h5>
                            </div>
                        </div>
                        <br>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>ID Lead: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' leads_pk_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Polo: </b></label>
                            </div>
                            <div class='col-md-3'>
                                <div class=' ds_polo_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Tipo Pessoa: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' ds_tipo_pessoa_cad'></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group">
                                <label class="col-md-12 control-label"><b>Lead: </b></label>
                            </div>
                            <div class='col-md-2'>
                                <div class=' ds_lead_cad'></div>
                            </div>
                        </div>
                        <br>
                        <div class='row'>
                            <div class='col-md-12'>
                                <button type="button" id="btn_modal_lead_operador" class="btn btn-secondary" >Incluir Operador</button>
                            </div>
                        </div>
                        <div id="exibir_operadoras" style="display:none">
                            <div class="row" id="ic_grid">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap " style="width:80%" id="tblLeadOperador">
                                        <thead >
                                            <tr>
                                            <th>Cód</th>
                                            <th>Operador</th>
                                            <th>Operador_pk</th>
                                            <th>Classificação_pk</th>
                                            <th>Classificação</th>
                                            <th>Cliente</th>
                                            <th>icCliente</th>
                                            <th>Base</th>
                                            <th>icBase</th>
                                            <th>Dt.Ativação</th>
                                            <th>Dt.Venc.</th>
                                            <th>Custo Atual</th>
                                            <th>Qtde. Voz</th>
                                            <th>Qtde. Dados</th>
                                            <th>Status</th>
                                            <th>icStatus</th>
                                            <th>Tempo Contrato (Meses)</th>
                                            <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <form id="form_lead_operador" class="form">
                            <!-- Inicio janeja modal para edicao do registro -->
                            <div class="modal fade bd-example-modal-lg" id="janela_lead_operador" data-backdrop='static'>
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="janela_leadOPeradorLabel">Novo Operador</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <input type='hidden' class='form-control form-control-sm'  id='lead_operador_pk' name='lead_operador_pk'>
                                            <input type='hidden' class='form-control form-control-sm'  id='ds_operador_lead' name='ds_operador_lead'>
                                            <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>

                                            <div class="row">
                                                <div class='col-md-4'>
                                                    <label for='operador_pk'>Operadora : </label>
                                                    <select class='form-control form-control-sm'  id='operador_pk' name='operador_pk' required>
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class='col-md-4'>
                                                    <label for='ic_cliente_operador'>Cliente: </label>
                                                    <select class='form-control form-control-sm'  id='ic_cliente_operador' name='ic_cliente_operador'>
                                                        <option value=""></option>
                                                        <option value="1">Sim</option>
                                                        <option value="2">Não</option>
                                                    </select>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label for='ic_base'>Base: </label>
                                                    <select class='form-control form-control-sm'  id='ic_base' name='ic_base'>
                                                        <option value=""></option>
                                                        <option value="1">Sim</option>
                                                        <option value="2">Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class='col-md-4'>
                                                    <label for='dt_ativacao'>Data ativação: </label>
                                                    <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_ativacao' name='dt_ativacao'>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label for='dt_vencimento'>Data vencimento: </label>
                                                    <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_vencimento' name='dt_vencimento'>
                                                </div>    
                                            </div>
                                            <div class="row">
                                                <div class='col-md-4'>
                                                    <label for='ds_custo_atual'>Custo atual: </label>
                                                    <input type='text' class='form-control form-control-sm' id='ds_custo_atual' name='ds_custo_atual'>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label for='ds_qtde_voz'>Quantidade voz: </label>
                                                    <input type='text' class='form-control form-control-sm'  id='ds_qtde_voz' name='ds_qtde_voz'>
                                                </div>    
                                                <div class='col-md-4'>
                                                    <label for='ds_qtde_dados'>Quantidade dados: </label>
                                                    <input type='text' class='form-control form-control-sm'  id='ds_qtde_dados' name='ds_qtde_dados'>
                                                </div>    
                                            </div>
                                            <div class="row">
                                                <div class='col-md-4'>
                                                    <label for='classificacao_pk'>Classificação : </label>
                                                    <select class='form-control form-control-sm'  id='classificacao_pk' name='classificacao_pk'>
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class='col-md-4'>
                                                    <label for='ic_status_operador'>Tempo Contrato (Meses): </label>
                                                    <select class='form-control form-control-sm'  id='tempo_contrato_pk' name='tempo_contrato_pk'>
                                                        <option></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                        <option value="32">32</option>
                                                        <option value="33">33</option>
                                                        <option value="34">34</option>
                                                        <option value="35">35</option>
                                                        <option value="36">36</option>
                                                        <option value="37">37</option>
                                                        <option value="38">38</option>
                                                        <option value="39">39</option>
                                                        <option value="40">40</option>
                                                        <option value="41">41</option>
                                                        <option value="42">42</option>
                                                        <option value="43">43</option>
                                                        <option value="44">44</option>
                                                        <option value="45">45</option>
                                                        <option value="46">46</option>
                                                        <option value="47">47</option>
                                                        <option value="48">48</option>
                                                        <option value="49">49</option>
                                                        <option value="50">50</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class='col-md-4'>
                                                    <label for='ic_status_operador'>Status: </label>
                                                    <select class='form-control form-control-sm'  id='ic_status_operador' name='ic_status_operador'>
                                                        <option value="1">Ativo</option>
                                                        <option value="2">Desativado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>                                                    
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn" id="cmdEnviarLeadOperador"  name="cmdEnviarLeadOperador">Enviar</button>
                                        </div>
                                    </div>
                                </div>  
                        </div>            
                        </form>
                        </div>
                             <!--CHAMADA LEAD OPERADOR ESTÁ NA TELA DE OCORRENCIAS POR CONTA DA ATUALIZACAO DO SEM INTERESSE-->          
                   </div>           
            </div> 
        </div>
    </div>        
    <hr><br>
    
    <div class="row">
        <div class="col-md-12" >
            <h5><i class="fa fa-angle-down" aria-hidden="true" style="font-size: 30px;"  onclick="fcExibirOc()"></i> &nbsp;Ocorrência(s)</h5>
        </div>
    </div>
    <hr>
    <div id="exibir_oc" style="display:none">
        <?php  include("inc_ocorrencia_res_form.php"); ?>
    </div>
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <h5><i class="fa fa-angle-down" aria-hidden="true" style="font-size: 30px;"  onclick="fcExibirProcesso()"></i> &nbsp;Processo(s) Comercial</h5>
        </div>
    </div>
    <div id="exibir_processo" style="display:none">
        <div class='row'>
            <div class='col-md-12'>
                <button type="button" class="btn btn-secondary" id="cmdIncluirProcesso">Incluir Processo Comercial</button>
            </div>
        </div>
        <br>
        <div class="row" >
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblProcessos" >
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Data Início</th>
                            <th>Data Fim</th>
                            <th>Data Cancelamento</th>
                            <th>Processo</th>
                            <th>Classificação</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
    </div>
    <form id="form_processo" class="form">
        <div class="modal fade bd-example-modal-lg" id="janela_processos" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for='processos_pk'>Processo Comercial:&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='processos_pk' name='processos_pk'/>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn" id="cmdEnviarProcesso"  name="cmdEnviarProcesso">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="janela_processos_cancelamento" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <input type="hidden" id="processos_cancelamento_pk">
                                    <label for='motivo_cancelamento_processo_pk'>Motivo Cancelamento:&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='motivo_cancelamento_processo_pk' name='motivo_cancelamento_processo_pk'/>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class='col-md-4'>
                                    &nbsp;                                             
                                </div>
                                <div class='col-md-6'>
                                    <label for='ds_motivo_cancelamento'>Descrição Motivo Cancelamento&nbsp;</label>
                                     <textarea class=" form-control form-control-file" id="ds_motivo_cancelamento" name="ds_motivo_cancelamento"></textarea>
                                </div>
                            </div>
                            <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn" id="cmdEnviarCancelamento"  name="cmdEnviarCancelamento">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    

    <hr>
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <h5><i class="fa fa-angle-down" aria-hidden="true" style="font-size: 30px;"  onclick="fcExibirDocumeto()"></i> &nbsp;Documento(s)</h5>
        </div>
    </div>
    <div id="exibir_documento" style="display:none">
        <div class='row'>
            <div class='col-md-12'>
                <button type="button" class="btn btn-secondary" id="cmdIncluirDocumento">Incluir Documento</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblDocumentos">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Documento</th>
                            <th>Observação</th>
                            <th>Nome Original</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
    </div>
    

    <div class="modal fade bd-example-modal-lg" id="janela_documentos" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Novo Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-8'>
                            <span class="btn btn-success fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Escolha o Arquivo</span>
                                <input id="fileupload"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php?token=<?=$token?>">

                            </span>
                            <br>
                            <div id="alert_documento" style="display:none" >
                                <strong style="color: red">Selecione um arquivo</strong>
                            </div>
                            <br>
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <div id="files" class="files"></div>
                            <!---->
                            <div class="row" id="rowFotos"></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            &nbsp;
                        </div>
                        <div class="col-md-8">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblArquivos">
                                <thead>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Nome Original</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            &nbsp;
                        </div>

                        <div class='col-md-6'>
                            <label for='ds_obs_doc'>Observação: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_obs_doc' name='ds_obs_doc'>
                            <input type="hidden" name="ds_nome_original" id="ds_nome_original"/>
                            <input type="hidden" name="ds_documento" id="ds_documento"/>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn" id="cmdEnviarDocumento"  name="cmdEnviarDocumento">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <hr>
</div>

<?php
include_once "../inc/php/footer.php";
?>
