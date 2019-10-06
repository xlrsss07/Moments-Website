<?php
    require_once "header.php";

    if (isset($_SESSION['ID']))
        destorySession();

    $a="";

    if(isset($_POST['username'])&&isset($_POST['password1'])&&isset($_POST['password2']))
    {

        if($_POST['password1']!==$_POST['password2'])
        {
            $a= "The passwords do not correspond with each other";
        }
        elseif(preg_match("/[^a-zA-Z0-9]/",$_POST['username'])|| $_POST['username']==='')
        {
            $a= "Please make sure that the username consists of letters and number only";
        }
        elseif(preg_match("/[^\w]/",$_POST['password1'])|| $_POST['password1']==='')
        {
            $a= "Please make sure that the password consists of letters, number and underline only";
        }
        else
        {
            $connection->beginTransaction();
            $stmt=$connection->prepare("SELECT ID FROM users WHERE user_login=?");
            $stmt->execute(array($_POST['username']));
            if($stmt->rowCount()===0)
            {
                $stmt= $connection->prepare("INSERT INTO users SET user_login=?,
                                    user_pass=?, user_registered=?");
                $success=$stmt->execute(array($_POST['username'],
                    $_POST['password1'],date('Y-m-d H:i:s', time())));

                if($success===true)
                {
                    $user_result=execMysql("SELECT ID FROM users WHERE user_login=?",
                                            array($_POST['username']),true);

                    $userID=$user_result->fetch()['ID'];

                    try
                    {
                        mkdir("./upload/users/user_id{$userID}");
                        mkdir("./upload/users/user_id{$userID}/moments");
                    }
                    catch(Exception $e)
                    {
                        $connection->rollBack();
                        $a= "Register failed, please try again";
                    }


                    $connection->commit();
                    $a= "Account created, please Log in.";
                    //TODO:跟前端说如果需要修改做到重定向，那么前端写休眠时间和重定向
                    header('location:login.php'); //重定向到testpost.html
                }
                else
                {
                    $connection->rollBack();
                    $a= "Register failed, please try again";
                }
            }
            else
            {
                $connection->rollBack();
                $a= "This username already exists";
            }
        }
    }





    echo <<<_END
    <!DOCTYPE HTML>
<html>

<head>
    <title>Register</title>
    <link rel="icon" href="images/Favicon.png" >
    <link href="css/login/register.css" rel="stylesheet" type="text/css" media="all" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
    <script src="js/jquery-1.11.1.min.js"></script>
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
    <!-- contact-form -->
    <div class="message warning">
        <div class="inset">
            <div class="login-head">
                <a href="home.html"><h1>Moments</h1></a>
                <div class="alert-close">
                     <a href="javascript:history.go(-1);"><img src="images/login/into.png" /></a>
                </div>
            </div>
            <form action="register.php" method="POST">

                <li>
                    <input type="text" class="text" name="username" value="Username" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Username';}">
                    <a href="#" class=" icon user"></a>
                </li>
                <div class="clear"> </div>

                <li>
                    <input type="password" name="password1" value="Password" placeholder="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
                    <a href="#" class="icon lock"></a>
                </li>
                <div class="clear"> </div>

                <li>
                    <input type="password" name="password2" value="Password" placeholder="Password again" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
                    <a href="#" class="icon lock"></a>
                </li>
                                   

                    <div class="submit">
                         <input type="submit" onclick="myFunction()" value="Register">
                    </div>

                     <a href="login.php">
                        <div class="submit" >
                             <h1 type="submit">Login</h1>
                        </div>
                    </a>
                    <div class="alertmessage">
                    <h><a>{$a}</a></h>
                    
                </div>
</br></br>
            </form>
        </div>
    </div>
    </div>
    <div class="clear"> </div>
    <!--- footer --->
    <div class="footer">
        <p></p>
    </div>

</body>

</html>
_END;

?>
