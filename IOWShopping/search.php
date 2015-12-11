Search: <input id="search" type="text" name="input">
<button onclick="ajaxRequest()">Click me</button>

<html>
	<script src="prototype.js"></script>
	<script type="text/javascript">
	function ajaxRequest()
	{
		var input = document.getElementById("search").value;
		var request = new Ajax.Request
		('getShops.php?location=IOW',
			{ method: 'get',
			parameters:"name=" + input,
	        onComplete: resultsReturned }
	    );
	}

	function resultsReturned(xmlHTTP)
	{

		var shopArray = xmlHTTP.responseXML.getElementsByTagName('shop');
		var html = "";
		
		for (var i = 0; i<shopArray.length; i++)
		{
			var shopName = shopArray[i].getElementsByTagName("name")[0].firstChild.nodeValue;
			var shopType = shopArray[i].getElementsByTagName('type')[0].firstChild.nodeValue;
			var shopLocation = shopArray[i].getElementsByTagName('location')[0].firstChild.nodeValue;
			html = html + "<p><strong>Name:</strong>" + shopName + "<br />" +
							"<strong>Type:</strong>" + shopType + "<br />" +
							"<strong>Location:</strong>" + shopLocation + "</p>";
		}		

		document.getElementById("content").innerHTML = html;
	}
	</script>
	
	<div id="content"></div>
</html>