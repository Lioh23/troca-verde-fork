<?php 

require_once '../start.php';

$_SESSION['active_menu'] = 'mensagens';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$mensagem = trim($data['mensagem']);

// validar os dados
if(strlen($mensagem) < 1) {
  $_SESSION['error']['mensagem'] = 'Você precisa escrever algoantes de enviar uma mensagem';
}

if(isset($_SESSION['error'])) {
  header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
  exit;
}

try {
  // gravar a mensagem
  $sqlInsertMessage = "INSERT INTO solicitacao_mensagens 
    (solicitacao_id, usuario_id, mensagem, created_at)
  VALUES
    (:solicitacao_id, :usuario_id, :mensagem, now())"; 
  
  $messageWasCreated = execute(getConnection(), $sqlInsertMessage, [
    'solicitacao_id' => $data['solicitacao_id'],
    'usuario_id'     => $_SESSION['id'],
    'mensagem'       => $data['mensagem']
  ]);
  
  if(!$messageWasCreated) 
    throw new Exception('Erro ao criar a mensagem');


  header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
  exit;

} catch(Exception $e) {
  setFlashMessage('Erro ao salvar a mensagem, tente novamente mais tarde!', 'danger');
  header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
  exit;
}
