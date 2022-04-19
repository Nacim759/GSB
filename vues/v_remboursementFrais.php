<script type="text/javascript">
function checkAllBox(ref, name) {
    var form = ref;
     
    while (form.parentNode && form.nodeName.toLowerCase() != 'form') { form = form.parentNode; }
     
    var elements = form.getElementsByTagName('input');
     
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox' && elements[i].name == name) {
            elements[i].checked = ref.checked;
        }
    }
}
</script>
<div id="contenu">
	<h2>Fiche de frais : </h2>
	
	<form class="s12" method='POST' action='index.php?uc=suiviRemboursement&action=valider'>
		<h3>Fiches de frais des visiteurs</h3>

		<table class="striped centered">
			<thead>
				<tr>
					<th class='nom'> Nom </th>    
                <th class='nom'> Mois </th>    
                <th class='montant'> Montant </th>     
                <th class="valide"> Valider </th> 
				</tr>
			</thead>
			<tbody>
				<?php
				$nbFiche=1;
				foreach ( $lesVisiteursRemboursement as $unVisiteur )//parcours des visiteur avec fiches MP
				{
					$lesFiches = $pdo->getLesFichesFraisRemboursement($unVisiteur['id']);
					$nom = $unVisiteur['nom'];
					$prenom = $unVisiteur['prenom'];
					?>
					<td><?php echo $nom." ".$prenom?></td><!-- Pour avoir un affichage en forme de puce -->
					<td> </td>
					<td> </td>
					<?php 
					//parcours des fiche du visiteur
					foreach ($lesFiches as $uneFiche)
					{
						$montantValide = $uneFiche['montantValide'];
						$mois = substr( $uneFiche['mois'],4,2)."/".substr( $uneFiche['mois'],0,4);//on passe de 201512 à 12/2015 par exemple
						?>
						<tr>
							<td><!-- Pour l'affichage en forme de puce --></td>
							<td><?php echo $mois ?></td>
							<td><?php echo $montantValide."€" ?></td>
							<td>
							  <label>
								<input class="filled-in" type="checkbox" name="choix[]" value="<?php echo $nbFiche;?>" id="<?php echo $nbFiche;?>">
								<span></span>
							  </label>
							  <!-- Liste de checkbox pour tous cocher via JS -->
							</td>
						</tr>
					<?php }
				$nbFiche++;//fiche suiviante
		  	  	}
				?>
			</tbody>
		</table>
		<!-- Permet de cocher toutes les checkbox -->
		<div class="row s12">
			<label>
				<input for="checkAll" type="checkbox" class="filled-in" onclick="checkAllBox(this, 'choix[]');" />
				<span>Tous cocher</span>
			</label>
		</div>
		<div class="row s12">
			<button class="btn waves-effect waves-light" type="submit" name="nom">Valider
				<i class="material-icons right">check_box</i>
			</button>
		</div>
	</form>
</div>