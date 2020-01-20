<?php

require_once('Manager.php');

/**
 *
 */
class ClientsManager extends Manager
{
	private $db;

	function __construct()
	{
		$this->db = $this->dbConnect();
	}

	public function getInfo($id)
	{ // Gets all info on client from id
		if ((int) $id > 0) {
			$req = $this->db->prepare('SELECT clients.*, Lieux.nom as nom_lieu, ts.nom_prenom as ts_nom, ts.id as ts_id FROM clients, Lieux, travailleurs_sociaux as ts WHERE clients.id = ? AND clients.lieu = Lieux.id AND clients.travailleur_social = ts.id AND actif = TRUE ORDER BY nom_prenom');
			$req->execute([$id]);
			$response = $req->fetch();

			return $response;
		}
		return 0;
	}

	public function getClients()
	{
		$req = $this->db->query('SELECT clients.*, Lieux.nom as nom_lieu, ts.nom_prenom as ts_nom, ts.id as ts_id FROM clients, Lieux, travailleurs_sociaux as ts WHERE clients.lieu = Lieux.id AND clients.travailleur_social = ts.id AND actif = TRUE ORDER BY nom_prenom');
		return($req);
	}

	public function getClientsFromPlace($place)
	{
		$req = $this->db->prepare('SELECT clients.*, Lieux.nom as nom_lieu, ts.nom_prenom as ts_nom, ts.id as ts_id FROM clients, Lieux, travailleurs_sociaux as ts WHERE clients.lieu = Lieux.id AND clients.travailleur_social = ts.id AND lieu = ? AND actif = TRUE ORDER BY nom_prenom');
		$req->execute([$place]);
		return($req);
	}

	public function clientCountPlace($place)
	{
		$req = $this->db->prepare('SELECT COUNT(id) as clientCount FROM clients WHERE lieu = ? AND actif = TRUE');
		$req->execute([$place]);
		$count = $req->fetch();
		return $count['clientCount'];
	}

	public function addClient($name, $pseudo, $place, $phone, $nbAdults, $nbChildren, $nbBabies, $socWorker)
	{
		$req = $this->db->prepare('INSERT INTO clients(nom_prenom, pseudo, lieu, telephone, nbr_adultes, nbr_enfants, nbr_bebe, travailleur_social) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
		$affectedLines = $req->execute([(string)$name, (string)$pseudo, $place, (string)$phone, $nbAdults, $nbChildren, $nbBabies, $socWorker]);

		return $affectedLines;
	}

	public function creditorClients()
	{
		$req = $this->db->query('SELECT
									clients.*, travailleurs_sociaux.nom_prenom as ts_nom, travailleurs_sociaux.telephone as ts_tel, travailleurs_sociaux.email as ts_email
								FROM
									clients, travailleurs_sociaux
								WHERE
									balance > 0 AND clients.travailleur_social = travailleurs_sociaux.id
								ORDER BY
									nom_prenom');
		return $req;
	}
	
	public function debtorClients()
	{
		$req = $this->db->query('SELECT
									clients.*, travailleurs_sociaux.nom_prenom as ts_nom, travailleurs_sociaux.telephone as ts_tel, travailleurs_sociaux.email as ts_email
								FROM
									clients, travailleurs_sociaux
								WHERE
									balance < 0 AND clients.travailleur_social = travailleurs_sociaux.id
								ORDER BY
									nom_prenom');
		return $req;
	}

	public function absentClients()
	{
		$req = $this->db->query('SELECT
									t1.date_achat as dernier_achat,
									clients.*, travailleurs_sociaux.nom_prenom as ts_nom, travailleurs_sociaux.telephone as ts_tel, travailleurs_sociaux.email as ts_email
								FROM
									achats t1,
									clients,
									travailleurs_sociaux
								WHERE
									clients.id = t1.client AND clients.travailleur_social = travailleurs_sociaux.id AND t1.date_achat =(
									SELECT
										MAX(t2.date_achat)
									FROM
										achats t2
									WHERE
										t2.client = t1.client
								) AND t1.date_achat <= DATE_SUB(NOW(), INTERVAL 1 MONTH)');
		return $req;
	}
}
