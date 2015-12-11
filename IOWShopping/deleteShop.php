<?php
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
	include ("callWebService.php");
	$url = "localhost/wsax/shopping/UKShopping/shopsXML.php?id=" . $_GET['id'];
	$xmlReturned = callWebService($url, "DELETE");
	header("Location: localhost/wsax/shopping/IOWShopping/"); 
}


?>