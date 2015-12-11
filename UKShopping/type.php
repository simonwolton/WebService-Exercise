<?php
include ("callWebService.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if (isset($_GET['type']))
	{
		$data = urlencode( $_GET['type'] );
		header("content-type: text/xml");
		$url = "localhost/wsax/shopping/UKShopping/shopsXML.php?type=" . $data;
		$xmlReturned = callWebService($url, "GET");
		if ($xmlReturned['code']==200)
			echo $xmlReturned['content'];
	}
	else
		header("HTTP/1.1 401 Not Authorised");

}
?>