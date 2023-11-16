<?php 

session_start();
ob_start();

require_once 'utils/utils.php';

include_once 'actions/checkAuthAction.php';

startDotEnvFile();

$appUrl = getenv('APP_URL') ?? 'http://localhost/troca-verde';
