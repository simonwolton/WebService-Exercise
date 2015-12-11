<?php

header("content-type: text/xml");
if (isset($_GET['location']))
	$url = "SELECT * FROM shops WHERE shopLocation = '" . $_GET['location'] . "'";
else 
	$url = "SELECT * FROM shops";
$conn = mysqli_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword","exampleDBtable");
if (mysqli_connect_errno())
	echo mysqli_connect_errno();


$result = mysqli_query($conn,$url);
$numRows = mysqli_num_rows($result);
if ($numRows==0)
	header("HTTP/1.1 404 Not Found");
else
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
	mysqli_close($conn);
}
?>