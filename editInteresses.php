<?php require_once('start.php') ?>

<?php 
  $view = 'Plantas para interesse';
  $favoritos = getCheckFavoritosUsuario(); 
?>

<?php include_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
      <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

  <h1 class="text-center mb-5">Selecione suas mudas favoritas</h1>  

  <div class="row justify-content-center mb-5">
    <div class="col-7">
      <div class="row">
        <div class="col-12">
          <form action="actions/editInteressesAction.php" method="POST">
            <div class="row mb-3">
              <?php foreach ($favoritos as $favorito): ?>
                <div class="d-grid gap-2 col-6 mx-auto">
                  <input type="checkbox" class="btn-check" name="favoritos[]" 
                         <?= $favorito['checked'] ? 'checked' : '' ?>
                         id="favorito_<?= $favorito['id'] ?>"  
                         value="<?= $favorito['id'] ?>" autocomplete="off">
                  <label class="fw-semibold custom-shape btn btn-lg btn-outline-success mb-3" for="favorito_<?= $favorito['id'] ?>">
                    <i class="fa-solid fa-leaf"></i> <?= $favorito['especie'] ?>
                  </label>
                </div>
              <?php endforeach ?>
            </div>
              
            <div class="row justify-content-center mb-4">
              <div class="col-6">
                <input class="btn-custom-brown custom-shape" type="submit" value="salvar" style="width: 100%;">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include_once('template/system/menu.php') ?>
</main>

<?php include_once('template/base/footer.php') ?>