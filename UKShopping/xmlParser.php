<?php
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
	switch($currentTag)
	{
		case 'ID':
			$ids[] = $characters; 
			break;
		case 'NAME':
			$names[] = $characters;
			break;
		case 'TYPE':
			$types[] = $characters;
			break;
		case 'LOCATION':
			$locations[] = $characters;
			break;
	}		
}
?>