<?php
include 'classes/menu.class.php';


$menu_items = array
(
	array
	(
		'title' => TXT_DOCUMENTACIONS,
		'url' => '#'
	)
);


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
