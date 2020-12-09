<?php
    session_start();
    require("../dbconnect.php");
    require("../common.php");
    // ini_set("display_errors", 1);

    // 初めてページを開いた場合の各種初期値
    if (!isset($_POST["tab"])) {
        $date = date("Y-m-d");
        $yyyy = substr($date, 0, 4);
        $MM = substr($date, 5, 2);
        $dd = substr($date, 8, 2);
        $_POST["year"] = $yyyy;
        $_POST["month"] = $MM;
        $_POST["day"] = $dd;
        // 詳細情報初期値
        $temp = 999;
        $_POST["diary_data"]["temp"] = $temp;
        $get_up_sense = 1;
        $_POST["diary_data"]["get_up_sense"] = $get_up_sense;
        $going_to_bed_sense = 2;
        $_POST["diary_data"]["going_to_bed_sense"] = $going_to_bed_sense;
        $happiness_sense = 3;
        $_POST["diary_data"]["happiness_sense"] = $happiness_sense;
    }

    // 送信ボタンが押された時にタブの情報が消えないようにするための処理
    if (!isset($_POST["send"])) {
        $_POST["diary_data"]["tab"] = $_POST["tab"];
    }

    // タブを切り替えても値を持ち続ける処理
    // 日記タブに居続ける場合は変数$diary_textにtextareaの値を入れ続ける。textareaの値には変数$diary_textの値を入れ続ける
    // $_POST["diary_data"]を用意して各種情報を入れる
    // $_POST["diary_data"]はhiddenで持ち続ける
    // 詳細情報タブから日記タブに遷移してきた場合、$_POST["diary_text"]に$_POST["diary_data"]["diary_text"]の値を代入する
    // $_POST["diary_text"]の値を変数$diary_textに代入してtextareaに表示する
        // 日記タブにいる場合
        if ($_POST["diary_data"]["tab"] === "1") {
            // 詳細情報タブから遷移してきた場合
            if ($_POST["jump"] === "1") {
                // 日記タブの情報
                $_POST["diary_text"] = $_POST["diary_data"]["diary_text"];
                $_POST["diary_title"] = $_POST["diary_data"]["diary_title"];
                // 詳細タブの情報
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
            // 共通情報
            $year = $_POST["year"];
            $month = $_POST["month"];
            $day = $_POST["day"];
            // 日記タブの情報
            $diary_text = $_POST["diary_text"];
            $diary_title = $_POST["diary_title"];
            // 詳細タブの情報
            // 記述なし
    
        // 詳細情報タブにいる場合
        } elseif ($_POST["diary_data"]["tab"] === "2") {
            // 日記タブから遷移してきた場合
            if ($_POST["jump"] === "0") {
                // 日記タブの情報
                $_POST["diary_data"]["diary_text"] = $_POST["diary_text"];
                $_POST["diary_data"]["diary_title"] = $_POST["diary_title"];
                // 詳細タブの情報
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
            // 共通の情報
            $year = $_POST["year"];
            $month = $_POST["month"];
            $day = $_POST["day"];
            // 詳細タブの情報
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
        }

        // 送信ボタンが押されたらデータベースに情報を渡す
        if (isset($_POST["send"])) {
        //     if (empty($_POST["diary_data"]["diary_title"])) {
        //         $error["diary_title"] = "on";
        //     }
        //     if (empty($_POST["diary_data"]["diary_text"])) {
        //         $error["diary_text"] = "on";
        //     }

        //     if (empty($error)) {
        //         // データベースに値を送信
        //         $aaa = 1;
        //     }
            $_POST["diary_text"]["tab"];
        }


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title></title>
    <link rel="stylesheet" href="style.css?v=1">

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
                                                <option value="" <?php if ($_POST["year"] === "") {echo "selected";} ?>>-</option>
                                                <option value="2000" <?php if ($_POST["year"] === "2000") {echo "selected";} ?>>2000</option>
                                                <option value="2001" <?php if ($_POST["year"] === "2001") {echo "selected";} ?>>2001</option>
                                                <option value="2002" <?php if ($_POST["year"] === "2002") {echo "selected";} ?>>2002</option>
                                                <option value="2003" <?php if ($_POST["year"] === "2003") {echo "selected";} ?>>2003</option>
                                                <option value="2004" <?php if ($_POST["year"] === "2004") {echo "selected";} ?>>2004</option>
                                                <option value="2005" <?php if ($_POST["year"] === "2005") {echo "selected";} ?>>2005</option>
                                                <option value="2006" <?php if ($_POST["year"] === "2006") {echo "selected";} ?>>2006</option>
                                                <option value="2007" <?php if ($_POST["year"] === "2007") {echo "selected";} ?>>2007</option>
                                                <option value="2008" <?php if ($_POST["year"] === "2008") {echo "selected";} ?>>2008</option>
                                                <option value="2009" <?php if ($_POST["year"] === "2009") {echo "selected";} ?>>2009</option>
                                                <option value="2010" <?php if ($_POST["year"] === "2010") {echo "selected";} ?>>2010</option>
                                                <option value="2011" <?php if ($_POST["year"] === "2011") {echo "selected";} ?>>2011</option>
                                                <option value="2012" <?php if ($_POST["year"] === "2012") {echo "selected";} ?>>2012</option>
                                                <option value="2013" <?php if ($_POST["year"] === "2013") {echo "selected";} ?>>2013</option>
                                                <option value="2014" <?php if ($_POST["year"] === "2014") {echo "selected";} ?>>2014</option>
                                                <option value="2015" <?php if ($_POST["year"] === "2015") {echo "selected";} ?>>2015</option>
                                                <option value="2016" <?php if ($_POST["year"] === "2016") {echo "selected";} ?>>2016</option>
                                                <option value="2017" <?php if ($_POST["year"] === "2017") {echo "selected";} ?>>2017</option>
                                                <option value="2018" <?php if ($_POST["year"] === "2018") {echo "selected";} ?>>2018</option>
                                                <option value="2019" <?php if ($_POST["year"] === "2019") {echo "selected";} ?>>2019</option>
                                                <option value="2020" <?php if ($_POST["year"] === "2020") {echo "selected";} ?>>2020</option>
                                            </select>　年
                                        </div>

                                        <div class="col-4 my-3 px-0">
                                            <select class="select_width" name="month">
                                                <option value="" <?php if ($_POST["month"] === "") {echo "selected";} ?>>-</option>
                                                <option value="1" <?php if ($_POST["month"] === "1") {echo "selected";} ?>>1</option>
                                                <option value="2" <?php if ($_POST["month"] === "2") {echo "selected";} ?>>2</option>
                                                <option value="3" <?php if ($_POST["month"] === "3") {echo "selected";} ?>>3</option>
                                                <option value="4" <?php if ($_POST["month"] === "4") {echo "selected";} ?>>4</option>
                                                <option value="5" <?php if ($_POST["month"] === "5") {echo "selected";} ?>>5</option>
                                                <option value="6" <?php if ($_POST["month"] === "6") {echo "selected";} ?>>6</option>
                                                <option value="7" <?php if ($_POST["month"] === "7") {echo "selected";} ?>>7</option>
                                                <option value="8" <?php if ($_POST["month"] === "8") {echo "selected";} ?>>8</option>
                                                <option value="9" <?php if ($_POST["month"] === "9") {echo "selected";} ?>>9</option>
                                                <option value="10" <?php if ($_POST["month"] === "10") {echo "selected";} ?>>10</option>
                                                <option value="11" <?php if ($_POST["month"] === "11") {echo "selected";} ?>>11</option>
                                                <option value="12" <?php if ($_POST["month"] === "12") {echo "selected";} ?>>12</option>
                                            </select>　月
                                        </div>

                                        <div class="col-4 my-3 px-0">
                                            <select class="select_width" name="day">
                                                <option value="" <?php if ($_POST["day"] === "") {echo "selected";} ?>>-</option>
                                                <option value="1" <?php if ($_POST["day"] === "1") {echo "selected";} ?>>1</option>
                                                <option value="2" <?php if ($_POST["day"] === "2") {echo "selected";} ?>>2</option>
                                                <option value="3" <?php if ($_POST["day"] === "3") {echo "selected";} ?>>3</option>
                                                <option value="4" <?php if ($_POST["day"] === "4") {echo "selected";} ?>>4</option>
                                                <option value="5" <?php if ($_POST["day"] === "5") {echo "selected";} ?>>5</option>
                                                <option value="6" <?php if ($_POST["day"] === "6") {echo "selected";} ?>>6</option>
                                                <option value="7" <?php if ($_POST["day"] === "7") {echo "selected";} ?>>7</option>
                                                <option value="8" <?php if ($_POST["day"] === "8") {echo "selected";} ?>>8</option>
                                                <option value="9" <?php if ($_POST["day"] === "9") {echo "selected";} ?>>9</option>
                                                <option value="10" <?php if ($_POST["day"] === "10") {echo "selected";} ?>>10</option>
                                                <option value="11" <?php if ($_POST["day"] === "11") {echo "selected";} ?>>11</option>
                                                <option value="12" <?php if ($_POST["day"] === "12") {echo "selected";} ?>>12</option>
                                                <option value="13" <?php if ($_POST["day"] === "13") {echo "selected";} ?>>13</option>
                                                <option value="14" <?php if ($_POST["day"] === "14") {echo "selected";} ?>>14</option>
                                                <option value="15" <?php if ($_POST["day"] === "15") {echo "selected";} ?>>15</option>
                                                <option value="16" <?php if ($_POST["day"] === "16") {echo "selected";} ?>>16</option>
                                                <option value="17" <?php if ($_POST["day"] === "17") {echo "selected";} ?>>17</option>
                                                <option value="18" <?php if ($_POST["day"] === "18") {echo "selected";} ?>>18</option>
                                                <option value="19" <?php if ($_POST["day"] === "19") {echo "selected";} ?>>19</option>
                                                <option value="20" <?php if ($_POST["day"] === "20") {echo "selected";} ?>>20</option>
                                                <option value="21" <?php if ($_POST["day"] === "21") {echo "selected";} ?>>21</option>
                                                <option value="22" <?php if ($_POST["day"] === "22") {echo "selected";} ?>>22</option>
                                                <option value="23" <?php if ($_POST["day"] === "23") {echo "selected";} ?>>23</option>
                                                <option value="24" <?php if ($_POST["day"] === "24") {echo "selected";} ?>>24</option>
                                                <option value="25" <?php if ($_POST["day"] === "25") {echo "selected";} ?>>25</option>
                                                <option value="26" <?php if ($_POST["day"] === "26") {echo "selected";} ?>>26</option>
                                                <option value="27" <?php if ($_POST["day"] === "27") {echo "selected";} ?>>27</option>
                                                <option value="28" <?php if ($_POST["day"] === "28") {echo "selected";} ?>>28</option>
                                                <option value="29" <?php if ($_POST["day"] === "29") {echo "selected";} ?>>29</option>
                                                <option value="30" <?php if ($_POST["day"] === "30") {echo "selected";} ?>>30</option>
                                                <option value="31" <?php if ($_POST["day"] === "31") {echo "selected";} ?>>31</option>
                                            </select>　日
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
                                        <!-- 日記タブの本文 -->
                                        <input type="hidden" name="diary_data[diary_text]" value=<?php echo $_POST["diary_data"]["diary_text"]; ?>>
                                        <input type="hidden" name="diary_data[diary_title]" value=<?php echo $_POST["diary_data"]["diary_title"]; ?>>
                                        <!-- 日付 -->
                                        <input type="hidden" name="diary_data[year]" value=<?php echo $_POST["diary_data"]["year"]; ?>>
                                        <input type="hidden" name="diary_data[month]" value=<?php echo $_POST["diary_data"]["month"]; ?>>
                                        <input type="hidden" name="diary_data[day]" value=<?php echo $_POST["diary_data"]["day"]; ?>>
                                        <!-- 詳細情報 -->
                                        <input type="hidden" name="diary_data[weather]" value=<?php echo $_POST["diary_data"]["weather"]; ?>>
                                        <input type="hidden" name="diary_data[temp]" value=<?php echo $_POST["diary_data"]["temp"]; ?>>
                                        <input type="hidden" name="diary_data[sleep_space]" value=<?php echo $_POST["diary_data"]["sleep_space"]; ?>>
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
                                        <input type="hidden" name="diary_data[mental]" value=<?php echo $_POST["diary_data"]["mental"]; ?>>
                                        <input type="hidden" name="diary_data[sleepiness]" value=<?php echo $_POST["diary_data"]["sleepiness"]; ?>>
                                        <input type="hidden" name="diary_data[stack]" value=<?php echo $_POST["diary_data"]["stack"]; ?>>
                                        <input type="hidden" name="diary_data[tab]" value=<?php echo $_POST["tab"]; ?>>
                                        <?php if (isset($_POST["send"])) {echo "<input type='hidden' name='diary_data[tab]' value=" . $_POST["diary_data"]["tab"] . ">";} ?>
                                    <!--------------------------- /hidden属性 -------------------------->

                                    <!-- 入力エリア -->
                                    <div class="diary_area">
                                        <input type="hidden" name="jump" value="0">
                                        <!-- 日記タブ選択時 -->
                                            <?php if ($_POST["diary_data"]["tab"] === "1" || !isset($_POST["diary_data"]["tab"])): ?>
                                                <!-- タイトル -->
                                                <div class="error">*タイトルは入力必須です</div>
                                                <span class="">タイトル：</span>
                                                <input class="diary_title" id="diary_title" type="text" name="diary_title" value="<?php echo $diary_title ?>"><br>
                                                <!-- /タイトル -->
                                                <div class="error">*本文は入力必須です</div>
                                                本文<br>
                                                <textarea id="diary_text" name="diary_text" cols="50" rows="10"><?php echo $diary_text; ?></textarea>
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
                                                                                天候：<br>
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
                                                                            <div class="col-sm-4 col-4">
                                                                                気温：<br>
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
                                                                                                        echo "<option value=" . $i . " selected>" . $i . "℃</option>";
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
                                                                            <div class="col-sm-5 col-5">
                                                                                寝る場所：<br>
                                                                                <input class="sleep_space" id="sleep_space" type="text" name="sleep_space" value="<?php echo $sleep_space ?>">
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
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<24; $i++) {
                                                                                    if ($i == $get_up_time_h) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select class="get_up_time_m" name="get_up_time_m" id="get_up_time_m">
                                                                            <?php
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<60; $i++) {
                                                                                    if ($i == $get_up_time_m) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
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
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<24; $i++) {
                                                                                    if ($i == $dinner_time_h) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select name="dinner_time_m" id="dinner_time_m">
                                                                            <?php
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<60; $i++) {
                                                                                    if ($i == $dinner_time_m) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
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
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<24; $i++) {
                                                                                    if ($i == $bath_time_h) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select class="bath_time" name="bath_time_m" id="bath_time_m">
                                                                            <?php
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<60; $i++) {
                                                                                    if ($i == $bath_time_m) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
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
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<24; $i++) {
                                                                                    if ($i == $going_to_bed_time_h) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select class="going_to_bed_time" name="going_to_bed_time_m" id="going_to_bed_time_m">
                                                                            <?php
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<60; $i++) {
                                                                                    if ($i == $going_to_bed_time_m) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
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
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<24; $i++) {
                                                                                    if ($i == $nap_time_h) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時間
                                                                        <select class="nap_time" name="nap_time_m" id="nap_time_m">
                                                                            <?php
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<60; $i++) {
                                                                                    if ($i == $nap_time_m) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
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
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<24; $i++) {
                                                                                    if ($i == $last_screen_time_h) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        時
                                                                        <select class="last_screen_time" name="last_screen_time_m" id="last_screen_time_m">
                                                                            <?php
                                                                                echo "<option value=''>-</option>";
                                                                                for ($i=1; $i<60; $i++) {
                                                                                    if ($i == $last_screen_time_m) {
                                                                                        echo "<option value=" . $i . " selected>" . $i . "</option>";
                                                                                    } else {
                                                                                        echo "<option value=" . $i . ">" . $i . "</option>";
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
                                                                    <div class="evaluation_text">悪い　　←　　普通　　→　　良い</div>
                                                                    <div class="row">
                                                                        <div class="col-4 col-sm-4 px-2">起床時の感覚:</div>
                                                                        <?php
                                                                            for ($i=0; $i<=5; $i++) {
                                                                                if ($i == $get_up_sense) {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="get_up_sense_0" type="radio" name="get_up_sense" value="0" checked><label for="get_up_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="get_up_sense_' . $i . '" type="radio" name="get_up_sense" value=' . $i . ' checked><label for="get_up_sense_' . $i . '">' . $i .'</label></div>';
                                                                                    }
                                                                                } else {
                                                                                    if ($i == 0) {
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="get_up_sense_0" type="radio" name="get_up_sense" value="0"><label for="get_up_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="get_up_sense_' . $i . '" type="radio" name="get_up_sense" value=' . $i . '><label for="get_up_sense_' . $i . '">' . $i .'</label></div>';
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
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="going_to_bed_sense_0" type="radio" name="going_to_bed_sense" value="0"><label for="going_to_bed_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="going_to_bed_sense_' . $i . '" type="radio" name="going_to_bed_sense" value=' . $i . '><label for="going_to_bed_sense_' . $i . '">' . $i .'</label></div>';
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
                                                                                        echo '<div class="col-3 col-sm-3 p-0"><input class="" id="happiness_sense_0" type="radio" name="happiness_sense" value="0"><label for="happiness_sense_0">指定しない</label></div>';
                                                                                    } else {
                                                                                        echo '<div class="col-1 col-sm-1 p-0"><input class="" id="happiness_sense_' . $i . '" type="radio" name="happiness_sense" value=' . $i . '><label for="happiness_sense_' . $i . '">' . $i .'</label></div>';
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
                                                                    <textarea class="mental" name="mental" id="" cols="30" rows="5"><?php echo $mental ?></textarea>
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
                                                                    <textarea class="sleepiness hull_width" id="sleepiness" name="sleepiness" cols="30" rows="5"><?php echo $sleepiness ?></textarea>
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

                                                                <textarea class="stack hull_width" id="stack" name="stack" cols="30" rows="5"><?php echo $stack ?></textarea>
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
                                            echo "temp" . "<br>";
                                            var_dump($temp);
                                            echo "<br>" . "<br>";
                                            echo "＄_POST[temp]" . "<br>";
                                            var_dump($_POST["temp"]);
                                            echo "<br>" . "<br>";
                                            echo "＄_POST[diary_data][temp]" . "<br>";
                                            var_dump($_POST["diary_data"]["temp"]);
                                            echo "<br>" . "<br>";
                                            echo "＄_POST[diary_data][year]" . "<br>";
                                            var_dump($_POST["diary_data"]["year"]);
                                            echo "<br>" . "<br>";
                                            echo "＄year" . "<br>";
                                            var_dump($year);
                                            echo "<br>" . "<br>";
                                            echo "＄_POST[year]" . "<br>";
                                            var_dump($_POST["year"]);
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
                                    <input id="draft" type="submit" name="draft" value="下書き">
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


<!-- メモ
タイトルの挙動は後回し
やりたいのは
・タイトルが選択した日付と連動すること
・ユーザーが書き換えたらユーザーが書き換えたタイトルをずっと表示
・ユーザーが書き換えたけど、日付の部分がいじられなかった（2020/10/25の私の日記とかの）場合は日付を連動させる

-->