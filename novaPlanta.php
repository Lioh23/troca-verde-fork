<?php require_once('start.php') ?>

<?php $view = 'Editar Perfil' ?>
<?php $tipos = getTiposPlanta() ?>
<?php $especies = getEspeciesPlanta() ?>

<?php include_once('template/base/header.php') ?>

<main class="container">
  <div class="d-flex justify-content-center mb-5">
    <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">
  </div>

  <?php include_once('template/base/flashMessage.php') ?>

  <h1 class="text-center mb-4">Adicione uma planta para troca</h1>

  <div class="row justify-content-center">
    <div class="col-9">
      <div class="row">
        <div class="col-12">
          <form action="actions/novaPlantaAction.php" method="POST" enctype="multipart/form-data">

            <div class="row mb-4 justify-content-center">
              <!-- image -->
              <div style="display: none;">
                <input type="file" id="file_image" name="file_image" accept="image/png, image/jpeg, image/jpg" />
              </div>

              <div class="col-12 imageWrapper m-auto" onclick="file_image.click()">
                <img id="img_planta" class="image d-none" src="">
                <i id="svg_planta" class="fa-solid fa-seedling"></i>
              </div>
            </div>

            <!-- image -->
            <div class="row justify-content-center">

              <div class="col-9 row">

                <div class="col-12 mb-5">
                  <div class="form-floating">
                    <select id="tipo_id" name="tipo_id" 
                            class="form-select input-custom-avocado <?= isset($_SESSION['error']['tipo_id']) ? 'is-invalid' : '' ?>">
                      <option value="" hidden disable selected>Selecione</option>
                      <?php foreach($tipos as $tipo): ?>
                        <option 
                          <?= isset($_SESSION['nova_planta']['tipo_id']) && $_SESSION['nova_planta']['tipo_id'] == $tipo['id'] ? 'selected' : ''  ?> 
                              value="<?= $tipo['id'] ?>"><?= $tipo['nome'] ?></option>
                      <?php endforeach ?>
                    </select>
                    <label for="tipo_id">Tipo de Planta</label>
                    <?= isset($_SESSION['error']['tipo_id']) ? '<div class="invalid-feedback">' . $_SESSION['error']['tipo_id'] . '</div>' : '' ?>
                  </div>
                </div>

                <div class="col-12 mb-5">
                  <div class="form-floating">
                    <select id="especie_id" name="especie_id" 
                            class="form-select input-custom-avocado <?= isset($_SESSION['error']['especie_id']) ? 'is-invalid' : '' ?>">
                      <option value="" hidden disable selected>Selecione</option>
                      <?php foreach($especies as $especie): ?>
                        <option <?= isset($_SESSION['nova_planta']['especie_id']) && $_SESSION['nova_planta']['especie_id'] == $especie['id'] ? 'selected' : ''  ?> 
                                value="<?= $especie['id'] ?>"><?= $especie['nome'] ?></option>
                      <?php endforeach ?>
                    </select>
                    <label for="especie_id">Espécie de Planta</label>
                    <?= isset($_SESSION['error']['especie_id']) ? '<div class="invalid-feedback">' . $_SESSION['error']['especie_id'] . '</div>' : '' ?>
                  </div>
                </div>

                <div class="col-12 mb-5">
                  <div class="form-floating">
                    <textarea id="descricao" name="descricao" style="height: 8rem"
                              class="form-control input-custom-avocado"><?= $_SESSION['nova_planta']['descricao'] ?? '' ?></textarea>
                    <label for="descricao">Dê uma descrição para sua planta</label>
                  </div>
                </div>

                <div class="row justify-content-center mb-5">
                  <div class="col-6">
                    <input class="btn-custom-brown custom-shape" type="submit" value="salvar" style="width: 100%;">
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
      image.setAttribute('src', e.target.result);
    };

    reader.readAsDataURL(this.files[0]);
  })
</script>