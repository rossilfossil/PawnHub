function addItem(itemID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('itemList').innerHTML = xmlhttp.responseText;
		} // if ready state
	};

	xmlhttp.open("POST","add_item.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("itemID=" + itemID);   
}

function removeItem(itemID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('itemList').innerHTML = xmlhttp.responseText;
		} // if ready state
	};

	xmlhttp.open("POST","remove_item.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("itemID=" + itemID);   
}