<?php 

require_once '../start.php';

unset($_SESSION['id']);
unset($_SESSION['nome']);
unset($_SESSION['email']);

header('Location: ../index.php');