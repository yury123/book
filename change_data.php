<?php
require_once("autoload.php");
	
if (!$_REQUEST['Action']){echo "Некорректный запрос";}
$newFields = $_REQUEST;

$catalog =new class_Catalog("");
switch ($newFields['Action']){
	case "Edit": 
		$arr = $catalog->changeBook($newFields);
		if($arr['id']){
			echo json_encode($arr);
			}
		break;
	case "Add_New": 
		$arr = $catalog->addBook($newFields);
		if($arr['id']) {
			echo json_encode($arr);
		}
		break;
	default: echo "Error";
	}
?>