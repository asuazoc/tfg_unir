/***********************************************************************
 * Fichero: sha1.js
 * Descripción: JavaScript Algoritmo SHA-1 para mensajes de 
 *              longbits máxima de 55 caracteres.
 *
 * Autor: PG - SERMEPA 10/12/1999
 *
 ***********************************************************************/
var H1 = 0x67452301;
var H2 = 0xefcdab89;
var H3 = 0x98badcfe;
var H4 = 0x10325476;
var H5 = 0xc3d2e1f0;

function hash(cadena)
{
/***********DEBUG *******************************/
/*alert("La cadena de entrada al hash es: " + cadena);*/

/***********DEBUG *******************************/

	buffer=new Array();

	/* Número de bytes */
	var longitud=cadena.length;
/***********DEBUG *******************************/
/*alert("La longitud de la cadena es: " + longitud);*/
/***********DEBUG *******************************/
	var longbits=longitud*8;
/*alert("La longitud de la cadena en bits es: " + longbits);*/
    var cadenaLen=String.fromCharCode(0x0,0x0,0x0,0x0,((longbits >>> 24) & 0xff),((longbits >>> 16) & 0xff),((longbits >>> 8) & 0xff),(longbits  & 0xff));
	var index=0;
    var padding=String.fromCharCode(0x80,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,
								0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,
								0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,
								0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,
								0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,
								0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,0x0,
								0x0,0x0,0x0,0x0);


    iniciar();

	if(longitud >= 64){
		/* Procesar bloques de 64 */
		for (indice = 0; indice + 63 < longitud; indice += 64){
			transformar(cadena.substr(indice,64));
			index+=64}
	}
  longitud-=index;

  /* Padding */  
  padLen = (longitud < 56) ? (56 - longitud) : (120 - longitud);

  /**alert("padLEn es: " + padLen);
  alert("cadenaLen es: " + cadenaLen);
  alert("padding es: " + padding.substr(0,padLen-56));
**/
  if(longitud < 56)
  {
	transformar(cadena.substr(index)+padding.substr(0,padLen)+cadenaLen);
	
  }else{

	transformar(cadena.substr(index)+padding.substr(0,padLen-56));
/***********DEBUG *******************************/
/**alert(word_string(H1)+":"+word_string(H2)+":"+word_string(H3)+":"+word_string(H4)+":"+word_string(H5));
**/
/***********DEBUG *******************************/
	transformar(padding.substr(padLen-56, 56)+cadenaLen);

  }


	/*
	 * convertir a string
	 */
	  return (word_string(H1)+word_string(H2)+word_string(H3)+word_string(H4)+word_string(H5));

}/* Fin función hash */

function iniciar(){

H1 = 0x67452301;
H2 = 0xefcdab89;
H3 = 0x98badcfe;
H4 = 0x10325476;
H5 = 0xc3d2e1f0;
}
function transformar(cadena)
{
/*alert("transformar("+cadena+")");*/
	var Y1 = 0x5a827999;
	var Y2 = 0x6ed9eba1;
	var Y3 = 0x8f1bbcdc;
	var Y4 = 0xca62c1d6;

	buffer=new Array();
	words=new Array();

/*alert(word_string(H1)+":"+word_string(H2)+":"+word_string(H3)+":"+word_string(H4)+":"+word_string(H5));*/

	for(i=0;i<cadena.length;i++){
	  buffer[i]=cadena.charCodeAt(i);
      /*alert("buffer["+i+"]"+buffer[i]);*/}


	/* Pasar  bloque de 64 bytes a 16 words */
	for(i=0,j=0;i<64;i+=4,j++){
	  words[j]=((buffer[i + 0] << 24) & 0xff000000)|((buffer[i + 1] << 16) & 0x00ff0000) |
			   ((buffer[i + 2] <<  8) & 0x0000ff00)|(buffer[i + 3] & 0x000000ff);		   

	  }
/***********DEBUG *******************************/
/**for(k=0;k<16;k++)
alert("word"+k+":"+word_string(words[k]));
***/
/***********DEBUG *******************************/
	/* Procesar */

	for (i = 16; i <= 79; i++)
	{
		t = words[i - 3]^ words[i - 8]^ words[i - 14]^ words[i - 16];
		words[i] = circularRotate(t, 1);
	}

	// Comienzo calculo SHA1
	var A = H1;
	var B = H2;
	var C = H3;
	var D = H4;
	var E = H5;
	var t;
	/*
	 * vuelta 1
	 */
	for (j = 0; j <= 19; j++)
	{
		t = circularRotate(A, 5) + f(B, C, D) + E + words[j] + Y1;
		E = D;	D = C;	C = circularRotate(B, 30);	B = A;	A = t;
	}

	/*
	 * vuelta 2
	 */
	for (j = 20; j <= 39; j++)
	{
		t = circularRotate(A, 5) + h(B, C, D) + E + words[j] + Y2;
		E = D;	D = C;	C = circularRotate(B, 30);	B = A;	A = t;
	}

	/*
	 * vuelta 3
	 */
	for (j = 40; j <= 59; j++)
	{
		t = circularRotate(A, 5) + g(B, C, D) + E + words[j] + Y3;
		E = D;	D = C;	C = circularRotate(B, 30);	B = A;	A = t;
	}

	/*
	 * vuelta 4
	 */
	for (j = 60; j <= 79; j++)
	{
		t = circularRotate(A, 5) + h(B, C, D) + E + words[j] + Y4;
		E = D;	D = C;	C = circularRotate(B, 30);	B = A;	A = t;
	}

	H1 += A;
	H2 += B;
	H3 += C;
	H4 += D;
	H5 += E;

}

function circularRotate(x,n)
{
	return (x << n) | (x >>> (32 - n));
}/* Fin función circularRotate */
function f(u,v,w)
{
	return ((u & v) | ((~u) & w));
}

function h(u,v,w)
{
		return (u ^ v ^ w);
}

function g(u,v,w)
{
		return ((u & v) | (u & w) | (v & w));
}
function word_string(a)
{
 b1 = ((a >>> 28) & 0xf); 
 b2 = ((a >>> 24) & 0xf); 
 b3 = ((a >>> 20) & 0xf);
 b4 = ((a >>> 16) & 0xf);
 b5 = ((a >>> 12) & 0xf);
 b6 = ((a >>> 8) & 0xf);
 b7 = ((a >>> 4) & 0xf);
 b8 = (a & 0xf);
 return (b1.toString(16)+b2.toString(16)+b3.toString(16)+b4.toString(16)+ 
         b5.toString(16)+b6.toString(16)+b7.toString(16)+b8.toString(16));
}
function decode(a)
{    
 b1 = ((a >>> 24) & 0xff); 
 b2 = ((a >>> 16) & 0xff);
 b3 = ((a >>> 8) & 0xff);
 b4 = (a & 0xff);
 return (String.fromCharCode(b1,b2,b3,b4));
}

function hmac(clave, texto){
	/* H(clave XOR opad, H(clave XOR ipad, texto)) */
	/* clave menor de 64 bytes */
	
	key_1=new Array();
	key_2=new Array();
	words=new Array();

	for(index=0;index<clave.length;index++)
	  key_1[index]=clave.charCodeAt(index);

	for(;index<64;index++)
	  key_1[index]=0x0;

/***********DEBUG *******************************/
/***	for(k=0;k<64;k++)
alert("Buffer["+k+"]: "+ key_1[k]);***/
/***********DEBUG *******************************/
	for(index=0;index<64;index++){
	  key_2[index]=key_1[index]^0x5c;
	  key_1[index]^=0x36;
	  }
/***********DEBUG *******************************/
/***	for(k=0;k<64;k++)
alert("key_1["+k+"]: "+ key_1[k]+"key_2["+k+"]: "+ key_2[k]);***/
/***********DEBUG *******************************/
clave_1=String.fromCharCode(key_1[0],key_1[1],key_1[2],key_1[3],key_1[4],key_1[6],key_1[7],key_1[8],key_1[9],key_1[10],
						    key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],
							key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],
							key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],
							key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],
							key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],key_1[0],
							key_1[0],key_1[0],key_1[0],key_1[0]);
	
	/* Append con texto */	
	hash(String.fromCharCode(key_1)+texto);
	var digest=decode(H1)+decode(H2)+decode(H3)+decode(H4);

	/* Append con clave */	
	return(hash(String.fromCharCode(key_2)+digest));

}


