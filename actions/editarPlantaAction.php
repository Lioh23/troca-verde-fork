<?php 

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$data['disabled_at'] = !isset($data['status']) ? date("Y-m-d H:i:s") : null;

$updateFoto = "";

$planta = getDadosPlanta($data['id']);

// arquivo
$file = $_FILES['file_image'];

$ruleUploadFile = [
  'maxSizeMegaBytes' => 12,
  'allowedTypes'     => ['image/png', 'image/jpeg', 'image/jpg', 'image/webp']
];

// salvar meu arquivo 
if(!$file['error']) {

  // atualizar foto
  $updateFoto = ", foto = :foto";

  // validação de tamanho
  if($file['size'] > (pow(1024, 2) * $ruleUploadFile['maxSizeMegaBytes'])) {
    setFlashMessage('Sua imagem precisa conter até 12MB', 'danger');
    header('Location: ../novaPlanta.php');
    exit;
  }

  // validação de tipo
  if(!in_array($file['type'], $ruleUploadFile['allowedTypes'])) {
    setFlashMessage('Arquivo contém formato inválido', 'danger');
    header('Location: ../novaPlanta.php');
    exit;
  }

   // remover a foto da planta anterior(ela exista)
   if($planta['foto']) {
    unlink(__DIR__ . '/..' . $planta['foto']);
  }


  // checa existencia de diretório, caso não exista, cria
  $fileDir = __DIR__ . '/../storage/plantas/'. $_SESSION['id'] . '/';

  if(!is_dir($fileDir)) {
    mkdir($fileDir, 0777, true);
  }
  $fileName = uniqid() . '.' .strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

  $filePath =  $fileDir . $fileName;

  $fileWasSaved = move_uploaded_file($file['tmp_name'], $fileDir . $fileName);

  if(!$fileWasSaved) {
    setFlashMessage('Erro ao salvar a imagem. Por favor, tente novamente mais tarde.', 'danger');
    header('Location: ../novaPlanta.php');
    exit;
  } 

  $filePath = '/storage/plantas/' . $_SESSION['id'] . '/' . $fileName;
}

// inserir a planta no banco de dados
$conn = getConnection();

$disabledAt = $data['disabled_at'] ? 'now()' : 'null';

$sql = "UPDATE plantas SET descricao = :descricao, disabled_at = $disabledAt, updated_at = now() $updateFoto WHERE id = :id";

$bindings = [
  'descricao' => $data['descricao'],
  'id'        => $data['id'],
];
if($updateFoto) $bindings['foto'] = $filePath ?? null;

$executed = execute($conn, $sql, $bindings);

if($executed) {
  setFlashMessage('Planta atualizada com sucesso!', 'success');
  unset($_SESSION['nova_planta']);
  header('Location: ../myProfile.php');
} else {
  setFlashMessage('Erro ao editar a planta! Por favor, tente novamente mais tarde.', 'danger');
  header('Location: ../editarPlanta.php?id=' . $data['id']);
}