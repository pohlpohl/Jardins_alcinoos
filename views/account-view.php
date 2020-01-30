<?php require('views/header.php') ?>

<div class="container">
	<h2>Mon compte :</h2>

	<div class="row">
		<div class="col s12 m9">
			<h4 id="pseudo-display">Pseudo : <span id="user-pseudo"><?= $userInfo['prenom'] ?></span></h4>
			<h5 id="email-display">Email : <?= $userInfo['email'] ?></h5>
			<h5 id="auth-display">Autorisation : <?= $userInfo['auth'] ?></h5>
		</div>
	</div>
	<p><a class="btn" href="index.php?action=modify-user-display&&id=<?= $_SESSION['id'] ?>">Modifier mon compte</a></p>
	<?php if ($userInfo['auth'] == 'admin') : ?>
		<h3>Table des utilisateurs</h3>
		<table>
			<thead>
				<tr>
					<th>Prenom</th>
					<th>email</th>
					<th>Authorisations</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($userList as $data) : ?>
					<tr>
						<td><?= $data['prenom'] ?></td>
						<td><?= $data['email'] ?></td>
						<td><?= $data['auth'] ?></td>
						<th><a href="index.php?action=modify-user-display&&id=<?= $data['id'] ?>">Modifier</a> | <a class="modal-trigger" href="#delete-modal">Supprimer</a></th>
					</tr>
					<!-- Modal Structure -->
					<div id="delete-modal" class="modal">
						<div class="modal-content">
							<h4>Etes-vous sur de vouloir supprimer cet utilisateur ?</h4>
							<p>Cette action est irréversible.</p>
						</div>
						<div class="modal-footer">
							<a href="index.php?action=delete-user&&deleted-id=<?= $data['id'] ?>" class="modal-close waves-effect white-text red btn-flat">Supprimer</a>
						</div>
					</div>
				<?php endforeach; ?>
			</tbody>
		</table>
		<!-- Signin Form -->
		<div class="col s12 m6">
			<form id="signin_form" action="index.php?action=signin" method="post">
				<h3 id="ajax-test">Ajouter un utilisateur</h3>
				<div class="input-field">
					<input type="text" name="signin_prenom" id="signin_prenom" required>
					<label for="signin_prenom">Prénom</label>
				</div>
				<div class="input-field">
					<input type="text" name="signin_email" id="signin_email" required>
					<label for="signin_email">Email</label>
				</div>
				<div class="input-field">
					<input type="password" name="signin_password" id="signin_password" required>
					<label for="signin_password">Mot de passe</label>
				</div>
				<div class="input-field">
					<input type="password" name="signin_confirmation" id="signin_confirmation" required>
					<label for="signin_confirmation">Confirmation</label>
				</div>
				<select name="auth" id="auth">
					<option value="caisse">Caissier</option>
					<option value="admin">Administrateur</option>
				</select>
				<p id="signin_error"></p>
				<div class="input-field center">
					<input class="btn" type="submit" id="signin_submit" name="signin_submit" value="Ajouter un utilisateur !">
				</div>
			</form>
		</div>
	<?php endif; ?>
</div>

<?php require('views/footer.php'); ?>

</body>

</html>
