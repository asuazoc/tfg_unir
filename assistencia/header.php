<?php
	$aPartsPhpSelf = explode('/',$_SERVER['PHP_SELF']);
	$iPag          = count($aPartsPhpSelf)-1;
?>
<nav class="navbar navbar-expand-lg" data-bs-theme="light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?=CARPETA_WEB;?>" target="_blank" title="Obrir pàgina principal del lloc web en una pestanya nova"><?=SESSIO_CONTROL?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
			<?if(isset($_SESSION['nom'])){?>
			<ul class="navbar-nav">
				<li class="nav-item">
						<a <?=(($aPartsPhpSelf[$iPag]=='control_assistencia.php')?'class="nav-link active" aria-current="page"':'class="nav-link"')?>  href="<?=CARPETA_WEB;?>/control_assistencia.php">Control de asistencia</a>
				</li>
        <?php //session_start();
				if($_SESSION['rol']=='admin'){?>
					<li class="nav-item">
	  					<a <?=(($aPartsPhpSelf[$iPag]=='lst_inscripcions.php')?'class="nav-link active" aria-current="page"':'class="nav-link"')?> href="<?=CARPETA_WEB;?>/lst_inscripcions.php">Listado de asistencia</a>
					</li>
					<li class="nav-item">
	  					<a <?=(($aPartsPhpSelf[$iPag]=='lst_acreditacions.php')?'class="nav-link active" aria-current="page"':'class="nav-link"')?> href="<?=CARPETA_WEB;?>/lst_acreditacions.php">Acreditaciones</a>
					</li>
				<?}?>
				<li class="nav-item">
						<a class="nav-link" href="<?=CARPETA_WEB;?>/logout.php">
						<i class="fa-solid fa-right-from-bracket"></i> Sortir</a>
				</li>
				<li class="nav-item menuDisabled">
				    <a class="nav-link" href="">
					<i class="fa-regular fa-user"></i><?= ' '.$_SESSION['nom'];?></a>
				</li>
      </ul>
			<?}else{
				echo $titol_congres;
			}?>
		</div>
  </div>
</nav>
