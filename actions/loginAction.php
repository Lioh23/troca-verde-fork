<?php 

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$email = trim($data['email']) ?? '';
$senha = trim($data['senha']) ?? '';

// email
$_SESSION['login']['email'] = $email;

if(strlen($email) < 8 || !strpos($email, '@')) {
    failLogin(); 
    exit;
}

if(!$senha) {
    failLogin(); 
    exit;
}

$sqlFindUser = "SELECT * FROM usuarios WHERE email = :email";

$connection = getConnection();

$stmt = $connection->prepare($sqlFindUser);
$stmt->bindParam(':email', $email);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$usuario) {
    failLogin(); 
    exit;
}

if(!password_verify($senha, $usuario['password_hash'])) {
    failLogin(); 
    exit;
}

// logar
if(isset($_SESSION['login']['email'])) unset($_SESSION['login']['email']);

$_SESSION['id'] = $usuario['id'];
$_SESSION['nome'] = $usuario['nome'];
$_SESSION['email'] = $usuario['email'];

header('Location: ../myProfile.php');


// functions

function failLogin() {
    setFlashMessage('E-Mail ou senha inválida', 'danger');
    header('Location: ../login.php');
}