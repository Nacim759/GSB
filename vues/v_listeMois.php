 <div id="contenu">
 	<?php if($_SESSION['statut']=='Visiteur'){?>
	<h2>Mes fiches de frais</h2>
	<?php }else{?>
	<h2>Fiches de Frais à Valider</h2>
	<?php }?>
	<form class="s12" action="index.php?uc=etatFrais&action=voirEtatFrais" method="post">
		<div class="row">
			<div class="input-field col s12">
				<select id="lstMois" name="lstMois">
				 <?php
					foreach ($lesMois as $unMois)
					{
						$mois = $unMois['mois'];
						$numAnnee =  $unMois['numAnnee'];
						$numMois =  $unMois['numMois'];
						if($mois == $moisASelectionner){
						?>
						<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
						<?php 
						}
						else{ ?>
						<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
						<?php 
						}
					}
				   ?> 
				</select>
				<label>Selectionner le Mois</label>
			</div>
		</div>
		
		<div class="row col s12">
			<button class="btn waves-effect waves-light" type="submit" name="valider">Valider
				<i class="material-icons right">check</i>
			</button>

			<button class="btn waves-effect waves-light" type="reset" name="annuler">Effacer
				<i class="material-icons right">autorenew</i>
			</button>
		</div>
	</form>
</div>