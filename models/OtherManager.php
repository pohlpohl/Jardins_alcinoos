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

	function getSocialWorkers()
	{
		$req = $this->db->query('SELECT * FROM travailleurs_sociaux');

		return $req;
	}
}
