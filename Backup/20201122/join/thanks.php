<?php
    session_start();
    require('../dbconnect.php');
    require("../common.php");
    // ini_set('display_errors',1);

    if (!empty($_POST["login"])) {
        header("Location: ../login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="style.css?v=8">
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width, initial-scale=1”>
    <style>
        .contents {height: <?php echo 450 ?>px;}
        .input_area {height: <?php echo 350 ?>px;}
    </style>
</head>
<body>
    <div class="contents">
        <div class="header_title">
            <h1 class="title">ユーザー登録</h1>
        </div>
        <!-- 白背景の入力エリア -->
        <p class="center">ユーザー登録が完了しました</p>
        <form action="" method="post" class="center">
            <input id="login_submit" class="red_submit center" type="submit" name="login" value="ログイン">
        </form>
        </div>
    </div>
</body>
</html>