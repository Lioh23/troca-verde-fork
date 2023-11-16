<?php require_once('start.php') ?>

<?php $view = 'Login' ?>

<?php include('template/base/header.php') ?>

<div class="container">

    <?php include 'template/auth/main.php' ?>

    <form method="POST" action="actions/loginAction.php" class="row justify-content-center">
        <div class="col-7 mb-4">
            <label class="fs-4" for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-12">
                <input type="email" id="email" name="email" value="<?= $_SESSION['login']['email'] ?? '' ?>" class="form-control form-control-lg input-custom-avocado" />
            </div>
        </div>
        <div class="col-7 mb-4">
            <label class="fs-4" for="senha" class="col-sm-2 col-form-label">Senha</label>
            <div class="col-12">
                <input type="password" id="senha" name="senha" class="form-control form-control-lg input-custom-avocado" />
                <a href="cadastrar.php" class="color-avocado">Cadastre-se</a>
            </div>
        </div>

        <div class="col-7 mt-5 text-center">
            <button type="submit" class="btn btn-lg custom-shape btn-custom-brown">Login</button>
        </div>
    </form>
</div>

<?php include('template/base/footer.php') ?>

<?php if(isset($_SESSION['login'])) unset($_SESSION['login']) ?>