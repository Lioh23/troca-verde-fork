<?php 

require_once '../start.php';


$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$descricao = trim($data['descricao']) ?? '';

// armazenar na sessão
$_SESSION['edit']['descricao'] = $descricao;

// validar se o campo não está vazio
if($descricao == '') {
  $_SESSION['error']['descricao'] = 'Esse campo não pode estar vazio';
  header('Location: ../editProfile.php');
  exit;
}

$sql = "UPDATE usuarios SET descricao = :descricao, updated_at = now() WHERE id = :id";
$conn = getConnection();
$success = execute($conn, $sql, [':descricao' => $descricao, 'id' => $_SESSION['id']]);

if($success) {
  setFlashMessage('Alteração realizada com sucesso!', 'success');
  header('Location: ../myProfile.php');
} else {
  setFlashMessage('Houve um erro ao tentar alterar a sua descrição, por favor, tente mais tarde', 'danger');
  header('Location: ../editProfile.php');
}
