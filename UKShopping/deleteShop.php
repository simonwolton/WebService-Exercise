<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	include ("callWebService.php");
	$url = "localhost/wsax/shopping/UKShopping/shopsXML.php?id=" . $_GET['id'];
	$xmlReturned = callWebService($url, "DELETE");
	header("Location: localhost/wsax/shopping/UKShopping/"); 
}


?>