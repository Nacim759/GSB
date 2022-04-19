
<div class="row s12" id="contenu">
	<form class="s12" action="index.php?uc=validerFrais&action=valideEtatFrais&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" method="post">
		<h2>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : </h2>

		<div class="row">
			<?php 
			if(empty($lesFraisForfait))
			{
				echo 'Pas de fiche(s) de frais pour ce visiteur ce mois';
			}
			else
			{
			?>
				Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> 
				<br> 
				Montant validé : <?php echo $montantValide?>
				
				<table class="striped centered">
					<thead>
					    <tr>
							<?php
							foreach ( $lesFraisForfait as $unFraisForfait ) 
							{
							$libelle = $unFraisForfait['libelle'];
							?>	
							<th> <?php echo $libelle?></th>
							<?php
							}
							?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php
							foreach (  $lesFraisForfait as $unFraisForfait  ) 
							{
							?>
								<td><input type="text" name="<?php echo $unFraisForfait['idfrais']; ?>" value="<?php echo $unFraisForfait['quantite'] ?>"/></td>
							<?php
							}
							?>
						</tr>
					</tbody>
				</table>
			<?php
			}
			?>
			
			<div class="row col s12">
				<button id="ok" class="btn waves-effect waves-light" type="submit" name="valider">Valider
					<i class="material-icons right">add</i>
				</button>
			</div>
		</div>
	</form>
	
	<form class="s12" action="index.php?uc=validerFrais&action=valideEtatFrais&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" method="post">
		<h2>Descriptif des éléments hors forfait <?php echo $nbJustificatifs; ?> justificatifs reçus.</h2>

		<div class="row">
			<?php 
			if(!empty($lesFraisHorsForfait))
			{
			?>
				<table class="striped centered">
					<thead>
					    <tr>
							<th class="date">Date</th>
							<th class="libelle">Libellé</th>
							<th class='montant'>Montant</th>     
							<th class='etatFrais'>Etat</th> 
							<th class='reporteFrais'>Reporter</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ( $lesFraisHorsForfait as $unFraisHorsForfait )
						{
							$date = $unFraisHorsForfait['date'];
							$libelle = $unFraisHorsForfait['libelle'];
							$montant = $unFraisHorsForfait['montant'];
						?>
						<tr>
							<td><?php echo $date ?></td>
							<td><?php echo $libelle ?></td>
							<td><?php echo $montant ?></td>
							<td>
								<a class="waves-effect waves-light btn" href="index.php?uc=validerFrais&action=refuserFraisHorsForfait&id=<?php echo $unFraisHorsForfait['id']; ?>&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" title="REFUSER" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette entrée?'));">
									<i class="material-icons right">delete</i>
									REFUSER
								</a>
							</td>
							<td>
								<a class="waves-effect waves-light btn" href="index.php?uc=validerFrais&action=reporterFraisHorsForfait&id=<?php echo $unFraisHorsForfait['id']; ?>&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" title="REPORTER" onclick="return(confirm('Etes-vous sûr de vouloir repporter cette entrée?'));">
									<i class="material-icons right">access_time</i>
									REPORTER
								</a>
							</td>
						</tr>
						<?php 
						}
						?>
					</tbody>
				</table>
			<?php
			}else{
				echo 'Aucun frais hors forfait de ce visiteur ce mois-ci';
			}
			?>
			
			<div class="row col s12">
				<a class="waves-effect waves-light btn" href="index.php?uc=validerFrais&action=validerFicheFrais&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" title="VALIDER" onclick="return(confirm('Etes-vous sûr de vouloir valider cette fiche de frais?'));" id="boutonDroite">
					<i class="material-icons right">check</i>
					VALIDER LA FICHE
				</a>
			</div>
		</div>
	</form>
</div>
  

 













