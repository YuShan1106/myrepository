<?php
session_start(); //啟用 session 功能


if (!isset($_SESSION["u_id"]) || empty($_SESSION["u_id"]) == true) {
    echo "<script>alert('尚未登入');location.href='index.html'</script>";

}

require_once "dbtools.inc.php";
$link=create_connection();
$u_id = $_SESSION['u_id'];
$sql="SELECT * FROM `member` WHERE `u_id`='{$u_id}' ";
$result=execute_sql($link,"guestbook",$sql);
$user=mysqli_fetch_array($result);

mysqli_free_result($result);
mysqli_close($link);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>佈告欄</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
    .list{
        width:800px; 
        text-align: left; 
        margin-left: auto; 
        margin-right: auto; 
        padding:1% 0 2% 0;
    }
    .list td{
        padding:10px;
    }
    </style>
    <script>
    $(function() {
        $("#myForm").submit(function() { //定義當 id="myForm" 的表單送出時的處理函式
            if ($("#subject").val().length == 0) {
                alert('主題欄位不可以空白哦！');
                $("#subject").focus();
                return false; //取消送出
            }
            if ($("#content").val().length == 0) {
                alert('內容欄位不可以空白哦！');
                $("#content").focus();
                return false; //取消送出
            }
        });
    });
    $(function() {
        $("#mysearch").submit(function() {
            if ($("#searchtext").val().length == 0) {
                $("#searchtext").focus();
                return false; //取消送出
            }
            
        });
    });
    
    </script>

</head>

<body>
    <p style="text-align: center">
        <h1 style="text-align:center">公佈欄</h1>
    </p>
    
    <p style=" text-align: right; padding:0 30% 0 0">
        <span >哈囉！<span style='color:blue;font-weight:bold'><?php echo $u_id;?></span></span><br>
        <a href="logout.php" >登出</a>
        <?php if($user['u_privilege']==1) {echo " / <a href='manage_post.php' >管理界面</a>";} ?>  
    </p>
    <?php
    

require_once "dbtools.inc.php"; //引用 dbtools.inc.php
//搜尋列
?>
<form id="mysearch" name="mysearch" method="post" action="search.php">
    <table style='width:800px; text-align: left; margin-left: auto; margin-right: auto;  '>
        <tr>
            <td colspan="2">
                <input type="text" id="searchtext" name="searchtext" placeholder="Search.." style="width:60%; padding:11px; border: 1px solid #ddd; margin:2% 1% 2% 16%"></input>
                
                <input type="submit" id="submit" style="padding:5px;margin:auto 10% auto auto" value="搜尋">
                
            </td>
        </tr>
    </table>
</form>
<?php

//指定每頁顯示幾筆記錄
$records_per_page=5;
if( isset($_GET["page"]) && is_numeric($_GET["page"])){
    $page=$_GET["page"];
}
else{
    $page=1;
}

//取得要顯示第幾頁的記錄

//建立資料連接
$link=create_connection();

//執行 SQL 命令
$sql = "SELECT * FROM message ORDER BY date DESC";
$result=execute_sql($link,"guestbook",$sql);

//取得記錄數
$total_records=mysqli_num_rows($result);

//計算總頁數
$total_pages=ceil($total_records/$records_per_page);

if ($page>$total_pages){
    $page=$total_pages;
}
if ($page<=0){
    $page=1;
}

//計算本頁第一筆記錄的序號
$started_record=$records_per_page * ($page-1);

//將記錄指標移至本頁第一筆記錄的序號
mysqli_data_seek($result,$started_record);


echo "<table class='list'>";



//顯示記錄
$j=1;
while ($row =mysqli_fetch_assoc($result) and $j <=$records_per_page){
    echo "<tr style='background-color:#D9D9D9'>";
    echo "<td>";
    echo "作者:" . $row["u_id"] . "<br/>";
    echo "主旨:" . $row["subject"] . "<br/>";
    echo "時間:" . $row["date"] ;
    if ($_SESSION['u_id']==$row["u_id"]) {
        echo "<a href='user_modify_message.php?no={$row['no']}'>編輯佈告</a> / ";
        echo "<a href='delete.php?no={$row['no']}' onclick='javascript:return del();'>刪除佈告</a>";
    }
    echo "<hr/>";
    echo str_replace("\n","<br/>",$row["content"]);
    echo "</td>";
    echo "</tr>";
    $j++;
}
echo "</table>";

//產生頁數
echo "<p style='text-align: center'>";
if ($page>1){
    echo "<a href='message.php?page=" . ($page - 1) . "'>上一頁</a>";
}
echo "[";
for ($i = 1 ;$i <=$total_pages ; $i++){
    if($i==$page){
        echo "$i";
    }
    else {
        echo "<a href='message.php?page=$i'> $i </a>";
    }
}
echo "]";
if($page<$total_pages){
    echo "<a href='message.php?page=" . ($page + 1) . "'>下一頁</a>";
}

echo "</p>";

//釋放記憶體空間
mysqli_free_result($result);
mysqli_close($link);

?>
    <form id="myForm" name="myForm" method="post" action="post.php">
        <table style="border-width:0px; width: 800px; margin-left: auto; margin-right: auto; border-spacing:0px">
            <tr style="background-color: #0084CA; text-align: center">
                <td colspan="2">
                    <span style="color: #FFFFFF">請在此輸入新的佈告</span>
                </td>
            </tr>
            <tr style="background-color: #84D7FF">
                <td style="width: 15%">主旨</td>
                <td style="width: 85%"><input id="subject" name="subject" id="subject" type="text" size="50"></td>
            </tr>
            <tr style="background-color: #D9F2FF">
                <td style="width: 15%">內容</td>
                <td style="width: 85%"><textarea id="content" name="content" id="content" cols="50" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    <input type="submit" value="新增佈告">
                    <input type="reset" value="重新輸入">
                </td>
            </tr>
        </table>
    </form>
</body>

</html>
