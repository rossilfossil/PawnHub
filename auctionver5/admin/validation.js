function validateTextOnly(text,id){
	// if (!/^[A-Z]{1,}([\s-]*[-a-zA-Z\s'.{1}-]*)$/.test(text)){
	if (!/^([\s-]*[-a-zA-Z\s'.{1}-]*)$/.test(text)){
		text = text.slice(0, -1);
		document.getElementById(id).value = text;
		document.getElementById(id).innerHTML=text;
		return;	
	}	
}

function validateNumberOnly(number,id){
	if (!/^[0-9.\s]+$/.test(number)){
		number = number.slice(0, -1);
		document.getElementById(id).value = number;
		document.getElementById(id).innerHTML=number;
		return;	
	}	
}

function validateNoSpecs(string,id){
	if (!/^[A-Za-z0-9.\s]+$/.test(string)){
		string = string.slice(0, -1);
		document.getElementById(id).value = string;
		document.getElementById(id).innerHTML=string;
		return;	
	}	
}


function validateMinSpecs(string,id){
	if (!/^[A-Za-z0-9'-\s]+$./.test(string)){
		string = string.slice(0, -1);
		document.getElementById(id).value = string;
		document.getElementById(id).innerHTML=string;
		return;	
	}	
}

function checkMin(number,id){
	if (number > document.getElementById(id).value){
		number = number.slice(0,-1);
		document.getElementById(id).value = number;
		document.getElementById(id).innerHTML=number;
	}
}