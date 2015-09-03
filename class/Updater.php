<?php
class class_Updater{
	protected $pdo; //БД
	protected $feedback;//ошибки
	protected $id;
	protected $fields;
	
	protected function getFieldId($fieldName){
		$fields=$this->fields;
		$ucField=ucfirst($fieldName);
		if(!$fields[$ucField]){return;}

		$table=$fieldName."s";
		$field=$fieldName."_id";
		$pdo = $this->pdo;
		
		$values = explode(',',$fields[$ucField]);
		foreach ($values as $val){// Если жанров или авторов несколько - повтор операции для каждого
			$val = trim($val);
			$stmt = $pdo->query("SELECT $field FROM $table WHERE $fieldName='$val'");
			$this->checkError();
			$res = $stmt->fetch();
			if($res[$field]){//поле найдено, 
				$fields_id[] = $res[$field];
			}
			else{ //поле не найдено, создается новое
				$pdo->query("INSERT INTO $table ($fieldName) VALUES ('$val')");
				$this->checkError();
				$fields_id[] = $pdo->lastInsertId();
			}
		}
		return $fields_id;
	}
		
	protected function checkRows(){
		$fields = $this->fields;
		if($fields['Price']&& !is_numeric($fields['Price'])){
			$this->feedback[]="Цена на книгу должна быть числом. Значение установлено в 0.";
			$fields['Price'] = 0;
		}
		if(!preg_match("/^[А-Яа-я,. \w]*$/u", $fields['Title'])){
			$this->feedback[]="Заголовок книги содержит недопустимые символы. Значение пропущено";
			$fields['Title']='';
		}
		if(!preg_match("/^[А-Яа-я,. \w]*$/u", $fields['Description'])){
			$this->feedback[]="Описание книги содержит недопустимые символы. Значение пропущено";
			$fields['Description'] = '';
		}
		if(!preg_match("/^[А-Яа-я,. \w]*$/u", $fields['Author'])){
			$this->feedback[]="Имя автора содержит недопустимые символы. Значение пропущено";
			$fields['Author'] = '';
		}
		if(!preg_match("/^[А-Яа-я,. \w]*$/u", $fields['Genre'])){
			$this->feedback[]="Название жанра содержит недопустимые символы. Значение пропущено";
			$fields['Genre'] = '';
		}
		return $fields;
	}
	protected function checkError(){
		$err = $this->pdo->errorInfo();
		if($err[0] != 0){
			$this->feedback[] = $err[2];
			return true;
		}
	}
}
?>