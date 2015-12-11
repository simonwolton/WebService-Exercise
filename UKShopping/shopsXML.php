<?php
$currentTag = null;
$ids = array();
$names = array();
$types = array();
$locations = array();
include("xmlParser.php");
if ($_SERVER["REQUEST_METHOD"]=="GET")
{
	header("content-type: text/xml");
	$url = "SELECT * FROM shops";

	if (isset($_GET['id']))
	{
		$url .= " WHERE shopID =" . $_GET['id'];
	}
	elseif (isset($_GET['name']))
	{
		$url .= " WHERE shopName LIKE '%" . $_GET['name'] . "%'";
		if (isset($_GET['location']))
		{
			$url .= " AND shopLocation LIKE '%" . $_GET['location'] . "%'";
			if (isset($_GET['type']))
				$url .= " AND shopType LIKE '%" . $_GET['type'] . "%'";
		}
	}
	elseif (isset($_GET['type']))
	{
		$url .= " WHERE shopType LIKE '%" . $_GET['type'] . "%'";
		if (isset($_GET['location']))
			$url .= " AND shopLocation LIKE '%" . $_GET['location'] . "%'";
	}
	elseif (isset($_GET['location']))
		$url .= " WHERE shopLocation LIKE '%" . $_GET['location'] . "%'";
	
	$conn = mysqli_connect("localhost", "root", "admin","wsax");
	if (mysqli_connect_errno())
		echo mysqli_connect_errno();
	
	$result = mysqli_query($conn,$url);
	$numRows = mysqli_num_rows($result);
	if (!($numRows==0))
	{
		echo "<shops>";
		while($row = mysqli_fetch_assoc($result))	
		{
			echo "<shop>";
				echo "<id>" . $row["shopID"] . "</id>";
				echo "<name>" . $row["shopName"] . "</name>";
				echo "<type>" . $row["shopType"] . "</type>";
				echo "<location>" . $row["shopLocation"] . "</location>";
			echo "</shop>";
		}
		echo "</shops>";
	}
	else 
		header("HTTP/1.1 404 Not Found");
	
	mysqli_close($conn);
}
elseif ($_SERVER['REQUEST_METHOD']=="POST")
{
	$xmlInput = $_POST['data'];
	
	$parser=xml_parser_create();
	xml_set_element_handler($parser, "foundOpeningTag","foundClosingTag");
	xml_set_character_data_handler($parser, "foundText");
	xml_parse($parser,$xmlInput);
	xml_parser_free($parser);
	
	for($i=0;$i<count($names); $i++)
	{
		$url = "INSERT INTO `shops`(`shopName`, `shopType`, `shopLocation`) VALUES ('".$names[$i]."','".$types[$i]."','".$locations[$i]."')";
	}

	$conn = mysqli_connect("localhost", "root", "admin","wsax");
	mysqli_query($conn,$url);
	if (!$result) 
	{
		die(mysql_error());
		header("HTTP/1.1 500 Internal Server Error");
	}
	mysqli_close($conn);
	

}
elseif ($_SERVER["REQUEST_METHOD"]=="DELETE")
{
	$url = "DELETE FROM `shops` WHERE shopID = ".$_GET['id'];
	$conn = mysqli_connect("localhost", "root", "admin","wsax");
	
	mysqli_query($conn,$url);
	if (!$result) 
	{
		die(mysql_error());
		header("HTTP/1.1 500 Internal Server Error");
	}
}
elseif ($_SERVER["REQUEST_METHOD"]=="PUT")
{
	$xmlReturned["content"] = file_get_contents('php://input');
	if ($xmlReturned["content"]==null)
		header("HTTP/1.1 404 Not Found");
	else
	{
		$parser=xml_parser_create();
		xml_set_element_handler($parser, "foundOpeningTag","foundClosingTag");
		xml_set_character_data_handler($parser, "foundText");
		xml_parse($parser,$xmlReturned["content"]);
		xml_parser_free($parser);
		
		for($i=0;$i<count($names); $i++)
		{
			$url = "UPDATE shops SET `shopName`='" . $names[$i] . "', `shopType`='" . $types[$i] . "', `shopLocation`='" . $locations[$i] . "' WHERE `shopID`=" . $_GET['id'];

			"INSERT INTO `shops`(`shopName`, `shopType`, `shopLocation`) VALUES (".$names[$i].",".$types[$i].",".$locations[$i].")";
			$conn = mysqli_connect("localhost", "root", "admin","wsax");
			$result = mysqli_query($conn,$url);
			if (!$result) 
			{
				die(mysql_error());
				header("HTTP/1.1 500 Internal Server Error");
			}
			mysqli_close($conn);
		}
	}
	
}


?>