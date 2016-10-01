function setCategory(amount){		
	document.getElementById('scate').options.length = 1;
	document.getElementById('subcat').options.length = 1;
	var xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function() {
		if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {

			var responseArray1 = xmlhttp2.responseText.split("/");
			
			for(i = responseArray1.length-1; i>=0;i--){
        		selectBox = document.getElementById('scate');
        		var contentArray = responseArray1[i].split("+")
 				selectBox.options[i+1] = new Option(contentArray[1], contentArray[0]);
			}
		}//if readystate
	};

	xmlhttp2.open("POST", "display-category.php", false);
	xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp2.send("amount="+ amount);    
}//displayBrand

function setSubCategory(amount){		
	document.getElementById('subcat').options.length = 1;	
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

			var responseArray = xmlhttp.responseText.split("/");
			
			for(i = responseArray.length-1; i>=0;i--){
        		selectBox = document.getElementById('subcat');
        		var contentArray = responseArray[i].split("+")
 				selectBox.options[i+1] = new Option(contentArray[1], contentArray[0]);
			}
		}//if readystate
	};

	xmlhttp.open("POST", "display-subcategory.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("amount="+ amount);    
}//displayBrand