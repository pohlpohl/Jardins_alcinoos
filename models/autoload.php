<?php

spl_autoload_register(function ($className) {
	$parts = explode('\\', $className);
	require_once end($parts) . '.php';
});
