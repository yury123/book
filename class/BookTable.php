<?php
/*
Класс получает массив книг, обрабатывает его и преобразует в html стрроку. Используется в class_Catalog
*/
class class_BookTable{
	private $books;
	private $html_block;
	
	function __construct($books){
		$this->books = $books;
	}
	function makeTable(){
		$books = $this->books;
		$html_block = '<table id="catalog" class="catalog">';
		//------Шапка таблицы----------
		$head = '<tr class = "catalogHeader">';
		$head.= "<td>№</td>";
		$head.= "<td>Название</td>";
		$head.= "<td>Автор</td>";
		$head.= "<td>Жанр</td>";
		$head.= "<td>Цена</td>";
		$head.="</tr>";
		$html_block.=$head;
		//-----------------------------
		$counter = 1;
		if (!is_array($books)) return "<div style=\"text-align:center;\" ><br>По вашему запросу ничего не найдено</div>";
		foreach($books as $key => $val){
			$row = '<tr class = "catalogRow" id ="catalogRow_'.$key.'">';
				$row.= '<td class = "catalog_numRow">';
					$row.=$counter . "</td>";
				$row.= '<td class = "catalog_id" style="display:none;" data-field="id">';
					$row.=$key . "</td>";
				$row.= '<td class = "catalog_title" data-field="Title">';
					$row.= $books[$key]['Title'] . "</td>";
				$row.= '<td class = "catalog_author" data-field="Author">';
					if (gettype($books[$key]['Author'])== "array"){
						$row.= join($books[$key]['Author'], ", ") . "</td>";
						}
					else{ $row.= $books[$key]['Author'] . "</td>";}
				$row.= '<td class = "catalog_genre" data-field="Genre">';
					if (gettype($books[$key]['Genre'])== "array"){
						$row.= join($books[$key]['Genre'], ", ") . "</td>";
						}
					else{ $row.= $books[$key]['Genre'] . "</td>";}
				$row.= '<td class = "catalog_price" data-field="Price">';
					$row.= $books[$key]['Price'] . "</td>";
			$row.= '</tr>';
			$html_block.=$row;
			$counter++;
		}
		$html_block.="</table>";
		return $html_block;
	}
}
?>