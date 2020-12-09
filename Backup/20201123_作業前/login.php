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
                $text_email = $_POST["email"];
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
    <link rel="stylesheet" href="./join/style.css?v=8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width", initial-scale="1">
    <style>
        .contents {height: <?php echo 450 ?>px;}
        .input_area {height: <?php echo 350 ?>px;}
    </style>
</head>
<body>
    <div class="contents">
        <div class="header_title">
            <h1 class="title">ログイン</h1>
        </div>
        <!-- 白背景の入力エリア -->
        <div class="input_area">
            <form action="" method="post" class="center">
                <!-- ボタンが押されたかチェック -->
                <input type="hidden" name="button" value="on">
                <p class="center">メールアドレス</p>
                <?php if ($error["email"] === "diff"): ?>
                    <p class="error">そのメールアドレスは登録されていません</p>
                <?php endif; ?>
                <input type="email" name="email" value="<?php echo $text_email; ?>">
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
</body>
</html>