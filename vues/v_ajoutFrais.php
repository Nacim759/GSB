<h3>Ajouter un nouveau frais hors forfait</h3>
<form method='POST' action='index.php?uc=gererFrais&action=validerCreationFrais'>
	<table class='striped'>
		<thead>
			<tr>
				<th>Date du frais (jj/mois/aaaa)</th>
				<th>Description du frais</th>
				<th>Montant engage</th>
				<th>Justificatif</th>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td><input  type='text' name='dateFrais'  size='30' maxlength='45'></td>
				<td><input  type='text' name='description'  size='50' maxlength='100'></td>
				<td><input  type='text' name='montant ' size='30' maxlength='45'></td>
				<td>
					<td>
						<label>
							<input type='radio' name='justificatif' value='oui'> 
							<span>oui</span>
						<label>
					</td>
					<td>
						<label>
							<input type='radio' name='justificatif' value='non'> 
							<span>non</span>
						<label>
					</td>
				</td>
			</tr>
		</tbody>
	</table>
	<input type='submit' value='Valider' name='valider'>
	<input type='reset' value='Annuler' name='annuler'>
</form>