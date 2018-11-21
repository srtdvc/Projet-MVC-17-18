<?php


function AfficherAccueil(){
	$contenu='';
	require_once('gabarit.php');
}


function afficherVue($agent){
	$contenu='';
	$contenu='<form action="directeur.php" method="post"> <fieldset>
				    <legend>Liste des employes</legend>
					<p><input type="submit" value="Ajouter un employer" name="ajouterEmploye" /> </p>';
					if( $agent == false){
							$contenu.= 'Aucune ligne ne correspond à votre requête</fieldset>';
						}
						else{
							foreach($agent as $ligne){
								$contenu.=	'<p><input type="checkbox" name="'.$ligne->idEmploye.'"/> '.$ligne->Categorie.' '.$ligne->nomEmploye.' '.$ligne->login.' '.$ligne->motDePasse.'</p>';
							}
							$contenu.='<p><input type="submit" value="Supprimer les employes cochés" name="supprimerEmploye"</p></fieldset></form>';
						}
	require_once('gabarit.php');
}



function formulaireEmploye(){
	$contenu='<form action="directeur.php" method="post"> <fieldset>
				    <legend>Ajout d\' employe</legend>
			<p>
				<label for="login">Login : </label>
				<input type="text" name="login" autofocus required/>

			</p>
			<p>
				<label for="nom">Nom : </label>
				<input type="text" name="nom" required />

			</p>
			<p>
				<label for="mdp">Mot de pass : </label>
				<input type="password" name="mdp" required />

			</p>
			<p>
				<label for="categorie">Categorie : </label>
				<input type="text" name="categorie" required />

			</p>
			<p>
				<input type="submit" value="Ajout de l\'employe" name="inserer"
			</p></fieldset></form>';
			require_once('gabarit.php');
}



function afficherListeDeroulante(){
	$contenu='<p>Liste des catégories</br>
				<select name="categorie">
					<option value="agent">Agent</option>
					<option value="mecanicien">Mecanicien</option>
					<option value="directeur">Directeur</option>
				</select>
			</p>';
	require_once('gabarit.php');
	
}

//Affiche les interventions
function afficherListe($liste){
	$contenu='<form action="directeur.php" method="post"><fieldset>
	<legend>Liste des interventions</legend>
	<p><input type="submit" value="Ajouter une intervention" name="ajoutIntervention" /> </p>';
			foreach($liste as $ligne){
				$contenu.='<p><input type="checkbox" name="'.$ligne->idTI.'"/> '.$ligne->nomTI.'</p>';
			}
	$contenu.='<p><input type="submit" value="Supprimer les interventions cochés" name="supprimerInterventions"</p></fieldset>';
	require_once('gabarit.php');
}

//Affiche la liste des interventions en mode midif
function afficherInterventions($liste){
	$contenu='<form action="directeur.php" method="post"><fieldset>
	<legend>Nouvelle intervention</legend>';
				$contenu.='
			<p>
				<label for="nomTI">Nom du Type d\'intervention : </label>
				<input type="text" name="nomTI" autofocus required  />

			</p>
			<p>
				<label for="montant">Montant de l\'intervention : </label>
				<input type="text" name="montant" required  />

			</p>
			<p>
				<label for="element_piece">Element à fournir : </label>
				<input type="text" name="element_piece" required  />

			</p>';
	$contenu.='<p><input type="submit" value="Ajout de l\'intervention" name="ajouterIntervention" /> </p></fieldset></form>';
	require_once('gabarit.php');
}


//Afficher la lites des pièces par interventions
function afficherListePiece($liste){
	$contenu='<form action="directeur.php" method="post"><fieldset>
	<legend>Liste des pièces par intervention</legend>
	<p><input type="submit" value="Ajouter une piece" name="ajouterPiece" /> </p>';
			foreach($liste as $ligne){
				$contenu.='<p>'.$ligne->nomTI. ': '.$ligne->element_piece.'</p>';
			}
	$contenu.='</fieldset></form>';
	require_once('gabarit.php');
}

//Affiche la liste des pièces par interventions en mode saisie texte
function afficherPiece($liste){
	$contenu='<form action="directeur.php" method="post"><fieldset>
	<legend>Liste des pièces par intervention</legend>
	<p><input type="submit" value="Ajouter une piece" name="ajouterPiece" /> </p>';
			foreach($liste as $ligne){
				$contenu.='<p>'.$ligne->nomTI.': <input type="text" name="'.$ligne->idTI.'" value="'.$ligne->element_piece.'"</p>';
			}
	$contenu.='<p><input type="submit" value="Valider les pieces" name="insererPiece" /> </p></fieldset></form>';
	require_once('gabarit.php');
}


function AfficherErreur($erreur){
	$contenu='<p>'.$erreur.'</p>
	          <p><a href="directeur.php"/> Revenir a la page d acceuil</a></p>';
	require_once('gabarit.php');		  
}