<?php
require_once("../autoload.php");
$catalog =new class_Catalog();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	
</head>
<body>
	<div id="editForm" class="hide">
		<div>
			<h3 id="formTitle">Изменить книгу.</h3>
			<form id="Edit" name="Edit" method="POST" accept-charset="windows-1251">
				<div id="innerDiv">
				<p>Название:</p>
				<input type="text" id="editFormTitle"  name="Title"  autocomplete="off"><br>
				<p>Автор:</p>
				<input type="text" id="editFormAuthor" name="Author" autocomplete="off"><br>
				<p>Жанр:</p>
				<input type="text" id="editFormGenre" name="Genre"  autocomplete="off"><br>
				<p>Цена:</p>
				<input type="text" id="editFormPrice" name="Price"  autocomplete="off"><br>
				<input type="text" id="editFormid"     name="id" style="display:none;">
				</div>
				
				<p>Описание книги:</p>
				<textarea name="Description"></textarea><br>
				<button type="submit" id="EditButton">Изменить</button>
				<input type="text" id="Action" name="Action" value = "Edit" style="display:none">
			</form>
		</div>
	</div>
	<h2 id ="advert">Двойной клик на строке чтобы изменить запись в таблице.</h2>
	<div id="forAlignment">	
	<div id="forAlignmentInner">
	<span id="tabNote">*Клик за пределами формы свернет ее.</span>
	
	<div><button id="addButton">Добавить новую книгу</button></div>
	<?php echo $table = $catalog->getTable(); ?>
	</div>
	</div> <!--конец  -->
<div id="bulletinBoard"></div>
<script>
var table = document.getElementById("catalog");
//----------------		
		table.addEventListener("mouseover", rowHover);
		table.addEventListener("mouseout", rowOut);
		table.addEventListener("dblclick", show)
		
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
//----------------	show/hide BookEdit  ----------------
	//document.editForm = "visible"; - добавляется, когда форма отображается
	var div =  document.getElementById("editForm");
	document.addEventListener("click", hideDiv);
	
	function hideDiv(e){
		var div =  document.getElementById("editForm");
		if(document.editForm != "visible"){return;} //editForm не показан
		target = e.target;
		while(target!=document.body){
			if(target == div){return}//клик на самом editForm
			if(target == document.getElementById("addButton")){return}//клик на кнопке должен показывать форму,а не прятать ее
			target = target.parentElement;
		}
		hideDivFunc()
	}
	function hideDivFunc(){//используется ниже в коде
		div.classList.remove("display");
		div.classList.add("hide");
		div.firstElementChild.style.display = "none";
		document.editForm = "";
	
	}
	function show(e){
		target = e.target;
		while(target!=this){				
			if(target.tagName == "TR"){
				showDivFunc();
				return false;
			}
			target = target.parentElement;
		}
	}
	function showDivFunc(){
		div.classList.remove("hide");
		div.classList.add("display");
		div.firstElementChild.style.display = "";
		document.editForm = "visible";
	}
//------------Заполнение формы----------
	table.addEventListener("dblclick", getRowData)
		
	function getRowData(e){
		while(target!=this){				
			if(target.tagName == "TR"){
				if(target.rowIndex == 0){return}//заголовок таблицы, не интересно
				var div =  document.getElementById('editForm');
				div.loadedIndex = target.rowIndex;
				var form = document.forms.Edit;
				for(var i=0;i<target.cells.length;i++){
					if(target.cells[i].dataset.field){
						var $str = "editForm" + target.cells[i].dataset.field;// атрибут data-field ячейки + 'editForm' = id поля формы.
						form[$str].value = target.cells[i].textContent;
					}
				}
				var title = document.getElementById("formTitle");
				title.textContent="Изменить информацию о книге";
				var button = document.getElementById("EditButton");
				button.innerHTML = "Изменить";
				form['Action'].value = "Edit";
				return false;
			}
			target = target.parentElement;
		}
	}
//-------Добавление книги в каталог------	
var button = document.getElementById("addButton");
button.addEventListener("click", displayAdd)

function displayAdd(){
	var form = document.forms.Edit;
	var div = document.getElementById("editForm");
	var title = document.getElementById("formTitle");
	var button = document.getElementById("EditButton");
	button.innerHTML = "Добавить";
	title.textContent="Добавить новую книгу в каталог";
	form.reset();
	form['Action'].value ="Add_New";
	
	showDivFunc();
	
}
//------------XMLHttpRequest------------

	document.forms.Edit.addEventListener("submit",trySend);
	var xhr = new XMLHttpRequest();
	var bulletinBoard = document.getElementById('bulletinBoard');

	function reactForReadyStateChange(){
		if (xhr.readyState != 4) {return}
		if (xhr.status != 200) {log(xhr.status + ': ' + xhr.statusText);}
		if(xhr.status == 200){
			try{
				var obj = JSON.parse(xhr.responseText);
			}catch (e){
				var obj = '';
				log("Что-то пошло не так")
				log(xhr.responseText);
				hideDivFunc();
				formResrt();
			}
			if(typeof obj['id'] != "undefined") {
				log_clear();
				var div = document.getElementById('editForm');
				div.newRowData = obj;
				switch (obj['action']){
					case "add": 
						log("Данные добавлены в базу");
						changeRow_add();
						if(obj['err']){
							for(var i=0;i<obj['err'].length;i++){
								log(obj['err'][i])
							}
						}
						break;
					case "edit": 
						changeRow();
						if(obj['err']){
							log("Данные обновлены с ошибками:");
							for(var i=0;i<obj['err'].length;i++){
								log(obj['err'][i])
							}
						}
						else {log("Даные в базе обновлены");}
						break;
				}

			}
			
		}
	}	
	function trySend(e){
		e.preventDefault();
		xhr.open('POST', '../change_data.php', true);
		var formData = new FormData(document.forms.Edit);
		xhr.onreadystatechange = reactForReadyStateChange;
		xhr.send(formData);
		
		}
	function log(text){bulletinBoard.innerHTML += text + "<br>";}
	function log_clear(){bulletinBoard.innerHTML = "";}

	function changeRow(){
		var target = document.getElementById('catalog');
		var form = document.forms.Edit;
		var div = document.getElementById('editForm');
			for(var i=0;i<target.rows[div.loadedIndex].cells.length;i++){
				if(target.rows[div.loadedIndex].cells[i].dataset.field){
					//var $str = "editForm" + target.rows[div.loadedIndex].cells[i].dataset.field;// атрибут data-field ячейки + 'editForm' = id поля формы.
					var $str = target.rows[div.loadedIndex].cells[i].dataset.field;
					if(div.newRowData[$str]){
						target.rows[div.loadedIndex].cells[i].textContent = div.newRowData[$str];
					}
				}
			}
		form.reset();
		hideDivFunc();
	}
	function changeRow_add(){
		var target = document.getElementById('catalog');
		var form = document.forms.Edit;
		var div = document.getElementById('editForm');
		var index = target.rows.length;
		var lastRow = (target.rows[index-1]);
		
		newRow = lastRow.cloneNode(true);
		lastRow.parentElement.appendChild(newRow);
		newRow.cells[0].innerHTML++;//Нумерация ячеек
		for(var i=0;i<target.rows[index].cells.length;i++){
			if(target.rows[index].cells[i].dataset.field){
				var $str = target.rows[index].cells[i].dataset.field;
				target.rows[index].cells[i].textContent = div.newRowData[$str];
			}
		}		
		newRow.cells[1].innerHTML=div.newRowData['id'];
		form.reset();
		hideDivFunc();
	}
	function formResrt(){document.forms.Edit.reset();}
</script>
</body>
</html>