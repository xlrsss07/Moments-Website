<?php
    require_once 'functions.php';

    //$_SESSION['ID']=1;

    if(!isset($_GET['id']) || !isset($_SESSION['ID']))
    {
        die("<script>history.go(-1)</script>"); //返回上一页
    }

//    $permission=execMysql("SELECT user_level FROM association_touser
//                                WHERE chatroom_ID=? AND user_ID=?",
//        array($_GET['id'],$_SESSION['ID']),true);
//    if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
//    {
//        die("<script>history.go(-1)</script>"); //返回上一页
//    }

    echo <<<_END
    <!DOCTYPE html>
<html>

<head>
    <title>Society Setting</title>
    <link rel="icon" href="../images/Favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="js/society/SocietySettingPage.js"></script>
    <link rel="stylesheet" type="text/css" href="css/society/SocietySettingPage.css" media="screen" />
    <script type="text/javascript">
        //nocache = "&nocache=" + Math.random() * 1000000
        function sendAjax(url, method, param, fnSucc) {
            //url="./../../fuckwebsite/eventback.php?id=1";
            var request = new ajaxRequest();
            //request.open("GET", "urlget.php?url=amazon.com/gp/aw" + nocache, true)
            //request.open("GET", "./../../fuckwebsite/eventback.php?id=1",true);
            if (method === "GET") {
                //alert(url+"?"+param);
                request.open("GET", url + "?" + param, true);
                request.send(null);
            } else if (method === "POST") {
                request.open("POST", url, true)
                request.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
                request.send(param);
            }

            request.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        if (this.responseText != null) {
                            //document.getElementById('info').innerHTML =String(this.responseText);
                            //fnSucc(this.responseText);
                            //alert(this.responseText)
                            var obj = JSON.parse(this.responseText);
                            fnSucc(obj);
                        } else alert("Ajax error: No data received")
                    } else alert("Ajax error: " + this.statusText)
                }
            }
        }

        function getHsonLength(json) {
            var jsonLength = 0;
            for (var i in json) {
                jsonLength++;
            }
            return jsonLength;
        }

        function ajaxRequest() {
            try {
                var request = new XMLHttpRequest()
            } catch (e1) {
                try {
                    request = new ActiveXObject("Msxml2.XMLHTTP")
                } catch (e2) {
                    try {
                        request = new ActiveXObject("Microsoft.XMLHTTP")
                    } catch (e3) {
                        request = false
                    }
                }
            }
            return request
        }

        pass = 0;

        function ab() {
            sendAjax("./societyback.php", "GET", "id={$_GET['id']}&action=search", function(obj) {
                if (obj.resultCode == '200') {
                    pass == "200";
                    document.getElementById("SocietyName113").value = obj.name;
                    document.getElementById("SocietyContact113").value = obj.contact;
                    document.getElementById("SocietyLocation113").value = obj.address;
                    document.getElementById("SocietyDescription113").value = obj.description;

                    if (obj.category == "academic") {
                        document.getElementById("categoryA").click();
                    } else if (obj.category == "culture") {
                        document.getElementById("categoryB").click();
                    } else if (obj.category == "art") {
                        document.getElementById("categoryC").click();
                    } else if (obj.category == "generalinterest") {
                        document.getElementById("categoryD").click();
                    } else if (obj.category == "media") {
                        document.getElementById("categoryE").click();
                    } else if (obj.category == "sports") {
                        document.getElementById("categoryF").click();
                    } else if (obj.category == "outdoor") {
                        document.getElementById("categoryG").click();
                    } else if (obj.category == "volunteering") {
                        document.getElementById("categoryH").click();
                    }
                } else {
                    alert("Error");
                }

            //<tr>
                //<td class="ManageMember">zito</td>
                    //</tr>
                var member=document.getElementById("SocietyMembertable");
                for(var i=0;i<=getHsonLength(obj.allmembers)-1;i++)
                {
                    var tr=document.createElement("tr");
                    var td=document.createElement("td");
                    td.setAttribute("class","ManageMember")
                    td.innerHTML=obj.allmembers[i]['name'];

                    tr.appendChild(td);
                    member.appendChild(tr);
                }

            });
        }

        function sub() {
            if (document.getElementById("SocietyName113").value == "") {
                alert("Society Name field can not be empty!");
                return false;
            } else if (document.all("SocietyContact113").value == "") {
                alert("Society Contact field can not be empty!");
                return false;
            } else if (document.all("SocietyLocation113").value == "") {
                alert("Society Location field can not be empty!");
                return false;
            } else if (document.all("SocietyDescription113").value == "") {
                alert("Society Description field can not be empty!");
                return false;
            } else {
                alert("Thanks for your submission!");
                window.setTimeout(submit(), 500);
                return true;
                
                
            }

        }
         function submit(){
            window.location.href="society.php?id="+ {$_GET['id']};
    }

        //添加社团成员
        function addrowF()
        {
            //alert(pass);
            var id=document.getElementById("hiddenid").value;
            var user=document.getElementById("AddSocietyMemberName").value;
            var param="id="+id+"&action=add"+"&user="+user;
            sendAjax("./societyback.php","POST",param,function(obj)
            {
                pass=obj.resultCode;
                //alert(pass);
                if (pass === 200)
                {
                    var existInGroup = false;
                    var MemberName = document.getElementById('AddSocietyMemberName').value;
                    var c = document.getElementById('SocietyMembertable');

                    //防止输入的User Name为空
                    if (MemberName == "")
                    {
                        alert("User Name field can not be empty!");
                        document.all("AddSocietyMemberName").focus();
                    }
                    else
                    {
                        //向一个空表增加一行

                        if (c.rows.length == 0)
                        {
                            var x = c.insertRow(0);
                            var y = x.insertCell(0);
                            y.innerHTML = MemberName;
                        }
                        else
                        {
                            //不是空表 检查ID是否已在表格中
                            for (var i = 0; i < c.rows.length; i++)
                            {
                                if (c.rows[i].cells[0].innerHTML == MemberName)
                                {
                                    existInGroup = true;
                                    alert("User <" + MemberName + " > already exists in the group");
                                }
                            }

                            //如果ID不在表格中，则添加进去
                            if (existInGroup == false)
                            {
                                var z = c.rows[0].cells;
                                var x = c.insertRow(1);
                                for (var i = 0; i < z.length; i++)
                                {
                                    var y = x.insertCell(i);
                                    if (i == 0)
                                    {
                                        y.innerHTML = MemberName;
                                    }
                                }
                                alert("New group member: User <" + MemberName + ">");
                            }
                        }
                    }
                }
                else
                {
                    alert("Add Error");
                }
            });


        }

        //删除社团成员
        function delrowF() {
            var id=document.getElementById("hiddenid").value;
            var user=document.getElementById("DeleteSocietyMemberName").value;
            var param="id="+id+"&action=delete"+"&user="+user;
            sendAjax("./societyback.php","POST",param,function(obj) {

                pass = obj.resultCode;
                //alert(pass);
                if (pass == '200') {
                    var found = false;
                    var deleteName = document.getElementById("DeleteSocietyMemberName").value;
                    var x = document.getElementById('SocietyMembertable');
                    for (var i = 0; i < x.rows.length; i++) {
                        if (x.rows[i].cells[0].innerHTML == deleteName) {
                            found = true;
                            alert("You have deleted User: <" + x.rows[i].cells[0].innerHTML + "> from this group");
                            x.deleteRow(i);
                        }
                    }
                    if (found == false) {
                        alert("Sorry, User <" + deleteName + " > is not exists in this group");
                    }
                } else {
                    alert("Del Error");
                }
            });
        }
        
    </script>
</head>

<body onload="ab()">
<iframe src="./header.php" style="display:block; position:fixed;z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>
</br>
</br>
</br>
</br>
<iframe id="iframe_display" name="iframe_display" style="display: none;"></iframe>

<div class="SocietySettingSection">

    <form method="POST" target="iframe_display" action="./societyback.php" enctype="multipart/form-data" onsubmit="return sub();">
        <!-- target="iframe_display" -->
        <input type="hidden" name="id" value="{$_GET['id']}">
        <input type="hidden" name="action" value="update">
        <img class="EditSocietyPageOurLogo" src="../images/logo.png" />
        <!--Society Name-->
        <div class="littleSocietySettingSection">
            <label class="SocietyTexttip">Name:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label> <span><input id="SocietyName113" class="writelittleSocietySection" name="societynamee" type="text"></span>
        </div>

        <!--Society Contact-->
        <div class="littleSocietySettingSection">
            <label class="SocietyTexttip">Contact:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label> <span><input id="SocietyContact113" class="writelittleSocietySection" name="societycontactt" type="text" value="+44 "> </input></span>
        </div>

        <!--Society Address-->
        <div class="littleSocietySettingSection">
            <label class="SocietyTexttip">Address:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label> <span><input id="SocietyLocation113" class="writelittleSocietySection" name="societylocationn" type="text"></input></span>
        </div>

        <!--Society Description-->
        <div class="littleSocietySettingSection">
            <label class="SocietyTexttip">Description:&nbsp&nbsp&nbsp</label> <span><textarea id="SocietyDescription113" name="societydescriptionn"> </textarea></span>
        </div>

        <!--society类别 可多选-->
        <div class="littleSocietySettingSection">
            <label class="SocietyTexttip">Category: </label>
            <br/>
            <br/>
            <label>
                <input id="categoryA" class="radioLimitation" type="radio" name="societycategoryy" checked="checked" value="Academic">Academic</label>
            <br/>
            <label>
                <input id="categoryB" class="radioLimitation" type="radio" name="societycategoryy" value="Culture">Culture</label>
            <br/>
            <label>
                <input id="categoryC" class="radioLimitation" type="radio" name="societycategoryy" value="Art">Art</label>
            <br/>
            <label>
                <input id="categoryD" class="radioLimitation" type="radio" name="societycategoryy" value="Generalinterest">General Interest</label>
            <br/>
            <label>
                <input id="categoryE" class="radioLimitation" type="radio" name="societycategoryy" value="Media">Media</label>
            <br/>
            <label>
                <input id="categoryF" class="radioLimitation" type="radio" name="societycategoryy" value="Sports">Sports</label>
            <br/>
            <label>
                <input id="categoryG" class="radioLimitation" type="radio" name="societycategoryy" value="Outdoor">Outdoor</label>
            <br/>
            <label>
                <input id="categoryH" class="radioLimitation" type="radio" name="societycategoryy" value="Volunteering">Volunteering</label>
            <br/>

        </div>

        <!--Society Head Portrait-->
        <p>
            <label class="SocietyTexttip">Upload head portrait: </label>
            <input type="file" name="file" id="file" onchange="readAsDataURL()" />
        </p>
        <div class="imguploadshow" id="imguploadresult" multiple="multiple" name="imguploadresult">
        </div>

        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

        <!--Save Button-->
        <div class="mt20 text-center">
            <input id="btnsave" class="SavebuttonSocietyPage" type="submit" value="Submit" />
        </div>

    </form>

<!--Edit the society members  Add/Delete-->
<label class="SocietyTexttip">Edit society members: </label>
<br/>
<div class="EditYourSocietyMembers">
    <table class="SocieyManageMemberTable" border="0" id="SocietyMembertable">
        <tr>
            <th>Member Name</th>
        </tr>
        <!--
        <tr>
            <td class="ManageMember">zito</td>
        </tr>
        <tr>
            <td class="ManageMember">sunchen</td>
        </tr>
        <tr>
            <td class="ManageMember">xuyifan</td>
        </tr>
        <tr>
            <td class="ManageMember">ranwenxi</td>
        </tr>
        <tr>
            <td class="ManageMember">shazhanyu</td>
        </tr>
        <tr>
            <td class="ManageMember">liumuzhe</td>
        </tr>
        <tr>
            <td class="ManageMember">shiwentao</td>
        </tr>
        <tr>
            <td class="ManageMember">Ann</td>
        </tr>
        <tr>
            <td class="ManageMember">Ben</td>
        </tr>
        <tr>
            <td class="ManageMember">Lucy</td>
        </tr>
        <tr>
            <td class="ManageMember">Tracey</td>
        </tr>
        <tr>
            <td class="ManageMember">Alisasa</td>
        </tr>-->
    </table>
</div>

<br/>
<div class="ManageManageSocietyMember">
    <label class="SocietyTexttip">Add Society Member</label>
    <br/>

    <iframe id="iframe_display1" name="iframe_display1" style="display: none;"></iframe>

    <!--<form method="POST" action="./societyback.php" enctype="multipart/form-data" target="iframe_display1" onsubmit="addrowF();">
        <label class="SocietyTexttip">User Name</label> <span>
        <input name="user" class="writeAddMemberSociety" id ="AddSocietyMemberName" type="text">
    </span>
        <input class="MembersbuttonSocietyPage" type="submit" value="Add">
    </form>-->

    <form method="POST" action="" enctype="multipart/form-data" target="iframe_display1" onsubmit="addrowF();">
        <input type="hidden" name="id" id="hiddenid" value="{$_GET['id']}">

        <label class="SocietyTexttip">User Name</label> <span>
        <input name="user" class="writeAddMemberSociety" id ="AddSocietyMemberName" type="text">
    </span>
        <!--<input class="MembersbuttonSocietyPage" type="submit" value="Add">-->
        <button class="MembersbuttonSocietyPage" type="button" onclick="addrowF()">Add</button>
    </form>

    <br/>

    <form method="POST" action="../societyback.php" enctype="multipart/form-data" target="iframe_display1" onsubmit="delrowF();">
        <input type="hidden" name="id" value="1">

        <label class="SocietyTexttip">Delete Society Member</label>
        <br/>
        <label class="SocietyTexttip">User Name</label> <span><input name="user" class="writeAddMemberSociety" id="DeleteSocietyMemberName" type="text"></span>
<!--        <input class="MembersbuttonSocietyPage" type="submit" value="Delete">-->
        <button class="MembersbuttonSocietyPage" type="button" onclick="delrowF()">Delete</button>
    </form>
</div>
<br/>
<br/>
<br/>

</div>

</div>

<iframe src="./bottom.html" style="display:block;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=310 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>

</body>

</html>
_END;
