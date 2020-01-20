<?php

use PaulOhl\Jardins\UserManager;

require('../models/UserManager.php');

$userManager = new UserManager();

// 0 -> Can't read data
// 1 -> success, user exists and password is right
// 2 -> user doesn't exist
// 3 -> password is wrong

if (isset($_POST['authentifier']) && isset($_POST['password'])) {
	$userInfo = $userManager->getInfo($_POST['authentifier']);

	if (!$userInfo) {
		echo 2;
	} else if (password_verify($_POST['password'], $userInfo['password'])) {
		echo 1;
	} else {
		echo 3;
	}
} else {
	echo 0;
}
