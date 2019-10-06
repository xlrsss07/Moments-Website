 
//上传eventd的照片
var result=document.getElementById("result");  
var file=document.getElementById("file");  
  
function readAsDataURL(){  

    var file = document.getElementById("file").files;
    var result=document.getElementById("result");  

    for(i = 0; i< file.length; i ++) {
        var reader    = new FileReader();    
        reader.readAsDataURL(file[i]);  
        reader.onload=function(e){  
            //多图预览

            result.innerHTML = result.innerHTML + '<img src="' + this.result +'" alt="" />';  
        }
    }  
}  


//防止用户输入的字符段为空
function myclickForEventSettings()
{
   if(document.all("EventSettingEventName").value == ""){
alert("Event Name field can not be empty!");
document.all("EventSettingEventName").focus();
return false;
}
else if(document.all("EventEventLocation").value == ""){
alert("Event Location field can not be empty!");
document.all("EventEventLocation").focus();
return false;
}
else if(document.all("EventEventDescription").value == ""){
alert("Event Description field can not be empty!");
document.all("EventEventDescription").focus();
return false;
}
else
{alert("Thanks for your submission!");
 window.history.back(-1);
	return true;}

}

