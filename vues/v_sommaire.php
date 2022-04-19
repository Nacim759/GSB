
	<nav id="nav">
		<div class="nav-wrapper">
		  <ul id="nav-mobile" class="left hide-on-med-and-down">
			<li>
				<?php echo $_SESSION['type'] ?>
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
			</li>
			<?php if($_SESSION['type']=="Visiteur"){ ?>
				<li><a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">SAISIE FICHE DE FRAIS</a></li>
				<li><a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">MES FICHES DE FRAIS</a></li>
			<?php
			}else{?>
				<li><a href="index.php?uc=validerFrais&action=selectionnerVisiteur" title="Valider Fiche de Frais">VALIDER FICHE DE FRAIS</a></li>
				<li><a href="index.php?uc=paiement&action=affichageVisiteur" title="Mettre en paiement Fiche de Frais">METTRE EN PAIEMENT FICHE DE FRAIS</a></li>
				<li><a href="index.php?uc=suiviRemboursement&action=affichage" title="Suivi Remboursement">SUIVI REMBOURSEMENT</a></li>
			<?php
			}?>
			<li><a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">DECONNEXION</a></li>
		  </ul>
		</div>
	</nav>