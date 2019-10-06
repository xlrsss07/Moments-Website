<?php

    require_once 'functions.php';


    if(isset($_GET['id']))
    {
        $event=execMysql("SELECT * FROM event WHERE event_ID=?",array($_GET['id']),TRUE);

        if($event->rowCount()===0)
        {
            //die404();//TODO:如果社团搜索不到应该显示这个
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Cannot find such event"
            ))) ;
        }

        $eventunit=$event->fetch();

        $temp=explode(' ',$eventunit['event_date']);
        //var_dump($temp);
        list($year,$month,$day)=explode("-",$temp[0]);
        list($hour,$minute,$second)=explode(":",$temp[1]);
        $date=mktime($hour, $minute, $second, $month, $day, $year);
        //echo date("l jS F Y", $d),"<br>";

        $img=array();
        for($i=1;$i<=$eventunit['pictureNum'];$i++)
        {
            $filepath="./upload/society/society_{$eventunit['asso_ID']}/event_{$_GET['id']}/{$i}.jpg";
            $img[]=$filepath;
        }

        //TODO:中间的那个Events You Might Like由于缺少算法就不管
        //TODO：用户针对某个用户的回复占时还有LIKE先不管，结合的时候那段代码直接删了或者不管他

        $comment_user=execMysql("SELECT * FROM comment WHERE comment_event_ID=?",array($_GET['id']),TRUE);


        $comment=Array();
        //这里不检测数量了，数量为0的话为空数组
        foreach($comment_user as $row)
        {
            $userunit=Array();
            //echo "Displayname: ",$row['comment_display_name'],"<br>"; //TODO：网名
            $userunit['displayname']=$row['comment_display_name'];

            $temp=explode(' ',$row['comment_date']);
            //var_dump($temp);
            list($year,$month,$day)=explode("-",$temp[0]);
            list($hour,$minute,$second)=explode(":",$temp[1]);

            //echo $year," ",$month," ",$day," ",$hour," ",$minute," ",$second,"<br>";

            $d=mktime($hour, $minute, $second, $month, $day, $year);
            //echo "Date: ",date("m-d G:i", $d),"<br>";    //TODO:发表评论的时间

            //TODO:时间不会显示年份，先不管他了
            $userunit['date']=date("m-d G:i", $d);

            //echo "Content: ",$row['comment_content'],"<br>"; //TODO:发表评论的内容
            $userunit['content']=$row['comment_content'];

            //TODO：目前用户上传文件只有这两种格式，到时候再加，当然home那里还没加，到了适合时间在做统一处理

            $header="./upload/users/user_id{$row['comment_user_ID']}/header.jpg";
            //echo $header,"<br>";
            $userunit['header']=$header;

            $comment[]=$userunit;
        }

        //更新活动对应的点击次数
        $eventunit['click_time']++;
        $connection->beginTransaction();
        $stmt=$connection->prepare("UPDATE event SET click_time=? WHERE event_ID=?");

        $success=$stmt->execute(array($eventunit['click_time'],$_GET['id']));
        if(!$success) {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode" => 404,
                "message" => "update failed"
            )));
        }

        $connection->commit();
        echo $json=json_encode(array(
            "resultCode"=>200,
            "name"=>$eventunit['event_name'],
            "date"=>date("Y-m-d\TH:i:s", $date),
            "location"=>$eventunit['event_location'],
            "limitation"=>$eventunit['limitation'],
            "description"=>$eventunit['event_description'],
            "img"=>$img,
            "comment"=>$comment
        ));
    }
    elseif (isset($_POST['id']) && isset($_POST['action']))
    {
        if($_POST['action']==='update')
        {
            //第一步检测是否登录
            if(!isset($_SESSION['ID']))
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Please login.",
                    "a"=>$_POST['username']
                ))) ;
            }

            //第二步检测是否存在该活动
            $check_result=execMysql("SELECT event_ID,asso_ID,pictureNum FROM event WHERE event_ID=?",array($_POST['id']),true);
            if($check_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Cannot find such event"
                )));
            }

            $check=$check_result->fetch();
            $asso_ID=$check['asso_ID'];

            //第三步检测该用户是否具有这个权限
            $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
                array($asso_ID,$_SESSION['ID']),true);
            if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"You do not have permission"
                ))) ;
            }

            if(isset($_POST['event_name'])&&isset($_POST['time'])&&
                isset($_POST['location'])&&isset($_POST['description'])&&
                isset($_POST['limitation']))
            {
                //TODO:如果考虑安全性还需要加一个过滤
                //sanitizeString()

                if(!preg_match("/^[123]$/",$_POST['limitation']) ||
                    !preg_match("/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}/",$_POST['time']))
                {

                    //如果limitation或者time传过来的不合法，至于什么错误并不需要告诉他们
                    die(json_encode(array(
                        "resultCode"=>404,
                        "message"=>"Update failed,please try again"
                    )));
                }
                $connection->beginTransaction();
                $stmt= $connection->prepare("UPDATE event SET event_name=?,
                                event_date=?,event_location=?,
                                event_description=?,limitation=? 
                                WHERE event_ID=?");
                $success=$stmt->execute(array($_POST['event_name'],
                    $_POST['time'],$_POST['location'],
                    $_POST['description'],$_POST['limitation'],
                    $_POST['id']));


                if(!$success)
                {
                    $connection->rollBack();

                    die(json_encode(array(
                        "resultCode"=>404,
                        "message"=>"Update failed, please try again"
                    )));
                }

                //TODO:判断是否有上传文件
                if(isset($_FILES['file']['name']))
                    //if(isset($_FILES['file']['name']))
                {

                    if ($_FILES["file"]["error"] > 0)
                    {
                        //echo "Error: " . $_FILES["file"]["error"] . "<br />";
                    }
                    else
                    {
                        //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                        //echo "Type: " . $_FILES["file"]["type"] . "<br />";
                        //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                        //echo "Stored in: " . $_FILES["file"]["tmp_name"];

                        $i=1;

                        while(true)
                        {
                            if(!file_exists("./upload/society/society_{$asso_ID}/event_{$_POST['id']}/{$i}.jpg"))
                            {
                                $saveto="./upload/society/society_{$asso_ID}/event_{$_POST['id']}/{$i}.jpg";
                                break;
                            }
                            $i++;
                        }
                        //$saveto="./upload/society_{$_POST['id']}/header.jpg";
                        //$saveto="header.jpg";

                        move_uploaded_file($_FILES['file']['tmp_name'],$saveto);
                        $typeok = TRUE;

                        switch($_FILES['file']['type'])
                        {
                            case "image/jpeg":  // Both regular and progressive jpegs
                            case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
                            case "image/png":   $src = imagecreatefrompng($saveto); break;
                            default:            $typeok = FALSE; break;
                        }

                        if ($typeok)
                        {
//                            move_uploaded_file($_FILES['file']['tmp_name'],$saveto);

                            list($w, $h) = getimagesize($saveto);

                            $tw  = $w;
                            $th  = $h;

                            $tmp = imagecreatetruecolor($tw, $th);
                            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
                            //imageconvolution($tmp, array(array(-1, -1, -1),
                            //array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
                            imagejpeg($tmp, $saveto);
                            imagedestroy($tmp);
                            imagedestroy($src);

                            //更新数据库中的图片数量
                            $check['pictureNum']++;
                            $stmt=$connection->prepare("UPDATE event SET pictureNum=? WHERE event_ID=?");
                            $success=$stmt->execute(array($check['pictureNum'],$_POST['id']));
                            if(!$success)
                            {
                                unlink($saveto);
                                $connection->rollBack();
                                die(json_encode(array(
                                    "resultCode"=>404,
                                    "message"=>"Update failed, please try again"
                                )));
                            }

                        }
                        else
                        {
                            unlink($saveto);
                            $connection->rollBack();
                            die(json_encode(array(
                                "resultCode"=>404,
                                "message"=>"Please upload jpg,png only"
                            )));
                        }
                    }

                }

                $connection->commit();

                die(json_encode(array(
                    "resultCode"=>200,
                    "message"=>"Update successful"
                )));


            }
            else
            {
                //缺少必要项目，至于什么错误并不需要告诉他们
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed,please try again"
                )));
            }
        }
        elseif ($_POST['action']==='join')
        {
            //第一步判断用户是否已经登录
            if(!isset($_SESSION['ID']))
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Please login",
                ))) ;
            }

            //第二步判断是否存在该活动
            $event_result=execMysql("SELECT event_member,limitation,asso_ID FROM event WHERE event_ID=?",
                array($_POST['id']),true);

            if($event_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"No such event exists",
                ))) ;
            }
            $eventunit=$event_result->fetch();
            $event=$eventunit['event_member'];

            //第三步判断这个活动是否限制了参加
            $limit=$eventunit['limitation'];
            if($limit==1)
            {
                $asso_ID=$eventunit['asso_ID'];
                $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
                            array($asso_ID,$_SESSION['ID']),true);
                if($permission->rowCount()===0)
                {
                    die(json_encode(array(
                        "resultCode"=>404,
                        "message"=>"Only society members are allowed to join the event",
                    ))) ;
                }
            }


            //第四步判断这个人是否已经参加了社团
            $check_result=execMysql("SELECT user_id FROM usermeta 
                                WHERE user_id=? AND
                                meta_key='event' AND
                                meta_value=?",array($_SESSION['ID'],$_POST['id']),true);

            //如果这个人已经参加了该活动
            if($check_result->rowCount()!==0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"You have already joined this event"
                )));
            }



            //第五步开始更新，先更新usermeta表
            $connection->beginTransaction();
            $stmt=$connection->prepare("INSERT INTO usermeta SET 
                                        user_id=?,
                                        meta_key='event',
                                        meta_value=?");
            $success=$stmt->execute(array($_SESSION['ID'],$_POST['id']));

            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, please try again"
                )));
            }


            //第六步更新event表格的参加人数

            $event++;

            $stmt=$connection->prepare("UPDATE event SET event_member=? WHERE event_ID=?");
            $success=$stmt->execute(array($event,$_POST['id']));

            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, please try again"
                )));
            }

            $connection->commit();
            echo json_encode(array(
                "resultCode"=>200,
                "message"=>"Joined successfully"
            ));
        }
    }
    elseif(isset($_POST['action']) && $_POST['action']==='create' && isset($_POST['asso']))
    {
        //第一步判断用户是否登录
        if(!isset($_SESSION['ID']))
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Please login",
            ))) ;
        }

        //第二步检测该用户是否具有这个权限，社团如果不存在，这里是不会被通过的
        $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
            array($_POST['asso'],$_SESSION['ID']),true);
        if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"You do not have permission"
            ))) ;
        }

        //第三步更新event表
        $default_name='event'.rand(1, 100000);
        $connection->beginTransaction();
        $stmt=$connection->prepare("INSERT INTO event SET 
                                      event_name='{$default_name}',
                                      event_description='',
                                      event_member=1,
                                      asso_ID=?,
                                      limitation=1");
        $success=$stmt->execute(array($_POST['asso']));

        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Create failed, please try again",
            ))) ;
        }

        //获取刚才创建的event对应的ID
        $event_result=execMysql("SELECT event_ID FROM event 
                            WHERE event_name=? ORDER BY event_ID DESC limit 0,1",array($default_name),true);

        $eventID=$event_result->fetch()['event_ID'];


        //第四步更新usermeta表
        $stmt=$connection->prepare("INSERT INTO usermeta SET 
                                    user_id=?,
                                    meta_key='event',
                                    meta_value=?");
        $success=$stmt->execute(array($_SESSION['ID'],$eventID));
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Create failed, please try again"
            ))) ;
        }

        //创建文件夹
        if(file_exists("./upload/society/society_{$_POST['asso']}/event_{$eventID}"))
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Create failed, please try again"
            ))) ;
        }

        mkdir("./upload/society/society_{$_POST['asso']}/event_{$eventID}",false);

        $connection->commit();
        echo json_encode(array(
            "resultCode"=>200,
            "message"=>"You have created the event successfully",
            "eventID"=>$eventID
        ));



    }
    //TODO:删除活动本来并不提供，之所以这里写起来是因为后期方便直接删除而不是两个表自己手动删除
    elseif(isset($_POST['action']) && $_POST['action']==='delete' && isset($_POST['event']))
    {
        //第一步判断用户是否登录
        if(!isset($_SESSION['ID']))
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Please log in at first",
            ))) ;
        }

        //第二步检测该活动是否存在，这里是不会被通过的
        $check_result=execMysql("SELECT asso_ID FROM event 
                            WHERE event_ID=?",
            array($_POST['event']),true);
        if($check_result->rowCount()===0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"No such event"
            ))) ;
        }

        //第三步检测用户是否具有删除活动的权限
        $permission=execMysql("SELECT user_level FROM association_touser 
                                WHERE chatroom_ID=? AND user_ID=?",
                                array($check_result->fetch()['asso_ID'],$_SESSION['ID']),true);

        if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"You do not have permission"
            ))) ;
        }

        //第四步删除event表相关数据
        $connection->beginTransaction();
        $stmt=$connection->prepare("DELETE FROM event WHERE
                                        event_ID=?");
        $success=$stmt->execute(array($_POST['event']));
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Delete failed, please try again"
            ))) ;
        }

        //第五步删除usermeta相关数据
        $stmt=$connection->prepare("DELETE FROM usermeta WHERE
                                        user_id=? AND 
                                        meta_key='event' AND 
                                        meta_value=?");
        $success=$stmt->execute(array($_SESSION['ID'],$_POST['event']));

        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Delete failed, please try again"
            ))) ;
        }

        $connection->commit();
        echo json_encode(array(
            "resultCode"=>200,
            "message"=>"Delete successfully",
        ));
    }






