<?php
/*
1. Получение таблицы в виде HTML строки.
2. Генерация html выпадающих списков для фильтров
3. Доступ к классам для добавления и изменение записей в БД
*/
class class_Catalog{
	private $books;
	private $pdo;
	private	$html_table;
	//private $feedback;
	
	function __construct($mode='',$arg=''){
		$this->pdo = class_Registry::instance()->getDB();//можно не проверять т.к. если не подключится - DBCreator сгенерирует исключение
		$list = $this->getList($mode,$arg);
		$this->books= $list;
		$catalog = new class_BookTable($list);
		$this->html_table = $catalog->makeTable();
	}
	function getTable(){
		return $this->html_table;
	}
	function getList($mode,$arg){
		$pdo = $this->pdo;
		switch($mode){
			case 'Author': $req =new class_BookRequest_AuthorRequest($pdo);break;
			case 'Genre' : $req =new class_BookRequest_GenreRequest($pdo);break;
			default: $req =new class_BookRequest_DefaultRequest($pdo);
		}
		$req->doRequest($arg);
		return $req->getList();
	}
	//------------------------------------------------------
	//---------Добавление и изменение записи в БД-----------
	function addBook($fields){
		$adder = new class_BookAdder($this->pdo,$fields);
		$ansver = $adder->addBook();
		return $ansver;
	}
	function changeBook($fields){
		$updater = new class_BookUpdater($this->pdo,/*array*/ $fields);
		$ansver = $updater->update(); //
		return $ansver;
	}
	//-------------------------------------
	//---------Получение списков-----------
	function getLists(){
		$pdo = $this->pdo;
		$query_a = "SELECT author FROM authors";
		$query_g = "SELECT genre  FROM genres";
		//-------
		$stmt = $pdo->query($query_a);
		if (!$stmt){
			$errInfo = $pdo->errorInfo();
			die("Ошибка SQL 1");
			}
		while ($row = $stmt->fetch()){
			$authors[] = $row['author'];
			}
		//-------	
		$stmt = $pdo->query($query_g);
		if (!$stmt){
			$errInfo = $pdo->errorInfo();
			die("Ошибка SQL 2");
			}
		while ($row = $stmt->fetch()){
			$genres[] = $row['genre'];
			}
		return array("Authors"=>$authors,"Genres"=> $genres);
	}

	function getHTMLList(){
		$selected_author = false;
		$selected_genre = false;
		
		$arr = $this->getLists();
		$get_arr = $_GET;
		//------------------------------------------
		$str='';
		foreach($arr["Authors"] as $val){
			if($val == $get_arr["Author"] && $get_arr["Author"] !='Все авторы' && $get_arr["Author"]!=''){
				$selected = "selected";
				$selected_author = true;
			}
			else {$selected = ""; }
			$str.= "<option $selected>{$val}</option>";
		}				
		if(!$selected_author){//Ни один из авторов из списка не совпал с запросом $_GET
			$str = "<option selected>Все авторы</option>".$str;//Пункт "Все авторы" добавлен как selected
		}
		else {$str = "<option>Все авторы</option>".$str;}//Пункт "Все авторы" добавлен как обычный пункт
		
		$str = "<select name=\"Authors\" id=\"selectAuthor\">" . $str . "</select>";
		$result[0]= $str;
		//------------------------------------------
		$str='';
		foreach($arr["Genres"] as $val){
			if($val == $get_arr["Genre"] && $get_arr["Genre"] !='Все жанры' && $get_arr["Genre"]!=''){
				$selected = "selected";
				$selected_genre = true;
			}
			else {$selected = "";}
			$str.= "<option $selected>{$val}</option>";
		}
		if(!$selected_genre){//Ни один из жанров из списка не совпал с запросом $_GET
			$str = "<option selected>Все жанры</option>".$str;
		}
		else {$str = "<option>Все жанры</option>".$str;}
		
		$str = "<select name=\"Genres\" id=\"selectGenre\">" . $str . "</select>";	
		$result[1]= $str;
		return $result;
	}
}
?>