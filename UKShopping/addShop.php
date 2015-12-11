<?php
include ("callWebService.php");
include("xmlParser.php");
$currentPath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);


if ($_SERVER['REQUEST_METHOD'] == 'GET')
{	
	header("Location: $currentPath");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	echo "<a href='" . $currentPath. "/'>Home</a><br />";
	if ((isset($_POST['name'])) && (isset($_POST['type'])) && (isset($_POST['location'])))
	{
		$postData = "<shop>" .
			"<name>" . $_POST['name'] . "</name>" . "
			<type>" . $_POST['type'] . "</type>" . "
			<location>" . $_POST['location'] . "</location>" . "
		</shop>";
		
		$xmlReturned = callWebService("localhost/wsax/shopping/UKShopping/shopsXML.php","POST",$postData);
		
		if ($xmlReturned['code']==200)
			header("Location: $currentPath");

		
	}
}


?>