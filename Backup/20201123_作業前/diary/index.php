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

        $content = '本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文本文';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title></title>
    <link rel="stylesheet" href="style.css?v=6">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
            /* タイムライン */
    .tweet_area {
        border-bottom: 1px solid #000;
        padding: 20px 15px
    }

    .image_area {
        height: 60px;
        /* width: 60; */
    }

    .user_name_area {
        height: 30px;
        text-align: left;
    }

    .tweet_time_area {
        font-size: .5em;
        text-align: right;
    }

    .tweet_title_area {
        text-align: left;
    }

    .tweet_diary_area {
        margin: 20px 0;
    }

    .icon {
        margin-right: 20px;
    }

    .icon:hover {
        cursor: pointer;
    }
    </style>

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
                    <?php for ($i=0; $i<3; $i++): ?>
                        <div class="tweet_area">
                            <div class="tweet">
                                <div class="row">
                                    <div class="col-3 col-sm-3"><img src="../usersPicture/null.png" alt="アイコン" width=60 height=60></div>
                                    <div class="row col-9 col-sm-9">
                                        <div class="user_name_area col-9 col-sm-7">ユーザーネーム</div>
                                        <div class="tweet_time_area col-3 col-sm-5">5分前</div>
                                        <div class="tweet_title_area col-12 col-sm-12">タイトル</div>
                                    </div>
                                </div>
                                <div class="tweet_diary_area"><?php echo mb_strimwidth( strip_tags( $content ), 0, 200, '…', 'UTF-8' ); ?></div>
                            </div>
                            <div class="icon_area">
                                <img class="icon" id="like_icon" src="../icon/like.png" alt="いいね" width=15 height=15>
                                <img class="icon" id="res_icon" src="../icon/response.png" alt="返信" width=15 height=15>
                                <img class="icon" id="delete_icon" src="../icon/garbage.png" alt="削除" width=15 height=15>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <!-- /投稿 -->
                </div>
            <!-- /container-fluid -->
        </div>
    <!-- /スマホ用 -->

    <p><?php echo $user["name"] . "さん、こんにちは"; ?></p>
    <p><?php echo "【登録情報】" . "<br>";
             echo "メールアドレス：" . $user["email"] . "<br>";
             echo "アイコン：" . "<br>";
             echo "<img src=../usersPicture/" . $user["picture"] . " " . "alt='アイコン'" . " " . "width=200 height=150>" . "<br>";
             echo $user["created"] . "から始めました"
    
    
    ?></p>
    <?php
        echo var_dump($_COOKIE["auto_login"]) . "<br>" . "<br>";
        // echo var_dump($user) . "<br>" . "<br>";
        // $str = "img src='../usersPicture/'" . $user["picture"] . " " . "alt='アイコン'" . " " . "width=200 height=150";
        // echo var_dump($str . "<br>" . "<br>");
        // echo var_dump($_SESSION["login_check"] . "<br>" . "<br>");
        // echo var_dump(empty($_SESSION["login_check"]));
        
        
        
        ?>
        <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>