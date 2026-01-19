function despresDesar(resposta){
	if(resposta.error==1){
		$('#msg_resulat_ko').html(resposta.txterror);
		$('#msg_resulat_ko').show();
		$('#msg_resulat_ok').hide();

		console.log(resposta);

		if (resposta.hasOwnProperty('no_places')) {
			const INPUT_TEL     = document.getElementById('tipus-assistencia-tel');      // input#tipus-assistencia-tel
			const INPUT_PRE     = document.getElementById('tipus-assistencia-pre');      // input#tipus-assistencia-pre
			const INPUT_PRE_TXT = document.getElementById('tipus-assistencia-pre-txt');  // span#tipus-assistencia-pre-txt
			const DIV_RADIO     = INPUT_PRE.parentElement.parentElement;                 // lavel > div.radio

			// Modifiquem dades formulari.
			INPUT_PRE.checked  = false;
			INPUT_PRE.disabled = true;
			INPUT_PRE.removeAttribute('class');
			INPUT_PRE.removeAttribute('required');
			INPUT_PRE.removeAttribute('name');
			INPUT_PRE.removeAttribute('value');

			INPUT_PRE_TXT.innerText = 'Presencial (0 places)';
			INPUT_PRE_TXT.classList.add('text-muted');

			INPUT_TEL.checked = true;

			DIV_RADIO.classList.add('disabled');

			// Fem scroll fins la part superior perquè es vegi el missatge d'error.
			window.scrollTo(0, 0);
		}

	}else{
		$('#msg_resulat_ok').html("S'ha desat la inscripció");
		$('#form').hide();
		$('#msg_resulat_ok').show();
		$('#msg_resulat_ko').hide();
	}
}

function calcularTotal(){
	var inscripcio = $('input[name=tipus_inscripcio]:checked', '#form').val();
	var total = 0;
	var tipus_inscripcio='';
	
	if(inscripcio){
		var partsI = inscripcio.split('_');		
		if(partsI[1]){
			total = parseInt(partsI[1]);
			tipus_inscripcio = partsI[0];						
		}
	}
	if($('input[name=taller]:checked', '#form').val()=='S'){
		total = total + parseInt("<?php echo $preu_taller;?>");
	}
	$('#total').val(total);
	$('#tipus_inscripcio').val(tipus_inscripcio);
	$('#span_total').html(total);
	$('#validat').val('1');
}

// En carregar-se la pàgina
$(document).ready(function() {
	var options = {
		beforeSubmit: function(){
			$("#form").validate();			
			if(($('#nom_autor').val()=='')||($('#cognoms_autor').val()=='')||($('#nif_autor').val()=='')||($('#centre_autor').val()=='')||($('#correu_autor').val()=='')||($('#tel_autor').val()=='')){
				alert('Falten camps obligatoris');
				return false;
			}
		},
		success: function(resposta){
			despresDesar(resposta);
		},
		dataType: 'json'
	}
	$("#form").ajaxForm(options);
	calcularTotal();
		
	$('.tipus_inscripcio').click(function() {
	  	calcularTotal();
	});	
		
	$('.tipus_inscripcio').each(function(e) {		
		$('#'+this.id).click(function() {
			calcularTotal();
		});
	});
	
	/*$('#tallerN').on('click',function(){
		$("#tipus_taller").hide();
		$(".titol_tipus_taller").hide();
	});
	
	$('#tallerS').on('click',function(){
		$("#tipus_taller").show();
		$(".titol_tipus_taller").show();
	});*/
	
    $('#tallerN').click(function() {
        if ($(this).prop('checked')) {
            $('input.tipus_taller').prop('disabled', true);
            $('input.tipus_taller').prop('checked', false);
        }
    });
    
    $('#tallerS').click(function() {
        if ($(this).prop('checked')) {
            $('input.tipus_taller').prop('disabled', false);
        }
    });

	$('.taller').each(function(e) {		
		$('#'+this.id).click(function() {
			calcularTotal();
		});
	});
		
	$('.btn').on('click', function() {
	    var $this = $(this);
	  $this.button('loading');
	    setTimeout(function() {
	       $this.button('reset');
	   }, 2000);
	});
	
});

