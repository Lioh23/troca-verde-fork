<?php

// rotas livres de autenticação
$freeRoutes = [
  '/login.php', 
  '/cadastrar.php',
  '/actions/loginAction.php',
  '/actions/cadastrarAction.php',
  '/actions/logoutAction.php'
];

$route = $_SERVER['REQUEST_URI'];

if(!in_array($route, $freeRoutes)) {
 
  if(!isset($_SESSION['id']) || !isset($_SESSION['nome']) || !isset($_SESSION['email'])) {
    header('Location: login.php'); exit;
  }
}
