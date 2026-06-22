window.location.getQueryParams = function(query) {
    if (!query) {
        
        query = window.location.search
    }
    
    if(query.trim() == ""){
        return [];
    }
    
    query = decodeURIComponent(query.trim().substr(1,query.length));
    arrLinhas = query.split("&");
    
    var arrRetorno = [];
    for(i = 0; i < arrLinhas.length; i++){
        arrCampos = arrLinhas[i].split("=");
        arrRetorno[arrCampos[0].trim()] = arrCampos[1].trim();
    }
    
    return arrRetorno;
    
}   

function NewWindow(v_url){
    var varWindow = window.open (v_url, 'popup' ) 
    return varWindow;
}

var arrQueryParams = location.getQueryParams();
var v_last_url = "";

if(!window.sendPost){
    window.sendPost = function(url, obj){
        //Define o formulário
        var myForm = document.createElement("form");
        myForm.action = url;
        myForm.method = "post";
        for(var key in obj) {
             var input = document.createElement("input");
             input.type = "hidden";
             input.value = obj[key];
             input.name = key;
             myForm.appendChild(input);	
        }
        //Adiciona o form ao corpo do documento
        document.body.appendChild(myForm);
        //Envia o formulário
        myForm.submit();
    } 
}


/*FunÃ§Ã£o que padroniza valor monÃ©tario*/
function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }

   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));

   ret = num + ',' + cents;

   if (x == 1) ret = ' - ' + ret;return ret;

}

function moeda2float(moeda){


	strResultado = "";
		
	for(indmoeda = 0; indmoeda < moeda.length; indmoeda++){
		if(moeda.charAt(indmoeda) != '.'){
			strResultado += moeda.charAt(indmoeda);
		}
	}

	moeda = strResultado.replace(",",".");

	return parseFloat(moeda);

}



function abrirMenu(v_url){
    sendPost(v_url, {token: token});
}
function abrirMenuMovimentar(v_url){
    sendPost(v_url, {token: token,leads_pk:"",colaborador_pk:"",pk:""});
}

function montarUrlController(vController, vJob, v_ParametrosJob){
    
    var v_strParametros = "";
    var url = "";

    if(v_ParametrosJob){    
        $.each( v_ParametrosJob, function( key, value ) {
            v_strParametros += "&"+key+"="+encodeURIComponent(value);
        });
    }
    
    url = "../controller/"+vController+".controller.php?"+"job="+vJob+"&token="+token + "" +v_strParametros;
    
    v_last_url = url;
    
    return url;
}

function carregarController(vController, vJob, vParametrosJob){
    
    var v_strParametros = "";
    
    var url = montarUrlController(vController, vJob, vParametrosJob);
   
    var arrRetornoCarregarControle;
    
    var request = $.ajax({
        url:          url,
        cache:        false,
        async:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            arrRetornoCarregarControle = output;
        }else{
            alert('Falhou a requisição: '+output.message);
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha na req: ' + textStatus);
    });

    return arrRetornoCarregarControle;
    
}

function carregarComboAjax(objCBO, arrDadosCarregarCombo, vValorPrimeiroItem, vPk, vDescricao){

    if (arrDadosCarregarCombo.result == 'success'){
        //limpa o combo
        objCBO.empty();

        //adiciona um item vazio
        if(vValorPrimeiroItem!=""){     
            objCBO.append($('<option>', {
                value: "",
                text: vValorPrimeiroItem
            }));
        }

        //carrega com a nova lista.
        for(i = 0; i < arrDadosCarregarCombo.data.length; i++){
            objCBO.append($('<option>', {
                value: arrDadosCarregarCombo.data[i][vPk],
                text: arrDadosCarregarCombo.data[i][vDescricao],
            }));
        }

    } 
    
}

function arrayToJson(arrKeys, arrDados) {

    var i, s = '[';
    for (i = 0; i < arrDados.length; ++i) {
        s += "{";
        for(j = 0; j < arrKeys.length; ++j){
            s += '"' + arrKeys[j] + '":"' + arrDados[i][j] + '"';
            if (j < arrKeys.length - 1) {
                s += ',';
            }
        }
        s += "}";
        if (i < arrDados.length - 1) {
            s += ',';
        }            
    }
    s += ']';
    return s;
}
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout('execmascara()',1);
}
 
function execmascara(){
    v_obj.value=v_fun(v_obj.value);
}


function chama_mascara(o) {
    var v = o.value.replace(/\D/g, '');

    if (v.length > 11) {
        mascara(o, cnpj);
    }
    else {
        mascara(o, cpf);
    }
}

function cpf(v) {
	v = v.replace( /\D/g , ""); //Remove tudo o que não é dígito
	v = v.replace( /(\d{3})(\d)/ , "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dígitos
	v = v.replace( /(\d{3})(\d)/ , "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dígitos
	//de novo (para o segundo bloco de números)
	v = v.replace( /(\d{3})(\d{1,2})$/ , "$1-$2"); //Coloca um hífen entre o terceiro e o quarto dígitos
	return v;
}

function cnpj(v) {
	v = v.replace( /\D/g , ""); //Remove tudo o que não é dígito
	v = v.replace( /^(\d{2})(\d)/ , "$1.$2"); //Coloca ponto entre o segundo e o terceiro dígitos
	v = v.replace( /^(\d{2})\.(\d{3})(\d)/ , "$1.$2.$3"); //Coloca ponto entre o quinto e o sexto dígitos
	v = v.replace( /\.(\d{3})(\d)/ , ".$1/$2"); //Coloca uma barra entre o oitavo e o nono dígitos
	v = v.replace( /(\d{4})(\d)/ , "$1-$2"); //Coloca um hífen depois do bloco de quatro dígitos
	return v;
}

//data
function mdata(v){
    v=v.replace(/\D/g,"");    //Remove tudo o que não é dígito
    v=v.replace(/(\d{2})(\d)/,"$1/$2");       
    v=v.replace(/(\d{2})(\d)/,"$1/$2");       
                                             
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
    return v;
}

function mascaraTelefone(v){
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if (r.length > 10) {
      r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1)$2-$3");
    } else if (r.length > 5) {
      r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1)$2-$3");
    } else if (r.length > 2) {
      r = r.replace(/^(\d\d)(\d{0,5})/, "($1)$2");
    } else {
      r = r.replace(/^(\d*)/, "($1");
    }
    return r;

}

function moeda(v){
    v=v.replace(/\D/g,""); // permite digitar apenas numero
    v=v.replace(/(\d{1})(\d{17})$/,"$1.$2"); // coloca ponto antes dos ultimos digitos
    v=v.replace(/(\d{1})(\d{13})$/,"$1.$2"); // coloca ponto antes dos ultimos 13 digitos
    v=v.replace(/(\d{1})(\d{8})$/,"$1.$2"); // coloca ponto antes dos ultimos 8 digitos
    v=v.replace(/(\d{1})(\d{5})$/,"$1.$2"); // coloca ponto antes dos ultimos 5 digitos
    v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2"); // coloca virgula antes dos ultimos 4 digitos
    return v;
}
function porcentagem(v){
    v=v.replace(/\D/g,""); // permite digitar apenas numero
    v=v.replace(/(\d{1})(\d{17})$/,"$1.$2"); // coloca ponto antes dos ultimos digitos
    v=v.replace(/(\d{1})(\d{13})$/,"$1.$2"); // coloca ponto antes dos ultimos 13 digitos
    v=v.replace(/(\d{1})(\d{8})$/,"$1.$2"); // coloca ponto antes dos ultimos 8 digitos
    v=v.replace(/(\d{1})(\d{5})$/,"$1.$2"); // coloca ponto antes dos ultimos 5 digitos
    v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2"); // coloca virgula antes dos ultimos 4 digitos
    return v;
}

function soNumeros(v){
    return v.replace(/\D/g,"");
}

function horamask(v) {
    v = v.replace(/\D/g, "");                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = (v.substring(0, 1) > 2) ? "" : v;
    v = (v.substring(0, 1) == 1 && v.substring(1, 2) > 9) ? v.substring(0, 1) : v;
    v = (v.substring(0, 1) == 0 && v.substring(1, 2) > 9) ? v.substring(0, 1) : v;
    v = (v.substring(2, 3) > 5) ? v.substring(0, 2) : v;
    v = v.replace(/(\d{2})(\d)/, "$1:$2");    //Coloca dois pontos entre o segundo e terceiro d&#237;gitos
    v = (v.length > 5) ? v.substring(0, 5) : v;
    return v;
}
function horamasksemanal(v) {
    v = v.replace(/\D/g, "");                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = (v.substring(0, 1) > 9) ? "" : v;
    v = (v.substring(0, 1) == 1 && v.substring(1, 2) > 9) ? v.substring(0, 1) : v;
    v = (v.substring(0, 1) == 0 && v.substring(1, 2) > 9) ? v.substring(0, 1) : v;
    v = (v.substring(2, 3) > 5) ? v.substring(0, 2) : v;
    v = v.replace(/(\d{2})(\d)/, "$1:$2");    //Coloca dois pontos entre o segundo e terceiro d&#237;gitos
    v = (v.length > 5) ? v.substring(0, 5) : v;
    return v;
}

function cep(d){
    d = soNumeros(d);
    d=d.replace(/^(\d{5})(\d)/,"$1-$2");
    return d;
}

function permissao(ds_dominio_modulo,ic_acao){

    var url = "../controller/usuario.controller.php?"+"job=verificarPermissao&token="+token+"&ds_dominio_modulo="+ds_dominio_modulo+"&ic_acao="+ic_acao;
   
    var arrRetornoCarregarControle;
    
    var request = $.ajax({
        url:          url,
        cache:        false,
        async:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            arrRetornoCarregarControle = output;
        } 
        else{
            //alert(output.message);
            //sendPost("../index.php", {token: token});
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha na req: ' + textStatus);
    });

    return arrRetornoCarregarControle;
    
}

function permissaoAtualizada(vController, vJob, vParametrosJob){

    var v_strParametros = "";
    
    var url = montarUrlController(vController, vJob, vParametrosJob);
    var arrRetornoCarregarControle;
    
    var request = $.ajax({
        url:          url,
        cache:        false,
        async:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            arrRetornoCarregarControle = output;
        } 
        else{
            arrRetornoCarregarControle = output;
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha na req: ' + textStatus);
    });

    return arrRetornoCarregarControle;
    
}

function carregarComboAjaxResponsavel(objCBO, arrDadosCarregarCombo, vValorPrimeiroItem, vPk, vDescricao){
    
    if (arrDadosCarregarCombo.result == 'success'){
        //limpa o combo
        objCBO.empty();

        //adiciona um item vazio
        if(vValorPrimeiroItem!=""){
            objCBO.append($('<option>', {
                value: "",
                text: vValorPrimeiroItem
            }));
        }
        objCBO.append($('<option>', {
            value: "Null",
            text: "Nenhuma"
        }));
        //carrega com a nova lista.
        for(i = 0; i < arrDadosCarregarCombo.data.length; i++){
            objCBO.append($('<option>', {
                value: arrDadosCarregarCombo.data[i][vPk],
                text: arrDadosCarregarCombo.data[i][vDescricao],
            }));
        }

    } 
    
}
function permissaoLogin(ds_dominio_modulo,ic_acao,token){
    
    var url = "../controller/usuario.controller.php?"+"job=verificarPermissao&token="+token+"&ds_dominio_modulo="+ds_dominio_modulo+"&ic_acao="+ic_acao;

    var arrRetornoCarregarControle;
    
    var request = $.ajax({
        url:          url,
        cache:        false,
        async:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            arrRetornoCarregarControle = output;
        } 
        else{
            arrRetornoCarregarControle = output;
            //alert(output.message);
            //sendPost("../index.php", {token: token});
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha na req: ' + textStatus);
    });

    return arrRetornoCarregarControle;
    
}

function DataYMD(strData){
	var arr = strData.split("/");
	return arr[2]+"-"+arr[1]+"-"+arr[0];
}
