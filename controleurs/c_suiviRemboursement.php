<?php
include ("vues/v_sommaire.php");
$action = $_REQUEST['action'];
switch($action) {
	case 'affichage':{ // quand on selectionne le suivi de remboursement
		$lesVisiteursRemboursement = $pdo->getLesVisiteursRemboursement(); //visiteur avec des fiches MP
		if(!$lesVisiteursRemboursement){
			$message = "Aucune fiche de frais mise en paiement";
			include ("vues/v_message.php");
		}
		else{
		include("vues/v_remboursementFrais.php");
		}
		break;
	}
	
	case 'valider':{
		$i=1;//i=1 car mes checkbox commence a 1, representant le numero de la fiche
		$lesVisiteursRemboursement = $pdo->getLesVisiteursRemboursement();
		foreach ( $lesVisiteursRemboursement as $unVisiteur ){ // on parcours les visiteur avec une fiche MP
			$lesFiches = $pdo->getLesFichesFraisRemboursement($unVisiteur['id']);
			foreach ($lesFiches as $uneFiche){//on recupere toutes les fiche du visiteur
			if(isset($_POST['choix'])){//seulement si on a cocher une checkbox
				foreach($_POST['choix'] as $case){//parcour des checkbox
					if($case==$i)//il faut que le numero de la fiche et de la checkbox soit egaux
						$pdo->modificationRemboursement($uneFiche['idVisiteur'],$uneFiche['mois']);
				}
			}
			$i++;//fiche suivante
			}
		}
		if(!isset($_POST['choix'])){
			$message = "Vous n'avez rien cochez!!";
			include ("vues/v_message.php");
		}
		else{
		include("vues/v_remboursementFrais.php");
		}
	}
}
?>