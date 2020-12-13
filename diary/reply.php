<?php
session_start();
require("../dbconnect.php");
require("../common.php");

// 返信先の投稿の情報を取得（セッション情報がなかったらトップページに飛ばす）
if (isset($_SESSION["user"])) {
    $replys = $db->prepare("SELECT * FROM diary_data WHERE id=?");
    $replys->execute(array($_GET["id"]));
    $reply = $replys->fetch();

    $usersId = $reply["user_id"];

    // 返信先のアイコンを取得
    $usersPicture = $db->prepare("SELECT picture FROM users WHERE id=?");
    $usersPicture->execute(array($usersId));
    $userPicture = $usersPicture->fetch();

    // 返信元の情報を取得
    $replyUser = $db->prepare("SELECT * FROM users WHERE id=?");
    $replyUser->execute(array($_SESSION["user"]["id"]));
    $repUser = $replyUser->fetch();

} else {
    header("Location: ../");
    exit();
}

// 送信ボタンが押されたとき
if (($_POST["reply_submit"] === "返信")) {
    if (!empty($_POST["reply"])) {
        $sends = $db->prepare("INSERT INTO reply SET user_id=?, origin_tweet_id=?, name=?, picture=?, text=?");
        $sends->execute(array(
            $_SESSION["user"]["id"],
            $reply["id"],
            $repUser["name"],
            $repUser["picture"],
            $_POST["reply"]
        ));

        // 送信完了画面へリダイレクト
        header("Location: ./success.php");
        exit();
    } else {
        $error["reply"] = "empty";
    }
}
// メモ
// 送信ボタンが押されたとき、何も入力されていなかったらエラーを表示
// 送信ボタンが押されたら「送信されました」の画面に遷移





?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title></title>
    <link rel="stylesheet" href="style.css?v=13">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <!-- スマホ用 -->
    <div class="width480">
            <!-- ナビバー -->
                <div class="pos-f-t">
                    <div class="collapse" id="navbarToggleExternalContent">
                        <div class="bg-dark p-4">
                            <h5 class="text-white h4"><?php echo $title; ?></h5>
                            <div class="gloval_menu">
                                <a href="./">ホーム</a>
                                <a href="./profile.php">プロフィール</a>
                                <a href="./write.php">記録する</a>
                                <a href="./logout.php">ログアウト</a>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-dark bg-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                    </nav>
                </div>
            <!-- /ナビバー -->

            <!-- container-fluid -->
            <div class="container-fluid">
                <!-- タイトル -->
                    <div class="row mx-0">
                        <div class="write_header col-12 col-sm-12 py-1"><h1 class="">リプライ</h1></div>
                    </div>
                <!-- /タイトル -->
            </div>
        <!-- <h1>リプライ</h1> -->
        <div class="reply_tweet_area mx-3">
            <div class="tweet">
                <div class="row">
                    <div class="col-3 col-sm-3 px-1"><img src="../usersPicture/<?php echo $userPicture["picture"]; ?>" alt="アイコン" width=60 height=60></div>
                    <div class="col-9 col-sm-9 px-1">
                        <div class="row px-0">
                            <div class="user_name_area col-8 col-sm-7"><?php echo h($reply["name"]); ?></div>
                            <div class="tweet_time_area col-4 col-sm-5"><?php echo elapsedTime($reply["created"]); ?></div>
                            <div class="tweet_title_area col-12 col-sm-12"><?php echo "タイトル：" . h($reply["title"]); ?></div>
                            <div class="tweet_date_area col-12 col-sm-12"><?php echo substr($reply["date"], 0, 4) . "年" . substr($reply["date"], 4, 2) . "月" . substr($reply["date"], 6, 2) . "日の日記"; ?></div>
                            <div class="tweet_text_area col-12 col-sm-12"><?php echo mb_strimwidth( strip_tags( h($reply["text"]) ), 0, 200, '…', 'UTF-8' ); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- リプライ -->
        <div class="reply_area mx-3">
            <div class="row">
                <div class="col-3 col-sm-3 px-1"><img src="../usersPicture/<?php echo h($repUser["picture"]); ?>" alt="アイコン" width=60 height=60></div>
                <div class="col-9 col-sm-9 px-1">
                    <div class="row px-0">
                        <div class="user_name_area col-8 col-sm-7"><?php echo h($repUser["name"]); ?></div>
                    </div>
                        <?php if ($error["reply"] === "empty"): ?>
                            <div class="reply_error">未入力です</div>
                        <?php endif; ?>
                    <div class="row px-0">
                        <form class="reply_form" action="" method="post">
                            <textarea name="reply" id="reply_text_area" cols="30" rows="10"></textarea><br>
                            <div class="reply_submit">
                                <input id="reply_submit" type="submit" name="reply_submit" value="返信">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





    </div>
    <!-- /スマホ用 -->






    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>