function setCity(amount){		
	document.getElementById('delivery_city').options.length = 1;
	var xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function() {
		if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {

			var responseArray1 = xmlhttp2.responseText.split("/");
			
			for(i = responseArray1.length-1; i>=0;i--){
        		selectBox = document.getElementById('delivery_city');
        		var contentArray = responseArray1[i].split("+")
 				selectBox.options[i+1] = new Option(contentArray[1], contentArray[0]);
			}
		}//if readystate
	};

	xmlhttp2.open("POST", "admin/display-city.php", false);
	xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp2.send("amount="+ amount);    
}//displayBrand