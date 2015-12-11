<?php
include ("callWebService.php");
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if (isset($_GET['location']))
	{
		$data = urlencode( $_GET['location'] );
		header("content-type: text/xml");
		$url = "localhost/wsax/shopping/UKShopping/shopsXML.php?location=" . $data;
		$xmlReturned = callWebService($url, "GET");
		if ($xmlReturned['code']==200)
			echo $xmlReturned['content'];
		if ($xmlReturned['code']==401)
			header("HTTP/1.1 401 Not Authorised");
		if ($xmlReturned['code']==500)
			header("HTTP/1.1 500 An internal server error occurred");
	}
	else
		header("HTTP/1.1 401 Not Authorised");
}
?>