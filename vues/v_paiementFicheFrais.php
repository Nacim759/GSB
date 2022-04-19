<div id="contenu">
	<form class="s12" method="post" action="index.php?uc=paiement&action=mettrePaiement" >
		<h2>Mise en paiement des Fiches de Frais</h2> 

		<table class="striped centered">
			<thead>
				<tr>
					<th class="nom">Nom</th>
					<th class="prenom">Prenom</th>
					<th class="mois">Mois</th>
					<th class='montantForfait' >Montant Forfait</th>
					<th class="id" style="display: none;">id</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$totalPaiement=0;
				foreach ( $lesDonnees as $uneDonnee ) {
				?>
				<tr>
					<td><?php echo $nom = $uneDonnee ['nom']; ?></td>
					<td><?php echo $prenom  = $uneDonnee ['prenom']; ?></td>
					<td><?php echo $mois = $uneDonnee ['mois']; ?></td>
					<td><?php echo $montantForfait = $uneDonnee ['montantValide']; ?></td>
					<td style="display: none;"><?php  $id = $uneDonnee ['idVisiteur']; ?></td>
				</tr>
				<?php $totalPaiement = $totalPaiement + $montantForfait;
				}
				?>
			</tbody>
		</table>
					
		<div class="row">
			<div class="row col s12">
				<h3>Total a mettre en paiement : <?php echo $totalPaiement ?>  Euro(s)</h3>
			</div>
			<div class="row col s12">
				<button class="btn waves-effect waves-light" type="submit" name="valider">MISE EN PAIEMENT
					<i class="material-icons right">attach_money</i>
				</button>
			</div>
		</div>
	</form>
</div>














