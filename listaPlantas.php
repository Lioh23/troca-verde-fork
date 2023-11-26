<?php require_once('start.php') ?>

<?php
$view = 'Lista de Plantas Disponíveis';
$page = $_GET['page'] ?? 1;
$especie = isset($_GET['especie']) ? trim($_GET['especie']) : '';
$plantasDisponiveis = getPlantasDisponiveis($especie, $page, 8);
?>

<?php include_once('template/base/header.php') ?>


<main class="container">
  <div class="d-flex justify-content-center mb-5">
    <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

  <div class="row justify-content-center mb-5">
    <div class="col-sm-8">

      <form action="" class="row mb-5">
        <div class="col-12 mx-auto">
          <div class="input-group mb-4 rounded-pill p-1 input-custom-avocado" style="overflow: hidden;">
            <input type="search" name="especie" placeholder="Busque uma planta" value="<?= $_GET['especie'] ?? '' ?>" class="form-control shadow-none bg-none border-0">
            <div class="input-group-append border-0">
              <button type="submit" class="btn btn-link text-success">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </form>


      <div class="row mb-5">
        <div class="col-12">

          <?php if ($plantasDisponiveis['total'] > 0) : ?>
            <div class="row">
              <?php foreach ($plantasDisponiveis['data'] as $planta) : ?>
                <div class="col-sm-2 col-md-3 mb-5" style="position: relative;">

                  <?php if ($planta['is_favorite']) : ?>
                    <div style="position: absolute; top: 10px; right: 30px; color: #CDC44D">
                      <i class="fa-solid fa-star"></i>
                    </div>
                  <?php endif; ?>

                  <a class="card-plant-clickable searchable text-center" href="<?= "visualizarPlanta.php?id={$planta['id']}" ?>">
                    <div class="col-12 imageWrapper m-auto mb-2" style="width: 90px; height: 90px;">
                      <?php if ($planta['foto']) : ?>
                        <img src="<?= $appUrl . $planta['foto'] ?>">
                      <?php else : ?>
                        <i class="fa-solid fa-seedling" style="font-size: 3rem;"></i>
                      <?php endif; ?>
                    </div>

                    <h6 class="card-title mb-0"><?= $planta['especie'] ?></h6>
                    <h6 class="card-subtitle mb-0 text-muted"><?= $planta['localizacao'] ?></h6>
                  </a>
                </div>
              <?php endforeach ?>
            </div>
            <div class="d-flex justify-content-between">
              <p class="fw-semibold">
                Total de Registros: <?= $plantasDisponiveis['total'] ?>
              </p>
              <div>

                <a href="<?= $plantasDisponiveis['prev'] ?>" class="btn btn-primary rounded-pill <?= !$plantasDisponiveis['prev'] ? 'disabled' : '' ?>" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                  Anterior
                </a>
                <a href="<?= $plantasDisponiveis['next'] ?>" class="btn btn-primary rounded-pill <?= !$plantasDisponiveis['next'] ? 'disabled' : '' ?>" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                  Próxima
                </a>

              </div>
            </div>
          <?php else : ?>
            <p>Ainda não há nenhuma muda para doação</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  </div>

  <?php include_once('template/system/menu.php') ?>
</main>

<?php include_once('template/base/footer.php') ?>