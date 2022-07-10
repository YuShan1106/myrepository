<?php
session_start();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>佈告欄管理系統</title>
        <style>
        table {
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
        table td{
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
    </head>
    <body>
        <?php
        require_once "dbtools.inc.php";

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
        ?>
        <table>
            <tr  style="color:#FFFFFF;background-color: #5B5B5B;text-align: center;">
                <td>功能</td><td>作者</td><td>主旨</td><td>內容</td>
            </tr>
            <?php
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td><a href='admin_modify_message.php?no={$row['no']}'>編輯 / </a>";
                    echo "<a href='admin_delete_user.php?u_id={$row['no']}' onclick='javascript:return del();'>刪除</a></td>\n";
                    echo "<td>{$row['u_id']}</td>\n";
                    echo "<td>{$row['subject']}</td>\n";
                    echo "<td >{$row['content']}</td>";
                    echo "</tr>\n";
                }
                
            }
            else{
                echo "<tr>";
                echo "<td colspan='4' style='text-align: center;' >無相關搜尋結果</td>";
                echo "</tr>\n";
            }
            ?>
            <tr>
                <td class="dark_row" colspan="4">
                    <a href="manage_post.php">回佈告欄管理網頁</a> / 
                    <a href="message.php">回個人頁面</a>
                </td>
            </tr>
        </table>
    </body>
</html>



<?php
//關閉資料連接
mysqli_close($link);

