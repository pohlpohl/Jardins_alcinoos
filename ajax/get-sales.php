<?php

require('../models/AchatManager.php');

$achatsManager = new AchatManager();

if (isset($_POST['date']))
{
	$result = [[], []];
	$result[0] = $achatsManager->avgWeekSales($_POST['date']);
	$result[1] = $achatsManager->sumWeekSales($_POST['date']);
	$salesJson = json_encode($result);
	echo $salesJson;
}
