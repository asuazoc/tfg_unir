<?php
include 'classes/menu.class.php';


if (($_SESSION['rol']=="admin")){
	$menu_items = array
	(
		array
		(
			'title' => 'Inscripciones',
			'url' => '#',
			'children' => array
			(
				array
				(
					'title' => 'Listado Inscripciones',
					'url' => 'lst_inscripcions.php',
				),

				array
				(
					'title' => 'Resumen Inscripciones',
					'url' => 'lst_control_inscrits.php',
				),
				array
				(
					'title' => 'Incidéncias',
					'url' => 'lst_incidencies.php',
				)


			),
		),
		array
		(
			'title' => 'Reservas',
			'url' => '#',
			'children' => array
			(

				array
				(
					'title' => 'Listado Reservas',
					'url' => 'lst_reserves.php',
				),
				array
				(
					'title' => 'Resumen Reservas',
					'url' => 'control_reserves.php',
				)
			),
		),
		array
		(
			'title' => 'Comunicaciones',
			'url' => '#',
			'children' => array
			(

				array
				(
					'title' => 'Listado Comunicaciones',
					'url' => 'lst_comunicacions.php',
				),
				array
				(
					'title' => 'Resumen Comunicaciones',
					'url' => 'lst_fulls_comunicacions.php',
				),
				/*array
				(
					'title' => 'Diplomas Comunicaciones',
					'url' => 'lst_diplomes.php',
				),*/
				array
				(
					'title' => 'Listado Comunicaciones Eliminadas',
					'url' => 'lst_comunicacions_eliminades.php',
				),
				array
				(
					'title' => 'Evaluadores',
					'url' => 'lst_evaluadors.php',
				),
		       		array
				(
					'title' => 'Notas',
					'url' => 'lst_comunicacions_nota.php',
				),
				array
				(
					'title'=>'Evaluadores/Notas',
					'url'=>'lst_avaluadors_nota.php',
				),
				/*array
				(
					'title'=>'Comunicaciones evaluadores/notas completo',
					'url'=>'lst_avaluadors_nota_complet.php',
				),
				array
				(
					'title' => 'Notes Revisió',
					'url' => 'lst_avaluadors_nota_revisio.php',
				),
				array
				(
					'title'=>'Comunicaciones programa',
					'url'=>'lst_comunicacions_programa.php',
				)*/

			),
		),
		array
		(
			'title' => 'Facturaci&oacute;n',
			'url' => '#',
			'children' => array
			(


				array
				(
					'title' => 'Listado Facturas',
					'url' => 'lst_factures.php',
				)
			),
		)
		,
		array
		(
			'title' => 'Otros',
			'url' => '#',
			'children' => array
			(
				array
				(
					'title' => 'Assistentes Cena',
					'url' => 'control_sopar.php',
				),
				array
				(
					'title' => 'Control certificados de asistencia',
					'url' => 'control_certificats_assist.php',
				)
			),
		)
	);
}

if (($_SESSION['rol']=="evaluador")){
	$menu_items = array
	(
		array
		(
			'title' => 'Comunicaciones',
			'url' => '#',
			'children' => array
			(
				array
				(
					'title' => 'Evaluación de Comunicaciones',
					'url' => 'lst_comunicacions_avaluacio.php',
				)
			)
		)
	);
}

$menu_attrs = array
(
	'id' => 'main-nav'
);

//
if (!isset($menu_current)){
	$file = $_SERVER["SCRIPT_NAME"];
	$break = explode('/', $file);
	$menu_current = $break[count($break) - 1];
}

echo " <!-- Accordion Menu -->";
echo menu::factory($menu_items)->render($menu_attrs, $menu_current);
echo "<!-- End #main-nav -->";
?>
