<?php
    require_once 'functions.php';
     //判断是否有上传文件
    global $connection;
    //$_SESSION['ID']=2;
    if(isset($_SESSION['ID'])&&isset($_GET['my']))
    {
        $my = execMysql("SELECT * FROM users WHERE ID=?", array($_SESSION['ID']), TRUE);
        $row=$my->fetch();
        $user_name = $row['user_login'];
        $signature = $row['signature'];
        $user_email=$row['user_email'];
        $user_address=$row['address'];
        if(file_exists("./upload/users/user_id{$_SESSION['ID']}/header.jpg"))
        {
            $user_img = "./upload/users/user_id{$_SESSION['ID']}/header.jpg";
        }
        else
        {
            $user_img = "./images/logo.png";
        }



    //    if(isset($_POST['submit'])) {

        //}

        echo $json=json_encode(array(
            "resultCode"=>200,
            "username"=>$user_name,
            "user"=>$user_img,
            "signature"=>$signature,
            "user_email"=>$user_email,
            "useraddress"=>$user_address,

        ));
        //file_put_contents('test.json', $json);



    }
    elseif(isset($_SESSION['ID']) && isset($_POST['signature']) && isset($_POST['email'])&&isset($_POST['address']))
    {

        $connection->beginTransaction();
        $stmt=$connection->prepare("UPDATE users SET 
                                              address=?,
                                              user_email=?,
                                              signature=? WHERE ID=?");
        $success=$stmt->execute(array($_POST['address'],$_POST['email'],$_POST['signature'],$_SESSION['ID']));
        if(!$success)
        {
            $connection->rollBack();
            die(json_encode(array(
                "resultCode"=>404,
                "message"=>"Update failed, please try again"
            )));
        }

        if (isset($_FILES['file']['name']) && isset($_SESSION['ID'])) //if(isset($_FILES['avatar_file']['name']))
        {
            echo $_FILES['file']['name'];

            if ($_FILES["file"]["error"] > 0) {
    //            echo "Error: " . $_FILES["file"]["error"] . "<br />";
            } else {
                //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                //echo "Type: " . $_FILES["file"]["type"] . "<br />";
                //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                //echo "Stored in: " . $_FILES["file"]["tmp_name"];

                $saveto = "./upload/users/user_id{$_SESSION['ID']}/header.jpg";

    //            $my = execMysql("SELECT * FROM users WHERE ID=?", array($_SESSION['ID']), TRUE);
    //            $new_pic[]=$saveto;

                move_uploaded_file($_FILES['file']['tmp_name'], $saveto);

                $typeok = TRUE;

                switch ($_FILES['file']['type']) {
                    case "image/jpeg":  // Both regular and progressive jpegs
                    case "image/pjpeg":
                        $src = imagecreatefromjpeg($saveto);
                        break;
                    case "image/png":
                        $src = imagecreatefrompng($saveto);
                        break;
                    default:
                        $typeok = FALSE;
                        break;
                }

                if ($typeok) {
                    //move_uploaded_file($_FILES['file']['tmp_name'], $saveto);
                    list($w, $h) = getimagesize($saveto);
                    $tw = $w;
                    $th = $h;
                    $tmp = imagecreatetruecolor($tw, $th);
                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
                    //imageconvolution($tmp, array(array(-1, -1, -1),
                    //array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
                    imagejpeg($tmp, $saveto);
                    imagedestroy($tmp);
                    imagedestroy($src);
                } else {
                    unlink($saveto);
                    $connection->rollBack();
                    die(json_encode(array(
                        "resultCode" => 404,
                        "message" => "Please only upload jpg,png"
                    )));
                }
            }
        }


        $connection->commit();
//        echo json_encode(array(
//            "resultCode"=>200,
//            "message"=>"Update successfully"
//        ));
        die("<script>history.go(-1)</script>");

    }



?>