<?php
    session_start();
    require("../dbconnect.php");
    require("../common.php");
    // ini_set("display_errors", 1);

    // ログインされてなければログイン画面にリダイレクトする
    $users = $db->prepare("SELECT * FROM users WHERE id=?");
    $users->execute(array($_SESSION["user"]["id"]));
    $user = $users->fetch();
    if(!$user) {
        header("Location: ../login.php");
        exit();
    }

    // 初めてページを開いた場合の各種初期値
    // 2つ目の条件は送信ボタンを押された時に中に入らないようにするための条件
    if (!isset($_POST["tab"]) && !isset($_POST["send"])) {
        // その日の日付を取得して値を代入
        $date = date("Y-m-d");
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);
        $_POST["year"] = $year;
        $_POST["month"] = $month;
        $_POST["day"] = $day;
        $_POST["diary_data"]["year"] = $year;
        $_POST["diary_data"]["month"] = $month;
        $_POST["diary_data"]["day"] = $day;
        // 日記タブ初期値
        $_POST["diary_data"]["diary_title"] = "";
        $_POST["diary_data"]["diary_text"] = "";
        // 詳細情報初期値
        // 999は入力なしの値
        $weather = "";
        $_POST["diary_data"]["weather"] = $weather;
        $temp = "999";
        $_POST["diary_data"]["temp"] = $temp;
        $sleep_space = "";
        $_POST["diary_data"]["sleep_space"] = $sleep_space;
        $get_up_time_h = "999";
        $_POST["diary_data"]["get_up_time_h"] = $get_up_time_h;
        $get_up_time_m = "999";
        $_POST["diary_data"]["get_up_time_m"] = $get_up_time_m;
        $dinner_time_h = "999";
        $_POST["diary_data"]["dinner_time_h"] = $dinner_time_h;
        $dinner_time_m = "999";
        $_POST["diary_data"]["dinner_time_m"] = $dinner_time_m;
        $bath_time_h = "999";
        $_POST["diary_data"]["bath_time_h"] = $bath_time_h;
        $bath_time_m = "999";
        $_POST["diary_data"]["bath_time_m"] = $bath_time_m;
        $going_to_bed_time_h = "999";
        $_POST["diary_data"]["going_to_bed_time_h"] = $going_to_bed_time_h;
        $going_to_bed_time_m = "999";
        $_POST["diary_data"]["going_to_bed_time_m"] = $going_to_bed_time_m;
        $nap_time_h = "999";
        $_POST["diary_data"]["nap_time_h"] = $nap_time_h;
        $nap_time_m = "999";
        $_POST["diary_data"]["nap_time_m"] = $nap_time_m;
        $last_screen_time_h = "999";
        $_POST["diary_data"]["last_screen_time_h"] = $last_screen_time_h;
        $last_screen_time_m = "999";
        $_POST["diary_data"]["last_screen_time_m"] = $last_screen_time_m;
        // ラジオボタンの初期値「指定しない」
        $get_up_sense = "0";
        $_POST["diary_data"]["get_up_sense"] = $get_up_sense;
        $going_to_bed_sense = "0";
        $_POST["diary_data"]["going_to_bed_sense"] = $going_to_bed_sense;
        $happiness_sense = "0";
        $_POST["diary_data"]["happiness_sense"] = $happiness_sense;
        // タブは日記タブが最初に選ばれている状態にする
        $_POST["diary_data"]["tab"] = "1";
    }

    // 送信ボタンが押された時にタブの情報が消えないようにするための処理
    // 2つ目の条件は
    if (!isset($_POST["send"]) && isset($_POST["tab"])) {
        $_POST["diary_data"]["tab"] = $_POST["tab"];
    }

    // タブを切り替えても値を持ち続ける処理
    // 連想配列diary_dataは裏で値を持つ役割を持つ
    // hiddenで値を持ち続ける
        // 日記タブにいる場合
        if ($_POST["diary_data"]["tab"] === "1") {
            // 詳細情報タブから遷移してきた場合
            if ($_POST["jump"] === "1") {
                // 日記タブの情報
                // hiddenからもらった値をPOSTに代入して、表示するための変数に代入するための橋渡し
                $_POST["diary_text"] = $_POST["diary_data"]["diary_text"];
                $_POST["diary_title"] = $_POST["diary_data"]["diary_title"];
                // 詳細タブの情報
                // 詳細タブから送られてきた値を連想配列に代入→hidden属性に渡す
                $_POST["diary_data"]["weather"] = $_POST["weather"];
                $_POST["diary_data"]["temp"] = $_POST["temp"];
                $_POST["diary_data"]["sleep_space"] = $_POST["sleep_space"];
                $_POST["diary_data"]["get_up_time_h"] = $_POST["get_up_time_h"];
                $_POST["diary_data"]["get_up_time_m"] = $_POST["get_up_time_m"];
                $_POST["diary_data"]["dinner_time_h"] = $_POST["dinner_time_h"];
                $_POST["diary_data"]["dinner_time_m"] = $_POST["dinner_time_m"];
                $_POST["diary_data"]["bath_time_h"] = $_POST["bath_time_h"];
                $_POST["diary_data"]["bath_time_m"] = $_POST["bath_time_m"];
                $_POST["diary_data"]["going_to_bed_time_h"] = $_POST["going_to_bed_time_h"];
                $_POST["diary_data"]["going_to_bed_time_m"] = $_POST["going_to_bed_time_m"];
                $_POST["diary_data"]["nap_time_h"] = $_POST["nap_time_h"];
                $_POST["diary_data"]["nap_time_m"] = $_POST["nap_time_m"];
                $_POST["diary_data"]["last_screen_time_h"] = $_POST["last_screen_time_h"];
                $_POST["diary_data"]["last_screen_time_m"] = $_POST["last_screen_time_m"];
                $_POST["diary_data"]["get_up_sense"] = $_POST["get_up_sense"];
                $_POST["diary_data"]["going_to_bed_sense"] = $_POST["going_to_bed_sense"];
                $_POST["diary_data"]["happiness_sense"] = $_POST["happiness_sense"];
                $_POST["diary_data"]["mental"] = $_POST["mental"];
                $_POST["diary_data"]["sleepiness"] = $_POST["sleepiness"];
                $_POST["diary_data"]["stack"] = $_POST["stack"];
            }
            // 日記タブの情報
            // 表示するための変数に値を代入
            $diary_text = $_POST["diary_text"];
            $diary_title = $_POST["diary_title"];
            // 連続で日記タブが押された時に連想配列の値を失わないための処理
            $_POST["diary_data"]["diary_title"] = $_POST["diary_title"];            
            $_POST["diary_data"]["diary_text"] = $_POST["diary_text"];
            // 共通情報
            // 詳細タブで変更された可能性のある日付の値を連想配列に渡しつつ、表示するための変数に代入
            $_POST["diary_data"]["year"] = $_POST["year"];
            $_POST["diary_data"]["month"] = $_POST["month"];
            $_POST["diary_data"]["day"] = $_POST["day"];
            $year = $_POST["diary_data"]["year"];
            $month = $_POST["diary_data"]["month"];
            $day = $_POST["diary_data"]["day"];
            // 詳細タブの情報
            // 記述なし
    
        // 詳細情報タブにいる場合
        } elseif ($_POST["diary_data"]["tab"] === "2") {
            // 日記タブから遷移してきた場合
            if ($_POST["jump"] === "0") {
                // 日記タブの情報
                // 日記タブで入力した情報を連想配列に代入→hidden属性に値を渡す
                $_POST["diary_data"]["diary_text"] = $_POST["diary_text"];
                $_POST["diary_data"]["diary_title"] = $_POST["diary_title"];
                // 詳細タブの情報
                // POSTに値を渡して、表示するための変数の橋渡し
                $_POST["weather"] = $_POST["diary_data"]["weather"];
                $_POST["temp"] = $_POST["diary_data"]["temp"];
                $_POST["sleep_space"] = $_POST["diary_data"]["sleep_space"];
                $_POST["get_up_time_h"] = $_POST["diary_data"]["get_up_time_h"];
                $_POST["get_up_time_m"] = $_POST["diary_data"]["get_up_time_m"];
                $_POST["dinner_time_h"] = $_POST["diary_data"]["dinner_time_h"];
                $_POST["dinner_time_m"] = $_POST["diary_data"]["dinner_time_m"];
                $_POST["bath_time_h"] = $_POST["diary_data"]["bath_time_h"];
                $_POST["bath_time_m"] = $_POST["diary_data"]["bath_time_m"];
                $_POST["going_to_bed_time_h"] = $_POST["diary_data"]["going_to_bed_time_h"];
                $_POST["going_to_bed_time_m"] = $_POST["diary_data"]["going_to_bed_time_m"];
                $_POST["nap_time_h"] = $_POST["diary_data"]["nap_time_h"];
                $_POST["nap_time_m"] = $_POST["diary_data"]["nap_time_m"];
                $_POST["last_screen_time_h"] = $_POST["diary_data"]["last_screen_time_h"];
                $_POST["last_screen_time_m"] = $_POST["diary_data"]["last_screen_time_m"];
                $_POST["get_up_sense"] = $_POST["diary_data"]["get_up_sense"];
                $_POST["going_to_bed_sense"] = $_POST["diary_data"]["going_to_bed_sense"];
                $_POST["happiness_sense"] = $_POST["diary_data"]["happiness_sense"];
                $_POST["mental"] = $_POST["diary_data"]["mental"];
                $_POST["sleepiness"] = $_POST["diary_data"]["sleepiness"];
                $_POST["stack"] = $_POST["diary_data"]["stack"];
            }
            // 日記タブの情報
            // 詳細タブが選択された状態で送信ボタンが押された時に、エラー内容確認の場所でemptyにならないように変数に値を代入する
            $diary_title = $_POST["diary_data"]["diary_title"];
            $diary_text = $_POST["diary_data"]["diary_text"];
            // 共通の情報
            // 日付の値を連想配列に代入しつつ、表示するための変数にも値を代入する
            $_POST["diary_data"]["year"] = $_POST["year"];
            $_POST["diary_data"]["month"] = $_POST["month"];
            $_POST["diary_data"]["day"] = $_POST["day"];
            $year = $_POST["diary_data"]["year"];
            $month = $_POST["diary_data"]["month"];
            $day = $_POST["diary_data"]["day"];
            // 詳細タブの情報
            // 詳細タブが連続で押された時に、表示するための変数に値を再び代入する
            $weather = $_POST["weather"];
            $temp = $_POST["temp"];
            $sleep_space = $_POST["sleep_space"];
            $get_up_time_h = $_POST["get_up_time_h"];
            $get_up_time_m = $_POST["get_up_time_m"];
            $dinner_time_h = $_POST["dinner_time_h"];
            $dinner_time_m = $_POST["dinner_time_m"];
            $bath_time_h = $_POST["bath_time_h"];
            $bath_time_m = $_POST["bath_time_m"];
            $going_to_bed_time_h = $_POST["going_to_bed_time_h"];
            $going_to_bed_time_m = $_POST["going_to_bed_time_m"];
            $nap_time_h = $_POST["nap_time_h"];
            $nap_time_m = $_POST["nap_time_m"];
            $last_screen_time_h = $_POST["last_screen_time_h"];
            $last_screen_time_m = $_POST["last_screen_time_m"];
            $get_up_sense = $_POST["get_up_sense"];
            $going_to_bed_sense = $_POST["going_to_bed_sense"];
            $happiness_sense = $_POST["happiness_sense"];
            $mental = $_POST["mental"];
            $sleepiness = $_POST["sleepiness"];
            $stack = $_POST["stack"];
            // 詳細タブが連続で押された時に、連想配列の値を保持する→hidden属性に渡す
            $_POST["diary_data"]["weather"] = $_POST["weather"];
            $_POST["diary_data"]["temp"] = $_POST["temp"];
            $_POST["diary_data"]["sleep_space"] = $_POST["sleep_space"];
            $_POST["diary_data"]["get_up_time_h"] = $_POST["get_up_time_h"];
            $_POST["diary_data"]["get_up_time_m"] = $_POST["get_up_time_m"];
            $_POST["diary_data"]["dinner_time_h"] = $_POST["dinner_time_h"];
            $_POST["diary_data"]["dinner_time_m"] = $_POST["dinner_time_m"];
            $_POST["diary_data"]["bath_time_h"] = $_POST["bath_time_h"];
            $_POST["diary_data"]["bath_time_m"] = $_POST["bath_time_m"];
            $_POST["diary_data"]["going_to_bed_time_h"] = $_POST["going_to_bed_time_h"];
            $_POST["diary_data"]["going_to_bed_time_m"] = $_POST["going_to_bed_time_m"];
            $_POST["diary_data"]["nap_time_h"] = $_POST["nap_time_h"];
            $_POST["diary_data"]["nap_time_m"] = $_POST["nap_time_m"];
            $_POST["diary_data"]["last_screen_time_h"] = $_POST["last_screen_time_h"];
            $_POST["diary_data"]["last_screen_time_m"] = $_POST["last_screen_time_m"];
            $_POST["diary_data"]["get_up_sense"] = $_POST["get_up_sense"];
            $_POST["diary_data"]["going_to_bed_sense"] = $_POST["going_to_bed_sense"];
            $_POST["diary_data"]["happiness_sense"] = $_POST["happiness_sense"];
            $_POST["diary_data"]["mental"] = $_POST["mental"];
            $_POST["diary_data"]["sleepiness"] = $_POST["sleepiness"];
            $_POST["diary_data"]["stack"] = $_POST["stack"];
        }

        // エラー内容
        if ($_POST["send"] === "送信") {
            if (empty($diary_title)) {
                $error["diary_title"] = "empty";
            }
            if (empty($diary_text)) {
                $error["diary_text"] = "empty";
            }
        }
        if (isset($error)) {
            $_POST["diary_data"]["tab"] = "1";
        }

        // データベースの「day」の値を確定する
        $_POST["diary_data"]["date"] = $_POST["diary_data"]["year"] . $_POST["diary_data"]["month"] . $_POST["diary_data"]["day"];
        try{
            // 送信ボタンが押されたらデータベースに情報を渡す
            if (isset($_POST["send"]) && !isset($error)) {
                $diary_data = $db->prepare("INSERT INTO diary_data SET user_id=?, name=?, title=?, text=?, date=?, weather=?, temp=?, sleep_space=?, get_up_time_h=?, get_up_time_m=?, dinner_time_h=?, dinner_time_m=?, bath_time_h=?, bath_time_m=?, going_to_bed_time_h=?, going_to_bed_time_m=?, nap_time_h=?, nap_time_m=?, last_screen_time_h=?, last_screen_time_m=?, get_up_sense=?, going_to_bed_sense=?, happiness_sense=?, mental=?, sleepiness=?, stack=?, created=NOW()");
                $diary_data->execute(array(
                    (int)$user["id"],
                    $user["name"],
                    $_POST["diary_data"]["diary_title"],
                    $_POST["diary_data"]["diary_text"],
                    (int)$_POST["diary_data"]["date"],
                    $_POST["diary_data"]["weather"],
                    (int)$_POST["diary_data"]["temp"],
                    $_POST["diary_data"]["sleep_space"],
                    (int)$_POST["diary_data"]["get_up_time_h"],
                    (int)$_POST["diary_data"]["get_up_time_m"],
                    (int)$_POST["diary_data"]["dinner_time_h"],
                    (int)$_POST["diary_data"]["dinner_time_m"],
                    (int)$_POST["diary_data"]["bath_time_h"],
                    (int)$_POST["diary_data"]["bath_time_m"],
                    (int)$_POST["diary_data"]["going_to_bed_time_h"],
                    (int)$_POST["diary_data"]["going_to_bed_time_m"],
                    (int)$_POST["diary_data"]["nap_time_h"],
                    (int)$_POST["diary_data"]["nap_time_m"],
                    (int)$_POST["diary_data"]["last_screen_time_h"],
                    (int)$_POST["diary_data"]["last_screen_time_m"],
                    (int)$_POST["diary_data"]["get_up_sense"],
                    (int)$_POST["diary_data"]["going_to_bed_sense"],
                    (int)$_POST["diary_data"]["happiness_sense"],
                    $_POST["diary_data"]["mental"],
                    $_POST["diary_data"]["sleepiness"],
                    $_POST["diary_data"]["stack"],
                ));

                // 送信完了
                header("Location: ./success.php");
                exit();
            }
        }catch(PDOException $e){
            $error["dbwrite"] = "on";
        }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>記録画面｜<?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css?v=2">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style>
            body {
                font-size: .7em !important;
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
                    <!-- データベースに書き込む時にエラーが起きたときの表示 -->
                    <?php
                        if($error["dbwrite"] === "on") {
                            echo "<h3>データ送信時にエラーが起きました</h3>";
                        }
                    ?>
                    <!-- タイトル -->
                        <div class="row mx-0">
                            <div class="write_header col-12 col-sm-12 py-1"><h1 class="">日記記録画面</h1></div>
                        </div>
                    <!-- /タイトル -->
                    <!-- form -->
                        <form name="a_form" action="./write.php" method="post">
                            <!-- 日付選択エリア -->
                                <div class="date mb-3">
                                    <div class="row">
                                        <div class="col-4 my-3 px-0">
                                            <select class="select_width" name="year">
                                                <option value="" <?php if ($year === "") {echo "selected";} ?>>-</option>
                                                <option value="2000" <?php if ($year === "2000") {echo "selected";} ?>>2000</option>
                                                <option value="2001" <?php if ($year === "2001") {echo "selected";} ?>>2001</option>
                                                <option value="2002" <?php if ($year === "2002") {echo "selected";} ?>>2002</option>
                                                <option value="2003" <?php if ($year === "2003") {echo "selected";} ?>>2003</option>
                                                <option value="2004" <?php if ($year === "2004") {echo "selected";} ?>>2004</option>
                                                <option value="2005" <?php if ($year === "2005") {echo "selected";} ?>>2005</option>
                                                <option value="2006" <?php if ($year === "2006") {echo "selected";} ?>>2006</option>
                                                <option value="2007" <?php if ($year === "2007") {echo "selected";} ?>>2007</option>
                                                <option value="2008" <?php if ($year === "2008") {echo "selected";} ?>>2008</option>
                                                <option value="2009" <?php if ($year === "2009") {echo "selected";} ?>>2009</option>
                                                <option value="2010" <?php if ($year === "2010") {echo "selected";} ?>>2010</option>
                                                <option value="2011" <?php if ($year === "2011") {echo "selected";} ?>>2011</option>
                                                <option value="2012" <?php if ($year === "2012") {echo "selected";} ?>>2012</option>
                                                <option value="2013" <?php if ($year === "2013") {echo "selected";} ?>>2013</option>
                                                <option value="2014" <?php if ($year === "2014") {echo "selected";} ?>>2014</option>
                                                <option value="2015" <?php if ($year === "2015") {echo "selected";} ?>>2015</option>
                                                <option value="2016" <?php if ($year === "2016") {echo "selected";} ?>>2016</option>
                                                <option value="2017" <?php if ($year === "2017") {echo "selected";} ?>>2017</option>
                                                <option value="2018" <?php if ($year === "2018") {echo "selected";} ?>>2018</option>
                                                <option value="2019" <?php if ($year === "2019") {echo "selected";} ?>>2019</option>
                                                <option value="2020" <?php if ($year === "2020") {echo "selected";} ?>>2020</option>
                                            </select>　年
                                        </div>

                                        <div class="col-4 my-3 px-0">
                                            <select class="select_width" name="month">
                                                <option value="" <?php if ($month === "") {echo "selected";} ?>>-</option>
                                                <option value="01" <?php if ($month === "01") {echo "selected";} ?>>01</option>
                                                <option value="02" <?php if ($month === "02") {echo "selected";} ?>>02</option>
                                                <option value="03" <?php if ($month === "03") {echo "selected";} ?>>03</option>
                                                <option value="04" <?php if ($month === "04") {echo "selected";} ?>>04</option>
                                                <option value="05" <?php if ($month === "05") {echo "selected";} ?>>05</option>
                                                <option value="06" <?php if ($month === "06") {echo "selected";} ?>>06</option>
                                                <option value="07" <?php if ($month === "07") {echo "selected";} ?>>07</option>
                                                <option value="08" <?php if ($month === "08") {echo "selected";} ?>>08</option>
                                                <option value="09" <?php if ($month === "09") {echo "selected";} ?>>09</option>
                                                <option value="10" <?php if ($month === "10") {echo "selected";} ?>>10</option>
                                                <option value="11" <?php if ($month === "11") {echo "selected";} ?>>11</option>
                                                <option value="12" <?php if ($month === "12") {echo "selected";} ?>>12</option>
                                            </select>　月
                                        </div>

                                        <div class="col-4 my-3 px-0">
                                            <select class="select_width" name="day">
                                                <option value="" <?php if ($day === "") {echo "selected";} ?>>-</option>
                                                <option value="01" <?php if ($day === "01") {echo "selected";} ?>>01</option>
                                                <option value="02" <?php if ($day === "02") {echo "selected";} ?>>02</option>
                                                <option value="03" <?php if ($day === "03") {echo "selected";} ?>>03</option>
                                                <option value="04" <?php if ($day === "04") {echo "selected";} ?>>04</option>
                                                <option value="05" <?php if ($day === "05") {echo "selected";} ?>>05</option>
                                                <option value="06" <?php if ($day === "06") {echo "selected";} ?>>06</option>
                                                <option value="07" <?php if ($day === "07") {echo "selected";} ?>>07</option>
                                                <option value="08" <?php if ($day === "08") {echo "selected";} ?>>08</option>
                                                <option value="09" <?php if ($day === "09") {echo "selected";} ?>>09</option>
                                                <option value="10" <?php if ($day === "10") {echo "selected";} ?>>10</option>
                                                <option value="11" <?php if ($day === "11") {echo "selected";} ?>>11</option>
                                                <option value="12" <?php if ($day === "12") {echo "selected";} ?>>12</option>
                                                <option value="13" <?php if ($day === "13") {echo "selected";} ?>>13</option>
                                                <option value="14" <?php if ($day === "14") {echo "selected";} ?>>14</option>
                                                <option value="15" <?php if ($day === "15") {echo "selected";} ?>>15</option>
                                                <option value="16" <?php if ($day === "16") {echo "selected";} ?>>16</option>
                                                <option value="17" <?php if ($day === "17") {echo "selected";} ?>>17</option>
                                                <option value="18" <?php if ($day === "18") {echo "selected";} ?>>18</option>
                                                <option value="19" <?php if ($day === "19") {echo "selected";} ?>>19</option>
                                                <option value="20" <?php if ($day === "20") {echo "selected";} ?>>20</option>
                                                <option value="21" <?php if ($day === "21") {echo "selected";} ?>>21</option>
                                                <option value="22" <?php if ($day === "22") {echo "selected";} ?>>22</option>
                                                <option value="23" <?php if ($day === "23") {echo "selected";} ?>>23</option>
                                                <option value="24" <?php if ($day === "24") {echo "selected";} ?>>24</option>
                                                <option value="25" <?php if ($day === "25") {echo "selected";} ?>>25</option>
                                                <option value="26" <?php if ($day === "26") {echo "selected";} ?>>26</option>
                                                <option value="27" <?php if ($day === "27") {echo "selected";} ?>>27</option>
                                                <option value="28" <?php if ($day === "28") {echo "selected";} ?>>28</option>
                                                <option value="29" <?php if ($day === "29") {echo "selected";} ?>>29</option>
                                                <option value="30" <?php if ($day === "30") {echo "selected";} ?>>30</option>
                                                <option value="31" <?php if ($day === "31") {echo "selected";} ?>>31</option>
                                            </select>　日
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            <!-- /.date(日付選択エリア) -->

                            <!-- タブ -->
                                <div class="tab_bar">
                                    <div class="row mx-0">
                                        <label class="tab col-sm-6 col-6 px-0 py-2 mb-0 <?php if (!isset($_POST["diary_data"]["tab"]) || $_POST["diary_data"]["tab"] === "1") { echo "active"; }?>" for="diary_tab">日記タブ</label>                        
                                        <label class="tab col-sm-6 col-6 px-0 py-2 mb-0 <?php if ($_POST["diary_data"]["tab"] === "2") { echo "active"; } ?>" for="detail_tab">詳細タブ</label>
                                    </div>
                                </div>
                            <!-- /タブ -->

                            <!-- contents -->
                                <div class="contents">
                                    <!--------------------------- hidden属性 --------------------------->
                                        <!-- 日記タブの本文 -->
                                        <input type="hidden" name="diary_data[diary_text]" value=<?php echo h($_POST["diary_data"]["diary_text"]); ?>>
                                        <input type="hidden" name="diary_data[diary_title]" value=<?php echo h($_POST["diary_data"]["diary_title"]); ?>>
                                        <!-- 日付 -->
                                        <input type="hidden" name="diary_data[year]" value=<?php echo $_POST["diary_data"]["year"]; ?>>
                                        <input type="hidden" name="diary_data[month]" value=<?php echo $_POST["diary_data"]["month"]; ?>>
                                        <input type="hidden" name="diary_data[day]" value=<?php echo $_POST["diary_data"]["day"]; ?>>
                                        <!-- 詳細情報 -->
                                        <input type="hidden" name="diary_data[weather]" value=<?php echo $_POST["diary_data"]["weather"]; ?>>
                                        <input type="hidden" name="diary_data[temp]" value=<?php echo $_POST["diary_data"]["temp"]; ?>>
                                        <input type="hidden" name="diary_data[sleep_space]" value=<?php echo h($_POST["diary_data"]["sleep_space"]); ?>>
                                        <input type="hidden" name="diary_data[get_up_time_h]" value=<?php echo $_POST["diary_data"]["get_up_time_h"]; ?>>
                                        <input type="hidden" name="diary_data[get_up_time_m]" value=<?php echo $_POST["diary_data"]["get_up_time_m"]; ?>>
                                        <input type="hidden" name="diary_data[dinner_time_h]" value=<?php echo $_POST["diary_data"]["dinner_time_h"]; ?>>
                                        <input type="hidden" name="diary_data[dinner_time_m]" value=<?php echo $_POST["diary_data"]["dinner_time_m"]; ?>>
                                        <input type="hidden" name="diary_data[bath_time_h]" value=<?php echo $_POST["diary_data"]["bath_time_h"]; ?>>
                                        <input type="hidden" name="diary_data[bath_time_m]" value=<?php echo $_POST["diary_data"]["bath_time_m"]; ?>>
                                        <input type="hidden" name="diary_data[going_to_bed_time_h]" value=<?php echo $_POST["diary_data"]["going_to_bed_time_h"]; ?>>
                                        <input type="hidden" name="diary_data[going_to_bed_time_m]" value=<?php echo $_POST["diary_data"]["going_to_bed_time_m"]; ?>>
                                        <input type="hidden" name="diary_data[nap_time_h]" value=<?php echo $_POST["diary_data"]["nap_time_h"]; ?>>
                                        <input type="hidden" name="diary_data[nap_time_m]" value=<?php echo $_POST["diary_data"]["nap_time_m"]; ?>>
                                        <input type="hidden" name="diary_data[last_screen_time_h]" value=<?php echo $_POST["diary_data"]["last_screen_time_h"]; ?>>
                                        <input type="hidden" name="diary_data[last_screen_time_m]" value=<?php echo $_POST["diary_data"]["last_screen_time_m"]; ?>>
                                        <input type="hidden" name="diary_data[get_up_sense]" value=<?php echo $_POST["diary_data"]["get_up_sense"]; ?>>
                                        <input type="hidden" name="diary_data[going_to_bed_sense]" value=<?php echo $_POST["diary_data"]["going_to_bed_sense"]; ?>>
                                        <input type="hidden" name="diary_data[happiness_sense]" value=<?php echo $_POST["diary_data"]["happiness_sense"]; ?>>
                                        <input type="hidden" name="diary_data[mental]" value=<?php echo h($_POST["diary_data"]["mental"]); ?>>
                                        <input type="hidden" name="diary_data[sleepiness]" value=<?php echo h($_POST["diary_data"]["sleepiness"]); ?>>
                                        <input type="hidden" name="diary_data[stack]" value=<?php echo h($_POST["diary_data"]["stack"]); ?>>
                                        <!-- タブ操作されていない状態で「送信ボタン」が押された時にタブの値を1にしておく処理 -->
                                        <?php 
                                            if (!isset($_POST["tab"])) {
                                                echo '<input type="hidden" name="diary_data[tab]" value="1">';
                                            } else {
                                                echo '<input type="hidden" name="diary_data[tab]" value=' . $_POST["tab"] . '>';
                                            }
                                        ?>
                                        <!-- 「送信ボタン」が押された時に押されたタブに止まる処理？（たぶん本来はいらない） -->
                                        <?php if (isset($_POST["send"])) {echo "<input type='hidden' name='diary_data[tab]' value=" . $_POST["diary_data"]["tab"] . ">";} ?>
                                    <!--------------------------- /hidden属性 -------------------------->

                                    <!-- 入力エリア -->
                                    <div class="diary_area">
                                        <input type="hidden" name="jump" value="0">
                                        <!-- 日記タブ選択時 -->
                                            <?php if ($_POST["diary_data"]["tab"] === "1" || !isset($_POST["diary_data"]["tab"])): ?>
                                                <!-- タイトル -->
                                                <?php if ($error["diary_title"] === "empty") { echo '<div class="error">*タイトルは入力必須です</div>';} ?>
                                                <span class="">タイトル：</span>
                                                <input class="diary_title" id="diary_title" type="text" name="diary_title" value="<?php echo h($diary_title) ?>"><br>
                                                <!-- /タイトル -->
                                                <?php if ($error["diary_text"] === "empty") { echo '<div class="error">*本文は入力必須です</div>'; } ?>
                                                本文<br>
                                                <textarea id="diary_text" name="diary_text" cols="50" rows="10"><?php echo h($diary_text); ?></textarea>
                                            <?php endif; ?>
                                        <!-- /日記タブ選択時 -->

                                        <!-- 詳細情報タブ選択時 -->
                                            <?php if ($_POST["diary_data"]["tab"] === "2"): ?>
                                                <!-- 詳細情報タブから日記タブに飛んできたことを知らせる値 -->
                                                <input type="hidden" name="jump" value="1">
                                                <!-- アコーディオン -->
                                                    <div class="accordion" id="accordionExample">
                                                        <!-- 環境 -->
                                                            <div class="card">
                                                                <div class="card-header" id="headingOne">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                        環境
                                                                    </button>
                                                                </h5>
                                                                </div>

                                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                <div class="card-body">
                                                                    <div class="row environment">
                                                                        <!-- 天候 -->
                                                                            <div class="environment_parts col-sm-12 col-12">
                                                                                天候：
                                                                                <select name="weather" id="weather">
                                                                                    <option value="" <?php if ($weather === "") { echo "selected"; } ?>>-</option>
                                                                                    <option value="晴れ" <?php if ($weather === "晴れ") { echo "selected"; } ?>>晴れ</option>
                                                                                    <option value="曇り" <?php if ($weather === "曇り") { echo "selected"; } ?>>曇り</option>
                                                                                    <option value="雨" <?php if ($weather === "雨") { echo "selected"; } ?>>雨</option>
                                                                                    <option value="雪" <?php if ($weather === "雪") { echo "selected"; } ?>>雪</option>
                                                                                </select>
                                                                            </div>
                                                                        <!-- /天候 -->
                                                                        <!-- 気温 -->
                                                                            <div class="environment_parts col-sm-12 col-12">
                                                                                気温：
                                                                                <select name="temp" id="temp">
                                                                                    <?php
                                                                                        // echo "<option value=-20>℃</option>";
                                                                                        for ($i=-20; $i<=40; $i++) {
                                                                                            if ($i == $temp) {
                                                                                                if ($i <= -20) {
                                                                                                    echo "<option value=" . $i . " selected>" . $i . "℃以下</option>";
                                                                                                } elseif ($i >= 40) {
                                                                                                    echo "<option value=" . $i . " selected>" . $i . "℃以上</option>";
                                                                                                } elseif ($i == 0) {
                                                                                                    if ($temp == 999) {
                                                                                                        echo "<option value='999' selected>-</option>";
                                                                                                        echo "<option value=" . $i . ">" . $i . "℃</option>";
                                                                                                    } else {
                                                                                                        echo "<option value='999'>-</option>";
                                                                                                        echo "<option value=" . $i . " selected>" . $i . "℃</option>";
                                                                                                    }
                                                                                                } else {
                                                                                                    echo "<option value=" . $i . " selected>" . $i . "℃</option>";
                                                                                                }
                                                                                            } else {
                                                                                                if ($i <= -20) {
                                                                                                    echo "<option value=" . $i . ">" . $i . "℃以下</option>";
                                                                                                } elseif ($i >= 40) {
                                                                                                    echo "<option value=" . $i . ">" . $i . "℃以上</option>";
                                                                                                } elseif ($i == 0) {
                                                                                                    if ($temp == 999) {
                                                                                                        echo "<option value='999' selected>-</option>";
                                                                                                        echo "<option value=" . $i . ">" . $i . "℃</option>";
                                                                                                    } else {
                                                                                                        echo "<option value='999'>-</option>";
                                                                                                        echo "<option value=" . $i . ">" . $i . "℃</option>";
                                                                                                    }
                                                                                                } else {
                                                                                                    echo "<option value=" . $i . ">" . $i . "℃</option>";
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        <!-- 気温 -->
                                                                        <!-- /寝る場所 -->
                                                                            <div class="environment_parts col-sm-12 col-12">
                                                                                寝る場所：
                                                                                <input class="sleep_space" id="sleep_space" type="text" name="sleep_space" value="<?php echo h($sleep_space);?>">
                                                                            </div>
                                                                        <!-- /寝る場所 -->
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        <!-- /環境 -->
                                                        <!-- 各種時間 -->
                                                            <div class="card">
                                                                <div class="card-header" id="headingTwo">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                        各種時間
                                                                    </button>
                                                                </h5>
                                                                </div>
                                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                                <div class="card-body">
                                                                    <div class="various_times mb-2">
                                                                        起床時間：
                                                                        <select class="get_up_time_h" name="get_up_time_h" id="get_up_time_h">
                                                                            <?php
                                                                                for ($i=0; $i<24; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($get_up_time_h > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $get_up_time_h) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select class="get_up_time_m" name="get_up_time_m" id="get_up_time_m">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<60; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($get_up_time_m > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $get_up_time_m) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        分
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        夜ご飯：
                                                                        <select class="dinner_time" name="dinner_time_h" id="dinner_time_h">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<24; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($dinner_time_h > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $dinner_time_h) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select name="dinner_time_m" id="dinner_time_m">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<60; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($dinner_time_m > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $dinner_time_m) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        分
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        お風呂：
                                                                        <select class="bath_time" name="bath_time_h" id="bath_time_h">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<24; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($bath_time_h > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $bath_time_h) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select class="bath_time" name="bath_time_m" id="bath_time_m">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<60; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($bath_time_m > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $bath_time_m) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        分<br>
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        就床時間：
                                                                        <select class="going_to_bed_time" name="going_to_bed_time_h" id="going_to_bed_time_h">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<24; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($going_to_bed_time_h > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $going_to_bed_time_h) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select class="going_to_bed_time" name="going_to_bed_time_m" id="going_to_bed_time_m">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<60; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($going_to_bed_time_m > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $going_to_bed_time_m) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        分<br>
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        合計仮眠時間：
                                                                        <select class="nap_time" name="nap_time_h" id="nap_time_h">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<24; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($nap_time_h > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $nap_time_h) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時間
                                                                        <select class="nap_time" name="nap_time_m" id="nap_time_m">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<60; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($nap_time_m > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $nap_time_m) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        分<br>
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        画面を最後に見た時間：
                                                                        <select class="last_screen_time" name="last_screen_time_h" id="last_screen_time_h">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<24; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($last_screen_time_h > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $last_screen_time_h) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select class="last_screen_time" name="last_screen_time_m" id="last_screen_time_m">
                                                                            <?php
                                                                                // echo "<option value=''>-</option>";
                                                                                for ($i=0; $i<60; $i++) {
                                                                                    if ($i == 0) {
                                                                                        if ($last_screen_time_m > 24) {
                                                                                            echo "<option value='999' selected>-</option>";
                                                                                        } else {
                                                                                            echo "<option value='999'>-</option>";
                                                                                        }
                                                                                    }
                                                                                    if ($i == $last_screen_time_m) {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . " selected>" . "0" . $i . "</option>";
                                                                                        } else {
                                                                                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                        }
                                                                                    } else {
                                                                                        if ($i <= 9) {
                                                                                            echo "<option value=" . $i . ">" . "0" . $i . "</option>";   
                                                                                        } else {
                                                                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        分<br>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        <!-- /各種時間 -->
                                                        <!-- 評価 -->
                                                            <div class="card">
                                                                <div class="card-header" id="headingThree">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                        評価
                                                                    </button>
                                                                </h5>
                                                                </div>
                                                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                                <div class="card-body">
                                                                    <div class="evaluation_text row mr-5">
                                                                        <div class="col-3 col-sm-3">悪い</div>
                                                                        <div class="col-1 col-sm-1">←</div>
                                                                        <div class="col-3 col-sm-3">普通</div>
                                                                        <div class="col-1 col-sm-1">→</div>
                                                                        <div class="col-3 col-sm-3">良い</div>
                                                                    </div>
                                                                    <div class="evaluation_parts row">
                                                                        <div class="evaluation_title col-12 col-sm-12 px-2">起床時の感覚:</div>
                                                                        <?php
                                                                            for ($i=0; $i<=5; $i++) {
                                                                                if ($i == $get_up_sense) {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-4 col-sm-2 p-0"><input class="" id="get_up_sense_0" type="radio" name="get_up_sense" value="0" checked><label for="get_up_sense_0">指定しない</label></div>';
                                                                                    } elseif ($i == 5) {
                                                                                        echo '<div class="col-1 col-sm-2 p-0"><input class="" id="get_up_sense_' . $i . '" type="radio" name="get_up_sense" value=' . $i . ' checked><label for="get_up_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-2 p-0 mr-3 mr-sm-0"><input class="" id="get_up_sense_' . $i . '" type="radio" name="get_up_sense" value=' . $i . ' checked><label for="get_up_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                } else {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-4 col-sm-2 p-0"><input class="" id="get_up_sense_0" type="radio" name="get_up_sense" value="0"><label for="get_up_sense_0">指定しない</label></div>';
                                                                                    } elseif ($i == 5) {
                                                                                        echo '<div class="col-1 col-sm-2 p-0"><input class="" id="get_up_sense_' . $i . '" type="radio" name="get_up_sense" value=' . $i . '><label for="get_up_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-2 p-0 mr-3 mr-sm-0"><input class="" id="get_up_sense_' . $i . '" type="radio" name="get_up_sense" value=' . $i . '><label for="get_up_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="evaluation_parts row">
                                                                        <div class="evaluation_title col-12 col-sm-12 px-2">就寝時の感覚:</div>
                                                                        <?php
                                                                            for ($i=0; $i<=5; $i++) {
                                                                                if ($i == $going_to_bed_sense) {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-4 col-sm-2 p-0"><input class="" id="going_to_bed_sense_0" type="radio" name="going_to_bed_sense" value="0" checked><label for="going_to_bed_sense_0">指定しない</label></div>';
                                                                                    } elseif ($i == 5) {
                                                                                        echo '<div class="col-1 col-sm-2 p-0"><input class="" id="going_to_bed_sense_' . $i . '" type="radio" name="going_to_bed_sense" value=' . $i . ' checked><label for="going_to_bed_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }else {
                                                                                        echo '<div class="col-1 col-sm-2 p-0 mr-3 mr-sm-0"><input class="" id="going_to_bed_sense_' . $i . '" type="radio" name="going_to_bed_sense" value=' . $i . ' checked><label for="going_to_bed_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                } else {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-4 col-sm-2 p-0"><input class="" id="going_to_bed_sense_0" type="radio" name="going_to_bed_sense" value="0"><label for="going_to_bed_sense_0">指定しない</label></div>';
                                                                                    } elseif ($i == 5) {
                                                                                        echo '<div class="col-1 col-sm-2 p-0"><input class="" id="going_to_bed_sense_' . $i . '" type="radio" name="going_to_bed_sense" value=' . $i . '><label for="going_to_bed_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }else {
                                                                                        echo '<div class="col-1 col-sm-2 p-0 mr-3 mr-sm-0"><input class="" id="going_to_bed_sense_' . $i . '" type="radio" name="going_to_bed_sense" value=' . $i . '><label for="going_to_bed_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="evaluation_parts row">
                                                                        <div class="evaluation_title col-12 col-sm-12 px-2">1日の幸せ度:</div>
                                                                        <?php
                                                                            for ($i=0; $i<=5; $i++) {
                                                                                if ($i == $happiness_sense) {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-4 col-sm-2 p-0"><input class="" id="happiness_sense_0" type="radio" name="happiness_sense" value="0" checked><label for="happiness_sense_0">指定しない</label></div>';
                                                                                    } elseif ($i == 5) {
                                                                                        echo '<div class="col-1 col-sm-2 p-0"><input class="" id="happiness_sense_' . $i . '" type="radio" name="happiness_sense" value=' . $i . ' checked><label for="happiness_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }else {
                                                                                        echo '<div class="col-1 col-sm-2 p-0 mr-3 mr-sm-0"><input class="" id="happiness_sense_' . $i . '" type="radio" name="happiness_sense" value=' . $i . ' checked><label for="happiness_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                } else {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-4 col-sm-2 p-0"><input class="" id="happiness_sense_0" type="radio" name="happiness_sense" value="0"><label for="happiness_sense_0">指定しない</label></div>';
                                                                                    } elseif ($i == 5) {
                                                                                        echo '<div class="col-1 col-sm-2 p-0"><input class="" id="happiness_sense_' . $i . '" type="radio" name="happiness_sense" value=' . $i . '><label for="happiness_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }else {
                                                                                        echo '<div class="col-1 col-sm-2 p-0 mr-3 mr-sm-0"><input class="" id="happiness_sense_' . $i . '" type="radio" name="happiness_sense" value=' . $i . '><label for="happiness_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        <!-- 評価 -->
                                                        <!-- 精神状態 -->
                                                            <div class="card">
                                                                <div class="card-header" id="headingFour">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                                        精神状態
                                                                    </button>
                                                                </h5>
                                                                </div>
                                                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                                                <div class="card-body">
                                                                    <textarea class="mental" name="mental" id="" cols="30" rows="5"><?php echo h($mental);?></textarea>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        <!-- /精神状態 -->
                                                        <!-- 眠気の発生条件 -->
                                                            <div class="card">
                                                                <div class="card-header" id="headingFive">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                                        眠気の発生条件
                                                                    </button>
                                                                </h5>
                                                                </div>
                                                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                                                <div class="card-body">
                                                                    <textarea class="sleepiness hull_width" id="sleepiness" name="sleepiness" cols="30" rows="5"><?php echo h($sleepiness);?></textarea>
                                                                <!-- @TODO 入力欄をtext属性にして追加ボタンで枠が1つずつ増えていく仕組みが作りたいけど、入力したものをどうやって保持すればいいかよくわからない(追加ボタンが何回押されたかと入力された情報を両方保持しつつ、ページ遷移で反映させないといけない) -->
                                                                    <!-- <input class="sleepiness hull_width" id="sleepiness" type="text" name="sleepiness" value=""><br>
                                                                    <div class="text-right">
                                                                        <input class="add_button" id="add_button_sleep" type="button" value="追加">
                                                                    </div> -->
                                                                </div>
                                                                </div>
                                                            </div>
                                                        <!-- /眠気の発生条件 -->
                                                        <!-- 一日の積み上げ -->
                                                            <div class="card">
                                                                <div class="card-header" id="headingSix">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                                        一日の積み上げ
                                                                    </button>
                                                                </h5>
                                                                </div>
                                                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                                                <div class="card-body">

                                                                <textarea class="stack hull_width" id="stack" name="stack" cols="30" rows="5"><?php echo h($stack);?></textarea>
                                                                    <!-- @TODO 入力欄をtext属性にして追加ボタンで枠が1つずつ増えていく仕組みが作りたいけど、入力したものをどうやって保持すればいいかよくわからない(追加ボタンが何回押されたかと入力された情報を両方保持しつつ、ページ遷移で反映させないといけない) -->
                                                                    <!-- <input class="stack hull_width" id="stack" type="text" name="stack" value=""><br>
                                                                    <div class="text-right">
                                                                        <input class="add_button" id="add_button_stack" type="button" value="追加">
                                                                    </div> -->
                                                                </div>
                                                                </div>
                                                            </div>
                                                        <!-- /一日の積み上げ -->
                                                    </div>
                                                <!-- /アコーディオン -->
                                            <?php endif; ?>
                                        <!-- 詳細情報タブ選択時 -->
                                    </div>
                                    <!-- /入力エリア -->

                                    <!-- デバッグエリア -->
                                        <?php
                                            // echo "＄_POST[diary_data]" . "<br>";
                                            // var_dump($_POST["diary_data"]);
                                            // echo "<br>" . "<br>";
                                            // echo "＄user" . "<br>";
                                            // var_dump($user);
                                            // echo "<br>" . "<br>";
                                            // echo "＄diary_title" . "<br>";
                                            // var_dump($diary_title);
                                            // echo "＄_POST[diary_data][diary_text]" . "<br>";
                                            // var_dump($_POST["diary_data"]["diary_text"]);
                                            // echo "<br>" . "<br>";
                                            // echo "＄error[diary_text]" . "<br>";
                                            // var_dump($error["diary_text"]);
                                            // echo "<br>" . "<br>";
                                            // echo "＄error" . "<br>";
                                            // var_dump($error);
                                            // echo "<br>" . "<br>";
                                            // echo "＄_POST[year]" . "<br>";
                                            // var_dump($_POST["year"]);
                                            // echo "<br>" . "<br>";
                                            // echo "＄＄_POST[tab]" . "<br>";
                                            // var_dump($_POST["tab"]);
                                            // echo "<br>" . "<br>";
                                            // echo "＄_POST[jump]" . "<br>";
                                            // var_dump($_POST["jump"]);
                                            // echo "<br>" . "<br>";
                                            // echo "＄_POST[tab]" . "<br>";
                                            // var_dump($_POST["tab"]);
                                        ?>
                                    <!-- /デバッグエリア -->
                                </div>
                            <!-- /.contents -->

                            <!-- 送信・下書きボタン -->
                                <div class="submit my-3">
                                    <input id="diary_tab" class="delite" type="submit" name="tab" value="1">
                                    <input id="detail_tab" class="delite" type="submit" name="tab" value="2">
                                    <input id="draft" type="submit" name="draft" value="下書き" disabled>
                                    <input id="send" type="submit" name="send" value="送信">
                                </div>
                            <!-- /送信・下書きボタン -->
                        </form>
                    <!-- /form -->
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