<?php require_once('start.php') ?>

<?php $view = 'Cadastrar' ?>

<?php require_once('template/header.php') ?>

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

    <form class="row justify-content-center" method="POST" action="actions/cadastrarAction.php">
        <div class="row col-7 mb-4">
            <label class="fs-4" for="nome" class="col-sm-2 col-form-label">Nome</label>
            <div class="col-12">
                <input  type="text" id="nome" name="nome"
                        value="<?= $_SESSION['cadastrar']['nome'] ?? '' ?>"
                        class="form-control form-control-lg input-login-custom <?= isset($_SESSION['error']['nome']) ? 'is-invalid' : '' ?>" />
                <?= isset($_SESSION['error']['nome']) ? '<div class="invalid-feedback">' . $_SESSION['error']['nome'] . '</div>' : '' ?>
            </div>
        </div>

        <div class="col-7 row mb-4">
            <div class="col-9">
                <label class="fs-4" class="col-sm-2 col-form-label">Cidade</label>
                <input  type="text" id="cidade" name="cidade"
                        value="<?= $_SESSION['cadastrar']['cidade'] ?? '' ?>"
                        class="form-control form-control-lg input-login-custom <?= isset($_SESSION['error']['cidade']) ? 'is-invalid' : '' ?>" />
                <?= isset($_SESSION['error']['cidade']) ? '<div class="invalid-feedback">' . $_SESSION['error']['cidade'] . '</div>' : '' ?>
            </div>
            <div class="col-3">
                <label class="fs-4" class="col-sm-2 col-form-label">UF</label>
                <input  type="text" id="estado"  name="estado"
                        value="<?= $_SESSION['cadastrar']['estado'] ?? '' ?>"
                        class="form-control form-control-lg input-login-custom <?= isset($_SESSION['error']['estado']) ? 'is-invalid' : '' ?>" />
            </div>
        </div>

        <div class="row col-7 mb-4">
            <label class="fs-4" for="email" class="col-sm-2 col-form-label">E-Mail</label>
            <div class="col-12">
                <input  type="email" id="email" name="email"
                        value="<?= $_SESSION['cadastrar']['email'] ?? '' ?>"
                        class="form-control form-control-lg input-login-custom <?= isset($_SESSION['error']['email']) ? 'is-invalid' : '' ?>" />
                <?= isset($_SESSION['error']['email']) ? '<div class="invalid-feedback">' . $_SESSION['error']['email'] . '</div>' : '' ?>
            </div>
        </div>

        <div class="row col-7 mb-4">
            <label class="fs-4" for="senha" class="col-sm-2 col-form-label">Senha</label>
            <div class="col-12">
                <input  type="password" id="senha" name="senha" 
                        class="form-control form-control-lg input-login-custom <?= isset($_SESSION['error']['senha']) ? 'is-invalid' : '' ?>" />
                <?= isset($_SESSION['error']['senha']) ? '<div class="invalid-feedback">' . $_SESSION['error']['senha'] . '</div>' : '' ?>
            </div>
        </div>

        <div class="row col-7 mb-4">
            <label class="fs-4" for="confirmacao_senha" class="col-sm-2 col-form-label">Repita a senha</label>
            <div class="col-12">
                <input  type="password" id="confirmacao_senha" name="confirmacao_senha" 
                        class="form-control form-control-lg input-login-custom <?= isset($_SESSION['error']['confirmacao_senha']) ? 'is-invalid' : '' ?>" />
                <?= isset($_SESSION['error']['confirmacao_senha']) ? '<div class="invalid-feedback">' . $_SESSION['error']['confirmacao_senha'] . '</div>' : '' ?>
            </div>
        </div>


        <div class="col-7 mt-5 text-center">
            <button type="submit" class="btn btn-lg custom-shape btn-custom-login me-5">Cadastrar</button>
            <a href="login.php" class="btn btn-lg custom-shape btn-danger">Voltar</a>
        </div>
    </form>
</div>

<?php include('template/footer.php') ?>

<?php if(isset($_SESSION['cadastrar'])) unset($_SESSION['cadastrar']) ?>