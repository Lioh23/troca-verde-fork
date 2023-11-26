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

function fetchAll(string $sql, array $bindings = []) {
  try {
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute($bindings);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch(PDOException $e) {
    return 'Não foi possível realizar sua consulta.';
  }
}

function fetch(string $sql, array $bindings = []) {
  try {
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute($bindings);

    return $stmt->fetch(PDO::FETCH_ASSOC);

  } catch(PDOException $e) {
    return 'Não foi possível realizar sua consulta.';
  }
}

function execute(PDO $conn, $sql, $bindings) {
  $stmt = $conn->prepare($sql);
  
  return $stmt->execute($bindings);
}

function executeGetId(PDO $conn, $sql, $bindings) {
  $stmt = $conn->prepare($sql);
  
  $executed = $stmt->execute($bindings);

  return $executed ? $conn->lastInsertId() : false;
}