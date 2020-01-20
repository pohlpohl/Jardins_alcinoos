<?php

class Manager
{
	protected static $instance;
	protected function dbConnect()
	{
		if (empty(self::$instance)) {
			self::$instance = new \PDO('mysql:host=localhost;dbname=jardin_alcinoos', 'root', 'root');
		}
		return self::$instance;
	}
}
