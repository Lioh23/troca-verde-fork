<?php

function getConnection() {
    try {
        $dsn = 'mysql:dbname=troca_verde;host=127.0.0.1';
        $user = 'root';
        $password = '';
        $connection = new PDO($dsn, $user, $password);

        return $connection;
    } catch (PDOException $e) { 
        echo 'Não foi possível se conectar com a base de dados - ' . $e->getMessage(); exit;
    }
}

function setFlashMessage($text, $color) {
    $_SESSION['flashMessage']['text'] = $text;
    $_SESSION['flashMessage']['color'] = $color;
}