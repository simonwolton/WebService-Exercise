<?php
include("xmlParser.php");
if ($_SERVER["REQUEST_METHOD"]=="GET")
{
	header("content-type: text/xml");
	include ("callWebService.php");
	$url = "localhost/wsax/shopping/UKShopping/listShopsXML.php";
	$xmlReturned = callWebService($url, "GET");

	echo $xmlReturned['content'];
}
?>