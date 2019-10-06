<?php
    require_once "functions.php";

    if(isset($_GET['action']) && $_GET['action']==='search')
    {
        $moments_result=$connection->query("SELECT * FROM moments ORDER BY moments_ID DESC");

        $moments=array();
        foreach($moments_result as $row)
        {
            $moments_unit=array();

            $displayname_result=execMysql("SELECT user_login FROM users WHERE ID=?",
                array($row['moments_senderID']),true);

            //发表moments的用户名
            $moments_unit['displayname']=$displayname_result->fetch()['user_login'];

            if(file_exists("./upload/users/user_id{$row['moments_senderID']}/header.jpg"))
            {
                $moments_unit['header']="./upload/users/user_id{$row['moments_senderID']}/header.jpg";
            }
            else
            {
                $moments_unit['header']="./images/logo.png";
            }

            $moments_unit['time']=substr($row['moments_date'],5);

            $moments_unit['content']=$row['moments_description'];
            $moments_unit['img']=array();
//            if($row['moments_pictureNum']===0)
//            {
//                //默认图片路径
//                $moments_unit['img'][0]="./images/logo.png";
//            }
//            else
//            {
                //for($i=1;$i<=$row['moments_pictureNum'];$i++)
                //{
            if(file_exists("./upload/users/user_id{$row['moments_senderID']}/moments/moments_id{$row['moments_ID']}/1.jpg"))
            {
                $moments_unit['img'][]="./upload/users/user_id{$row['moments_senderID']}/moments/moments_id{$row['moments_ID']}/1.jpg";
            }
            else
            {
                $moments_unit['img'][]="./images/logo.png";
            }

                //}
            //}
            $moments[]=$moments_unit;

        }

        echo $json=json_encode(array(
            "resultCode"=>200,
            //"displayname"=>$user['user_login'],
            //"header"=>"./upload/users/user_id{$_GET['id']}/header.jpg",
            "moments"=>$moments
        ));
    }
    elseif(isset($_POST['action']))
    {
        //发表moments，TODO:之所以不跟上面合并是因为可能存在其他操作
        if($_POST['action']==='publish' &&
            isset($_SESSION['ID']) &&
            isset($_POST['description']))
        {
            $connection->beginTransaction();
            $stmt=$connection->prepare("INSERT INTO moments SET 
                                    moments_senderID=?,
                                    moments_date=?,
                                    moments_description=?,
                                    moments_pictureNum=0");

            //净化输入
            $description=sanitizeString($_POST['description']);


            $success=$stmt->execute(array($_SESSION['ID'],
                                        date('Y-m-d H:i:s', time()),
                                        $description));

            if(!$success)
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Publish failed, please try again"
                )));
            }

            //获取添加的对应moments的ID
            $moments_result=execMysql("SELECT moments_ID FROM moments 
                                    WHERE moments_senderID=? AND
                                    moments_description=? AND 
                                    moments_pictureNum=0 ORDER BY moments_ID DESC LIMIT 0,1",
                                    array($_SESSION['ID'],
                                    $description),true);

            $moments=$moments_result->fetch();

            //先创建对应的文件夹，因为需求变更，导致文件夹只可能出现0或一个图片
            //创建文件夹
            if(file_exists("./upload/users/user_id{$_SESSION['ID']}/moments/moments_id{$moments['moments_ID']}"))
            {
                $connection->rollBack();
                die(json_encode(array(
                    "resultCode"=>404,
                    "message"=>"Create failed, please try again"
                ))) ;
            }

            mkdir("./upload/users/user_id{$_SESSION['ID']}/moments/moments_id{$moments['moments_ID']}",false);

            //TODO:判断是否有上传文件
            if(isset($_FILES['file']['name']))
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

                    $saveto="./upload/users/user_id{$_SESSION['ID']}/moments/moments_id{$moments['moments_ID']}/1.jpg";
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
                    }
                    else
                    {
                        unlink($saveto);
                        rmdir("./upload/users/user_id{$_SESSION['ID']}/moments/moments_id{$moments['moments_ID']}");
                        $connection->rollBack();
                        die(json_encode(array(
                            "resultCode"=>404,
                            "message"=>"Please only upload jpg,png"
                        )));
                    }
                }

            }

            $connection->commit();
//            echo json_encode(array(
//                "resultCode"=>200,
//                "message"=>"Publish successfully"
//            ));

            header('location:moments.php');


        }
    }

