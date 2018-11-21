<!DOCTYPE html>
<html>
<head>
	<title>Agent</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="vue/style/style.css">
</head>
<body>
<header>
<div class="logo"><img src="vue/logo/logo1.png" alt="logo" title="logo" /></div>
	<nav>
		<ul>
			<li>Nos véhicules d'occasions</li>
			<li>Contacter le siège</li>
			<li>Numéros d'urgences</li>
			<li>Nos coordonnées</li>
		</ul>
	</nav>
			
	</header>

<form action="Agent.php" method="post">
	<p>
		<input type="submit" value="Nouveau Client" name="nouveauClient"/>
		<input type="submit" value="Prise de RDV" name="listePourRdv"/>
		<input type="submit" value="Deconnexion" name="deconnexion"/>
	</p>
</form>

<form action="Agent.php" method="post">
	<fieldset><legend>Recherche ID</legend>
	<p>
		<label for="id">Nom : </label>
		<input type="text" name="nom"  />
	</p>
	<p>
		<label for="id">Prenom : </label>
		<input type="text" name="prenom"  />
	</p>
	<p>
		<label for="id">Date : </label>
		<input type="date" name="naissance"   />
	</p>
	<p>
		<input type="submit" value="Rechercher ID" name="searchID"/>
	</p>
	</fieldset>
</form>

	<?php echo $contenuID ?>


<form action="Agent.php" method="post">
	<fieldset>
	<legend>Intervention Client</legend>
			<p>
				<label for="id">Identifiant client : </label>
				<input type="text" name="idclient"  />

			</p>
			<p>
				<input type="submit" value="Valider" name="valide"/>
			</p>
	</fieldset>
	

</form>
	
	<?php echo $contenu ?>
	<?php echo $contenuDerInter ?>
	<?php echo $contenuInterDiffere ?>
	<?php echo $contenuInterPaye ?>
	
	<form action="Agent.php" method="post">
	<fieldset>
	<legend>Synthese</legend>
			<p>
				<label for="id">Identifiant client : </label>
				<input type="text" name="idclient"  />

			</p>
			<p>
				<input type="submit" value="Synthese" name="synthese"/>
			</p>
	</fieldset>
	

</form>

	
	<?php echo $contenuFicheClient ?>
	<?php echo $contenuMontantTotal?>
	<?php echo $contenuMontantPossible ?>
	<?php echo $contenuInterventionDuClient ?>
	
	
</body>
</html>