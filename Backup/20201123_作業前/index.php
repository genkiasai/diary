<?php
ini_set('display_errors',1);
session_start();
require('./dbconnect.php');

if (!empty($_POST['createSubmit'])) {
    header('Location: ./join');
}
if (!empty($_POST["loginSubmit"])) {
    header('Location: ./login.php');
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=1">
    <title>積み上げDiary</title>
</head>
<body>
    <header>
        <h1 class="title top-center-item">積み上げDiary</h1>
        <p class="title top-center-item">〜積み上げ時間をCreate〜</p>
    </header>
    <br>
    <ul class="top-center-item">
        <li>毎日何に時間を使っているのか可視化したい</li>
        <li>毎日の積み上げを記録したい</li>
        <li>睡眠時間の効率化を図って積み上げに使う時間を今以上に確保したい</li>
        <li>日中の活動が睡眠にどう影響しているのか分析したい</li>
        <li>仲間と生活習慣を共有したい</li>
    </ul>
    <p class="stringLetter top-center-item">そんな意識高い系のあなた</p>
    <p class="stringLetter top-center-item">積み上げ効率を最大化してみませんか？</p>
    <form class="top-center-item" method="post" action="">
        <input id="create-button" type="submit" name="createSubmit" value="アカウント登録">
        <input id="login-button" type="submit" name="loginSubmit" value="ログイン">
    </form>
</body>

</html>