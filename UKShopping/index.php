<html>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<body onload="viewAllShops()">
		<?php 
		include ("callWebService.php");
		$currentPath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
		echo  "<div id='header'><button onclick=ajaxRequest('viewAllShops.php','get',resultsReturned)>Home</button>"; 
		?>
		<button onclick='showAddForm()'>Add</button>
		Search: <input id="search" type="text" name="input" onKeyUp="nameSearch()"></div>
		<script src="prototype.js"></script>
		<script type="text/javascript">
		function ajaxRequest(url, method, onCompleteAction, paramKey, paramValue) 
		{
			if (typeof(paramKey)===undefined) 
			{
				var request = new Ajax.Request
				(url,
					{ method: method,
					parameters:paramKey + "=" + paramValue,
			        onComplete: onCompleteAction }
			    );
			}
			else
			{
				//alert("url is " + url + "<br>method is " + method + "<br>paramKey is "+paramKey+"<br>paramValue is "+paramValue);
				var request = new Ajax.Request
				(url,
					{ method: method,
			        onComplete: onCompleteAction }
			    );
			}
		}
		function nameSearch()
		{
			var input = document.getElementById("search").value;
			var request = new Ajax.Request
			('getShops.php',
				{ method: 'get',
				parameters:"name=" + input,
		        onComplete: resultsReturned }
		    );
		}		
		function viewShop(id)
		{
			var request = new Ajax.Request
			('viewShop.php',
				{ method: 'get',
				parameters:"id=" + id,
		        onComplete: resultsReturned }
		    );
		}
		function editShop(id)
		{
			var request = new Ajax.Request
			('viewShop.php',
				{ method: 'get',
				parameters:"id=" + id,
		        onComplete: showEditForm }
		    );
		}
		function deleteShop(id)
		{
			var request = new Ajax.Request
			('deleteShop.php',
				{ method: 'get',
				parameters:"id=" + id,
		        onComplete: viewAllShops }
		    );
		}
		function viewType(type)
		{
			var request = new Ajax.Request
			('type.php',
				{ method: 'get',
				parameters:"type=" + type,
		        onComplete: resultsReturned }
		    );

		}
		function viewLocation(location)
		{
			var request = new Ajax.Request
			('location.php',
				{ method: 'get',
				parameters:"location=" + location,
		        onComplete: resultsReturned }
		    );

		}
		function viewAllShops()
		{
			var request = new Ajax.Request
			('viewAllShops.php',
				{ method: 'get',
		        onComplete: resultsReturned }
		    );
		}
		function showAddForm()
		{
			document.getElementById("content").innerHTML = "<form action='addShop.php' method='post' class='item'>"+
			"Name: <input type='text' name='name'><br />"+
			"Type: <input type='text' name='type'><br />"+
			"Location: <input type='text' name='location'><br />"+
			"<input type='submit'></form>";
		}
		function resultsReturned(xmlHTTP)
		{
			
			if (xmlHTTP.status==200)
			{
				if(xmlHTTP.responseXML===null)
					html="No results returned";
				else
				{
					var shopArray = xmlHTTP.responseXML.getElementsByTagName('shop');
					var html = "";
					if(shopArray.length>0)
					{
						for (var i = 0; i<shopArray.length; i++)
						{
							var shopID = shopArray[i].getElementsByTagName("id")[0].firstChild.nodeValue;
							var shopName = shopArray[i].getElementsByTagName("name")[0].firstChild.nodeValue;
							var shopType = shopArray[i].getElementsByTagName('type')[0].firstChild.nodeValue;
							var shopLocation = shopArray[i].getElementsByTagName('location')[0].firstChild.nodeValue;
							html = html + "<div class='item'><div class='itemName'><strong>Name: </strong>"+shopName+ "</div>"+
							" <div class='itemType'><strong>Type:</strong>"+shopType+"<button onclick='viewType(`"+shopType+"`)'>View All</button></div>"+
							" <div class='itemLocation'><strong>Location:</strong>"+shopLocation+"<button onclick='viewLocation(`"+shopLocation+"`)'>View All</button></div>"+
							"<div class='options'><button onclick='viewShop(`"+shopID+"`)'>View</button> | "+
							"<button onclick='editShop(`"+shopID+"`)'>Edit</button> | "+
							"<button onclick='deleteShop(`"+shopID+"`)''>Delete</button></div></div>";
						}
					}
				}
				document.getElementById("content").innerHTML = html;
			}
		}
		
		
		function showEditForm (xmlHTTP) 
		{
			var shopArray = xmlHTTP.responseXML.getElementsByTagName('shop');
			var html = "";
			
			for (var i = 0; i<shopArray.length; i++)
			{
				var shopID = shopArray[i].getElementsByTagName("id")[0].firstChild.nodeValue;
				var shopName = shopArray[i].getElementsByTagName("name")[0].firstChild.nodeValue;
				var shopType = shopArray[i].getElementsByTagName('type')[0].firstChild.nodeValue;
				var shopLocation = shopArray[i].getElementsByTagName('location')[0].firstChild.nodeValue;
				html = html + "<form action='editShop.php' method='post' class='item'>"+
								"<input type='hidden' name='id' value='"+shopID+"'>"+
								"Name: <input type='' name='name' value='"+shopName+"'><br />"+
								"Type: <input type='text' name='type' value='"+shopType+"'><br />"+
								"Location: <input type='text' name='location' value='"+shopLocation+"'><br />"+
								"<input type='submit'></form>";
			}
			document.getElementById("content").innerHTML = html;
		}		
		</script>
		
		<div id="content"></div>
	</body>
</html>