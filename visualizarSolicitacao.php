<?php require_once('start.php') ?>

<?php 
  $view = 'Visualizar Solicitação';
  // $planta = getDadosPlanta($_GET['id']);
  // $favoritos = getUsuarioFavoritos();

  // if(!$planta) {
  //   setFlashMessage('Planta não localizada!', 'danger');
  //   header('Location: myProfile.php');
  //   exit;
  // }
?>

<?php include_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
      <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

    <h1>Solicitação</h1>
  
  <?php include_once('template/system/menu.php') ?>
</main>

<?php include_once('template/base/footer.php') ?>
