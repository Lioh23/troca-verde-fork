<?php

require_once('databaseUtils.php');

require_once('usuarioUtils.php');

require_once('plantaUtils.php');

require_once('formatUtils.php');

function setFlashMessage($text, $color) {
    $_SESSION['flashMessage']['text'] = $text;
    $_SESSION['flashMessage']['color'] = $color;
}


function startDotEnvFile() {

    if(!file_exists('.env')) {
        return false;
    }
    $contents = explode(PHP_EOL, file_get_contents('.env'));

    foreach($contents as $content) {        
        putenv(trim($content));
    }
}