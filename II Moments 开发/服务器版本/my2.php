<?php
require_once 'functions.php';

try{
    if(isset($_SESSION['ID'])&&isset($_GET['my'])) {

        //users' name and signature
        //$user_name = execMysql("SELECT user_login FROM users WHERE ID=?", array($_SESSION['ID']), TRUE);
        $my = execMysql("SELECT * FROM users WHERE ID=?", array($_SESSION['ID']), TRUE);
        $user_name = Array();
        $signature = Array();
        $user_img=Array();
        foreach ($my as $row) {
            $user_name[] = $row['user_login'];
            $signature[] = $row['signature'];
            $user = "./upload/users/user_id{$_SESSION['ID']}/header.jpg";
            $user_img[]=$user;
        }

        //user的图片
//            $user_img = "./upload/users/user_id{$_SESSION['ID']}/header.jpg";


        if ($_GET['my'] === 'societies') {
            //society
            //$my_society = execMysql("SELECT * FROM usermeta WHERE user_id=? AND meta_key='subscribe_association'", array($_SESSION['ID']), TRUE);
            $my_society = execMysql("SELECT * FROM usermeta WHERE user_id=? AND meta_key='subscribe_association'", array($_SESSION['ID']), TRUE);
            $society_id = Array();
            foreach ($my_society as $row) {
                $society_id[] = $row['meta_value'];
            }


            $length = count($society_id);
            $society_name = Array();
            for ($i = 0; $i < $length; $i++) {
                $society = execMysql("SELECT * FROM association WHERE association_ID=?", array($society_id[$i]), TRUE);
                foreach ($society as $row) {
                    $society_name[] = $row['association_name'];
                }
            }
            //society的名字
//            $society_name = Array();
//            foreach ($society as $row) {
//                $society_name[] = $row['association_name'];
//            }

            //society的图片
            $society_img = Array();
            $arr_length = count($society_name);
            for ($i = 0; $i < $arr_length; $i++) {
                if(file_exists("./upload/society/society_{$society_id[$i]}/header.jpg"))
                {
                    $filepath = "./upload/society/society_{$society_id[$i]}/header.jpg";
                }
                else
                {
                    $filepath = "./images/logo.png";
                }

                $society_img[] = $filepath;
            }


            //读取社团对应的链接
            $society_link=array();
            for($i=0;$i<$arr_length;$i++)
            {
                $link_path="./society.php?id={$society_id[$i]}";
                $society_link[]=$link_path;
            }

            echo $json = json_encode(array(
                "resultCode" => 200,
                "username" => $user_name,
                "user" => $user_img,
                "signature" => $signature,
                "societyname" => $society_name,
                "societypic" => $society_img,
                "societylink"  => $society_link,
            ));
            file_put_contents('test.json', $json);


        } elseif ($_GET['my']==='event'){
            //society
            // $my_event = execMysql("SELECT * FROM usermeta WHERE user_id=? AND meta_key='event'", array($_SESSION['ID']), TRUE);
            $my_event = execMysql("SELECT * FROM usermeta WHERE user_id=? AND meta_key='event'", array($_SESSION['ID']), TRUE);
            $event_id=Array();
            foreach ($my_event as $row) {
                $event_id[] = $row['meta_value'];
            }

//            for($x=0;$x<1;$x++)
//            {
//                echo $event_id[$x];
//                echo "<br>";
//            }
//
            $length2=count($event_id);
            $event_name= Array();
            $society_id=Array();
            for ($i = 0; $i < $length2; $i++) {
                $event=execMysql("SELECT * FROM event WHERE event_ID=?",array($event_id[$i]),TRUE);

                foreach ($event as $row) {
                    $event_name[] = $row['event_name'];
                    $society_id[] =$row['asso_ID'];
                }
            }
//            for($x=0;$x<1;$x++)
//            {
//                echo $event_name[$x];
//                echo $society_id[$x];
//                echo "<br>";
//            }
//
//
            //event的图片
            $event_img = Array();
            $arr_length2 = count($event_name);
            for ($i = 0; $i < $arr_length2; $i++) {
                if(file_exists("./upload/society/society_{$society_id[$i]}/event_{$event_id[$i]}/1.jpg"))
                {
                    $filepath2 = "./upload/society/society_{$society_id[$i]}/event_{$event_id[$i]}/1.jpg";
                }
                else
                {
                    $filepath2="./images/logo.png";
                }

                $event_img[] = $filepath2;
            }

            //读取event对应的链接
            $event_link=array();
            for($i=0;$i<$arr_length2;$i++)
            {
                $link_path="./event.php?id={$event_id[$i]}";
                $event_link[]=$link_path;
            }

            echo $json=json_encode(array(
                "resultCode"=>200,
                "username"=>$user_name,
                "user"=>$user_img,
                "signature"=>$signature,
                "eventname"=>$event_name,
                "eventpic"=>$event_img,
                "eventlink"=>$event_link,
            ));
            file_put_contents('test.json', $json);

        }


    }else{
        header('location:index.html');
    }

}catch (PDOException $e) {
    exit("PDO Error: ".$e->getMessage()."<br>");
}
