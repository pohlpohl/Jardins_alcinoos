<?php require('views/header.php'); ?>

<div class="little_margin">
	<table>
		<thead>
			<tr>
				<th>N° d'achat</th>
				<th>Client</th>
				<th>Prix du panier</th>
				<th>Prix payé</th>
				<th>Prix en chèques</th>
			</tr>
		</thead>

		<tbody>
			<?php while ($data = $listeAchats->fetch()) : ?>
				<tr>
					<th><?= $data['id'] ?></th>
					<th><a href="index.php?action=liste-clients&&select=place&&id=<?= $data['client'] ?>"><?= $data['client_name'] ?></a></th>
					<th><?= $data['prix'] ?></th>
					<th><?= $data['montant'] ?></th>
					<th><?= $data['montant_chq_service'] ?></th>
				</tr>
			<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
			<th><strong>Sommes :</strong></th>
			<th><?= $sums['clients'] ?></th>
			<th><?= $sums['prix'] ?></th>
			<th><?= $sums['montant'] ?></th>
			<th><?= $sums['montant_chq'] ?></th>
			</tr>
		</tfoot>
	</table>
</div>

<?php require('views/footer.php'); ?>

</body>

</html>
