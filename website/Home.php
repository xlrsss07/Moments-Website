<!DOCTYPE html>
<!-- saved from url=(0022)http://momentists.com/ -->
<!-- TODO:这个网页目前情况下不联网是不能正常运行的，因为外部链接没有替换，并且理论上他们需要调用header文件，
TODO:等到所有前端代码弄完以后再弄 ,还有网页左上角的moments图标不见了，前端代码定位一下
TODO:还有跟前端说一下不怎么好判断用户是否在线能否把他去掉

因为个人开发的原因，可能出现css和js重名，为了解决这个问题先暂时给每个人的js文件专门分配一个文件夹，在这里就是
放在/js/home，TODO:真实网页中把这种沙雕注释删了

TODO:同时找个时间将没用或者已经解决的注释和TODO去掉-->



<?php
require_once 'functions.php';

if(!isset($_GET['id']))
{
    //TODO:等index主页做完了这里改成302重定向到主页上去
    die404();
}
//TODO:先全部查找，等到后期确定下来到底需要什么时候在改成选定的字段
$association=execMysql("SELECT * FROM association WHERE association_ID=?",array($_GET['id']),TRUE);

//奇怪的是checkuser.php不加===0可以正常运行，在这里去掉就变成非预期
if($association->rowCount()===0)
{
    die404();
}
$association_unit=$association->fetch(PDO::FETCH_ASSOC);
//TODO:倒时候在考虑少于5人的情况
$subscribe_user=execMysql("SELECT a.user_id,b.display_name,b.ID 
                    FROM usermeta a,users b WHERE a.user_id=b.ID 
                    AND a.meta_key='subscribe_association' AND a.meta_value=?",
                    array($association_unit['association_ID']),TRUE);

echo <<<_END
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<title>Home</title>
	<link rel="shortcut icon" href="./images/Favicon.png">
	<link rel="icon" href="./images/Favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="./css/home/reset.css">
	<link rel="stylesheet" href="./css/home/index.css">
	<script type="text/javascript" src="./js/home/jquery.min.js"></script>

	<script type="text/javascript">
  		function showInform()
		{
        	document.getElementById("inform").style.display='block';
      	}
     
		function hiddenInform()
		{
  			document.getElementById("inform").style.display="none";
 	 	}
     
	</script>
</head>




<body class="vsc-initialized" style="">
<header class="header">
	<div class="header-inner body-width">
  		<a href="http://momentists.com/#" class="logo"></a>
  		<div class="category">
 		 </div>
		<div class="search">
			<input type="searchtext" class="search-text" placeholder="Seach here...">
			<a class="search-btn">
				<i class="icon-search"></i>
			</a>
  		</div>

  		<nav class="header-nav">
			<ul>
	  			<li>
					<span class="line"></span>
					<a href="http://momentists.com/#" class="dreamer">Mine</a>
					<i class="icon-text__pink icon-new">new</i>
	  			</li>
	  			<li>
					<span class="line"></span>
					<a href="http://momentists.com/#" class="icon-text__pink register">Sign up</a>
				</li>
	  			<li>
					<span class="line"></span>
					<!-- login -->
					<a href="http://momentists.com/#" class="icon-text__pink login" onclick="document.getElementById(&#39;id01&#39;).style.display=&#39;block&#39;">  Log in </a>

					<div id="id01" class="modal">
						<form class="modal-content animate" action="http://momentists.com/action_page.php">
							<div class="imgcontainer">
								<span onclick="document.getElementById(&#39;id01&#39;).style.display=&#39;none&#39;" class="close" title="Close Modal">×</span>
				 				<h1 class="HeadOne">Moments</h1>
							</div>

							<div class="container">
      							<label>
									<b>Username</b>
								</label>
      							<input type="text" placeholder="Enter Username" name="uname" required="">

      							<label>
									<b>Password</b>
								</label>
      							<input type="password" placeholder="Enter Password" name="psw" required="">
        
      							<button type="submit">Submit</button>
      							<input type="checkbox" checked="checked"> Remember Me
    						</div>

    						<div class="container" style="background-color:#f1f1f1">
      							<button type="button" onclick="document.getElementById(&#39;id01&#39;).style.display=&#39;none&#39;" class="cancelbtn">Cancel</button>
      							<span class="psw">Forgot
									<a href="http://momentists.com/#">password?</a>
								</span>
  							</div>
						</form>
	
					</div>

	  			</li>
	  			<li>
					<span class="line"></span>
					<i class="icon-app"></i>
					<a href="http://momentists.com/#" class="app">English</a>
					<i class="icon-arrow"></i>
					<div class="app-hover">
						<a href="http://momentists.com/#"></a>
						<p>Scan</p>
					</div>
				</li>
			</ul>
  		</nav>
	</div>

	<div>
		<input type="checkbox" id="menu">
		<label for="menu" class="menu">
			<span></span>
			<span></span>
			<span></span>
		</label>

		<nav class="nav">
  			<img class="UserHeadPortrait" src="./Home_files/tDXE-hcikcew6516254.jpg">
  	  		 <p class="UserName">Gabrielle</p>
  			<ul>
    			<li><a href="http://momentists.com/#">My Society</a></li>
    			<li><a href="http://momentists.com/#">My Events</a></li>
    			<li><a href="http://momentists.com/#">Settings</a></li>
  			</ul>
		</nav>
	</div>

	<div class="header-shadow"></div>
</header>
<div class="main">
<div class="main-inner body-width">
  <div class="banner clearfix">
	<div class="slider" id="slider">
	  <ul class="slider-wrapper" style="width: 3550px; left: -2840px;">
		<li class="item" data-title="Test Title" data-author="            Test Auther">
		  <a href="http://momentists.com/#" class="pic"><img src="./Home_files/test hottest moments1.jpg" alt="#"></a>
		</li>
		<li class="item" data-title="Test Title" data-author="Test Auther">
		  <a href="http://momentists.com/#" class="pic"><img src="./Home_files/test hottest moments2.jpg" alt="#"></a>
		</li>
		<li class="item" data-title="Test Title" data-author="Test Auther">
		  <a href="http://momentists.com/#" class="pic"><img src="./Home_files/test hottest moments3.jpg" alt="#"></a>
		</li>
		<li class="item" data-title="Test Title" data-author="Test Auther">
		  <a href="http://momentists.com/#" class="pic"><img src="./Home_files/test hottest moments4.jpg" alt="#"></a>
		</li>
        <li class="item" data-title="Test Title" data-author="Test Auther">
		  <a href="http://momentists.com/#" class="pic"><img src="./Home_files/test hottest moments5.jpg" alt="#"></a>
		</li>
		
	  </ul>
	  <a href="javascript:;" class="slider-prev"></a>
	  <a href="javascript:;" class="slider-next"></a>

	  <div class="slider-title">
		<h2>Test Title</h2>
		<span>Test Auther</span>
	  </div>

	  <div class="slider-btns">
		<span class="item"></span>
		<span class="item"></span>
		<span class="item"></span>
		<span class="item"></span>
		<span class="item item-cur"></span>
	  </div>
	</div>

 	<h1>
<div class="chatbox">
  <div class="chat_top fn-clear">
    <div class="logo"><img src="./images/logo2.png" alt=""></div>
    <div class="uinfo fn-clear">
      <div class="uface"><img src="./Home_files/hetu.jpg" width="40" height="40" alt=""></div>
      <div class="uname">
        Aditor<i class="fontico down"></i>
        <ul class="managerbox">
          <li><a href="http://momentists.com/#"><i class="fontico lock"></i>Lock</a></li>
          <li><a href="http://momentists.com/#"><i class="fontico logout"></i>Log out</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="chat_message fn-clear">
    <div class="chat_left">
      <div class="message_box" id="message_box">
_END;

//TODO:如果前端可以保障多个消息能够正常显示就继续尝试添加数据进行测试，目前只加了4个消息
//这里由于发消息的人和下面的member不一样，嫌麻烦就用之前新建的5个角色

$message=execMysql("SELECT *,UNIX_TIMESTAMP(msg_date) as timestamp FROM groupmsg WHERE chatroom_ID=? ORDER BY msg_date",array($_GET['id']),TRUE);
foreach ($message as $row)
{
    //var_dump($row);
    echo <<<_END
        <div class="msg_item fn-clear">
          <div class="uface"><img src="./upload/users/{$row['msg_senderID']}.jpeg" width="40" height="40" alt=""></div>
          <div class="item_right">
            <div class="msg">{$row['msg_content']}</div>
            <div class="name_time">{$row['msg_sendername']} · 
_END;
    //TODO:看懂的话我就换成整数了,还有下面的days和day懒得改了，有心情再改,很奇怪会多出额外8个小时，找一个大佬解决问题
    $timediff=time()-$row['timestamp']-8*3600;
    if($timediff>60*60*24)
    {
        $timeago=floor($timediff/86400);
        echo "$timeago days ago";
    }
    elseif ($timediff>60*60)
    {
        $timeago=floor($timediff/3600);
        echo "$timeago hours ago";
    }
    else
    {
        $timeago=floor($timediff/60);
        echo "$timeago minutes ago";
    }
    echo "</div></div></div>";
}

echo <<<_END
            
        <div class="msg_item fn-clear">
          <div class="uface"><img src="./Home_files/53f44283a4347.jpg" width="40" height="40" alt=""></div>
          <div class="item_right">
            <div class="msg">Say hello to every one!</div>
            <div class="name_time">Catty · 3minuts ago</div>
          </div>
        </div>
        
        <div class="msg_item fn-clear">
          <div class="uface"><img src="./Home_files/hetu.jpg" width="40" height="40" alt=""></div>
          <div class="item_right">
            <div class="msg own">OK~~</div>
            <div class="name_time">Aditor · 30seconds ago</div>
          </div>
        </div>
      </div>
      <div class="write_box">
        <textarea id="message" name="message" class="write_area" placeholder="Say something..."></textarea>
        <input type="hidden" name="fromname" id="fromname" value="Aditor">
        <input type="hidden" name="to_uid" id="to_uid" value="0">
        <div class="facebox fn-clear">
          <div class="expression"></div>
          <div class="chat_type" id="chat_type">Moments Chatting</div>
          <button name="" class="sub_but">Send</button>
        </div>
      </div>
    </div>
    <div class="chat_right">
      <ul class="user_list" title="Double click to chat privately">
        <li class="fn-clear selected"><em>All users</em></li>
_END;

//TODO:如果用户名昵称过长会换行，前端改一下
/*
 * 经考虑在touser表中额外添加一个displayname字段，虽然查找会效率增加，但是用户如果更新昵称的效率会变低，
 * 尤其是在信息逐渐变大的情况下（如果msg中所谓的三天外删除指的是数据库也一起删的话，那么groupmsg不会受多大
 * 影响，但是touser那个表就不行了）。如果已经到达了这种情况，那么就只能用联接了，但是个人建议如
 * 果用的话，只用改touser表，msg的表就还是原来的样子，虽然这样会导致用户昵称变化但是之前发的信
 * 息不会变，但是我认为没多大关系
 */
$userlist=execMysql("SELECT * FROM association_touser WHERE chatroom_ID=?",
                        array($_GET['id']),TRUE);
$i=1;
foreach ($userlist as $row)
{
    echo "<li class=\"fn-clear\" data-id=\"$i\"><span><img src=\"./upload/users/{$row['user_ID']}.jpeg\" width=\"30\" height=\"30\" alt=\"\"></span><em>{$row['user_displayname']}</em><small class=\"online\" title=\"Online\"></small></li>";
    $i++;
}
echo <<<_END
        <li class="fn-clear" data-id="1"><span><img src="./Home_files/hetu.jpg" width="30" height="30" alt=""></span><em>Aditor</em><small class="online" title="Online"></small></li>
        <li class="fn-clear" data-id="2"><span><img src="./Home_files/53f44283a4347.jpg" width="30" height="30" alt=""></span><em>Catty</em><small class="online" title="Online"></small></li>
        <li class="fn-clear" data-id="3"><span><img src="./Home_files/53f442834079a.jpg" width="30" height="30" alt=""></span><em>Doggy</em><small class="offline" title="Offline"></small></li>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	$('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
	$('.uname').hover(
	    function(){
		    $('.managerbox').stop(true, true).slideDown(100);
	    },
		function(){
		    $('.managerbox').stop(true, true).slideUp(100);
		}
	);
	
	var fromname = $('#fromname').val();
	var to_uid   = 0; // 默认为0,表示发送给所有用户
	var to_uname = '';
	$('.user_list > li').dblclick(function(){
		to_uname = $(this).find('em').text();
		to_uid   = $(this).attr('data-id');
		if(to_uname == fromname){
		    alert('You cant talk to yourself!');
			return false;
		}
		if(to_uname == 'All users'){
		    $("#toname").val('');
			$('#chat_type').text('Chatroom');
		}else{
		    $("#toname").val(to_uid);
			$('#chat_type').text('You are talking to ' + to_uname );
		}
		$(this).addClass('selected').siblings().removeClass('selected');
	    $('#message').focus().attr("placeholder", "Say something to "+to_uname );
	});
	
	$('.sub_but').click(function(event){
	    sendMessage(event, fromname, to_uid, to_uname);
	});
	
	/*按下按钮或键盘按键*/
	$("#message").keydown(function(event){
		var e = window.event || event;
        var k = e.keyCode || e.which || e.charCode;
		//按下ctrl+enter发送消息
		if(k == 13){
			sendMessage(event, fromname, to_uid, to_uname);
		}
	});
});
function sendMessage(event, from_name, to_uid, to_uname){
    var msg = $("#message").val();
	if(to_uname != ''){
	    msg = 'You are talking to ' + to_uname  + msg;
	}
	var htmlData =   '<div class="msg_item fn-clear">'
                   + '   <div class="uface"><img src="images/hetu.jpg" width="40" height="40"  alt=""/></div>'
			       + '   <div class="item_right">'
			       + '     <div class="msg own">' + msg + '</div>'
			       + '     <div class="name_time">' + from_name + ' · 30 seconds ago</div>'
			       + '   </div>'
			       + '</div>';
	$("#message_box").append(htmlData);
	$('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
	$("#message").val('');
}
</script>
</h1>




  </div>


<br>

<div class="SocietyDescription">
	<a class="SoDesForm1" href="http://momentists.com/#" onmouseover="showInform()" onmouseout="hiddenInform()"> Description / Contact / Address </a>
_END;

//TODO:前端改成把这个改成PRE，换行都没显示的
echo "<p id=\"inform\" class=\"SoDesForm2\">{$association_unit['association_description']}";

echo '<br><br><img src="./images/IconTel.png" width="20" height="20">  
        Contact:',$association_unit['association_contact'],"<br><br>";

echo '<img src="./images/IconLocation.png" width="20" height="20">  Address:', $association_unit['association_address'];



echo <<<_END
<br><br><br>
	</p>
</div>
   <div class="main-cont main-album">
	<div class="main-cont__title">
	  <h3>Moments</h3>
	  <a href="http://momentists.com/#" class="more">More &gt;</a>
	</div>
	<ul class="main-cont__list clearfix">
	  <li class="item">
		<a href="http://momentists.com/#" class="pic"><img src="./Home_files/test moments1.jpg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="title">Test MOMENTS</a>
		  <p>68 Pics · 2255 Likes</p>
		  <p>by <a href="http://momentists.com/#" class="author">Test writer</a></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic"><img src="./Home_files/test moments2.jpg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="title">Test MOMENTS</a>
		  <p>68 Pics · 2255 Likes</p>
		  <p>by <a href="http://momentists.com/#" class="author">Test writer</a></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic"><img src="./Home_files/test moments3.jpg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="title">Test MOMENTS</a>
		  <p>68 Pics · 2255 Likes</p>
		  <p>by <a href="http://momentists.com/#" class="author">Test writer</a></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic"><img src="./Home_files/test moments4.jpg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="title">Test MOMENTS</a>
		  <p>68 Pics · 2255 Likes</p>
		  <p>by <a href="http://momentists.com/#" class="author">Test writer</a></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic"><img src="./Home_files/test moments5.jpg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="title">Test MOMENTS</a>
		  <p>68 Pics · 2255 Likes</p>
		  <p>by <a href="http://momentists.com/#" class="author">Test writer</a></p>
		</div>
	  </li>
	</ul>
  </div>

  <div class="main-cont main-recommend">
	<div class="main-cont__title">
	  <h3>Events</h3>
	  <p class="list">
		<em>Rank：</em>
		<a href="http://momentists.com/#">Hottest</a>
		<span>|</span>
		<a href="http://momentists.com/#">time</a>
		<span>|</span>
		<a href="http://momentists.com/#">aaa</a>
		<span>|</span>
		<a href="http://momentists.com/#">bbb</a>
		<span>|</span>
		<a href="http://momentists.com/#">ccc</a>
		
	  </p>
	</div>
	<ul class="main-cont__list clearfix">
_END;

//TODO:这玩意也一样等到确定下来到底要什么东西之后在写具体字段,还有如果已经确认是jpg图形后面就给我全部用这个类型
$event=execMysql("SELECT * FROM event WHERE asso_ID=?",array($_GET['id']),TRUE);
$i=0;
foreach ($event as $row)
{
    //var_dump($row);
    if($i<5)
    {
        echo <<<_END
<li class="item">
		<a href="http://momentists.com/EventPage/Event.html" class="pic">
		<img src="./upload/society/{$association_unit['association_name']}/events/{$row['event_name']}/header.jpg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/EventPage/Event.html" class="title">{$row['event_name']}</a>
		  <span>{$row['event_member']} participated in</span>
		  <a href="http://momentists.com/#" class="icon-text__pink purchase">Join</a>
		</div>
	  </li>
_END;
        $i++;
    }
}

echo <<<_END
	  
	</ul>
  </div>
  <div class="main-cont main-user">
	<div class="main-cont__title">
	  <h3>Members</h3>
	  <a href="http://momentists.com/#" class="more">More &gt;</a>
	</div>
	<ul class="main-cont__list clearfix">
_END;
//TODO:也一样，倒时候在考虑少于5人的情况，这边也要改
$i=0;
foreach ($subscribe_user as $row)
{
    //var_dump($row);
    if($i<5)
    {
        //TODO:前端解释以下url(images/cont/user_img1.jpg)这串代码里面的背景图片是什么东西
        //TODO:还有下面的9645以及等级问题
        /*
         * <li class="item">
		<a href="http://momentists.com/#" class="pic" style=" background: url(images/cont/user_img1.jpg) no-repeat; background-size: cover; "></a>

		<a href="http://momentists.com/#" class="headImg"><img src="./Home_files/test user1.jpeg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="info-title">Test user</a>
		  <p><i class="icon-star"></i>9645</p>
		  <p>Level: <b>3⭐</b></p>
		</div>
	  </li>
        <li class="item">
		<a href="http://momentists.com/#" class="pic" style=" background: url(images/cont/user_img1.jpg) no-repeat; background-size: cover; "></a>

		<a href="http://momentists.com/#" class="headImg"><img src="./Home_files/test user1.jpeg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="info-title">Test user</a>
		  <p><i class="icon-star"></i>9645</p>
		  <p>Level: <b>3⭐</b></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic" style=" background: url(images/cont/user_img2.jpg) no-repeat; background-size: cover; "></a>
		<a href="http://momentists.com/#" class="headImg"><img src="./Home_files/test user2.jpeg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="info-title">Test user</a>
		  <p><i class="icon-star"></i>9645</p>
		  <p>Level: <b>3⭐</b></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic" style=" background: url(images/cont/user_img3.jpg) no-repeat; background-size: cover; "></a>
		<a href="http://momentists.com/#" class="headImg"><img src="./Home_files/test user3.jpeg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="info-title">Test user</a>
		  <p><i class="icon-star"></i>9645</p>
		  <p>Level: <b>3⭐</b></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic" style=" background: url(images/cont/user_img4.jpg) no-repeat; background-size: cover; "></a>
		<a href="http://momentists.com/#" class="headImg"><img src="./Home_files/test user4.jpeg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="info-title">Test user</a>
		  <p><i class="icon-star"></i>9645</p>
		  <p>Level: <b>3⭐</b></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic" style=" background: url(images/cont/user_img5.jpg) no-repeat; background-size: cover; "></a>
		<a href="http://momentists.com/#" class="headImg"><img src="./Home_files/test user5.jpeg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="info-title">Test user</a>
		  <p><i class="icon-star"></i>9645</p>
		  <p>Level: <b>3⭐</b></p>
		</div>
	  </li>
         */
        //注意多表连接使用用到的a.什么b.什么的不会在关联数组的索引上出现
        //TODO:未来需要考虑如果用户没有上传头像或者背景图片怎么办！！
        echo <<<_END
<li class="item">
		<a href="http://momentists.com/#" class="pic" style="background: url(./upload/userbackground/user_img{$row['ID']}.jpg) no-repeat; background-size: cover;"></a>
		<a href="http://momentists.com/#" class="headImg"><img src="./upload/users/{$row['ID']}.jpeg" alt="#"></a>
		<div class="info">
		  <a href="http://momentists.com/#" class="info-title">{$row['display_name']}</a>
		  <p><i class="icon-star"></i>9645</p>
		  <p>Level: <b>3⭐</b></p>
		</div>
	  </li>
_END;
        $i++;
    }
    else
        break;
}
echo <<<_END
	</ul>
  </div>
  <div class="main-cont main-waterfall">
	<div class="main-cont__title">
	  <h3>Recommended Societies</h3>
	</div>
	<ul class="main-cont__list clearfix">
	  <li class="item item-cur">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society1.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect">Like  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society2.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society3.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society4.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society5.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 163px; left: 0px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society1.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 163px; left: 244px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society2.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 163px; left: 488px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society3.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 163px; left: 732px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society4.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 183px; left: 976px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society5.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 326px; left: 0px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society1.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 326px; left: 244px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society2.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 326px; left: 488px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society3.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 326px; left: 732px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society4.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	  <li class="item" style="position: absolute; top: 346px; left: 976px;">
		<a href="http://momentists.com/#" class="pic">
		  <img src="./Home_files/test society5.jpg" alt="#">
		</a>
		<div class="waterfall-hover">
		  <span class="mask"></span>
		  <a href="http://momentists.com/#" class="btn-collect"> Likes  45</a>
		  <a href="http://momentists.com/#" class="btn-white btn-like"></a>
		  <a href="http://momentists.com/#" class="btn-white btn-comment"></a>
		</div>
		<div class="waterfall-info">
		  <p class="title">Test Society</p>
		  <p class="icon"><span class="icon-star">89</span><span class="icon-like">10</span></p>
		</div>
		<div class="collect-info">
		  <a href="http://momentists.com/#" class="headImg"><img src="./Home_files/waterfall_headImg1.jpeg" alt="#"></a>
		  <p class="title"><a href="http://momentists.com/#">Test Administrator</a></p>
		  <p class="to">Sports<a href="http://momentists.com/#"> A level</a></p>
		</div>
	  </li>
	</ul>
  </div>
</div>
<a href="http://momentists.com/#" id="readMore">More &gt;</a>
</div>

<footer class="footer">
<div class="footer-container">
  <div class="footer-link">
	<div class="footer-link__item">
	  <h4 class="footer-title">More</h4>
	  <ul class="footer-list">
		<li class="item"><a href="http://momentists.com/#"> </a></li>
		<li class="item"><a href="http://momentists.com/#"> </a></li>
		
	  </ul>
	</div>
	<div class="footer-link__item">
	  <h4 class="footer-title">More</h4>
	  <ul class="footer-list">
		<li class="item"><a href="http://momentists.com/#"> </a></li>
		<li class="item"><a href="http://momentists.com/#"> </a></li>
		
	  </ul>
	</div>
	<div class="footer-link__item">
	  <div class="footer-orcode"><img src="./images/app_qrcode.png" alt="#"></div>
	  <div class="orcode-text">
		<p>Scan</p>
		
	  </div>
	</div>
	<div class="footer-link__item">
	  <h4 class="footer-title">More</h4>
	  <ul class="footer-list">
		<li class="item"><a href="http://momentists.com/#"> </a></li>
		<li class="item"><a href="http://momentists.com/#"> </a></li>
	  </ul>
	</div>
	<div class="footer-link__item">
	  <h4 class="footer-title">Link</h4>
	  <ul class="footer-list">
		<li class="item"><a href="http://momentists.com/#">About us</a></li>
		<li class="item"><a href="http://momentists.com/#">Helping center</a></li>
		
	  </ul>
	</div>
  </div>
  <div class="fopter-copyright">
	<p>Copyright © 2019.Moments studio. All rights reserved.</p>
  </div>
</div>
</footer>


<script src="./js/home/jquery.min.js"></script>
<script src="./js/home/script.js"></script>


</body></html>
_END;
?>