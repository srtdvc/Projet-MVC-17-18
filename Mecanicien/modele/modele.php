<?php
function getConnect(){
	require_once('connect.php'); 
	$connexion=new PDO('mysql:host='.SERVEUR.';dbname='.BDD,USER,PASSWORD);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connexion->query('SET NAMES UTF8');
	$connexion->exec("SET lc_time_names = 'fr_FR'");
	return $connexion ;
}

/* On insere une formation*/
function saisir_formation($dateFormation , $heureFormation, $idMecanicien){
$connexion=getConnect();
$requete="INSERT INTO formation VALUES(0,'$dateFormation','$heureFormation','$idMecanicien')";
$resultat=$connexion->query($requete);
$resultat->closeCursor();
}


/* Recupere la fiche identitaire du client à partir de l'id intervention*/
function Recuperation_Client_RDV($idTI){
$connexion=getConnect();
$requete="SELECT * FROM Client WHERE  idClient =(SELECT DISTINCT idClient FROM intervention WHERE idTI='$idTI') ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$synthese=$resultat->fetchall();
$resultat->closeCursor();
return $synthese;
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

 /* Retourne l'objet du RDV, soit le nom de l'intervention */
function Recuperation_Object_RDV($idTI){
$connexion=getConnect();
$requete="SELECT nomTI as 'ObjectRDV' FROM type_intervention WHERE  idTI='$idTI'";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$objetRDV=$resultat->fetchall();
$resultat->closeCursor();
return $objectRDV;
}

/*retourne la liste des elements d'une intervention*/
function Recuperation_Liste_Element($idTI){
$connexion=getConnect();
$requete="SELECT element_piece as 'ListePiece' FROM type_intervention WHERE  idTI='$idTI'";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$liste=$resultat->fetchall();
$resultat->closeCursor();
return $liste;
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

/*Retourne les noms des jours , les heures et le nom des interventions de la semaine du mécanicien donné */
function Visualisation_Formation_Semaine($id,$dateLundi,$dateDimanche){
$connexion=getConnect();
$requete="SELECT DAYNAME(dateFormation) as jour_formation ,DATE_FORMAT(heureFormation,'%H') as heure_formation FROM formation  WHERE idEmploye='$id' 
	AND dateFormation BETWEEN '$dateLundi' AND '$dateDimanche'";
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


/*Retourne les noms des jours et les heures de chaque formation pour un mecanicien donné à une date donnée*/
function Visualisation_Formation_Date($date,$id){
$connexion=getConnect();
$requete="SELECT DAYNAME(dateFormation) as date_formation ,DATE_FORMAT(heureFormation,'%H') 
as heure_formation FROM formation WHERE idEmploye='$id' AND dateFormation='$date' ";
$resultat->setFetchMode(PDO::FETCH_OBJ);
$dateFormation=$resultat->fetchall();
$resultat->closeCursor();
return $dateFormation;
}
/* Retourne les noms des jours ,les heures et nom de chaque intervention pour un mecanicien donné à une date donnée*/
function Visualisation_Intervention_Date($date,$id){
$connexion=getConnect();
$requete=" SELECT nomTI, DAYNAME(dateIntervention) as 'jour_intervention' ,DATE_FORMAT(heureIntervention,'%H') 
as 'heure_intervention' FROM type_intervention NATURAL JOIN (SELECT * FROM intervention WHERE idEmploye='$id' AND dateIntervention='$date') as dateIntervention";
$resultat->setFetchMode(PDO::FETCH_OBJ);
$dateIntervention=$resultat->fetchall();
$resultat->closeCursor();
return $dateIntervention;
}


/*Retourne le nom du jour et l'heure de chaque formation du jour d'un mecanicien */
function date_planning_formation_meca_dujour($idMecanicien){
$connexion=getConnect();
$requete="SELECT DAYNAME(dateFormation) as 'jour_Formation' ,DATE_FORMAT(heureFormation,'%H') 
as 'heure_Formation' FROM formation WHERE idEmploye=$idMecanicien AND dateFormation=(SELECT CAST(NOW() AS DATE)) ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$formationDujour=$resultat->fetchall();
$resultat->closeCursor();
return $formationDujour;
}

/*Retourne les dates , heures  et nom de chaque  intervention du jour actuel d'un mecanicien . */
function date_planning_intervention_meca_dujour($idMecanicien){
$connexion=getConnect();
$requete="SELECT nomTI,DAYNAME(dateIntervention) 
as 'jour_intervention' ,DATE_FORMAT(heureIntervention,'%H') 
as 'heure_intervention' FROM (SELECT * FROM intervention WHERE 
idEmploye=$idMecanicien AND dateIntervention=(SELECT CAST(NOW() AS DATE))) 
as interventionDuJour NATURAL JOIN type_intervention ";
$resultat=$connexion->query($requete);
$resultat->setFetchMode(PDO::FETCH_OBJ);
$InterventionDujour=$resultat->fetchall();
$resultat->closeCursor();
return $InterventionDujour;
}