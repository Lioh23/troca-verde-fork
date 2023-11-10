<?php require_once('start.php') ?>
<?php $view = 'Login' ?>
<?php $requireLogin = false ?>
<?php include('template/header.php') ?>

<div class="container">
    <div class="d-flex flex-column align-items-center">
        <img class="logo-image mb-3" src="assets/images/logo.png" alt="Logo do site">
    
        <p class="fs-4">O seu destino online para amantes de plantas e jardineiros entusiastas.</p>
    
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

    <form method="POST" action="actions/loginAction.php" class="row justify-content-center">
        <div class="col-7 mb-4">
            <label class="fs-4" for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-12">
                <input type="email" id="email" name="email" value="<?= $_SESSION['login']['email'] ?? '' ?>" class="form-control form-control-lg input-login-custom" />
            </div>
        </div>
        <div class="col-7 mb-4">
            <label class="fs-4" for="senha" class="col-sm-2 col-form-label">Senha</label>
            <div class="col-12">
                <input type="password" id="senha" name="senha" class="form-control form-control-lg input-login-custom" />
                <a href="cadastrar.php" class="color-avocado">Cadastre-se</a>
            </div>
        </div>

        <div class="col-7 mt-5 text-center">
            <button type="submit" class="btn btn-lg custom-shape btn-custom-login">Login</button>
        </div>
    </form>
</div>

<?php include('template/footer.php') ?>

<?php if(isset($_SESSION['login'])) unset($_SESSION['login']) ?>