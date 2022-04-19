<div id="contenu">
	<h2>Descriptif des éléments hors forfait</h2>
	<table class="striped centered">
		<thead>
			<tr>
				<th class="date">Date</th>
				<th class="libelle">Libellé</th>  
                <th class="montant">Montant</th>  
                <th class="action">&nbsp;</th> 
			</tr>
		</thead>
		<?php    
	    foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
		{
			$libelle = $unFraisHorsForfait['libelle'];
			$date = $unFraisHorsForfait['date'];
			$montant=$unFraisHorsForfait['montant'];
			$id = $unFraisHorsForfait['id'];
		?>
		
		<tbody>
			<tr>
                <td> <?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td>
					<a class="waves-effect waves-light btn" href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">
						<i class="material-icons right">delete</i>
						Supprimer ce frais
					</a>
				</td>
			</tr>
		</tbody>
		<?php		 
        }
		?>	
	</table>
	
	<form class="s12" action="index.php?uc=gererFrais&action=validerCreationFrais" method="post">
		<h2>Nouvel élément hors forfait</h2>
		<table class="striped centered">
			<thead>
				<tr>
					<th>Date (jj/mm/aaaa)</th>
					<th>Libellé</th>
					<th>Montant</th>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<td>
						 <div class="input-field col s6">
							<input type="text" id="txtDateHF" name="dateFrais" size="10" maxlength="10" value=""  />
						 </div>
					</td>
					<td>
						 <div class="input-field col s6">
							 <input type="text" id="txtLibelleHF" name="libelle" size="70" maxlength="256" value="" />
						 </div>
					</td>
					<td>
						 <div class="input-field col s6">
							<input type="text" id="txtMontantHF" name="montant" size="10" maxlength="10" value="" />
						 </div>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="row col s12">
			<button class="btn waves-effect waves-light" type="submit" name="Ajouter" value="Ajouter">Ajouter
				<i class="material-icons right">add</i>
			</button>

			<button class="btn waves-effect waves-light" type="reset" name="annuler">Effacer
				<i class="material-icons right">delete_forever</i>
			</button>
		</div>
	</form>
</div>
          
    		
            
	  
                                      
     
         
            
              

             

              


