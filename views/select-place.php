<?php require('views/header.php'); ?>

<form action="index.php?action=change-place" method="POST" class="container row">
	<h3 class="col s12">Merci de sélectionner la ville où vous vous trouvez :</h3>
	<div class="col s12 m7">
		<select name="place-selected" id="place-selected">
			<?php foreach ($placeList as $data) : ?>
				<option value="<?= $data['id'] ?>" <?php echo (isset($_SESSION['place']) && $_SESSION['place'] == $data['id']) ? 'selected' : '' ?>><?= $data['nom'] ?></option>
			<?php endforeach; ?>
		</select>
		<label>Choisissez le lieu où vous vous trouvez</label>
	</div>
	<input type="submit" value="Selectionner" class="btn green darken-2 col s12 m5">
</form>

<?php require('views/footer.php'); ?>

</body>

</html>
