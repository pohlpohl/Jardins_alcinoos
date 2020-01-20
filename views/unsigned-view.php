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
	<title>Le jardin d'Alcinoos - Authentification</title>
</head>

<body>
	<div class="container center">
		<h1>Bienvenue au Jardin D'Alcinoos</h1>
	</div>
	<div id="authentification_container" class="container z-depth-2 row">
		<h4 class="center">Pour utiliser le site, vous devez vous authentifier</h4> 
		<!-- Login Form -->
		<div class="col s12 m6 offset-m3">
			<h3>Se connecter</h3>
			<form id="login_form" action="index.php?action=login" method="post">
				<div class="input-field">
					<input type="text" name="login_authentifier" id="login_authentifier" required>
					<label for="login_authentifier">Mail</label>
				</div>
				<div class="input-field">
					<input type="password" name="login_password" id="login_password" required>
					<label for="login_password">Mot de passe</label>
				</div>
				<p id="login_error"></p>
				<div class="input-field center">
					<input class="btn" type="submit" name="login_submit" value="Se connecter !">
				</div>
			</form>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<!-- Materialize js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<!-- Custom js -->
	<script src="public/js/unsigned-view.js"></script>
</body>

</html>
