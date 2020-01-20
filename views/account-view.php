<?php require('views.header.php') ?>

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
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Materialize js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<!-- Custom js -->
<script src="public/js/account-view.js"></script>
<!-- Materialize initializations -->
<script>
	$(document).ready(function() {
		$('.dropdown-trigger').dropdown({
			constrainWidth: false,
			coverTrigger: false,
			alignment: 'right',
			hover: false
		});
	});
</script>
</body>
