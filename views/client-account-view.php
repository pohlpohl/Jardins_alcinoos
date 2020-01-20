<?php require('views/header.php'); ?>

<div class="container row">
	<h3><?= $infos['nom_prenom'] ?>
		<a href="#!" class="btn-large waves-effect waves-light blue">Modifier</a>
		<a href="#delete-modal" class="modal-trigger btn-large waves-effect waves-light red">Supprimer</a>
	</h3>
	<p>Pseudo : <?= $infos['pseudo'] ?><br>
		Lieu assigné : <?= $infos['nom_lieu'] ?><br>
		Balance : <?= $infos['balance'] ?><br>
		Famille : <?= $infos['nbr_adultes'] . " adultes, " . $infos['nbr_enfants'] . " enfants et " . $infos['nbr_bebe'] . " bébés" ?><br>
		Travailleur : <a href="index.php?action=liste-clients&&select=ts&&id=<?= $infos['ts_id'] ?>"><?= $infos['ts_nom'] ?></a><br>
		Téléphone : <a href="tel:<?= $infos['telephone'] ?>"><?= $infos['telephone'] ?></a></p>
</div>

<!-- Modal Structure -->
<div id="delete-modal" class="modal">
	<div class="modal-content">
		<h4>Attention</h4>
		<p>Etes-vous sur de vouloir supprimer/désactiver ce client ?</p>
		<p>
			Si vous supprimez le compte, il sera définitivement inaccessible et sera supprimé de la base de données. 
		</p>
		<h6><u>Cette action est irréversible, n'utilisez cette option qu'en cas de création accidentelle de client !</u></h6>
		<p>
			Si vous le désactivez, son compte ne sera pas supprimé mais il ne sera plus visible, et aucune action ne pourra etre effectuée sur son compte jusqu'à ce qu'il soit réactivé.
		</p>
	</div>
	<div class="modal-footer">
		<a href="index.php?action=desactivate-client" class="modal-close waves-effect waves-red btn-flat white-text red darken-2">Désactiver le compte</a>
		<a href="index.php?action=delete-client" class="modal-close waves-effect waves-red btn-flat white-text red darken-4">Supprimer le compte</a>
		<a href="#!" class="modal-close waves-effect waves-red btn-flat transparent">Annuler</a>
	</div>
</div>

<?php require('views/footer.php'); ?>
<script src="public/js/tableau-de-bord.js"></script>

</body>

</html>
