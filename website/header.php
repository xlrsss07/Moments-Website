<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2019/3/23
 * Time: 21:14
 */
    /*
     * 这块地方放所有html的共同部分。比如<!DOCTYPE html>
     *
     *  以下放出认为书中不需要加的东西，给出原因，方便之后添加
     *
     */

    session_start();
    echo "<!DOCTYPE html>\n<html><head>";

    require_once 'functions.php';


    $userstr=' (Guest)';

    if(isset($_SESSION['user'])) //获取用户登录状态
    {
        $user=$_SESSION['user'];
        $loggedin=TRUE;
        $userstr=" ($user)";
    }
    else $loggedin=FALSE;

    echo "<title>$appname$userstr</title><link rel='stylesheet' " .
        "href='styles.css' type='text/css'>"                     .
        "</head><body><center><canvas id='logo' width='624' "    .
        "height='96'>$appname</canvas></center>"             .
        "<div class='appname'>$appname$userstr</div>"            .
        "<script src='javascript.js'></script>";

    /*if ($loggedin)
    {
        echo "<br ><ul class='menu'>" .
            "<li><a href='members.php?view=$user'>Home</a></li>" .
            "<li><a href='members.php'>Members</a></li>"         .
            "<li><a href='friends.php'>Friends</a></li>"         .
            "<li><a href='messages.php'>Messages</a></li>"       .
            "<li><a href='profile.php'>Edit Profile</a></li>"    .
            "<li><a href='logout.php'>Log out</a></li></ul><br>";
    }
    else
    {
        echo ("<br><ul class='menu'>" .
            "<li><a href='index.php'>Home</a></li>"                .
            "<li><a href='signup.php'>Sign up</a></li>"            .
            "<li><a href='login.php'>Log in</a></li></ul><br>"     .
            "<span class='info'>&#8658; You must be logged in to " .
            "view this page.</span><br><br>");
    }*/
?>
