<?php 

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


if($data['action'] == 'aceitar') { // aceitar solicitação
  $executed = aceitarSolicitacao(
    $data['solicitacao_id'], 
    $data['planta_solicitante_id'], 
    $data['planta_proprietario_id'],
    $data['proprietario_id'],
    $data['solicitante_id'],
  );

  if($executed) {
    setFlashMessage('Solicitação finalizada com sucesso!', 'success');
    header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
    exit;
  }

  setFlashMessage('Erro ao finalizar solicitação, tente novamente mais tarde!', 'danger');
  header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
  exit;

} else { // recusar solicitação
  $executed = recusarSolicitacao($data['solicitacao_id'], $data['agente']);

  if($executed) {
    setFlashMessage('Solicitação cancelada com sucesso!', 'success');
    header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
    exit;
  }

  setFlashMessage('Erro ao cancelar solicitação, tente novamente mais tarde!', 'danger');
  header('Location: ../visualizarSolicitacao.php?id=' . $data['solicitacao_id']);
  exit;
}



/* functions */

function aceitarSolicitacao($solicitacaoId, $plantaSolicitanteId, $plantaProprietarioId, $proprietarioId, $solicitanteId) {

  $conn = getConnection();
  $conn->beginTransaction();

  $executed = execute($conn, "UPDATE solicitacoes SET solic_accepted_at = now() where id = :id", [ 'id' => $solicitacaoId ]);
  if(!$executed) return false;

  $solicitacoesACancelar = getSolicitacoesACancelar($plantaSolicitanteId, $plantaProprietarioId, $solicitacaoId);

  $motivoId = 3;

  foreach($solicitacoesACancelar as $solicitacao) {

    $executed = execute($conn, "UPDATE solicitacoes 
      SET canceled_at = now(), updated_at = now(), cancelamento_motivo_id = :motivo_id
      where id = :id", ['id' => $solicitacao['id'], 'motivo_id' => $motivoId ]
    );

    if(!$executed) return false;    
  }

  $executed = execute($conn, "UPDATE plantas 
    SET 
      donated_at = now(), 
      updated_at = now(),
      donated_to = :proprietario_id
      where id = :planta_id", ['planta_id' => $plantaSolicitanteId, 'proprietario_id' => $proprietarioId]);
  if(!$executed) return false;

  $executed = execute($conn, "UPDATE plantas 
    SET 
      donated_at = now(), 
      updated_at = now(),
      donated_to = :solicitante_id
      where id = :planta_id", ['planta_id' => $plantaProprietarioId, 'solicitante_id' => $solicitanteId]);
  if(!$executed) return false;


  $conn->commit();
  
  return true;
}

function recusarSolicitacao($solicitacaoId, $agente) {
  $motivoId = $agente == 'solicitante' ? 1 : 2;

  $conn = getConnection();
  
  $executed = execute($conn, "UPDATE solicitacoes 
    SET canceled_at = now(), updated_at = now(), cancelamento_motivo_id = :motivo_id, canceled_by = :canceled_by 
    where id = :id",
    [
      'motivo_id' => $motivoId,
      'canceled_by' => $_SESSION['id'],
      'id' => $solicitacaoId
    ]
  );

  return $executed;
}

function getSolicitacoesACancelar($plantaSolicitanteId, $plantaProprietarioId, $solicitacaoId) {
  return fetchAll("SELECT
      id
    from 
      solicitacoes s
    where
      (planta_id in ($plantaSolicitanteId, $plantaProprietarioId) or solicitante_planta_id in ($plantaSolicitanteId, $plantaProprietarioId))
      and canceled_at is null 
      and not (
        propriet_accepted_at is null and
        s.solic_accepted_at is null
      )
      and id <> :solicitacao_id", ['solicitacao_id' => $solicitacaoId]
  );
}