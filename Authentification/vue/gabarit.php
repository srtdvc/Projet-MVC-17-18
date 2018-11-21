<!DOCTYPE html>
<html>
<head>
	<title>Authentification</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Authentification/vue/style/style.css">
</head>
<body>
<strong>Veuillez vous authentifier</strong>
<div class="login">
<form action="garage.php" method="post">
	<fieldset>
	<legend>Compte</legend>
			<p>
				<label for="identifiant">Identifiant : </label>
				<input type="text" name="login" autofocus required size="20" maxlength="10" />

			</p>
			<p>
				<label for="mdp">Mot de passe : </label>
				<input type="password" name="mdp"  required size="20" maxlength="10" />

			</p>
		
	</fieldset>
	<p>
		<input type="submit" value="Se connecter" name="connexion"/>
		<input type="reset" value="Recommencer"/>
	</p>
	
	<?php echo $contenu ?>
</form>
</div>
<footer>
	<strong>Tous droits réservés SnK 2018 </strong>

</body>
</html>