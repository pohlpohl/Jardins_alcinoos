<?php

require_once('models/autoload.php');

function signin($prenom, $email, $password, $auth)
{
	if (strlen($email) > 4) {
		if (strlen($password) >= 5) {
			$userManager = new UserManager();
			if (!$userManager->checkExistingUser($email)) {
				$affectedLines = $userManager->signin($email, $prenom, $password, $auth);
				if ($affectedLines) {
					require('Location: index.php?action=account');
				} else {
					throw new Exception("Impossible d'ajouter l'utilisateur");
				}
			} else {
				throw new Exception("Votre email est déjà utilisé par un autre utilisateur !");
			}
		} else {
			throw new Exception("Votre mot de passe est trop court, 5 caracteres minimum.");
		}
	} else {
		throw new Exception("Votre email est trop court, 5 caracteres minimum.");
	}
}

function login($authentifier, $password)
{
	$userManager = new UserManager();
	$userInfo = $userManager->getInfo($authentifier);
	if (password_verify($password, $userInfo['password'])) {
		$_SESSION['id'] = $userInfo['id'];
		$_SESSION['auth'] = $userInfo['auth'];
		header('Location: index.php?action=home');
	} else {
		throw new Exception('email ou mot de passe inconnu');
	}
}

function logout()
{
	session_destroy();
	header('Location: index.php?action=home');
}

function displayAccount($userID)
{
	$userManager = new UserManager();
	$userInfo = $userManager->getInfo($userID);
	if ($userInfo['auth'] == 'admin') {
		$userList = $userManager->getUsers();
	}
	require('views/account-view.php');
}

function displayModifyUser($userID)
{
	$userManager = new UserManager();
	$userInfo = $userManager->getInfo($userID);
	require('views/modify-user.php');
}

function modifyUserInfo($userID, $modifiedID, $prenom, $email, $oldPassword, $password, $confirmation, $auth)
{
	$userManager = new UserManager();
	$userInfo = $userManager->getInfo($userID);
	$modifiedInfo = $userManager->getInfo($modifiedID);

	if ($userInfo['auth'] == 'admin' || $userID == $modifiedID) {
		$affectedLines = $userManager->modifyInfo($modifiedID, $prenom, "prenom");
		if (!$affectedLines) {
			throw new Exception("Erreur lors de l'enregistrement du prenom.");
		}
		$affectedLines = $userManager->modifyInfo($modifiedID, $email, "email");
		if (!$affectedLines) {
			throw new Exception("Erreur lors de l'enregistrement de l'email.");
		}
		if ($auth !== '') {
			$affectedLines = $userManager->modifyInfo($modifiedID, $auth, "auth");
		}
		if (!$affectedLines) {
			throw new Exception("Erreur lors de l'enregistrement de l'autorisation.");
		}
		if ($password !== '' && $oldPassword !== '' && $confirmation !== '') {
			if ($userInfo['auth'] == 'admin' || password_verify($oldPassword, $modifiedInfo['password'])) {
				if ($password == $confirmation) {
					$userManager->modifyPassword($modifiedID, $password);
				} else {
					throw new Exception("Le nouveau mot de passe et la confirmation ne correspondent pas");
				}
			} else {
				throw new Exception("L'ancien mot de passe est faux");
			}
		}
		header('Location: index.php?action=account');
	} else {
		throw new Exception("Vous n'avez pas l'authorisation de modifier ces informations.");
	}
}

function deleteUser($userID, $deletedUser)
{
	$userManager = new UserManager();
	$userInfo = $userManager->getInfo($userID);

	if ($userInfo['auth'] = 'admin' || $userID == $deletedUser) {
		$affectedLines = $userManager->deleteUser($deletedUser);
		if ($affectedLines) {
			if ($userID == $deletedUser) {
				unset($_SESSION['id']);
				unset($_SESSION['auth']);
				header('Location: index.php?action=home');
			} else {
				header('Location: index.php?action=account');
			}
		} else {
			throw new Exception("Impossible de supprimer l'utilisateur");
		}
	} else {
		header('Location: unauthorized.php');
	}
}
