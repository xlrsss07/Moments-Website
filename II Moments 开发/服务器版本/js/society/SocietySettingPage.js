 //上传eventd的照片
var result=document.getElementById("imguploadresult");  
var file=document.getElementById("file"); 
  
function readAsDataURL(){  
    var file = document.getElementById("file").files;
    var result=document.getElementById("imguploadresult");  
    for(i = 0; i< file.length; i ++) {
        var reader    = new FileReader();    
        reader.readAsDataURL(file[i]);  
        reader.onload=function(e){  
            result.innerHTML = result.innerHTML + '<img src="' + this.result +'"  width="240" height="180"/>';  

        }
    }  
}  


function previewFile() {
  var preview = document.querySelector('img');
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}


//防止用户输入的字符段为空
function myclickForSocietySettings()
{
   if(document.all("SocietySocietyName").value == ""){
alert("Society Name field can not be empty!");
document.all("SocietySocietyName").focus();
return false;
}
else if(document.all("SocietySocietyContact").value == ""){
alert("Society contact field can not be empty!");
document.all("SocietySocietyContact").focus();
return false;
}
else if(document.all("SocietySocietyLocation").value == ""){
alert("Society address field can not be empty!");
document.all("SocietySocietyLocation").focus();
return false;
}
else if(document.all("SocietySocietyDescription").value == ""){
alert("Society description field can not be empty!");
document.all("SocietySocietyDescription").focus();
return false;
}
else if(document.all("SocietySocietyMID").value == ""){
alert("Society Manager ID field can not be empty!");
document.all("SocietySocietyMID").focus();
return false;
}

else
{alert("Thanks for your submission!");
 window.history.back(-1);
	return true;}

}


//添加社团成员
function addrow(){
    var existInGroup=false;
   var MemberName=document.getElementById('AddSocietyMemberName').value;
  var c=document.getElementById('SocietyMembertable');

//防止输入的User Name为空
if(MemberName == ""){
alert("User Name field can not be empty!");
document.all("AddSocietyMemberName").focus();
}
else{

//向一个空表增加一行
  if( c.rows.length==0){
 var x=c.insertRow(0);
 var y=x.insertCell(0);  
 y.innerHTML=MemberName;
  }
else{
//不是空表 检查ID是否已在表格中
for(var i=0;i<c.rows.length;i++){
    if(c.rows[i].cells[0].innerHTML==MemberName){
        existInGroup=true;
        alert("User <"+MemberName+" > already exists in the group");
    }
}

//如果ID不在表格中，则添加进去
if(existInGroup==false){
var z=c.rows[0].cells;
var x=c.insertRow(1);
for(var i=0;i<z.length;i++){
     var y=x.insertCell(i);
if(i==0){
  y.innerHTML=MemberName;  
}
}
alert("New group member: User <"+MemberName+">");
 }
}
}
}


//删除社团成员
function delrow(){
    var found=false;
    var deleteName=document.getElementById("DeleteSocietyMemberName").value;
    var x=document.getElementById('SocietyMembertable');
for(var i=0;i<x.rows.length;i++){
    if(x.rows[i].cells[0].innerHTML==deleteName){
        found=true;
        alert("You have deleted User: <"+x.rows[i].cells[0].innerHTML+"> from this group");
        x.deleteRow(i);
    }
}
if(found==false){
    alert("Sorry, User <"+deleteName+" > is not exists in this group");
}
}


