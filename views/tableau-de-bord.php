<?php require('views/header.php'); ?>

<section class="row container general">
	<h3 class="center">Bienvenue sur le tableau de bord !</h3>
</section>

<section class="action-buttons container center">
	<?php if ($_SESSION['auth'] == 'admin') : ?>
		<a class="btn" href="index.php?action=achats-display">Panneau d'achats</a>
		<a class="btn" href="index.php?action=achats-recap&&select=<?= date('Y-m-d') ?>">Récapitulatif des achats du jour</a>
		<a class="btn" href="index.php?action=achats-recap&&select=all">Tout les achats</a>
	<?php endif; ?>
</section>

<section class='stats row'>
	<div class='col s12 l6'>
		<div class="card blue-grey darken-2">
			<div class="card-content white-text" id="chart-card">
				<div class="row">
					<div class="col s12">
						<ul class="tabs blue-grey darken-1">
							<li class="tab col s6"><a href="#avg-tab">Moyennes de la semaine</a></li>
							<li class="tab col s6"><a class="active" href="#sun-tab">Sommes de la semaine</a></li>
						</ul>
					</div>
					<div id="avg-tab" class="col s12">
						<p class="stats-date center"></p>
						<canvas id="avg-stats"></canvas>
					</div>
					<div id="sun-tab" class="col s12">
						<p class="stats-date center"></p>
						<canvas id="sum-stats"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='col s12 l6'>
		<div class="card blue-grey darken-2">
			<div class="card-content white-text">
				<span class="card-title">Clients créditeurs</span>
				<table>
					<thead>
						<tr>
							<th>Nom Prénom</th>
							<th>Balance</th>
							<th>Contact</th>
							<th>Travailleur social</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($data = $creditors->fetch()) : ?>
							<tr>
								<th><a href="index.php?action=liste-clients&&select=client&&id=<?= $data['id'] ?>"><?= $data['nom_prenom'] ?></a></th>
								<th><?= $data['balance'] ?></th>
								<th><a href="tel:<?= $data['telephone'] ?>"><?= $data['telephone'] ?></a></th>
								<th><a href="tel:<?= $data['ts_tel'] ?>"><?= $data['ts_nom'] ?></a></th>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class='col s12 l6'>
		<div class="card blue-grey darken-2">
			<div class="card-content white-text">
				<span class="card-title">Clients débiteurs</span>
				<table>
					<thead>
						<tr>
							<th>Nom Prénom</th>
							<th>Balance</th>
							<th>Contact</th>
							<th>Travailleur social</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($data = $debtors->fetch()) : ?>
							<tr>
								<th><a href="index.php?action=liste-clients&&select=client&&id=<?= $data['id'] ?>"><?= $data['nom_prenom'] ?></a></th>
								<th><?= $data['balance'] ?></th>
								<th><a href="tel:<?= $data['telephone'] ?>"><?= $data['telephone'] ?></a></th>
								<th><a href="tel:<?= $data['ts_tel'] ?>"><?= $data['ts_nom'] ?></a></th>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class='col s12 l6'>
		<div class="card blue-grey darken-2">
			<div class="card-content white-text">
				<span class="card-title">Clients absents depuis 1 mois</span>
				<table>
					<thead>
						<tr>
							<th>Nom Prénom</th>
							<th>Dernier achat</th>
							<th>Contact</th>
							<th>Travailleur social</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($data = $absents->fetch()) : ?>
							<tr>
								<th><a href="index.php?action=liste-clients&&select=client&&id=<?= $data['id'] ?>"><?= $data['nom_prenom'] ?></a></th>
								<th><?= $data['dernier_achat'] ?></th>
								<th><a href="tel:<?= $data['telephone'] ?>"><?= $data['telephone'] ?></a></th>
								<th><a href="tel:<?= $data['ts_tel'] ?>"><?= $data['ts_nom'] ?></a></th>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<!-- <a href="index.php?action=export-csv" class="btn">Exporter achats</a> -->

<?php require('views/footer.php'); ?>
<script src="public/js/tableau-de-bord.js"></script>

</body>

</html>
