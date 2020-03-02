<?php require('views/header.php'); ?>

<?php if (isset($_GET['select']) && $_GET['select'] != 'all') : ?>
	<div class="container row">
		<p><input type="date" class="col s12 m4 offset-m4" name="date-selection" id="date-selection" value="<?= $_GET['select'] ?>"></p>
		<p><a class="btn" href="index.php?action=achats-recap&&select=all">Voir tout</a></p>
	</div>
<?php endif; ?>

<div class="little_margin">
	<table>
		<thead>
			<tr>
				<th>Client</th>
				<th>Date</th>
				<th>Prix du panier</th>
				<th>Prix payé</th>
				<th>Prix en chèques</th>
				<th>Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php while ($data = $listeAchats->fetch()) : ?>
				<tr>
					<th><a href="index.php?action=liste-clients&&select=client&&id=<?= $data['client'] ?>"><?= $data['client_name'] ?></a></th>
					<th><?= $data['date_fr'] ?></th>
					<th><?= $data['prix'] ?></th>
					<th><?= $data['montant'] ?></th>
					<th><?= $data['montant_chq_service'] ?></th>
					<th><a href="index.php?action=modify-achat-display&&id=<?= $data['id'] ?>">Modifier</a> | <a class="modal-trigger" href="#delete-modal">Supprimer</a></th>
				</tr>
				<!-- Modal Structure -->
				<div id="delete-modal" class="modal">
					<div class="modal-content">
						<h4>Etes-vous sur de vouloir supprimer cet achat ?</h4>
						<p>Cette action est irréversible.</p>
					</div>
					<div class="modal-footer">
						<a href="index.php?action=delete-achat&&id=<?= $data['id'] ?>" class="modal-close waves-effect white-text red btn-flat">Supprimer</a>
					</div>
				</div>
			<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<th><strong>Sommes :</strong></th>
				<th><?= $sums['clients'] ?> clients</th>
				<th><?= $sums['prix'] ?> euros</th>
				<th><?= $sums['montant'] ?> euros</th>
				<th><?= $sums['montant_chq'] ?> euros</th>
			</tr>
		</tfoot>
	</table>
</div>

<?php require('views/footer.php'); ?>
<script>
	$('#date-selection').on("change", function() {
		if (this.value) {
			window.location.replace("index.php?action=achats-recap&&select=" + this.value);
		}
	});
</script>

</body>

</html>
