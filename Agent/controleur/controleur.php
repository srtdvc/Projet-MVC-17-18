<?php

require_once('modele/modele.php');
require_once('vue/vue.php');

function CtlAgentAccueil(){
	AfficherAgentAccueil();
}

function CtlAuthentification(){
	header('location:../garage.php');
}

function CtlPriseRDV(){
	$listeMecanicien = liste_mecanicien();
	$listeIntervention=liste_Intervention();
	AfficherPriseRDV($listeMecanicien,$listeIntervention);
}

function CtlPriseRDVV(){
	$listeMecanicien = liste_mecanicien();
	AfficherPriseRDVV($listeMecanicien);
}

function Ctl_idClient($nom,$prenom,$date){
	if (!empty($nom) && !empty($prenom) && !empty($date)){
		$idClient = id_client($nom,$prenom,$date);
		if(!empty($idClient)){
			foreach($idClient as $id){
				$idfinal = $id->idClient;
				afficherID($idfinal);
			}
		}else{
			throw new Exception("Identifiant du client non connu dans notre base");
		}
	}else{
		throw new Exception("Nom ou prénom incorrecte");
	}
}

function Ctl_ReturnIdClient($nom,$prenom,$date){
	if (!empty($nom) && !empty($prenom) && !empty($date)){
		$idClient = id_client($nom,$prenom,$date);
		if(!empty($idClient)){
			foreach($idClient as $id){
				$idfinal = $id->idClient;
				return $idfinal;
			}
		}else{
			throw new Exception("Identifiant du client non connu dans notre base");
		}
	}else{
		throw new Exception("Nom ou prénom incorrecte");
	}
}

/*function CtlSyntheseClient($id){
		if(!empty($id)){
			$infoClient = information_client($id);
			afficherSyntheseClient($infoClient);
		}else{
			throw new Exception("Identifiant du client non connu dans notre base");
		}
}*/

function CtlSyntheseClient($idClient){
	$syntheseClient=information_client($idClient);
	$syntheseIntervention=synthese_intervention_client($idClient);
	$somme=sommes_des_differes($idClient);
	$differePossible=differe_possible($idClient);
	afficherSynthese($syntheseClient,$syntheseIntervention,$somme,$differePossible);
}

function CtlNouveauClient(){
	AfficherForumulaireClient();
}

function CtlAjoutClient($nom,$prenom,$adresse,$numTel,$mail,$montantMax){
	if (!empty($nom) && !empty($prenom) && !empty($adresse) && !empty($numTel) && !empty($mail) && !empty($montantMax)){
		saisirClient($nom,$prenom,$adresse,$numTel,$mail,$montantMax);
		afficherAgentAccueil();
	}else{
		throw new Exception("Champs non rempli ou incorrecte");
	}
}

function CltSyntheseIntervention(){
	foreach($_POST as $key=>$val){
		$client = Recup_Client_RDV($key);
		$element = Recup_Liste_Element($key);
		afficherSyntheseClient($client,$element);
	}
}


 
/*function CtlAcceuil(){
	afficherAcceuil();
}*/

 
/* Creer un client*/
function CtlSaisirClient($nom, $prenom, $sexe, $dateNaissance, $adresse, $codePostal, $numTel, $mail, $ville, $pays,$montantDiffereMax){
	if (!empty($nom) && !empty($prenom) && !empty($sexe) && !empty($dateNaissance) && !empty($adresse)&& !empty($codePostal) &&!empty($numTel)&&!empty($mail)&&!empty($ville)&&!empty($pays)&&!empty($montantDiffereMax)){
		saisir_client($nom, $prenom, $sexe, $dateNaissance, $adresse, $codePostal, $numTel, $mail, $ville, $pays,$montantDiffereMax);
		CtlAgentAccueil();
	}else{
		throw new Exception ("un des champs est invalide");
	}
}



/* Modifie un client*/
function CtlModifierClient($idClient, $nom, $prenom, $sexe, $dateNaissance, $codePostal, $adresse, $ville, $pays, $numTel, $mail, $montantDiffereMax){
   if (!empty($nom) && !empty($prenom) && !empty($sexe) && !empty($dateNaissance) && !empty($adresse)&& !empty($codePostal) &&!empty($numTel)&&!empty($mail)&&!empty($ville)&&!empty($pays)&&!empty($montantDiffereMax)){

     modifier_client($idClient, $nom, $prenom, $sexe, $dateNaissance, $codePostal, $adresse, $ville, $pays, $numTel, $mail, $montantDiffereMax);
	 AfficherAgentAccueil();
	  }else{
	      throw new Exception ("un des champs est invalide");
	  }
}


/* Retourne la derniere intervention en attente de payement*/
function Ctl_derniere_intervention_enAttenteDePayement($idClient){
	$derniereIntervention=derniere_intervention_enAttenteDePayement($idClient);
	//AFFICHAGE DE LA VUE
}

/* encaisse le payement de la derniere intervention en attente de payement*/
function Ctl_payer_intervention_cash($idClient,$idTI){
	encaisser_payement_enattente($idClient, $idTI);
	$derniereIntervention=derniere_intervention_enAttenteDePayement($idClient);
	$listeInterventionDiff=liste_intervention_diff($idClient);
	afficherIntervention($idClient,$listeInterventionDiff,$derniereIntervention);
}


/* demande un differe */
function Ctl_demande_differe($id,$idTI){
	demande_differe($id,$idTI);
	$listeInterventionDiff=liste_intervention_diff($id);
	$derniereIntervention=derniere_intervention_enAttenteDePayement($id);
	afficherIntervention($idClient,$listeInterventionDiff,$derniereIntervention);
}


/* la liste des intervention en differe */
function Ctl_liste_intervention_diff($idClient){
	$listeIntervention=liste_intervention_diff($idClient);
	//AFFICHAGE DE LA VUE
}


function Ctl_rembourser_differe($id){
		foreach($_POST as $key => $val){
			encaisser_payement_differe($id,$key);
		}
	$listeInterventionDiff=liste_intervention_diff($id);
	$derniereIntervention=derniere_intervention_enAttenteDePayement($id);
	afficherIntervention($id,$listeInterventionDiff,$derniereIntervention);
}



/* Verifie si il est possible de mettre en differe une intervention sans que ca nous fasse depasser notre decouvert  */
function Ctl_verification_differe_possible($idClient,$idTI){
	$ecartDifferePossible = differe_possible($idClient);
	foreach ($ecartDifferePossible as $ligne){
         
         $DifferePossible=$ligne->differePossible;
		 echo 'Differe Possible: '.$DifferePossible.'</br>';
	}
	
	
	$prixIntervention = prix_intervention($idTI);
	foreach ($prixIntervention as $ligne){
	$prix=$ligne->montant;
	}
	
	if($prix <= $DifferePossible){
		demande_differe($idClient,$idTI);
	}else{
		throw new Exception ("le differe ne peut pas etre effectué");
	}
	$listeInterventionDiff=liste_intervention_diff($idClient);
	$derniereIntervention=derniere_intervention_enAttenteDePayement($idClient);
	afficherIntervention($idClient,$listeInterventionDiff,$derniereIntervention);
}




/* Recherche un client a partir de son id */
function Ctlrechercher_nom_client($id){
	$user = rechercher_nom_client($id);
}


/* Recherche un client a partir de son nom*/
function Ctlrechercher_id_client($nom,$prenom){
	$user = rechercher_id_client($nom,$prenom);
	return $user;
}


//SYNTHESE CLIENT PARTIE AGENT:

/* Consulte la synthèse d'un client a partir de son id */
function CtlConsulterSyntheseClient($id){
	$synthese=information_client($id);
	afficherSyntheseClient($synthese); /* synthese c'est tous les champs de la table client*/
}



/* Recherche la liste des interventions du client, le nom du mecanicien qui a realise chaque intervention , le montant de chaque intervention ainsi que son etat*/
function Ctl_intervention_client($idClient){
	$derniereIntervention=derniere_intervention_enAttenteDePayement($idClient);
	$listeInterventionDiff=liste_intervention_diff($idClient);
	afficherIntervention($idClient,$listeInterventionDiff,$derniereIntervention);
}



/* Recherche la somme des differes des interventions du client */
function Ctl_somme_des_differes($idClient){
	$somme = ($idClient);
	//afficherSommmeDesDifferes($somme);
}


/*Retourne le montant disponible pour des differes ulterieurs*/
function Ctl_montant_differe_disponible($idClient){
	$montant=($idClient);
	//AFFICHE DE LA VUE AVEC PARAMETRE $MONTANT
}


function Ctl_retrouver_id_client($nom,$prenom,$dateNaissance){
	$idClient=rechercher_id_client($nom,$prenom,$dateNaissance);
	//AFFICHAGE DE LA VUE
}


//GESTION DES RVD PARTIE AGENT :

/* Visualise la synthese d'un RDV */
function Ctl_Visualiser_Rendez_Vous($idRDV){
	$client = Recuperation_Client_RDV($idRDV);
	$ObjetRDV = Recuperation_Objet_RDV($idRDV);
	$listeElement = Recuperation_Liste_Element($idRDV);
	AfficherSyntheseRDV ($client,$ObjetRDV,$listeElement);//AFFICHAGE DE LA VUE
}


/* affiche la liste de tous les mecaniciens */
function Ctl_liste_mecanicien(){
	$listeMecanicien = liste_mecanicien();
	AfficherlisteMecanicien($listeMecanicien);
}

function Ctl_intervention_du_garage(){
	$intervention=liste_Intervention();
	//Affichage DE LA VUE
}
/*Retourne la liste des pieces necessaire pour une intervention*/
function Ctl_liste_elements($idTI){
	$listePiece=liste_elements($idTI);
	//AFFICHAGE DE LA VUE 
}


function Ctl_enregistrer_intervention($idClient,$idMeca,$date,$heure,$idTI){
	enregister_RDV($date,$heure,$idTI,$idMeca,$idClient);
	$derniereIntervention=derniere_intervention_enAttenteDePayement($idClient);
	$listeInterventionDiff=liste_intervention_diff($idClient);
	afficherIntervention($idClient,$listeInterventionDiff,$derniereIntervention);
}


/* Permet de visualiser les formations et interventions de la semaine a partir d'une semaine donnée*/
function Ctl_Visualisation_Planning_Semaine($idEmploye,$semaine){
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
		$idTI = $ligne->nomTI;
	}
	$listeMecanicien = liste_mecanicien();
	$listeIntervention=liste_Intervention();
	AfficherPlanning($listeMecanicien, $listeIntervention, $formations, $interventions);
}



function CtlErreur($erreur){
	afficherErreur($erreur);
}
