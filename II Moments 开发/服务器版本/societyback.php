<?php
    require_once 'functions.php';

    if(isset($_GET['id']) && isset($_GET['action']))
    {
        //查询社团
        if($_GET['action']==='search')
        {
            $association=execMysql("SELECT * FROM association WHERE association_ID=?",array($_GET['id']),TRUE);
            if($association->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Cannot find such society"
                ))) ;
                //
            }
            $asso_unit=$association->fetch();

            //图片地址
            $poster_result=execMysql("SELECT event_ID FROM event WHERE asso_ID=?",array($_GET['id']),true);
            $poster_img=Array();
            foreach($poster_result as $row)
            {
                $poster_unit=Array();

                //如果对应活动不存在图片，那么就需要默认图片代替
                if(file_exists("./upload/society/society_{$_GET['id']}/event_{$row['event_ID']}/1.jpg"))
                {
                    $poster_unit['path']="./upload/society/society_{$_GET['id']}/event_{$row['event_ID']}/1.jpg";
                }
                else
                {
                    $poster_unit['path']="./images/logo.png";
                }

                $poster_unit['href']="./event.php?id={$row['event_ID']}";

                $poster_img[]=$poster_unit;
            }

            $message_result=execMysql("SELECT *,UNIX_TIMESTAMP(msg_date) as timestamp 
                    FROM groupmsg WHERE chatroom_ID=? ORDER BY msg_date",
                array($_GET['id']),TRUE);
            //这里不检测数量了，数量为0的话为空数组
            $messages=Array();
            foreach ($message_result as $row)
            {
                $message_unit=Array();
                $message_unit['displayname']=$row['msg_sendername'];

                //发表时间,现在变成了7个小时，到时候到了冬令时要改成8
                $timediff=time()-$row['timestamp']-7*3600;
                if($timediff>60*60*24)
                {
                    $timeago=floor($timediff/86400);
                    //echo "$timeago days ago";
                    $timeans="$timeago days ago";
                }
                elseif ($timediff>60*60)
                {
                    $timeago=floor($timediff/3600);
                    //echo "$timeago hours ago";
                    $timeans="$timeago hours ago";
                }
                else
                {
                    $timeago=floor($timediff/60);
                    //echo "$timeago minutes ago";
                    $timeans="$timeago minutes ago";
                }

                $message_unit['time']=$timeans;
                $message_unit['content']=$row['msg_content'];

                $messages[]=$message_unit;
            }

            $user_result=execMysql("SELECT * FROM association_touser WHERE chatroom_ID=?",
                array($_GET['id']),TRUE);
            $usergroup=Array();
            //同理不检测数量，数量为0的话为空数组
            foreach($user_result as $row)
            {
                $user_unit=Array();
                $user_unit['display_name']=$row['user_displayname'];
                $user_unit['level']=$row['user_level'];

                $usergroup[]=$user_unit;


            }

            //TODO:找最新的5条，因为随机貌似有点问题？
            /*$moments_result=execMysql("SELECT * FROM moments
                                WHERE moments_assoID=? 
                                ORDER BY moments_ID DESC LIMIT 5",array($_GET['id']),true);
            $moments=Array();
            foreach ($moments_result as $row)
            {
                $moment_unit=Array();
                $moment_unit['title']=$row['moments_title'];

                $temp=execMysql("SELECT user_login FROM users WHERE ID=? limit 1",array($row['moments_senderID']),true);
                $temp=$temp->fetch();
                $moment_unit['display_name']=$temp['user_login'];

                $moment_unit['pictNum']=$row['moments_pictureNum'];
                $moment_unit['pictHeader']="./upload/users/user_id{$row['moments_senderID']}".
                    "/moments/moments_id{$row['moments_ID']}/header.jpg";

                //TODO:moments的超链接，等moments写好了再加
                $moment_unit['href']="";

                $moments[]=$moment_unit;
            }*/

            $event_result=execMysql("SELECT * FROM event
                                WHERE asso_ID=? ORDER BY asso_ID DESC LIMIT 5",
                array($_GET['id']),true);

            $events=Array();
            foreach ($event_result as $row)
            {
                $event_unit=Array();
                $event_unit['title']=$row['event_name'];
                $event_unit['number']=$row['pictureNum'];

                if(file_exists("./upload/society/society_{$row['asso_ID']}/event_{$row['event_ID']}/1.jpg"))
                {
                    $event_unit['pictHeader']="./upload/society/society_{$row['asso_ID']}/event_{$row['event_ID']}/1.jpg";
                }
                else
                {
                    $event_unit['pictHeader']="./images/logo.png";
                }

                $event_unit['href']="./event.php?id={$row['event_ID']}";

                $events[]=$event_unit;
            }

            //TODO:随机查找5个，但是网上说这种办法效率很低
            $member_result=execMysql("SELECT ID,user_login FROM usermeta,users
                                WHERE users.ID=usermeta.user_ID 
                                AND meta_key='subscribe_association' 
                                AND meta_value=? ORDER BY RAND() LIMIT 5",
                array($_GET['id']),true);

            $members=Array();
            foreach($member_result as $row)
            {
                //TODO: 等级先不考虑了,不是说好了没有关注度了吗？
                $member_unit=Array();
                $member_unit['name']=$row['user_login'];
                $member_unit['header']="./upload/users/user_id{$row['ID']}/header.jpg";
                //TODO:member的超链接，等user写好了再加
                $member_unit['href']="";

                $members[]=$member_unit;
            }

            $all_member_result=execMysql("SELECT user_login FROM usermeta,users
                                WHERE users.ID=usermeta.user_ID 
                                AND meta_key='subscribe_association' 
                                AND meta_value=? ORDER BY user_login",
                array($_GET['id']),true);

            $all_members=Array();
            foreach($all_member_result as $row)
            {
                //TODO: 等级先不考虑了,不是说好了没有关注度了吗？
                $all_member_unit=Array();
                $all_member_unit['name']=$row['user_login'];

                $all_members[]=$all_member_unit;
            }


            $name="";
            if(isset($_SESSION['ID']))
            {
                $user_result=execMysql("SELECT user_login FROM users WHERE ID=?",array($_SESSION['ID']),true);
                $name=$user_result->fetch()['user_login'];
            }

            echo $json=json_encode(array(
                "resultCode"=>200,
                "name"=>$asso_unit['association_name'],
                "category"=>$asso_unit['class'],
                "poster_img"=>$poster_img,
                "description"=>$asso_unit['association_description'],
                "contact"=>$asso_unit['association_contact'],
                "address"=>$asso_unit['association_address'],
                //"chat_message"=>$messages,
                "chat_users"=>$usergroup,
                //"moments"=>$moments,
                "events"=>$events,
                "members"=>$members,
                //"manager"=>$manager_name,
                "username"=>$name,
                "allmembers"=>$all_members
            ));
        }
    }
    elseif(isset($_POST['id']) && isset($_POST['action']))
    {
        if($_POST['action']==='update')
        {
            //检测是否存在相关必要参数
            if(isset($_POST['societynamee'])
                && isset($_POST['societycontactt'])
                && isset($_POST['societylocationn'])
                && isset($_POST['societydescriptionn'])
                && isset($_POST['societycategoryy']))
            {
                if(!isset($_SESSION['ID']))
                {
                    die(json_encode(array(
                        "resultCode"=>404,
                        "message"=>"Please login",
                    ))) ;
                }

                //判断修改的人是否存在权限（里面包含了检测社团，因为如果不存在该社团也就不存在该管理员
                $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
                    array($_POST['id'],$_SESSION['ID']),true);
                if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
                {
                    die(json_encode(array(
                        "resultCode"=>404,
                        "message"=>"You do not have permission"
                    ))) ;
                }

                //检测class，因为class只有固定的值
                $white_list=['Academic','Art','Culture','General_interest','Media','Outdoor',
                            'Sports'];
                if(!in_array($_POST['societycategoryy'],$white_list,true))
                {
                    die(json_encode(array(
                        "resultCode"=>404,
                        "message"=>"Category invaild"
                    ))) ;
                }


                $connection->beginTransaction();
                //第一步先修改相关信息
                $stmt=$connection->prepare("UPDATE association SET association_name=?,
                                    association_contact=?,
                                    association_address=?,
                                    association_description=?,
                                    class=?
                                    WHERE association_ID=?");
                $success=$stmt->execute(array($_POST['societynamee'],
                    $_POST['societycontactt'],
                    $_POST['societylocationn'],
                    $_POST['societydescriptionn'],
                    $_POST['societycategoryy'],
                    $_POST['id']));
                //如果修改失败
                if(!$success)
                {
                    $connection->rollBack();
                    die(json_encode(array(
                        "resultCode"=>404,
                        "message"=>"Update failed, please try again"
                    )));
                }



                //判断是否有上传文件
                if(isset($_FILES['file']['name']) && isset($_POST['id']))
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

                        $saveto="./upload/society/society_{$_POST['id']}/header.jpg";
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

                        }
                        else
                        {
                            //图片删除失败会导致之前上传成功的文件会被覆盖
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
                    "message"=>"Update successfully"
                )));
            }
        }
        elseif($_POST['action']==='add' && isset($_POST['user']))
        {
            if(!isset($_SESSION['ID']))
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Please login",
                ))) ;
            }

            //判断修改的人是否存在权限
            $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
                array($_POST['id'],$_SESSION['ID']),true);
            if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"You do not have permission"
                ))) ;
            }


            $asso_result=execMysql("SELECT memberNum FROM association 
                                WHERE association_ID=?",array($_POST['id']),true);

            //涉及社团不存在
            if($asso_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, the association is not exist"
                )));
            }

            //如果要加的用户不存在
            $user_result=execMysql("SELECT ID FROM users WHERE user_login=?",array($_POST['user']),true);
            if($user_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"The user does not exist"
                )));
            }

            $user=$user_result->fetch()['ID'];

            $check_result=execMysql("SELECT user_id FROM usermeta 
                                WHERE user_id=? AND
                                meta_key='subscribe_association' AND
                                meta_value=?",array($user,$_POST['id']),true);

            //如果这个人已经订阅了该社团
            if($check_result->rowCount()!==0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"The user has already subscribed the society"
                )));
            }

            $connection->beginTransaction();
            $stmt=$connection->prepare("INSERT INTO usermeta SET 
                                    user_id=?, 
                                    meta_key='subscribe_association',
                                    meta_value=?");

            $success=$stmt->execute(array($user,$_POST['id']));

            //更新usermeta失败
            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, please try again"
                )));
            }

            $stmt=$connection->prepare("INSERT INTO association_touser SET 
                                    chatroom_ID=?,
                                    user_id=?, 
                                    user_displayname=?,
                                    user_level=1");

            $success1=$stmt->execute(array($_POST['id'],$user,$_POST['user']));

            //更新association_touser失败
            if(!$success1)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, please try again"
                )));
            }

            $number=$asso_result->fetch()['memberNum'];
            $number++;

            $stmt=$connection->prepare("UPDATE association SET
                                    memberNum=? WHERE
                                    association_ID=?");

            $success2=$stmt->execute(array($number,$_POST['id']));
            //更新社团人数
            if(!$success2)
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
                "message"=>"Added successfully"
            ));
        }
        elseif ($_POST['action']==='delete' && isset($_POST['user']))
        {
            if(!isset($_SESSION['ID']))
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Please login",
                ))) ;
            }

            //判断修改的人是否存在权限
            $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
                array($_POST['id'],$_SESSION['ID']),true);
            if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"You do not have permission"
                ))) ;
            }

            $asso_result=execMysql("SELECT memberNum FROM association 
                                WHERE association_ID=?",array($_POST['id']),true);

            //涉及社团不存在
            if($asso_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, the association is not exist"
                )));
            }

            //如果要删除的用户不存在
            $user_result=execMysql("SELECT ID FROM users WHERE user_login=?",array($_POST['user']),true);
            if($user_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"The user does not exist"
                )));
            }

            $user=$user_result->fetch()['ID'];

            $check_result=execMysql("SELECT user_level FROM association_touser 
                                WHERE chatroom_ID=? AND 
                                user_ID=? ",array($_POST['id'],$user),true);

            //如果这个人没有订阅了该社团或者被删除的这个人是管理员
            if($check_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"The user does not subscribe the society"
                )));
            }
            elseif ($check_result->fetch()['user_level']===2)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, you cannot remove manager:)"
                )));
            }

            $connection->beginTransaction();
            $stmt=$connection->prepare("DELETE FROM usermeta WHERE
                                    user_id=? AND 
                                    meta_key='subscribe_association' AND 
                                    meta_value=?");

            $success=$stmt->execute(array($user,$_POST['id']));

            //从usermeta删除失败
            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, please try again"
                )));
            }


            $stmt=$connection->prepare("DELETE FROM association_touser WHERE
                                    chatroom_ID=? AND 
                                    user_ID=?");

            $success1=$stmt->execute(array($_POST['id'],$user));

            //更新失败
            if(!$success1)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, please try again"
                )));
            }

            //社团人数数量减一
            $number=$asso_result->fetch()['memberNum'];
            $number--;

            $stmt=$connection->prepare("UPDATE association SET
                                    memberNum=? WHERE
                                    association_ID=?");

            $success2=$stmt->execute(array($number,$_POST['id']));

            if(!$success2)
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
                "message"=>"Deleted successfully"
            ));
        }
        elseif($_POST['action']==='join')
        {
            //第一步判断用户是否已经登录
            if(!isset($_SESSION['ID']))
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Please login",
                ))) ;
            }

            //第二步判断是否存在该社团
            $asso_result=execMysql("SELECT memberNum FROM association WHERE association_ID=?",
                                        array($_POST['id']),true);

            if($asso_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"No such association exists",
                ))) ;
            }
            $asso=$asso_result->fetch();

            //第三步判断这个人是否已经订阅了社团
            $check_result=execMysql("SELECT user_id FROM usermeta 
                                WHERE user_id=? AND
                                meta_key='subscribe_association' AND
                                meta_value=?",array($_SESSION['ID'],$_POST['id']),true);

            //如果这个人已经订阅了该社团
            if($check_result->rowCount()!==0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"You have already subscribed the society"
                )));
            }

            //第四步开始更新，先更新usermeta表
            $connection->beginTransaction();
            $stmt=$connection->prepare("INSERT INTO usermeta SET 
                                        user_id=?,
                                        meta_key='subscribe_association',
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

            //第五步更新association_touser表

            //获取登录用户的用户名
            $user_result=execMysql("SELECT user_login FROM users WHERE ID=?",array($_SESSION['ID']),true);
            $username=$user_result->fetch()['user_login'];

            $stmt=$connection->prepare("INSERT INTO association_touser SET 
                                        chatroom_ID=?,
                                        user_ID=?,
                                        user_displayname=?,
                                        user_level=1");
            $success=$stmt->execute(array($_POST['id'],$_SESSION['ID'],$username));

            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, please try again"
                )));
            }

            //第六步更新association表格的社团人数

            $asso['memberNum']++;

            $stmt=$connection->prepare("UPDATE association SET memberNum=? WHERE association_ID=?");
            $success=$stmt->execute(array($asso['memberNum'],$_POST['id']));

            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, the user is not exist"
                )));
            }

            $connection->commit();
            echo json_encode(array(
                "resultCode"=>200,
                "message"=>"Joined successfully"
            ));

        }
        elseif ($_POST['action']==='exit')
        {
            //第一步判断用户是否已经登录
            if(!isset($_SESSION['ID']))
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Please log in at first",
                ))) ;
            }

            //第二步判断是否存在该社团
            $asso_result=execMysql("SELECT memberNum FROM association WHERE association_ID=?",
                array($_POST['id']),true);

            if($asso_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"No such association exists",
                ))) ;
            }
            $asso=$asso_result->fetch();

            //第三步判断这个人是否订阅了社团,并且要退出的这个人是否是管理员
            $check_result=execMysql("SELECT user_level FROM association_touser 
                                WHERE chatroom_ID=? AND 
                                user_ID=? ",array($_POST['id'],$_SESSION['ID']),true);

            //如果这个人没有订阅了该社团或者被删除的这个人是管理员
            if($check_result->rowCount()===0)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, the user does not subscribed the association"
                )));
            }
            elseif ($check_result->fetch()['user_level']===2)
            {
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, manager cannot cancel subscribe"
                )));
            }

            //第四步开始更新，先更新usermeta表
            $connection->beginTransaction();
            $stmt=$connection->prepare("DELETE FROM usermeta WHERE
                                    user_id=? AND 
                                    meta_key='subscribe_association' AND 
                                    meta_value=?");
            $success=$stmt->execute(array($_SESSION['ID'],$_POST['id']));

            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, the user is not exist"
                )));
            }

            //第五步更新association_touser表

            //获取登录用户的用户名
            $user_result=execMysql("SELECT user_login FROM users WHERE ID=?",array($_SESSION['ID']),true);
            $username=$user_result->fetch()['user_login'];

            $stmt=$connection->prepare("DELETE FROM association_touser WHERE
                                        chatroom_ID=? AND 
                                        user_ID=? AND 
                                        user_level=1");
            $success=$stmt->execute(array($_POST['id'],$_SESSION['ID']));

            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, the user is not exist"
                )));
            }

            //第六步更新association表格的社团人数

            $asso['memberNum']--;

            $stmt=$connection->prepare("UPDATE association SET memberNum=? WHERE association_ID=?");
            $success=$stmt->execute(array($asso['memberNum'],$_POST['id']));

            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Update failed, the user is not exist"
                )));
            }

            $connection->commit();
            echo json_encode(array(
                "resultCode"=>200,
                "message"=>"Subscribe successfully"
            ));
        }
    }
    elseif(isset($_POST['action']) && $_POST['action']==='create')
    {
        //第一步判断用户是否登录
        if(!isset($_SESSION['ID']))
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Please login",
            ))) ;
        }


        $default_name='society'.rand(1, 100000);

        $connection->beginTransaction();

        //第二步更新association表
        $success=$connection->exec("INSERT INTO association SET 
                                      association_name='{$default_name}',
                                      memberNum=1,
                                      association_description='',
                                      association_contact='',
                                      association_address='',
                                      class='Academic'");

        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again",
            ))) ;
        }

        $asso_result=execMysql("SELECT association_ID FROM association 
                            WHERE association_name=? ORDER BY association_ID DESC limit 0,1",array($default_name),true);

        $asso_ID=$asso_result->fetch()['association_ID'];

        //第三步更新usermeta表
        $stmt=$connection->prepare("INSERT INTO usermeta SET 
                                    user_id=?,
                                    meta_key='subscribe_association',
                                    meta_value=?");
        $success=$stmt->execute(array($_SESSION['ID'],$asso_ID));
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Create failed, please try again"
            ))) ;
        }

        //第四步更新association_touser表
        //先查找用户ID对应的用户名
        $user_result=execMysql("SELECT user_login FROM users WHERE ID=?",array($_SESSION['ID']),true);
        $username=$user_result->fetch()['user_login'];

        $stmt=$connection->prepare("INSERT INTO association_touser SET 
                                    chatroom_ID=?,
                                    user_ID=?,
                                    user_displayname=?,
                                    user_level=?");
        $success=$stmt->execute(array($asso_ID,$_SESSION['ID'],$username,2));
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Create failed, please try again"
            ))) ;
        }

        //创建文件夹
        if(file_exists("./upload/society/society_{$asso_ID}"))
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Create failed, please try again"
            ))) ;
        }

        mkdir("./upload/society/society_{$asso_ID}",false);


        $connection->commit();
        echo json_encode(array(
            "resultCode"=>200,
            "association_ID"=>$asso_ID
        ));

    }







    /*//TODO:查询社团相关信息
    if(isset($_GET['id']))
    {
        $association=execMysql("SELECT * FROM association WHERE association_ID=?",array($_GET['id']),TRUE);
        if($association->rowCount()===0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Cannot find such society"
            ))) ;
            //
        }
        $asso_unit=$association->fetch();

        //图片地址
        $poster_img=Array();
        for($i=1;$i<=$asso_unit['pictureNum'];$i++)
        {
            $filepath="./upload/society/society_{$_GET['id']}/{$i}.jpg";
            $poster_img[]=$filepath;
        }

        $message_result=execMysql("SELECT *,UNIX_TIMESTAMP(msg_date) as timestamp 
                    FROM groupmsg WHERE chatroom_ID=? ORDER BY msg_date",
                    array($_GET['id']),TRUE);
        //这里不检测数量了，数量为0的话为空数组
        $messages=Array();
        foreach ($message_result as $row)
        {
            $message_unit=Array();
            $message_unit['displayname']=$row['msg_sendername'];

            //发表时间,现在变成了7个小时，到时候到了冬令时要改成8
            $timediff=time()-$row['timestamp']-7*3600;
            if($timediff>60*60*24)
            {
                $timeago=floor($timediff/86400);
                //echo "$timeago days ago";
                $timeans="$timeago days ago";
            }
            elseif ($timediff>60*60)
            {
                $timeago=floor($timediff/3600);
                //echo "$timeago hours ago";
                $timeans="$timeago hours ago";
            }
            else
            {
                $timeago=floor($timediff/60);
                //echo "$timeago minutes ago";
                $timeans="$timeago minutes ago";
            }

            $message_unit['time']=$timeans;
            $message_unit['content']=$row['msg_content'];

            $messages[]=$message_unit;
        }

        $user_result=execMysql("SELECT * FROM association_touser WHERE chatroom_ID=?",
                    array($_GET['id']),TRUE);
        $usergroup=Array();
        //同理不检测数量，数量为0的话为空数组
        foreach($user_result as $row)
        {
            $user_unit=Array();
            $user_unit['display_name']=$row['user_displayname'];
            $user_unit['level']=$row['user_level'];

            $usergroup[]=$user_unit;


        }

        //TODO:找最新的5条，因为随机貌似有点问题？
        $moments_result=execMysql("SELECT * FROM moments 
                                WHERE moments_assoID=? 
                                ORDER BY moments_ID DESC LIMIT 5",array($_GET['id']),true);
        $moments=Array();
        foreach ($moments_result as $row)
        {
            $moment_unit=Array();
            $moment_unit['title']=$row['moments_title'];

            $temp=execMysql("SELECT user_login FROM users WHERE ID=? limit 1",array($row['moments_senderID']),true);
            $temp=$temp->fetch();
            $moment_unit['display_name']=$temp['user_login'];

            $moment_unit['pictNum']=$row['moments_pictureNum'];
            $moment_unit['pictHeader']="./upload/users/user_id{$row['moments_senderID']}".
                                        "/moments/moments_id{$row['moments_ID']}/header.jpg";

            //TODO:moments的超链接，等moments写好了再加
            $moment_unit['href']="";

            $moments[]=$moment_unit;
        }

        $event_result=execMysql("SELECT * FROM event
                                WHERE asso_ID=? ORDER BY asso_ID DESC LIMIT 5",
                                array($_GET['id']),true);

        $events=Array();
        foreach ($event_result as $row)
        {
            $event_unit=Array();
            $event_unit['title']=$row['event_name'];
            $event_unit['number']=$row['pictureNum'];

            $event_unit['pictHeader']="./upload/society_{$row['asso_ID']}/event_{$row['event_ID']}/header.jpg";
            $event_unit['href']="./event.php?id={$row['event_ID']}";

            $events[]=$event_unit;
        }

        //TODO:随机查找5个，但是网上说这种办法效率很低
        $member_result=execMysql("SELECT ID,user_login FROM usermeta,users
                                WHERE users.ID=usermeta.user_ID 
                                AND meta_key='subscribe_association' 
                                AND meta_value=? ORDER BY RAND() LIMIT 5",
                                array($_GET['id']),true);

        $members=Array();
        foreach($member_result as $row)
        {
            //TODO: 等级先不考虑了,不是说好了没有关注度了吗？
            $member_unit=Array();
            $member_unit['name']=$row['user_login'];
            $member_unit['header']="./upload/users/user_id{$row['ID']}/header.jpg";
            //TODO:member的超链接，等user写好了再加
            $member_unit['href']="";

            $members[]=$member_unit;
        }

        $manager_result=execMysql("SELECT user_displayname FROM association_touser 
                                    WHERE chatroom_ID=? AND user_level=2",
                                    array($_GET['id']),true);

        if($manager_result->rowCount()===0)
        {
            $manager_name="";
        }
        else
        {
            $manager_name=$manager_result->fetch()['user_displayname'];
        }


        echo $json=json_encode(array(
            "resultCode"=>200,
            "name"=>$asso_unit['association_name'],
            "category"=>$asso_unit['class'],
            "poster_img"=>$poster_img,
            "description"=>$asso_unit['association_description'],
            "contact"=>$asso_unit['association_contact'],
            "address"=>$asso_unit['association_address'],
            "chat_message"=>$messages,
            "chat_users"=>$usergroup,
            "moments"=>$moments,
            "events"=>$events,
            "members"=>$members,
            "manager"=>$manager_name,
        ));

        //file_put_contents('test.json', $json);
    }
    //TODO:用于修改社团
    elseif(isset($_POST['societynamee'])
        && isset($_POST['societycontactt'])
        && isset($_POST['societylocationn'])
        && isset($_POST['managernamee'])
        && isset($_POST['societydescriptionn'])
        && isset($_POST['societycategoryy'])
        && isset($_POST['id']))
    {
        if(!isset($_SESSION['ID']))
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Please log in at first",
            ))) ;
        }

        //判断修改的人是否存在权限
        $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
            array($_POST['id'],$_SESSION['ID']),true);
        if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"You do not have permission"
            ))) ;
        }

        $connection->beginTransaction();
        //第一步先修改除了管理员的相关信息
        $stmt=$connection->prepare("UPDATE association SET association_name=?,
                                    association_contact=?,
                                    association_address=?,
                                    association_description=?,
                                    class=?
                                    WHERE association_ID=?");
        $success=$stmt->execute(array($_POST['societynamee'],
                            $_POST['societycontactt'],
                            $_POST['societylocationn'],
                            $_POST['societydescriptionn'],
                            $_POST['societycategoryy'],
                            $_POST['id']));
        //如果修改失败
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again"
            )));
        }


        //成功的话,第二步将所有社团涉及到的level为2的成员改成1
        $stmt=$connection->prepare("UPDATE association_touser 
                                SET user_level=1
                                WHERE chatroom_ID=? AND user_level=2");

        $success1=$stmt->execute(array($_POST['id']));

        //如果修改失败
        if(!$success1)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again"
            )));
        }


        //成功的话，第三步判断要成为管理员的那个用户是否存在
        $manager_result=execMysql("SELECT ID FROM users WHERE user_login=?",
                        array($_POST['managernamee']),true);
        if($manager_result->rowCount()===0)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, the user is not exist"
            )));
        }


        //成功的话，第四步将目标用户修改为2
        $stmt=$connection->prepare("UPDATE association_touser 
                            SET user_level=2
                            WHERE chatroom_ID=? AND user_displayname=?");

        $success2=$stmt->execute(array($_POST['id'],$_POST['managernamee']));

        if(!$success2)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again"
            )));
        }

        //判断是否有上传文件
        if(isset($_FILES['file']['name']) && isset($_POST['id']))
            //if(isset($_FILES['file']['name']))
        {

            if ($_FILES["file"]["error"] > 0)
            {
                echo "Error: " . $_FILES["file"]["error"] . "<br />";
            }
            else
            {
                //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                //echo "Type: " . $_FILES["file"]["type"] . "<br />";
                //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                //echo "Stored in: " . $_FILES["file"]["tmp_name"];

                $saveto="./upload/society_{$_POST['id']}/header.jpg";
                //$saveto="header.jpg";

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
                    move_uploaded_file($_FILES['file']['tmp_name'],$saveto);

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

                }
                else
                {
                    $connection->rollBack();
                    die(json_encode(array(
                        "resultCode"=>404,
                        "message"=>"Please only upload jpg,png"
                    )));
                }
            }

        }

        $connection->commit();
        die(json_encode(array(
            "resultCode"=>200,
            "message"=>"Update successfully"
        )));
    }
    //TODO:管理员拉人
    elseif(isset($_POST['id'])
        && isset($_POST['add']))
    {

        if(!isset($_SESSION['ID']))
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Please log in at first",
            ))) ;
        }

        //判断修改的人是否存在权限
        $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
            array($_POST['id'],$_SESSION['ID']),true);
        if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"You do not have permission"
            ))) ;
        }


        $asso_result=execMysql("SELECT memberNum FROM association 
                                WHERE association_ID=?",array($_POST['id']),true);

        //涉及社团不存在
        if($asso_result->rowCount()===0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, the association is not exist"
            )));
        }

        //如果要加的用户不存在
        $user_result=execMysql("SELECT ID FROM users WHERE user_login=?",array($_POST['add']),true);
        if($user_result->rowCount()===0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, the user is not exist"
            )));
        }

        $user=$user_result->fetch()['ID'];

        $check_result=execMysql("SELECT user_id FROM usermeta 
                                WHERE user_id=? AND
                                meta_key='subscribe_association' AND
                                meta_value=?",array($user,$_POST['id']),true);

        //如果这个人已经订阅了该社团
        if($check_result->rowCount()!==0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, the user has subscribed the association"
            )));
        }

        $connection->beginTransaction();
        $stmt=$connection->prepare("INSERT INTO usermeta SET 
                                    user_id=?, 
                                    meta_key='subscribe_association',
                                    meta_value=?");

        $success=$stmt->execute(array($user,$_POST['id']));

        //更新usermeta失败
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again"
            )));
        }

        $stmt=$connection->prepare("INSERT INTO association_touser SET 
                                    chatroom_ID=?,
                                    user_id=?, 
                                    user_displayname=?,
                                    user_level=1");

        $success1=$stmt->execute(array($_POST['id'],$user,$_POST['add']));

        //更新association_touser失败
        if(!$success1)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again"
            )));
        }

        $number=$asso_result->fetch()['memberNum'];
        $number++;

        $stmt=$connection->prepare("UPDATE association SET
                                    memberNum=? WHERE
                                    association_ID=?");

        $success2=$stmt->execute(array($number,$_POST['id']));
        //更新社团人数
        if(!$success2)
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
            "message"=>"Add successfully"
        ));
    }

    //TODO:管理员踢人
    elseif (isset($_POST['id'])
        && isset($_POST['delete']))
    {
        if(!isset($_SESSION['ID']))
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Please log in at first",
            ))) ;
        }

        //判断修改的人是否存在权限
        $permission=execMysql("SELECT user_level FROM association_touser 
                            WHERE chatroom_ID=? AND user_ID=?",
            array($_POST['id'],$_SESSION['ID']),true);
        if($permission->rowCount()===0 || $permission->fetch()['user_level']<2)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"You do not have permission"
            ))) ;
        }

        $asso_result=execMysql("SELECT memberNum FROM association 
                                WHERE association_ID=?",array($_POST['id']),true);

        //涉及社团不存在
        if($asso_result->rowCount()===0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, the association is not exist"
            )));
        }

        //如果要删除的用户不存在
        $user_result=execMysql("SELECT ID FROM users WHERE user_login=?",array($_POST['delete']),true);
        if($user_result->rowCount()===0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, the user is not exist"
            )));
        }

        $user=$user_result->fetch()['ID'];

        $check_result=execMysql("SELECT user_id FROM usermeta 
                                WHERE user_id=? AND
                                meta_key='subscribe_association' AND
                                meta_value=?",array($user,$_POST['id']),true);

        //如果这个人没有订阅了该社团
        if($check_result->rowCount()===0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, the user does not subscribed the association"
            )));
        }

        $connection->beginTransaction();
        $stmt=$connection->prepare("DELETE FROM usermeta WHERE
                                    user_id=? AND 
                                    meta_key='subscribe_association' AND 
                                    meta_value=?");

        $success=$stmt->execute(array($user,$_POST['id']));

        //从usermeta删除失败
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again"
            )));
        }


        $stmt=$connection->prepare("DELETE FROM association_touser WHERE
                                    chatroom_ID=? AND 
                                    user_ID=?");

        $success1=$stmt->execute(array($_POST['id'],$user));

        //更新失败
        if(!$success1)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again"
            )));
        }

        $number=$asso_result->fetch()['memberNum'];
        $number--;

        $stmt=$connection->prepare("UPDATE association SET
                                    memberNum=? WHERE
                                    association_ID=?");

        $success2=$stmt->execute(array($number,$_POST['id']));

        if(!$success2)
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
            "message"=>"Delete successfully"
        ));
    }
    elseif (isset($_GET['join']))
    {

    }*/


?>
