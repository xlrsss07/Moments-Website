<?php
    require_once "header.php";

    if(isset($_SESSION['ID']))
    {
        $info="";
        if(isset($_POST['old']) && isset($_POST['new1']) && isset($_POST['new2']))
        {
            if($_POST['old']==="" || $_POST['new1']==="" || $_POST['new2']==="")
            {
                $info="Please make sure that enter all fields";
            }
            else
            {
                //execMysql("SELECT ID FROM ")
                //$user_result=execMysql("SELECT user_pass FROM users WHERE ID=?",array($_SESSION['ID']),true);
                $user_result=execMysql("SELECT user_pass FROM users WHERE ID=?",array($_SESSION['ID']),true);
                $user=$user_result->fetch();
                if($user['user_pass']!==$_POST['old'])
                {
                    $info="old password is wrong";
                }
                elseif($_POST['new1']!==$_POST['new2'])
                {
                    $info="please input same password";
                }
                else
                {
                    if(preg_match("/[^\w]/",$_POST['new1'])|| $_POST['new1']==='')
                    {
                        $info="Please make sure that password only contains letters, number and underline";
                    }
                    else
                    {
                        $connection->beginTransaction();
                        $stmt=$connection->prepare("UPDATE users SET user_pass=? WHERE ID=?");
                        $success=$stmt->execute(array($_POST['new1'],$_SESSION['ID']));

                        if($success)
                        {
                            $info="Change password successfully";
                            $connection->commit();
                        }
                        else
                        {
                            $info="Change password failed, please try again";
                            $connection->rollBack();
                        }
                    }
                }
            }

        }
    }
    else
    {
        header('location:login.php'); //重定向到login.php
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

<script src="./js/request.js"></script>

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
    
    function a() 
    {
        sendAjax("./my2.php", "GET", "my=event", function(obj) 
        {
            document.getElementById("username").innerHTML=obj.username;
            document.getElementById("userheader").src=obj.user;
        });
    }
</script>

<body class="white" onload="a()">
    
    <!-- 页面头部 -->
   <iframe src="header.php" style="display:block; position:absolute;    left: 0px;  top: 0px;  z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100%  height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe> 

    <main class="container mt30 mb20 overflow-Show clearfix" style="min-height:750px;">
        <aside class="user-sidebar pull-left">
            <section class="user-info">
                <div class="avatar">
                    <img id="userheader" src="images/myinformation/catcat.jpg" alt="" />
                </div>
                <h1 style="text-align: left;"> <span style="width:120px;margin:0 0 0 50px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;line-height: initial;" id="username">Aditor </span> <a href="userinfo.php"><i class="icon icon-edit"  style="cursor:pointer"> </i> </a></h1>
                <p style="text-align: center;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; line-height: initial;">Enjoy your Moments!!! </p>
            </section>
            <ul class="user-menu">
                
                <li> <a href="usersociety.php"> <i class="icon icon-cat"></i><span>SOCIETIES</span></a></li>
                <li> <a href="userevent.php"><i class="icon icon-date"></i><span>EVENTS</span> </a> </li>
                <li> <a id="hi" onclick="hi(this)" href=""   ><i class="icon icon-fav" ></i><span>CREATE SOCIETY </span> </a> </li>

                <li> <a href="moments.php" ><i class="icon icon-imgup"></i><span>MOMENTS</span></a> </li>
                <li> <a href="userinfo.php" ><i class="icon icon-lamp"></i><span>INFORMATION</span></a></li>
                <li> <a class="active" href="changepassword.php"><i class="icon icon-lock"></i><span>SETTING</span></a> </li>
               
            </ul>
        </aside>

        <article class="article-main pull-right">
            <section class="box">
                <div class="table-head">
                    <ul class="table-tabs">
                        <li> <a class="active" href="changepassword.php">Reset</a> </li>
                    </ul>
                </div>
                <div class="box-body">
                    <section class="user-repasswd">
                        <form action="changepassword.php" method="post" novalidate="novalidate">
                            <p class="tip"> <i class="sp sp-tip" style="display: none"></i><span class="js_err_tip" style="color: red;"></span> </p>
                            <p>
                                <input type="password" name="old" autocomplete="off" name="txtPasswordOld" value="" placeholder="Your original password" reg-err="It can not be empty" required=""> </p>
                            <p>
                                <input type="password" name="new1" autocomplete="off" name="txtPasswordNew" value="" placeholder="New password" reg-err="New password" minlength="6" maxlength="20" required=""> </p>
                            <p>
                                <input type="password" name="new2" autocomplete="off" name="txtPasswordConfirm" value="" placeholder="Type your new password again" reg-err="The two passwords do not match" equalto="[name=&#39;txtPasswordNew&#39;]" required=""> </p>
                            <p>
                                <button class="btn full" type="submit">Reset my password</button>
                            </p>
                        </form>
                        <p>{$info}</p>
                    </section>
                </div>
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
  
</body>
</html>
_END;
