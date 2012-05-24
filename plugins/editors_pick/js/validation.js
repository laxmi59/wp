function validate(){
	var name = document.getElementById('name');
	var image_desc = document.getElementById('image_desc');
	var image = document.getElementById('image');
	if(name.value==""){
		alert("Please Enter Image Name.");
		name.focus();
		return false;
	}
	if(image_desc.value==""){
		alert("Please Enter Image Description.");
		image_desc.focus();
		return false;
	}
	if(image.value==""){
		alert("Please Upload Image Here.");
		image.focus();
		return false;
	}
}