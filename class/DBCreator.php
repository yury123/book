<?php
class class_DBCreator{
	private $pdo;

	function __construct(){
		$host 	 = class_Registry::getValue('host');
		$db_name = class_Registry::getValue('db_name');
		$charset = class_Registry::getValue('charset');
		$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
		
		$user = class_Registry::getValue('db_user');
		$pass = class_Registry::getValue('db_pass');
		$opt = array(
						PDO::ATTR_ERRMODE =>			PDO::ERRMODE_SILENT,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
						);
		try{
			$this->pdo =new PDO($dsn, $user, $pass, $opt);
		}
		catch(Exception $e){
			 echo $e->getMessage();
			die("Ошибка подключения к базе данных");
		}
	}
	function getDatabase(){
		return $this->pdo;
	}
}
?>