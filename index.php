<?php
require_once("autoload.php");

if($_GET['Author']){
	$catalog =new class_Catalog("Author", $_GET['Author']);
}
elseif($_GET['Genre']){
	$catalog =new class_Catalog("Genre", $_GET['Genre']);
}
else {$catalog =new class_Catalog("");}

$lists = $catalog->getHTMLList();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	
</head>
<body>
	<h2 id ="advert">Двойной клик на строке чтобы посмотреть детали</h2>
	<div id="forAlignment">	
		<div id="forAlignmentInner">
			<span>Из списков можно выбрать фильтр для записей.</span><br>
			<span id="Lists">
				<?php 
				echo $lists[0];
				echo $lists[1];
				?>
			</span>
			<button id="listReset">Сбросить фильтр</button>
			<?php echo $catalog->getTable();?>
		</div>
	</div> <!--конец  forAlignment-->
<div id="bulletinBoard"></div>
<script>
	var table = document.getElementById("catalog");
//--------------Выпадающие списки-------------- /
	var selectAuthor = document.getElementById("selectAuthor");
	var selectGenre = document.getElementById("selectGenre");
	
	selectAuthor.addEventListener("change",reload);
	selectGenre.addEventListener("change",reload);
	
	function reload(e){
		var url = <?php echo "'{$_SERVER['PHP_SELF']}';\r\n"?>
		var request = '';
		if(e.target.value != "Все авторы" && e.target.value != "Все жанры" ){
			if(e.target.id == "selectAuthor"){request+="?Author=";}
			if(e.target.id == "selectGenre") {request+="?Genre=" ;}
			request+= e.target.value;
		}
		var link = url + request;
		location.href = link;
	}
//--------	Сбросить фильтр --------
	var listReste = document.getElementById("listReset");
	listReset.addEventListener('click', resetList);
	function resetList(e){
		var selectAuthor = document.getElementById("selectAuthor").selectedOptions[0].textContent;
		var selectGenre = document.getElementById("selectGenre").selectedOptions[0].textContent;
		if((selectAuthor != "Все авторы") || (selectGenre != "Все жанры" )){
			location.href = "<? echo $_SERVER['PHP_SELF'];?>";
		}
	}
//----------------		
		table.addEventListener("mouseover", rowHover);
		table.addEventListener("mouseout", rowOut);
		
		function  rowHover($e){
			target = $e.target;
			while(target!=this){				
				target = target.parentElement;
				if(target.tagName == "TR"){
					target.classList.add("hoverRow");
					table.hovered = target;
					return false;
				}
			}
		}
		function  rowOut($e){
			target = $e.target;
			while(target!=this){				
				target = target.parentElement;
				if(target.tagName == "TR" ){
					target.classList.remove("hoverRow");
					return false;
				}
			}
		}
//------------Переход на страницу с дополнительной информацией----------
	var table = document.getElementById("catalog");
	table.addEventListener("dblclick", getRowData)
		
	function getRowData(e){
		while(target!=this){				
			if(target.tagName == "TR"){
				
				var url = <?php echo "'{$_SERVER['HOST']}/';\r\n"?>
				url+="full_view.php";
				var request = '?id=';
				id = target.getElementsByClassName("catalog_id")[0].innerHTML;
				var link = url + request + id;
				location.href = link;
			}
			target = target.parentElement;
		}
	}
</script>
</body>
</html>