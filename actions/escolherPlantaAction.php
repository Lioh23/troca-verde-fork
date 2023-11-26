<?php 

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(!isset($data['planta_id'])) {
  setFlashMessage('Você precisa selecionar uma planta!', 'danger');
  header('Location: ../escolherPlantaSolicitante.php?id=' . $data['solicitacao_id']);
  exit;
}

try {
  $executed = execute(getConnection(), "UPDATE solicitacoes 
      SET solicitante_planta_id = :planta_id, updated_at = now(), propriet_accepted_at = now() where id = :solicitacao_id", [
    'planta_id' => $data['planta_id'],
    'solicitacao_id' => $data['solicitacao_id']
  ]);

  if(!$executed)
    throw new Exception('Erro ao salvar a planta selecionada');

  setFlashMessage('Planta selecionada com sucesso, aguarde o solicitante aceitar a troca da planta que você escolheu!', 'success');
  header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
  exit;
  
} catch (Exception $e) {

  $conn->rollBack();
  setFlashMessage('Erro ao salvar a planta selecionada, tente novamente mais tarde!', 'danger');
  header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
  exit;
}