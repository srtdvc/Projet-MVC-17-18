<?php

require_once('modele/modele.php');
require_once('vue/vue.php');

function CtlAccueil(){
	AfficherAccueil();
}

function CtlAuthentification(){
	header('location:../garage.php');
}


function CtlFormulaireEmploye(){
	formulaireEmploye();
}

/*DIRECTEUR*/

/* Ajoute un employe */

function CtlAjouterEmploye($login,$nom,$mdp,$categorie){
	if (!empty($login) && !empty($mdp) && !empty($categorie) && !empty($nom)){
	   ajouterEmploye($login,$nom,$mdp,$categorie);
	   AfficherAccueil();
	}else{
	   throw new Exception ("un des champs est invalide");
	}
}

/* Recherche un employe a partir de son id */
function CtlrechercherEmploye_id($nom){
	$id = rechercher_id_Employe($nom);
}


 function Ctl_rechercher_Employe_nom($id){
	$nom = rechercher_nom_Employe($id);
 }
 
 
 /* Supprime un employe a partir de son id */
function CtlSupprimerEmploye($id){
	supprimerEmploye($id);
	afficherAcceuilDirecteur();
}

 /*Ajout ! Supprime des employes cochés*/
function CtlSupprimerDesEmploye(){
	foreach($_POST as $key => $val){
				if(is_int($key)){
					supprimerEmploye($key);
					AfficherAccueil();
				}
	}
}


/* Modifie un employe */
function CtlModifierEmploye($id,$nom,$login,$mdp,$categorie){
	if (!empty($login) && !empty($mdp) && !empty($categorie) && !empty($nom)){
		  modifierEmploye($id,$nom,$login,$mdp,$categorie);
		  afficherAcceuilDirecteur();
	}else{
		throw new Exception ("un des champs est invalide");
	  }
}

function Ctl_ListeDeroulante(){
	afficherListeDeroulante();
}

function Ctl_liste(){
	Ctl_liste_agent();
	Ctl_liste_mecanicien();
	Ctl_liste_directeur();
}


function Ctl_liste_agent(){
	$agent=liste_agent();
	afficherVueAgent($agent);
}


function Ctl_liste_mecanicien(){
	$mecanicien=liste_mecanicien();
	afficherVueMecanicien($mecanicien);
}

function Ctl_liste_directeur(){
	$directeur=liste_directeur();
	afficherVueDirecteur($directeur);
}




/* Cree une liste d'intervention */
function CtlCree_Intervention($nomTI,$montant, $elements){
	if(!empty($nomTI) && !empty($montant) && !empty($elements)){
		creer_intervention($nomTI,$montant,$elements);
		AfficherAccueil();
	}else{
		throw new Exception ("un des champs est invalide");
	}
}



/* Supprime une liste d'intervention */
function CtlSupprimer_Intervention($idTI){
	supprimer_intervention($idTI);
	afficherAcceuilDirecteur();
}

/*Ajout ! Suppression des cases cochées*/
function CtlSupprimerIntervention(){
	foreach($_POST as $key => $val){
				if(is_int($key)){
					supprimer_intervention($key);
					AfficherAccueil();
				}
	}
}

/* Modifie une liste d'intervention */
function CtlModifier_Intervention($idTI,$nomTI,$montant,$listepiece){
	if(!empty($nomTI) && !empty($montant)){
		modifier_intervention($idTI,$nomTI,$montant,$listepiece);
		afficherAcceuilDirecteur();
	}else{
		throw new Exception("un des champs est invalide");
	}
}


/* Recherche une intervention a partir de son nom */
function CtlRechercher_Intervention($nomTI){
	$idTI = rechercherIntervention($nomTI);
}



/* Cree une liste d'element */
function CtlCree_listeElement($idTI,$elementPieces){
	if (!empty($elementPieces)){
		ajouter_des_pieces($idTI,$elementPieces);
		afficherAcceuilDirecteur();
	}else{
		throw new Exception("un des champs est invalide");
	}
}

/* Supprime une liste d'element a partir de l'id de son type d'intervention */
function CtlSupprimer_listeElement($idTI){
	supprimer_listePiece($idTI);
	afficherAcceuilDirecteur();
}



/* Modidie une liste d'element a partir de l'id de sa liste d'element */
function CtlModifier_listeElement($idTI,$elementPieces){
	if (!empty($elementPieces)){
		modifier_listePiece($idTI,$elementPieces);
		AfficherAccueil();
	}else{
		throw new Exception("un des champs est invalide");
	}
}

function CtlListe(){
	$liste = liste_piece();
	afficherListe($liste);
}

function CtlListePiece(){
	$liste = liste_piece();
	afficherListePiece($liste);
}

function CtlListe_employe(){
	$liste=liste_employe();
	afficherVue($liste);
}

function CtlFormulaireIntervention(){
	$liste = liste_piece();
	afficherInterventions($liste);
}


function CtlFormulairePiece(){
	$liste = liste_piece();
	afficherPiece($liste);
}

function CtlErreur($erreur){
	afficherErreur($erreur);
}