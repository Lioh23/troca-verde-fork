<?php 

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$conn = getConnection();
$conn->beginTransaction();

try {
  // criar nova solicitação
  $sqlInsertSolicitacao = "INSERT INTO solicitacoes 
    (planta_id, solicitante_id, created_at, updated_at)
  VALUES
    (:planta_id, :solicitante_id, now(), now())";

  $solicitacaoId = executeGetId($conn, $sqlInsertSolicitacao, [
    'planta_id'      => $data['planta_id'],
    'solicitante_id' => $data['solicitante_id']
  ]); 
  
  if(!$solicitacaoId) 
    throw new Exception('Erro ao criar a solicitação');


  // gravar a mensagem
  $sqlInsertMessage = "INSERT INTO solicitacao_mensagens 
    (solicitacao_id, usuario_id, mensagem, created_at)
  VALUES
    (:solicitacao_id, :usuario_id, :mensagem, now())"; 
  
  $messageWasCreated = execute($conn, $sqlInsertMessage, [
    'solicitacao_id' => $solicitacaoId,
    'usuario_id'     => $_SESSION['id'],
    'mensagem'       => $data['mensagem']
  ]);

  if(!$messageWasCreated) 
    throw new Exception('Erro ao criar a mensagem');

  $conn->commit();

  setFlashMessage('Solicitação criada com sucesso!', 'success');
  header('Location: ../visualizarSolicitacao.php?id=' . $solicitacaoId);
  exit;
  
} catch (Exception $e) {

  $conn->rollBack();
  setFlashMessage('Erro ao criar a solicitação, tente novamente mais tarde!', 'danger');
  header('Location: ../visualizarPlanta.php?id=' . $data['planta_id']);
  exit;
}