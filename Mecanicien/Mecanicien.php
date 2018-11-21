<?php

require_once('controleur/controleur.php');

try{
	if(isset($_POST['planning'])){
		$nom = $_POST['nom'];
		$semaine = $_POST['semaine'];
		Ctl_Visualisation_Planning_Semaine($nom,$semaine);
	}elseif(isset($_POST['deconnexion'])){
		CtlAuthentification();
	}elseif(isset($_POST['info'])){
		CltSyntheseIntervention();
	}elseif(isset($_POST['insererFormation'])){
		CtlAfficherFormation();
	}elseif(isset($_POST['validerFormation'])){
		$idEmploye=$_POST['idEmploye'];
		$dateFormation=$_POST['date'];
		$heureFormation=$_POST['heure'];
		CtlAjouterFormation($dateFormation,$heureFormation,$idEmploye);
	}else{
		CtlAccueil();
	}
}catch(Exception $e){
	$msg=$e->getMessage();
	CtlErreur($msg);
}