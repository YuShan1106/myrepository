<?php
session_start(); //啟用 session 功能
require_once "dbtools.inc.php"; //引用 dbtools.inc.php，其內含 create_connection() 與 execute_sql() 函式

header("Content-type: text/html; charset=utf-8");

require_once "dbtools.inc.php";
$link=create_connection();
$u_id = mysqli_real_escape_string($link,$_REQUEST['user_id']);
$u_password= mysqli_real_escape_string($link,$_REQUEST['user_password']);
$sql="SELECT * FROM `member` WHERE `u_id`='{$u_id}' AND `u_password`='{$u_password}'";
$result= execute_sql($link, "guestbook", $sql);
if (mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
    $_SESSION['u_id']=$row['u_id'];
    $_SESSION['u_privilege']=$row['u_privilege'];
    header("Location: message.php");
}
else{
    mysqli_free_result($result);
    mysqli_close($link);
    echo "<script>alert('**帳號/密碼錯誤!**');window.history.back();</script>"; 
    die(); 
}
mysqli_free_result($result);
mysqli_close($link);
