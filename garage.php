<?php

require_once('Authentification/controleur/controleur.php');

try{
	if(isset($_POST['connexion'])){
		$nom=$_POST['login'];
		$mdp=$_POST['mdp'];
		CtlCheckUser($nom,$mdp);
	}
	else{
		CtlAccueil();
	}
}catch(Exception $e){
	$msg=$e->getMessage();
	CtlErreur($msg);
}
