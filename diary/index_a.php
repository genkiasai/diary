<?php
    session_start();
    require("../common.php");
    require("../dbconnect.php");

    // セッションとデータベースの登録情報から変数に情報を渡してセッションを放棄する。セッション情報が無ければログインページに飛ばす。

        $users = $db->prepare("SELECT * FROM users WHERE id=?");
        $users->execute(array($_SESSION["user"]["id"]));
        $user = $users->fetch();
        if (empty($user)) {
            header("Location: ../login.php");
        }

        $diaries = $db->prepare("SELECT u.name, u.picture, d.* FROM diary_data d, users u WHERE d.user_id=u.id ORDER BY d.created DESC");
        $diaries->execute();
        
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="style.css?v=35">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>ホーム｜<?php echo $title; ?></title>

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
                            <h5 class="text-white h4">積み上げDiary</h5>
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
                        <div class="row">
                            <div class="write_header col-12 col-sm-12 py-1"><h1 class="">タイムライン</h1></div>
                        </div>
                    <!-- /タイトル -->
                    <!-- 投稿 -->
                    <?php foreach ($diaries as $diary): ?>
                        <div class="tweet_area py-2">
                            <div class="tweet">
                                <div class="row">
                                    <div class="col-3 col-sm-3 px-1"><img src="../usersPicture/<?php echo $diary["picture"]; ?>" alt="アイコン" width=60 height=60></div>
                                    <div class="col-9 col-sm-9 px-1">
                                        <div class="row px-0">
                                            <div class="user_name_area col-8 col-sm-7"><?php echo h($diary["name"]); ?></div>
                                            <div class="tweet_time_area col-4 col-sm-5"><?php echo elapsedTime($diary["created"]); ?></div>
                                            <div class="tweet_title_area col-12 col-sm-12"><a href="./detail_tweet.php?id=<?php echo $diary["id"]; ?>"><?php echo "タイトル：" . h($diary["title"]); ?></a></div>
                                            <div class="tweet_date_area col-12 col-sm-12"><?php echo substr($diary["date"], 0, 4) . "年" . substr($diary["date"], 4, 2) . "月" . substr($diary["date"], 6, 2) . "日の日記"; ?></div>
                                            <div class="tweet_text_area col-12 col-sm-12"><?php echo mb_strimwidth( strip_tags(h($diary["text"])), 0, 200, '…', 'UTF-8' ); ?></div>
                                            <div class="icon_area col-12 col-sm-12">
                                                <a href=""><img class="icon" id="like_icon" src="../icon/like.png" alt="いいね" width=15 height=15></a>
                                                <a href="./reply.php?id=<?php echo $diary["id"]; ?>"><img class="icon" id="res_icon" src="../icon/response.png" alt="返信" width=15 height=15></a>
                                                <?php if ($_SESSION["user"]["id"] === h($diary["user_id"])): ?>
                                                <a href="./delete.php?id=<?php echo $diary["id"]; ?>"><img class="icon" id="delete_icon" src="../icon/garbage.png" alt="削除" width=15 height=15></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- リプライ -->
                            <?php
                                // PDOインスタンスを作る関数
                                $reply = reply ($diary["id"]);
                                foreach ($reply as $rep) : ?>
                                 <div class="row pl-5 pt-2">
                                    <div class="col-3 col-sm-3 px-1"><img src="../usersPicture/<?php echo h($rep["picture"]); ?>" alt="アイコン" width=60 height=60></div>
                                    <div class="col-9 col-sm-9 px-1">
                                        <div class="row px-0">
                                            <div class="user_name_area col-8 col-sm-7"><?php echo h($rep["name"]); ?></div>
                                            <div class="tweet_time_area col-4 col-sm-5"><?php echo elapsedTime($rep["created"]); ?></div>
                                            <div class="tweet_date_area col-12 col-sm-12">返信</div>
                                            <div class="tweet_text_area col-12 col-sm-12"><?php echo mb_strimwidth(strip_tags(h($rep["text"])), 0, 180, '…', 'UTF-8' ); ?></div>
                                            <div class="icon_area col-12 col-sm-12">
                                                <a href=""><img class="icon" id="like_icon" src="../icon/like.png" alt="いいね" width=15 height=15></a>
                                                <a href="./reply.php?id=<?php echo $diary["id"]; ?>"><img class="icon" id="res_icon" src="../icon/response.png" alt="返信" width=15 height=15></a>
                                                <?php if ($_SESSION["user"]["id"] === $rep["user_id"]): ?>
                                                <a href="./delete.php?rep_id=<?php echo $rep["id"]; ?>"><img class="icon" id="delete_icon" src="../icon/garbage.png" alt="削除" width=15 height=15></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                    <!-- /投稿 -->
                </div>
            <!-- /container-fluid -->
        </div>
    <!-- /スマホ用 -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>