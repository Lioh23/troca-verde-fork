<?php

require_once '../start.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$conn = getConnection();
$conn->beginTransaction();

try {

  // remover os favoritos anteriores
  $sqlRemoveFavoritos = "DELETE FROM favoritos WHERE usuario_id = :id";
  
  $stmt = $conn->prepare($sqlRemoveFavoritos);
  $stmt->bindParam('id', $_SESSION['id']);
    
  if($stmt->execute()) {
    // inserir os novos favoritos
    foreach($data['favoritos'] as $favorito) {
      $sqlNovoFavorito = "INSERT INTO favoritos (usuario_id, especie_id, created_at) VALUES (:usuario_id, :especie_id, now())";
  
      $stmt = $conn->prepare($sqlNovoFavorito);
      $stmt->bindParam(':usuario_id', $_SESSION['id']);
      $stmt->bindParam(':especie_id', $favorito);
     
      $stmt->execute();
    }
  } else {

    throw new PDOException('Não foi possível executar o delete');
  }

  $conn->commit();

  setFlashMessage('Favoritos atualizados com sucesso!', 'success');
  header('Location: ../myProfile.php');

} catch(PDOException $exception) {

  $conn->rollBack();

  setFlashMessage('Erro ao atualizar favoritos, por favor tente novamente!', 'danger');
  header('Location: ../editInteresses.php');
}