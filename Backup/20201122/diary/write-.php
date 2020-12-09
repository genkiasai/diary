<?php
session_start();
require("../dbconnect.php");
require("../common.php");
ini_set("display_errors", 1);

// if ($_GET["tab_number"] = 0) {

// }
$_POST["diary"]["test"] = $_POST["test"];
$_POST["diary"]["diary_text"] = $_POST["diary_text"];
if (!isset($_POST["diary"]["diary_text"])) {
    $diary_text = $_POST["diary"]["diary_text"];
} else {
    $diary_text = "";
}

if (!isset($_GET["tab"])) {
    $_POST["diary"]["diary_text"];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title></title>
    <link rel="stylesheet" href="style.css?v=10">

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
            <!-- 日付選択エリア -->
            <!-- <div class="container"> -->
                <div class="date mb-3">
                    <div class="row">
                        <div class="col-4 my-3 px-0">
                            <select class="select_width" name="year">
                                <option value="">-</option>
                                <option value="2000">2000</option>
                                <option value="2001">2001</option>
                                <option value="2002">2002</option>
                                <option value="2003">2003</option>
                                <option value="2004">2004</option>
                                <option value="2005">2005</option>
                                <option value="2006">2006</option>
                                <option value="2007">2007</option>
                                <option value="2008">2008</option>
                                <option value="2009">2009</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                            </select>　年
                        </div>

                        <div class="col-4 my-3 px-0">
                            <select class="select_width" name="month">
                                <option value="">-</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>　月
                        </div>

                        <div class="col-4 my-3 px-0">
                            <select class="select_width" name="day">
                                <option value="">-</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>　日
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.date(日付選択エリア) -->

                <!-- タブ -->
                    <form name="a_form" action="./write.php?tab=2" method="post">
                <nav class="nav nav-pills nav-justified">
                    <a class="nav-item nav-link tab_border <?php if (!isset($_GET["tab"])): ?>active<?php endif; ?>" href="./write.php" onclick="document.a_form.submit();">日記</a>
                    <a class="nav-item nav-link tab_border <?php if ($_GET["tab"] === "2"): ?>active<?php endif; ?>" href="?tab=2" onclick="document.a_form.submit();">詳細情報</a>
                </nav>
                <!-- /タブ -->

                <!-- コンテンツ -->
                <div class="contents">
                        <!-- hidden属性 -->
                        <input type="hidden" name="diary_data" value="<?php echo $_POST["diary"]["diary_text"]; ?>">
                        <input type="hidden" name="test" value="<?php echo $_POST["test"]; ?>">
                        <!-- /hidden属性 -->

                        <!-- 入力エリア -->
                        <div class="diary_area">
                            <!-- 日記タブ選択時 -->
                            <?php if (!isset($_GET["tab"])): ?>
                                本文<br>
                                <input type="text" name="test" value="test">
                                <textarea id="diary_text" name="diary_text" cols="50" rows="10"><?php echo $diary_text; ?></textarea>
                            <?php endif; ?>

                            <!-- 詳細情報タブ選択時 -->
                            <?php if (isset($_GET["tab"])): ?>
                                いいい
                                <?php var_dump($_POST["diary"]["diary_text"]); ?>
                                <?php var_dump($_POST["diary"]["test"]); ?>
                                <?php var_dump($_POST["test"]); ?>
                            <?php endif; ?>
                        </div>
                        <!-- /入力エリア -->
                </div>

                <!-- 送信・下書きボタン -->
                <div class="submit my-3">
                        <input id="draft" type="submit" name="draft" value="下書き">
                        <input id="send" type="submit" name="send" value="送信">
                </div>
            
                </form>
            



            <!-- </div> -->
            <!-- /.container -->
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


-->