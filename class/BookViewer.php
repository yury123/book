<?php
/*
Класс для отображения информации о выбранной книге.
*/
class class_BookViewer{
	protected $readyState=false;
	private $errors = array();
	private $pdo;
	private $id;
	private $book;
	
	function __construct(){
		$err = &$this->errors;
		if(!$_GET['id']){
			$err[]="Не указан id";
			return;
		}
		$this->id = $_GET['id'];
		
		if(!is_numeric($this->id)){
			$err[]="Некорректный id";
			return;
		}
		
		$this->pdo = class_Registry::getDB();
		if(!$this->pdo || !is_a($this->pdo, "PDO")){
			$err[] = "Нет доступа к базе данных";
			return;
		}
		$this->readyState = true;//Проверки пройдены
	}
	function findBook(){
		$id = $this->id;

		$query = class_BookRequest_AbstractBookRequest::$query . " WHERE books.book_id = '$id'";
		$result = $this->pdo->query($query);			
		if (!$result){
			$errInfo =  $this->pdo->errorInfo();
			$this->errors[]=$errInfo[2];
			return false;
		}

		$book = $result->fetch();
		if(count($book) == 1 && $book[0] == '') {
			$book = "Запрошенная книга не найдена.";
		}
		$this->book = $book;
		
		return true;
	}
	
	function getBook($field=""){
		if(!$field) {
			return $this->book;
		}
		return $this->book[$field];
	}
	
	function getReady(){	
		return $this->readyState;
	}
	
	function getErrors(){
		return $this->errors;
	}
}
?>