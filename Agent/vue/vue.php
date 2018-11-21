<?php
function afficherAgentAccueil(){
	$contenuID='';
	$contenu='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenuFicheClient=' ';
    $contenuMontantTotal=' ';
	$contenuMontantPossible=' '; 
	$contenuInterventionDuClient=' '; 
	require_once('vue/gabarit.php');
}
	
function afficherSyntheseClient($client,$element){
	$contenuID='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenuFicheClient=' ';
    $contenuMontantTotal=' ';
	$contenuMontantPossible=' '; 
	$contenuInterventionDuClient=' '; 
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


function AfficherlisteMecanicien($listeMecanicien){
	$contenuID='';
	$contenu='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenuFicheClient=' ';
    $contenuMontantTotal=' ';
	$contenuMontantPossible=' '; 
	$contenuInterventionDuClient='';
	$contenu='<form action="Agent.php" method="post">
				<fieldset><legend>Choisir son mecanicien</legend>';
				$contenu.='<p>Liste des mecaniciens
				<select name="listeMecanicien">';
				foreach($listeMecanicien as $ligne){
					$contenu.='<option value="'.$ligne->idEmploye.'">'.$ligne->nomEmploye.'</option>';
				}
				$contenu.='</select></p><p><label for="semaine">Semaine : </label>
											<input type="text" name="semaine"/></p>';
			
				$contenu.='<input type="submit" value="Valider le mécanicien et la semaine" name ="validerMecanicien"/>';
	$contenu.='</fieldset></form>';
	require_once('gabarit.php');
}

function AfficherPlanning($listeMecanicien, $listeIntervention, $formations, $interventions){
	$contenuID='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenuFicheClient=' ';
    $contenuMontantTotal=' ';
	$contenuMontantPossible=' '; 
	$contenuInterventionDuClient=' '; 
	$contenu='<form action="Agent.php" method="post"><table>';
	$jour = array(null, "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche");
	if($formations == false){
		$contenu.='<fieldset><legend>Liste des formations</legend>
		<p>Pas de formation pour le moment.<p></fieldset>';
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
	$contenu.='</table>';
	$contenu.='<fieldset><legend>Initialisation du RDV</legend><p>
					<label for="id">Identifiant client : </label>
					<input type="text" name="idClient"" />
				</p>';
				
				$contenu.='<p>Liste des mecaniciens
				<select name="listeMecanicien">';
				foreach($listeMecanicien as $ligne){
					$contenu.='<option value="'.$ligne->idEmploye.'">'.$ligne->nomEmploye.'</option>';
				}
				$contenu.='</select>';
				
				$contenu.='<p>Liste des interventions
				<select name="listeIntervention">';
				foreach($listeIntervention as $ligne){
					$contenu.='<option name="idTI" value="'.$ligne->idTI.'">'.$ligne->nomTI.'</option>';
				}
				$contenu.='</select>';
				$contenu.='<p>
					<label for="id">Date du RDV : </label>
					<input type="date" name="date"" />
				</p>
				<p>
					<label for="id">Heure du RDV : </label>
					<input type="texte" name="heure"" />
				</p>
				<input type="submit" value="Valider le RDV" name ="validerRDV"/>';
	$contenu.='</fieldset></form>';
	require_once('gabarit.php');
}
	
function AfficherPriseRDV($listeMecano,$listeIntervention){
	$contenuID='';
	$contenu='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenuFicheClient=' ';
    $contenuMontantTotal=' ';
	$contenuMontantPossible=' '; 
	$contenuInterventionDuClient='';
	$contenu='<form action="Agent.php" method="post">
				<fieldset><legend>Initialisation du RDV</legend><p>
					<label for="id">Identifiant client : </label>
					<input type="text" name="idClient"" />
				</p>';
				
				$contenu.='<p>Liste des mecaniciens
				<select name="listeMecanicien">';
				foreach($listeMecano as $ligne){
					$contenu.='<option value="'.$ligne->idEmploye.'">'.$ligne->nomEmploye.'</option>';
				}
				$contenu.='</select>';
				
				$contenu.='<p>Liste des interventions
				<select name="listeIntervention">';
				foreach($listeIntervention as $ligne){
					$contenu.='<option name="idTI" value="'.$ligne->idTI.'">'.$ligne->nomTI.'</option>';
				}
				$contenu.='</select>';
				$contenu.='<p>
					<label for="id">Date du RDV : </label>
					<input type="date" name="date"" />
				</p>
				<p>
					<label for="id">Heure du RDV : </label>
					<input type="texte" name="heure"" />
				</p>
				<input type="submit" value="Valider le RDV" name ="validerRDV"/>';
	$contenu.='</fieldset></form>';
	require_once('gabarit.php');
}
	
function afficherID($idfinal){
	$contenuID='<p><fieldset>L\'ID du client est '.$idfinal.'</fieldset></p>';
	$contenu='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenuFicheClient=' ';
     $contenuMontantTotal=' ';
	 $contenuMontantPossible=' '; 
	$contenuInterventionDuClient=' '; 
	require_once('vue/gabarit.php');
}
	
function afficherIntervention($idClient,$listeInterventionDiff,$derniereIntervention){
	$contenuID='';
	$contenuFicheClient=' ';
     $contenuMontantTotal=' ';
	 $contenuMontantPossible=' '; 
	$contenuInterventionDuClient=' '; 
	$contenuDerInter='<form id="1" action="agent.php" method="post"><fieldset><legend>Dernière intervention</legend>';
	$contenuInterDiffere='<form id="2" action="agent.php" method="post"><fieldset><legend>Interventions en differe</legend>';
	$contenuInterPaye='';
	$contenu='';
		
			
	if($derniereIntervention == false){
									echo "Aucune intervention en attente de payement ";
	}else{
		foreach($derniereIntervention as $ligne){
								
		$contenuDerInter.='<p><input type="checkbox" name="'.$ligne->idTI.'"/> '.$ligne->nomTI.'.<br/> 
											</p>';
							}
	}
							
	if ($listeInterventionDiff == false){
							
							   echo "Aucune intervention en différé";
	}else{
		foreach($listeInterventionDiff as $ligne){				
		$contenuInterDiffere.= '<p><input type="checkbox" name="'.$ligne->idTI.'"/> '.$ligne->nomTI.'.<br/> 
											</p>';

											}
							}
		$contenuID='<p>ID Client: <input type="text" value="'.$idClient.'" name ="idClient"/></p>';
		$contenuDerInter.='<input type="submit" value="Payer la dernière intervention" name="validerDernierPayement"/>
						<input type="submit" value="Demander un differe" name="demandeDiffere"/></form></fieldset>';
		$contenuInterDiffere.='<input type="submit" value="Payer les différées" name="validerDiffere"/></form></fieldset>';
		
	 
		
											
		require_once('vue/gabarit.php');
	
}

function AfficherForumulaireClient(){
	$contenuID='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenuFicheClient=' ';
     $contenuMontantTotal=' ';
	 $contenuMontantPossible=' '; 
	$contenuInterventionDuClient=' ';
	$contenu='<form action="agent.php" method="post"> <form>
		<fieldset>
			<legend>Informations Client</legend>
			<p>
				<label for="prenom">Prénom : </label>
				<input type="text" name="prenom" id="prenom" autofocus required />
			</p>
			<p>
				<label for="nom">Nom : </label>
				<input type="text" name="nom" id="nom" required  />
			</p>
			<p>
				<label for="sexe">Sexe</label>
 				<select name="sexe">
 				<option value="blank" selected></option>
				<option value="man">Masculin</option>
 				<option value="woman">Féminin</option>
 				</select>
			</p>
			<p>
				<label for="naissance">Date de naissance: </label>
				<input type="date" name="naissance" id="naissance" autofocus required  />
			</p>
			<p>
				<label for="adresse">Adresse : </label>
				<input type="text" name="adresse" id="adresse" required  />
			</p>
			<p>
				<label for="postal">Code postal : </label>
				<input type="number" name="postal" min="0" max="95990" required  />
			</p>
			<p>
				<label for="numTel">Numero de telephone : </label>
				<input type="number" name="numTel" required  />

			</p>
			<p>
				<label for="mail">Mail : </label>
				<input type="text" name="mail" required />

			</p>
			<p>
				<label for="ville">Ville : </label>
				<input type="text" name="ville" id="ville" required  />
			</p>
			<p>
				<label for="pays">Pays : </label>
				<input type="text" name="pays" id="pays" required  />
			</p>
			<p>
				<label for="montant">Montant Max : </label>
				<input type="number" name="montant" required  />
			</p>
			<p>
				<input type="submit" value="Ajout du client" name="ajout"
			</p></fieldset></form>';
			require_once('vue/gabarit.php');
}


function afficherSynthese($syntheseClient,$syntheseIntervention,$somme,$differePossible){
	$contenuID='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenu='';
	$contenuFicheClient='<form id="3" action="agent.php" method="post"><fieldset><legend>Information du Client</legend>'; 
	$contenuMontantTotal='<form id="4" action="agent.php" method="post"><fieldset><legend>Montant total</legend>'; 
	$contenuMontantPossible='<form id="5" action="agent.php" method="post"><fieldset><legend>Decouvert restant possible </legend>';
	$contenuInterventionDuClient='<form id="6" action="agent.php" method="post"><fieldset><legend>Interventions realisées du client </legend>';

					if( $syntheseClient== false){
							$contenuFicheClient.= 'Aucune ligne ne correspond a votre requete</fieldset>';
					}
					else{
						foreach($syntheseClient as $ligne){
							$contenuFicheClient.='<p>Nom<input type="text" name="nom" value="'.$ligne->nom.'"</p></br>
													<p>Prenom <input type="text" name="prenom" value="'.$ligne->prenom.'"</p></br>
													<p>Sexe <input type="text" name="sexe" value="'.$ligne->sexe.'"</p></br>
													<p>Date de naissance<input type="date" name="naissance" value="'.$ligne->dateNaissance.'"</br></p
													<p>Adresse<input type="text" name="adresse" value="'.$ligne->adresse.'"</br></p>
													<p>Code Postal<input type="number" name="postal" value="'.$ligne->codePostal.'"</br></p>
													<p>Numero de telephone<input type="number" name="numTel" value="'.$ligne->numTel.'"</br></p>
													<p>Mail<input type="text" name="mail" value="'.$ligne->mail.'"</br></p>
													<p>Ville<input type="text" name="ville" value="'.$ligne->Ville.'"</br></p>
													<p>Pays<input type="text" name="pays" value="'.$ligne->Pays.'"</br></p>
													<p>Montant Max<input type="number" name="montant" value="'.$ligne->montantMax.'"</br></p>
													<p><input type="submit" value="Modifier client" name="modif"/></p>';
							/*$contenuFicheClient.=	'<p> Monsieur/Madame:  '.$ligne->nom.' '.$ligne->prenom.' a pour identifiant ID :'.$ligne->idClient.', domicilant au : '.$ligne->adresse.', joignable sur le numéro de téléphone: '.$ligne->numTel.'<br/> 
										</p>';*/
						}
					}
							
						
	if( $syntheseIntervention == false){
							$contenuInterventionDuClient.= 'Aucune ligne ne correspond a votre requete</fieldset>';
	}
	else{
		foreach($syntheseIntervention as $ligne){
			$contenuInterventionDuClient.='<p> Le '.$ligne->dateIntervention.' Intervention '.$ligne->codeIntervention.' :'.$ligne->nomTI.' au prix de  '.$ligne->montant.'€ actuellement en '.$ligne->etat.' a ete réalisée par le mécanicien '.$ligne->nomEmploye.'.<br/> 
										</p>';
						}
					}
					
			if( $somme == null){
							$contenuMontantTotal.= 'Aucune ligne ne correspond a votre requete</fieldset>';
			}
			else{
				foreach($somme as $ligne){
			$contenuMontantTotal.= '<p> Le prix total de différe réalisé à ce jour vaut : '.$ligne->total.' euros <br/> </p>';
								}
							}		
					
					
		if( $differePossible == null){
							$contenuMontantPossible.= 'Aucune ligne ne correspond a votre requete</fieldset>';
	}
	else{
		foreach($differePossible as $ligne){
	$contenuMontantPossible.= '<p> Decouvert restant :'.$ligne->differePossible.' euros <br/> </p>';
						}
					}	
					
					
   $contenuFicheClient.='</form></fieldset>';
   $contenuMontantTotal.='</form></fieldset>';
   $contenuMontantPossible.='</form></fieldset>';
   $contenuInterventionDuClient.='</form></fieldset>';
   
					
			
	require_once("vue/gabarit.php"); 
}

function AfficherErreur($erreur){
	$contenuFicheClient=' ';
     $contenuMontantTotal=' ';
	 $contenuMontantPossible=' '; 
	$contenuInterventionDuClient=' '; 
	$contenuID='';
	$contenuDerInter='';
	$contenuInterDiffere='';
	$contenuInterPaye='';
	$contenu='<p>'.$erreur.'</p>
	          <p><a href="agent.php"/> Revenir a la page d acceuil</a></p>';
	require_once('gabarit.php');		  
}
