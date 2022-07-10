<?php
session_start(); //啟用 session 功能

require_once "dbtools.inc.php";

//設定此php網頁的文件類型為 html 文字網頁，字元集編碼為 utf-8
header("Content-type: text/html; charset=utf-8");
$link = create_connection();
$no=$_GET['no'];

$sql = "SELECT * FROM `message` WHERE `no` = '{$no}'";
$result = execute_sql($link, "guestbook", $sql);

mysqli_free_result($result);
$sql="DELETE FROM `message` WHERE `no`='{$no}'";
$result = execute_sql($link, "guestbook", $sql);

if($result){
    mysqli_close($link);
    echo "<script>alert('{$no}--刪除成功');location.href='message.php';</script>";
}
else{
    mysqli_close($link);
    echo "<script>alert('{$no}--刪除失敗');location.href='message.php';</script>";
}