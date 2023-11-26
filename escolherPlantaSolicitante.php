<?php require_once('start.php') ?>

<?php
$view = 'Visualizar Solicitação';

$solicitacao = getSolicitacao($_GET['id']);

if (!$solicitacao) {
  setFlashMessage('Solicitação inexistente!', 'danger');
  header('Location: myProfile.php');
}

$plantas = getPlantasDisponiveisUsuario($solicitacao['solicitante_id']);


$canEscolherPlantaSolicitante = $solicitacao['proprietario_id'] == $_SESSION['id'];


if (!$canEscolherPlantaSolicitante) {
  setFlashMessage('Você deve aguardar a escolha da planta por parte do proprietário!', 'danger');
  header('Location: visualizarSolicitacao.php?id=' . $_GET['id']);
  exit;
}
?>

<?php include_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
    <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

  <h5 class="text-center text-secondary fst-italic mb-5">Escolha uma planta de <?= $solicitacao['solicitante'] ?></h5>

  <div id="visualizar-solicitacao" class="row justify-content-center">
    <div class="col-8">
      <form method="post" action="actions/escolherPlantaAction.php" class="row" id="form_escolher_planta">
        <input type="hidden" name="solicitacao_id" value="<?= $_GET['id'] ?>">
        <?php foreach ($plantas as $planta) : ?>
          <div class="col-sm-2 col-md-3 mb-5" style="position: relative;">

            <?php if ($planta['is_favorite']) : ?>
              <div style="position: absolute; top: 10px; right: 30px; color: #CDC44D">
                <i class="fa-solid fa-star"></i>
              </div>
            <?php endif; ?>

            <input type="radio" class="btn-check" name="planta_id" value="<?= $planta['id'] ?>" id="planta_<?= $planta['id'] ?>" autocomplete="off">
            <label  class="card-plant-clickable searchable text-center" for="planta_<?= $planta['id'] ?>">
              <div class="col-12 imageWrapper m-auto mb-2" style="width: 90px; height: 90px;">
                <?php if ($planta['foto']) : ?>
                  <img src="<?= $appUrl . $planta['foto'] ?>">
                <?php else : ?>
                  <i class="fa-solid fa-seedling" style="font-size: 3rem;"></i>
                <?php endif; ?>
              </div>

              <h6 class="card-title mb-0"><?= $planta['especie'] ?></h6>
              <h6 class="card-subtitle fst-italic mb-0"><?= $planta['tipo'] ?></h6>
            </label>
          </div>
        <?php endforeach ?>

        <div class="row">
          <div class="col-12 d-flex justify-content-center gap-4">
            <button type="submit" class="rounded-pill btn btn-success">salvar</button>
            <a href="visualizarSolicitacao.php?id=<?= $_GET['id'] ?>" class="rounded-pill btn btn-danger">Voltar</a>
          </div>
        </div>
      </form>
    </div>



    <?php include_once('template/system/menu.php') ?>
</main>

<?php include_once('template/base/footer.php') ?>

<script>
  var radios = document.querySelectorAll('input[type="radio"]')

  function startRadios() {
    radios.forEach(radio => {
      radio.addEventListener('change', updateCheck)
    })
  }

  function updateCheck() {
    radios.forEach(radio => {
      if(radio.checked) {
        document.querySelector(`label[for="${radio.id}"]`).classList.add('checked')
      } else {
        document.querySelector(`label[for="${radio.id}"]`).classList.remove('checked')
      }
    })
  }

  setTimeout(() => {
    startRadios()
  }, 200);
</script>