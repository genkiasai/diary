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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=4">
    <title>積み上げDiary</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <header>
                    <h1 class="title top-center-item">Share Diary</h1>
                    <p class="title top-center-item">〜日常共有プラットフォーム〜</p>
                </header>
                <br>
                <ul class="top-center-item">
                    <li>みんなと生活習慣を共有したい</li>
                    <li>ブログよりも手軽に日常を投稿したい</li>
                    <li>データで日記をつけたい</li>
                    <li>憧れの人の日常をのぞきたい</li>
                </ul>
                <p class="stringLetter top-center-item">そんな繋がり意識の高いあなた</p>
                <p class="stringLetter top-center-item">日常を記録してみませんか？</p>
                <form class="top-center-item" method="post" action="">
                    <input id="create-button" type="submit" name="createSubmit" value="アカウント登録">
                    <input id="login-button" type="submit" name="loginSubmit" value="ログイン">
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap4 -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>