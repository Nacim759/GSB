<?php
include ("vues/v_sommaire.php");

$action = $_REQUEST ['action'];
$idVisiteur = $_SESSION ['idVisiteur'];

switch ($action) {
	case 'selectionnerVisiteur' :
		{
			$leMois=-1;
			$idAutreVisiteur=-1;
			
			$lesVisiteurs = $pdo->getLesVisiteurs ();
			$lesMois=$pdo->getLesMois();
			include ("vues/v_validationFrais.php");
			break;
		}
	
	case 'voirEtatFrais' :
		{
			$leMois = $_REQUEST ['lstMois'];
			$idAutreVisiteur = $_REQUEST ['lstVis'];
			
			$lesMois = $pdo->getLesMois ();
			$lesVisiteurs = $pdo->getLesVisiteurs ();
			
			include ("vues/v_validationFrais.php");
			
			$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait ( $idAutreVisiteur, $leMois );
			$lesFraisForfait = $pdo->getLesFraisForfait ( $idAutreVisiteur, $leMois );
			$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais ( $idVisiteur, $leMois );
			
			$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais ( $idAutreVisiteur, $leMois );
			
			$numAnnee = substr ( $leMois, 0, 4 );
			$numMois = substr ( $leMois, 4, 2 );
			
			$libEtat = $lesInfosFicheFrais ['libEtat'];
			$montantValide = $lesInfosFicheFrais ['montantValide'];
			$nbJustificatifs = $lesInfosFicheFrais ['nbJustificatifs'];
			$dateModif = $lesInfosFicheFrais ['dateModif'];
			$dateModif = dateAnglaisVersFrancais ( $dateModif );
			
			include ("vues/v_etatFrais.php");
			break;
		}
	
	case 'valideEtatFrais' :
		{
			$etp = $_REQUEST ['ETP'];
			$km = $_REQUEST ['KM'];
			$nui = $_REQUEST ['NUI'];
			$rep = $_REQUEST ['REP'];
			
			$idAutreVisiteur = $_REQUEST ['lstVis'];
			$leMois = $_REQUEST ['lstMois'];
			
			$pdo->majInfoFraisForfaitise ( $idAutreVisiteur, $etp, $km, $nui, $rep );
			
			$lesVisiteurs = $pdo->getLesVisiteurs ();
			
			
			
			$lesMois = $pdo->getLesMois ();
			
			include ("vues/v_validationFrais.php");
			
			$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait ( $idAutreVisiteur, $leMois );
			
			$lesFraisForfait = $pdo->getLesFraisForfait ( $idAutreVisiteur, $leMois );
			
			$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais ( $idAutreVisiteur, $leMois );
			
			$numAnnee = substr ( $leMois, 0, 4 );
			$numMois = substr ( $leMois, 4, 2 );
			
			$libEtat = $lesInfosFicheFrais ['libEtat'];
			$montantValide = $lesInfosFicheFrais ['montantValide'];
			$nbJustificatifs = $lesInfosFicheFrais ['nbJustificatifs'];
			$dateModif = $lesInfosFicheFrais ['dateModif'];
			$dateModif = dateAnglaisVersFrancais ( $dateModif );
			
			include ("vues/v_etatFrais.php");
			
			break;
		}
	
	case 'refuserFraisHorsForfait' :
		{
			$idFrais=$_REQUEST['id'];
			$pdo->refuserFrais($idFrais);
			
			$lesVisiteurs = $pdo->getLesVisiteurs ();
				
			$idAutreVisiteur = $_REQUEST ['lstVis'];
			$leMois = $_REQUEST ['lstMois'];
				
			$lesMois = $pdo->getLesMois ();
				
			include ("vues/v_validationFrais.php");
				
			$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait ( $idAutreVisiteur, $leMois );
				
			$lesFraisForfait = $pdo->getLesFraisForfait ( $idAutreVisiteur, $leMois );
				
			$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais ( $idAutreVisiteur, $leMois );
				
			$numAnnee = substr ( $leMois, 0, 4 );
			$numMois = substr ( $leMois, 4, 2 );
				
			$libEtat = $lesInfosFicheFrais ['libEtat'];
			$montantValide = $lesInfosFicheFrais ['montantValide'];
			$nbJustificatifs = $lesInfosFicheFrais ['nbJustificatifs'];
			$dateModif = $lesInfosFicheFrais ['dateModif'];
			$dateModif = dateAnglaisVersFrancais ( $dateModif );
				
			include ("vues/v_etatFrais.php");
			
			break;
		}
		
	case 'validerFicheFrais' :
		{
			$idAutreVisiteur = $_REQUEST ['lstVis'];
			$leMois = $_REQUEST ['lstMois'];
			
			$pdo->validerFiche($idAutreVisiteur,$leMois);
			
			$lesVisiteurs = $pdo->getLesVisiteurs ();
					
			$lesMois = $pdo->getLesMois ();
				
			include ("vues/v_validationFrais.php");
			
			break;
		}
	
	case 'reporterFraisHorsForfait':
		{
			$idFrais=$_REQUEST['id'];
			
			$lesVisiteurs = $pdo->getLesVisiteurs ();
				
			$idAutreVisiteur = $_REQUEST ['lstVis'];
			$leMois = $_REQUEST ['lstMois'];
			
			//var_dump($leMois);
			
			$annee=substr($leMois,0,4);
			$mois=substr($leMois,4,2)+1;
			
			if($mois==13){
				$mois=1;
				$annee=$annee+1;
			}
			
			$anneeMois=$annee.$mois;
			
			//var_dump($anneeMois);
			
			$resultat=$pdo->reporterFrais($idFrais);
			
			$test=$pdo->creeNouvellesLignesFrais($idAutreVisiteur,$anneeMois);
			
			foreach($resultat as $unResultat){
				$mois=$unResultat['mois'];
				$libelle=$unResultat['libelle'];
				$date=$unResultat['date'];
				$montant=$unResultat['montant'];
				$etat=$unResultat['etat'];
			}
			
			$anneeDate=substr($date,0,4);
			$moisDate=substr($date,5,2);
			$jourDate=substr($date,8,2);
			
			$pdo->creeNouveauFraisHorsForfait($idAutreVisiteur,$anneeMois,$libelle,$jourDate."/".$moisDate."/".$anneeDate,$montant,$etat);	
			
			$lesMois = $pdo->getLesMois ();
				
			include ("vues/v_validationFrais.php");
				
			$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait ( $idAutreVisiteur, $leMois );
				
			$lesFraisForfait = $pdo->getLesFraisForfait ( $idAutreVisiteur, $leMois );
				
			$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais ( $idAutreVisiteur, $leMois );
				
			$numAnnee = substr ( $leMois, 0, 4 );
			$numMois = substr ( $leMois, 4, 2 );
				
			$libEtat = $lesInfosFicheFrais ['libEtat'];
			$montantValide = $lesInfosFicheFrais ['montantValide'];
			$nbJustificatifs = $lesInfosFicheFrais ['nbJustificatifs'];
			$dateModif = $lesInfosFicheFrais ['dateModif'];
			$dateModif = dateAnglaisVersFrancais ( $dateModif );
				
			include ("vues/v_etatFrais.php");
			
			break;
			
		}
}
?>