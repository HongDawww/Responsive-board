<?php

// header('Content-Type: text/html; charset=utf-8');

$db = new mysqli('localhost','root','php504','bbs'); // DB 접속

if($db->connect_error){
	die('DB연결 실패');
}

$db->set_charset('utf8mb4');



?>