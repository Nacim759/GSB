<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : </h3>


    <form action="index.php?uc=validerFrais&action=valideEtatFrais&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" method="post">
    <div class="encadre">
    
    <?php 
    if(empty($lesFraisForfait))
    {
    	echo 'Pas de fiche(s) de frais pour ce visiteur ce mois';
    }
    else
    {
    ?>
    <table class="listeLegere">
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?>
              
                     
    </p>
  	<table class="listeLegere">
  	   <caption>Eléments forfaitisés </caption>
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
        <tr>
        <?php
          foreach (  $lesFraisForfait as $unFraisForfait  ) 
		  {
		?>
                <td><input type="text" name="<?php echo $unFraisForfait['idfrais']; ?>" 
					value="<?php echo $unFraisForfait['quantite'] ?>" />
		 <?php
          }
		?>
		</tr>
    </table>
  
<div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
      </p> 
</div>
<?php
	if(!empty($lesFraisHorsForfait)){
		?>
  	<table class="listeLegere">
  	   <caption>Descriptif des Ã©lÃ©ments hors forfait <?php echo $nbJustificatifs; ?> justificatifs reÃ§us
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">LibellÃ©</th>
                <th class='montant'>Montant</th>     
                <th class='etatFrais'>Etat</th> 
				<th class='reporteFrais'>Reporter</th>
             </tr>
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
				<td><a href="index.php?uc=validerFrais&action=refuserFraisHorsForfait&id=<?php echo $unFraisHorsForfait['id']; ?>&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" title="REFUSER" onclick="return(confirm('Etes-vous sÃ»r de vouloir supprimer cette entrÃ©e?'));" class="bouton">REFUSER</a></td>
				<td><a href="index.php?uc=validerFrais&action=reporterFraisHorsForfait&id=<?php echo $unFraisHorsForfait['id']; ?>&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" title="REPORTER" onclick="return(confirm('Etes-vous sÃ»r de vouloir repporter cette entrÃ©e?'));" class="bouton">REPORTER</a></td>
             </tr>
        <?php 
          }
		?>
    </table>
	<?php
	}
		else{
			echo 'Aucun frais hors forfait de ce visiteur ce mois-ci';
		}
	?>
  </div>
  </div>
  <a href="index.php?uc=validerFrais&action=validerFicheFrais&lstVis=<?php echo $idAutreVisiteur; ?>&lstMois=<?php echo $leMois; ?>" title="VALIDER" 
  onclick="return(confirm('Etes-vous sÃ»r de vouloir valider cette fiche de frais?'));" class="bouton" id="boutonDroite">VALIDER LA FICHE</a>
  <?php }?>

 













