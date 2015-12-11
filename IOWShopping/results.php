<form action="results.php" method="post">
Search: <input type="text" name="input">
<input type="submit">
</form>

<?php
$currentPath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
echo "<a href='" . $currentPath. "/'>Home</a><br />";
include ('callWebService.php');
include ("xmlParser.php");
$url = "localhost/wsax/shopping/UKShopping/shopsXML.php";

if (($_SERVER['REQUEST_METHOD'])=='POST')
{
	if(isset($_POST['input']))
	{
		$url .= "?name=" . $_POST['input'];
		$xmlReturned = callWebService($url, "GET");
	}
	$currentTag = null;
	$ids = array();
	$names = array();
	$types = array();
	$locations = array();

	$parser=xml_parser_create();
	xml_set_element_handler($parser, "foundOpeningTag","foundClosingTag");
	xml_set_character_data_handler($parser, "foundText");
	xml_parse($parser,$xmlReturned["content"]);
	xml_parser_free($parser);


	for($i=0;$i<count($names); $i++)
	{
		echo "<strong>Name:</strong>" . $names[$i] . " <a href='viewShop.php?id=" . $ids[$i] . "'>View</a> | <a href='editShop.php?id=" . $ids[$i] . "'>Edit</a> | <a href='deleteShop.php?id=" . $ids[$i] . "'>Delete</a> <br />";
		echo "<strong>Type:</strong>" . $types[$i] . " <br />";
		echo "<strong>Location:</strong>" . $locations[$i] . " <br /><br />";
	}
}
?>