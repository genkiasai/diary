<?php
session_start();
require("../dbconnect.php");

if (isset($_SESSION["user"])) {
    if (!empty($_GET["id"])) {
        // 投稿のゴミ箱アイコンが押されたときの処理
        $messages = $db->prepare("SELECT user_id FROM diary_data WHERE id=?");
        $messages->execute(array($_GET["id"]));
        $message = $messages->fetch();

        // このページにたどり着いた人と消そうとしている投稿者が一致している場合
        if ($message["user_id"] === $_SESSION["user"]["id"]) {
            $delete = $db->prepare("DELETE FROM diary_data WHERE id=?");
            $delete->execute(array($_GET["id"]));
        }

        // 削除に成功したらホームへ戻す
        header("Location: ./");
        exit();
    } elseif (!empty($_GET["rep_id"])) {
        // リプライのゴミ箱アイコンが押されたときの処理
        $messages = $db->prepare("SELECT user_id FROM reply WHERE id=?");
        $messages->execute(array($_GET["rep_id"]));
        $message = $messages->fetch();

        // このページにたどり着いた人と消そうとしている投稿者が一致している場合
        if ($message["user_id"] === $_SESSION["user"]["id"]) {
            $delete = $db->prepare("DELETE FROM reply WHERE id=?");
            $delete->execute(array($_GET["rep_id"]));
        }

        // 削除に成功したらホームへ戻す
        header("Location: ./");
        exit();
    }
} else {

    // セッション情報がなかったら（ログインせずにurlで直接来ようとしたら）ログイン画面に飛ばす
    header("Location: ../");
    exit;
}




?>