<?php require_once('start.php') ?>

<?php
$view = 'Visualizar Solicitação';

$solicitacao = getSolicitacao($_GET['id']);

if (!$solicitacao) {
  setFlashMessage('Solicitação inexistente!', 'danger');
  header('Location: myProfile.php');
}

$canVisualizarSolicitacao =
  $solicitacao['proprietario_id'] == $_SESSION['id'] ||
  $solicitacao['solicitante_id'] == $_SESSION['id'];

if (!$canVisualizarSolicitacao) {
  setFlashMessage('Você não pode visualizar solicitações em que não estão associadas ao seu perfil!', 'danger');
  header('Location: myProfile.php');
  exit;
}

$plantaProprietario = getDadosPlanta($solicitacao['proprietario_planta_id']);
$plantaSolicitante = getDadosPlanta($solicitacao['solicitante_planta_id']);

$mensagens = getSolicitacaoMensagens($_GET['id']);

if (isset($_SESSION['active_menu'])) {
  $activeMenu = $_SESSION['active_menu'];
  unset($_SESSION['active_menu']);
} else {
  $activeMenu = 'detalhes';
}
?>

<?php include_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
    <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

  <h5 class="text-center text-secondary fst-italic mb-2"><?= $solicitacao['titulo'] ?></h5>
  <h4 class="text-center mb-5">
    <span class="badge bg-success rounded-pill"><?= $solicitacao['status'] ?></span>
  </h4>

  <div id="visualizar-solicitacao" class="row justify-content-center mb-5">
    <div class="col-7">
      <div class="row">
        <div class="col-12">
          <ul class="nav nav-pills mb-4 d-flex justify-content-around" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link rounded-pill <?= $activeMenu == 'detalhes' ? 'active' : '' ?>" id="detalhes-tab" data-bs-toggle="tab" data-bs-target="#detalhes-tab-pane" type="button" role="tab" aria-controls="detalhes-tab-pane" aria-selected="true">
                Detalhes
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link rounded-pill <?= $activeMenu == 'mensagens' ? 'active' : '' ?>" id="mensagens-tab" data-bs-toggle="tab" data-bs-target="#mensagens-tab-pane" type="button" role="tab" aria-controls="mensagens-tab-pane" aria-selected="false">
                Mensagens
              </button>
            </li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane fade <?= $activeMenu == 'detalhes' ? 'show active' : '' ?>" id="detalhes-tab-pane" role="tabpanel" aria-labelledby="detalhes-tab" tabindex="0">
              <div class="row">

                <!-- planta do proprietário -->
                <div class="col-6 mb-4">

                  <div class="card">
                    <div class="card-header text-bg-success">
                      <h5 class="text-center m-0">Escolhida pelo solicitante</h5>
                    </div>

                    <div class="card-body position-relative">

                      <div style="min-height: 300px;">
                        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 135px;">
                          <div class="imageWrapper mb-2" style="width: 110px; height: 110px;">
                            <?php if ($plantaProprietario['foto']) : ?>
                              <img src="<?= $appUrl . $plantaProprietario['foto'] ?>">
                            <?php else : ?>
                              <i id="svg_planta" class="fa-solid fa-seedling" style="font-size: 4rem;"></i>
                            <?php endif; ?>
                          </div>
                        </div>

                        <hr class="my-2">

                        <div class="col-12">
                          <h4 class="card-title"><?= $plantaProprietario['especie'] ?></h4>
                          <h5 class="text-secondary"><?= $plantaProprietario['tipo'] ?></h5>
                          <p class="fst-italic">
                            <?= $plantaProprietario['descricao'] ?>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-body-secondary" style="font-size: .9rem;">
                      <?= $plantaProprietario['proprietario'] ?> | <?= $plantaProprietario['cidade'] ?> - <?= $plantaProprietario['uf'] ?>
                    </div>
                  </div>
                </div>

                <!-- planta do solicitante -->
                <div class="col-6 mb-4">

                  <div class="card">
                    <div class="card-header text-bg-success">
                      <h5 class="text-center m-0">Escolhida pelo proprietário</h5>
                    </div>

                    <div class="card-body position-relative">

                      <?php if ($plantaSolicitante) : ?>
                        <div style="min-height: 300px;">
                          <div class="col-12 d-flex justify-content-center align-items-center" style="height: 135px;">
                            <div class="imageWrapper mb-2" style="width: 110px; height: 110px;">
                              <?php if ($plantaSolicitante['foto']) : ?>
                                <img src="<?= $appUrl . $plantaSolicitante['foto'] ?>">
                              <?php else : ?>
                                <i id="svg_planta" class="fa-solid fa-seedling" style="font-size: 4rem;"></i>
                              <?php endif; ?>
                            </div>
                          </div>

                          <hr class="my-2">

                          <div class="col-12">
                            <h4 class="card-title"><?= $plantaSolicitante['especie'] ?></h4>
                            <h5 class="text-secondary"><?= $plantaSolicitante['tipo'] ?></h5>
                            <p class="fst-italic">
                              <?= $plantaSolicitante['descricao'] ?>
                            </p>
                          </div>
                        </div>
                      <?php else : ?>
                        <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 300px;">
                          <?php if ($solicitacao['proprietario_id'] == $_SESSION['id']) : ?>
                            <h5 class="text-center card-title mb-4">Você ainda não escolheu uma planta para troca</h5>
                            <a href="escolherPlantaSolicitante.php?id=<?= $solicitacao['solicitacao_id'] ?>" class="btn btn-success rounded-pill">
                              Escolher
                            </a>
                          <?php else : ?>
                            <h5 class="text-center card-title">O proprietário ainda não escolheu uma planta para troca</h5>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>

                    </div>
                    <div class="card-footer text-body-secondary" style="font-size: .9rem;">
                      <?php if ($plantaSolicitante) : ?>
                        <?= $plantaSolicitante['proprietario'] ?> | <?= $plantaSolicitante['cidade'] ?> - <?= $plantaSolicitante['uf'] ?>
                      <?php else : ?>
                        Aguardando escolha...
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

              </div>
              <?php if ($solicitacao['can_edit']) : ?>
                <div class="row">
                  <form action="actions/finalizarTrocaAction.php" method="post" class="col-12 d-flex justify-content-center gap-4">
                    <input type="hidden" name="solicitacao_id" value="<?= $solicitacao['solicitacao_id'] ?>">
                    <input type="hidden" name="agente" value="<?= $solicitacao['proprietario_id'] == $_SESSION['id'] ? 'proprietario' : 'solicitante' ?>">
                    <?php if ($plantaSolicitante && $solicitacao['solicitante_id'] == $_SESSION['id']) : ?>

                      <input type="hidden" name="planta_solicitante_id" value="<?= $plantaSolicitante['id'] ?>">
                      <input type="hidden" name="planta_proprietario_id" value="<?= $plantaProprietario['id'] ?>">

                      <input type="hidden" name="proprietario_id" value="<?= $plantaProprietario['proprietario_id'] ?>">
                      <input type="hidden" name="solicitante_id" value="<?= $plantaSolicitante['proprietario_id'] ?>">

                      <button name="action" value="aceitar" type="submit" class="rounded-pill btn btn-success">Aceitar Solicitação</button>
                    <?php endif; ?>
                    <button name="action" value="recusar" type="submit" class="rounded-pill btn btn-danger">Cancelar Solicitacao</button>
                  </form>
                </div>
              <?php endif; ?>
            </div>

            <!-- mensagens -->
            <div class="tab-pane fade <?= $activeMenu == 'mensagens' ? 'show active' : '' ?>" id="mensagens-tab-pane" role="tabpanel" aria-labelledby="mensagens-tab" tabindex="0">
              <div class="box direct-chat direct-chat-success">
                <!-- /.box-header -->
                <div class="box-body">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">

                    <?php foreach ($mensagens as $mensagem) : ?>

                      <?php if ($mensagem['remetente'] == 'solicitante') : ?>
                        <div class="direct-chat-msg">
                          <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left"><?= $mensagem['usuario'] ?></span> &nbsp;
                            <span class="direct-chat-timestamp pull-right"><?= $mensagem['dt_envio'] ?></span>
                          </div>
                          <img class="direct-chat-img" src="<?= $appUrl . '/assets/images/rosto_' . ($mensagem['usuario_sexo'] == 'M' ? 'homem' : 'mulher') . '.png' ?>">
                          <div class="direct-chat-text-container">
                            <div class="direct-chat-text">
                              <?= $mensagem['mensagem'] ?>
                            </div>
                          </div>
                        </div>
                      <?php else : ?>
                        <div class="direct-chat-msg right">
                          <div class="direct-chat-info clearfix text-end">
                            <span class="direct-chat-name pull-right"><?= $mensagem['usuario'] ?></span> &nbsp;
                            <span class="direct-chat-timestamp pull-left"><?= $mensagem['dt_envio'] ?></span>
                          </div>
                          <img class="direct-chat-img" src="<?= $appUrl . '/assets/images/rosto_' . ($mensagem['usuario_sexo'] == 'M' ? 'homem' : 'mulher') . '.png' ?>">
                          <div class="direct-chat-text-container">
                            <div class="direct-chat-text">
                              <?= $mensagem['mensagem'] ?>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>

                    <?php endforeach ?>
                  </div>
                </div>

                <div class="box-footer">
                  <form action="actions/salvarMensagemAction.php" method="post">
                    <div class="input-group">
                      <input type="hidden" name="solicitacao_id" value="<?= $solicitacao['solicitacao_id'] ?>">

                      <div id="input-group-mensagem" class="input-group mb-4 rounded-pill p-1 input-custom-avocado <?= $_SESSION['error']['mensagem'] ? 'is-invalid' : '' ?>" style="overflow: hidden;">
                        <input type="text" id="mensagem" name="mensagem" placeholder="Digite uma mensagem" class="form-control shadow-none bg-none border-0">
                        <div class="input-group-append border-0">
                          <button type="submit" class="btn btn-link text-success">
                            <i class="fa-regular fa-paper-plane"></i>
                          </button>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- fim mensagens -->

          </div>
        </div>
      </div>
    </div>
  </div>



  <?php include_once('template/system/menu.php') ?>
</main>

<?php include_once('template/base/footer.php') ?>

<script>
  function scrollToBottom() {
    var container = document.querySelector('.direct-chat-messages')
    container.scrollTop = container.scrollHeight;
  }

  document.getElementById('mensagens-tab').addEventListener('click', () => scrollToBottom())

  setTimeout(() => {
    scrollToBottom()
  }, 200);
</script>