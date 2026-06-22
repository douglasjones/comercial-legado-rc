<?
include_once "../inc/php/header.php";

if (!isset($_SESSION['transferencia_lead_context']) || !is_array($_SESSION['transferencia_lead_context'])) {
    $_SESSION['transferencia_lead_context'] = array();
}

function fcTransferenciaNormalizarEntrada($key, $default = ""){
    if (!isset($_REQUEST[$key])) {
        return $default;
    }

    $value = $_REQUEST[$key];

    if (is_array($value)) {
        return array();
    }

    return trim((string)$value);
}

$arrTransferenciaDefaults = array(
    "polos_pk" => "",
    "ds_razao_social" => "",
    "ic_status_1" => "0",
    "ic_status_2" => "0",
    "ic_status_3" => "0",
    "ic_status_4" => "0",
    "grupos_pk" => "",
    "usuarios_pk" => "",
    "tipo_pessoa_pk" => "",
    "mailing_pk" => "",
    "operador_pk" => "",
    "classificacao_operador_pk" => "",
    "tempo_contrato_ini" => "",
    "tempo_contrato_fim" => "",
    "qtde_linhas_ini" => "",
    "qtde_linhas_fim" => ""
);

$arrTransferenciaRequest = array();
$houvePostTransferencia = false;

foreach ($arrTransferenciaDefaults as $key => $defaultValue){
    $valorNormalizado = fcTransferenciaNormalizarEntrada($key, $defaultValue);
    $arrTransferenciaRequest[$key] = $valorNormalizado;
    if ($valorNormalizado !== $defaultValue && $valorNormalizado !== ""){
        $houvePostTransferencia = true;
    }
}

if ($houvePostTransferencia){
    $_SESSION['transferencia_lead_context'] = array_merge($_SESSION['transferencia_lead_context'], $arrTransferenciaRequest);
}

$arrTransferenciaContext = array_merge($arrTransferenciaDefaults, $_SESSION['transferencia_lead_context']);

$arrTransferenciaObrigatorios = array("polos_pk", "ic_status_1", "ic_status_2", "ic_status_3", "ic_status_4");
$arrTransferenciaAusentes = array();

foreach ($arrTransferenciaObrigatorios as $campoObrigatorio){
    if (!isset($arrTransferenciaContext[$campoObrigatorio]) || $arrTransferenciaContext[$campoObrigatorio] === null || $arrTransferenciaContext[$campoObrigatorio] === ""){
        $arrTransferenciaAusentes[] = $campoObrigatorio;
    }
}

$arrTransferenciaContext["tempo_contrato_pk"] = $arrTransferenciaContext["tempo_contrato_ini"];
?>
<script>
window.transferenciaLeadContext = <?php echo json_encode($arrTransferenciaContext); ?>;
window.transferenciaLeadWarnings = <?php echo json_encode($arrTransferenciaAusentes); ?>;

var polos_pk = window.transferenciaLeadContext.polos_pk || "";
var ds_razao_social = window.transferenciaLeadContext.ds_razao_social || "";
var ic_status_1 = window.transferenciaLeadContext.ic_status_1 || "0";
var ic_status_2 = window.transferenciaLeadContext.ic_status_2 || "0";
var ic_status_3 = window.transferenciaLeadContext.ic_status_3 || "0";
var ic_status_4 = window.transferenciaLeadContext.ic_status_4 || "0";
var grupos_pk = window.transferenciaLeadContext.grupos_pk || "";
var usuarios_pk = window.transferenciaLeadContext.usuarios_pk || "";
var tipo_pessoa_pk = window.transferenciaLeadContext.tipo_pessoa_pk || "";
var mailing_pk = window.transferenciaLeadContext.mailing_pk || "";
var operador_pk = window.transferenciaLeadContext.operador_pk || "";
var classificacao_operador_pk = window.transferenciaLeadContext.classificacao_operador_pk || "";
var tempo_contrato_ini = window.transferenciaLeadContext.tempo_contrato_ini || "";
var tempo_contrato_fim = window.transferenciaLeadContext.tempo_contrato_fim || "";
var qtde_linhas_ini = window.transferenciaLeadContext.qtde_linhas_ini || "";
var qtde_linhas_fim = window.transferenciaLeadContext.qtde_linhas_fim || "";
var tempo_contrato_pk = window.transferenciaLeadContext.tempo_contrato_pk || "";
</script>
<script src="transferencia_lead2.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container col-md-10">
    <form id='form'>
        <table>
            <tr>
                <td>
                    <h2>Transfêrencia Lead</h2>
                </td>
            </tr>
        </table>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div id="form_grid">
                    <div id="grid"></div>
                </div>
            </div>
        </div>
    </form>
    
</div>
<?
include_once "../inc/php/footer.php";
?>
