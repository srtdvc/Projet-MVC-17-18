<?php

require_once('controleur/controleur.php');

try{
	if(isset($_POST['personnel'])){
		CtlListe_employe();
	}elseif(isset($_POST['garage'])){
		CtlListe();
	}elseif(isset($_POST['liste'])){
		CtlListePiece();
	}elseif(isset($_POST['ajouterEmploye'])){
		CtlFormulaireEmploye();
	}elseif(isset($_POST['inserer'])){
		$login = $_POST['login'];
		$nom = $_POST['nom'];
		$mdp = $_POST['mdp'];
		$categorie = $_POST['categorie'];
		CtlAjouterEmploye($login,$nom,$mdp,$categorie); 
	}elseif(isset($_POST['supprimerEmploye'])){
		CtlSupprimerDesEmploye();
	}elseif(isset($_POST['ajoutIntervention'])){
		CtlFormulaireIntervention();
	}elseif(isset($_POST['ajouterIntervention'])){
		$nomTI = $_POST['nomTI'];
		$montant = $_POST['montant'];
		$elements = $_POST['element_piece'];
		CtlCree_Intervention($nomTI,$montant, $elements);
	}elseif(isset($_POST['supprimerInterventions'])){
		CtlSupprimerIntervention();
	}elseif(isset($_POST['ajouterPiece'])){
		CtlFormulairePiece();
	}elseif(isset($_POST['insererPiece'])){
		foreach($_POST as $key => $val){
			CtlModifier_listeElement($key, $val);
		}
	}elseif(isset($_POST['deconnexion'])){
		CtlAuthentification();
	}else{
		CtlAccueil();
	}
}catch(Exception $e){
	$msg=$e->getMessage();
	CtlErreur($msg);
}