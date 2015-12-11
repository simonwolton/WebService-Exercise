<?php
if ($_SERVER["REQUEST_METHOD"]=="GET")
{
	header("content-type: text/xml");
	include ("callWebService.php");
	$url = "localhost/wsax/shopping/UKShopping/listShopsXML.php?location=IOW";
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

	echo $xmlReturned['content'];
}
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
?>