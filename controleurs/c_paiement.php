<?php
include ("vues/v_sommaire.php");
$action = $_REQUEST ['action'];
switch ($action) {
	case 'affichageVisiteur' :
		{
			// récupère les paiements (montant de fiche de frais en fonction du visiteurs)
			// et le total à mettre en paiement.

			$lesDonnees = $pdo->getlesFichesdeFrais ();
			// retourne les nom et prnéom et leur montant de frais pour chaque personne
			if (!$lesDonnees) {
			$message = "aucune fiche de frais pour ce mois !!";
			include ("vues/v_message.php");
			}
			else {
			include ("vues/v_paiementFicheFrais.php");
			}
			
			break;
		}
	
	case 'mettrePaiement' :
		{
			// supprime les fichers de paiements du tableau car elles sont en cours de paiements
			// modifie l'état de la fiche de frais pour passer de VA à MB
			$lesDonnees = $pdo->majFicheFrais();
			//include ("vues/v_paiementFicheFrais.php");
			$validMessage = "Aucune fiche de frais pour ce mois  !!";
			include ("vues/v_messageValid.php");
			break;
		}
}
?>