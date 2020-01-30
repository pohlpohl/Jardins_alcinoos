<?php

require_once('Manager.php');

/**
 *
 */
class UserManager extends Manager
{
	private $db;

	function __construct()
	{
		$this->db = $this->dbConnect();
	}

	public function getInfo($authentifier)
	{
		if ((int) ($authentifier) > 0) {
			$sql = 'SELECT * FROM utilisateurs WHERE id = ?';
		} else {
			$sql = 'SELECT * FROM utilisateurs WHERE email = ?';
		}

		$req = $this->db->prepare($sql);
		$req->execute([$authentifier]);
		$response = $req->fetch();

		return $response;
	}

	public function getUsers()
	{
		$req = $this->db->query('SELECT * FROM utilisateurs');

		return $req;
	}

	public function checkExistingUser($user)
	{ //finds user by email or pseudo
		$req = $this->db->prepare('SELECT id FROM utilisateurs WHERE email = ?');
		$req->execute(array($user));
		$response = $req->fetch();

		if ($response == null) { // Returns true if user exists, otherwise false
			return false;
		} else {
			return true;
		}
	}

	public function signin($email, $prenom, $password, $auth)
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);

		$req = $this->db->prepare('INSERT INTO utilisateurs(email, prenom, password, auth) VALUES(?, ?, ?, ?)');
		$affectedLines = $req->execute([$email, $prenom, $hash, $auth]);

		return $affectedLines;
	}

	public function alreadyExisting($userID, $authentifier, $type)
	{
		if ($type == "pseudo") {
			$req = $this->db->prepare('SELECT * FROM utilisateurs WHERE id != ? AND pseudo = ?');
		} else if ($type == "email") {
			$req = $this->db->prepare('SELECT * FROM utilisateurs WHERE id != ? AND email = ?');
		} else {
			throw new Exception("Erreur de synthaxe lors de la séléction du type de champs à tester");
		}

		$req->execute([$userID, $authentifier]);
		$response = $req->fetch();

		return ($response == null) ? false : true;
	}

	public function modifyInfo($userID, $modifiedInfo, $type)
	{
		if ($type == "prenom") {
			$req = $this->db->prepare('UPDATE utilisateurs SET prenom = ? WHERE id = ?');
		} else if ($type == "email") {
			$req = $this->db->prepare('UPDATE utilisateurs SET email = ? WHERE id = ?');
		} else if ($type == "password") {
			$req = $this->db->prepare('UPDATE utilisateurs SET password = ? WHERE id = ?');
		} else if ($type == "auth") {
			$req = $this->db->prepare('UPDATE utilisateurs SET auth = ? WHERE id = ?');
		} else {
			throw new Exception("Erreur de synthaxe lors de la séléction du type de champs à modifier");
		}

		$affectedLines = $req->execute([$modifiedInfo, $userID]);
		return $affectedLines;
	}

	public function modifyPassword($userID, $newPassword)
	{
		$hash = password_hash($newPassword, PASSWORD_DEFAULT);

		$affectedLines = $this->modifyInfo($userID, $hash, "password");

		return $affectedLines;
	}

	public function modifyImage($userID, $imageName)
	{
		$req = $this->db->prepare('SELECT profile_pic FROM utilisateurs WHERE id = ?');

		$req->execute([$userID]);

		$oldImageName = $req->fetch();

		$oldImageName = $oldImageName['profile_pic'];

		$req = $this->db->prepare('UPDATE utilisateurs SET profile_pic = ? WHERE id = ?');

		$affectedLines = $req->execute([$imageName, $userID]);

		return ($affectedLines) ? $oldImageName : $affectedLines;
	}

	public function deleteUser($userID)
	{
		$req = $this->db->prepare('DELETE FROM utilisateurs WHERE id = ?');
		$affectedLines = $req->execute([$userID]);
		return $affectedLines;
	}
}
