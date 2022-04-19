<div class ="erreur">
	<ul>
		<?php 
		foreach($_REQUEST['erreurs'] as $erreur)
		{
			echo"<script type='text/javascript'>
					pop_up_erreur('$erreur'); 
					
					function pop_up_erreur(erreur){
						window.confirm(erreur);
						//console.log(erreur);
					}
				</script>";
		}
		?>
	</ul>
</div>
