function viewContent(aucID){
	// alert(aucID)
	// return;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('viewContent').innerHTML = xmlhttp.responseText;
 			$('#viewModal').openModal();
		} // if ready state
	};

	xmlhttp.open("POST","viewContent.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("aucID=" + aucID);   
}