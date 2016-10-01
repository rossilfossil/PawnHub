function editAuction(aucID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('editContent').innerHTML = xmlhttp.responseText;
		 	$('#editModal').openModal();
		} // if ready state
	};

	xmlhttp.open("POST","editAuction.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("aucID=" + aucID);   
}

function extendAuction(aucID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('extendContent').innerHTML = xmlhttp.responseText;
 			$('#extendModal').openModal();
		} // if ready state
	};

	xmlhttp.open("POST","extendAuction.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("aucID=" + aucID);   
}