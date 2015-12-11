<?php
include ("callWebService.php");
$currentPath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
echo "<a href='" . $currentPath. "/'>Home</a><br />";
function foundOpeningTag($parser,$tag,$attributes)
{
	global $currentTag;
	
	$currentTag = $tag;
}
function foundClosingTag($parser,$tag)
{
	global $currentTag;
	$currentTag = null;
}

function foundText($parser,$characters)
{

	global $currentTag, $ids, $names, $types, $locations;
	if($currentTag == "ID")
		$ids[] = $characters;   
	elseif($currentTag == "NAME")
		$names[] = $characters;
	elseif($currentTag == "TYPE")
		$types[] = $characters;
	elseif($currentTag == "LOCATION")
		$locations[] = $characters;

}

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{	
	
	$url = "localhost/wsax/shopping/UKShopping/shopsXML.php?id=" . $_GET['id'];
	$xmlReturned = callWebService($url, "GET");

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
		echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
		echo '<input type="hidden" name="id" value='.$ids[$i].'>';
		echo 'Name: <input type="text" name="name" value='.$names[$i].'><br />';
		echo 'Type: <input type="text" name="type" value='.$types[$i].'><br />';
		echo 'Location: <input type="text" name="location" value='.$locations[$i].'><br />';
		echo '<input type="submit">';
		echo '</form>';
	}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if ((isset($_POST['id'])) && (isset($_POST['name'])) && (isset($_POST['type'])) && (isset($_POST['location'])))
	{
		$putData = "<shop>" .
			"<name>" . $_POST['name'] . "</name>" . "
			<type>" . $_POST['type'] . "</type>" . "
			<location>" . $_POST['location'] . "</location>" . "
		</shop>";
		$shopID = $_POST['id'];
		$xmlReturned = callWebService("localhost/wsax/shopping/UKShopping/shopsXML.php?id=$shopID","PUT",$putData);
		
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
		if ($xmlReturned['code']==200)
			header("Location: index.php");
		
	}
}


?>