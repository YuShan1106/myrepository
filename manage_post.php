<?php
session_start(); //啟用 session 功能

if (isset($_SESSION["u_privilege"])==false or ($_SESSION["u_privilege"] !="1")) {
    header("Location:index.html");
    exit();
}


?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>佈告欄管理系統</title>
    <style>
    .list {
        /* 套用至 table tag */
        width: 80%;
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
    .list td{
        padding: 10px;
        border: 1px solid #ddd ;
    }
    .dark_row {
        /* 套用至有 class="dark_row" 的 tag */
        background-color: #cccccc;
        /* 背景色 */
        text-align: center;
        /* 內容置中*/
    }
    .title_row {
        /* 套用至有 class="title_row" 的 tag */
        background-color: #5B5B5B;
        /* 背景色 */
        text-align: center;
        /* 內容置中*/
    }
    </style>
<script>
    function del(){
        if (confirm('確定要刪除?')){
            return true;
        }else{
            return false;
        }
    }
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
    <h1 style="text-align: center;padding:10px">佈告欄管理</h1>
    <form id="mysearch" name="mysearch" method="post" action="admin_search.php">
        <table style='width:800px; text-align: left; margin-left: auto; margin-right: auto;  '>
            <tr>
                <td colspan="2">
                    <input type="text" id="searchtext" name="searchtext" placeholder="Search.." style="width:60%; padding:11px; border: 1px solid #ddd; margin:2% 1% 2% 16%"></input>
                    
                    <input type="submit" id="submit" style="padding:5px;margin:auto 10% auto auto" value="搜尋">
                    
                </td>
            </tr>
        </table>
    </form>
    <table class="list">
        <tr class="title_row" style="color:#FFFFFF">
            <td>功能</td><td>作者</td><td>主旨</td><td>內容</td>
        </tr>
        <?php 
        require_once "dbtools.inc.php";
        $link=create_connection();
        $sql="SELECT * FROM `message` ORDER BY `no`";
        $result= execute_sql($link, "guestbook", $sql);

        if (mysqli_num_rows($result)>0) {
            while ($row=mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td><a href='admin_modify_message.php?no={$row['no']}'>編輯</a> / ";
                echo "<a href='admin_delete_user.php?u_id={$row['no']}' onclick='javascript:return del();'>刪除</a></td>\n";
                echo "<td>{$row['u_id']}</td>\n";
                echo "<td>{$row['subject']}</td>\n";
                echo "<td >{$row['content']}</td>";
                echo "</tr>\n";
            }
        }

        mysqli_free_result($result);
        mysqli_close($link);
        ?>
        
        <tr>
            <td colspan="7" class="dark_row" ><a href="message.php">回個人頁面</a> </td>
        </tr>
    </table>

</body>

</html>