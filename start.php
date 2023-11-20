<?php 

session_start();
ob_start();

require_once 'utils/utils.php';

include_once 'actions/checkAuthAction.php';

startDotEnvFile();

global $appUrl;

$appUrl = getenv('APP_URL') ?? 'http://localhost/troca-verde';
