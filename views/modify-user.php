<?php require('views/header.php'); ?>

<!-- Signin Form -->
<div class="container">
	<form id="form" action="index.php?action=modify-user&&modified-id=<?= $userInfo['id'] ?>" method="post">
		<h3 id="ajax-test">Modifier utilisateur</h3>
		<div class="input-field">
			<input type="text" name="prenom" id="prenom" value="<?= $userInfo['prenom'] ?>" required>
			<label for="prenom">Prénom</label>
		</div>
		<div class="input-field">
			<input type="text" name="email" id="email" value="<?= $userInfo['email'] ?>" required>
			<label for="email">Email</label>
		</div>
		<?php if ($_GET['id'] == $_SESSION['id']): ?>
			<h5>Si vous ne souhaitez pas modifier le mot de passe, laissez les champs vides.</h5>
			<div class="input-field">
				<input type="password" name="old-password" id="old-password">
				<label for="old-password">Ancien mot de passe</label>
			</div>
			<div class="input-field">
				<input type="password" name="password" id="password">
				<label for="password">nouveau mot de passe</label>
			</div>
			<div class="input-field">
				<input type="password" name="confirmation" id="confirmation">
				<label for="confirmation">Confirmation</label>
			</div>
		<?php endif; ?>
		<?php if ($_SESSION['auth'] == 'admin'): ?>
			<select name="auth" id="auth">
				<option value="caisse" <?= ($userInfo['auth'] == 'caisse') ? 'selected' : '' ?>>Caissier</option>
				<option value="admin" <?= ($userInfo['auth'] == 'admin') ? 'selected' : '' ?>>Administrateur</option>
			</select>
		<?php endif; ?>
		<p id="error"></p>
		<div class="input-field center">
			<input class="btn" type="submit" id="submit" name="submit" value="Modifier l'utilisateur !">
		</div>
	</form>
</div>

<?php require('views/footer.php'); ?>

</body>

</html>
