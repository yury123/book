<?php
class class_BookRequest_AuthorRequest 
extends class_BookRequest_AbstractBookRequest{
	protected $list;
	protected $pdo;
	
	function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}
	function doRequest($arg){
		$query = parent::$query." WHERE author = '$arg'";
		parent::makeRequest($query);
	}
}
?>