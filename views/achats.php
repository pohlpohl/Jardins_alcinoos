<?php require('views/header.php'); ?>

<div class="container">
	<h2>Nouvel achat</h2>
	<?php if ($_GET['action'] == "achats-display"): ?>
	<p>Vous avez sélectionné le lieu : <?= isInPlaceList($_SESSION['place'], $placeList)[1] ?>. <a href="index.php?action=delete-place">Changer de lieu</a></p>
	<?php endif; ?>
	<form action="index.php?action=achat" method="post" id="buy-form">
		<input type="hidden" name="place" value="<?= $_SESSION['place'] ?>">
		<div class="row">
			<div class="col s12 m6">
				<select name="client-selected" id="client-selected" autofocus>
					<option value="0" disabled selected>Sélectionnez un client</option>
					<?php while ($data = $clientsList->fetch()) : ?>
						<option value="<?= $data['id'] ?>" <?= ($_GET['action'] == 'modify-achat-display' && $data['id'] == $achatInfo['client']) ? 'selected' : ''; ?>><?= $data['nom_prenom'] ?></option>
					<?php endwhile; ?>
				</select>
				<label>Clients</label>
				<p id="client-selected-help" class="helper"></p>
			</div>
			<div class="col s12 m6 center">
				<p><a class='btn' href="index.php?action=new-client-display">Ajouter un nouveau client</a></p>
			</div>
			<div class="input-field col s12" id='notes-client'></div>
			<div class="input-field col s12">
				<input type="date" id='date-achat' name='date-achat' value='<?php echo ($_GET['action'] == 'modify-achat-display') ? $achatInfo['date_achat'] : (date('Y-m-d')); ?>'>
				<label for="date-achat">Date d'achat</label>
				<p id="date-achat-help" class="helper"></p>
			</div>
			<div class="input-field col s12">
				<p>Quel(s) type(s) d'achats ont été effectués ?</p>
				<div class="row">
					<label class="col m6 l3 black-text">
						<input type="checkbox" name="hygiene" id="hygiene" value="1" <?= ($_GET['action'] == 'modify-achat-display' && floor($achatInfo['type_marchandises'] % 16 / 8)) ? 'checked' : '' ?>>
						<span>Produits d'hygiène</span>
					</label>
					<label class="col m6 l3 black-text">
						<input type="checkbox" name="frais" id="frais" value="1" <?= ($_GET['action'] == 'modify-achat-display' && floor($achatInfo['type_marchandises'] % 8 / 4)) ? 'checked' : '' ?>>
						<span>Frais</span>
					</label>
					<label class="col m6 l3 black-text">
						<input type="checkbox" name="sec" id="sec" value="1" <?= ($_GET['action'] == 'modify-achat-display' && floor($achatInfo['type_marchandises'] % 4 / 2)) ? 'checked' : '' ?>>
						<span>Sec</span>
					</label>
					<label class="col m6 l3 black-text">
						<input type="checkbox" name="fruits-legumes" id="fruits-legumes" value="1" <?= ($_GET['action'] == 'modify-achat-display' && floor($achatInfo['type_marchandises'] % 2 / 1)) ? 'checked' : '' ?>>
						<span>Fruits & Légumes</span>
					</label>
				</div>
				<p id="type-achat-help" class="helper"></p>
			</div>
			<div class="input-field col s12 m4">
				<input type="number" name="prix" id="prix" step='0.5' min='0' value="0">
				<label for="prix">Prix de l'achat</label>
			</div>
			<div class="input-field col s12 m4">
				<input type="number" name="montant" id="montant" step='0.5' min='0' value="0">
				<label for="montant">Montant payé</label>
			</div>
			<div class="input-field col s12 m4">
				<input type="number" name="montant-chq" id="montant-chq" step='1' min='0' value="0">
				<label for="montant-chq">Valeur en cheques services</label>
			</div>
			<div class="col s12">
				<p id="new-balance"></p>
			</div>
			<div class="input-field col s12 row">
				<input type="submit" id="submit" value="Valider l'achat !" class="btn green darken-2 col s12 m6">
				<a href="#reset-modal" class="btn transparent modal-trigger black-text z-depth-0 col s12 m6">Annuler l'achat</a>
			</div>
		</div>
		<!-- Modal Structure -->
		<div id="reset-modal" class="modal">
			<div class="modal-content">
				<h4>Attention</h4>
				<p>Etes-vous sur de vouloir annuler cet achat ?</p>
			</div>
			<div class="modal-footer">
				<a id="reset-form" href="#!" class="modal-close waves-effect waves-red btn-flat red lighten-2">Annuler l'achat</a>
				<a href="#!" class="modal-close waves-effect waves-red btn-flat transparent">Continuer</a>
			</div>
		</div>
	</form>
</div>

<?php require('views/footer.php'); ?>
<script src="public/js/achats.js"></script>

</body>

</html>
