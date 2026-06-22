<?
require_once "../inc/php/config.php";

require_once "../model/usuario.dao.php";

function DataYMD($strData){
	$arrData = preg_split('/[\/\.\-]/', (string)$strData);
	if(count($arrData) !== 3){
		return "";
	}
	list($day, $month, $year) = $arrData;
	return $year."-".$month."-".$day;
}
function DataDMY($strData){
	$arrData = preg_split('/[\/\.\-]/', (string)$strData);
	if(count($arrData) !== 3){
		return "";
	}
	list($year, $month, $day) = $arrData;
	return $day."/".$month."/".$year;
}

function redirecionar($strPagina){
    echo "<script>";
    echo "location.href = '".$strPagina."' ";
    echo "</script>";
}

function criarConstantesPost(){
    foreach(array_keys($_REQUEST) as $key){
        echo "var $key = '".$_REQUEST[$key]."'; ";
    }    
}

function tratar_request(){
    return $_REQUEST;
}

function getUploadBaseDir(){
    $baseDir = getenv("UPLOAD_BASE_DIR");
    if($baseDir === false || trim($baseDir) === ""){
        $baseDir = "/var/appdata/uploads";
    }
    return rtrim($baseDir, "/");
}

function ensureUploadBaseDir(){
    $baseDir = getUploadBaseDir();
    if(!is_dir($baseDir)){
        @mkdir($baseDir, 0750, true);
    }
    return $baseDir;
}

function safeFilename($name){
    $name = str_replace("\0", "", (string)$name);
    $name = basename($name);
    return preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
}

function safePath($baseDir, $filename){
    if($filename === null || $filename === ""){
        return false;
    }
    if(strpos($filename, "\0") !== false || strpos($filename, "..") !== false || strpos($filename, "\\") !== false || strpos($filename, ":") !== false){
        return false;
    }

    $base = realpath($baseDir);
    if($base === false){
        return false;
    }
    $candidate = $base . "/" . safeFilename($filename);
    $resolved = realpath($candidate);
    if($resolved === false){
        // arquivo pode ainda não existir
        return $candidate;
    }
    if(strpos($resolved, $base . "/") !== 0 && $resolved !== $base){
        return false;
    }
    return $resolved;
}

function remover_acentos($palavra){
  return strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC");
}

function tratarToken($token){
    if(isset($_SESSION['auth']) && is_array($_SESSION['auth'])){
        return $_SESSION['auth'];
    }
    return array(
        "usuarios_pk" => "",
        "ds_usuario" => "",
        "ds_login" => "",
        "dt_validade_login" => "",
        "contas_pk" => "",
        "grupos_pk" => "",
        "equipes_pk" => "",
        "polos_pk" => ""
    );
}

function verificarLogin($token){
    $arrToken = tratarToken($token);
    if(!isset($_SESSION['auth']) || !is_array($_SESSION['auth']) || empty($arrToken['usuarios_pk'])){
        redirecionar("../index.php");
        exit(0);
    }

    if(!empty($_SESSION['auth_exp']) && time() > (int)$_SESSION['auth_exp']){
        unset($_SESSION['auth']);
        unset($_SESSION['auth_exp']);
        session_regenerate_id(true);
        redirecionar("../index.php");
        exit(0);
    }
}

function permissao($ds_dominio_modulo, $ic_acao, $token){

        $arrToken = tratarToken($token);
        if(empty($arrToken['usuarios_pk'])){
            return false;
        }
       
		$usuarios_pk = $arrToken['usuarios_pk'];
        
	$usuariodao = new usuariodao();
        $total = $usuariodao->verificarPermissao($usuarios_pk,$ds_dominio_modulo,$ic_acao);
        
	if($total > 0)
            return true;
	else
            return false;

}

function permissao_dados(){
    
}

//Função que verifica a extensão
function extensao($arquivo){
    
    $tam = strlen($arquivo);
    //ext de 3 chars
    if( $arquivo[($tam)-4] == '.' )
    {
    $extensao = substr($arquivo,-3);
    }

    //ext de 4 chars
    elseif( $arquivo[($tam)-5] == '.' )
    {
    $extensao = substr($arquivo,-4);
    }

    //ext de 2 chars
    elseif( $arquivo[($tam)-3] == '.' )
    {
    $extensao = substr($arquivo,-2);
    }

    //Caso a extensão não tenha 2, 3 ou 4 chars ele não aceita e retorna Nulo.
    else
    {
    $extensao = NULL;
    }
    return $extensao;
}
function moeda2float($moeda){
    $moeda = str_replace(".","", $moeda);
    $moeda = str_replace(",",".", $moeda);
    return $moeda;
}
function pegarMes($data){
	$arrData = explode("/", (string)$data);
	return $arrData[1];
}

function primeiroDiaMes($data){
	$arrData = explode("/", (string)$data);
	return  "01/".$arrData[1]."/".$arrData[2];
}

function ultimoDiaMes($newData){	
    $usuariodao = new usuariodao();
    $strRetorno = "";
    $strRetorno = $usuariodao->pegarUltimoDiaMes($newData);
    
    return $strRetorno;
}

function pegarDiaMes($n_mes,$n_ano){

    //pegar primeiro dia do mês
    $dt_ini_mes = primeiroDiaMes("01/".$n_mes."/".$n_ano);
    //Pegar ultimo dia do mês
    $dt_fim_mes = ultimoDiaMes($dt_ini_mes);
    
    for ($d = 1; $d <= $dt_fim_mes; $d++ ){
        echo $d."/".$n_mes."/".$n_ano."<br>";
    }
}

function pegarDiasSemana($dt_periodo_ini,$dt_periodo_fim) {

    list($ano1,$mes1,$dia1) = explode("-",$dt_periodo_ini);
    list($ano2,$mes2,$dia2) = explode("-",$dt_periodo_fim);

    $fimMK = mktime(0,0,0,$mes2,$dia2,$ano2);

    for ($i=0;$i>=0;$i++) {
        $calcula = mktime(0,0,0,$mes1,$dia1+$i,$ano1);
        if (date('w',$calcula) == 0) {
                $dom++;
        }
        if (date('w',$calcula) == 1) {
                $seg++;
        }
        if (date('w',$calcula) == 2) {
                $ter++;
        }
        if (date('w',$calcula) == 3) {
                $qua++;
        }
        if (date('w',$calcula) == 4) {
                $qui++;
        }
        if (date('w',$calcula) == 5) {
                $sex++;
        }
        if (date('w',$calcula) == 6) {
                $sab++;
        }
        if ($calcula == $fimMK) {
                break;
        }
    }

    return array('0' => $dom,'1' => $seg,'2' => $ter,'3' => $qua,'4' => $qui,'5' => $sex,'6'=> $sab);
}

function formatCnpjCpf($value){
  $cnpj_cpf = preg_replace("/\D/", '', $value);
  
  if (strlen($cnpj_cpf) === 11) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } 
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}


$arrPaletaCores = array();

$arrPaletaCores[0] = '#5f9bc8';
$arrPaletaCores[1] = '#CDC0B0';
$arrPaletaCores[2] = '#66CDAA';
$arrPaletaCores[3] = '#C1CDCD';
$arrPaletaCores[4] = '#EED5B7';
$arrPaletaCores[5] = '#0000FF';
$arrPaletaCores[6] = '#8A2BE2';
$arrPaletaCores[7] = '#CD3333';
$arrPaletaCores[8] = '#EEC591';
$arrPaletaCores[9] = '#98F5FF';
$arrPaletaCores[10] = '#7FFF00';
$arrPaletaCores[11] = '#D2691E';
$arrPaletaCores[12] = '#F0F8FF';
$arrPaletaCores[13] = '#CD5B45';
$arrPaletaCores[14] = '#EEE8CD';
$arrPaletaCores[15] = '#00EEEE';
$arrPaletaCores[16] = '#FFB90F';
$arrPaletaCores[17] = '#006400';
$arrPaletaCores[18] = '#556B2F';
$arrPaletaCores[19] = '#6E8B3D';
$arrPaletaCores[20] = '#CD6600';
$arrPaletaCores[21] = '#B23AEE';
$arrPaletaCores[22] = '#E9967A';
$arrPaletaCores[23] = '#9BCD9B';
$arrPaletaCores[24] = '#97FFFF';
$arrPaletaCores[25] = '#00CED1';
$arrPaletaCores[26] = '#CD1076';
$arrPaletaCores[27] = '#009ACD';
$arrPaletaCores[28] = '#1C86EE';
$arrPaletaCores[29] = '#FF3030';
$arrPaletaCores[30] = '#FFFAF0';
$arrPaletaCores[31] = '#FFD700';
$arrPaletaCores[32] = '#DAA520';
$arrPaletaCores[33] = '#8B6914';
$arrPaletaCores[34] = '#00EE00';
$arrPaletaCores[35] = '#BEBEBE';
$arrPaletaCores[36] = '#828282';
$arrPaletaCores[37] = '#E0EEE0';
$arrPaletaCores[38] = '#FF6EB4';
$arrPaletaCores[39] = '#CD5C5C';
$arrPaletaCores[40] = '#8B3A3A';
$arrPaletaCores[41] = '#8B8B83';
$arrPaletaCores[42] = '#8B864E';
$arrPaletaCores[43] = '#CDC1C5';
$arrPaletaCores[44] = '#EEE9BF';
$arrPaletaCores[45] = '#BFEFFF';
$arrPaletaCores[46] = '#F08080';
$arrPaletaCores[47] = '#7A8B8B';
$arrPaletaCores[48] = '#CDBE70';
$arrPaletaCores[49] = '#FFB6C1';
$arrPaletaCores[50] = '#8B5F65';
$arrPaletaCores[51] = '#8B5742';
$arrPaletaCores[52] = '#A4D3EE';
$arrPaletaCores[53] = '#778899';
$arrPaletaCores[54] = '#A2B5CD';
$arrPaletaCores[55] = '#CDCDB4';
$arrPaletaCores[56] = '#FAFAD2';
$arrPaletaCores[57] = '#B03060';
$arrPaletaCores[58] = '#8B1C62';
$arrPaletaCores[59] = '#B452CD';
$arrPaletaCores[60] = '#9F79EE';
$arrPaletaCores[61] = '#7B68EE';
$arrPaletaCores[62] = '#191970';
$arrPaletaCores[63] = '#CDB7B5';
$arrPaletaCores[64] = '#EECFA1';
$arrPaletaCores[65] = '#FDF5E6';
$arrPaletaCores[66] = '#9ACD32';
$arrPaletaCores[67] = '#CD8500';
$arrPaletaCores[68] = '#CD3700';
$arrPaletaCores[69] = '#EE7AE9';
$arrPaletaCores[70] = '#98FB98';
$arrPaletaCores[71] = '#AFEEEE';
$arrPaletaCores[72] = '#668B8B';
$arrPaletaCores[73] = '#CD6889';
$arrPaletaCores[74] = '#EECBAD';
$arrPaletaCores[75] = '#FFC0CB';
$arrPaletaCores[76] = '#8B636C';
$arrPaletaCores[77] = '#CD96CD';
$arrPaletaCores[78] = '#9B30FF';
$arrPaletaCores[79] = '#FF0000';
$arrPaletaCores[80] = '#FFC1C1';
$arrPaletaCores[81] = '#4169E1';
$arrPaletaCores[82] = '#27408B';
$arrPaletaCores[83] = '#CD7054';
$arrPaletaCores[84] = '#54FF9F';
$arrPaletaCores[85] = '#EEE5DE';
$arrPaletaCores[86] = '#FF8247';
$arrPaletaCores[87] = '#87CEEB';
$arrPaletaCores[88] = '#4A708B';
$arrPaletaCores[89] = '#6959CD';
$arrPaletaCores[90] = '#9FB6CD';
$arrPaletaCores[91] = '#EEE9E9';
$arrPaletaCores[92] = '#00EE76';
$arrPaletaCores[93] = '#63B8FF';
$arrPaletaCores[94] = '#D2B48C';
$arrPaletaCores[95] = '#D8BFD8';
$arrPaletaCores[96] = '#8B7B8B';
$arrPaletaCores[97] = '#8B3626';
$arrPaletaCores[98] = '#00C5CD';
$arrPaletaCores[99] = '#FF3E96';
$arrPaletaCores[100] = '#F5DEB3';
$arrPaletaCores[101] = '#8B7E66';
$arrPaletaCores[102] = '#EEEE00';
$arrPaletaCores[103] = '#FAEBD7';
$arrPaletaCores[104] = '#FFEFDB';
$arrPaletaCores[105] = '#EEDFCC';
$arrPaletaCores[106] = '#8B8378';
$arrPaletaCores[107] = '#7FFFD4';
$arrPaletaCores[108] = '#76EEC6';
$arrPaletaCores[109] = '#458B74';
$arrPaletaCores[110] = '#F0FFFF';
$arrPaletaCores[111] = '#E0EEEE';
$arrPaletaCores[112] = '#838B8B';
$arrPaletaCores[113] = '#F5F5DC';
$arrPaletaCores[114] = '#FFE4C4';
$arrPaletaCores[115] = '#CDB79E';
$arrPaletaCores[116] = '#8B7D6B';
$arrPaletaCores[117] = '#000000';
$arrPaletaCores[118] = '#FFEBCD';
$arrPaletaCores[119] = '#0000EE';
$arrPaletaCores[120] = '#0000CD';
$arrPaletaCores[121] = '#00008B';
$arrPaletaCores[122] = '#A52A2A';
$arrPaletaCores[123] = '#FF4040';
$arrPaletaCores[124] = '#EE3B3B';
$arrPaletaCores[125] = '#8B2323';
$arrPaletaCores[126] = '#DEB887';
$arrPaletaCores[127] = '#FFD39B';
$arrPaletaCores[128] = '#CDAA7D';
$arrPaletaCores[129] = '#8B7355';
$arrPaletaCores[130] = '#5F9EA0';
$arrPaletaCores[131] = '#8EE5EE';
$arrPaletaCores[132] = '#7AC5CD';
$arrPaletaCores[133] = '#53868B';
$arrPaletaCores[134] = '#76EE00';
$arrPaletaCores[135] = '#66CD00';
$arrPaletaCores[136] = '#458B00';
$arrPaletaCores[137] = '#FF7F24';
$arrPaletaCores[138] = '#EE7621';
$arrPaletaCores[139] = '#CD661D';
$arrPaletaCores[140] = '#FF7F50';
$arrPaletaCores[141] = '#FF7256';
$arrPaletaCores[142] = '#EE6A50';
$arrPaletaCores[143] = '#8B3E2F';
$arrPaletaCores[144] = '#6495ED';
$arrPaletaCores[145] = '#FFF8DC';
$arrPaletaCores[146] = '#CDC8B1';
$arrPaletaCores[147] = '#8B8878';
$arrPaletaCores[148] = '#00FFFF';
$arrPaletaCores[149] = '#00CDCD';
$arrPaletaCores[150] = '#008B8B';
$arrPaletaCores[151] = '#B8860B';
$arrPaletaCores[152] = '#EEAD0E';
$arrPaletaCores[153] = '#CD950C';
$arrPaletaCores[154] = '#8B658B';
$arrPaletaCores[155] = '#A9A9A9';
$arrPaletaCores[156] = '#BDB76B';
$arrPaletaCores[157] = '#8B008B';
$arrPaletaCores[158] = '#CAFF70';
$arrPaletaCores[159] = '#BCEE68';
$arrPaletaCores[160] = '#A2CD5A';
$arrPaletaCores[161] = '#FF8C00';
$arrPaletaCores[162] = '#FF7F00';
$arrPaletaCores[163] = '#EE7600';
$arrPaletaCores[164] = '#8B4500';
$arrPaletaCores[165] = '#9932CC';
$arrPaletaCores[166] = '#BF3EFF';
$arrPaletaCores[167] = '#9A32CD';
$arrPaletaCores[168] = '#68228B';
$arrPaletaCores[169] = '#8B0000';
$arrPaletaCores[170] = '#8FBC8F';
$arrPaletaCores[171] = '#C1FFC1';
$arrPaletaCores[172] = '#B4EEB4';
$arrPaletaCores[173] = '#698B69';
$arrPaletaCores[174] = '#483D8B';
$arrPaletaCores[175] = '#2F4F4F';
$arrPaletaCores[176] = '#8DEEEE';
$arrPaletaCores[177] = '#79CDCD';
$arrPaletaCores[178] = '#528B8B';
$arrPaletaCores[179] = '#9400D3';
$arrPaletaCores[180] = '#FF1493';
$arrPaletaCores[181] = '#EE1289';
$arrPaletaCores[182] = '#8B0A50';
$arrPaletaCores[183] = '#00BFFF';
$arrPaletaCores[184] = '#00B2EE';
$arrPaletaCores[185] = '#00688B';
$arrPaletaCores[186] = '#696969';
$arrPaletaCores[187] = '#1E90FF';
$arrPaletaCores[188] = '#1874CD';
$arrPaletaCores[189] = '#104E8B';
$arrPaletaCores[190] = '#B22222';
$arrPaletaCores[191] = '#EE2C2C';
$arrPaletaCores[192] = '#CD2626';
$arrPaletaCores[193] = '#8B1A1A';
$arrPaletaCores[194] = '#228B22';
$arrPaletaCores[195] = '#DCDCDC';
$arrPaletaCores[196] = '#F8F8FF';
$arrPaletaCores[197] = '#EEC900';
$arrPaletaCores[198] = '#CDAD00';
$arrPaletaCores[199] = '#8B7500';
$arrPaletaCores[200] = '#FFC125';
$arrPaletaCores[201] = '#EEB422';
$arrPaletaCores[202] = '#CD9B1D';
$arrPaletaCores[203] = '#CFCFCF';
$arrPaletaCores[204] = '#E8E8E8';
$arrPaletaCores[205] = '#00FF00';
$arrPaletaCores[206] = '#00CD00';
$arrPaletaCores[207] = '#008B00';
$arrPaletaCores[208] = '#ADFF2F';
$arrPaletaCores[209] = '#1C1C1C';
$arrPaletaCores[210] = '#363636';
$arrPaletaCores[211] = '#4F4F4F';
$arrPaletaCores[212] = '#9C9C9C';
$arrPaletaCores[213] = '#B5B5B5';
$arrPaletaCores[214] = '#F0FFF0';
$arrPaletaCores[215] = '#C1CDC1';
$arrPaletaCores[216] = '#838B83';
$arrPaletaCores[217] = '#FF69B4';
$arrPaletaCores[218] = '#EE6AA7';
$arrPaletaCores[219] = '#CD6090';
$arrPaletaCores[220] = '#8B3A62';
$arrPaletaCores[221] = '#FF6A6A';
$arrPaletaCores[222] = '#EE6363';
$arrPaletaCores[223] = '#CD5555';
$arrPaletaCores[224] = '#FFFFF0';
$arrPaletaCores[225] = '#EEEEE0';
$arrPaletaCores[226] = '#CDCDC1';
$arrPaletaCores[227] = '#FFF68F';
$arrPaletaCores[228] = '#EEE685';
$arrPaletaCores[229] = '#CDC673';
$arrPaletaCores[230] = '#E6E6FA';
$arrPaletaCores[231] = '#FFF0F5';
$arrPaletaCores[232] = '#EEE0E5';
$arrPaletaCores[233] = '#8B8386';
$arrPaletaCores[234] = '#7CFC00';
$arrPaletaCores[235] = '#FFFACD';
$arrPaletaCores[236] = '#CDC9A5';
$arrPaletaCores[237] = '#8B8970';
$arrPaletaCores[238] = '#ADD8E6';
$arrPaletaCores[239] = '#B2DFEE';
$arrPaletaCores[240] = '#9AC0CD';
$arrPaletaCores[241] = '#68838B';
$arrPaletaCores[242] = '#E0FFFF';
$arrPaletaCores[243] = '#D1EEEE';
$arrPaletaCores[244] = '#B4CDCD';
$arrPaletaCores[245] = '#EEDD82';
$arrPaletaCores[246] = '#FFEC8B';
$arrPaletaCores[247] = '#EEDC82';
$arrPaletaCores[248] = '#8B814C';
$arrPaletaCores[249] = '#D3D3D3';
$arrPaletaCores[250] = '#90EE90';
$arrPaletaCores[251] = '#FFAEB9';
$arrPaletaCores[252] = '#EEA2AD';
$arrPaletaCores[253] = '#CD8C95';
$arrPaletaCores[254] = '#FFA07A';
$arrPaletaCores[255] = '#EE9572';
$arrPaletaCores[256] = '#CD8162';
$arrPaletaCores[257] = '#20B2AA';
$arrPaletaCores[258] = '#87CEFA';
$arrPaletaCores[259] = '#B0E2FF';
$arrPaletaCores[260] = '#8DB6CD';
$arrPaletaCores[261] = '#607B8B';
$arrPaletaCores[262] = '#8470FF';
$arrPaletaCores[263] = '#B0C4DE';
$arrPaletaCores[264] = '#CAE1FF';
$arrPaletaCores[265] = '#BCD2EE';
$arrPaletaCores[266] = '#6E7B8B';
$arrPaletaCores[267] = '#FFFFE0';
$arrPaletaCores[268] = '#EEEED1';
$arrPaletaCores[269] = '#8B8B7A';
$arrPaletaCores[270] = '#32CD32';
$arrPaletaCores[271] = '#FAF0E6';
$arrPaletaCores[272] = '#FF00FF';
$arrPaletaCores[273] = '#EE00EE';
$arrPaletaCores[274] = '#CD00CD';
$arrPaletaCores[275] = '#FF34B3';
$arrPaletaCores[276] = '#EE30A7';
$arrPaletaCores[277] = '#CD2990';
$arrPaletaCores[278] = '#BA55D3';
$arrPaletaCores[279] = '#E066FF';
$arrPaletaCores[280] = '#D15FEE';
$arrPaletaCores[281] = '#7A378B';
$arrPaletaCores[282] = '#9370DB';
$arrPaletaCores[283] = '#AB82FF';
$arrPaletaCores[284] = '#8968CD';
$arrPaletaCores[285] = '#5D478B';
$arrPaletaCores[286] = '#3CB371';
$arrPaletaCores[287] = '#48D1CC';
$arrPaletaCores[288] = '#C71585';
$arrPaletaCores[289] = '#00FA9A';
$arrPaletaCores[290] = '#F5FFFA';
$arrPaletaCores[291] = '#FFE4E1';
$arrPaletaCores[292] = '#EED5D2';
$arrPaletaCores[293] = '#8B7D7B';
$arrPaletaCores[294] = '#FFE4B5';
$arrPaletaCores[295] = '#FFDEAD';
$arrPaletaCores[296] = '#CDB38B';
$arrPaletaCores[297] = '#8B795E';
$arrPaletaCores[298] = '#000080';
$arrPaletaCores[299] = '#6B8E23';
$arrPaletaCores[300] = '#C0FF3E';
$arrPaletaCores[301] = '#B3EE3A';
$arrPaletaCores[302] = '#698B22';
$arrPaletaCores[303] = '#FFA500';
$arrPaletaCores[304] = '#EE9A00';
$arrPaletaCores[305] = '#8B5A00';
$arrPaletaCores[306] = '#FF4500';
$arrPaletaCores[307] = '#EE4000';
$arrPaletaCores[308] = '#8B2500';
$arrPaletaCores[309] = '#DA70D6';
$arrPaletaCores[310] = '#FF83FA';
$arrPaletaCores[311] = '#CD69C9';
$arrPaletaCores[312] = '#8B4789';
$arrPaletaCores[313] = '#EEE8AA';
$arrPaletaCores[314] = '#9AFF9A';
$arrPaletaCores[315] = '#7CCD7C';
$arrPaletaCores[316] = '#548B54';
$arrPaletaCores[317] = '#BBFFFF';
$arrPaletaCores[318] = '#AEEEEE';
$arrPaletaCores[319] = '#96CDCD';
$arrPaletaCores[320] = '#DB7093';
$arrPaletaCores[321] = '#FF82AB';
$arrPaletaCores[322] = '#EE799F';
$arrPaletaCores[323] = '#8B475D';
$arrPaletaCores[324] = '#FFEFD5';
$arrPaletaCores[325] = '#FFDAB9';
$arrPaletaCores[326] = '#CDAF95';
$arrPaletaCores[327] = '#8B7765';
$arrPaletaCores[328] = '#CD853F';
$arrPaletaCores[329] = '#FFB5C5';
$arrPaletaCores[330] = '#EEA9B8';
$arrPaletaCores[331] = '#CD919E';
$arrPaletaCores[332] = '#DDA0DD';
$arrPaletaCores[333] = '#FFBBFF';
$arrPaletaCores[334] = '#EEAEEE';
$arrPaletaCores[335] = '#8B668B';
$arrPaletaCores[336] = '#B0E0E6';
$arrPaletaCores[337] = '#A020F0';
$arrPaletaCores[338] = '#912CEE';
$arrPaletaCores[339] = '#7D26CD';
$arrPaletaCores[340] = '#551A8B';
$arrPaletaCores[341] = '#EE0000';
$arrPaletaCores[342] = '#CD0000';
$arrPaletaCores[343] = '#BC8F8F';
$arrPaletaCores[344] = '#EEB4B4';
$arrPaletaCores[345] = '#CD9B9B';
$arrPaletaCores[346] = '#8B6969';
$arrPaletaCores[347] = '#4876FF';
$arrPaletaCores[348] = '#436EEE';
$arrPaletaCores[349] = '#3A5FCD';
$arrPaletaCores[350] = '#FA8072';
$arrPaletaCores[351] = '#FF8C69';
$arrPaletaCores[352] = '#EE8262';
$arrPaletaCores[353] = '#8B4C39';
$arrPaletaCores[354] = '#F4A460';
$arrPaletaCores[355] = '#2E8B57';
$arrPaletaCores[356] = '#4EEE94';
$arrPaletaCores[357] = '#43CD80';
$arrPaletaCores[358] = '#FFF5EE';
$arrPaletaCores[359] = '#CDC5BF';
$arrPaletaCores[360] = '#8B8682';
$arrPaletaCores[361] = '#A0522D';
$arrPaletaCores[362] = '#EE7942';
$arrPaletaCores[363] = '#CD6839';
$arrPaletaCores[364] = '#8B4726';
$arrPaletaCores[365] = '#87CEFF';
$arrPaletaCores[366] = '#7EC0EE';
$arrPaletaCores[367] = '#6CA6CD';
$arrPaletaCores[368] = '#6A5ACD';
$arrPaletaCores[369] = '#836FFF';
$arrPaletaCores[370] = '#7A67EE';
$arrPaletaCores[371] = '#473C8B';
$arrPaletaCores[372] = '#C6E2FF';
$arrPaletaCores[373] = '#B9D3EE';
$arrPaletaCores[374] = '#6C7B8B';
$arrPaletaCores[375] = '#708090';
$arrPaletaCores[376] = '#FFFAFA';
$arrPaletaCores[377] = '#CDC9C9';
$arrPaletaCores[378] = '#8B8989';
$arrPaletaCores[379] = '#00FF7F';
$arrPaletaCores[380] = '#00CD66';
$arrPaletaCores[381] = '#008B45';
$arrPaletaCores[382] = '#4682B4';
$arrPaletaCores[383] = '#5CACEE';
$arrPaletaCores[384] = '#4F94CD';
$arrPaletaCores[385] = '#36648B';
$arrPaletaCores[386] = '#FFA54F';
$arrPaletaCores[387] = '#EE9A49';
$arrPaletaCores[388] = '#8B5A2B';
$arrPaletaCores[389] = '#FFE1FF';
$arrPaletaCores[390] = '#EED2EE';
$arrPaletaCores[391] = '#CDB5CD';
$arrPaletaCores[392] = '#FF6347';
$arrPaletaCores[393] = '#EE5C42';
$arrPaletaCores[394] = '#CD4F39';
$arrPaletaCores[395] = '#40E0D0';
$arrPaletaCores[396] = '#00F5FF';
$arrPaletaCores[397] = '#00E5EE';
$arrPaletaCores[398] = '#00868B';
$arrPaletaCores[399] = '#EE82EE';
$arrPaletaCores[400] = '#D02090';
$arrPaletaCores[401] = '#EE3A8C';
$arrPaletaCores[402] = '#CD3278';
$arrPaletaCores[403] = '#8B2252';
$arrPaletaCores[404] = '#FFE7BA';
$arrPaletaCores[405] = '#EED8AE';
$arrPaletaCores[406] = '#CDBA96';
$arrPaletaCores[407] = '#FFFFFF';
$arrPaletaCores[408] = '#F5F5F5';
$arrPaletaCores[409] = '#FFFF00';
$arrPaletaCores[410] = '#CDCD00';
$arrPaletaCores[411] = '#8B8B00';

?>
