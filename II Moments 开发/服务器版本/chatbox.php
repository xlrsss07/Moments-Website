<?php
    require_once 'functions.php';


    if(isset($_GET['id']))
    {
        //TODO:查询名字放在前面，判断是否存在这个社团

        $name_result=execMysql("SELECT association_name
                                    FROM association WHERE association_ID=?",
                                    array($_GET['id']),true);

        if($name_result->rowCount()===0)
        {
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"No such society exists",
            )));
        }

        $name=$name_result->fetch()['association_name'];


        $message_result=execMysql("SELECT * FROM groupmsg
                            WHERE chatroom_ID=? AND
                            TIMESTAMPDIFF(SECOND,`msg_date`,NOW())<=30",
                            array($_GET['id']),true);

        /*$message_result=execMysql("SELECT *,UNIX_TIMESTAMP(msg_date) as timestamp
                    FROM groupmsg WHERE chatroom_ID=? ORDER BY msg_date",
            array($_GET['id']),TRUE);
        */
        //这里不检测数量了，数量为0的话为空数组
        $messages=Array();
        foreach ($message_result as $row)
        {
            $message_unit=Array();
            $message_unit['ID']=$row['msg_ID'];
            $message_unit['displayname']=$row['msg_sendername'];

            $message_unit['time']=substr($row['msg_date'],5);
            $message_unit['content']=$row['msg_content'];

            $message_unit['header']="./upload/users/user_id{$row['msg_senderID']}/header.jpg";

            $messages[]=$message_unit;
        }

        $header="./upload/society/society_{$_GET['id']}/header.jpg";

        $username="Visitor";
        if(isset($_SESSION['ID']))
        {
            if(file_exists("./upload/users/user_id{$_SESSION['ID']}/header.jpg"))
            {
                $userheader="./upload/users/user_id{$_SESSION['ID']}/header.jpg";
            }
            else
            {
                $userheader="images/chatbox/user.jpg";
            }

            $user_result=execMysql("SELECT user_login FROM users WHERE ID=?",array($_SESSION['ID']),true);

            $username=$user_result->fetch()['user_login'];
        }



        echo json_encode(array(
            "resultCode"=>200,
            "chat_message"=>$messages,
            "header"=>$header,
            "name"=>$name,
            "userheader"=>$userheader,
            "username"=>$username
        ));
    }
    elseif(isset($_POST['id']) && isset($_SESSION['ID']) && isset($_POST['content']))
    {
        //过滤发信息的内容
        $content=sanitizeString($_POST['content']);


        $connection->beginTransaction();
        $stmt=$connection->prepare("INSERT INTO groupmsg SET
                                        chatroom_ID=?,
                                        msg_senderID=?,
                                        msg_sendername=?,
                                        msg_senderIP=?,
                                        msg_date=now(),
                                        msg_content=?,
                                        msg_agent=?");

        //获取发送方的名字
        $user_result=execMysql("SELECT user_login FROM users WHERE ID=?",array($_SESSION['ID']),true);


        $success=$stmt->execute(array($_POST['id'],
                                $_SESSION['ID'],
                                $user_result->fetch()['user_login'],
                                $_SERVER['REMOTE_ADDR'],
                                $content,
                                $_SERVER['HTTP_USER_AGENT']));
        //如果更新失败
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Failed to send the message",
            )));
        }


        $connection->commit();

        echo json_encode(array(
            "resultCode"=>200,
            "message"=>"Update successfully",
        ));


    }
    else
    {
        echo json_encode(array(
            "resultCode"=>404,
            "message"=>"Please login.",
        ));
    }
