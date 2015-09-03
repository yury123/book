<?php
$id = $_GET['id'];
if(!is_numeric($id)){
	$id = "";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<a href="index.php">На главную</a>
<div id="editForm">
		<div>
			<h3 id="formTitle">Заказать книгу.</h3>
			<form id="Buy" name="buy" method="POST" action="" accept-charset="windows-1251">
				<div id="innerDiv">
				<p>Имя:</p>
				<input type="text" id="buyFormTitle"  name="Name"  autocomplete="off" required><br>
				<p>Фамилия:</p>
				<input type="text" id="buyFormAuthor" name="Surname" autocomplete="off" required><br>
				<p>Адрес:</p>
				<input type="text" id="buyFormGenre" name="Address"  autocomplete="off" required><br>
				<p>E-mail:</p> 
				<input type="email" id="buyFormPrice" name="Mail"  autocomplete="off" required><br>
				<p>Телефон:</p>
				<input type="tel" id="buyFormPrice" name="Phone"  autocomplete="off" required><br>
				<p>Количество экземпляров:</p>
				<input type="number" id="buyFormPrice" name="Quantity"  autocomplete="off" required><br>
				<input type="text" id="buyFormid" value = <?php echo "\"$id\"";?> name="id" style="display:none;">
				</div>
				
				<p>Дополнительные пожелания:</p>
				<textarea name="Description"></textarea><br>
				<button type="submit" id="sendMailButton">Заказать</button>
				<input type="text" id="Action" name="Action" value = "Edit" style="display:none">
			</form>
		</div>
	</div><!--end EditForm-->
	<div id="bulletinBoard"></div>
<script>
	var xhr = new XMLHttpRequest();
	var button = document.getElementById("sendMailButton");
	button.addEventListener("click",trySend);
	function reactForReadyStateChange(){
		if (xhr.readyState != 4) {return}
		if (xhr.status != 200) {log(xhr.status + ': ' + xhr.statusText);}
		if(xhr.status == 200){
			switch(xhr.responseText){
				case "mail = OK": 
					log("Ваша заявка отправлена. Спасибо за сотрудничество.");
					log("Переход на главную страницу через <span id=\"countdown\">10</span> секунд");
					log("<a href=\"../\">Перейти сейчас</a>");
					setTimeout(redirect,100);
					break;
				default: log(xhr.responseText);
			}
		}
	}
	function redirect(){
		var i=10;
		var func = function(){
				document.getElementById("countdown").innerHTML = --i;
				if(i>0){setTimeout(func,1000);}
				else{location.href = "../";	}
				};
		setTimeout(func,1000);
	};
	function trySend(e){
		if(!isFilled()){ //Проверка формы
			log("Нужно заполнить все выделенные поля.");
			return;
		}
		e.preventDefault();
		xhr.open('POST', 'send_mail.php', true);
		var formData = new FormData(document.forms.Buy);
		xhr.onreadystatechange = reactForReadyStateChange;
		xhr.send(formData);
		
		}
	var disp = document.getElementById("bulletinBoard");
	function log(text){disp.innerHTML += text + "<br>";}
	
	function isFilled(){ //Проверка формы
		var form = document.forms.Buy;
		var fields = form.querySelectorAll("[required]");
		for (var key in fields){
			if (fields[key].value == '') return false; //0 тоже не подходит
		}
		return true;
	}
	function mailOk(){}//<<<------- to do ---
</script>
</body>

</html>