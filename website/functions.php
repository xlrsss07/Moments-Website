<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2019/3/23
 * Time: 20:41
 */
    /*
     * 下面是数据库的参数，每次移植都需要改，对应到那边的数据库的值
     *
     * 以下放出认为书中不需要加的东西，给出原因，方便之后添加
     * createTable：手动添加
     * queryMysql：并没有使用预处理语句，书上给的是杀毒处理，处于安全性考虑，
     *              使用预处理，效率不高再换，决定用其他函数代替
     * showProfile:显示用户图像的，数据库还没搭好所以先不写那个，因为图像这东西不仅包含用户还有社团还有聊天记录
     *
     * 由于开发途中想把所有查询和执行语句集中在一个函数，但是对于函数来说预处理的参数和处理语句是不确定的，
     * mysqli在处理预处理语句后不能够通过一个数组或者其他方式来处理不确定个数的参数，所以换成PDO,
     * 但是毕竟mysqli看起来舒服一点
     *
     * 如果知道mysqli怎么做请联系我
     *
     * fileFormatList:全局变量，一个包含所有可能的图片格式，随着需求改变而改变。因为用户上传的网页不一定是统一格式的，
     *              所以提供给所有需要调用图片的地方。要么使用列表遍历，要么在数据库中记录，要么就自己后端统一将用户
     *              上传的文件格式统一。
     */
    //TODO:还有一个问题是为什么网页上面的图案在js代码里面改不行，正常样是可以的，需要一个大佬来解决

    $appname="Moment";//TODO:这个是为了兼容性而建立起来的变量，前端到时候改了记得删掉

    //设置时区，从某种角度上说某个网页凡是要用数据库的以及调用时间的都要调用这个文件
    date_default_timezone_set("Europe/London");

    $fileFormatList=['.jpg','.jpeg'];


    $db_hostname='192.168.184.129'; //数据库IP，这个是本地测试地址，如果移植到网站服务器，一般为localhost
    $db_database = "test_website";    //数据库的对应数据库
    $db_username = "XXXXX";    //数据库用户名
    $db_password = "xxxxx";    //数据库密码
    $db_charset = "utf8mb4";    //不用管,貌似没什么屌用
    $dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    );

    //注意mysqli和pdo处理连接错误不一样
    try
    {
        $connection = new PDO($dsn,$db_username,$db_password,$opt);//连接数据库
    }
    catch (PDOException $e)//异常定位在没有成功连接数据库
    {
        die("can not connect to this database");
    }

    function destorySession()
    {
        $_SESSION=array();

        //如果当前SESSION的ID不会空或者还带有会话名称的cookie
        if(session_id()!="" || isset($_COOKIE[session_name()]))
        {
            //删除cookie
            setcookie(session_name(),"",time()-2592000,'');
        }
        //本地销毁一个会话中的全部数据
        session_destroy();
    }

    /*
     * 净化用户输入，个人主要认为防XSS，虽然SQL有了预处理，但是还是要在外面一层过滤
     * 个人认为在熟悉使用这个函数前最好多比较一下输出前和输出后的样子
     *
     * 书上函数还给了一个real_escape_string，但是这里由于用的不是mysqli，所以没办法用了
     */
    function sanitizeString($var)
    {
        //global  $connection;
        $var=strip_tags($var); //从字符串中去除 HTML 和 PHP 标记
        $var=htmlentities($var); //将字符转换为 HTML 转义字符
        $var=stripslashes($var); //返回一个去除转义反斜线后的字符串
        return $var; //根据当前连接的字符集，对于 SQL 语句中的特殊字符进行转义
    }

    /*
     * 代替queryMysql，使用预处理技术，使用方法如下：
     * 第一个参数为执行语句，第二个参数为数组类型，保存执行语句中变量,
     * 第三个参数为boolean，表示执行语句是否是查询语句
     *
     * 比如要查询用户表中是否在一个用户名为test，密码为123456的用户，则写成
     * execMysql("SELECT * FROM user WHERE username=? AND password=?",array("test","123456"));
     *
     * 如果执行语句没有变量比如SELECT * FROM user，那么第二参数统一写成NULL
     * execMysql("SELECT * FROM user",NULL);
     *
     * 返回值为结果，查询的话就是关联数组，非查询语句就是返回执行是否成功，即FALSE或者TRUE
     *
     * 如果未来需要启用事务功能，可以在这里修改，或者不使用这个函数
     */
    function execMysql($exec,$arr,$query)
    {
        global $connection;
        try
        {
            $stmt=$connection->prepare($exec);
        }
        catch (PDOException $e)//异常定位在执行语句出现错误
        {
            echo $e,"<br>";
        }

        if(empty($arr))
            $success=$stmt->execute();
        else
            $success=$stmt->execute($arr);

        if($query)
            return $stmt;
        else
            return $success;
    }

    //TODO:先拿404挡一下，到时候换成302重定向，参数为跳转的网站
    function die404()
    {
        die("404 not found");
    }

    //将数据库返回的时间跟目前的时间计算时间差
    //理论上$time为string类型，格式为2019-03-23 23:14:00
    function time_difference($time)
    {

    }
?>





