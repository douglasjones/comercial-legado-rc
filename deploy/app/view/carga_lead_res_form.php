<?
include_once "../inc/php/header.php";
?>
<script src="carga_lead_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Carga Lead</h2>
        </div>
    </div>
    <form method="post">
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_equipe'>Polos:&nbsp;</label>
                <select class='form-control form-control-sm' id='polos_pk' name='polos_pk'>
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_equipe">Mailing:&nbsp;</label>
                <select class='form-control form-control-sm' id='mailing_pk' name='mailing_pk'>
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-2' align="left">
                <label for='dt_ativacao'>Data da Carga : </label>
                <input type="text" class="form-control form-control-sm" id="dt_carga_ini" placeholder="De">
           </div>
           <div class='col-md-2' align="left">
               <label for='dt_ativacao'>&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="dt_carga_fim" placeholder="Até">
           </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_equipe'>Usuário Cadastro:&nbsp;</label>
                <select class='form-control form-control-sm' id='usuario_cadastro_pk' name='usuario_cadastro_pk'>
                    <option></option>
                </select>
            </div>
        </div>
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
    </form>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Usuário Cadastro</th>
                    <th>Data Carga</th>
                    <th>Mailing</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
    
    <div class="modal fade bd-example-modal-lg" id="janela_carga_nao_realizada" data-backdrop='static'>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class='row'>
                        <div class='col-md-12'>
                            <h5>Carga Não Realizada</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblCargaNaoRealizada">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Lead</th>
                                    <th>CNPJ</th>
                                    <th>Mailing</th>
                                    <th>Usuário Cadastro</th>
                                    <th>Data da Carga</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>                                                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn" id="cmdEnviarEndereco"  name="cmdEnviarEndereco">Enviar</button>
                </div>
            </div>
        </div>  
</div> 
</div>
<?
include_once "../inc/php/footer.php";
?>
