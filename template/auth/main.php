<div class="d-flex flex-column align-items-center">
    <img class="logo-image my-3" src="assets/images/logo.png" alt="Logo do site">

    <p class="fs-5">O seu destino online para amantes de plantas e jardineiros entusiastas.</p>

    <div class="login-user">
        <i class="fa-solid fa-circle-user"></i>
    </div>
</div>

<?php if(isset($_SESSION['flashMessage'])): ?> 
    <div class="row justify-content-center">           
        <div class="col-7">
            <div class="alert alert-<?= $_SESSION['flashMessage']['color'] ?> text-center" role="alert">
                <?= $_SESSION['flashMessage']['text'] ?>
            </div>
        </div>
    </div>
<?php endif ?>