<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

require('controllers/controller.php');
require('controllers/user_controller.php');

try {
	if (isset($_GET['action'])) {
		switch (htmlspecialchars($_GET['action'])) {
			case 'home':
				home();
				break;
			case 'achats-display':
				if (isset($_SESSION['place'])) {
					achatsDisplay($_SESSION['place']);
				} else {
					achatsDisplay(0);
				}
				break;
			case 'change-place':
				if (isset($_POST['place-selected']) && $_POST['place-selected'] > 0) {
					$_SESSION['place'] = $_POST['place-selected'];
				}
				header('Location: index.php?action=achats-display');
				break;
			case 'delete-place':
				unset($_SESSION['place']);
				header('Location: index.php?action=achats-display');
				break;
			case 'achat':
				recordAchat($_POST);
				break;
			case 'new-client-display':
				newClientDisplay();
				break;
			case 'new-client-add':
				if ($_POST['place-selected'] == -1) {
					$newPlaceID = addPlace($_POST['new-place'], $_POST['new-place-short']);
					addClient(htmlspecialchars($_POST['client-first-name']), htmlspecialchars($_POST['client-last-name']), $newPlaceID, htmlspecialchars($_POST['client-phone']), htmlspecialchars($_POST['client-adults']), htmlspecialchars($_POST['client-children']), htmlspecialchars($_POST['client-babies']), htmlspecialchars($_POST['social-worker']));
				} else {
					addClient(htmlspecialchars($_POST['client-first-name']), htmlspecialchars($_POST['client-last-name']), htmlspecialchars($_POST['place-selected']), htmlspecialchars($_POST['client-phone']), htmlspecialchars($_POST['client-adults']), htmlspecialchars($_POST['client-children']), htmlspecialchars($_POST['client-babies']), htmlspecialchars($_POST['social-worker']));
				}
				break;
			case 'new-social-worker-display':
				newSocialWorkerDisplay();
				break;
			case 'new-social-worker-add':
				addSocialWorker($_POST['first-name'], $_POST['last-name'], $_POST['phone'], $_POST['email']);
				break;
			case 'export-csv':
				exportCsv();
				break;
			case 'liste-clients':
				if ($_SESSION['auth'] == 'admin') {
					if (isset($_GET['select'])) {
						$selectID = (isset($_GET['id']) && $_GET['id'] > 0) ? htmlspecialchars($_GET['id']) : 0;
						listeClientsDisplay(htmlspecialchars($_GET['select']), $selectID);
					} else {
						http_response_code(404);
						include('views/error_404.php');
						die();
					}
				} else {
					require('views/unauthorized.php');
				}
				break;
			case 'achats-recap':
				if ($_SESSION['auth'] == 'admin') {
					if (isset($_GET['select'])) {
						achatsRecapDisplay(htmlspecialchars($_GET['select']));
					} else {
						achatsRecapDisplay("all");
					}
				} else {
					require('views/unauthorized.php');
				}
				break;
			case 'modify-achat-display':
				if (isset($_GET['id']) && $_GET['id'] > 0) {
					modifyAchat($_GET['id']);
				}
				break;
			case 'delete-achat':
				if ($_SESSION['auth'] == 'admin' && isset($_GET['id']) && $_GET['id'] > 0) {
					deleteAchat(htmlspecialchars($_GET['id']), htmlspecialchars($_GET['go-back']));
				} else {
					http_response_code(404);
					include('views/error_404.php');
					die();
				}
				break;
			case 'signin':
				if ($_SESSION['auth'] == "admin" && $_POST['signin_password'] === $_POST['signin_confirmation']) {
					signin(htmlspecialchars($_POST['signin_prenom']), htmlspecialchars($_POST['signin_email']), htmlspecialchars($_POST['signin_password']), htmlspecialchars($_POST['auth']));
				} else {
					displayAccount($_SESSION['id']);
				}
				break;
			case 'login':
				login(htmlspecialchars($_POST['login_authentifier']), htmlspecialchars($_POST['login_password']));
				break;
			case 'logout':
				logout();
				break;
			case 'account':
				if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
					displayAccount($_SESSION['id']);
				}
				break;
			case 'modify-user-display':
				if (isset($_GET['id']) && ($_GET['id'] == $_SESSION['id'] || $_SESSION['auth'] == 'admin')) {
					displayModifyUser($_GET['id']);
				}
				break;
			case 'modify-user':
				modifyUserInfo($_SESSION['id'], htmlspecialchars($_GET['modified-id']), htmlspecialchars($_POST['prenom']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['old-password']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['confirmation']), (isset($_POST['auth'])) ? htmlspecialchars($_POST['auth']) : '');
				break;
			case 'delete-user':
				if (isset($_GET['deleted-id']) && $_GET['deleted-id'] > 0 && $_SESSION['auth'] = 'admin') {
					deleteUser($_SESSION['id'], htmlspecialchars($_GET['deleted-id']));
				}
				break;
			default:
				http_response_code(404);
				include('views/error_404.php');
				die();
				break;
		}
	} else {
		header('Location: index.php?action=home');
	}
} catch (Exception $e) {
	echo "Erreur : " . $e->getMessage();
}
