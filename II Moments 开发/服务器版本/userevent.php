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
        var request = new ajaxRequest();
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

        sendAjax("./my2.php", "GET", "my=event", function(obj) {
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

                for (var ii = 0; ii <= getHsonLength(obj.eventname) - 1; ii++) {

                    var li = document.createElement("li");

                    var div = document.createElement("div");
                    div.setAttribute("class", "mh-item");

                    var a = document.createElement("a");
                    a.setAttribute("class", "mh-cover");
                    a.setAttribute("href", obj.eventlink[ii]);
                    a.setAttribute("title", obj.eventname[ii]);
                    a.setAttribute("style","background-image: url('"+obj.eventpic[ii]+"')");


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
                    a2.setAttribute("title",  obj.eventname[ii]);
                    a2.setAttribute("href", obj.eventlink[ii]);
                    a2.innerHTML= obj.eventname[ii];
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
                <li> <a class="active" href="userevent.php"><i class="icon icon-date"></i><span>EVENTS</span> </a> </li>
                <li> <a id="hi" onclick="hi(this)" href=""   ><i class="icon icon-fav" ></i><span>CREATE SOCIETY </span> </a> </li>

                <li> <a href="moments.php" ><i class="icon icon-imgup"></i><span>MOMENTS</span></a> </li>
                <li> <a href="userinfo.php" ><i class="icon icon-lamp"></i><span>INFORMATION</span></a></li>
                <li> <a href="changepassword.php"><i class="icon icon-lock"></i><span>SETTING</span></a> </li>
                
            </ul>
        </aside>

        <article class="article-main pull-right">
            <section class="box">
                <header class="box-header">
                    <h1><span>MY EVENTS</span></h1>

                    <div class="pull-right">
                        <a href="userevent.php" class="more js_edit_booklist_btn"><i class="icon icon-box mr5"></i>Manage my events</a>
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
    <script src="myinformation/yqdmlist.js.download">
    </script>
    <script src="myinformation/user-booklist.js.download">
    </script>
    <script type="text/javascript">
        var yqdm = new YingdmList({
            action: 'getmorebookmarkers',
            itemname: 'items',
            element: '.box-body .mh-list',
            pager: '.page-pagination ul',
            params: {
                pageindex: 1,
                pagesize: 50,
                sort: 1,
                title: ''
            }
        });
        yqdm.oldparams = $.extend({
            action: yqdm.action
        }, yqdm.oldparams, yqdm.params);
        YingdmList.prototype.getrequesturl = function() {
            var url = '/bookmarker';
            if (this.params) {
                if (this.params.pageindex > 0) {
                    url += '-p' + this.params.pageindex + '/';
                }
                if ($.trim(this.params.title || '') !== '') {
                    url += '?title=' + encodeURIComponent(this.params.title);
                }
                if (this.params.sort > 0) {
                    url += (url.indexOf('?') === -1 ? '?' : '&') + 'sort=' + this.params.sort;
                }
            } else {
                url += '/';
            }
            return url;
        };
    </script>
</body>

</html>
_END;

