<?php

require_once('Manager.php');

/**
 *
 */
class OtherManager extends Manager
{
	private $db;

	function __construct()
	{
		$this->db = $this->dbConnect();
	}

	function getPlace($placeID)
	{
		$req = $this->db->prepare('SELECT * FROM Lieux WHERE id = ?');

		$req->execute([$placeID]);

		return $req->fetch();
	}

	function getPlaces()
	{
		$places = $this->db->query('SELECT * FROM Lieux');

		return $places;
	}

	function getSellingPlaces()
	{
		$places = $this->db->query('SELECT * FROM lieux_achat');

		return $places;
	}

	function getSocialWorkers()
	{
		$req = $this->db->query('SELECT * FROM travailleurs_sociaux');

		return $req;
	}

	function addPlace($placeName, $placeNameShort)
	{
		$req = $this->db->prepare('INSERT INTO Lieux(nom, nom_reduit) VALUES(?, ?)');
		$affectedLines = $req->execute([$placeName, $placeNameShort]);


		if ($affectedLines) {
			return ($this->db->lastInsertId());
		} else {
			return ($affectedLines);
		}
	}
}
