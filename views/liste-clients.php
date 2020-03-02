<?php require('views/header.php'); ?>

<section class="action-buttons container center">
	<a class="btn little_margin" href="index.php?action=new-client-display">Ajouter un nouveau client</a>
</section>

<div class="little_margin">
	<table>
		<thead>
			<tr>
				<th>NOM Prénom</th>
				<th>Lieu de provenance</th>
				<th>Balance</th>
				<th>Famille</th>
				<th>Travailleur</th>
				<th>Téléphone</th>
			</tr>
		</thead>

		<tbody>
			<?php while ($data = $listeClients->fetch()) : ?>
				<tr>
					<th><a href="index.php?action=liste-clients&&select=client&&id=<?= $data['id'] ?>"><?= $data['nom_prenom'] ?></a></th>
					<th><a href="index.php?action=liste-clients&&select=place&&id=<?= $data['lieu'] ?>"><?= $data['nom_lieu'] ?></a></th>
					<th><?= $data['balance'] ?></th>
					<th><?= $data['nbr_adultes'] . " ; " . $data['nbr_enfants'] . " ; " . $data['nbr_bebe'] ?></th>
					<th><a href="index.php?action=liste-clients&&select=ts&&id=<?= $data['ts_id'] ?>"><?= $data['ts_nom'] ?></a></th>
					<td><a href="tel:<?= $data['telephone'] ?>"><?= $data['telephone'] ?></a></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
</div>

<?php require('views/footer.php'); ?>

</body>

</html>
