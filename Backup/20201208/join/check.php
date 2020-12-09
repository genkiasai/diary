<?php
    session_start();
    require('../dbconnect.php');
    require("../common.php");
    // ini_set('display_errors',1);

    if ($_POST['create'] === 'この内容で登録') {
        $statement = $db->prepare('INSERT INTO users SET name=?, email=?, password=?, picture=?, created=NOW()');
        $statement->execute(array(
            h($_SESSION['user']['name']),
            h($_SESSION['user']['email']),
            h(sha1($_SESSION['user']['password'])),
            h($_SESSION['user']['image'])
        ));
        // move_uploaded_file($_SESSION['user']['image_tmp'], '../usersPicture/' . $_SESSION['user']['image']);
        header('Location: ./thanks.php');
        exit();
    }

    if (h($_POST['rewrite']) === 'やり直す') {
        $_SESSION['rewrite'] = 'on';
        header('Location: ./index.php');
        exit();
    }


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=5">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .contents {
            height: auto;
            padding-bottom: 15px;
        }
        .input_area {height: <?php echo 350 ?>px;}
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <div class="contents">
                    <div class="header_title">
                        <h1 class="title">ユーザー登録</h1>
                    </div>
                    <!-- 白背景の入力エリア -->
                    <div class="check_input_area">
                        <form action="" method="post">
                            <p>*ユーザー名</p>
                            <p><?php echo h($_SESSION['user']["name"]); ?></p>
                            <p>*メールアドレス</p>
                            <p><?php echo h($_SESSION['user']["email"]); ?></p>
                            <p>*パスワード</p>
                            <p>表示されません</p>
                            <p>アイコン</p>
                            <span><img src=<?php echo '../usersPicture/' . h($_SESSION["user"]["image"]); ?> width="150" height="150" alt="アイコン" title="アイコン"></span>
                            <br>
                            <span><input id="create_submit" class="red_submit" type="submit" name="create" value="この内容で登録"></span>
                            <input id="rewrite_submit" type="submit" name="rewrite" value="やり直す">
                            <label for='rewrite_submit'><p class='rewrite'>&lt;&lt;やり直す</p></label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>