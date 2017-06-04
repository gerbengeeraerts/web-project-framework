<?php
class DAO {
	private static $dbHost = "localhost";
	private static $dbName = "petrolfest";
	private static $dbUser = "root";
	private static $dbPass = "";
	private static $sharedPDO;

	// private static $dbHost = "localhost";
	// private static $dbName = "vmtest_vmweb";
	// private static $dbUser = "vmtest_vmweb";
	// private static $dbPass = "welcome";
	// private static $sharedPDO;

	protected $pdo;

	function __construct() {

		if($_SERVER['REMOTE_ADDR'] != '::1'){
			self::$dbHost = "gerbengeeraerts.be.mysql";
			self::$dbName = "gerbengeeraerts";
			self::$dbUser = "gerbengeeraerts";
			self::$dbPass = "bLfcvPj7";
			self::$sharedPDO;
		}

		if(empty(self::$sharedPDO)) {
			self::$sharedPDO = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName, self::$dbUser, self::$dbPass);
			self::$sharedPDO->exec("SET CHARACTER SET utf8");
			self::$sharedPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$sharedPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		$this->pdo =& self::$sharedPDO;
	}
}
