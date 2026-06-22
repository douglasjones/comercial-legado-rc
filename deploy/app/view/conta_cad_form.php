<?
include_once "../inc/php/header.php";
?>

<script src="conta_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    
    <div class="row">
        <div class="col-md-12">
            <h3>Conta</h3>
            <hr>
        </div>
    </div>
    <form id="form" class="form">
        <input type='hidden' class='form-control form-control-sm'  id='pk' name='pk'>
        <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
        <div class='row'>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>       
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dados-tab" data-toggle="tab" href="#dados" role="tab" aria-controls="dados" >Dados Cadastrais</a>
            </li> 
            <!--<li class="nav-item">
                <a class="nav-link" id="cobranca-tab" data-toggle="tab" href="#cobranca" role="tab" aria-controls="cobranca" >Dados de Cobrança</a>
            </li>        -->
        </ul> 
        
        <div class="tab-content" id="myTabContent">            
           <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">                
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-3'>
                            <label for='ds_lead'>Tipo Pessoa:&nbsp;</label>
                           <select id="ds_tipo_pessoa" class="form-control form-control-sm" name="ds_tipo_pessoa" required>
                                 <option value=""></option>
                                 <option value="1">PF</option>
                                 <option value="2">PJ</option>
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-8'>
                            <label for='ds_lead'>Nome da Conta:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_conta' name='ds_conta' required >
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-8'>
                            <label for='ds_razao_social'>Razão Social/Nome:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_razao_social' name='ds_razao_social' required>
                        </div>
                    </div>               

                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>                    
                        <div class='col-md-3'>
                            <label for='ds_cpf_cnpj'>CPF/CNPJ:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="18" id='ds_cpf_cnpj' name='ds_cpf_cnpj' required>
                        </div>
                        <div class='col-md-3'>
                            <label for='ds_ie'>CNAE :&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="20" id='ds_cnae' name='ds_ie' >
                        </div>
                        <div class='col-md-3'>
                           <label for='ds_ie'>RG :&nbsp;</label>
                           <input type='text' class='form-control form-control-sm' maxlength="20" id='ds_rg' name='ds_rg' >
                       </div>
                    </div>

                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-2'>
                            <label for='ds_tel_lead'>Telefone:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm'  id='ds_tel' name='ds_tel' required>
                        </div>
                        <div class='col-md-2'>
                            <label for='ds_tel_lead'>Celular:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm'  id='ds_cel' name='ds_cel' required>
                        </div>
                        <div class='col-md-4'>
                            <label for='ds_email_lead'>Email:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm'  maxlength="80" id='ds_email' name='ds_email' required>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-2'>
                            <label for='ds_cep'>CEP:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm'  maxlength="9" id='ds_cep' name='ds_cep' required>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-8'>
                            <label for='ds_endereco'>Endereço:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_endereco' name='ds_endereco'  required>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-2'>
                            <label for='ds_numero'>Número:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="10" id='ds_numero' name='ds_numero'  required>
                        </div>
                        <div class='col-md-3'>
                            <label for='ds_complemento'>Complemento:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="10" id='ds_complemento' name='ds_complemento'  >
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-3'>
                            <label for='ds_bairro'>Bairro:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="45" id='ds_bairro' name='ds_bairro'  required>
                        </div>
                        <div class='col-md-3'>
                            <label for='ds_cidade'>Cidade:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="45" id='ds_cidade' name='ds_cidade'  required>
                        </div>

                        <div class='col-md-2'>
                            <label for='ds_uf'>UF:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='ds_uf' name='ds_uf' required>
                                <option></option>
                                <option>AC</option>
                                <option>AL</option>
                                <option>AP</option>
                                <option>AM</option>
                                <option>BA</option>
                                <option>CE</option>
                                <option>DF</option>
                                <option>ES</option>
                                <option>GO</option>
                                <option>MA</option>
                                <option>MT</option>
                                <option>MS</option>
                                <option>MG</option>
                                <option>PA</option>
                                <option>PB</option>
                                <option>PR</option>
                                <option>PE</option>
                                <option>PI</option>
                                <option>RJ</option>
                                <option>RN</option>
                                <option>RS</option>
                                <option>RO</option>
                                <option>RR</option>
                                <option>SC</option>
                                <option>SP</option>
                                <option>SE</option>
                                <option>TO</option>
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                       <div class='col-md-2'>
                           &nbsp;
                       </div>
                       <div class='col-md-2'>
                           <label for='dt_inicio'>Dt Ativação: </label>
                           <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_ativacao' name='dt_ativacao'>
                       </div>
                       <div class='col-md-2'>
                           <label for='dt_inicio'>Dt Cancelamento: </label>
                           <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_cancelamento' name='dt_cancelamento'>
                       </div>
                       <div class='col-md-3'>
                           <label for='dia_vencimento'>Status:&nbsp;</label>
                           <select id="ic_status" class="form-control form-control-sm" name="ic_status" >
                               <option value="1">Ativo</option>
                               <option value="2">Desativado</option>
                          </select>
                       </div> 
                   </div> 
                 
            </div>
            
            <!--Cobranças-->
            <!--<div class="tab-pane fade" id="cobranca" role="tabpanel" aria-labelledby="cobranca-tab">
                <input type='hidden' class='form-control form-control-sm'  id='contas_dados_cobranca_pk' name='contas_dados_cobranca_pk'>
                <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                <div class='row'>
                    <div class="col-md-12">
                        &nbsp;
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='planos_pk'>Planos:&nbsp;</label>
                        <select id="planos_pk" class="form-control form-control-lg" name="planos_pk" >
                            <option value=""></option>   
                       </select>
                    </div>     
                </div> 
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='dia_vencimento'>Dia Vencimento:&nbsp;</label>
                        <select id="dia_vencimento" class="form-control form-control-lg" name="dia_vencimento" >
                            <option value=""></option>
                            <option value="1">01</option>
                            <option value="5">05</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                       </select>
                    </div>  
                    <div class='col-md-3'>
                        <label for='tipo_pagamentos_pk'>Tipo Pagamento:&nbsp;</label>
                        <select id="tipo_pagamentos_pk" class="form-control form-control-lg" name="tipo_pagamentos_pk" >
                            <option value=""></option>
                            <option value="1">Boleto</option>
                            <option value="2">Cartão de Credito</option>                
                       </select>
                    </div>   
                </div>  
                <div id="pg_cartao">
                    <div class='row' >
                        <div class='col-md-2'>
                            &nbsp;
                        </div> 
                         <div class='col-md-3'>
                             <label for='bandeira_cartao_pk'>Bandeira Cartão:&nbsp;</label><br>
                             <input type="radio" id="bandeira_cartao_pk" name="bandeira_cartao_pk" value="1"> Visa  &nbsp;<input type="radio" id="bandeira_cartao_pk" name="bandeira_cartao_pk" value="2"> Master 
                        </div>            
                    </div>   
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div> 
                        <div class='col-md-3'>
                            <label for='n_cartao'>Número do Cartão:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="100" id='n_cartao' name='n_cartao' required >
                        </div>
                        <div class='col-md-2'>
                            <label for='ds_vencimento_cartao'>Vencimento Cartão:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_vencimento_cartao' name='nds_vencimento_cartao' required >           
                        </div>
                    </div>    
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-8'>
                             <label for='ds_nome_cartao'>Nome no Cartão:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_nome_cartao' name='ds_nome_cartao' >
                        </div>     
                    </div>
                </div>         
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ds_email_financeiro'>E-mail cobrança:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_email_financeiro' name='ds_email_financeiro' >
                    </div>
                </div>
            </div>  -->
            <div class="row">
                <div class="col-md-12" align="center">
                    <hr>
                    <button type="submit" class="btn" id="cmdEnviar">Enviar</button>
                    &nbsp;
                    <button type="button" class="btn" id="cmdCancelar">Cancelar</button>
                </div>
            </div>
        </div>    
    </form>
</div>
        
<?
include_once "../inc/php/footer.php";
?>
