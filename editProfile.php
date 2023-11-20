<?php require_once('start.php') ?>

<?php $view = 'Editar Perfil' ?>
<?php $usuario = getDadosUsuario() ?>

<?php include_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
      <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>


  <div class="row justify-content-center mb-5">
    <div class="row">
      <div class="col-3">
        <div class="profile-image">
          <img src="assets/images/<?= $usuario['sexo'] == 'M' ? 'rosto_homem' : 'rosto_mulher' ?>.png" alt="">
        </div>
      </div>
      <div class="col-9 d-flex flex-column justify-content-center">
        <h4 class="mb-5">Adicione uma descrição ao seu perfil</h4>
        <form class="row" method="post" action="<?= $appUrl . '/actions/editProfileAction.php' ?>">
          <div class="col-12 mb-5">
            <textarea name="descricao" 
                id="descricao" 
                style="height: 10rem; resize: none"
                class="form-control form-control-lg <?= isset($_SESSION['error']['descricao']) ? 'is-invalid' : '' ?>"><?= $usuario['descricao'] ?? '' ?></textarea>
              <?= isset($_SESSION['error']['descricao']) ? '<div class="invalid-feedback">' . $_SESSION['error']['descricao'] . '</div>' : '' ?>
          </div>

          <div class="col-12">
            <button type="submit" class="btn btn-custom-brown custom-shape me-5" style="font-size: 1.1rem;">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include_once('template/system/menu.php') ?>
</main>

<?php include_once('template/base/footer.php') ?>
