<?php

require_once('Authentification/modele/connect.php');

function getConnect(){
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion;
}

function checkUser($login,$mdp){
	$connexion=getConnect();
	$requete="select * from employe where login='$login' and motDePasse='$mdp'";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$valide=$resultat->fetchall();
	$resultat->closeCursor();
	return $valide;
}

