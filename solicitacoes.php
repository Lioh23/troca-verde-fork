<?php require_once('start.php') ?>

<?php
$view = 'Minhas Solicitações';
$solicitacoes = getSolicitacoesUsuario();

?>

<?php require_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
    <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

  <h2 class="mb-5 text-center">Minhas solicitações</h2>

  <div class="row justify-content-center">
    <div class="col-8">
      <div class="row">
        <?php if (count($solicitacoes)) : ?>
          <?php foreach($solicitacoes as $index => $solicitacao): ?>
            <?php 
              if($solicitacao['status'] == 'Em andamento') {
                $icon = '<i class="fa-regular fa-clock text-primary"></i>';
              } else if ($solicitacao['status'] == 'Cancelada') {
                $icon = '<i class="fa-solid fa-ban text-danger"></i>';
              } else {
                $icon = '<i class="fa-regular fa-thumbs-up text-success"></i>';
              }
            ?>

            <div class="col-12 mb-4">
              <div class="card">
                
                <div class="card-body position-relative">

                  <div class="row">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                      <div class="col-12 imageWrapper m-0" style="width: 90px; height: 90px;">
                      <?php if($solicitacao['foto']): ?>
                        <img src="<?= $appUrl . $solicitacao['foto'] ?>">
                      <?php else: ?>
                        <i id="svg_planta" class="fa-solid fa-seedling" style="font-size: 3rem;"></i>
                      <?php endif; ?>
                    </div>

                    </div>
                    <div class="col-10">
                      <h5 class="card-title"><?= $solicitacao['descricao'] ?></h5>
                      <p class="card-text">
                        <span class="fw-semibold">Status:</span> 
                        <span class="fst-italic"><?= $solicitacao['status'] ?> </span>
                      </p>
                      <a 
                        href="visualizarSolicitacao.php?id=<?= $solicitacao['solicitacao_id'] ?>" 
                        class="btn btn-success rounded-pill"
                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                          Visualizar
                      </a>
                    </div>
                  </div>

                  <div class="position-absolute" style="bottom: 20px; right: 20px; font-size: 1.4rem"><?= $icon ?></div>
                </div>
                <div class="card-footer text-body-secondary" style="font-size: .9rem;">
                  Solicitado em <?= $solicitacao['dt_solicitacao'] ?>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        <?php else : ?>
          <div class="col-12 mt-5">

            <h4 class="text-center text-secondary fst-italic">Ainda não existem solicitações recebidas ou realizadas por você.</h4>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>


  <?php include_once('template/system/menu.php') ?>
</main>

<?php include('template/base/footer.php') ?>

<?php if (isset($_SESSION['cadastrar'])) unset($_SESSION['cadastrar']) ?>