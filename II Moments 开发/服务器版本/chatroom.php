<?php
    if(!isset($_GET['id']))
    {
        die();
    }

    echo <<<_END
    <!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Chatroom </title>
    <link rel="icon" href="images/Favicon.png">
    <link type="text/css" rel="stylesheet" href="css/chatbox/style.css">
    <script type="text/javascript" src="js/chatbox/jquery.min.js"></script>
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

    function b() {

        sendAjax("./chatbox.php", "GET", "id={$_GET['id']}", function(obj) {

            document.getElementById("1").setAttribute("src", obj.header);
            document.getElementById("1").setAttribute("onerror","this.src='images/logo.png'");
            document.getElementById("2").innerHTML = obj.name;

            document.getElementById("fromname").value=obj.username;
            document.getElementById("userheader").value=obj.userheader;
        });
    }

    function c() {

        sendAjax("./societyback.php", "GET", "id={$_GET['id']}&action=search", function(obj) {
            var ul = document.getElementById("3");
            for (var i = 0; i < getHsonLength(obj.members); i++) {

                var li = document.createElement("li");
                li.setAttribute("class", "msg_item fn-clear");

                var span = document.createElement("span");

                var img = document.createElement("img");
                img.setAttribute("src", obj.members[i]["header"]);
                img.setAttribute("onerror","this.src='images/logo.png'");
                img.setAttribute("width", "25");
                img.setAttribute("height", "25");

                var em = document.createElement("em");
                em.innerHTML = obj.members[i]["name"];

                ul.appendChild(li);
                li.appendChild(span);
                span.appendChild(img);
                li.appendChild(em);

            }

        });
    }
    var id0 = 0;
  
    function sendMessage(event, from_name, to_uid, to_uname) {

            var msg = $("#message").val();
            var header=document.getElementById("userheader").value;
            var from_name=document.getElementById("fromname").value;

            // var htmlData = "";

            var htmlData =   '<div class="clear"></div><div class="mymsg_item fn-clear">'
                            + '   <div class="myuface"><img id="user_header" src="'
                            + header
                            
                            +'" width="40" height="40"  alt=""/></div>'
                   + '   <div class="myitem_right">'
                   + '     <div class="mymsg">' + msg + '</div>'
                   + '     <div class="myname_time">' + from_name + getNowFormatDate()
                   + '   </div>'
                   + '</div><div class="clear"> </div>';
            $("#message_box").append(htmlData);
            $('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
            $("#message").val('');

            window.clearInterval(getmessage());

            sendAjax("./chatbox.php", "POST", "id={$_GET['id']}&content=" + msg, function(obj) {
                if(obj.resultCode==404)
                {
                    alert("Please log in")
                }
            });
            d();

        }

   

    //get message
    function d(){
        id0= id0+1;
        window.setInterval("getmessage()", 800);
    }
    function e() {

        sendAjax("./chatboxhistory.php", "GET", "id={$_GET['id']}", function(obj) {
            var msgl = getHsonLength(obj.chat_message);

            if (msgl > 0) {
                if (id0 == 0) {
                    
                    id0 = obj.chat_message[0]["ID"]-1
                   
                }
                var id = obj.chat_message[msgl - 1]["ID"];
                if (id > id0) {
                   
                    id0 = id;

                    var div = document.getElementById("message_box");

                    for (var i = 0; i < msgl; i++) {

                         var div2 = document.createElement("div");
                        div2.setAttribute("class", "msg_item fn-clear");

                        div2.innerHTML = '<div class="clear"> </div><div class="uface"><img src="' +
                            obj.chat_message[i]["header"] +
                            '" /></div>  <div class="item_right">  <div class="msg">' +
                            obj.chat_message[i]["content"] +
                            '</div>      <div class="name_time">' +
                            obj.chat_message[i]["displayname"] +
                            ' ' +
                            obj.chat_message[i]["time"] +
                            '</div> </div> </div> <div class="clear"> </div>'

                        div.appendChild(div2);
                        var message_box = document.getElementById('message_box');
                        message_box.scrollTop = message_box.scrollHeight;
                       
                    }

                }
            }

        });
    }
    
    function getmessage() {

        sendAjax("./chatbox.php", "GET", "id={$_GET['id']}", function(obj) {
            var msgl = getHsonLength(obj.chat_message);

            if (msgl > 0) {

                if (id0 == 0 || id0 == 1) {
                    
                    id0 = obj.chat_message[0]["ID"] - 1
                    var id = obj.chat_message[msgl - 1]["ID"];
                    id0 = id;

                } 
                var id = obj.chat_message[msgl - 1]["ID"];

                if (id > id0) {
             
                    var div = document.getElementById("message_box");

                    for (var i = 0; i < msgl; i++) {
                        if(obj.chat_message[i]["ID"]>id0){

                         var div2 = document.createElement("div");
                        div2.setAttribute("class", "msg_item fn-clear");

                        div2.innerHTML = '<div class="clear"> </div><div class="uface"><img src="' +
                            obj.chat_message[i]["header"] +
                            '" /></div>  <div class="item_right">  <div class="msg">' +
                            obj.chat_message[i]["content"] +
                            '</div>      <div class="name_time">' +
                            obj.chat_message[i]["displayname"] +
                            ' ' +
                            obj.chat_message[i]["time"] +
                            '</div> </div> </div> <div class="clear"> </div>'

                        div.appendChild(div2);
                        var message_box = document.getElementById('message_box');
                        message_box.scrollTop = message_box.scrollHeight;
                       }
                    }
                    id0 = id;

                }
            }

        });
    }
    
    var userheader = "images/chatbox/user.jpg";

    window.setInterval("getmessage()", 800);
</script>

<body onload="b();c();e()">

    <div class="chatbox">

        <div class="chat_top fn-clear">
            <div class="logo"><img src="images/chatbox/logo2.png" width="190" height="60" alt="" /></div>
            <div class="uinfo fn-clear">
                <div class="uface"><img id="1" src="images/chatbox/user.jpg" width="40" height="40" alt="" /></div>
                <div id="2" class="uname">
                    Visitor
                </div>
            </div>
        </div>
        
        <div class="chat_message fn-clear">
            <div class="chat_left">

                <div class="message_box" id="message_box">
                    <a class="pasthistory" onclick="gethistory()">.  .  .  .  .  .  .  .  .  .  .  .  H i s t o r y  .  .  .  .  .  .  .  .  .  .  .  .  </a>
          
            <div class="msg_item fn-clear">
              <div class="uface"><img src="images/logo.png" /></div>
              <div class="item_right">
                <div class="msg">Welcom to Moments chatroom!</div>
                <div class="name_time">Moments</div>
              </div>
            </div>

            <div class="clear"> </div>

        <!--     
            <div class="mymsg_item fn-clear">
              <div class="myuface"><img src="images/chatbox/53f44283a4347.jpg" /></div>
              <div class="myitem_right">
                <div class="mymsg">Welcome</div>
                <div class="myname_time">Moments</div>
              </div>            
            </div>
            <div class="clear"> </div>
 -->
            


                </div>
                <div class="write_box">
                    <textarea id="message" name="message" value="" class="write_area" placeholder="Say something..."></textarea>
                    <input type="hidden" name="fromname" id="fromname" value="Visitor" />
                    <input type="hidden" name="userheader" id="userheader" value="" />
                    
                    <input type="hidden" name="to_uid" id="to_uid" value="0">
                    <div class="facebox fn-clear">
                        <div class="expression"></div>
                        <div class="chat_type" id="chat_type">
                            <a class=emoji onclick="emoji1()">😁</a>
                            <a class=emoji onclick="emoji2()">😂</a>
                            <a class=emoji onclick="emoji3()">😜</a>
                            <a class=emoji onclick="emoji4()">😎</a>
                            <a class=emoji onclick="emoji5()">😘</a>
                            <a class=emoji onclick="emoji6()">😆</a>
                            <a class=emoji onclick="emoji7()">👍</a>
                            <a class=emoji onclick="emoji8()">👏</a>
                            <a class=emoji onclick="emoji9()">💪</a>
                            </div>
                        <button name="" class="sub_but">Send</button>
                    </div>
                </div>
            </div>
            <div class="chat_right">
                <ul id="3" class="user_list" title="">
                    <li class="fn-clear selected"><em>All members</em></li>

                    <!-- <li class="fn-clear" data-id="1">
            <span>
                <img src="images/chatbox/user.jpg" width="25" height="25"/>
            </span>
            <em>Aditor</em>
        </li> -->

                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
            $('.uname').hover(
                function() {
                    $('.managerbox').stop(true, true).slideDown(100);
                },
                function() {
                    $('.managerbox').stop(true, true).slideUp(100);
                }
            );

            //var fromname = $('#fromname').val();
            var fromname=document.getElementById("fromname").value;
            
            var to_uid = 0; // 默认为0,表示发送给所有用户
            var to_uname = '';

            $('.sub_but').click(function(event) {
                sendMessage(event, fromname, to_uid, to_uname);
            });

            /*按下按钮或键盘按键*/
            $("#message").keydown(function(event) {
                var e = window.event || event;
                var k = e.keyCode || e.which || e.charCode;
                //按下ctrl+enter发送消息
                if ((event.keyCode && (k == 13 || k == 10))) {
                    sendMessage(event, fromname, to_uid, to_uname);
                    event.preventDefault();
                }
            });
        });
        function emoji1(){var msg = document.getElementById("message");msg.value=msg.value+"😁";}
        function emoji2(){var msg = document.getElementById("message");msg.value=msg.value+"😂";}
        function emoji3(){var msg = document.getElementById("message");msg.value=msg.value+"😜";}
        function emoji4(){var msg = document.getElementById("message");msg.value=msg.value+"😎";}
        function emoji5(){var msg = document.getElementById("message");msg.value=msg.value+"😘";}
        function emoji6(){var msg = document.getElementById("message");msg.value=msg.value+"😆";}
        function emoji7(){var msg = document.getElementById("message");msg.value=msg.value+"👍";}
        function emoji8(){var msg = document.getElementById("message");msg.value=msg.value+"👏";}
        function emoji9(){var msg = document.getElementById("message");msg.value=msg.value+"💪";}      
   

        function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    if (hour >= 1 && hour <= 9) {
        hour = "0" + hour;
    }
    if (minute >= 1 && minute <= 9) {
        minute = "0" + minute;
    }
   if (second >= 1 && second <= 9) {
        second = "0" + second;
    }
    var currentdate = " " + month + seperator1 + strDate
            + " " + hour + seperator2 + minute
            + seperator2 + second;
    return currentdate;
} 

    </script>
</body>

</html>
_END;
