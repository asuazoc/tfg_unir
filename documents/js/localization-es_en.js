// Localització catalana per al wForms, una extensió en Javascript per als formularis electrònics
// wForms en català - 23 de maig de 2005
// Anna Grau (agrau@ya.com)
// Aquest programa està llicenciat sota CC-GNU LGPL (http://creativecommons.org/licenses/LGPL/2.1/)

// Per a més informació, visiteu: http://formassembly.com/blog/how-to-localize-wforms/
// Per cridar la versió catalana del wForms, afegiu-hi la indicació del fitxer de localització a sota de "wforms.js"
// Per exemple: 
// <head>
//<meta http-equiv="content-type" content=" content=; charset=UTF-8" >...
// <script type="text/javascript" src="wforms.js" ></script>
// <script type="text/javascript" src="localization-ca.js" ></script>
// </head>

wFORMS.behaviors['validation'].errMsg_required     = "Este campo es obligatorio. / This field is required. "; // required
wFORMS.behaviors['validation'].errMsg_alpha        = "No introduïu xifres en els camps de text (a-z). "; // no numbers 
wFORMS.behaviors['validation'].errMsg_email        = "El correu electrónico no es válido. / This does not appear to be a valid email address."; // validate email 
wFORMS.behaviors['validation'].errMsg_integer      = "Introducir un numero entero. / Please enter an integer."; // integer 
wFORMS.behaviors['validation'].errMsg_float        = "Introduïu un nombre decimal (p. ex. 1,9) ."; // float 
wFORMS.behaviors['validation'].errMsg_password     = "La contrasenya no és segura. Introduïu de quatre a dotze caràcters i combineu-hi majúscules i minúscules. "; // password
wFORMS.behaviors['validation'].errMsg_alphanum     = "Introduïu únicament caràcters alfanumèrics (a-z i 0-9). "; // alphanumeric
wFORMS.behaviors['validation'].errMsg_date         = "La data no és correcta. "; // date
wFORMS.behaviors['validation'].errMsg_notification = "%% error(es) detectados / error(s) detected.\nEl formulario no se ha podido enviar. Verifique los datos que ha introducido. / \n Your form has not been submitted yet.Please check the information you provided. "; // %% errors.

wf.arrMsg[0] = "Afegeix una altra fila. "; // repeat row
wf.arrMsg[1] = "Repiteix el camp o el grup anterior. " // repeat row title 
wf.arrMsg[2] = "Suprimeix"; // remove row
wf.arrMsg[3] = "Suprimeix el camp o el grup anterior. " // remove row title
wf.arrMsg[4] = "Pàgina següent";
wf.arrMsg[5] = "Pàgina anterior";


// Alpha-Numeric Input Validation: 
wFORMS.behaviors['validation'].isAlpha = function(s) {
	var reg = /^[\u0041-\u007A\u00C0-\u00FF\u0100-\u017F]+$/; 
	return this.isEmpty(s) || reg.test(s);
}

wFORMS.behaviors['validation'].isAlphaNum = function(s) {
	var reg = /^[\u0030-\u0039\u0041-\u007A\u00C0-\u00FF\u0100-\u017F]+$/;
	return this.isEmpty(s) || reg.test(s);
}
// Unicode ranges (from http://www.unicode.org/) :
// \u0030-\u0039 : Numbers 0-9
// \u0041-\u007A : Basic Latin : For english, and ASCII only strings (ex: username, password, ..)
// \u00C0-\u00FF : Latin-1 : For Danish, Dutch, Faroese, Finnish, Flemish, German, Icelandic, Irish, Italian, Norwegian, Portuguese, Spanish, and Swedish.
// \u0100-\u017F : Latin Extended-A (to be used with Basic Latin and Latin-1) : Afrikaans, Basque, Breton, Catalan, Croatian, Czech, Esperanto, Estonian, French, Frisian, Greenlandic, Hungarian, Latin, Latvian, Lithuanian, Maltese, Polish, Provençal, Rhaeto-Romanic, Romanian, Romany, Sami, Slovak, Slovenian, Sorbian, Turkish, Welsh, and many others.
// \u0180-\u024F : Latin Extended-B (to be used with Basic Latin and Latin-1) : ?
// \u1E00-\u1EFF : Latin Extended Additional : Vietnamese ?
// \u0370-\u03FF : Greek
// \u0400-\u04FF : Cyrillic : Russian, etc..
// \u0590.\u05FF : Hebrew (and #FB1D - #FB4F ?)
// \u0600.\u06FF : Arabic
// \u0900.\u097F : Devanagari : Hindi, etc..
// \u4E00.\u9FFF : Han - common ideographs : Chinese, Japanese, and Korean languages.
// See http://www.unicode.org/charts/ for other languages
