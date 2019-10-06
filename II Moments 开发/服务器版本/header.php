<?php
    require_once 'functions.php';

    if(isset($_SESSION['ID'])) //获取用户登录状态
    {
        $loggedin=TRUE;

        if(file_exists("./upload/users/user_id{$_SESSION['ID']}/header.jpg"))
        {
            $filename = "./upload/users/user_id{$_SESSION['ID']}/header.jpg";
        }
        else
        {
            $filename="./images/logo.png";
        }
    }
    else
        $loggedin=FALSE;

    echo <<<_END
    <!DOCTYPE html>
    <html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Header</title>
        <link rel="icon" href="images/Favicon.png">
        <link rel="stylesheet" href="http://css122us.cdndm5.com/v201904041843/dm5/css/style.css">
        <link rel="stylesheet" href="css/bottom/bottom.css">
        <base target="_parent" />
    
    </head>
_END;

    if($loggedin)
    {
        echo <<<_END
<body>
    <!-- 登陆后 -->
    <header class="header container-fluid ">
        <div class="container">
            <!-- 左侧logo -->
            <a href="index.html"> <img class="header-logo" src="images/myinformation/header-logo.png" /> </a>
            <!-- 左侧菜单标题 -->
            <ul class="header-title">
                <li><a href="index.html">Home</a></li>
                <li><a href="index.html#societyhref">Club</a></li>
                <li><a href="index.html#eventhref">Event</a></li>
                <li><a href="moments.php">Moment</a></li>
                <li>
                    <a href="index.html"> <i class="icon icon-cat" style="font-size:19px;vertical-align: sub;"></i></a>
                </li>
            </ul>
            <!-- 搜索栏 -->
            <div class="header-search">
                <input id="txtKeywords2" value="" type="text" placeholder="Search" data-default="Search" />
                <div class="header-search-list" style="display: none">
                </div>
                <a id="btnSearch" onmouseover="mOver(this)" href="search.php">Search</a>
            </div>
            <!-- 右侧菜单选项 -->
            <ul class="header-bar">
                <li class="vip">
                    <a href="index.html">
                        <div class="header-vip"></div>
                        <p>VIP</p>
                    </a>
                </li>
                <li class="hover">
                    <a href="index.html" data-isload="0" onmouseover="getreadhistorys(this)"> <i class="icon icon-clock"></i>
                        <p>History</p>
                    </a>

                </li>
                <li class="hover">
                    <a href="usersociety.php" data-isload="0" onmouseover="getbookmarkers(this);"> <i class="icon icon-fav"></i>
                        <p>Like</p> <span class="red-sign"></span> </a>

                </li>
                <li class="download">
                    <a href="logout.php"> <i class="icon icon-down"></i>
                        <p>Log out</p>
                    </a>
                </li>
            </ul>
            <!-- 登录头像 -->
            <div class="header_login hover">
                <a href="userinfo.php"> <img data-isload="0" class="header-avatar" src="{$filename}" onmouseover="getuserinfo(this);" /></a>
                
            </div>
        </div>
    </header>

</body>
_END;

    }

    else
    {
        echo <<<_END
    <body>

    <!-- 登录前 -->
    <header class="header container-fluid ">
        <div class="container">
            <!-- 左侧logo -->
            <a href="index.html"> <img class="header-logo" src="images/myinformation/header-logo.png" /> </a>
            <!-- 左侧菜单标题 -->
            <ul class="header-title">
                <li><a href="index.html">Home</a></li>
                <li><a href="index.html#societyhref">Club</a></li>
                <li><a href="index.html#eventhref">Event</a></li>
                <li><a href="moments.php">Moment</a></li>
                <li>
                    <a href="My societies.html"> <i class="icon icon-cat" style="font-size:19px;vertical-align: sub;"></i></a>
                </li>
            </ul>
            <!-- 搜索栏 -->
            <div class="header-search">
                <input id="txtKeywords2" value="" type="text" placeholder="Search" data-default="Search" />
                <div class="header-search-list" style="display: none">
                </div>
                <a id="btnSearch" onmouseover="mOver(this)" href="search.php">Search</a>
            </div>
            <!-- 右侧菜单选项 -->
            <ul class="header-bar">
                <li class="vip">
                    <a href="My societies.html">
                        <div class=""></div>
                        <p></p>
                    </a>
                </li>
                <li class="hover">
                    <a href="My societies.html" data-isload="0" onmouseover="getreadhistorys(this)"> <i class=""></i>
                        <p></p>
                    </a>

                </li>
                <li class="hover">
                    <a href="My societies.html" data-isload="0" onmouseover="getbookmarkers(this);"> <i class=""></i>
                        <p></p> <span class="red-sign"></span> </a>

                </li>
                <li class="download">
                    <a href="login.php"> <i class="icon icon-down"></i>
                        <p>Log in</p>
                    </a>
                </li>
            </ul>
            <!-- 登录头像 -->
            <div class="header_login hover">
                <a href="login.php"> <img data-isload="0" class="header-avatar" src="images/myinformation/catcat.jpg" onmouseover="getuserinfo(this);" /></a>
                
            </div>
        </div>
    </header>


</body>
_END;

    }

    echo <<<_END
<script type="text/javascript">
function mOver(obj)
{ 
    var keyword = document.getElementById("txtKeywords2").value;
    obj.href=("search.php?text="+keyword);
    //alert(keyword);
}
</script>
</html>
_END;
