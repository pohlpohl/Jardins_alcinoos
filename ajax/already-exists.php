<?php

require('../models/UserManager.php');

$userManager = new UserManager();

// return table
// 0 -> can't read
// 1 -> no match, everything's good
// 2 -> pseudo already exists
// 3 -> email already exists
// 4 -> pseudo and email already exist

if (isset($_POST['pseudo']) && isset($_POST['email'])) {
	$pseudoExists = $userManager->alreadyExisting(0, $_POST['pseudo'], "pseudo");
	$emailExists = $userManager->alreadyExisting(0, $_POST['email'], "email");
	if ($pseudoExists && $emailExists) {
		echo 4;
	} elseif ($emailExists) {
		echo 3;
	} else if ($pseudoExists) { 
		echo 2;
	} else {
		echo 1;
	}
} else if (isset($_POST['email'])) {
	$emailExists = $userManager->alreadyExisting(0, $_POST['email'], "email");
	if ($emailExists) {
		echo 3;
	} else {
		echo 1;
	}
} else if (isset($_POST['pseudo'])) {
	$pseudoExists = $userManager->alreadyExisting(0, $_POST['pseudo'], "pseudo");
	if ($pseudoExists) {
		echo 2;
	} else {
		echo 1;
	}
} else {
	echo 0;
}
