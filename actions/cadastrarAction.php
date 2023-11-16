<?php

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$nome             = trim($data['nome']) ?? '';
$sexo             = trim($data['sexo']) ?? '';
$logradouro       = trim($data['logradouro']) ?? '';
$numero           = trim($data['numero']) ?? '';
$complemento      = trim($data['complemento']) ?? null;
$bairro           = trim($data['bairro']) ?? '';
$cidade           = trim($data['cidade']) ?? '';
$uf               = strtoupper(trim($data['uf'])) ?? '';
$email            = trim($data['email']) ?? '';
$senha            = trim($data['senha']) ?? '';
$confirmacaoSenha = trim($data['confirmacao_senha']) ?? '';


// salvar os dados na sessão
$_SESSION['cadastrar']['nome'] = $nome;
$_SESSION['cadastrar']['sexo'] = $sexo;
$_SESSION['cadastrar']['logradouro'] = $logradouro;
$_SESSION['cadastrar']['numero'] = $numero;
$_SESSION['cadastrar']['complemento'] = $complemento;
$_SESSION['cadastrar']['bairro'] = $bairro;
$_SESSION['cadastrar']['cidade'] = $cidade;
$_SESSION['cadastrar']['uf'] = $uf;
$_SESSION['cadastrar']['email'] = $email;


// validar os dados
if(strlen($nome) < 3) {
    $_SESSION['error']['nome'] = 'O nome precisa conter 3 ou mais caraceteres';
}

if(strlen($sexo) < 1) {
    $_SESSION['error']['sexo'] = 'Você precisa preencher este campo!';
}

if(strlen($logradouro) < 1) {
    $_SESSION['error']['logradouro'] = 'Você precisa preencher este campo!';
}

if(strlen($numero) < 1) {
    $_SESSION['error']['numero'] = '';
}

if(strlen($bairro) < 3) {
    $_SESSION['error']['bairro'] = 'Você precisa informar o bairro';
}

if(strlen($cidade) < 3) {
    $_SESSION['error']['cidade'] = 'A cidade precisa conter 3 ou mais caraceteres';
}

if(strlen($uf) != 2) {
    $_SESSION['error']['uf'] = 'A Unidade Federativa precisa conter apenas 2 caracteres';
}

if(strlen($email) < 8 || !strpos($email, '@')) {
    $_SESSION['error']['email'] = 'E-Mail inválido';
}

if(!$senha) {
    $_SESSION['error']['senha'] = 'O campo "senha" não pode estar vazio';
}

if($senha !== $confirmacaoSenha) {
    $_SESSION['error']['confirmacao_senha'] = 'As senhas precisam ser iguais';
}

if(isset($_SESSION['error'])) {
    header('Location: ../cadastrar.php'); exit;
}


// criar o hash da senha
$passwordHash = password_hash($senha, PASSWORD_DEFAULT);


// salvar no banco de dados
$sqlSave = "INSERT INTO usuarios (
        nome, sexo, logradouro, numero, complemento, bairro,  cidade,  uf,  email,  password_hash,  created_at,  updated_at
    ) VALUES (
        :nome, :sexo, :logradouro, :numero, :complemento, :bairro,  :cidade,  :uf,  :email,  :password_hash, now(), now()
    )";

$bindings = [
    ':nome'          => $nome,
    ':sexo'          => $sexo,
    ':logradouro'    => $logradouro,
    ':numero'        => $numero,
    ':complemento'   => $complemento,
    ':bairro'        => $bairro,
    ':cidade'        => $cidade,
    ':uf'            => $uf,
    ':email'         => $email,
    ':password_hash' => $passwordHash
];

if(execute(getConnection(), $sqlSave, $bindings)) {
    if(isset($_SESSION['cadastrar'])) unset($_SESSION['cadastrar']);

    setFlashMessage('Usuário cadastrado com sucesso!', 'success');
    header('Location: ../login.php');
} else {
    setFlashMessage('Erro inesperado ao cadastrar o usuário! por favor tende novamente mais tarde', 'danger');
    header('Location: ../cadastrar.php');
}
