<!DOCTYPE html>
<html>
<head>
	<title>Directeur</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="vue/style/style.css">
</head>
<body>

	

	</form>
	<header>
		<div class="logo"><img src="vue/logo/logo1.png" alt="logo" title="logo COD"/></div>
		
	<nav>
		<ul>
			<li>Nos vehicules d'occasions</li>
			<li>Contacter le siège</li>
			<li>Numéros d'urgences</li>
			<li>Nos coordonnées</li>
		</ul>
	</nav>
		
			
	</header>
	
	<form action="directeur.php" method="post">
		<p>
		<div class="img1"><img src="vue/icone/modifier.png" alt="Reglage" title="Personnel" style="width:150px " /> </a>
			<input type="submit" value="Gestion du personnel" name="personnel" />
		</p>
		<p>
		<div class="img2"><img src="vue/icone/settings.jpg" alt="Reglage" title="Garage" style="width:150px" /> </a>
			<input type="submit" value="Gestion du garage" name="garage" />
		</p>
		<p>
		<div class="img3"><img src="vue/icone/checklist.png" alt="Reglage" title="Checklist" style="width:150px" /> </a>
			<input type="submit" value="Gestion des éléments" name="liste" />
		</p>
	</form>
		
	<?php echo $contenu; ?>
	
	<form action="Directeur.php" method="post">
		<p>
			<input type="submit" value="Deconnexion" name="deconnexion"/>
		</p>
	
	

</body>
</html>