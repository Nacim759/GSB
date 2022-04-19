<div id="contenu">
	<h2>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : </h2>
	Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> 
	<br> 
	Montant validé : <?php echo $montantValide?>
	
	<table class="striped centered">
		<h3>Eléments forfaitisés</h3>
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
				<th class='total'>Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php
				$total=0;
			    foreach (  $lesFraisForfait as $unFraisForfait  ) 
			    {
					$quantite = $unFraisForfait['quantite'];
					
					if($unFraisForfait['idfrais']=='ETP'){
						$total=$unFraisForfait['quantite']*110.00;
					}
					if($unFraisForfait['idfrais']=='KM'){
						$total=$unFraisForfait['quantite']*0.62;
					}
					if($unFraisForfait['idfrais']=='NUI'){
						$total=$unFraisForfait['quantite']*80.00;
					}
					if($unFraisForfait['idfrais']=='REP'){
						$total=$unFraisForfait['quantite']*25.00;
					}
				?>
					<td class="qteForfait"><?php echo $quantite?> </td>
				<?php
				}
				?>
				<td><?php echo $total." €"; ?></td>
			</tr>
		</tbody>
	</table>
	<?php if(!empty($lesFraisHorsForfait))
	{
	?>
		<h3>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -</h3>
		<table class="striped centered">
			<thead>
				<tr>
					<th class='date'>Date</th>
					<th class='libelle'>Libellé</th>
					<th class='montant'>Montant</th> 
				</tr>
			</thead>
			<?php      
			foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
			{
				$date = $unFraisHorsForfait['date'];
				$libelle = $unFraisHorsForfait['libelle'];
				$montant = $unFraisHorsForfait['montant'];
			?>
			<tbody>
				<tr>
					<td><?php echo $date ?></td>
					<td><?php echo $libelle ?></td>
					<td><?php echo $montant ?></td>
				</tr>
			</tbody>
			<?php
			}
			?>
		</table>
	<?php 
	}else{
    	echo'<h2>Aucun Frais hors forfait enregistré !</h2>';
    }
	?>
</div>


    

        
             
        
    </table>
    
    
    
  </div>
  </div>
 













