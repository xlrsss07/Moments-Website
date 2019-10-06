<?php
    require_once 'functions.php';

    if(isset($_SESSION['ID']))
    {
        destorySession();

        //TODO:到时候这里改成302重定向
        //echo "<div class='main'>You have been logged out. Please " .
            //"<a href='index.php'>click here</a> to refresh the screen.";
    }
    //echo "<a href=\"javascript:history.go(-1)\">返回上一页</a> ";
    echo "<script>history.go(-1)</script>";
