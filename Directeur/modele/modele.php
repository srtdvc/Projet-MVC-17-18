<?php 
function getConnect(){
	require_once('modele/connect.php'); 
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	return $connexion ;
}

function ajouterEmploye($login,$nom,$mdp,$categorie){
	$connexion=getConnect();
	$requete="INSERT INTO employe VALUES (0,'$login','$mdp','$categorie','$nom')";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

function rechercher_nom_Employe($idEmploye){
	$connexion=$getConnect();
	$requete="SELECT nomEmploye FROM employe WHERE idEmploye='$idEmploye'";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$nom=$resultat->fetchall();
	$resultat->closeCursor();
	return $nom;
}
function rechercher_id_Employe($nomEmploye){
	$connexion=$getConnect();
	$requete="SELECT idEmploye FROM employe WHERE nomEmploye='$nomEmploye'";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$id=$resultat->fetchall();
	$resultat->closeCursor();
	return $id;
}
//pour $id mettre avant appel de cette fonction, ma fonction recuperer id
//modif

function supprimerEmploye($idEmploye){
	$connexion=getConnect();
	$requete="DELETE FROM employe WHERE idEmploye='$idEmploye'";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

function modifierEmploye($id,$nom,$login,$mdp,$categorie){
	$connexion=$getConnect();
	$requete="UPDATE employe SET login='$login',motDePasse='$mdp', Categorie='$categorie', nomEmploye='$nom' WHERE idEmploye='$id'";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}


//creer une intervention
function creer_intervention($nomIntervention,$montant,$listePiece){
	$connexion=getConnect();
	$requete="INSERT INTO type_intervention VALUES(0,'$nomIntervention','$montant','$listePiece')";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

function modifier_intervention($idTI,$nomTI,$montant,$listepiece){
	$connexion=getConnect();
	$requete="UPDATE type_intervention SET nomTI='$nomTI', montant='$montant', element_piece='$listepiece' WHERE idTI='$idTI' ";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

//Modif nomTI='idTI' => idTI='$idTI'
function supprimer_intervention($idTI){
	$connexion=getConnect();
	$requete="DELETE FROM type_intervention WHERE idTI='$idTI'"; 
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

/* Pour ajouter des pièces , à celles qui sont déja existante , je n'ai qu'à concatener. Car ici le champ element_piece est de type chaine de caractere */
function rechercherIntervention($nomTI){
$connexion=$getConnect();
$requete="SELECT idTI FROM type_intervention WHERE nomTI='$nomTI'";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$id=$resultat->fetchall();
$resultat->closeCursor();
return $id;
}

function ajouter_des_pieces($idIntervention,$listePiece){ 
$connexion=getConnect();
$requete="UPDATE type_intervention  SET element_piece=CONCAT(element_piece,' $listePiece') WHERE idTI='$idIntervention'  ";
$resultat=$connexion->query($requete);
$resultat->closeCursor();
}
 
function supprimer_listePiece($idIntervention){ //on met à null laliste des pieces
$connexion=getConnect(); 
$requete="UPDATE type_intervention SET element_piece=null WHERE nomTI='$idIntervention' ";
$resultat=$connexion->query($requete);
$resultat->closeCursor();
}
/*le directeur aura la possibilite de saisir directement sur le texte où seront inscrit les pieces ,de cette facon je recupere ce champs qui constitura la nouvelle liste de pieces */
function modifier_listePiece($idIntervention,$nouvelleListePiece){
$connexion=getConnect();
$requete="UPDATE type_intervention SET element_piece='$nouvelleListePiece' WHERE idTI='$idIntervention'";
$resultat=$connexion->query($requete);
$resultat->closeCursor();
}


function liste_agent(){
$connexion=getConnect();
$requete="SELECT * FROM employe WHERE Categorie='agent' ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$agent=$resultat->fetchall();
$resultat->closeCursor();
return $agent;
}



function liste_mecanicien(){
$connexion=getConnect();
$requete="SELECT * FROM employe WHERE Categorie='mecanicien' ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$meca=$resultat->fetchall();
$resultat->closeCursor();
return $meca;
}


function liste_directeur(){
$connexion=getConnect();
$requete="SELECT * FROM employe WHERE Categorie='directeur' ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$directeur=$resultat->fetchall();
$resultat->closeCursor();
return $directeur;
}

/* Retourne pour chaque nom d'intervention , la liste des pieces */
//Modif
function liste_piece(){
	$connexion=getConnect();
	$requete="SELECT idTI, element_piece, nomTI FROM type_intervention GROUP BY nomTI ";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$listePiece=$resultat->fetchall();
	$resultat->closeCursor();
	return $listePiece;
 }
 
function liste_employe(){
	$connexion=getConnect();
	$requete="SELECT * FROM employe ";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$listeEmploye=$resultat->fetchall();
	$resultat->closeCursor();
	return $listeEmploye;
 }
