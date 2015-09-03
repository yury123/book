<?php 
function __autoload($className){
	$path=$_SERVER['DOCUMENT_ROOT'].'/'.str_replace('_','/',$className);
	include("$path.php");
}
?>