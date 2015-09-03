<?php
/*
Страница отображения информации о выбранной книге
*/
require_once("autoload.php");

$bookViewer = new class_BookViewer();
if($bookViewer->getReady()){
	$bookViewer->findBook();
	}
$errors = join($bookViewer->getErrors(), "<br>\r\n");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	
</head>
<body>
	<a href="http://<?php echo $_SERVER['HTTP_HOST']?>">На главную</a>
		<div id="book" >
			<div id="bookImage">
				<img id="cover" src = "" alt = "Обложка книги">
				<div id="prop">
					<ul id="list">
						<li><b>Автор: <?php echo $bookViewer->getBook("Author");?> </b> </li>
						<li><b>Жанр:  <?php echo $bookViewer->getBook("Genre");?> </b> </li>
						<li><b>Цена:  <?php echo $bookViewer->getBook("Price");?> </b> </li>
					</ul> 
					
				</div>
				<button id="buyButton">Заказать книгу</button>
			</div>
			<div id="bookDescription">
				<h2><?php echo $bookViewer->getBook("Title");?></h2>
				<p><?php echo $bookViewer->getBook("Description");	?></p>
			</div>
		</div>
		<div id="bulletinBoard"><?php echo $errors ?></div>
</body>
<script>
	var button = document.getElementById("buyButton");
	button.onclick = function(){location.href = "/make_order.php?<?php echo $_SERVER["QUERY_STRING"]?>";}
</script>
</html>