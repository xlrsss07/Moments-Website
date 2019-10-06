<?php
    require_once "header.php";

    /*
     * 这一整段话放在哪里都没关系，因为就一个部分,所以可以采用html代码嵌套php代码
     * 如果是这么做的话，那么找到一个可以腾出的地方，把这句话一整段话插入即可
     */

    $information="";
    //form标签里面把method改成POST，action写成本文件地址
    //TODO:下面有一个TODO表示需要腾出一个地方回显这句话，实在不行就alert谈个窗口
    if(isset($_POST['username'])&&isset($_POST['password']))
    {
        $success=execMysql("SELECT ID,user_login FROM users WHERE user_login=? AND user_pass=? limit 1",
            array($_POST['username'],$_POST['password']),true);

        if($success->rowCount()===0)
        {
            //TODO:找一个地方写上这句话，实在不行就alert谈个窗口
            $information= "Login failed. Username/password invalid.";
        }
        else
        {
            $temp=$success->fetch();
            //$_SESSION['username']=$temp['user_login'];
            $_SESSION['ID']=$temp['ID'];
            header('location:index.html'); //重定向到testpost.html

            //echo "<script>history.go(-2)</script>";
        }
    }

    echo <<<_END
<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <link rel="icon" href="images/Favicon.png" >
    <link href="css/login/login.css" rel="stylesheet" type="text/css" media="all" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="./js/jquery-1.11.1.min.js" type="text/javascript"></script>
   <!-- -->
    <script>
        var __links = document.querySelectorAll('a');

        function __linkClick(e) {
            parent.window.postMessage(this.href, '*');
        };
        for (var i = 0, l = __links.length; i < l; i++) {
            if (__links[i].getAttribute('data-t') == '_blank') {
                __links[i].addEventListener('click', __linkClick, false);
            }
        }
    </script>
    <script>
        $(document).ready(function(c) {
            $('.alert-close').on('click', function(c) {
                $('.message').fadeOut('slow', function(c) {
                    $('.message').remove();
                });
            });
        });
    </script>
</head>

<body>
   <iframe src="header.php" style="display:block; position:fixed;z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100%  height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe> </br></br>
    <!-- contact-form -->
    <div class="message warning">
        <div class="inset">
            <div class="login-head">
                <a href="index.html"><h1>Moments</h1></a>
                <div class="alert-close">
                    <a href="javascript:history.go(-1);"><img src="images/login/into.png" /></a>
                </div>
            </div>
            <form method="POST" action="login.php">

                <li>
                    <input type="text" class="text" name="username" value="Username" placeholder="Username"" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Username';}">
                    <a href="#" class=" icon user"></a>
                </li>
                <div class="clear"> </div>

                <div>
                    </br> 
                   
                </div>

                <li>
                    <input type="password" name="password" value="Password" placeholder="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
                    <a href="#" class="icon lock"></a>
                </li>
                <div class="clear"> </div>


                <div class="submit">
                    <input type="submit" onclick="myFunction()" value="Login">
                </div>


                <a href="register.php">
                <div class="submit" >
                    <h1 type="submit">Register</h1>
                </div>
                </a>

                
                <div class="alertmessage">
                    <h><a>{$information}</a></h>
                    
                </div>
           </br>
           
            </form>
        </div>
    </div>
    </div>
    <div class="clear"> </div>
    <!--- footer --->
    <div class="footer">
        <p></p>
    </div>
    
</br></br></br></br></br></br>
    <iframe src="bottom.html" style="display:block;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100%  height=270 scrolling=no ALLOWTRANSPARENCY=”true”></iframe>
</body>

</html>
_END;

