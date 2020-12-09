<?php
    session_start();
    require('../dbconnect.php');
    require("../common.php");
    //ini_set('display_errors',1);

    // ユーザー名が入力されているかチェック
    if ($_POST['name'] === '') {
        $error['name'] = 'empty';
    }
    // メールアドレスが入力されているか、アカウントが重複しているかチェック
    $statement = $db->prepare("SELECT COUNT(*) AS cnt FROM users WHERE email=?");
    $statement->execute(array($_POST["email"]));
    $record = $statement->fetch();
    if ($_POST['email'] === '') {
        $error['email'] = 'empty';
    }
    if ($record["cnt"] !== "0") {
        $error["email"] = "error";
    }
    // パスワードが入力されているか、されている場合6文字以上かチェック
    if ($_POST['password'] === '') {
        $error['password'] = 'empty';
    }
    if (!empty($_POST['password'])) {
        if (strlen($_POST['password']) < 6) {
            $error['password'] = 'short';
        }
    }
    // ファイルの拡張子チェック
    if (!empty($_FILES)) {
        $substr = substr($_FILES['image']['name'], -4);
        if ($substr !== '.png' && $substr !== '.jpg' && $substr !== '.bmp' && $substr !== 'jpeg') {
            $error['files'] = 'error';
        }
    } else {
        $_FILES['image']['name'] = 'default.png';
    }

    // リライトする場合
    if ($_SESSION['rewrite'] === 'on') {
        $_SESSION['rewrite'] = 'off';
        $_POST['name'] = h($_SESSION['user']['name']);
        $_POST['email'] = h($_SESSION['user']['email']);
    }
    
    // 入力内容に問題がなければ画像を指定のフォルダに移動させてcheck.phpに進む
     if (empty($error) && $_POST['input'] === 'on') {
        $file_name = date("YmdHis") . h($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "../usersPicture/" . $file_name);
        $_POST['input'] = 'off';
        $_SESSION['user'] = $_POST;
        $_SESSION['user']['image'] = $file_name;
        $_SESSION['user']['image_tmp'] = $_FILES['image']['tmp_name'];
        $_SESSION['user']['image_error'] = $_FILES['image']['error'];
        header('Location: ./check.php');
        exit();
     }


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="style.css?v=5">
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
        <div class="input_area">
            <form action="" method="post" enctype="multipart/form-data">
                <input type='hidden' name='input' value='on'>
                <p>*ユーザー名</p>
                <?php if ($error['name'] === 'empty'): ?>
                    <p class='error'>ユーザー名を入力してください</p>
                <?php endif; ?>
                <input type="text" name="name" value="<?php echo h($_POST["name"]) ?>">
                <p>*メールアドレス</p>
                <?php if ($error['email'] === 'empty'): ?>
                    <p class='error'>メールアドレスを入力してください</p>
                <?php elseif ($error["email"] === "error"): ?>
                    <p class="error">そのメールアドレスはすでに登録されています</p>
                <?php endif; ?>
                <input type="email" name="email" value="<?php echo h($_POST["email"]) ?>">
                <p>*パスワード</p>
                <?php if ($error['password'] === 'empty'): ?>
                    <p class='error'>パスワードを入力してください</p>
                <?php elseif ($error['password'] === 'short'): ?>
                    <p class='error'>パスワードは6文字以上で入力してください</p>
                <?php endif; ?>
                <input type="password" name="password" value="<?php echo h($_POST["password"]) ?>">
                <p>アイコン</p>
                <?php if ($error["files"] === "error"): ?>
                    <p class="error">*拡張子は「png」「jpg」「bmp」を選択してください</p>
                <?php endif; ?>
                <input id="input_file" type="file" name="image">
                <label class="label_file" for="input_file">ファイルを選択</label><br>
                <?php if (!empty(h($_FILES["name"]))):?>
                    <?php echo h($_FILES["name"]); ?>
                <?php else: ?>
                    <p>JavaScriptで画像が選択されるとここに画像が表示されるようにする</p>
                <?php endif; ?>
                <br>
                <input id="input_submit" class="red_submit" type="submit" name="check" value="登録内容を確認">
            </form>
        </div>
    </div>
</body>
</html>