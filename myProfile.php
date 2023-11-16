<?php require_once('start.php') ?>

<?php 
  $view = 'Meu Perfil';
  $usuario = getDadosUsuario(); 
  $plantas = getUsuarioPlantas();
  $favoritos = getUsuarioFavoritos();
?>

<?php include_once('template/base/header.php') ?>

<style>
  #svg_planta {
    font-size: 3rem;
  }
</style>

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
        <h2 class="mb-4"><?= $usuario['nome'] ?></h2>
        <h4 class="mb-4"><?= $usuario['cidade'] ?> - <?= $usuario['uf'] ?></h4>
        <p class="mb-4 bg-da"><?= $usuario['descricao'] ?? 'Nenhuma descrição foi adicionada para este usuário ainda.' ?></p>
        <a class="text-dark" href="/editProfile.php" style="font-size: 1.6rem;"><i class="fa-solid fa-pen-fancy"></i></a>
      </div>
    </div>
  </div>

  <div class="row jusitfy-content-center mb-5">
    <div class="col-12">
      <h2 class="mb-4">
        Mudas para doação &nbsp;
        <a href="novaPlanta.php" class="btn-add" style="position: relative; top: 5px"><i class="fa-solid fa-plus"></i></a>
      </h2>
      <?php if(count($plantas)): ?>
        <div class="row">
          <?php foreach($plantas as $planta): ?>
            <div class="col-2 mb-5">
                <div class="text-center">

                  <div class="col-12 imageWrapper m-auto mb-1" style="width: 100px; height: 100px; border-width: 2px">
                    <?php if($planta['foto']): ?>
                      <img class="image" src="<?= $appUrl . $planta['foto'] ?>">
                    <?php else: ?>
                      <i id="svg_planta" class="fa-solid fa-seedling"></i>
                    <?php endif; ?>
                  </div>

                  <h5 class="card-title mb-1"><?= $planta['especie'] ?></h5>
                  <h6 class="card-subtitle mb-1 text-muted"><?= $planta['tipo'] ?></h6>
                  <!-- <a href="#" class="card-link">Card link</a>
                  <a href="#" class="card-link">Another link</a> -->
                </div>
            </div>
          <?php endforeach ?>
        </div>
      <?php else: ?>
        <p>Ainda não há nenhuma muda para doação</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row jusitfy-content-center mb-5">
    <div class="col-12">
      <h2 class="mb-4">Plantas que eu tenho interesse para troca &nbsp;
        <a href="editInteresses.php" class="btn-add" style="position: relative; top: 5px"><i class="fa-solid fa-plus"></i></a>
      </h2>

      <?php if($lenFavoritos = count($favoritos)): ?>
        <p>
          <?php foreach($favoritos as $index => $favorito): ?>
            <?= $index == $lenFavoritos - 1 // checa se é o último último 
                ? "{$favorito['nome']}." 
                : ($index == $lenFavoritos - 2 // checa se é o penúltimo
                  ? "{$favorito['nome']} e " 
                  : "{$favorito['nome']}, " ) ?>
          <?php endforeach ?>
        </p>
      <?php else: ?>
      <p>Ainda não há interesses adicionados.</p>
      <?php endif ?>
    </div>
  </div>  


  <?php include_once('template/system/menu.php') ?>
</main>

<?php include_once('template/base/footer.php') ?>
