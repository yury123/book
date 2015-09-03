<?php
class class_BookUpdater extends class_Updater{
	protected $fields;
	protected $pdo;
	protected $id;
	protected $feedback;
	
	function __construct(PDO $pdo,/*array*/ $fields){
		if(!fields){
			$this->feedback[]="Не заполнены поля формы.";
			return;
			}
		$this->pdo = $pdo;
		if((gettype($fields)!="array") || !is_numeric($fields['id'])){
			$this->feedback[]="Неверные входящие данные в class_BookUpdater.";
			return;
		}
		$this->fields =$fields;
		$this->id = $fields['id'];
	}
	function update(){
		if($this->feedback) {return $this->feedback;}//Критические ошибки
		$fields = $this->fields;
		$checkedFields = $this->checkRows();//значения $this->fields; могут быть изменены в $this->checkRows();
		if($this->fields['Title'] || $this->fields['Price'] || $this->fields['Desacription']){
			$this->changeBook();
		}
		//-------------
		if($checkedFields['Author']==$fields['Author']){//Значение не было изменено при проверке
			$this->changeField('author');
		}
		if($checkedFields['Genre']==$fields['Genre']){
			$this->changeField('genre');
		}
		//-------------
		$checkedFields['err'] = $this->feedback;
		$checkedFields['action'] = "edit";
		return $checkedFields;
	}
	private function changeBook(){
		$pdo = $this->pdo;
		$id	= $this->id;
		$fields = $this->fields;
		$req = array();		
			
		if($fields['Title']!="") 		{$req[]="Title = '{$fields['Title']}'";}
		if($fields['Price']!='') 		{$req[]="Price = '{$fields['Price']}'";}
		if($fields['Description']!='')  {$req[]="Description = '{$fields['Description']}'";}
		$req = join($req, ', ');

		$query = "UPDATE books SET $req WHERE book_id='$id'";
		$res=$pdo->query($query);
		$this->checkError();
	}
	
	private function changeField($field){
		$fields_id = $this->getFieldId($field);
		$field_id=$field."_id";
		$fields_books = $field."s_books";
		$query = "SELECT id FROM $fields_books WHERE book_id = $this->id";
		
		$stmt = $this->pdo->query($query);
		$books_id = $stmt->fetchAll(PDO::FETCH_COLUMN);
		if (count($books_id)< count($fields_id)){//Авторов было указано боольше, чем есть записей для данного book_id
			$diff =  count($fields_id) - count($books_id);
			for($i=0;$i<$diff;$i++){//для каждой вставленной строки получаем id
				$query = "INSERT INTO $fields_books (book_id) VALUES ('$this->id')";
				$stmt = $this->pdo->query($query);
				$this->checkError();
				$books_id[] = $this->pdo->lastInsertId();
			}
		}
		elseif(count($books_id) > count($fields_id)){//Количество авторов уменьшилось и стало меньше количества записей	для book_id	
			$diff =  count($books_id) - count($fields_id);
			
			$query = "DELETE FROM $fields_books WHERE book_id ='$this->id' LIMIT $diff";
			$stmt = $this->pdo->query($query);
			$this->checkError();
			for($i=0;$i<$diff;$i++){array_shift($books_id);}
		}
		foreach ($books_id as $k=>$v){				
			$query = "UPDATE $fields_books SET $field_id = '$fields_id[$k]' WHERE id='$v'";
			$stmt = $this->pdo->query($query);
			$res = $stmt->fetchAll();
		}
	}
}
?>