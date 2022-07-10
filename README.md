# 佈告欄系統
###### 登入帳密(index.html)
帳號:test
密碼:123
## 檔案說明
###### 前端檔案
| 檔名 | 說明 |
|:------------:|:------------:|
|index.html|登入頁面|
|message.php|使用者介面首頁|
|search.php|使用者搜尋頁面|
|user_modify_message.php|使用者編輯頁面|
###### 後端檔案
| 檔名 | 說明 |
|:------------:|:------------:|
|manage_post.php|管理員介面首頁|
|admin_modify_message.php|管理員編輯頁面|
|admin_search.php|管理員搜尋頁面|
|user_update.php|更新使用者佈告|
|post.php|發佈公告|
|check.php|帳密確認|
|logout.php|登出|
|dbtools.inc.php|資料庫連結|
|delete.php|刪除佈告|
###### 資料庫
| 檔名 | 說明 |
|:------------:|:------------:|
|guestbook.sql|使用者、佈告資料庫|
## 資料庫說明
**member資料庫與message資料庫為關聯式資料庫**
###### 使用者資料庫:member
| # | 名稱  | 類型  |中文名稱 | 說明與範例 |
|:----------:|:---------|:----------|:---------|:----------|
|1|u_id|varchar(10)|使用者ID|主鍵，不可重複|
|2|u_password|varchar(10)|密碼|使用者密碼，例:123|
|3|u_privilege|tinyint(11)|使用者權限|0為一般使用者，1為管理員|
###### 公佈欄資料庫:message
| # | 名稱  | 類型  |中文名稱 | 說明與範例 |
|:----------:|:---------|:----------|:---------|:----------|
|1|no|int(11)|公佈編號|主鍵，不可重複|
|2|u_id|varchar(10)|使用者ID|member資料表中的使用者ID|
|3|subject|tinytext|主旨|佈告主旨|
|4|content|text|內容|佈告內容|
|5|date|datetime|發佈時間|佈告發布時間|
