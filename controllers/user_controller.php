<?php

require_once('models/autoload.php');

function signin($email, $prenom, $password)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		if (strlen($password) > 5) {
			$userManager = new UserManager();
			if (!$userManager->checkExistingUser($email)) {
				$affectedLines = $userManager->signin($email, $prenom, $password);

				if ($affectedLines) {
					login($email, $password);
				} else {
					throw new Exception("Impossible d'ajouter l'utilisateur");
				}
			} else {
				throw new Exception("Votre email est déjà utilisé par un autre utilisateur !");
			}
		} else {
			throw new Exception("Votre mot de passe est invalide");
		}
	} else {
		throw new Exception("Votre email est invalide");
	}
}

function login($authentifier, $password)
{
	$userManager = new UserManager();
	$userInfo = $userManager->getInfo($authentifier);
	if (password_verify($password, $userInfo['password'])) {
		$_SESSION['id'] = $userInfo['id'];
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

function modifyPassword($userID, $oldPassword, $newPassword, $confirm)
{
	$userManager = new UserManager();
	$userInfo = $userManager->getInfo($userID);

	if (!password_verify($oldPassword, $userInfo['password'])) {
		throw new Exception("L'ancien mot de passe est invalide.");
	} else if (strlen($newPassword) < 5) {
		throw new Exception("Le nouveau mot de passe est trop court, 5 caractères minimum.");
	} else if ($newPassword !== $confirm) {
		throw new Exception("La confirmation ne correspond pas.");
	} else {
		$affectedLines = $userManager->modifyPassword($userID, $newPassword);
	}

	if ($affectedLines) {
		header('Location: index.php?action=account');
	} else {
		throw new Exception("Impossible de modifier le mot de passe");
	}
}

function deleteUser($userID, $deletedUser)
{
	$userManager = new UserManager();
	$userInfo = $userManager->getInfo($userID);

	if ($userInfo['is_admin']) {
		$affectedLines = $userManager->deleteUser($deletedUser);
		if ($affectedLines) {
			header('Location: index.php?action=account');
		} else {
			throw new Exception("Impossible de supprimer l'utilisateur");
		}
	} else {
		header('Location: unauthorized.php');
	}
}
