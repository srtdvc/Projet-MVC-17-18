<?php

require_once('controleur/controleur.php');

try{
	if(isset($_POST['valide'])){
		$idclient = $_POST['idclient'];
		Ctl_intervention_client($idclient);
	}elseif(isset($_POST['validerDernierPayement'])){
		//$idClient = $_POST['idClient'];
		foreach($_POST as $key => $val){
			Ctl_payer_intervention_cash(11,$key);
		}
	}elseif(isset($_POST['demandeDiffere'])){
		foreach($_POST as $key => $val){
			/*$idClient = $_POST['idClient'];*/
			Ctl_verification_differe_possible(11,$key);
		}
	}elseif(isset($_POST['validerDiffere'])){
		/*$idClient = $_POST['idClient'];*/
		Ctl_rembourser_differe(11);
	}elseif(isset($_POST['synthese'])){
		$idclient = $_POST['idclient'];
		CtlSyntheseClient($idclient);
	}elseif(isset($_POST['modif'])){
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$sexe=$_POST['sexe'];
		$ddn=$_POST['naissance'];
		$adresse=$_POST['adresse'];
		$codePostal=$_POST['postal'];
		$numTel=$_POST['numTel'];
		$mail=$_POST['mail'];
		$ville=$_POST['ville'];
		$pays=$_POST['pays'];
		$montantDiffereMax=$_POST['montant'];
		$idClient = Ctl_ReturnIdClient($nom,$prenom,$ddn);
		CtlModifierClient($idClient, $nom, $prenom, $sexe, $ddn, $codePostal, $adresse, $ville, $pays, $numTel, $mail ,$montantDiffereMax);
	}elseif(isset($_POST['nouveauClient'])){
		CtlNouveauClient();
	}elseif(isset($_POST['ajout'])){
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$sexe=$_POST['sexe'];
		$ddn=$_POST['naissance'];
		$adresse=$_POST['adresse'];
		$codePostal=$_POST['postal'];
		$numTel=$_POST['numTel'];
		$mail=$_POST['mail'];
		$ville=$_POST['ville'];
		$pays=$_POST['pays'];
		$montantDiffereMax=$_POST['montant'];
		CtlSaisirClient($nom, $prenom, $sexe, $ddn, $adresse, $codePostal, $numTel, $mail, $ville, $pays, $montantDiffereMax);
	}elseif(isset($_POST['searchID'])){
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$ddn=$_POST['naissance'];
		Ctl_idClient($nom,$prenom,$ddn);
	}elseif(isset($_POST['deconnexion'])){
		CtlAuthentification();
	}elseif(isset($_POST['listePourRdv'])){
		Ctl_liste_mecanicien();
	}elseif(isset($_POST['validerMecanicien'])){
		$nom = $_POST['listeMecanicien'];
		$semaine = $_POST['semaine'];
		Ctl_Visualisation_Planning_Semaine($nom,$semaine);
	}elseif(isset($_POST['validerRDV'])){
		$idClient=$_POST['idClient'];
		$idMeca=$_POST['listeMecanicien'];
		$date=$_POST['date'];
		$heure=$_POST['heure'];
		$idTI=$_POST['listeIntervention'];
		Ctl_enregistrer_intervention($idClient,$idMeca,$date,$heure,$idTI);
	}elseif(isset($_POST['info'])){
		CltSyntheseIntervention();
	}else{
		CtlAgentAccueil();
	}
}catch(Exception $e){
	$msg=$e->getMessage();
	CtlErreur($msg);
}