<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
	<meta charset="utf-8">
	<!-- Materialize CSS -->
	<link rel="stylesheet" href="Ref/materialize/css/materialize.min.css">
	<!-- Chartjs CSS -->
	<link rel="stylesheet" href="node_modules/chart.js/dist/Chart.min.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="public/css/style.css">
	<title>Le jardin d'Alcinoos - Tableau de bord</title>
</head>

<body>

	<nav>
		<div class="nav-wrapper grey darken-4">
			<a href="index.php?action=home" class="brand-logo">Le jardin d'Alcinoos</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li <?php echo (($_GET['action'] == 'home') ? "class=\"grey darken-1\"" : ''); ?>><a href="index.php?action=home">Tableau de bord</a></li>
				<li <?php echo (($_GET['action'] == 'achats-display') ? "class=\"grey darken-1\"" : ''); ?>><a href="index.php?action=achats-display">Achats</a></li>
				<li <?php echo (($_GET['action'] == 'liste-clients') ? "class=\"grey darken-1\"" : ''); ?>><a href="index.php?action=liste-clients&&select=all">Liste des clients</a></li>
				<li><a href="#" class="dropdown-trigger" data-target='account-dropdown'>Compte</a></li>
			</ul>
		</div>
	</nav>

	<!-- Dropdown Structure -->
	<ul id='account-dropdown' class='dropdown-content'>
		<li><a href="index.php?action=account">Mon Compte</a></li>
		<li class="divider" tabindex="-1"></li>
		<li><a href="index.php?action=logout">Se déconnecter</a></li>
	</ul>
