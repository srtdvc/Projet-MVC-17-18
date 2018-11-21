<?php


function AfficherAccueil(){
	$contenu='';
	require_once('gabarit.php');
}

function AfficherAccueilAgent(){
	header('location:Agent/agent.php');
}

function AfficherAccueilDirecteur(){
	header('location:Directeur/directeur.php');
}

function AfficherAccueilMecanicien(){
	header('location:Mecanicien/mecanicien.php');
}


function AfficherErreur($erreur){
	$contenu='<p>'.$erreur.'</p>
	          <p><a href="garage.php"/> Revenir a la page d acceuil</a></p>';
	require_once('gabarit.php');		  
}