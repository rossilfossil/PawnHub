function auctionStart(auctionID){
	// alert(auctionID)
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
          	Materialize.toast('New Auction Started!!', 4000,'black');
          	alert(xmlhttp.responseText)
          		if(xmlhttp.responseText == "0"){
					countdown(0,0,0,0,0,0,-1)
					document.getElementById("jsalarm_ct").innerHTML= "<center>No Auctions Listed</center>"
          			// return;
          		}else{
          			responseArray = xmlhttp.responseText.split("/");
					countdown(responseArray[0],responseArray[1],responseArray[2],responseArray[3],responseArray[4],responseArray[5],responseArray[6])
					document.getElementById("AuctionName").innerHTML = responseArray[7];
					document.getElementById("View").innerHTML = '<button class="btn black white-text" onclick="viewContent('+responseArray[6]+')">View</button>';
          		}
		} // if ready state
	};

	xmlhttp.open("POST","auctionstart.php", false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("auctionID=" + auctionID);   
}