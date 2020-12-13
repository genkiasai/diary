<?php

// XSS
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

// タイムゾーン
date_default_timezone_set("Asia/Tokyo");

// タイトル
$title = "Share Diary";

// 時間差を求める関数
function elapsedTime ($dateTime) {
    $now = new datetime("now");
    $tweetTime = new datetime($dateTime);

    $elapsedTime = $tweetTime->diff($now);

    if (($elapsedTime->i < 1) && ($elapsedTime->h < 1) && ($elapsedTime->d  < 1) && ($elapsedTime->m  < 1) && ($elapsedTime->y  < 1)) {
        $elapsedTimeS = $elapsedTime->s . "秒前";
    } elseif (($elapsedTime->h < 1) && ($elapsedTime->d  < 1) && ($elapsedTime->m  < 1) && ($elapsedTime->y  < 1)) {
        $elapsedTimeS = $elapsedTime->i . "分前";
        // 一日以下だったら
    } elseif (($elapsedTime->d  < 1) && ($elapsedTime->m  < 1) && ($elapsedTime->y  < 1)) {
        $elapsedTimeS = $elapsedTime->h . "時間前";
    } elseif (($elapsedTime->m  < 1) && ($elapsedTime->y  < 1)) {
        $elapsedTimeS = $elapsedTime->d . "日前";
    } elseif (($elapsedTime->y  < 1)) {
        $elapsedTimeS = $elapsedTime->m . "ヶ月前";
    } else {
        $elapsedTimeS = $elapsedTime->y . "年前";
    }


    return($elapsedTimeS);
}

// タイムラインでリプライの表示をするための補助の関数
function reply ($diary_id) {
    // $mysql = "mysql:dbname=muscle_diary;host=mysql2010.db.sakura.ne.jp;charset=utf8";
    // $id = "muscle";
    // $password = "1025asai";
    $mysql = "mysql:dbname=diary;host=localhost:8889;charset=utf8";
    $id = "root";
    $password = "root";
    
    try {
        $db = new PDO ($mysql, $id, $password);
    } catch (PDOException $e) {
        print($e->getMessage);
    }

    // require("./dbconnect.php");
    $reply = $db->prepare("SELECT * FROM reply WHERE origin_tweet_id=?");
    $reply->execute(array($diary_id));
    return $reply;
}

?>