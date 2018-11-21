<!DOCTYPE html>
<html>
<head>
	<title>Mécanicien</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="vue/style/style.css">
  
</head>
<body>
<header>
		<div class="logo"><img src="vue/logo/logo1.png" alt="logo" title="logo" /></div>
	<nav>
		<ul>
			<li>Fiche fourniture</li>
			<li>Contacter le siège</li>
			<li>Numéros d'urgences</li>
			<li>Mise à jour des fiches méthodes de réparation</li>
		</ul>
	</nav>
			
	</header>
<form action="Mecanicien.php" method="post">
	<p>
		<input type="submit" value="Deconnexion" name="deconnexion"/>
	</p>

</form>
	
<form action="Mecanicien.php" method="post">
	<fieldset><legend>Nom Mecanicien</legend>
	<p>
		<label for="id">Nom : </label>
		<input type="text" name="nom"  />
	</p>
	<p>
		<label for="id">Semaine : </label>
		<input type="text" name="semaine"  />
	</p>
	<p>
		<input type="submit" value="Planning" name="planning"/>
	</p>
	</fieldset>
</form>

	<?php echo $contenu; ?>
	

</body>
</html>
