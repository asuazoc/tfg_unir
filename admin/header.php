<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<title>Gestió del congres: <?=$titol_congres?></title>
		 
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="style/reset.css" type="text/css" media="screen">
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="style/style.css" type="text/css" media="screen">
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="style/invalid.css" type="text/css" media="screen">	
		
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="style/ie.css" type="text/css" media="screen" />
		<![endif]-->
		
		<!--                       Javascripts                       -->
  
		<!-- jQuery
		<script type="text/javascript" src="js/jquery-1.js"></script>-->
		<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="js/simpla.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="js/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin 
		<script type="text/javascript" src="js/jquery.js"></script>
		-->

		<!-- jQuery Datepicker Plugin -->

		<script type="text/javascript" src="js/jquery.datePicker.js"></script>

		<!--[if IE]><script type="text/javascript" src="js/jquery.bgiframe.js"></script><![endif]-->

		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="js/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->


		<! --jQuery Table-->
		

		<link rel="stylesheet" href="style/table/themes/blue/style.css" type="text/css" media="print, projection, screen" /> 
		<script type="text/javascript" src="js/table/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="js/table/addons/pager/jquery.tablesorter.pager.js"></script>
		<script type="text/javascript" src="js/jquery.doomEdit.js"></script>
		
		<script type="text/javascript">
		$(document).ready(function() 
    			{ 
				$("#pagerTable").tablesorter({widthFixed: false, widgets: ['zebra']});      
				$('.edit-order').doomEdit(
					{
						editForm:{
							method:'post',
							action:'comunicacions-sort.php',
							id:'myeditformid'
						},
						afterFormSubmit: function (data, form, el) {el.text(data);}
					}
				);

	    	} 
		); 
		</script>
	</head><body>

<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="#">Admin</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="images/logo.png" alt="Admin logo"></a>
		  
			<!-- Sidebar Profile links -->
			<div id="profile-links">
				<?php $nomUser = utf8_encode($_SESSION['name']);
				if(mb_detect_encoding($nomUser,'UTF8')){
					$nomUser = utf8_decode($nomUser);
				}
				?>
				Hola, <a href="#" title="Edit your profile"><?=$nomUser?></a><br>
				<br>
				<a href="logout.php" title="Sign Out">Desconnecta</a>
			</div>  
