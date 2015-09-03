<?php
abstract class class_BookRequest_AbstractBookRequest{
	protected $list;
	protected $pdo;
	static $query = "SELECT books.book_id, Author, Title,  Genre, Price 
							   FROM books				
									LEFT JOIN authors_books ON authors_books.book_id = books.book_id
									LEFT JOIN authors ON authors.author_id = authors_books.author_id
									LEFT JOIN genres_books ON genres_books.book_id = books.book_id
									LEFT JOIN genres ON genres.genre_id = genres_books.genre_id";
	
	abstract function __construct(PDO $pdo);
	abstract function doRequest($arg);
	
	function getList(){
		return $this->list;
	}
	protected function checkPDO($stmt,$pdo){
		if (!$stmt){
		$errInfo = $pdo->errorInfo();
		die($errInfo[2]);
		}
	}
	function makeRequest($query){
		$pdo = $this->pdo;
		
		$stmt = $pdo->query($query);
		$this->checkPDO($stmt,$pdo);
		$res = $stmt->fetchAll();
		foreach($res as $k=>$v){
			$id = $res[$k]['book_id'];
			$books[$id]['Title']=$res[$k]['Title'];
			$books[$id]['Price']=$res[$k]['Price'];
			if(!is_array($books[$id]['Author']) || !in_array($res[$k]['Author'],$books[$id]['Author'])){
				$books[$id]['Author'][]=$res[$k]['Author'];
			}
			if(!is_array($books[$id]['Genre']) || !in_array($res[$k]['Genre'],$books[$id]['Genre'])){
				$books[$id]['Genre'][]=$res[$k]['Genre'];
			}
		}
		if(!$books){ $books = "В базе данных ничего не найдено";}
		$this->list = $books;
	}
	
}
?>