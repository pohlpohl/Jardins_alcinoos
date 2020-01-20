<?php

require('../models/ClientsManager.php');

$clientsManager = new ClientsManager();

if (isset($_POST['id']) && $_POST['id'])
{
	$result = $clientsManager->getInfo($_POST['id']);
	// $clients = $result->fetch(PDO::FETCH_ASSOC);
	$clientsJson = json_encode($result);
	echo $clientsJson;
}
