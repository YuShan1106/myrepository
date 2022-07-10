<?php
session_start();
require_once "dbtools.inc.php";
?>
<html>
    <head>
    <title>佈告欄</title>
    <style>
        table{
            width:800px; 
            text-align: left; 
            margin-left: auto; 
            margin-right: auto; 
            padding:1% 0 2% 0;
        }
        table td{
            padding:10px;
        }
    </style>
    </head>
    <body>
        <?php
        //建立資料連接
        $link = create_connection();

        //取得表單傳來的資料
        $u_id = $_SESSION['u_id'];
        $searchtext= mysqli_real_escape_string($link,trim($_POST["searchtext"]));

        //執行 insert SQL 指令
        $sql="SELECT * FROM `message` WHERE `subject` OR `content` LIKE '%".$searchtext."%'";
        $result= execute_sql($link,"guestbook",$sql);
        if(!$result){
            printf("Error: %s \n",mysqli_error($link));
            exit();
        }

        echo "<h1 style='text-align:center; padding:50px 0 0 0;'>「".$searchtext."」搜尋結果</h1>";

        echo "<table>";

        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
            echo "<tr style='background-color:#D9D9D9'>";
            echo "<td>";
            echo "作者:" . $row["u_id"] . "<br/>";
            echo "主題:" . $row["subject"] . "<br/>";
            echo "時間:" . $row["date"] ;
            if ($_SESSION['u_id']==$row["u_id"]) {
                echo "<a href='user_modify_message.php?no={$row['no']}'>編輯佈告</a> / ";
                echo "<a href='delete.php?no={$row['no']}' onclick='javascript:return del();'>刪除佈告</a>";
            }
            echo "<hr/>";
            echo str_replace("\n","<br/>",$row["content"]);
            echo "</td>";
            echo "</tr>";
            }
            
        }
        else{
            echo "<tr>";
            echo "<td colspan='4' style='text-align: center;' >無相關搜尋結果</td>";
            echo "</tr>\n";
        }
        echo "</table>";


        echo "<a href='message.php'; style='margin: 48.5%'>回首頁</a>";

    //關閉資料連接
    mysqli_close($link);?>
    </body>
    </html>
