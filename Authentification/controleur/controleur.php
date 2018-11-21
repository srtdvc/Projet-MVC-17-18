<?php

require_once('Authentification/modele/modele.php');
require_once('Authentification/vue/vue.php');

function CtlAccueil(){
	AfficherAccueil();
}

function CtlAccueilAgent(){
	AfficherAccueilAgent();
}

function CtlAccueilMecanicien(){
	AfficherAccueilMecanicien();
}

function CtlAccueilDirecteur(){
	AfficherAccueilDirecteur();
}

function CtlCheckUser($nom,$mdp){
    if (!empty($nom) && !empty($mdp)){
		$valide=checkUser($nom,$mdp);
		if(!empty($valide)){
			foreach($valide as $ligne){
				if($ligne->Categorie == 'Agent'){
					CtlAccueilAgent();
				}
				if($ligne->Categorie == 'Mecanicien'){
					CtlAccueilMecanicien();
				}
				if($ligne->Categorie == 'Directeur'){
					CtlAccueilDirecteur();
				}
			}
		}else{
			throw new Exception("Login ou Mot de passe non valide");
		}
	}else{
		throw new Exception("Login ou Mot de pass vide");
	}
}

function CtlErreur($erreur){
	afficherErreur($erreur);
}