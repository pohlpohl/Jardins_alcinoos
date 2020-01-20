<?php require('views/header.php') ?>

<div class="container">
	<h2>Mon compte :</h2>

	<div class="row">
		<div class="col s12 m9">
			<h4 id="pseudo-display">Pseudo : <span id="user-pseudo"><?= $userInfo['prenom'] ?></span></h4>
			<h5 id="email-display">Email : <?= $userInfo['email'] ?></h5>
		</div>
	</div>
	<?php if ($userInfo['auth'] == 'admin') : ?>
		<h3>Table des utilisateurs</h3>
		<table>
			<thead>
				<tr>
					<th>Prenom</th>
					<th>email</th>
					<th>Authorisations</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($userList as $data) : ?>
					<tr>
						<td><?= $data['prenom'] ?></td>
						<td><?= $data['email'] ?></td>
						<td><?= $data['auth'] ?></td>
						<td><a class="red btn-floating white-text" href="index.php?action=delete-user&&user-id=<?= $data['id'] ?>"><i class="material-icons">delete</i></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
	<!-- Signin Form -->
		<div class="col s12 m6">
			<form id="signin_form" action="index.php?action=signin" method="post">
				<h3 id="ajax-test">Ajouter un utilisateur</h3>
				<div class="input-field">
					<input type="text" name="signin_prenom" id="signin_prenom" required>
					<label for="signin_prenom">Prénom</label>
				</div>
				<div class="input-field">
					<input type="email" name="signin_email" id="signin_email" required>
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
				<p id="signin_error"></p>
				<div class="input-field center">
					<input class="btn" type="submit" id="signin_submit" name="signin_submit" value="Ajouter un utilisateur !">
				</div>
			</form>
		</div>
</div>

<?php require('views/footer.php'); ?>

</body>

</html>
