<?php
    echo <<<_END
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Moments</title>
    <link rel="icon" href="images/Favicon.png">
    <link rel="stylesheet" href="css/moments/index.css">
    <link rel="stylesheet" href="css/moments/moments.css">
    <script type="text/javascript" src="js/request.js"></script>
    <script type="text/javascript" src="js/moments/demo.js"></script>

</head>
<script>
    function a() {

        sendAjax("./momentsback.php", "GET", "action=search", function(obj) {

            var div0 = document.getElementById("list");

            for (var j = 0; j <= getHsonLength(obj.moments) - 1; j++) {

                var div = document.createElement("div");
                div.setAttribute("class", "box clearfix");

                var a = document.createElement("a");
                a.setAttribute("class", "close");
                a.setAttribute("href", "javascript:;");
                a.innerHTML = "x";

                var img = document.createElement("img");
                img.setAttribute("class", "head");
                img.setAttribute("src", obj.moments[j]["header"]);

                var div2 = document.createElement("div");
                div2.setAttribute("class", "content");

                var div3 = document.createElement("div");
                div3.setAttribute("class", "main");

                var span = document.createElement("span");
                span.setAttribute("class", "user");
                span.innerHTML = obj.moments[j]["displayname"];

                var p = document.createElement("p");
                p.setAttribute("class", "txt");
                p.innerHTML = obj.moments[j]["content"];

                var img2 = document.createElement("img");
                img2.setAttribute("class", "pic");
                img2.setAttribute("src", obj.moments[j]["img"][0]);

                var div4 = document.createElement("div");
                div4.setAttribute("class", "info clearfix");
                div4.innerHTML = '<span class="time">'+obj.moments[j]['time']+'</span> <a class="praise" href="javascript:;">Like</a>';

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
                img3.setAttribute("class", "myhead");
                img3.setAttribute("src", obj.moments[j]["header"]);

                var div8 = document.createElement("div");
                div8.setAttribute("class", "comment-content");
                div8.innerHTML = '<p class="comment-text"><span class="user">Me：</span>Gooooood....</p>   <p class="comment-time">     2019-05-01 14:36                           <a href="javascript:;" class="comment-praise" total="1" my="0" style="display: inline-block">1 Likes</a>                     <a href="javascript:;" class="comment-operate"> Delete</a>          </p>';

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

        var theHead = document.getElementsByTagName('head').item(0);
        var myScript = document.createElement('script');
        myScript.src = 'js/moments/demo.js';
        myScript.type = 'text/javascript';
        myScript.defer = true;
        theHead.appendChild(myScript);

    }
</script>

<body>

    <iframe src="header.php" style="display:block; position:fixed;z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>
    </br>
    </br>
    </br>
    </br>

    <div class="postmoments"><a href="momentssetting.php">Post  My Moments</a></div>

    <div id="list">

        <!--<div class="box clearfix">
            <a class="close" href="javascript:;">×</a>
            <img class="head" src="upload/test1.jpg" />
            <div class="content">
                <div class="main">
                    <span class="user">Andy：</span>
                    <p class="txt">
                        轻轻的Me走了，正如Me轻轻的来；Me轻轻的招手，作别西天的云彩。
                    </p>
                    <img class="pic" src="upload/test4.jpg" />

                </div>
                <div class="info clearfix">
                    <span class="time">02-14 23:01</span>
                    <a class="praise" href="javascript:;">Like</a>
                </div>
                <div class="praises-total" total="4" style="display: block;">4 People Like
                </div>
                <div class="comment-list">
                    <div class="comment-box clearfix" user="self">
                        <img class="myhead" src="upload/test3.jpg" />
                        <div class="comment-content">
                            <p class="comment-text"><span class="user">Me：</span>Gooooood....</p>
                            <p class="comment-time">
                                2014-02-19 14:36
                                <a href="javascript:;" class="comment-praise" total="1" my="0" style="display: inline-block">1 Likes</a>
                                <a href="javascript:;" class="comment-operate"> Delete</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="text-box">
                    <textarea class="comment" autocomplete="off">Say something…</textarea>
                    <button class="btn ">Reply</button>
                    <span class="word"><span class="length">0</span>/140</span>
                </div>
            </div>
        </div>-->

    </div>

    </br>
    </br>
    <div class="loadMore" onclick="a()"><a href="#">Load ></a></div>
    <script>
        a()
    </script>

    </br>
    </br>
    </br>
    </br>
    <iframe src="bottom.html" style="display:block;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=270 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>

</body>

</html>
_END;
