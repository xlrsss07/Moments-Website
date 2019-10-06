<?php
    require_once 'functions.php';

    if(!isset($_SESSION['ID']))
    {
        header('location:login.php');
    }

    echo <<<_END
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Personal Information </title>
    <link rel="icon" href="images/Favicon.png">
    <link rel="stylesheet" href="http://css122us.cdndm5.com/v201904041843/dm5/css/style.css">
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
                      //  alert(this.responseText)
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

    function a() {

        sendAjax("./my3.php", "GET", "my=information", function(obj) {
//user information
                var session = document.getElementById("1");
                session.setAttribute("class", "user-info");

                var h1= document.getElementById("5");

                var span = document.getElementById("2");
                span.innerHTML = obj.username;

                var p = document.getElementById("3");
                p.innerHTML=obj.signature;

                var div = document.getElementById("4");
                div.setAttribute("class", "avatar");

                var img = document.createElement("img");
                img.setAttribute("src",obj.user);
                img.setAttribute("alt","");


                div.appendChild(img);
                h1.appendChild(span);
                session.appendChild(div);
                session.appendChild(h1);
                session.appendChild(p);

                //开始写修改信息部分

                var img2 =  document.getElementById("header");
                img2.setAttribute("src",obj.user);

                var text =  document.getElementById("text");
                text.innerHTML=obj.signature;

                var email=  document.getElementById("email");
                email.setAttribute("value",obj.user_email);

                var address= document.getElementById("address");
                address.setAttribute("value",obj.useraddress);
            }
        );
    }
</script>

<script type="text/javascript">
    function hi(obj)
    {
        sendAjax("./societyback.php", "POST", "action=create", function(obj) {
                // alert("hi2");
                //  alert(obj.association_ID);
                // var hi = document.getElementById("hi");
                // hi.href="societysetting.html?a="+obj.association_ID;
                window.location.href="societysetting.php?id=" + obj.association_ID;
                
            }
        );
    }
</script>
<body class="white" onload="a()">
    
    <!-- 页面头部 -->
   <iframe src="header.php" style="display:block; position:absolute;    left: 0px;  top: 0px;  z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100%  height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>

    <main class="container mt30 mb20 overflow-Show clearfix" style="min-height:750px;">
        <aside class="user-sidebar pull-left">
            <section class="user-info" id="1">
                <div class="avatar" id="4">

                </div>
                <h1 style="text-align: left;" id="5"> <span style="width:120px;margin:0 0 0 50px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;line-height: initial;" id="2"> </span> <a href="userinfo.php"><i class="icon icon-edit"  style="cursor:pointer"> </i> </a></h1>
                <p style="text-align: center;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; line-height: initial;" id="3"></p>
            </section>
            <ul class="user-menu">

                <li> <a href="usersociety.php"> <i class="icon icon-cat"></i><span>SOCIETIES</span></a></li>
                <li> <a href="userevent.php"><i class="icon icon-date"></i><span>EVENTS</span> </a> </li>
                <li> <a id="hi" onclick="hi(this)" href=""   ><i class="icon icon-fav" ></i><span>CREATE SOCIETY </span> </a> </li>

                <li> <a href="moments.php" ><i class="icon icon-imgup"></i><span>MOMENTS</span></a> </li>
                <li> <a class="active" href="userinfo.php" ><i class="icon icon-lamp"></i><span>INFORMATION</span></a></li>
                <li> <a href="changepassword.php"><i class="icon icon-lock"></i><span>SETTING</span></a> </li>
               
            </ul>
        </aside>

        <article class="article-main pull-right">
            <section class="box-userinfo box ">
                <header class="box-header ">MY INFORMATION</span></h1> </header>
                <div class="box-body">
                    <form method="POST" action="my3.php" class="user-info-form mt20" novalidate="novalidate" enctype="multipart/form-data">
                       
                        <div class="avatar-wrap">
                            <label>Avatar </label> 
                            <span class="avatar-demo js_input_wrap">                            
                                <img id="header" class="" src="" alt="">
                                <input type="hidden" name="avatar_canvas" value="">                            
                                <input class="inputImage" type="file" id="inputImage" name="avatar_file" placeholder="Avatar" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">                            
                                <!--<label for="inputImage" class="ml10 upfile-btn btn">New</label>-->
                                <label>New Picture:</label>
                                <input type="file" id="file" name="file" multiple="multiple" onchange="readAsDataURL()" />

                                <!--<span class="upfile-text-tip">support:jpg、bmp、png, no larger than 1MB</span> -->
                            </span>
                            <div class="avatar-edit-wrap">
                                <div class="avatar-edit pull-left">
                                    <div>
                                        <canvas id="canvas"></canvas>
                                    </div>
                                    <p class="upfile-text-tip">Crop it</p>
                                    <label for="inputImage" class="btn upfile-btn">Upload again</label>
                                </div>
                                <div class="preview-wrap pull-left"> <span>Preview</span> <span><img class="js_avatar_img" src="./myinformation/catcat.jpg" alt=""></span> </div>
                            </div>
                        </div>
                        <!--<div>-->
                            <!--<label>Name </label> <span><input name="name" type="text" value="" id="name"></span> </div>-->

                        <div>
                            <label>Signature</label> <span><textarea name="signature" id="text"></textarea></span> </div>
                        
                        <div>
                            <label>Email</label> <span><input name="email" type="text" value="" id="email"></span> </div>
                        <div>
                            <label>Address</label> <span><input name="address" type="text" value="" id="address"></span> </div>
                        <hr>
                        <div class="mt20 text-center">
                            <input class="save-btn btn" type="submit" name="submit" value="SAVE">
                            <!--<button id="btnsave" class="save-btn btn" type="button">Save</button>-->
                        </div>
                    </form>
                </div>
            </section>
        </article>
    </main>
   
 
    <div class="alertTop_1" style="display: none;">
        <p id="alertTop_1"></p>
    </div>
    <div style="display:none">
        <script type="text/javascript">
            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + "w.cnzz.com/c.php?id=30089965";
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <!--谷歌全站统计-->
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-495269-1']);
            _gaq.push(['_setDomainName', 'none']);
            _gaq.push(['_setAllowLinker', true]);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <script type="text/javascript">
            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + "w.cnzz.com/c.php?id=30090267";
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </div>
    
    
</body>
</html>
_END;
