<?php
require_once 'header.php';
echo<<<_END
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Moments Search Page </title>
	<link rel="icon" href="images/Favicon.png">
	<link rel="stylesheet" href="css/search/reset.css">
    <link rel="stylesheet" type="text/css" href="css/search/Search1.css">

</head>

<body>

<iframe src="header.php" style="display:block; position:fixed;z-index:1000;" frameBorder=0 marginwidth=0 marginheight=0 scrolling=no width=100%  height=74 scrolling=no ALLOWTRANSPARENCY=”true”></iframe> </br></br></br></br>

<div class=searchframe>
_END;

    if(!isset($_GET['text']))
    {
        die404();
        return;
    }
    $resultNum=0; //用于显示找到结果的总数


    $searchText='%'.$_GET['text'].'%';
    $searchTextDisplay=$_GET['text'];
    $resultAsso=execMysql("SELECT * FROM association WHERE association_name LIKE ?",array($searchText),TRUE);
    if($resultAsso->rowCount()===0)
    {
        echo "No result";
    }
    $resultNum+=$resultAsso->rowCount();


    //TODO:可能这种查询效率不高，到时候慢了再改
    $resultEvent=execMysql("SELECT * FROM association a,event e 
                        WHERE a.association_ID=e.asso_ID AND event_name LIKE ?",array($searchText),TRUE);
    if($resultEvent->rowCount()===0)
    {
        echo "No result";
    }

    $resultNum+=$resultEvent->rowCount(); //表示总搜索到的次数，即社团数量到活动数量

echo<<<_END

<!--显示搜索结果的数目-->
<header class="SearchHead" id="SH1" >
	<div class="SearchNUM">
	<div id="app">
      <v-countup :start-value="start" :end-value="end"></v-countup>
    </div>
    <script src='https://unpkg.com/vue@2.3.3'></script>
    <script src='https://unpkg.com/vue-countupjs'></script>
    <script>
      Vue.use(VueCountUp)
      var app = new Vue({
        data: {
          start: 1,
          end: {$resultNum}
        },
        el: "#app"
      })
    </script>	
	<p class="NUM"></p>
		<p>&nbsp;results about&nbsp;<p>
			<p id="SearchITEM">{$searchTextDisplay}</p>	
		</div>
</header>
</div>

<div>
<p class="SearchH1">Society</p>
<!--搜索出来的社团-->
<div class="SearchClub">

_END;

                foreach ($resultAsso as $row)
                {
                    //echo $row['association_name'],"<br>";
                    if(file_exists("./upload/society/society_{$row['association_ID']}/header.jpg"))
                    {
                        $filepath="./upload/society/society_{$row['association_ID']}/header.jpg"; //社团图像图片地址
                    }
                    else
                    {
                        $filepath="./images/logo.png";
                    }

                    //echo $filepath,"<br>";

                    $linkSociety="./society.php?id={$row['association_ID']}";//社团超级链接地址
                    //echo $linkSociety,"<br>";

echo<<<_END

       <div class="ClubResult">
       <a href="{$linkSociety}"> <img class="Searchcircle" src="$filepath"></a>
  	   <a class="ClubName" href="{$linkSociety}">{$row['association_name']}</a>
  	   </div>

_END;
                }
                echo "<br>";
echo<<<_END
<div class="clear"></div>
</div>

<!--搜索出来的event-->
<br>
<p class="SearchH1">Events</p>
<div class="SearchEvent">
<div class="clear"></div>

_END;

                foreach ($resultEvent as $row)
                {
                    //echo $row['association_name'],"\n";
                    if(file_exists("./upload/society/society_{$row['association_ID']}/event_{$row['event_ID']}/1.jpg"))
                    {
                        $filepath="./upload/society/society_{$row['association_ID']}/event_{$row['event_ID']}/1.jpg"; //活动头像图片地址
                    }
                    else
                    {
                        $filepath="./images/logo.png";
                    }

                    //echo $filepath,"<br>";

                    $linkEvent="./event.php?id={$row['event_ID']}";//活动超级链接
                    //echo $linkEvent,"<br>";
echo<<<_END

<div class="EventResult">
<a href="{$linkEvent}"><img class="SearchSquare" src="$filepath"></a>
<a class="EventName" href="{$linkEvent}">{$row['event_name']}</a>
</div>

_END;
                }

echo<<<_END
</div>

	<script type="text/javascript" src="js/search/emojiCursor.js"></script>
	<!--<script type="text/javascript" src="js/search/countUp.js"></script>-->
	<script type="text/javascript">
		//change the background images automatically 
		window.onload=function(){
		var bg=new Array("images/search/searchBG1.jpg","images/search/searchBG2.jpg",
			"images/search/searchBG3.jpg", "images/search/searchBG4.jpg",
             "images/search/searchBG5.jpg","images/search/searchBG6.jpg");
		var index = Math.floor(Math.random()*bg.length);;
		document.getElementById("SH1").style.backgroundImage="url('"+bg[index]+"')";
		document.getElementById("SH1").style.backgroungRepeat="no-repeat";
		
		//Setting the count up number
		// var options = {useEasing: true, useGrouping: true, separator: ',', decimal: '.'};
		// var numAnim = new CountUp('NUM', 0, 4036, 0, 2.5, options);
		// numAnim.start();
	}
	</script>
</div>

</body>
</html>
_END;
echo "</pre>";
?>