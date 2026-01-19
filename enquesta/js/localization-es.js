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

wFORMS.behaviors['validation'].errMsg_required     = "Sección obligatoria. "; // required
wFORMS.behaviors['validation'].errMsg_alpha        = "Solo se admiten letras (a-z A-Z). No se permiten números."; // no numbers 
wFORMS.behaviors['validation'].errMsg_email        = "No es una dirección de correo electrónico válida."; // validate email 
wFORMS.behaviors['validation'].errMsg_integer      = "Introducir un número entero (ej. 3). "; // integer 
wFORMS.behaviors['validation'].errMsg_float        = "Introducir un número decimal (ex. 1,9) ."; // float 
wFORMS.behaviors['validation'].errMsg_password     = "La contrasenya no és segura. Introduïu de quatre a dotze caràcters i combineu-hi majúscules i minúscules. "; // password
wFORMS.behaviors['validation'].errMsg_alphanum     = "Introduïu únicament caràcters alfanumèrics (a-z i 0-9). "; // alphanumeric
wFORMS.behaviors['validation'].errMsg_date         = "La data no es correcta. "; // date
wFORMS.behaviors['validation'].errMsg_notification = "Se ha encontrado %% error. El formulario no se ha enviado. Verifique los datos introducidos."; // %% errors.

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
