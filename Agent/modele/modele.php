<?php


function getConnect(){
	require_once('connect.php'); 
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	$connexion->exec("SET lc_time_names = 'fr_FR'");
	return $connexion ;
}

function client($nom){
	$connexion=getConnect();
	$requete=" SELECT * FROM client WHERE nom='$nom' ";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$synthese=$resultat->fetchall();
	$resultat->closeCursor();
	return $synthese;
}


//GESTION FINANCIERE
function saisir_client($nom,$prenom,$sexe,$dateNaissance,$adresse,$codePostal,$numTel,$mail,$ville,$pays,$montantDiffereMax){
	$connexion=getConnect();
	$requete="INSERT INTO client VALUES(0,'$nom','$prenom','$sexe','$dateNaissance','$adresse','$numTel','$mail', '$codePostal',
	'$ville','$pays','$montantDiffereMax') ";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

//GESTION FINANCIERE
//Ajout !
function saisirClient($nom,$prenom,$adresse,$numTel,$mail,$montantMax){
	$connexion=getConnect();
	$requete="INSERT INTO client VALUES(0,'$nom','$prenom','$adresse','$numTel','$mail','$montantMax') ";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}


function modifier_client($idClient,$nom,$prenom,$sexe,$dateNaissance,$codePostal,$adresse,$ville,$pays ,$numTel,$mail,$montantDiffereMax){
	$connexion=getConnect();
	$requete="UPDATE client SET nom='$nom', prenom='$prenom', sexe='$sexe',dateNaissance='$dateNaissance',adresse='$adresse', numTel='$numTel', 
	mail='$mail', codePostal='$codePostal', Ville='$ville', Pays='$pays', montantMax='$montantDiffereMax' WHERE idClient='$idClient'";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}

/*Retourne l'identifiant d'un client*/
function rechercher_id_client($nomClient,$prenomClient){ 
$connexion=getConnect();
$requete="SELECT idClient FROM client WHERE nom='$nomClient' AND prenom='$prenomClient' ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$idClient=$resultat->fetchall();
$resultat->closeCursor();
return $idClient;
}

/* Retourne l'identifiant d'un mecanicien  à partir de son nom*/
function  Rechercher_Employe_Par_Nom($nomEmploye){
$connexion=getConnect();
$requete="SELECT idEmploye FROM employe WHERE nomEmploye='$nomEmploye' AND Categorie='mecanicien'";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$id=$resultat->fetchall();
$resultat->closeCursor();
return $id;
}


//on recupere la derniere intervention "en attente de payement" ainsi que toute celle "en differe" du client
function afficher_intervention_nonPayee_client($idClient){
	$connexion=getConnect();
	$requete=" SELECT nomTI FROM (SELECT * FROM intervention WHERE etat IN ('en attente de payement', 'differe')  
	AND idClient='$idClient') as T1 NATURAL JOIN type_intervention ";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$ensembleIntervention=$resultat->fetchall();
	$resultat->closeCursor();
	return $ensembleIntervention;
}



/* On encaisse le payement d'une intervention en attente de payement */
function encaisser_payement_enattente($idClient,$idTI){ 
	$connexion=getConnect();
	$requete="UPDATE intervention SET etat='payee' WHERE  idClient='$idClient' AND idTI='$idTI' and etat='en attente de payement'";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}


//cete fonction sera appele a chaque tour de boucle du controleur qui recupere la liste des check  box valide e encaisse les interventions en differes
	function encaisser_payement_differe($idClient,$idTI){ 
	$connexion=getConnect();
	$requete="UPDATE intervention SET etat='payee' WHERE  idClient='$idClient' AND idTI='$idTI' and etat='differe' ";//pb nomTI je ne peux le recuperequ'en jointure et je ne peux pas utili
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}


/*Me retourne l'id et le nom de la derniere intervention realisé en attente de payement,ce sera celle qui sera afficher sur notre premier et seconde checkbox , a savoir la derniere intervention cash a payer ou à differe*/
function derniere_intervention_enAttenteDePayement($idClient){ 
	$connexion=getConnect();
	$requete="Select idTI, nomTI from type_intervention NATURAL JOIN 
	(select * from intervention where idClient='$idClient' and etat='en attente de payement') 
	as T1 ORDER BY dateIntervention DESC, heureIntervention DESC LIMIT 0,1";
	$resultat=$connexion->query($requete);
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$derniereInterventionCash=$resultat->fetchall();
	$resultat->closeCursor();
	return $derniereInterventionCash;
}



/* me retourne le montant maximum de difffere autorise d'un client*/
function montant_max($idClient){
	$connexion=getConnect();
	$requete="SELECT montantMax FROM client WHERE idClient='$idClient' ";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$montantMax=$resultat->fetchall();
	$resultat->closeCursor();
	return $montantMax;
}


/*Pour cette fonction , l'idTI en parametre est l'id renvoye par ma fonction 'derniere_intervention_en_attente',me contacter pour plus d'info  */
function demande_differe($idClient,$idTI){// demande un differe  pour la derniere intervention en attente 
	$connexion=getConnect();
	$requete="UPDATE intervention SET etat='differe'
	 WHERE idClient='$idClient' AND etat='en attente de payement' AND idTI='$idTI' ";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}


// appeler cette fonction dès que l'agent a valide le rdv, la facture(intervention) passe en attente de payement
function intervention_enAttente($idClient,$idTI){ 
	$connexion=getConnect();
	$requete="UPDATE intervention SET etat='en attente de payement'
	 WHERE idClient='$idClient' AND idTI='$idTI' AND etat is null ";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}


/* Retourne la somme de toutes les interventions en differe d'un client*/
function sommes_des_differes($idClient){
	$connexion=getConnect();
	$requete="SELECT SUM(montant) as 'total' FROM (SELECT * FROM intervention WHERE idClient='$idClient' 
	AND etat='differe') as T2 NATURAL JOIN type_intervention ";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$total=$resultat->fetchall();
	$resultat->closeCursor();
	return $total;
}

function differe_possible($idClient){
$connexion=getConnect();
$requete="SELECT montantMax -SUM(montant) as 'differePossible' FROM client NATURAL JOIN (SELECT * FROM intervention WHERE idClient='$idClient' 
AND etat='differe') as interventionDiffere NATURAL JOIN type_intervention  ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$differePossible=$resultat->fetchall();
$resultat->closeCursor();
return $differePossible;
}


//cette fonction permet à l'agent de fixer un montant maximum de différer pour le client .
function fixer_un_differe($idClient,$sommeMontantFixe){
	$connexion=getConnect();
	$requete="UPDATE client SET montantMax='$sommeMontantFixe' WHERE idClient='$idClient' ";
	$resultat=$connexion->query($requete);
	$resultat->closeCursor();
}


//SYNTHESE DU CLIENT 
function information_client($idClient){ //affiche l'identite du client
	$connexion=getConnect();
	$requete=" SELECT * FROM client WHERE idClient='$idClient' ";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$synthese=$resultat->fetchall();
	$resultat->closeCursor();
	return $synthese;
}

function prix_intervention($idTI){
$connexion=getConnect();
$requete="SELECT montant FROM type_intervention WHERE idTI='$idTI'";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$prix=$resultat->fetchall();
$resultat->closeCursor();
return $prix;
}



/*la fonction retourne l'ensemble des interventions du client */
function liste_intervention_client($idClient){ 
	$connexion=getConnect();
	$requete="SELECT * FROM (SELECT * FROM intervention WHERE idClient='$idClient') as T6 NATURAL JOIN type_intervention  ";
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$listeIntervention=$resultat->fetchall();
	$resultat->closeCursor();
	return $listeIntervention;
}


/* Retourne l'ensemble des interventions en differe du client*/
function liste_intervention_diff($idClient){
$connexion=getConnect();
$requete="(select idTI, nomTI from type_intervention NATURAL JOIN (SELECT * from intervention
 WHERE idClient='$idClient' and etat='differe') as interventionDiffere) ";
 $resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$listeIntervention=$resultat->fetchall();
$resultat->closeCursor();
return $listeIntervention;
}

/*Retourne les mecaniciens, le montant , l'etat et le nom des interventions du client*/
function synthese_intervention_client($idClient){ 
$connexion=getConnect();
$requete="SELECT codeIntervention, dateIntervention, idTI, montant, nomTI ,nomEmploye,etat FROM type_intervention NATURAL JOIN
 (SELECT * FROM intervention WHERE idClient='$idClient' ) as interventionClient  NATURAL JOIN employe ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$syntheseIntervention=$resultat->fetchall();
$resultat->closeCursor();
return $syntheseIntervention;
}

function syntheseTotal($idClient){ 
$connexion=getConnect();
$requete="SELECT montant, nomTI ,nomEmploye,etat FROM type_intervention NATURAL JOIN
 (SELECT * FROM intervention WHERE idClient='$idClient') as interventionClient  NATURAL JOIN employe ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$syntheseTotal=$resultat->fetchall();
$resultat->closeCursor();
return $syntheseTotal;
}


/*Permet de retrouver l'id du client*/
function id_client($nomClient,$prenomClient/*,$dateNaissance*/){ //rajouter a la base la date de naissance
	$connexion=getConnect();
	$requete="SELECT idClient FROM client WHERE nom='$nomClient' AND prenom='$prenomClient'  ";//AND dateNaissance='$dateNaissance'
	$resultat=$connexion->query($requete);
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$idClient=$resultat->fetchall();
	$resultat->closeCursor();
	return $idClient;
}


/* Recupere la fiche identitaire du client à partir du codeIntervention*/
//AJOUT
function Recup_Client_RDV($codeIntervention){
$connexion=getConnect();
$requete="SELECT * FROM Client WHERE  idClient =(SELECT DISTINCT idClient FROM intervention WHERE codeIntervention='$codeIntervention') ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$synthese=$resultat->fetchall();
$resultat->closeCursor();
return $synthese;
}

/*retourne la liste des elements d'une intervention*/
function Recup_Liste_Element($codeIntervention){
$connexion=getConnect();
$requete="SELECT element_piece as 'ListePiece' FROM type_intervention WHERE  idTI = (SELECT DISTINCT idTI FROM intervention WHERE codeIntervention='$codeIntervention') ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$liste=$resultat->fetchall();
$resultat->closeCursor();
return $liste;
}


/*version 2b*/ //les interventions d'un mecanicien 
function liste_intervention_mecanicien($idMecanicien){
	$connexion=getConnect();
	$requete="SELECT nomTI FROM type_intervention NATURAL JOIN (SELECT * FROM intervention WHERE idEmploye='$idMecanicien') as T9 GROUP BY nomTI";
	$resultat=$connexion->query($requete); 
	$resultat->setFetchMode(PDO::FETCH_OBJ);
	$listeIntervention=$resultat->fetchall();
	$resultat->closeCursor();
	return $listeIntervention;
}


//Gestion des rendez-vous et planning :
 /*Retourne la liste de toutes les interventions possible du garage*/
function liste_Intervention(){
$connexion=getConnect();
$requete="SELECT idTI, nomTI FROM type_intervention ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$listeIntervention=$resultat->fetchall();
$resultat->closeCursor();
return $listeIntervention;
}
/*Retourne tout les mécaniciens du garage*/
function liste_mecanicien(){ 
$connexion=getConnect();
$requete="SELECT idEmploye,nomEmploye FROM employe WHERE Categorie='mecanicien' ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$listeMecanicien=$resultat->fetchall();
$resultat->closeCursor();
return $listeMecanicien;
}

/*Retourne les jours et les heures de formations d'un mécanicien d'une semaine donné */
function Visualisation_Formation_Semaine($id,$dateLundi,$dateDimanche){
$connexion=getConnect();
$requete="SELECT DAYNAME(dateFormation) as jour_formation ,DATE_FORMAT(heureFormation,'%H') 
as heure_formation FROM formation  WHERE idEmploye='$id' AND dateFormation BETWEEN '$dateLundi' AND '$dateDimanche' ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$dateFormation=$resultat->fetchall();
$resultat->closeCursor();
return $dateFormation;
}



/* Retourne les noms des jours , les heures et le nom des interventions de la semaine d'un mécanicien donné*/
function Visualisation_Intervention_Semaine($id,$dateLundi,$dateDimanche){
$connexion=getConnect();
$requete="SELECT codeIntervention, nomTI, DAYNAME(dateIntervention) as jour_intervention ,DATE_FORMAT(heureIntervention,'%H') 
as heure_intervention FROM type_intervention NATURAL JOIN (SELECT * FROM intervention WHERE idEmploye='$id' AND dateIntervention BETWEEN '$dateLundi' AND '$dateDimanche' ) as dateIntervalle";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$dateIntervention=$resultat->fetchall();
$resultat->closeCursor();
return $dateIntervention;
}

/*Insert dans la table intervention les heures et dates du rendez-vous. On met par defaut le rendez-vous en attente de payement*/
function enregister_RDV($date, $heureIntervention,$idTI,$idMeca,$idClient){
$connexion=getConnect();
$requete="INSERT INTO intervention VALUES 
(0,'$idTI','$date','$heureIntervention','$idMeca','$idClient','en attente de payement')";
$resultat=$connexion->query($requete);
$resultat->closeCursor();
}

/*Retourne la liste des pieces à fournir pour une intervention */
function liste_elements($idTI){
$connexion=getConnect();
$requete="SELECT element_piece FROM type_intervention WHERE idTI='$idTI' ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$listePieces=$resultat->fetchall();
$resultat->closeCursor();
return $listePieces;
}






