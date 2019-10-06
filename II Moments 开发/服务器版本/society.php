<?php
    require_once 'functions.php';



    if(!isset($_GET['id']))
    {
        header('location:index.html');
    }
    else
    {
        $permission=false;
        if(isset($_SESSION['ID']))
        {
            $level_result=execMysql("SELECT user_level FROM association_touser 
                                WHERE chatroom_ID=? AND user_ID=?",
                                array($_GET['id'],$_SESSION['ID']),true);

            if($level_result->rowCount()!==0 && $level_result->fetch()['user_level']==2)
            {
                $permission=true;
            }
        }



        echo <<<_END
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Society</title>
    <link rel="icon" href="images/Favicon.png">
    <link rel="stylesheet" href="css/society/reset.css">
    <link rel="stylesheet" href="css/society/index.css">
    
</head>

<script>
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

    //document.getElementById('info').innerHTML =
    //sendAjax("./societyback.php","GET","id=1",function (obj)

        function a() {

        sendAjax("./societyback.php", "GET", "id={$_GET['id']}&action=search", function(obj) {
            //document.getElementById('info').innerHTML =obj.resultCode+" "+getHsonLength(obj);
            //document.getElementById("1");
            //document.getElementById('info').innerHTML =obj.img[0];
            //alert(getHsonLength(obj.poster_img));
            //alert(obj.poster_img[0]);
            
                if (getHsonLength(obj.poster_img) > 0 ) {
                    document.getElementById("11").src = obj.poster_img[0]["path"]; 
                    document.getElementById("16").href = obj.poster_img[0]["href"];
                    
                }
                if (getHsonLength(obj.poster_img) > 1 ) {
                    document.getElementById("12").src = obj.poster_img[1]["path"];
                    document.getElementById("17").href = obj.poster_img[1]["href"];
                }
                if (getHsonLength(obj.poster_img) > 2 ) {
                    document.getElementById("13").src = obj.poster_img[2]["path"];
                    document.getElementById("18").href = obj.poster_img[2]["href"];
                }
                if (getHsonLength(obj.poster_img) > 3 ) {
                    document.getElementById("14").src = obj.poster_img[3]["path"];
                    document.getElementById("19").href = obj.poster_img[3]["href"];
                } 
                if (getHsonLength(obj.poster_img) > 4 ) {   
                    document.getElementById("15").src = obj.poster_img[4]["path"];
                    document.getElementById("10").href = obj.poster_img[4]["href"];
                }  


                document.getElementById("103").innerHTML = obj.description; 
                document.getElementById("101").innerHTML = obj.contact; 
                document.getElementById("102").innerHTML = obj.address; 
                
                
              var ul3 = document.getElementById("3");
                var length = 4
                 
                if(getHsonLength(obj.events)<5){
                    length = getHsonLength(obj.events)-1 ;
                }
                for (var i = 0; i <= length; i++) {
                var li3 = document.createElement("li");
                li3.setAttribute("class", "item");
               
                var a3 = document.createElement("a");
                a3.setAttribute("href", obj.events[i]["href"]);
                a3.setAttribute("class", "pic");

                var img3 = document.createElement("img");
                img3.setAttribute("src",obj.events[i]["pictHeader"]);
                img3.setAttribute("onerror","this.src='images/logo.png'");

                var div3 = document.createElement("div");
                div3.setAttribute("class", "info");

                 var a32 = document.createElement("a");
                 a32.setAttribute("href", obj.events[i]["href"]);
                 a32.setAttribute("class", "title");
                 a32.innerHTML = obj.events[i]["title"];

                 var span3 = document.createElement("span");
                 span3.innerHTML = obj.events[i]["number"];

                 var a33 = document.createElement("p");
                 a33.setAttribute("href", obj.events[i]["href"]);
                 a33.setAttribute("class", "icon-text__pink purchase");
                 a33.innerHTML = "Join";

                div3.appendChild(a32);
                div3.appendChild(span3);
                div3.appendChild(a33);
                a3.appendChild(img3);
                li3.appendChild(a3);
                li3.appendChild(div3);
                ul3.appendChild(li3);

            
            }

            //alert(getHsonLength(obj.members));

          var ul4 = document.getElementById("4");
                var length = 4
                if(getHsonLength(obj.members)<5){
                    length = getHsonLength(obj.members)-1 ;
                }
                for (var i = 0; i <= length; i++) {
                var li4 = document.createElement("li");
                li4.setAttribute("class", "item");
               
                var a4 = document.createElement("a");
                a4.setAttribute("href", obj.members[i]["href"]);
                a4.setAttribute("class", "pic");
               
                var img4 = document.createElement("img");
                img4.setAttribute("style", "height:120px; width:220px");
                img4.setAttribute("src",obj.members[i]["background"]);
                img4.setAttribute("onerror","this.src='images/logo.png'");

                var a42 = document.createElement("a");
                a42.setAttribute("href", obj.members[i]["href"]);
                a42.setAttribute("class", "headImg");
                
                var img42 = document.createElement("img");
                img42.setAttribute("src",obj.members[i]["header"]);
                img42.setAttribute("onerror","this.src='images/logo.png'");

                var div4 = document.createElement("div");
                div4.setAttribute("class", "info");

                var a43 = document.createElement("a");
                a43.setAttribute("href", obj.members[i]["href"]);
                a43.setAttribute("class", "info-title");
                a43.innerHTML = obj.members[i]["name"];

                var p4 = document.createElement("p");
                p4.innerHTML = '<i class="icon-star"></i>9645</p> <p>Level: <b>3⭐</b>';

                div4.appendChild(a43);
                div4.appendChild(p4);
                a42.appendChild(img42);
                a4.appendChild(img4);
                li4.appendChild(a4);
                li4.appendChild(a42);
                li4.appendChild(div4);
                ul4.appendChild(li4);

               

            }

    
            }
            );
    }
	function join() {

		sendAjax("./societyback.php", "POST", "id={$_GET['id']}&action=join", function(obj) {

			alert(obj.message);

        }
        );
  	}

  	function create(){

  		sendAjax("./eventback.php", "POST", "asso={$_GET['id']}&action=create", function(obj) {

  		    alert(obj.message);

  			if(obj.resultCode==200){
  				

  				window.location.href="eventsetting.php?id=" + obj.eventID;
             
               
  			}

        }
        );

  	}


</script>

<body onload="a();">
    
    <iframe src="header.php" style="display:block; position:fixed;z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>
    </br>
    </br>
    </br>
    </br>

    <div class="main">
        <div class="main-inner body-width">
            <div class="banner clearfix">
                <div class="slider" id="slider">
                    <ul class="slider-wrapper" >
                        <li class="item" data-title="Test Title" data-author="Test Auther">
                            <a id="16" href="#" class="pic"><img id="11" src="upload/test1.jpg"></a>
                        </li>
                        <li class="item" data-title="Test Title" data-author="Test Auther">
                            <a id="17" href="#" class="pic"><img id="12" src="upload/test2.jpg"></a>
                        </li>
                        <li class="item" data-title="Test Title" data-author="Test Auther">
                            <a id="18" href="#" class="pic"><img id="13" src="upload/test3.jpg"></a>
                        </li>
                        <li class="item" data-title="Test Title" data-author="Test Auther">
                            <a id="19" href="#" class="pic"><img id="14" src="upload/test4.jpg"></a>
                        </li>
                        <li class="item" data-title="Test Title" data-author="Test Auther">
                            <a id="10" href="#" class="pic"><img id="15" src="upload/test1.jpg"></a>
                        </li>

                    </ul>
                    <a href="javascript:;" class="slider-prev"></a>
                    <a href="javascript:;" class="slider-next"></a>

                    <div class="slider-title">
                        <h2></h2>
                        <span></span>
                    </div>

                    <div class="slider-btns">
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                        <span class="item"></span>
                    </div>
                </div>

                <!-- chatbox -->
                <div>
                    <iframe id="chatbox" src="chatroom.php?id={$_GET['id']}" style="display:block; " frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=470 height=550 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>

                </div>

            </div>
   

            </br>

            <div class=functionbuttons>

_END;

        if($permission)
        {
            echo <<<_END
                <a href="societysetting.php?id={$_GET['id']}"><div class="submit">
                    <input type="submit" value="Edit">
                </div></a>
_END;
        }


        echo <<<_END
                <a onclick="join()"><div class="submit">
                    <input type="submit" value="Join it" id="joinit">
                </div></a>>
_END;

        if($permission)
        {
            echo <<<_END

                <a onclick="create()"> <div class="submit">
                    <input type="submit" value="Create a event" ></input>
                </div></a>
_END;
        }


        echo <<<_END
                <div class="clear"> </div>

                
            </div>

            <div class="SocietyDescription">
                <a class="SoDesForm1" href="#" onload="hiddenInform()" onmouseover="showInform()" onmouseout="hiddenInform()" class="icon-text__pink register"> Details </a>
                <div id="inform" class="SoDesForm2" style="display:none";>
                     <p >Description : </p><p id="103">11111</p>
                    
                     <p >Contact number : </p><p id="101" >2222</p>
                    
                    <p >Adress :</p>  <p id="102">3333</p>
                    
                </div>

            </div>

            
            <div class="main-cont main-recommend">
                <div class="main-cont__title">
                    <h3>Events</h3>
                    <p class="list">
                        <em>Rank：</em>
                        <a href="#">Hottest</a>
                        <span>|</span>
                        <a href="#">time</a>
                        <span>|</span>
                        <a href="#">aaa</a>

                    </p>
                </div>
<!-- events -->
                <ul class="main-cont__list clearfix" id="3">
                    <!--<li class="item">
                        <a href="event.html" class="pic">
                            <img src="upload/test2.jpg"></a>
                        <div class="info">
                            <a href="event.html" class="title">Test EVENT</a>
                            <span>Arts</span>
                            <a href="event.html" class="icon-text__pink purchase">Join</a>
                        </div>
                    </li>-->
                 
                </ul>
            </div>

           
            <div class="main-cont main-user">
                <div class="main-cont__title">
                    <h3>Members</h3>
                    <a href="#" class="more">More ></a>
                </div>
<!-- members -->
                <ul class="main-cont__list clearfix" id="4">
                    <!--<li class="item">
                        <a href="#" class="pic">
                            <img style="height:120px; width:220px" src="upload/test3.jpg" >
                        </a>
                        <a href="#" class="headImg"><img src="upload/test4.jpg"></a>
                        <div class="info">
                            <a href="#" class="info-title">Test user</a>
                            <p><i class="icon-star"></i>9645</p>
                            <p>Level: <b>3⭐</b></p>
                        </div>
                    </li>-->
                    
                </ul>
            </div>

           
        </div>
        </br>
        </br>
       
        
    </div>
    <script type="text/javascript">
    function showInform() {
        document.getElementById("inform").style.display = 'block';
    }

    function hiddenInform() {
        document.getElementById("inform").style.display = "none";
    }
    </script>
    <script type="text/javascript" src="" id="societyjs"></script>

    <script src="js/society/jquery.min.js"></script>
    <script src="js/society/script.js"></script>

    <iframe src="bottom.html" style="display:block;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=270 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>

</body>

</html>
_END;

    }
