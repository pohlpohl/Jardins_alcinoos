<?php require('views/header.php'); ?>

<form id="new-client-form" action="index.php?action=new-client-add" method="POST" class="container row">
	<h3 class="col s12">Nouveau client :</h3>
	<div class="input-field col s12 m6">
		<input type="text" id="client-first-name" name="client-first-name" required autofocus>
		<label for="client-first-name">Prénom</label>
	</div>
	<div class="input-field col s12 m6">
		<input type="text" id="client-last-name" name="client-last-name" required>
		<label for="client-last-name">Nom</label>
	</div>
	<div class="input-field col s12 m6">
		<select name="place-selected" id="place-selected">
			<?php foreach ($placeList as $data) : ?>
				<option value="<?= $data['id'] ?>" <?php echo (isset($_SESSION['place']) && $_SESSION['place'] == $data['id']) ? 'selected' : '' ?>><?= $data['nom'] ?></option>
			<?php endforeach; ?>
		</select>
		<label>Lieu de provenance du client</label>
	</div>
	<div class="input-field col s12 m6">
		<input type="text" id="client-phone" name="client-phone" placeholder="01.23.45.67.89" required>
		<label for="client-phone">Numéro de téléphone</label>
	</div>
	<div class="input-field col s12 m4">
		<input type="number" id="client-adults" name="client-adults" value="0" min="0" required>
		<label for="client-adults">Nombre d'adultes</label>
	</div>
	<div class="input-field col s12 m4">
		<input type="number" id="client-children" name="client-children" value="0" min="0" required>
		<label for="client-children">Nombre d'enfants</label>
	</div>
	<div class="input-field col s12 m4">
		<input type="number" id="client-babies" name="client-babies" value="0" min="0" required>
		<label for="client-babies">Nombre de bébés</label>
	</div>
	<div class="input-field col s12">
		<select name="social-worker" id="social-worker">
			<?php foreach ($socialWorkers as $data) : ?>
				<option value="<?= $data['id'] ?>"><?= $data['nom_prenom'] . "  (" . $data['telephone'] . ")" ?></option>
			<?php endforeach; ?>
		</select>
		<label>Sélectionnez le travailleur social</label>
	</div>
	<input type="submit" value="Ajouter !" class="btn green darken-2 col s12">
</form>

<?php require('views/footer.php'); ?>

</body>

</html>
