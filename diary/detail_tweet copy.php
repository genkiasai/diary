<?php
session_start();
require("../dbconnect.php");
require("../common.php");

// クエリストリングから投稿情報を引っ張る
if (!empty($_GET["id"])) {
    $details = $db->prepare("SELECT * FROM diary_data WHERE id=?");
    $details->execute(array($_GET["id"]));
    $detail = $details->fetch();

    $year = substr($detail["date"], 0, 4);
    $month = substr($detail["date"], 4, 2);
    $day = substr($detail["date"], 6, 2);


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
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title></title>
    <link rel="stylesheet" href="style.css?v=3">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .detail_text {
            border: 1px solid #000;
            height: 300px; /* @TODO暫定の高さ */
        }

        .output_textarea {
            border: 1px solid #000;
            height: 100px; /* @TODO暫定の高さ */
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
                    <!-- form -->
                        <form name="a_form" action="./detail_tweet.php?id=<?php echo $_GET["id"]; ?>" method="post">
                            <!-- 日付選択エリア -->
                                <div class="date mb-3">
                                    <div class="row">
                                        <div class="col-4 my-3 px-0">
                                            <?php echo $year; ?>年
                                        </div>

                                        <div class="col-4 my-3 px-0">
                                        <?php echo $month; ?>月
                                        </div>

                                        <div class="col-4 my-3 px-0">
                                        <?php echo $day; ?>日
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            <!-- /.date(日付選択エリア) -->

                            <!-- タブ -->
                                <div class="tab_bar">
                                    <div class="row">
                                        <label class="tab col-sm-6 col-6 px-0 py-2 mb-0 <?php if (!isset($_POST["diary_data"]["tab"]) || $_POST["diary_data"]["tab"] === "1") { echo "active"; }?>" for="diary_tab">日記タブ</label>                        
                                        <label class="tab col-sm-6 col-6 px-0 py-2 mb-0 <?php if ($_POST["diary_data"]["tab"] === "2") { echo "active"; } ?>" for="detail_tab">詳細タブ</label>
                                    </div>
                                </div>
                            <!-- /タブ -->

                            <!-- contents -->
                                <div class="contents">
                                    <!--------------------------- hidden属性 --------------------------->
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
                                                <div class="">タイトル：<?php echo $detail["title"]; ?></div>
                                                <!-- /タイトル -->
                                                本文<br>
                                                <div class="detail_text"><?php echo $detail["text"]; ?></div>
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
                                                                    <div class="row">
                                                                        <!-- 天候 -->
                                                                            <div class="col-sm-3 col-3">
                                                                                天候：<?php if (empty($detail["weathre"])) {echo "-";} else {echo $detail["weather"];} ?><br>
                                                                            </div>
                                                                        <!-- /天候 -->
                                                                        <!-- 気温 -->
                                                                            <div class="col-sm-4 col-4">
                                                                                気温：<?php if ($detail["temp"] == 999) {echo "-";} else {echo $detail["temp"];} ?><br>
                                                                            </div>
                                                                        <!-- 気温 -->
                                                                        <!-- /寝る場所 -->
                                                                            <div class="col-sm-5 col-5">
                                                                                寝る場所：<?php if (empty($detail["sleep_space"])) {echo "-";} else {echo $detail["sleep_space"];} ?><br>
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
                                                                        起床時間：<?php if ($detail["get_up_time_h"] == 999) {echo "-";} else {echo $detail["get_up_time_h"] . "時" . $detail["get_up_time_m"] . "分";}?>
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        夜ご飯：<?php if ($detail["dinner_time_h"] == 999) {echo "-";} else {echo $detail["dinner_time_h"] . "時" . $detail["dinner_time_m"] . "分";}?>
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        お風呂：<?php if ($detail["bath_time_h"] == 999) {echo "-";} else {echo $detail["bath_time_h"] . "時" . $detail["bath_time_m"] . "分";}?>
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        就床時間：<?php if ($detail["going_to_bed_time_h"] == 999) {echo "-";} else {echo $detail["going_to_bed_time_h"] . "時" . $detail["going_to_bed_time_m"] . "分";}?>
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        合計仮眠時間：<?php if ($detail["nap_time_h"] == 999) {echo "-";} else {echo $detail["nap_time_h"] . "時" . $detail["nap_time_m"] . "分";}?>
                                                                    </div>
                                                                    <div class="various_times mb-2">
                                                                        画面を最後に見た時間：<?php if ($detail["last_screen_time_h"] == 999) {echo "-";} else {echo $detail["last_screen_time_h"] . "時" . $detail["last_screen_time_m"] . "分";}?>
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
                                                                    <div class="evaluation_text">悪い　　←　　普通　　→　　良い</div>
                                                                    <div class="row">
                                                                        <div class="col-4 col-sm-4 px-2">起床時の感覚:</div>
                                                                        <?php
                                                                            for ($i=0; $i<=5; $i++) {
                                                                                if ($i == $detail["get_up_sence"]) {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="get_up_sense_0" type="radio" name="get_up_sense" value="0" checked><label for="get_up_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="get_up_sense_' . $i . '" type="radio" name="get_up_sense" value=' . $i . ' checked><label for="get_up_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                } else {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="get_up_sense_0" type="radio" name="get_up_sense" value="0" disabled><label for="get_up_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="get_up_sense_' . $i . '" type="radio" name="get_up_sense" value=' . $i . ' disabled><label for="get_up_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 col-sm-4 px-2">就寝時の感覚:</div>
                                                                        <?php
                                                                            for ($i=0; $i<=5; $i++) {
                                                                                if ($i == $going_to_bed_sense) {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="going_to_bed_sense_0" type="radio" name="going_to_bed_sense" value="0" checked><label for="going_to_bed_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="going_to_bed_sense_' . $i . '" type="radio" name="going_to_bed_sense" value=' . $i . ' checked><label for="going_to_bed_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                } else {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="going_to_bed_sense_0" type="radio" name="going_to_bed_sense" value="0" disabled><label for="going_to_bed_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="going_to_bed_sense_' . $i . '" type="radio" name="going_to_bed_sense" value=' . $i . ' disabled><label for="going_to_bed_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 col-sm-4 px-2">1日の幸せ度:</div>
                                                                        <?php
                                                                            for ($i=0; $i<=5; $i++) {
                                                                                if ($i == $happiness_sense) {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="happiness_sense_0" type="radio" name="happiness_sense" value="0" checked><label for="happiness_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="happiness_sense_' . $i . '" type="radio" name="happiness_sense" value=' . $i . ' checked><label for="happiness_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                } else {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="happiness_sense_0" type="radio" name="happiness_sense" value="0" disabled><label for="happiness_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="happiness_sense_' . $i . '" type="radio" name="happiness_sense" value=' . $i . ' disabled><label for="happiness_sense_' . $i . '">' . $i .'</label></div>';
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
                                                                    <div class="output_textarea">
                                                                        <?php echo $detail["mental"]; ?>
                                                                    </div>
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
                                                                    <div class="output_textarea">
                                                                        <?php echo $detail["sleepiness"]; ?>
                                                                    </div>
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
                                                                    <div class="output_textarea">
                                                                        <?php echo $detail["stack"]; ?>
                                                                    </div>
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
                                            echo "＄_POST[diary_data][tab]" . "<br>";
                                            var_dump($_POST["diary_data"]["tab"]);
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

                            <!-- タブボタン -->
                                <div class="submit my-3">
                                    <input id="diary_tab" class="delite" type="submit" name="tab" value="1">
                                    <input id="detail_tab" class="delite" type="submit" name="tab" value="2">
                                </div>
                            <!-- /タブボタン -->
                        </form>
                    <!-- /form -->
                </div>
            <!-- /container-fluid -->
        スマホ用画面<br>
        現在：800px指定





    </div>
    <!-- /スマホ用 -->






    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>