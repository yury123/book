<?php 
class class_BookAdder extends class_Updater{
	protected $fields;
	protected $pdo;
	protected $id;
	protected $feedback;
	
	function __construct(PDO $pdo,/*array*/ $fields){
		$this->pdo = $pdo;
		$this->fields = $fields;
		$this->fields = $this->checkRows();
	}
	function addBook(){
		$pdo = $this->pdo;
		$fields = $this->fields;
		
		//-------Поля проверены	
		$authors_id = $this->getFieldId('author');
		$genres_id = $this->getFieldId('genre');
			
		if($fields['Title'] || $fields['Price'] || $fields['Descrption']){
			$query = "INSERT INTO books (Title,Price,Description)
					VALUES('{$fields['Title']}', '{$fields['Price']}', '{$fields['Description']}')";	
			$pdo->query($query);		
			$books_id = $pdo->lastInsertId();	
		}
		//------Заполнение промежуточных таблиц
		if(is_array($authors_id)){
			foreach($authors_id as $val){
				$query = "INSERT INTO authors_books (author_id, book_id) VALUES ('$val', '$books_id')";
				$pdo->query($query);	
				$this->checkError();
			}
		}
		if(is_array($genres_id)){
			foreach($genres_id as $val){
				$query = "INSERT INTO genres_books (genre_id, book_id) VALUES ('$val', '$books_id')";
				$pdo->query($query);	
			}
		}
		$fields['id'] = $books_id;
		$fields['err'] = $this->feedback;
		$fields['action'] = "add";
		return $fields;
	}
}
?>