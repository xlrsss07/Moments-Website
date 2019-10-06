<?php
    require_once 'functions.php';
    global $connection;
    try
    {
        $event=$connection->prepare("SELECT * FROM event ORDER BY click_time DESC");
        $event->execute();
        if($event->rowCount()===0)
        {
            //die404();//TODO:如果里面没有一个活动的话，应该显示这个
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"There is no event"
            ))) ;
        }
        //这里是读取对应点击次数最多的event名字
        $event_name=Array();
        $eventID=Array();
        $association_ID=Array();
        $event_ID=Array();
        foreach($event as $row)
        {
            $event_name[] = $row['event_name'];
            $eventID[] = $row['event_ID'];
            $association_ID[] =$row['asso_ID'];
            $event_ID[]=$row['event_ID'];
        }

//        echo $arr_length = count($number);
//        echo $name[0];
//        for($x=0;$x<10;$x++)
//        {
//            echo $event_name[$x];
//            echo $association_ID[$x];
//            echo "<br>";
//        }
        //这里是读取event的图像
        $event_img=array();

        $min=sizeof($association_ID)<10?sizeof($association_ID):10;

        for($i=0;$i<$min;$i++)
        {
            if(file_exists("./upload/society/society_{$association_ID[$i]}/event_{$eventID[$i]}/1.jpg"))
            {
                $filepath="./upload/society/society_{$association_ID[$i]}/event_{$eventID[$i]}/1.jpg";
            }
            else
            {
                $filepath="./images/logo.png";
            }
            $event_img[]=$filepath;
           // echo $event_img[$i];
        }

       //读取event对应的链接
        $event_link=array();

        $min=sizeof($event_ID)<10?sizeof($event_ID):10;
        for($i=0;$i<$min;$i++)
        {
            $event_path="./event.php?id={$event_ID[$i]}";
            $event_link[]=$event_path;
        }





        //读取人数最多的社团名字
        $society=$connection->prepare("SELECT * FROM association ORDER BY memberNum DESC");
        $society->execute();
        if($society->rowCount()===0)
        {
            //die404();//TODO:如果里面没有一个活动的话，应该显示这个
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"There is no society"
            ))) ;
        }
        //人数最多的社团id,名字
        $asso_name=Array();
       // $member_Num=Array();
        $asso_ID=Array();
        foreach($society as $row)
        {
            $asso_name[] = $row['association_name'];
          //  $member_Num[] = $row['memberNum'];
            $asso_ID[] =$row['association_ID'];
        }

        $society_link=array();

        $min=sizeof($asso_ID)<10?$asso_ID:10;

        for($i=0;$i<$min;$i++)
        {
            $link_path="./society.php?id={$asso_ID[$i]}";
            $society_link[]=$link_path;
        }

//        for($x=0;$x<10;$x++)
//        {
//            echo $asso_name[$x];
//            echo $society_link[$x];
//            echo "<br>";
//        }


        echo $json=json_encode(array(
            "resultCode"=>200,
            "event_name"=>$event_name,
            "event_img"=>$event_img,
            "event_link"=>$event_link,
            "society_name"=>$asso_name,
            "society_link"=>$society_link,



        ));

        //file_put_contents('test.json', $json);

        //If there are not available society, then just display the no available information.


    }
    catch (PDOException $e)//异常定位在执行语句出现错误
    {
        echo $e,"<br>";
    }

?>