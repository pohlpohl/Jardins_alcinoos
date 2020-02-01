<?php

require_once('models/autoload.php');

function home()
{
	if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
		$clientsManager = new ClientsManager();
		$creditors = $clientsManager->creditorClients();
		$debtors = $clientsManager->debtorClients();
		$absents = $clientsManager->absentClients();
		require('views/tableau-de-bord.php');
	} else {
		require('views/unsigned-view.php');
	}
}

function isInPlaceList($placeID, $placeList)
{
	foreach ($placeList as $data) {
		if ($data['id'] == $placeID) {
			return [true, $data['name']];
		}
	}
	return [false, null];
}

function achatsDisplay($placeSelected)
{
	if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
		$otherManager = new OtherManager();
		$clientsManager = new ClientsManager();
		$placeList = $otherManager->getSellingPlaces()->fetchAll();
		$clientsList = $clientsManager->getClients();

		if ($placeSelected != 0 && isInPlaceList($placeSelected, $placeList)[0]) {
			require('views/achats.php');
		} else {
			require('views/select-place.php');
		}
	} else {
		require('views/unsigned-view.php');
	}
}

function recordAchat($post)
{
	$achatManager = new AchatManager();

	$marchandisesType = 0;
	$marchandisesType += (isset($post['hygiene'])) ? 8 : 0;
	$marchandisesType += (isset($post['frais'])) ? 4 : 0;
	$marchandisesType += (isset($post['sec'])) ? 2 : 0;
	$marchandisesType += (isset($post['fruits-legumes'])) ? 1 : 0;

	if ($post['client-selected'] == 0 || $post['date-achat'] == '') {
		throw new Exception("Erreur dans la saisie des données, activez Javascript pour plus d'informations");
	}
	$affectedLines = $achatManager->recordAchat(htmlspecialchars($post['client-selected']), htmlspecialchars($post['date-achat']), htmlspecialchars($post['place']), $marchandisesType, htmlspecialchars($post['prix']), htmlspecialchars($post['montant']), htmlspecialchars($post['montant-chq']));
	if ($affectedLines) {
		header('Location: index.php?action=achats-display');
	} else {
		throw new Exception("Error Processing Request");
	}
}

function newClientDisplay()
{
	$otherManager = new OtherManager();
	$placeList = $otherManager->getPlaces()->fetchAll();
	$socialWorkers = $otherManager->getSocialWorkers()->fetchAll();

	require('views/new-client-display.php');
}

function addClient($firstName, $lastName, $placeID, $phone, $nbAdults, $nbChildren, $nbBabies, $socWorker)
{
	$clientsManager = new ClientsManager();
	$otherManager = new OtherManager();

	$name = strtoupper($lastName) . " " . ucfirst(strtolower($firstName));
	$clientsCount = $clientsManager->clientCountPlace($placeID);
	$placeName = $otherManager->getPlace($placeID)['nom_reduit'];
	$pseudo = sprintf("%s_%03d", strtoupper($placeName), $clientsCount + 1);
	$affectedLines = $clientsManager->addClient($name, $pseudo, $placeID, $phone, $nbAdults, $nbChildren, $nbBabies, $socWorker);

	if ($affectedLines) {
		header('Location: index.php?action=achats-display');
	} else {
		throw new Exception("Error Processing Request");
	}
}

function addPlace($placeName, $placeNameShort)
{
	$otherManager = new OtherManager();

	$newPlaceID = $otherManager->addPlace($placeName, strtoupper($placeNameShort));
	if (!$newPlaceID) {
		throw new Exception("Error Processing Request");
	} else {
		return ($newPlaceID);
	}
}

function exportCsv()
{
	$achatManager = new AchatManager();

	$listeAchats = $achatManager->exportCsv();
	require('ajax/export-csv.php');
}

function listeClientsDisplay($mode, $id)
{
	$clientsManager = new ClientsManager();
	switch ($mode) {
		case 'all':
			$listeClients = $clientsManager->getClients();
			require('views/liste-clients.php');
			break;
		case 'client':
			if ($id <= 0) {
				http_response_code(404);
				include('views/error_404.php');
				die();
			}
			$infos = $clientsManager->getInfo($id);
			require('views/client-account-view.php');
			break;
		case 'ts':
			if ($id <= 0) {
				http_response_code(404);
				include('views/error_404.php');
				die();
			}
			$infos = $clientsManager->getInfo($id);
			require('views/liste-clients.php');
			break;
		case 'place':
			if ($id <= 0) {
				http_response_code(404);
				include('views/error_404.php');
				echo $id . " There.";
				die();
			}
			$listeClients = $clientsManager->getClientsFromPlace($id);
			require('views/liste-clients.php');
			break;
		default:
			http_response_code(404);
			include('views/error_404.php');
			die();
			break;
	}
}

function achatsRecapDisplay($selector)
{
	$achatManager = new AchatManager();

	if ($selector == "all") {
		$listeAchats = $achatManager->getAchats();
		$sums = $achatManager->getSumAchats();
	} else {
		$listeAchats = $achatManager->getListeAchats($selector);
		$sums = $achatManager->getDaySums($selector);
	}


	if ($listeAchats) {
		require('views/achats-recap-display.php');
	} else {
		throw new Exception("Error Processing Request");
	}
}

function modifyAchat($id)
{
	$achatManager = new AchatManager();
	$clientsManager = new ClientsManager();
	$otherManager = new OtherManager();
	
	$placeList = $otherManager->getSellingPlaces()->fetchAll();
	$achatInfo = $achatManager->getInfo($id);
	$clientsList = $clientsManager->getClients();

	require("views/achats.php");
}

function deleteAchat($id, $goBack)
{
	$achatManager = new AchatManager();
	$affectedLines = $achatManager->deleteAchat($id);

	if ($affectedLines)
	{
		header('Location: index.php?action=achats-recap&&select=all');
	} else {
		throw new Exception("Error Processing Request");
	}
}
