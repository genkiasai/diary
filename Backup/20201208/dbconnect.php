<?php
// $mysql = "mysql:dbname=muscle_diary;host=mysql2010.db.sakura.ne.jp;charset=utf8";
// $id = "muscle";
// $password = "1025asai";
// $db = new PDO("mysql:dbname=practice;host=localhost:8889;charset=utf8", "root", "root");
$mysql = "mysql:dbname=diary;host=localhost:8889;charset=utf8";
$id = "root";
$password = "root";

try {
    $db = new PDO ($mysql, $id, $password);
} catch (PDOException $e) {
    print($e->getMessage);
}
?>


<!-- 会員ID：fja21386
パスワード：1224asai
サーバーコントロールパネル
ドメイン名：muscle.sakura.ne.jp
パスワード：GpmQThySh3+8
データベース
データベース名：muscle_study
パスワード：1025asai
テーブルの接頭語：muscle-study_wp_ -->