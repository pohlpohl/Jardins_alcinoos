<?php

require_once('Manager.php');

/**
 *
 */
class AchatManager extends Manager
{
	private $db;

	function __construct()
	{
		$this->db = $this->dbConnect();
	}

	function getInfo($id)
	{
		$achats = $this->db->prepare('SELECT achats.*, DATE_FORMAT(achats.date_achat, "%d/%m/%Y") as date_fr FROM achats WHERE id = ?');
		$achats->execute([$id]);

		return $achats->fetch();
	}

	function getAchats()
	{
		$achats = $this->db->query('SELECT achats.*, clients.nom_prenom as client_name, DATE_FORMAT(achats.date_achat, "%d/%m/%Y") as date_fr FROM achats, clients WHERE achats.client = clients.id');

		return $achats;
	}

	function getSumAchats()
	{
		$achats = $this->db->query('SELECT SUM(prix) as prix, SUM(montant) as montant, SUM(montant_chq_service) as montant_chq, COUNT(client) as clients FROM achats');

		return $achats->fetch();
	}

	function recordAchat($clientSelected, $dateAchat, $place, $marchandisesType, $prix, $montant, $montantChq)
	{
		$req = $this->db->prepare('INSERT INTO achats(client, date_achat, lieu, type_marchandises, prix, montant, montant_chq_service) VALUES(?, ?, ?, ?, ?, ?, ?)');
		$affectedLines = $req->execute([$clientSelected, $dateAchat, $place, $marchandisesType, $prix, $montant, $montantChq]);
		
		if (!$affectedLines) {
			return $affectedLines;
		}
		$req = $this->db->prepare('UPDATE clients SET `balance` = `balance` + ? WHERE id = ?');
		$affectedLines = $req->execute([($montant - $prix), $clientSelected]);
		return $affectedLines;
	}

	function exportCsv()
	{
		$req = $this->db->prepare("SELECT WEEKDAY(date_achat) as jour_semaine, date_achat, SUM(prix) as ca, SUM(montant_chq_service) as chq
									FROM achats 
									GROUP BY date_achat
									ORDER BY date_achat");

		$req->execute();

		return $req;
	}

	function sumWeekSales($date)
	{
		$req = $this->db->prepare('SELECT WEEKDAY(date_achat) as week_day, SUM(`prix`) as ca, SUM(`montant_chq_service`) as chqs, COUNT(id) as nbr_clients
										FROM `achats`
										WHERE WEEK(date_achat - INTERVAL 1 DAY) = WEEK(CURRENT_DATE - INTERVAL 1 DAY) AND YEAR(date_achat) = YEAR(CURRENT_DATE)
										GROUP BY date_achat');

		$req->execute([$date, $date]);
		return $req->fetchAll();
	}

	function avgWeekSales($date)
	{
		$req = $this->db->prepare('SELECT WEEKDAY(date_achat) as week_day, AVG(`prix`) as ca, AVG(`montant_chq_service`) as chqs, COUNT(id) as nbr_clients
									FROM `achats`
									WHERE WEEK(date_achat - INTERVAL 1 DAY) = WEEK(CURRENT_DATE - INTERVAL 1 DAY) AND YEAR(date_achat) = YEAR(CURRENT_DATE)
									GROUP BY date_achat');
		
		$req->execute([$date, $date]);
		return $req->fetchAll();
	}

	function getListeAchats($date)
	{
		$req = $this->db->prepare('SELECT achats.*, clients.nom_prenom as client_name, DATE_FORMAT(achats.date_achat, "%d/%m/%Y") as date_fr FROM achats, clients WHERE achats.client = clients.id AND achats.date_achat = ?');

		$req->execute([$date]);
		return ($req);
	}
	
	function getDaySums($date)
	{
		$req = $this->db->prepare('SELECT SUM(prix) as prix, SUM(montant) as montant, SUM(montant_chq_service) as montant_chq, COUNT(client) as clients FROM achats WHERE achats.date_achat = ?');
		
		$req->execute([$date]);
		return ($req->fetch());
	}

	function deleteAchat($ID)
	{
		$req = $this->db->prepare('DELETE FROM achats WHERE id = ?');

		$affectedLines = $req->execute([$ID]);

		return $affectedLines;
	}
}
