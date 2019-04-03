<?php
    /*
     * 关于对这个页面的问题以及注意事项放在这里
     *
     * TODO: 为什么网页只有3个地方调用js文件但是目录有4个js文件？但这个问题不是特别重要，不会影响后端开发
     *
     * font的文件夹在有css文件调用，由于用的是css文件给的是相对路径所以这里把它放在了css/fonts中
     *
     * 同样跟home.php一样，因为个人开发的原因，可能出现css和js重名，为了解决这个问题先暂时给每个人的js文件专门
     * 分配一个文件夹，在这里就是放在/js/home
     *
     * TODO:跟前端提前商量好后端数据库可以提供什么，防止对面乱写，必要的情况下后端这里加上去。
     * TODO:还有提醒他们别把最好别把图片重命名了，看一下目前的图片名字然后改一下
     *
     * TODO:home对应的index.css文件中出现问题,后端这里查不出来logo.png又显示不出来了。。。
     * TODO:经过半个小时排错已解决，不知道为什么不能使用../../来退后两级。只能在前面加上./表示当前路径
     *
     * Time似乎缺少一个具体时间，跟前端商量是用什么格式
     *
     * 还有event页面上没有活动标题，如果有，在哪？css文件中貌似没有background图片
     *
     * 两个人交的东西部分地方调用了不存在的文件
     *
     * home这里的事件图片和event显示的图片分辨率不一样，怎么处理，一个是封面图像，一个是海报
     *
     * 叫前端别在CSS文件里面设置图片路径，因为这样似乎不太方便用php替换。保险一点叫前端现场改
     *
     * 开会中，谁没事的就叫他将之前home网页用户的图片转成jpg
     * 谁没事的就找下怎么固定设置网络当前路径
     */

    //跟home原理，如果没有输入id参数，就暂时变成404 not found，到了后期再换成302重定向到其他页面上去
    require_once 'functions.php';

    if(!isset($_GET['id']))
    {
        die404();
    }

    $event=execMysql("SELECT * FROM event WHERE event_ID=?",array($_GET['id']),TRUE);
    $eventunit=$event->fetch();

    //下面这一部分是测试语句
    /*
     * TODO:$eventunit['event_name']保存的是活动名字或称为标题
     * TODO:$eventunit['event_date']保存的是活动日期
     * TODO:$eventunit['event_location']保存的是活动地点
     * TODO:$eventunit['event_description']保存的是活动描述
     */
    echo "<pre>";
    var_dump($eventunit['event_name']);
    echo "\n";
    var_dump($eventunit['event_date']);
    echo "\n";
    var_dump($eventunit['event_location']);
    echo "\n";
    var_dump($eventunit['event_description']);
    echo "</pre>";

    //时间输出格式为2019-03-25 22:41:00



    /*-------------这是截止线--------------------*/

    //TODO:date("l jS F Y", $d)里面保存着活动日期，但是不包含具体时间，需要跟前端商量
    $temp=explode(' ',$eventunit['event_date']);
    //var_dump($temp);
    list($year,$month,$day)=explode("-",$temp[0]);
    list($hour,$minute,$second)=explode(":",$temp[1]);

    //echo $year," ",$month," ",$day," ",$hour," ",$minute," ",$second,"<br>";

    $d=mktime($hour, $minute, $second, $month, $day, $year);
    //echo date("l jS F Y", $d);

    /*---------------------这是分割线--------------------*/

    /*
     * TODO: $row['comment_display_name']保存着某个评论用户的网名
     * TODO: date("j F Y", $d)保存着评论日期，但是没有具体时间
     * TODO: $row['comment_content']保存着评论内容
     */

    $comment_user=execMysql("SELECT * FROM comment WHERE comment_event_ID=?",array($_GET['id']),TRUE);

    foreach($comment_user as $row)
    {
        echo "Displayname: ",$row['comment_display_name'],"<br>";

        $temp=explode(' ',$row['comment_date']);
        //var_dump($temp);
        list($year,$month,$day)=explode("-",$temp[0]);
        list($hour,$minute,$second)=explode(":",$temp[1]);

        //echo $year," ",$month," ",$day," ",$hour," ",$minute," ",$second,"<br>";

        $d=mktime($hour, $minute, $second, $month, $day, $year);
        //echo date("j F Y", $d);

        echo "Content; ",$row['comment_content'],"<br>";

        //TODO：目前用户上传文件只有这两种格式，到时候再加，当然home那里还没加，到了适合时间在做统一处理

        //fileFormatList放在function.php，因为觉得这个会很常用。
        foreach($fileFormatList as $format)
        {
            $file=$row['comment_user_ID'].$format;
            if(file_exists("./upload/users/$file"))
            {
                echo $file;
                break;
            }
        }

    }

?>