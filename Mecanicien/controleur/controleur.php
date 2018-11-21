<?php 

require_once('modele/modele.php');
require_once('vue/vue.php');

/* MECANICIEN */

function CtlAccueil(){
	AfficherAccueil();
}

function CtlAuthentification(){
	header('location:../garage.php');
}

function CtlAfficherFormation(){
	AfficherFormation();
}

function CtlAjouterFormation($idMecanicien,$dateFormation,$heureFormation){
	saisir_formation($dateFormation , $heureFormation, $idMecanicien);
	AfficherAccueil();
}


/* Bloque un creneau a une date et une heure donnée  */

function CtlBloquer_Creneau($date,$heure,$idMecanicien){
if(!empty ($date) && !empty ($heure)){
  
saisir_formation($date,$heure,$idMecanicien); /* bloque un creneau */
$rdv = creneau_bloque_mecanicien(idMecanicien); /* $rdv correcpond a toutes les dates et heures des formations du mecanicien en parametre*/

if ($rdv){
/* Affichage de la vue */
}else{
throw new Exception("pas de formations pour ce mecanicien");
}
throw new Exception("un des champs est invalide");
}
}



/* Recherche un employe a partir de son nom */
function Ctl_Rechercher_Employe_Par_Nom($nom){
$id = Rechercher_Employe_Par_Nom($nom);
}


/* Permet de visualiser le planning de la semaine a partir d'une semaine donnée*/
function Ctl_Visualisation_Planning_Semaine($nom,$semaine){
	$id = Rechercher_Employe_Par_Nom($nom);
	foreach ($id as $ligne){
		$idEmploye = $ligne->idEmploye;
	}
	
	$year=date('y');
	$time = strtotime($year . '0104 +' . ($semaine - 1). ' weeks');
	$dateLundi=date('y-m-d', strtotime('-' . (date('w', $time) - 1) . ' days',$time));
	
	
	
	
	
	$date_format='y-m-d';
	$array_date=date_parse_from_format($date_format, $dateLundi);
	$jour=6;
	$dateDimanche=date($date_format, mktime(0,0,0,$array_date['month'],$array_date['day']+$jour, $array_date['year']));
	$formations = Visualisation_Formation_Semaine($idEmploye,$dateLundi,$dateDimanche);
	$interventions = Visualisation_Intervention_Semaine($idEmploye,$dateLundi,$dateDimanche);
	foreach ($interventions as $ligne){
		$codeIntervention = $ligne->codeIntervention;
		$idTI = $ligne->nomTI;
	}
	$client = Recup_Client_RDV($codeIntervention);
	$element = Recuperation_Liste_Element($idTI);
	AfficherPlanning($client, $element, $formations, $interventions);
}

function CltSyntheseIntervention(){
	foreach($_POST as $key=>$val){
		$client = Recup_Client_RDV($key);
		$element = Recup_Liste_Element($key);
		afficherSyntheseClient($client,$element);
	}
}



function CtlErreur($erreur){
	afficherErreur($erreur);
}