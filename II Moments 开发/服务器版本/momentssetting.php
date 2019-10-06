<?php
    require_once 'functions.php';

    if(!isset($_SESSION['ID']))
    {
        header('location:login.php');
    }
    else
    {
        echo <<<_END
<!DOCTYPE html>
<html>

<head>
    <title>Post my moments</title>
    <link rel="icon" href="images/Favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="js/moments/momentssetting/.js"></script>
    <link rel="stylesheet" type="text/css" href="css/moments/momentssetting.css" media="screen" />

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
                      alert(this.responseText)
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


</script>
<script type="text/javascript">

    // function a()
    // {
    //
    //     var f=document.getElementById("b").value;
    //     sendAjax("./momentsback.php", "POST", "action=publish&description="+f, function(obj) {
    //         alert("hello");
    //            if(obj.resultCode==200){
    //                alert("submit successfully!");
    //            }else if (obj.resultCode==404){
    //                alert("submit fail, please try it again!");
    //            }
    //         }
    //     );
    // }
</script>
<body>
    <iframe src="header.php" style="display:block; position:fixed;z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>
    </br>
    </br>
    </br>
    </br>

    <div class="EventSettingSection">
        <img class="EditEventPgeOurLogo" src="images/logo.png" />



        <!--添加活动图片-->
        <form method="POST" action="momentsback.php" enctype="multipart/form-data" >
            <!--<p class=choosepic>Choose a picture: </p>-->
            <!--<p>-->
                <label>New Picture:</label>
                <input type="file" id="file" name="file" multiple="multiple" onchange="readAsDataURL()" />
            <!--</p>-->
            <!--<div id="result" name="result"></div>-->

            <input type="hidden" name="action" value="publish" />
            </br>
            <!--活动描述-->
            <div class="littleEventSettingSection">
                <label class="EventTexttip">Say something : </label> <span><textarea id="b" name="description"rows="3" cols="40"> </textarea></span>
            </div>

            <!--保存按钮-->
            <div class="mt20 text-center">
                <input id="btnsave" class="SavebuttonEventPage" type="submit" name="submit" value="Submit">
            </div>
        </form>
        <!--</form>-->
    </div>

    </br>
    </br>
    <iframe src="bottom.html" style="display:block;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100% height=270 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>
</body>

</body>

</html>
_END;

    }