<?php

// XSS
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

// タイムゾーン
date_default_timezone_set("Asia/Tokyo")


?>