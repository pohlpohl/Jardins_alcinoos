<?php require('views/header.php'); ?>

<form id="new-social-worker-form" action="index.php?action=new-social-worker-add" method="POST" class="container row">
	<h3 class="col s12">Nouveau travailleur social :</h3>
	<div class="input-field col s12 m6">
		<input type="text" id="first-name" name="first-name" required autofocus>
		<label for="first-name">Prénom</label>
	</div>
	<div class="input-field col s12 m6">
		<input type="text" id="last-name" name="last-name" required>
		<label for="last-name">Nom</label>
	</div>
	<div class="input-field col s12">
		<input type="text" id="phone" name="phone" placeholder="01.23.45.67.89">
		<label for="phone">Numéro de téléphone</label>
	</div>
	<div class="input-field col s12">
		<input type="email" id="email" name="email">
		<label for="email">e-mail</label>
	</div>
	<input type="submit" value="Ajouter !" class="btn green darken-2 col s12">
</form>

<?php require('views/footer.php'); ?>

</body>

</html>
