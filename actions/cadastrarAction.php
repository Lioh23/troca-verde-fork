<?php

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$nome             = trim($data['nome']) ?? '';
$cidade           = trim($data['cidade']) ?? '';
$estado           = strtoupper(trim($data['estado'])) ?? '';
$email            = trim($data['email']) ?? '';
$senha            = trim($data['senha']) ?? '';
$confirmacaoSenha = trim($data['confirmacao_senha']) ?? '';

// validar os dados

// nome
$_SESSION['cadastrar']['nome'] = $nome;
if(strlen($nome) < 3) {
    $_SESSION['error']['nome'] = 'O nome precisa conter 3 ou mais caraceteres';
}

// cidade
$_SESSION['cadastrar']['cidade'] = $cidade;
if(strlen($cidade) < 3) {
    $_SESSION['error']['cidade'] = 'A cidade precisa conter 3 ou mais caraceteres';
}

// estado
$_SESSION['cadastrar']['estado'] = $estado;
if(strlen($estado) != 2) {
    $_SESSION['error']['estado'] = 'A Unidade Federativa precisa conter apenas 2 caracteres';
}

// email
$_SESSION['cadastrar']['email'] = $email;
if(strlen($email) < 8 || !strpos($email, '@')) {
    $_SESSION['error']['email'] = 'E-Mail inválido';
}

// senha
if(!$senha) {
    $_SESSION['error']['senha'] = 'O campo "senha" não pode estar vazio';
}

// senhas iguais
if($senha !== $confirmacaoSenha) {
    $_SESSION['error']['confirmacao_senha'] = 'As senhas precisam ser iguais';
}

if(isset($_SESSION['error'])) {
    header('Location: ../cadastrar.php');
}

// criar o hash da senha
$passwordHash = password_hash($senha, PASSWORD_DEFAULT);

// salvar no banco de dados
$sqlSave = "INSERT INTO usuarios (nome, email, password_hash, cidade, estado, created_at, updated_at)
            VALUES (:nome, :email, :password_hash, :cidade, :estado, now(), now())";

$connection = getConnection();
$stmt = $connection->prepare($sqlSave);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password_hash', $passwordHash);
$stmt->bindParam(':cidade', $cidade);
$stmt->bindParam(':estado', $estado);

if($stmt->execute()) {
    if(isset($_SESSION['cadastrar'])) unset($_SESSION['cadastrar']);
    setFlashMessage('Usuário cadastrado com sucesso!', 'success');
    header('Location: ../login.php');
} else {
    setFlashMessage('Erro inesperado ao cadastrar o usuário! por favor tende novamente mais tarde', 'danger');
    header('Location: ../cadastrar.php');
}
