<?php
    session_start();
    require('./dbconnect.php');
    require("./common.php");
    // ini_set('display_errors',1);

    $users = $db->prepare("SELECT *, COUNT(*) FROM users WHERE email=?");
    $users->execute(array(h($_POST["email"])));
    $user = $users->fetch();

    // メールアドレスチェック
    if ($user["COUNT(*)"] === "0" && $_POST["button"] === "on") {
        $error["email"] = "diff";
    } else {
        $error["email"] = "";
    }

    // パスワードチェック
    if (($user["password"] !== sha1(h($_POST["password"])) && $_POST["button"] === "on")) {
        $error["password"] = 'diff';
    } else {
        $error["password"] = "";
    }

    // メールアドレスをクッキーに登録するかチェック
    if ($_POST["auto_login"] === "on") {
       setcookie("email", $_POST["email"], time() + 10);
    } else {
        setcookie("email", "", time() - 1);
    }

    // ページを読み込んだときのメールアドレスのtextの挙動
    // メールアドレスが合っててパスワードが違ったら入力されたメールアドレスは残す
    // 入力されたメールアドレスが間違っていたら消す
    // メールアドレス自動入力が設定されていたら自動的に入力する
    if (!empty($_COOKIE["email"])) {
        if ($error["email"] === "") {
            $text_email = $_COOKIE["email"];
        } elseif ($error["email"] === "diff") {
            $text_email = "";
        }
    } else {
        if ($error["email"] === "") {
            if ($error["password"] === "diff") {
                $text_email = h($_POST["email"]);
            }
        } elseif ($error["email"] === "diff") {
            $text_email = "";
        }
    }
    
    // チェックボックスの初期値設定
    if ($_POST["button"] === "on") {
        if ($_POST["auto_login"] === "on") {
            setcookie("auto_login", "on", time() + 20);
        } else {
            setcookie("auto_login", "on", time() - 1);
        }
    } else {
        if ($_COOKIE["auto_login"] === "on") {
            setcookie("auto_login", "on", time() + 20);
        } else {
            setcookie("auto_login", "on", time() + 20);
        }
    }

    // リダイレクト
    if ($error["email"] === "" && $error["password"] === "" && $_POST["button"] === "on") {
        $_SESSION["user"]["id"] = h($user["id"]);
        header("Location: ./diary");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./join/style.css?v=3">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .contents {height: <?php echo 450 ?>px;}
        .input_area {height: <?php echo 350 ?>px;}
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <div class="contents">
                    <div class="header_title">
                        <h1 class="title">ログイン</h1>
                    </div>
                    <!-- 白背景の入力エリア -->
                    <div class="col-10 offset-1 col-sm-8 offset-sm-2">
                        <div class="input_area">
                            <form action="" method="post" class="center">
                                <!-- ボタンが押されたかチェック -->
                                <input type="hidden" name="button" value="on">
                                <p class="center">メールアドレス</p>
                                <?php if ($error["email"] === "diff"): ?>
                                    <p class="error">そのメールアドレスは登録されていません</p>
                                <?php endif; ?>
                                <input type="email" name="email" value="<?php echo h($text_email); ?>">
                                <p class="center">パスワード</p>
                                <?php if ($error["password"] === "diff" && empty($error["email"])): ?>
                                    <p class="error">パスワードを正しく入力してください</p>
                                <?php endif; ?>
                                <input type="password" name="password">
                                <br>
                                <br>
                                <input id="login_submit" class="red_submit" type="submit" name="login_submit" value="ログイン">
                                <br>
                                <input id="login_checkbox" type="checkbox" name="auto_login" value="on" <?php if ($_COOKIE["auto_login"] === "on"){ echo "checked='checked'"; } ?>>
                                <label for="login_checkbox">次回から自動的にログイン</label>
                                <br>
                                <br>
                                <a href="#">パスワードを忘れましたか？</a>
                                <br>
                                <br>
                                <a href="./join/index.php">アカウントを作成</a>
                            </form>
                        </dev>
                        <pre>
                            <?php
                                //  echo "_POST[auto_login]";
                                //  echo "<br>";
                                //  echo "<br>";
                                //  var_dump($_POST["auto_login"]);
                                //  echo "<br>";
                                //  echo "<br>";
                                //  echo "_COOKIE[auto_login]";
                                //  echo "<br>";
                                //  echo "<br>";
                                //  var_dump($_COOKIE["auto_login"]);
                                //  echo "<br>";
                                //  echo "<br>";
                                //  echo "_COOKIE[email]";
                                //  echo "<br>";
                                //  echo "<br>";
                                //  var_dump($_COOKIE["email"]);
                            ?>
                        </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap4 -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>