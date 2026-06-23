<?
include_once "../inc/php/header.php";
?>
<script src="lead_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
<div class="container" id="exibir" style="display:none">
    <div class="row">
        <div class="col-md-12">
            <h3 style="display: inline-block;">Pesquisa - Leads</h3>
            <button type="button" class="btn btn-primary btn-sm" id="cmdVoltarLista" style="display:none; float: right; margin-top: 10px;">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Retornar a Lista
            </button>
            <input type="hidden" class="form-control form-control-sm" id="usuario_logado_pk">
        </div>
    </div>
    <form method="post">
        <br>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label cfor="Nome">Polo</label>
                <select class='form-control form-control-sm'  id='polos_pk' name='polos_pk' requered>                            
                    <option value=""></option>                       
                </select>                
            </div>     
            <div class='col-md-4'>
                <label  for="Nome">Tipo Pessoa</label>
                <select class='form-control form-control-sm'  id='tipo_pessoa_pk' name='tipo_pessoa_pk'>                            
                    <option value=""></option>
                    <option value="PJ">PJ</option>
                    <option value="PF">PF</option>                            
                </select>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>ID Lead:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="100" id='id_lead' name='id_lead' required >
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>Lead:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_lead' name='ds_lead' required >
            </div>
        </div>  
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>Razão Social:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_razao_social' name='ds_razao_social' required >
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>CPF/CNPJ:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_cpf_cnpj' name='ds_cpf_cnpj' required >
            </div>
        </div>  

        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>    
                <label for="Nome">Mailing:</label>
                <select  class='form-control form-control-sm'  id='mailing_pk' name='mailing_pk'>                            
                    <option value=""></option>                           
                </select>
                
            </div>
            <div class='col-md-4'>
               <!-- <label for="Nome">Equipes:</label>
                <select class='form-control form-control-sm'  id='equipes_pk' name='equipes_pk'>                            
                    <option></option>                           
                </select>-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>  
                <label  for="Nome">Perfil:</label>
                <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk'>                            
                    <option value=""></option>                           
                </select>
                
           </div>
            <div class='col-md-4'>
                <label class="bmd-label-floating" for="Nome">Responsável:</label>
                <select class='form-control form-control-sm' id='usuarios_pk' name='usuarios_pk' >                            
                    <option></option>                           
                </select>
                
           </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="Nome">Cidade:</label>
                <select class='form-control form-control-sm'  id='ds_cidade' name='ds_cidade'>                            
                    <option value=""></option>                           
                </select>
            </div>
            <div class="col-md-4">
                <label for="Nome">Cliente:</label>
                <select id="ic_status"  class="form-control form-control-sm" name="ic_status">
                    <option value=""></option>
                    <option value="1">Sim</option>
                    <option value="2">Não</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='status_processo_pk'>Status: </label>
                <select class='form-control form-control-sm'  id='status_processo_pk' name='status_processo_pk'>
                    <option value=""></option>
                    <option value="7">Sem Interesse</option>
                    <option value="6">Não Contactado</option>
                    <option value="5">Contactado</option>
                    <option value="1">25%</option>
                    <option value="2">50%</option>
                    <option value="3">75%</option>
                    <option value="8">80%</option>
                    <option value="9">90%</option>
                    <option value="4">Cliente</option>                    
                </select>
           </div>
            <div class='col-md-4'>
                <label for='ds_lead'>Qtde Dias Ult Ocorrência:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="100" id='qtde_ult_oc' name='qtde_ult_oc' required >
            </div>   
        </div> 
        
        <!--<div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>ID Processo:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="100" id='ds_processo_pk' name='ds_processo_pk' required >
            </div>
            <div class='col-md-4'>
                <label for='ds_lead'>Processo:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="100" id='processo_default_pk' name='processo_default_pk' required >
            </div>
        </div> --> 
   
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            
            <div class='col-md-4'>
                <label for='operador_pk'>Operadora : </label>
                <select class='form-control form-control-sm'  id='operador_pk' name='operador_pk' >
                    <option></option>
                </select>
            </div>
            <div class='col-md-4'>
                <label for="classificacao_operador_pk">Classificacao Operadora:&nbsp;</label>
                <select class='form-control form-control-sm'  id='classificacao_operador_pk' name='classificacao_operador_pk' requered>                            
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
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
        <p>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='qtde_linhas'>Qtde. Linhas: </label>
           </div>
            <div class='col-md-1'>
                <input type="text" class="form-control form-control-sm" id="qtde_linhas_ini" placeholder="De">  
           </div>
           <div class='col-md-1'>
                <input type="text" class="form-control form-control-sm" id="qtde_linhas_fim" placeholder="Até">  
           </div>
        </div>
        <p>
        <!--<div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='dt_ativacao'>Data de Cadastro: </label>
            </div>
            <div class='col-md-2' align="left">
                <input type="text" class="form-control form-control-sm" id="dt_cadastro_ini" placeholder="De">
           </div>
           <div class='col-md-2' align="left">
                <input type="text" class="form-control form-control-sm" id="dt_cadastro_fim" placeholder="Até">
           </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='dt_ativacao'>Ativação Contrato : </label>
            </div>
            <div class='col-md-2' align="left">
                <input type="text" class="form-control form-control-sm" id="dt_ativacao_ini" placeholder="De">
           </div>
           <div class='col-md-2' align="left">
                <input type="text" class="form-control form-control-sm" id="dt_ativacao_fim" placeholder="Até">
           </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='dt_vencimento'>Vencimento Contrato : </label>
            </div>
            <div class='col-md-2' align="left">
                <input type="text" class="form-control form-control-sm" id="dt_vencimento_ini" placeholder="De">
           </div>
           <div class='col-md-2' align="left">
                <input type="text" class="form-control form-control-sm" id="dt_vencimento_fim" placeholder="Até">
           </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='status_processo_pk'>Data Transferência: </label>
           </div>
            <div class='col-md-2'>
                <input type="text" class="form-control form-control-sm" id="dt_transf_ini"  placeholder="De">  
           </div>
           <div class='col-md-2'>
                <input type="text" class="form-control form-control-sm" id="dt_transf_fim" placeholder="Até">  
           </div>
        </div>-->
        
        <br>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><i class="fa fa-search" aria-hidden="true" style="font-size: 15px;" > Pesquisar</i></button>
                &nbsp;&nbsp;
                <button type="button" class="btn btn-link" id="cmdIncluir"><i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 15px;" > Incluir</i></button>
            </div>
        </div>
        <div class='row' id="alert" style="display:none">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-6'  >
                <strong style="color: red">Você não é responsavel por esse Lead !!!</strong>
            </div>
        </div>
    </form>
    <div class="row" id="tabela_lead" style="display:none">
        <div class="col-md-12">
            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado" >
            <thead>
                <tr>
                    <th>Cód</th>
                    <th>Lead</th>
                    <th>Resp</th>
                    <th>Qtde Linhas</th>
                    <th>Tempo Contrato</th>
                    <th>Status OC</th>
                    <th>Dt Ult OC</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
     
</div>
<?
include_once "../inc/php/footer.php";
?>
