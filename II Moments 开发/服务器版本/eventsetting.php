<?php
    require_once 'functions.php';

    //$_SESSION['ID']=1;

    if(!isset($_GET['id']) || !isset($_SESSION['ID']))
    {
        die("<script>history.go(-1)</script>"); //返回上一页
    }

    $asso_results=execMysql("SELECT asso_ID FROM event WHERE event_ID=?",
                            array($_GET['id']),true);

    if($asso_results->rowCount()===0)
    {
        die("<script>history.go(-1)</script>");
    }


    $asso_ID=$asso_results->fetch()['asso_ID'];

    $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
                            array($asso_ID,$_SESSION['ID']),true);

    if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
    {
        die("<script>history.go(-1)</script>"); //返回上一页
    }

    echo <<<_END
<!DOCTYPE html>
<html>

<head>
    <title>Event</title>
    <link rel="icon" href="images/Favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="js/events/EventSettingPage.js"></script>
    <link rel="stylesheet" type="text/css" href="css/events/EventSettingPage.css" media="screen" />

<script type="text/javascript">
    //nocache = "&nocache=" + Math.random() * 1000000
    function sendAjax(url,method,param,fnSucc)
    {
        //url="./../../fuckwebsite/eventback.php?id=1";
        var request = new ajaxRequest();
        //request.open("GET", "urlget.php?url=amazon.com/gp/aw" + nocache, true)
        //request.open("GET", "./../../fuckwebsite/eventback.php?id=1",true);
        if(method==="GET")
        {
            //alert(url+"?"+param);
            request.open("GET",url+"?"+param,true);
            request.send(null);
        }
        else if(method==="POST")
        {
            request.open("POST",url,true)
            request.setRequestHeader('content-type','application/x-www-form-urlencoded');
            request.send(param);
        }



        request.onreadystatechange = function()
        {
            if (this.readyState === 4)
            {
                if (this.status === 200)
                {
                    if (this.responseText != null)
                    {
                        //alert(this.responseText)
                        var obj=JSON.parse(this.responseText);
                        fnSucc(obj);
                    }
                    else alert("Ajax error: No data received")
                }
                else alert( "Ajax error: " + this.statusText)
            }
        }
    }

    function getHsonLength(json){
        var jsonLength=0;
        for (var i in json) {
            jsonLength++;
        }
        return jsonLength;
    }

    function ajaxRequest()
    {
        try
        {
            var request = new XMLHttpRequest()
        }
        catch(e1)
        {
            try
            {
                request = new ActiveXObject("Msxml2.XMLHTTP")
            }
            catch(e2)
            {
                try
                {
                    request = new ActiveXObject("Microsoft.XMLHTTP")
                }
                catch(e3)
                {
                    request = false
                }
            }
        }
        return request
    }


    function ab() {
        sendAjax("eventback.php","GET","id={$_GET['id']}",function(obj)
        {
            //alert(obj.date);
            if(obj.resultCode=="200")
            {
                document.getElementById("EventName113").value=obj.name;
                document.getElementById("EventTime113").value=obj.date;
                document.getElementById("EventLocation113").value=obj.location;
                document.getElementById("EventDescription113").value=obj.description;

                if(obj.limitation=="1")
                {
                    document.getElementById("limitationA").click();
                }
                else if(obj.limitation=="2")
                {
                    document.getElementById("limitationB").click();
                }
                else
                {
                    document.getElementById("limitationC").click();
                }

                var ul=document.getElementById("result");
                // alert(getHsonLength(obj.img));
                for(var i=0;i<=getHsonLength(obj.img)-1;i++)
                {
                    var li=document.createElement("li");
                    li.setAttribute("class","item");

                    var img=document.createElement("img");
                    img.setAttribute("src",obj.img[i]);
                    img.style.width="200px";
                    img.style.height="200px";
                    //alert(obj.img[i]);
                    li.appendChild(img);
                    ul.appendChild(li);
                }
            }
            else
            {
                alert(obj.message);
            }

        });
    }  

</script>  
<script type="text/javascript">
    function sub(){
       
        // if(obj.event_name.value==""){
        //    alert("Event Name field can not be empty!");
        //    return false; 
        // }
        // if(obj.location.value==""){
        //    alert("Event Location field can not be empty!");
        //    return false; 
        // }
        // if(obj.description.value==""){
        //    alert("Event Description field can not be empty!");
        //    return false; 
        // }


        if(document.getElementById("EventName113").value ==""){
            alert("Event Name field can not be empty!");
            return false;
            }
            else if(document.all("EventLocation113").value == ""){
            alert("Event Location field can not be empty!");
            return false;
            }
            else if(document.all("EventDescription113").value == ""){
            alert("Event Description field can not be empty!");
            return false;
            }
            else{alert("Thanks for your submission!");
            window.setTimeout(submit(), 500);
            
            return true;
           
                    }
    }
    function submit(){
            window.location.href="event.php?id="+ {$_GET['id']};
    }


</script>
</head>

<body onload="ab()">
    <iframe src="header.php" style="display:block; position:fixed;z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>
    </br>
    </br>
    </br>
    </br>
<iframe id="iframe_display" name="iframe_display" style="display: none;"></iframe>
    <!-- submit2(this); -->
<form id="fff" method="POST" action="./eventback.php" enctype="multipart/form-data" target="iframe_display" onsubmit="return sub();">
<input type="hidden" name="id" value="{$_GET['id']}"/>
<input type="hidden" name="action" value="update">
    <div class="EventSettingSection">
        <img class="EditEventPgeOurLogo" src="images/logo.png" />
        <!--事件名字-->
        <div class="littleEventSettingSection">
            <label class="EventTexttip">Title:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label> <span><input id="EventName113" class="writelittleEventSection" name="event_name" type="text"></span>
        </div>

        <!--活动时间-->
        <div class="littleEventSettingSection">
            <label class="EventTexttip">Time:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label> <span><input id="EventTime113"  class="writelittleEventSection" name="time" type="datetime-local"/></span>
        </div>

        <!--活动地点-->
        <div class="littleEventSettingSection">
            <label class="EventTexttip">Location:&nbsp&nbsp&nbsp</label> <span><input id="EventLocation113" class="writelittleEventSection" name="location" type="text"></input></span>
        </div>

        <!--活动描述-->
        <div class="littleEventSettingSection">
            <label class="EventTexttip">Description:</label> <span><textarea id="EventDescription113" name="description" rows="3" cols="40"> </textarea></span>
        </div>

        <!--活动限制条件 Limitation-->
        <div class="littleEventSettingSection">
            <label class="EventTexttip">Limitation&nbsp; Please choose one of the following options:</label>
            <br/>
            <br/>
            <label>
                <input id="limitationA" class="radioLimitation" type="radio" name="limitation" value="1">Only society members are allowed to join the event</label>
            <br/>
            <label>
                <input  id="limitationB" class="radioLimitation" type="radio" name="limitation" value="2"> All students from XXX university can join the event</label>
            <br/>
            <label>
                <input  id="limitationC" class="radioLimitation" type="radio" name="limitation" value="3" checked="checked">No limitation to the target people</label>
        </div>

        <!--添加活动图片-->
        <p>
            <label>Choose a picture: </label>
            <input type="file" id="file" name="file" multiple="multiple" onchange="readAsDataURL()" />
        </p>
        <ul id="result" name="result"></ul>

        <!--保存按钮-->
        <div class="mt20 text-center">
            <input id="btnsave" class="SavebuttonEventPage" type="submit" value="Save"/>
            <!-- onclick="myclickForEventSettings()" -->
        </div>

    </div>
</form>

    </br>
    </br>
    <iframe src="bottom.html" style="display:block;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=270 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>


</body>



</html>
_END;

