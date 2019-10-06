<?php
    require_once 'functions.php';

    if(!isset($_GET['id']))
    {
        header('location:index.html');
    }
    else
    {
        echo <<<_END
<!DOCTYPE html>
<html>
<head>
<title>Event</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="images/Favicon.png" >
<link rel="stylesheet" type="text/css" href="css/events/EventPagePage.css">
<script type="text/javascript" src="js/events/demo.js"></script>
</head>
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
                        //document.getElementById('info').innerHTML =String(this.responseText);
                        //fnSucc(this.responseText);
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

    function ab(){
    sendAjax("./eventback.php","GET","id={$_GET['id']}",function(obj)
    {
        document.getElementById("eventmainName").innerText=obj.name;
        document.getElementById("eventmaintime").innerHTML=obj.date;
        document.getElementById("eventmainplace").innerHTML=obj.location;
        document.getElementById("eventmaindescription").innerHTML=obj.description;

        if(obj.limitation=="1")
        {
           document.getElementById("eventmainlimitation").innerText="Only society members are allowed to join the event";
        }else if(obj.limitation=="2")
        {
            document.getElementById("eventmainlimitation").innerHTML="<p>All students from UoL can join the event</p>";
        }else
        {
            document.getElementById("eventmainlimitation").innerText="No limitation to the target people";
        }

        var photoshowww=document.getElementById("photoshow");
        for(var i=0;i<=getHsonLength(obj.img)-1;i++)
        {
            var photo=document.createElement("img");
            photo.setAttribute("class","eventpictureshow");
            photo.setAttribute("src",obj.img[i]);
            photoshowww.appendChild(photo);
        }

        var div0 = document.getElementById("list");
          
        for (var j = 0; j <= getHsonLength(obj.comment) - 1; j++)
        {

            var div = document.createElement("div");
            div.setAttribute("class", "box clearfix");

            var a = document.createElement("a");
            a.setAttribute("class", "close");
            a.setAttribute("href", "javascript:;");
            a.innerHTML = "x";

            var img = document.createElement("img");
            img.setAttribute("class","head");
            img.setAttribute("src",obj.comment[j]["header"]);

            var div2 = document.createElement("div");
            div2.setAttribute("class", "content");

            var div3 = document.createElement("div");
            div3.setAttribute("class", "main");

            var span = document.createElement("span");
            span.setAttribute("class", "user");
            span.innerHTML = obj.comment[j]["displayname"];

            var p = document.createElement("p");
            p.setAttribute("class", "txt");
            p.innerHTML = obj.comment[j]["content"];

            var img2 = document.createElement("img");
            img2.setAttribute("class","pic");
            img2.setAttribute("src",obj.comment[j]["header"]);

            var div4 = document.createElement("div");
            div4.setAttribute("class", "info clearfix");
            div4.innerHTML = '<span class="time">02-14 23:01</span> <a class="praise" href="javascript:;">Like</a>';

            var div5 = document.createElement("div");
            div5.setAttribute("class", "praises-total");
            div5.setAttribute("total", "4");
            div5.setAttribute("style", "display: block;");
            div5.innerHTML = "4 People Like";

            var div6 = document.createElement("div");
            div6.setAttribute("class", "comment-list");

            var div7 = document.createElement("div");
            div7.setAttribute("class", "comment-box clearfix");
            div7.setAttribute("user", "self");

            var img3 = document.createElement("img");
            img3.setAttribute("class","myhead");
            img3.setAttribute("src",obj.comment[j]["header"]);

            var div8 = document.createElement("div");
            div8.setAttribute("class", "comment-content");
            div8.innerHTML = '<p class="comment-text"><span class="user">Me：</span>Gooooood....</p>   <p class="comment-time">     2014-02-19 14:36                           <a href="javascript:;" class="comment-praise" total="1" my="0" style="display: inline-block">1 Likes</a>                     <a href="javascript:;" class="comment-operate"> Delete</a>          </p>';

            var div9 = document.createElement("div");
            div9.setAttribute("class", "text-box");
            div9.innerHTML = '<textarea class="comment" autocomplete="off">Say something…</textarea>                    <button class="btn ">Reply</button>                    <span class="word"><span class="length">0</span>/140</span>';



            div0.appendChild(div);
            div.appendChild(a);
            div.appendChild(img);
            div.appendChild(div2);
            div2.appendChild(div3);
            div3.appendChild(span);
            div3.appendChild(p);
            div3.appendChild(img2);
            div2.appendChild(div4);
            div2.appendChild(div5);
            div2.appendChild(div6);
            div6.appendChild(div7);
            div7.appendChild(img3);
            div7.appendChild(div8);
            div2.appendChild(div9);

           }

        });

    }
    
   
</script>

<script type="text/javascript">
    function ss() {
        sendAjax("./eventback.php","POST","id={$_GET['id']}&action=join",function(obj){
                if(obj.resultCode==200){
                    alert("join the event successfully");
                }else if(obj.resultCode==404){
                    alert("fail to join the event, please join again");
                    alert(obj.message);
                }
            }
        );

    }
</script>

<body onload="ab()">

<iframe src="header.php" style="display:block; position:fixed;z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100%  height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe> </br></br></br></br></br>
<input type="hidden" name="id" value="1"></input>
<iframe id="iframe_display" name="iframe_display" style="display: none;"></iframe>
  <div class="TotalEventPagePage">
	<p class="EventPAGENAME" id="eventmainName">EVENT NAME</p><!--<a href="EventSetting.html"> <img src="images/events/edit.png" height=2% width=2% /> </a>-->
	<div class="Eventdisplay">
		<marquee id="photoshow" class="Eventpicturedisplayyyyy" scrollamount="15" scrolldelay="0" direction= "right" width="600" height="450" hspace="5" >
<!--         <img class="eventpictureshow" src="upload/ssociety/society_3/3 (2).jpg" />
		<img class="eventpictureshow" src="upload/society/society_3/event2/5.jpg" /> -->
    	</marquee>



	<div class="EventTextdisplayyyyy">
		<p class="EventContentTitle">Time</p>
		<p class="EventContentAnswer" id="eventmaintime"></p>
		<p class="EventContentTitle">Location</p>
	    <p class="EventContentAnswer" id="eventmainplace"></p>
        <p class="EventContentTitle">Limitation</p>
        <p class="EventContentAnswer" id="eventmainlimitation"></p>
		<p class="EventContentTitle">Description</p>
	    <p class="EventContentAnswer" id="eventmaindescription"></p>

    <!--<form method="POST" action="./eventback.php" enctype="multipart/form-data" target="iframe_display" >-->
        <div class="PageRegisterEvent">
	        <input onclick="ss()"  target="iframe_display" class="PageRegisterEventButton"  value="Register" id="EVENTButton1" ></input>
        </div>
_END;
        //检测该用户是否管理员
        if(isset($_SESSION['ID']))
        {
            $asso_result=execMysql("SELECT asso_ID FROM event WHERE event_ID=?",array($_GET['id']),true);
            $assoID=$asso_result->fetch()['asso_ID'];

            $check_result=execMysql("SELECT user_level FROM association_touser 
                                        WHERE user_ID=? AND chatroom_ID=?",
                                    array($_SESSION['ID'],$assoID),true);

            if($check_result->rowCount()!==0 && $check_result->fetch()['user_level']===2)
            {
                echo <<<_END
            <div class="PageRegisterEvent">
                <a id=2 href= "eventsetting.php?id={$_GET['id']}" class="PageEditEventButton">Edit</a>
            </div>
_END;
            }
        }



        echo <<<_END
	</div>
	</div>

  <p class="EventPAGEYOUMAYLIKE">Events You Might Like</p>
  <div class="EventPAGEYOUMAYLIKESection" id="eventlikesec">
        <!--<a href="#">
                 <div class="boxeven1">
                <img src="upload/society/society_3/event2/3.jpg" alt="">
                <div class="boxeven1-content">
                    <h3 class="titleeven1">Event 1</h3>
                    <span class="posteven1">Time   Location</span>
                </div>
            </div></a>

        <a href="#">
                 <div class="boxeven1">
                <img src="upload/society/society_3/event2/4.jpg" alt="">
                <div class="boxeven1-content">
                    <h3 class="titleeven1">Event 2</h3>
                    <span class="posteven1">Time   Location</span>
                </div>
            </div></a>

        <a href="#">
                 <div class="boxeven1">
                <img src="upload/society/society_3/event2/5.jpg" alt="">
                <div class="boxeven1-content">
                    <h3 class="titleeven1">Event 3</h3>
                    <span class="posteven1">Time   Location</span>
                </div>
            </div></a>-->
    </div>

<!--评论区域 和朋友圈的一致-->
	<p class="EventPAGEYOUMAYLIKE" id="eventlikesec1">Comments</p>
	<div class="EventCommentSectionSection">
         <div class="clear"> </div>
    <div id="list">

        <div class="box clearfix" id="boxclearfix113">
            <a class="close" id="commentaaa" href="javascript:;">×</a>
            <img class="head" id="commenthead" src="images/logo.png" alt=""/>
            <div class="content" id="content113">
                <div class="main" id="main113">
                    <p class="txt" id="txt113">
                        <span class="user" id="commentname113">Andy：</span>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                    </p>
                </div>
                <div class="info clearfix" id="div11133">
                    <span class="time" id="commenttime113">02-14 23:01</span>
                    <a class="praise" href="javascript:;">Like</a>
                </div>
                <div class="praises-total" total="4" style="display: block;">4 people like the idea</div>
                <div class="comment-list">
                    <div class="comment-box clearfix" user="self">
                        <img class="myhead" src="images/logo.png" alt=""/>
                        <div class="comment-content">
                            <p class="comment-text"><span class="user">Me：</span>Love it</p>
                            <p class="comment-time">
                                2014-02-19 14:36
                                <a href="javascript:;" class="comment-praise" total="1" my="0" style="display: inline-block">1 Like</a>
                                <a href="javascript:;" class="comment-operate">Delete</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="text-box">
                    <textarea class="comment" autocomplete="off">Comment…</textarea>
                    <button class="btn ">Reply</button>
                    <span class="word"><span class="length">0</span>/140</span>
                </div>
            </div>
        </div>



<!--         <div class="box clearfix">
            <a class="close" href="javascript:;">×</a>
            <img class="head" src="upload/society/society_3/event2/5.jpg" alt=""/>
            <div class="content">
                <div class="main">
                    <p class="txt">
                        <span class="user">Y：</span>what
                    </p>
                </div>
                <div class="info clearfix">
                    <span class="time">02-11 13:17</span>
                    <a class="praise" href="javascript:;">赞</a>
                </div>
                <div class="praises-total" total="0" style="display: none;"></div>
                <div class="comment-list">

                </div>
                <div class="text-box">
                    <textarea class="comment" autocomplete="off">comments…</textarea>
                    <button class="btn ">reply</button>
                    <span class="word"><span class="length">0</span>/140</span>
                </div>
            </div>
        </div> -->
    </div> 
     <div class="clear"> </div>
  </div>
</div>	


    </br></br></br></br>
    <iframe src="bottom.html" style="display:block;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100%  height=270 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>
</body>

</html>
_END;

    }
