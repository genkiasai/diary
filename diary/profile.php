<?php
session_start();
require("../dbconnect.php");
require("../common.php");

// ログイン者の情報を取得
if (!empty($_SESSION["user"])) {
    // ログイン者の情報を取得
    $users = $db->prepare("SELECT * FROM users WHERE id=?");
    $users->execute(array($_SESSION["user"]["id"]));
    $user = $users->fetch();

    // ログイン者の投稿履歴を取得
    $tweets = $db->prepare("SELECT * FROM diary_data WHERE user_id=? ORDER BY created DESC");
    $tweets->execute(array($_SESSION["user"]["id"]));

    // ログイン者の投稿数を取得
    $tweetNumb = $db->prepare("SELECT COUNT(*) FROM diary_data WHERE user_id=?");
    $tweetNumb->execute(array($_SESSION["user"]["id"]));
    $tweetNum = $tweetNumb->fetch();
} else {
    header("Location: ../");
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>プロフィール｜<?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css?v=4">

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
                        <div class="write_header col-12 col-sm-12 py-1"><h1 class="">プロフィール</h1></div>
                    </div>
                <!-- /タイトル -->
            </div>
            <!-- プロフィール -->
                <div class="profile mx-3 px-3">
                    <div class="info1">
                        <div class="row">
                            <div class="icon col-3 col-sm-3">
                                <img src="../usersPicture/<?php echo h($user["picture"]); ?>" alt="アイコン" width=70 height=70>
                            </div>
                            <div class="name_edit col-8 col-sm-8">
                                <div class="name col-12 col-sm-12 px-0">
                                    <?php echo h($user["name"]); ?>
                                </div>
                                <div class="edit col-12 col-sm-12 px-0">
                                    <a href="./edit_profile">プロフィールを編集</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info2">
                        <div class="row">
                            <div class="profile_statement col-12 col-sm-12">
                                <?php echo h($user["profile_statement"]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="info3 my-4">
                        <div class="row">
                            <div class="tweet_num col-4 col-sm-4">
                                投稿<br>
                                <?php echo h($tweetNum["COUNT(*)"]); ?><br>
                                件
                            </div>
                            <div class="follower_num col-4 col-sm-4">
                                フォロワー<br>
                                <?php // @TODO ?><br>
                                人
                            </div>
                            <div class="follow_num col-4 col-sm-4">
                                フォロー<br>
                                <?php // @TODO ?><br>
                                人
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /プロフィール -->

            <!-- 投稿履歴 -->
            <?php foreach ($tweets as $tweet): ?>
                <div class="tweet_area mx-3">
                <div class="tweet mx-3">
                    <div class="row">
                        <div class="col-3 col-sm-3 px-1"><img src="../usersPicture/<?php echo $user["picture"]; ?>" alt="アイコン" width=60 height=60></div>
                        <div class="tweet_info col-9 col-sm-9 px-1">
                            <div class="row">
                                <div class="user_name_area col-8 col-sm-7"><?php echo h($user["name"]); ?></div>
                                <div class="tweet_time_area col-4 col-sm-5"><?php echo elapsedTime($tweet["created"]); ?></div>
                                <a href="./detail_tweet.php?id=<?php echo $tweet["id"]; ?>"><div class="tweet_title_area col-12 col-sm-12"><?php echo "タイトル：" . h($tweet["title"]); ?></div></a>
                                <div class="tweet_date_area col-12 col-sm-12"><?php echo substr($tweet["date"], 0, 4) . "年" . substr($tweet["date"], 4, 2) . "月" . substr($tweet["date"], 6, 2) . "日の日記"; ?></div>
                                <div class="tweet_text_area col-12 col-sm-12"><?php echo mb_strimwidth( strip_tags( h($tweet["text"]) ), 0, 200, '…', 'UTF-8' ); ?></div>
                                <div class="icon_area col-12 col-sm-12">
                                    <a href=""><img class="icon" id="like_icon" src="../icon/like.png" alt="いいね" width=15 height=15></a>
                                    <a href="./reply.php?id=<?php echo $tweet["id"]; ?>"><img class="icon" id="res_icon" src="../icon/response.png" alt="返信" width=15 height=15></a>
                                    <?php if ($_SESSION["user"]["id"] === $tweet["user_id"]): ?>
                                    <a href="./delete.php?id=<?php echo $tweet["id"]; ?>"><img class="icon" id="delete_icon" src="../icon/garbage.png" alt="削除" width=15 height=15></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
            <!-- /投稿履歴 -->
    </div>
    <!-- /スマホ用 -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>