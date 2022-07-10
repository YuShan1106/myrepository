<?php
session_start(); //啟用 session 功能

session_unset(); //移除所有 session 變數

session_destroy(); //銷毀 session

header("Location: index.html"); //連到 index.html 首頁
?>