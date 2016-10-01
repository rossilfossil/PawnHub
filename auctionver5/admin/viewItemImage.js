function viewContent(itemID){
	// alert(itemID)
	// return;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('viewContent').innerHTML = xmlhttp.responseText;
 			$('#imageModal').openModal();
		} // if ready state
	};

	xmlhttp.open("POST","viewItemImage.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("itemID=" + itemID);   
}