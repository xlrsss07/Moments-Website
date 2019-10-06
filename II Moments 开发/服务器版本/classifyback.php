<?php
require_once 'functions.php';


    try{
        
        //If there are available society, then show the web page.
        if(isset($_GET['class']))
        {
            $society=execMysql("SELECT * FROM association WHERE class=?",array($_GET['class']),TRUE);
            if($society->rowCount()===0)
            {
                //die404();//TODO:如果这个类里面没有一个社团的话，应该显示这个，假定没有社团不为0的情况
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Cannot find such event"
                ))) ;
            }
            //这里是读取对应这个类里面的社团名字
            $name=Array();
            $ID=array();
            foreach($society as $row)
            {
                $name[] = $row['association_name'];
                $ID[] = $row['association_ID'];
            }
            $arr_length = count($name);
           // echo $name[0];
//            for($x=0;$x<$arr_length;$x++)
//            {
//                echo $name[$x];
//                echo $ID[$x];
//                echo "<br>";
//            }

            $img=array();
            for($i=0;$i<$arr_length;$i++)
            {
                if(file_exists("./upload/society/society_{$ID[$i]}/header.jpg"))
                {
                    $filepath="./upload/society/society_{$ID[$i]}/header.jpg";
                }
                else
                {
                    $filepath="./images/logo.png";
                }
                $img[]=$filepath;
            }


            //读取社团对应的链接
            $link=array();
            for($i=0;$i<$arr_length;$i++)
            {
                $link_path="./society.php?id={$ID[$i]}";
                $link[]=$link_path;
            }


            echo $json=json_encode(array(
                "resultCode"=>200,
                "name"=>$name,
                "img"=>$img,
                "link"=>$link,
            ));

            //file_put_contents('test.json', $json);
        }
        //If there are not available society, then just display the no available information.
        else {
            echo "Sorry, there are not available soceity now.";
        }
    } catch (PDOException $e) {
        exit("PDO Error: ".$e->getMessage()."<br>");
    }



?>