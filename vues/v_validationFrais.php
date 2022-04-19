 <div class="row" id="contenu">
	<form class="s12" action="index.php?uc=validerFrais&action=voirEtatFrais" method="post">
		<h2>Les fiches de frais</h2>
			
		<div class="input-field col s8">
			<select id="lstVis" name="lstVis">
				<?php
				if(!empty($lesVisiteurs)){ ?>
					<?php
					foreach ($lesVisiteurs as $unVis)
					{					
						?>
							<option value="<?php echo $unVis['id'] ?>" <?php if($idAutreVisiteur == $unVis['id']) { ?> selected <?php } ?> ><?php echo $unVis['nom']." ".$unVis['prenom']; ?></option>
						<?php 
					}
				}else{
				?>
					<option><?php echo 'Aucun Visiteur ne possède de fiche de frais'; ?></option>
				<?php
				}
				?>
			</select>
			<label>Visiteur :</label>
		</div>
		
		<div class="input-field col s8">
			<select id="lstMois" name="lstMois">
				<?php
				foreach ($lesMois as $unMois)
				{
					?>
						<option value="<?php echo $unMois['mois'] ?>" <?php if($leMois == $unMois['mois']) { ?> selected <?php } ?> ><?php echo $unMois['numMois']."/".$unMois['numAnnee']; ?></option>
					<?php
				}
				?>
			</select>
			<label>Mois :</label>
		</div>
		
		<div class="row col s12">
			<button class="btn waves-effect waves-light" type="submit" name="valider">Search
				<i class="material-icons right">search</i>
			</button>
		</div>
	</form>
</div>