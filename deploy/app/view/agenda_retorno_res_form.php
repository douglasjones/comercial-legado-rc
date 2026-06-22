<?
include_once "../inc/php/header.php";

?>
<script src="agenda_retorno_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
    .titulo_calendario_anterior{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_grid_produto_servico{
        background-color: #c3c3c3;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_atual{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_seguinte{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .subtitulo_calendario{
        text-align: center;
    }
    .corpo{
        border-right-style: dashed;
        border-right-width: thin;        
    }
    .modal-content1{
        width: 1200px;
    }
    
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
<div class="container col" id="exibir" style="display:none">
    <form id="form">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <h3><div class="" >Agenda Retorno <labe id="ds_usuario_logado"></label></div>  </h3> 
                </div>
            </div>
            <form method="post">

               <div class="modal-content" >
                    <div class="modal-body">
                        <div class="row" align="center">
                            <div class="col-md"  >
                                <button type="button" class="btn" id="cmdPreviMes"  name="cmdPreviMes"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                                &nbsp;<label id="ds_mes"></label>&nbsp;
                                <button type="button" class="btn" id="cmdNextMes"  name="cmdNextMes"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>                    
                                <input type="hidden" id="ic_mes" value="ic_mes" >&nbsp;&nbsp; - &nbsp;&nbsp;
                                <button type="button" class="btn" id="cmdPreviAno"  name="cmdPreviAno"><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                                &nbsp;<label id="ano_pk"></label>&nbsp;
                                <input type="hidden" id="ds_ano" value="ds_ano" >
                                <button type="button" class="btn" id="cmdNextAno"  name="cmdNextAno"><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></button>                       
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='col-md-3'>
                                            <label for="ds_lead">Ocorrencia:&nbsp;</label>
                                             <select class='form-control form-control-sm'  id='calendar_ocorrencia_pk' name='polos_pk' requered>                            
                                                <option value=""></option>                       
                                            </select>
                                        </div>
                                        <div class='col-md-3'>
                                            <label for='grupos_pk'>Equipe: </label>
                                            <select class='form-control form-control-sm'  id='calendar_equipe_pk' name='grupos_pk'>
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class='col-md-3'>
                                            <label for='usuarios_pk'>Responsável: </label>
                                            <select class='form-control form-control-sm'  id='calendar_usuarios_pk' name='usuarios_pk'>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>    
                                </div>
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class="col-md-3" >
                                            Legenda
                                         </div>
                                        <div class="col-md-5"  style="background-color:#DFF0D8">
                                            <div class="text-center">
                                            Retorno Concluido
                                            </div>
                                        </div> 
                                        <div class="col-md-5" style="background-color:#e62121">
                                            <div class="text-center">
                                            Atrasados
                                            </div> 
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div id="container"></div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center">
                             <div class="col-md"  >
                                 <button type="button" class="btn btn-secondary" id="cmdFiltrar">Filtrar</button> 
                             </div>
                        </div>    
                    </div>
               </div>             
               <br>

                <!-- 1º SEMANA--> 
                <div class="row">
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_anterior'>
                            <div class='col-xl-12'>
                                <div class='col-xl-12 dom'>Dom</div>                            
                            </div>                        
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_dom1"></div>                              
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_dom1_val" value="">
                                <div class="ds_visita_dom1"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_anterior'>
                            <div class='col-xl-12 seg'>Seg</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_seg1"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_seg1_val" value="">
                                <div class="ds_visita_seg1"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_anterior'>
                            <div class='col-xl-12 ter'>Ter</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                               <div id="dt_agenda_ter1"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_ter1_val" value="">
                                <div class="ds_visita_ter1"></div><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_anterior'>
                            <div class='col-xl-12 qua'>Qua</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>

                                <div id="dt_agenda_qua1"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qua1_val" value="">
                                <div class="ds_visita_qua1"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_anterior'>
                            <div class='col-xl-12 qui'>Qui</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qui1"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qui1_val" value="">
                               <div class="ds_visita_qui1"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">

                        <div class='row titulo_calendario_anterior'>
                            <div class='col-xl-12 sex'>Sex</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sex1"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sex1_val" value="">
                                <div class="ds_visita_sex1"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_anterior'>
                            <div class='col-xl-12 sab'>Sab</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sab1"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sab1_val" value="">
                                <div class="ds_visita_sab1"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                </div>



                <!--2º Semana-->
                <div class="row">
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12'>
                                <div class='col-xl-12 dom'>Dom</div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_dom2"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_dom2_val" value="">
                                <div class="ds_visita_dom2"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 seg'>Seg</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_seg2"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                                <input type="hidden" id="dt_agenda_seg2_val" value="">
                                <div class="ds_visita_seg2"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 ter'>Ter</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                               <div id="dt_agenda_ter2"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>                  
                                <input type="hidden" id="dt_agenda_ter2_val" value="">
                                <div class="ds_visita_ter2"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qua'>Qua</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qua2"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qua2_val" value="">
                               <div class="ds_visita_qua2"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qui'>Qui</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qui2"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qui2_val" value="">
                                <div class="ds_visita_qui2"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">

                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sex'>Sex</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sex2"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sex2_val" value="">
                                <div class="ds_visita_sex2"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sab'>Sab</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sab2"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sab2_val" value="">
                                <div class="ds_visita_sab2"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>  


                <!--3º Semana-->
                <div class="row">
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12'>
                                <div class='col-xl-12 dom'>Dom</div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_dom3"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_dom3_val" value="">
                                <div class="ds_visita_dom3"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 seg'>Seg</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_seg3"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_seg3_val" value="">    
                                <div class="ds_visita_seg3"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 ter'>Ter</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                               <div id="dt_agenda_ter3"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_ter3_val" value="">
                                <div class="ds_visita_ter3"></div><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qua'>Qua</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qua3"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qua3_val" value="">
                               <div class="ds_visita_qua3"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qui'>Qui</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qui3"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qui3_val" value="">
                                <div class="ds_visita_qui3"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">

                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sex'>Sex</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sex3"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sex3_val" value="">
                                <div class="ds_visita_sex3"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sab'>Sab</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sab3"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sab3_val" value="">
                                <div class="ds_visita_sab3"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>  

                <!--4º Semana-->
                <div class="row">
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12'>
                                <div class='col-xl-12 dom'>Dom</div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_dom4"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_dom4_val" value="">
                                <div class="ds_visita_dom4"></div><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 seg'>Seg</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_seg4"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_seg4_val" value="">
                                <div class="ds_visita_seg4"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 ter'>Ter</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                               <div id="dt_agenda_ter4"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                              <br>
                              <input type="hidden" id="dt_agenda_ter4_val" value="">
                                <div class="ds_visita_ter4"></div><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qua'>Qua</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qua4"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qua4_val" value="">
                               <div class="ds_visita_qua4"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qui'>Qui</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qui4"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qui4_val" value="">
                                <div class="ds_visita_qui4"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">

                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sex'>Sex</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sex4"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sex4_val" value="">
                                <div class="ds_visita_sex4"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sab'>Sab</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sab4"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sab4_val" value="">
                                <div class="ds_visita_sab4"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>  

                <!--5º Semana-->
                <div class="row">
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12'>
                                <div class='col-xl-12 dom'>Dom</div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_dom5"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_dom5_val" value="">
                                <div class="ds_visita_dom5"></div><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 seg'>Seg</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_seg5"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_seg5_val" value="">
                                <div class="ds_visita_seg5"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 ter'>Ter</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                               <div id="dt_agenda_ter5"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_ter5_val" value="">
                                <div class="ds_visita_ter5"></div><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qua'>Qua</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qua5"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qua5_val" value="">
                               <div class="ds_visita_qua5"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qui'>Qui</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qui5"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_qui5_val" value="">
                                <div class="ds_visita_qui5"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">

                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sex'>Sex</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sex5"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sex5_val" value="">
                                <div class="ds_visita_sex5"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sab'>Sab</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sab5"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sab5_val" value="">
                                <div class="ds_visita_sab5"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>  

                <!--6º Semana-->
                <div class="row">
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12'>
                                <div class='col-xl-12 dom'>Dom</div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_dom6"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_dom6_val" value="">
                                <div class="ds_visita_dom6"></div><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 seg'>Seg</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_seg6"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_seg6_val" value="">
                                <div class="ds_visita_seg6"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 ter'>Ter</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                               <div id="dt_agenda_ter6"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_ter6_val" value="">
                                <div class="ds_visita_ter6"></div><br>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qua'>Qua</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qua6"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                               <br>
                               <input type="hidden" id="dt_agenda_qua6_val" value="">
                               <div class="ds_visita_qua6"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 qui'>Qui</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_qui6"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_qui6_val" value="">
                                <div class="ds_visita_qui6"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">

                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sex'>Sex</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sex6"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sex6_val" value="">
                                <div class="ds_visita_sex6"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>

                    </div>
                    <div class="col-lg corpo">
                        <div class='row titulo_calendario_atual'>
                            <div class='col-xl-12 sab'>Sab</div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12 subtitulo_calendario'>
                                <div id="dt_agenda_sab6"></div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-xl-12'>
                                <br>
                                <input type="hidden" id="dt_agenda_sab6_val" value="">
                                <div class="ds_visita_sab6"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </form>
</div>
<?php include("cal_inc_agenda_retorno.php"); ?> 
<?
include_once "../inc/php/footer.php";
?>
