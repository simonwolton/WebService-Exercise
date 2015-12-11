<?php

include ("callWebService.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	var_dump($_POST);
	if ((isset($_POST['id'])) && (isset($_POST['name'])) && (isset($_POST['type'])) && (isset($_POST['location'])))
	{
		$putData = "<shop>" .
			"<name>" . $_POST['name'] . "</name>" . "
			<type>" . $_POST['type'] . "</type>" . "
			<location>" . $_POST['location'] . "</location>" . "
		</shop>";
		$shopID = $_POST['id'];
		$xmlReturned = callWebService("localhost/wsax/shopping/UKShopping/shopsXML.php?id=$shopID","PUT",$putData);
		if ($xmlReturned['code']==200)
			header("Location: .");		
	}
}

?>