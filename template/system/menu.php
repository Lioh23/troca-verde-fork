<nav class="navbar fixed-bottom navbar-light bg-body-secondary justify-content-center p-2 mt-5">
  <div class="row w-100 justify-content-center">
    <div class="col-10 d-flex justify-content-evenly" style="font-size: 2rem">
      <a class="text-black"  href="<?= $appUrl . '/listaPlantas.php' ?>"><i class="fa-solid fa-seedling"></i></a>
      <a class="text-black"  href="<?= $appUrl . '/solicitacoes.php' ?>"><i class="fa-regular fa-bell"></i></a>
      <a class="text-black"  href="<?= $appUrl . '/myProfile.php' ?>"><i class="fa-regular fa-user"></i></a>
      <a class="text-danger" href="<?= $appUrl . '/actions/logoutAction.php' ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
    </div>
  </div>
</nav>