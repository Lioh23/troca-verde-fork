<?php require_once('start.php') ?>

<?php 
  $view = 'Visualizar Planta';
  $planta = getDadosPlanta($_GET['id']);
  $favoritos = getUsuarioFavoritos();

  if(!$planta) {
    setFlashMessage('Planta não localizada!', 'danger');
    header('Location: myProfile.php');
    exit;
  }
?>

<?php include_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
      <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

  <div class="row justify-content-center mb-5">
    <div class="col-sm-8">

      <div class="row">
        <div class="col-4">

          <div class="d-flex mb-4 justify-content-center position-relative">
            <div class="imageWrapper" style="height: 210px; width: 210px;">
              <?php if($planta['foto']): ?>
                <img id="img_planta" class="image" src="<?= $appUrl . $planta['foto'] ?>" style="width: 100%; height: 100%; object-fit: cover">
                <?php else: ?>
                  <i id="svg_planta" class="fa-solid fa-seedling" style="font-size: 8rem; color: white"></i>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="col-8 d-flex flex-column justify-content-center">
            <p class="mb-3 fst-italic text-secondary">
              Publicado em: <?= $planta['dt_publicacao'] ?>
            </p>

            <?php if($planta['status'] == 0): ?>
              <span class="badge bg-danger mb-3" style="width: 220px;"><?= $planta['status_text'] ?></span>
            <?php endif; ?>

            <h1 class="mb-2"><?= $planta['especie'] ?></h1>
            <h3 class="mb-2 text-secondary"><?= $planta['tipo'] ?></h3>
            <p class="mb-2 fw-semibold">
              <?php if($planta['descricao']): ?>
                Descrição: <?= $planta['descricao'] ?>
              <?php else: ?>
                  Nenhuma descrição foi adicionada à esta planta
              <?php endif; ?>
            </p>
        </div>
        
        <?php if($_SESSION['id'] != $planta['proprietario_id']): ?>
          <hr class="my-4">
          
          <h2 class="mb-5">Proprietári<?= $planta['proprietario_sexo'] == 'M' ? 'o' : 'a' ?> de origem</h2>

          <div class="row mb-5">
            <div class="col-sm-2">
              <div class="profile-image" style="width: 120px;">
                <img src="assets/images/<?= $planta['proprietario_sexo'] == 'M' ? 'rosto_homem' : 'rosto_mulher' ?>.png" alt="">
              </div>
            </div>
            <div class="col-sm-10">
                <h4 class="mt-4"><?= $planta['proprietario'] ?></h4>
                <h6 class="text-secondary"><?= $planta['cidade'] ?> - <?= $planta['uf'] ?></h6>
            </div>
          </div>

          <?php if($planta['status'] == 1): ?>
          <div class="d-flex justify-content-center">
            <form action="actions/solicitarPlantaAction.php" method="POST" id="form_solicitacao">
              <input type="hidden" name="solicitante_id" value="<?= $_SESSION['id'] ?>" >
              <input type="hidden" name="planta_id" value="<?= $_GET['id'] ?>" >
              <input type="hidden" name="mensagem">
              <button type="button" class="btn btn-lg btn-success rounded-pill" data-bs-toggle="modal" data-bs-target="#messageModal">Solicitar</button>
            </form>
          </div>
          <?php endif; ?>
          
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <form class="modal-content" id="form_message">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Deixe uma mensagem para <?= $planta['proprietario'] ?></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating">
            <textarea class="form-control" placeholder="Deixe sua mensagem aqui" 
                      name="modal_message" id="modal_message" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Mensagem</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-custom-brown rounded-pill">Abrir Solicitação</button>
        </div>
      </form>
    </div>
  </div>
  
  <?php include_once('template/system/menu.php') ?>
</main>

<?php include_once('template/base/footer.php') ?>

<script>
  document.getElementById('form_message').addEventListener('submit', function (event) {
      event.preventDefault()

      // textarea modal
      const { modal_message } = this

      if(!modal_message.value.trim()){
        modal_message.classList.add('is-invalid')
        return
      }

      modal_message.classList.remove('is-invalid')

      const formSolicitacao = document.getElementById('form_solicitacao')
      const { mensagem } = formSolicitacao;

      // guarda a informção do textarea do modal dentro do input hidden 
      mensagem.value = modal_message.value;

      // submeter o formulário
      formSolicitacao.submit()
    }
  )
</script>