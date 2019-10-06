<?php
    require_once 'functions.php';

    if(!isset($_SESSION['ID']))
    {
        header('location:login.php');
    }
    else {
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
                       // alert(this.responseText)
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

        sendAjax("./my2.php", "GET", "my=societies", function(obj) {
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
                var ul =  document.getElementById("list");

                for (var ii = 0; ii <= getHsonLength(obj.societyname) - 1; ii++) {
                        var li = document.createElement("li");

                        var div = document.createElement("div");
                        div.setAttribute("class", "mh-item");

                        var a = document.createElement("a");
                        a.setAttribute("class", "mh-cover");
                        a.setAttribute("href", obj.societylink[ii]);
                        a.setAttribute("title", obj.societyname[ii]);
                        a.setAttribute("style","background-image: url('"+obj.societypic[ii]+"')");

                        var span2 = document.createElement("span");
                        span2.setAttribute("href", "#mh-id=123123");
                        span2.setAttribute("reg-id", "432");
                        span2.setAttribute("class", "edit-state");

                        var i = document.createElement("i");
                        i.setAttribute("class", "icon icon-ok");

                        var div2 = document.createElement("div");
                        div2.setAttribute("class", "mh-item-detali");

                        var h2 = document.createElement("h2");
                        h2.setAttribute("class", "title");
                        h2.setAttribute("style", "overflow: hidden;text-overflow: ellipsis;white-space: nowrap;");

                        var a2 = document.createElement("a");
                        a2.setAttribute("title",  obj.societyname[ii]);
                        a2.setAttribute("href", obj.societylink[ii]);
                        a2.innerHTML= obj.societyname[ii];

                        ul.appendChild(li);
                        li.appendChild(div);
                        div.appendChild(a);
                        a.appendChild(span2);
                        span2.appendChild(i);
                        div.appendChild(div2);
                        div2.appendChild(h2);
                        h2.appendChild(a2);

                }
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
                window.location.href="societysetting.php?id=" + obj.association_ID;
            }
        );
    }
</script>
<body onload="a()">
	
    <!-- 页面头部 -->
   <iframe src="header.php" style="display:block; position:absolute;    left: 0px;  top: 0px;  z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100%  height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>

    <main class="container mt30 mb20 overflow-Show clearfix" style="min-height:750px;">
        <aside class="user-sidebar pull-left">
            <section class="user-info" id="1">
                <div class="avatar" id="4">

                </div>
                <h1 style="text-align: left;" id="5"> <span style="width:120px;margin:0 0 0 50px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;line-height: initial;" id="2"> </span> <a href="./userinfo.php"><i class="icon icon-edit"  style="cursor:pointer"> </i> </a></h1>
                <p style="text-align: center;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; line-height: initial;" id="3"></p>
            </section>
            <ul class="user-menu">

                <li> <a class="active" href="usersociety.php"> <i class="icon icon-cat"></i><span>SOCIETIES</span></a></li>
                <li> <a href="userevent.php"><i class="icon icon-date"></i><span>EVENTS</span> </a> </li>
                <li> <a id="hi" onclick="hi(this)" href=""   ><i class="icon icon-fav" ></i><span>CREATE SOCIETY </span> </a> </li>

                <li> <a href="moments.php" ><i class="icon icon-imgup"></i><span>MOMENTS</span></a> </li>
                <li> <a href="userinfo.php" ><i class="icon icon-lamp"></i><span>INFORMATION</span></a></li>
                <li> <a href="changepassword.php"><i class="icon icon-lock"></i><span>SETTING</span></a> </li>

            </ul>
        </aside>

        <article class="article-main pull-right">
            <section class="box">
                <header class="box-header">
                    <h1><span>MY SOCIETIES</span></h1>

                    <div class="pull-right">
                        <a href="usersociety.php" class="more js_edit_booklist_btn"><i class="icon icon-box mr5"></i>Manage my societies</a>
                        <div href="#" class="box-booklist-edit-head" style="display: none">
                            <form>
                                <span>已选<span class="color-main js_count_num">0</span></span>
                                <span><label><input class="js_allsel_checkbox" type="checkbox" value="" />全选</label></span>
                                <span><button id="book_del" type="button" class="del-btn">删除</button></span>
                                <span><button type="button" class="finish-btn js_esc_booklist_btn">完成</button></span>
                                <input id="ids" name="ids" type="hidden" />
                                <input name="uid" type="hidden" value="278694511" />
                            </form>
                        </div>
                    </div>
                </header>

                <div class="box-body">
                    <div class="bg-gray box-sub-head clearfix">
                    </div>
                    <div class="mt20">
                        <ul class="mh-list col7" id="list">

                        </ul>
                    </div>
                </div>
                <footer class="mt20">
                    <div class="page-pagination pull-right mt20">
                        <ul>
                        </ul>
                    </div>
                </footer>
            </section>
        </article>

        <input id="hidCount" type="hidden" value="2" />
    </main>

   
    <div class="alertTop_1" style=>
        <p id="alertTop_1"></p>
    </div>
    <div style=>
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

        
    </div>
</body>

</html>
_END;
    }
?>

