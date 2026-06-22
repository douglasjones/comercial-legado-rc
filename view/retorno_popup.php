<?
    include_once "../inc/php/pre_header.php";
?>
<html>
    <head>
        <?include_once PATH.'inc/php/scripts.php';?>
        <script>
            criarConstantesPost();   
        </script>    
        <script src="retorno_popup.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
    </head>

        <form id="form_retorno" class="form">
            <input type="hidden" id="t_token" value="<?=$token?>">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblRetorno">
                        <thead>
                            <tr>   
                                <th>Lead</th>              
                                <th>Dt Retorno </th> 
                                <th>Atraso</th>
                                <th>Agendado Para</th> 
                                <th>Tipo OC</th>
                                <th>Descr Retorno</th>         
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
        </form>    

</html>
