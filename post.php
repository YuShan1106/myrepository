<?php
session_start();
require_once "dbtools.inc.php";

date_default_timezone_set("Asia/Taipei");

//建立資料連接
$link = create_connection();

//取得表單傳來的資料
$u_id = $_SESSION['u_id'];
$subject= mysqli_real_escape_string($link,trim($_POST["subject"]));
$content= mysqli_real_escape_string($link,trim($_POST["content"]));
$current_time= date("Y-m-d H:i:s");

//執行 insert SQL 指令
$sql= "INSERT INTO message (u_id,subject,content,date) VALUES('$u_id','$subject','$content','$current_time')";
$result= execute_sql($link,"guestbook",$sql);

//關閉資料連接
mysqli_close($link);

//將網頁重新導向到index.php
if($result){
    echo "<script> alert('新增留言成功');location.href='message.php';</script>";
}
else{
    echo "<script> alert('新增留言失敗');location.href='message.php';</script>";
}
