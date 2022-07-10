<?php
session_start(); //啟用 session 功能

//檢查是否為登入狀態，若未登入或沒管理者權限則重導至 index.html 登入網頁
if (isset($_SESSION["u_privilege"])==false or ($_SESSION["u_privilege"] !="1")) {
    header("Location:index.html");
    exit();
}


require_once "dbtools.inc.php";

$link = create_connection();
//取得 no
$no=$_GET['no'];

$sql = "SELECT * FROM `message` WHERE `no` = '{$no}'";

$result = execute_sql($link, "guestbook", $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $no = $row['no'];
    $u_id = $row["u_id"];
    $subject = $row["subject"];
    $content =  $row["content"];
}
//釋放記憶體空間
mysqli_free_result($result);
mysqli_close($link);
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>佈告欄管理系統</title>
    <style>
    table {
        /* 套用至 table tag */
        width: 60%;
        /* 設定寬度*/
        text-align: left;
        /* 內容置中*/
        border: 0px;
        /* 邊框 */
        background-color: #F2F2F2;
        /* 背景色 */
        padding: 0;
        margin-left: auto;
        /* 左邊界距離 */
        margin-right: auto;
        /* 右邊界距離 */
    }
    
    table [type="text"]{
        width: 90%;
        
    }
    .dark_row {
        /* 套用至有 class="dark_row" 的 tag */
        background-color: #cccccc;
        /* 背景色 */
        text-align: center;
        /* 內容置中*/
    }
    </style>
</head>

<body>

    <table>
        <tr>
            <td class="dark_row" colspan="2">
                <h1 style="margin:10px">佈告欄管理編輯</h1>
            </td>
        </tr>
        
        <form id="form" name="form" method="POST" action="admin_update.php">
            <tr>
                <td style="width:5%">作者：
                <input type="hidden" name="no" value="<?php  echo $no;?>">
                </td>
                <td><?php echo $u_id; ?></td>
                
            </tr>
            <tr>
                <td style="width:5%">主旨：</td>
                <td><input required type="text" name="subject" value="<?php echo $subject; ?>"></td>
            </tr>
            <tr>
                <td style="width:5%">內容：</td>
                <td>
                    <textarea name="content"  style="height:100px;width: 90%; "><?php echo $content; ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="dark_row" colspan="2"><input type="submit" value="修改">
                <input type="reset" value="重置"></td>
            </tr>
            <tr>
                <td class="dark_row" colspan="2">
                    <a href="manage_post.php">回佈告欄管理網頁</a>
                    <a href="message.php">回個人頁面</a>
                </td>
            </tr>
        </form>
    </table>

</body>

</html>