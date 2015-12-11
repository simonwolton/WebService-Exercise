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

	$url = "localhost/wsax/shopping/UKShopping/shopsXML.php?type=" . $_GET['type'] . "&location=IOW";
	
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

	echo "<h3>Here is a list of " . $_GET['type'] . "s on the IOW</h3><br />";
	for($i=0;$i<count($names); $i++)
	{
		

		if (!($locations[$i] == 'IOW'))
			die("Not authorised to access this shop");
		echo "<strong>Name:</strong>" . $names[$i] . " <a href='".$currentPath."/shop/" . $ids[$i] . "'>View</a> | <a href='".$currentPath."/edit/" . $ids[$i] . "'>Edit</a> | <a href='".$currentPath."/delete/" . $ids[$i] . "'>Delete</a> <br />";
		echo "<strong>Type:</strong>" . $types[$i] . "<br />";
		echo "<strong>Location:</strong>" . $locations[$i] . " <br /><br />";
	}
}




?>