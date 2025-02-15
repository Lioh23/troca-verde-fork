<?php 

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// preparar minha session
$_SESSION['nova_planta']['tipo_id'] = trim($data['tipo_id']);
$_SESSION['nova_planta']['especie_id'] = trim($data['especie_id']);
$_SESSION['nova_planta']['descricao'] = trim($data['descricao']);


// validação de campos
if(!$data['tipo_id']) {
  $_SESSION['error']['tipo_id'] = 'Você precisa selecionar um tipo de planta!';
}

if(!$data['especie_id']) {
  $_SESSION['error']['especie_id'] = 'Você precisa selecionar uma espécie de planta!';
}

if($_SESSION['error']) {
  header('Location: ../novaPlanta.php');
  exit;
}

// arquivo
$file = $_FILES['file_image'];

$ruleUploadFile = [
  'maxSizeMegaBytes' => 12,
  'allowedTypes'     => ['image/png', 'image/jpeg', 'image/jpg', 'image/webp']
];

// salvar meu arquivo 
if(!$file['error']) {

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

$sql = "INSERT INTO plantas 
    (usuario_id, tipo_id, especie_id, foto, descricao, created_at, updated_at) 
  VALUES(:usuario_id, :tipo_id, :especie_id, :foto, :descricao, now(), now())";

$bindings = [
  ':usuario_id' => $_SESSION['id'],
  ':tipo_id'    => $data['tipo_id'],
  'especie_id'  => $data['especie_id'],
  ':foto'       => $filePath ?? null,
  ':descricao'  => $data['descricao']
];

$executed = execute($conn, $sql, $bindings);

if($executed) {
  setFlashMessage('Nova planta cadastrada com sucesso!', 'success');
  unset($_SESSION['nova_planta']);
  header('Location: ../myProfile.php');
} else {
  setFlashMessage('Erro ao cadastrar a planta! Por favor, tente novamente mais tarde.', 'danger');
  header('Location: ../novaPlanta.php');
}