<?php
require_once("autoload.php");
$mail_address = class_Registry::getValue('E-Mail');//E-Mail должен быть указан в config.ini	
$mail_from = class_Registry::getValue('From');
$newFields = $_REQUEST;
	$to = "$mail_address";
	$subj = "Новый заказ";	
	
	$text = "ID книги: " . 			$newFields['id'] . "<br>\r\n";
	$text.= "Имя заказчика: " . 	$newFields['Name'] . "<br>\r\n"; 
	$text.= "Фамилия заказчика: " . $newFields['Surname'] . "<br>\r\n"; 
	$text.= "Адрес: " . 			$newFields['Address'] . "<br>\r\n"; 
	$text.= "E-mail: " . 			$newFields['Mail'] . "<br>\r\n"; 
	$text.= "Телефон: " . 			$newFields['Phone'] . "<br>\r\n"; 
	$text.= "Количество экземпляров: " .	$newFields['Quantity'] . "<br>\r\n"; 
	$text.= "Дополнительные пожелания: " .  $newFields['Description'] . "<br>\r\n"; 
$headers = "Content-type: text/html; charset=UTF-8 \r\n";
$headers .= "From: catalog <$mail_from>\r\n";

$m = mail($to, $subj, $text, $headers);
if($m)echo "mail = OK";
	else echo "mail = FAIL";
?>