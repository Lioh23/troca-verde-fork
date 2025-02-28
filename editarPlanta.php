<?php require_once('start.php') ?>

<?php 
  $view = 'Editar Planta';
  $tipos = getTiposPlanta();
  $especies = getEspeciesPlanta();
  $planta = getDadosPlanta($_GET['id']);
?>

<?php include_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
    <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

  <div class="row justify-content-center">
    <div class="col-9">
      <div class="row">
        <div class="col-12">
          <form action="actions/editarPlantaAction.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $planta['id'] ?>">

            <div class="row mb-4 justify-content-center position-relative ">
              <!-- image -->
              <div style="display: none;">
                <input type="file" id="file_image" name="file_image"
                       accept="image/png, image/jpeg, image/jpg, image/webp" />
              </div>

              <div class="col-12 imageWrapper hoverable clickable m-auto" onclick="file_image.click()">
                <?php if($planta['foto']): ?>
                  <img id="img_planta" class="image" src="<?= $appUrl . $planta['foto'] ?>">
                  <i id="svg_planta" class="fa-solid fa-seedling d-none"></i>
                <?php else: ?>
                  <img id="img_planta" class="image d-none" src="">
                  <i id="svg_planta" class="fa-solid fa-seedling"></i>
                <?php endif; ?>
              </div>
            </div>

            <!-- image -->
            <div class="row justify-content-center">

              <div class="col-9 row">

              <div class="col-12 d-flex justify-content-between mb-4 align-items-center">
                <div class="col-6">
                  <input  type="checkbox" class="btn-check" name="status" id="status"
                          <?= $planta['status'] ? 'checked' : '' ?> 
                          value="<?= $planta['status'] ?>" autocomplete="off">
                  <label  class="fw-semibold custom-shape btn btn-outline-success mb-3" 
                          for="status" style="padding: 10px 20px; font-size: 1rem">
                      <i class="fa-solid fa-power-off"></i> 
                      <span id="status_text"><?= $planta['status_text'] ?></span>
                  </label>
                </div>

                <span>Publicado em: <?= $planta['dt_publicacao'] ?></span>
              </div>

                <div class="col-12 mb-5">
                  <div class="form-floating">
                    <select id="tipo_id" name="tipo_id" disabled class="form-select input-custom-avocado">
                      <option value="" hidden disable selected>Selecione</option>
                      <?php foreach($tipos as $tipo): ?>
                        <option <?= isset($planta['tipo_id']) == $tipo['id'] ? 'selected' : ''  ?> 
                            value="<?= $tipo['id'] ?>"><?= $tipo['nome'] ?></option>
                      <?php endforeach ?>
                    </select>
                    <label for="tipo_id">Tipo de Planta</label>
                  </div>
                </div>

                <div class="col-12 mb-5">
                  <div class="form-floating">
                    <select id="especie_id" name="especie_id" disabled
                            class="form-select input-custom-avocado">
                      <option value="" hidden disable selected>Selecione</option>
                      <?php foreach($especies as $especie): ?>
                        <option <?= isset($planta['especie_id']) == $especie['id'] ? 'selected' : ''  ?> 
                                value="<?= $especie['id'] ?>"><?= $especie['nome'] ?></option>
                      <?php endforeach ?>
                    </select>
                    <label for="especie_id">Espécie de Planta</label>
                  </div>
                </div>

                <div class="col-12 mb-5">
                  <div class="form-floating">
                    <textarea id="descricao" name="descricao" style="height: 8rem"
                              class="form-control input-custom-avocado"><?= $planta['descricao'] ?? '' ?></textarea>
                    <label for="descricao">Dê uma descrição para sua planta</label>
                  </div>
                </div>

                <div class="row justify-content-center mb-5">
                  <div class="col-6">
                    <input class="btn-custom-brown custom-shape" type="submit" value="salvar" style="width: 100%; border: none">
                  </div>
                </div>

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

<?php if(isset($_SESSION['nova_planta'])) unset($_SESSION['nova_planta']) ?>

<script>
  file_image.addEventListener('change', function() {
    const image = document.getElementById('img_planta')
    const svg = document.getElementById('svg_planta')

    if (!this.value) {
      image.classList.add('d-none')
      svg.classList.remove('d-none')
      return
    } else {
      image.classList.remove('d-none')
      svg.classList.add('d-none')
    }

    const reader = new FileReader()

    reader.onload = function(e) {
      image.setAttribute('src', e.target.result)
    };

    reader.readAsDataURL(this.files[0])
  })

  document.getElementById('status').addEventListener('change', function() {
    const label = this.nextElementSibling
    const statusText = document.getElementById('status_text')

    if(!this.checked) {
      label.classList.remove('btn-outline-success')
      label.classList.add('btn-danger')
      statusText.innerHTML = 'Indisponível'
    } else {
      label.classList.add('btn-outline-success')
      label.classList.remove('btn-danger')
      statusText.innerHTML = 'Disponível'
    }
  })
</script>