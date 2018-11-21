<?php

function AfficherAccueil(){
	$contenu='';
	require_once('gabarit.php');
}

function AfficherFormation(){
	$contenu='<form action="Mecanicien.php" method="post">
				<fieldset><legend>Formation prévu</legend>';
	$contenu.='<p><label for="id">Votre ID Employe : </label><input type="text" name="idEmploye"/><p>';
	$contenu.='<p><label for="date">Date formation : </label><input type="date" name="date"/></p>';
	$contenu.='<p><label for="heure">Heure : </label><input type="text" name="heure" placeholder="ex: 2018-01-01 10:00:00"/></p>';
	$contenu.='<input type="submit" value="Valider Formation" name="validerFormation"</fieldset></form>';
	require_once('gabarit.php');
}



function AfficherPlanning($client, $element, $formations, $interventions){
	$contenu='<form action="Mecanicien.php" method="post">
			<input type="submit" value="Inserer Formation" name="insererFormation">';
	$contenu.='<table>';
	$jour = array(null, "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche");
	if($formations == false){
		$contenu.='<fieldset><legend>Liste des formations</legend>
		<p>Pas de formation en cours.<p></fieldset>';
	}else{
		$contenu.='<fieldset><legend>Liste des formations prevu</legend>';
	}
	foreach($formations as $ligne){
		$contenu.='<p>Formation '.$ligne->jour_formation.' à '.$ligne->heure_formation.'h00</p>';
		$jjF=$ligne->jour_formation;
		$hhF=$ligne->heure_formation;
		$rdv[$jjF][$hhF] = "Formation";
	}
	$contenu.='</fieldset>';
	if($interventions == false){
		$contenu.='<fieldset><legend>Liste des interventions</legend>
		<p>Pas d\'interventions pour le moment.<p></fieldset>';
	}else{
		$contenu.='<fieldset><legend>Liste des interventions prevu</legend>';
	}
	foreach($interventions as $ligne){
		$contenu.='<p><input type="checkbox" name="'.$ligne->codeIntervention.'"/> '.$ligne->nomTI.' '.$ligne->jour_intervention.' à '.$ligne->heure_intervention.'h00    
		<input type="submit" value="Informations Intervention" name="info"/></p>';
		$jjI=$ligne->jour_intervention;
		$hhI=$ligne->heure_intervention;
		$objet=$ligne->nomTI;
		$rdv[$jjI][$hhI] = $objet;
	}
	$contenu.='</fieldset>';
	$contenu.='<tr><th>Heure</th>';
    for($x = 1; $x < 8; $x++)
       $contenu.='<th>'.$jour[$x].'</th>';
    $contenu.="</tr>";
    for($j = 9; $j < 17; $j++) {
        $contenu.='<tr>';
        for($i = 0; $i < 7; $i++){
            if($i == 0) {
                $heure = $j;
				//if(substr($heure,-3,3) != ":30")
					$contenu.='<td class=\'time\'>'.$heure.'</td>';
            }
            $contenu.='<td>';
            if(!isset($rdv[$jour[$i+1]][$heure])) {
                $rdv[$jour[$i+1]][$heure] = 'oui';
            }else{
				$contenu.=$rdv[$jour[$i+1]][$heure];
			}
            $contenu.='</td>';
        }
        $contenu.='</tr>';
    }
	$contenu.='</table></form>';
	require_once('gabarit.php');
}

function afficherSyntheseClient($client,$element){
	$contenu='';
	foreach($client as $ligne){
		$contenu.='<fieldset><legend>Synthèse client</legend>';
		$contenu.='<p> Monsieur/Madame:  '.$ligne->nom.' '.$ligne->prenom.' a pour  ID '.$ligne->idClient.'. Domicilant au '.$ligne->adresse.'. Sera joignable sur le numéro de téléphone: 0'.$ligne->numTel.'<br/> 
										</p>';
	}
	foreach($element as $ligne){
		$contenu.='<p> Liste des pièces à fournir:  '.$ligne->ListePiece.'</p></fieldset>';
	}
	require_once('gabarit.php');
}

function afficherErreur($erreur){
	$contenuTsClient='';
	$contenu='<p>'.$erreur.'</p>
	          <p><a href="site.php"/> Revenir a la page d acceuil</a></p>';
	require_once('gabarit.php');		  
}