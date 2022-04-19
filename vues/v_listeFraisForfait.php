<div id="contenu">
    <h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee ?></h2>
         
    <form class="s12" method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
          
        <table class="striped centered">
			<h3>Eléments forfaitisés</h3>
			<?php
			foreach ($lesFraisForfait as $unFrais)
			{
				$idFrais = $unFrais['idfrais'];
				$libelle = $unFrais['libelle'];
				$quantite = $unFrais['quantite'];
			?>
			<thead>
				<tr>
					<td><?php echo $libelle ?></td>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<td><input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>"></td>
				</tr>
			</tbody>
			<?php
				}
			?>
		</table>

		<div class="row col s12">
			<button class="btn waves-effect waves-light" type="submit" name="valider">Valider
				<i class="material-icons right">send</i>
			</button>

			<button class="btn waves-effect waves-light" type="reset" name="annuler">Effacer
				<i class="material-icons right">autorenew</i>
			</button>
		</div>
	</form>
</div>
  