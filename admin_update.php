<?php
session_start(); //啟用 session 功能

if (isset($_SESSION["u_privilege"])==false or ($_SESSION["u_privilege"] !="1")) {
    header("Location:index.html");
    exit();
}

require_once "dbtools.inc.php";

//設定此php網頁的文件類型為 html 文字網頁，字元集編碼為 utf-8
header("Content-type: text/html; charset=utf-8");

$link=create_connection();
$no = $_POST["no"];
$subject= mysqli_real_escape_string($link,$_REQUEST['subject']);
$content = mysqli_real_escape_string($link,$_REQUEST['content']);

$sql="UPDATE `message` SET `subject`='{$subject}',`content`='{$content}' WHERE`no`='{$no}'";
$result= execute_sql($link, "guestbook", $sql);

if($result){
    mysqli_close($link);
    echo "<script>alert('更新成功{$no}');location.href='manage_post.php';</script>"; 
}
else{
    mysqli_close($link);
    echo "<script>alert('更新失敗');location.href='manage_post.php';</script>"; 
}
