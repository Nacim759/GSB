
<div id="contenu">
	<form class="s12" method="POST" action="index.php?uc=connexion&action=valideConnexion">
		<h2>Interface de Connexion</h2>

		<div class="row">
			<div class="row col s12">
				<div class="input-field col s8">
					<input placeholder="Login" id="login" type="text" name="login"  size="30" maxlength="45" required>
					<label for="nom">Login</label>
				</div>
			</div>
			<div class="row col s12">
				<div class="input-field col s8">
					<input placeholder="Mot de Passe" id="mdp"  type="password"  name="mdp" size="30" maxlength="45" required>
					<label for="mdp">Mot de passe</label>
				</div>
			</div>
			<div class="row col s12">
				<button class="btn waves-effect waves-light" type="submit" name="valider">Connexion
					<i class="material-icons right">send</i>
				</button>

				<button class="btn waves-effect waves-light" type="reset" name="annuler">Effacer
					<i class="material-icons right">autorenew</i>
				</button>
			</div>
		</div>
	</form>
</div>
