<?php require_once('start.php') ?>

<?php $view = 'Cadastrar' ?>

<?php require_once('template/base/header.php') ?>

<div class="container">

    <?php include 'template/auth/main.php' ?>

    <form class="row justify-content-center" method="POST" action="actions/cadastrarAction.php">
        <div class="row col-9 mb-4">
            <div class="col-9">
                <label class="fs-4" for="nome" class="col-sm-2 col-form-label">Nome</label>
                <div class="col-12">
                    <input  type="text" id="nome" name="nome"
                            value="<?= $_SESSION['cadastrar']['nome'] ?? '' ?>"
                            class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['nome']) ? 'is-invalid' : '' ?>" />
                    <?= isset($_SESSION['error']['nome']) ? '<div class="invalid-feedback">' . $_SESSION['error']['nome'] . '</div>' : '' ?>
                </div>
            </div>

            <div class="col-3">
                 <label class="fs-4" for="nome" class="col-2 col-form-label">Sexo</label>
                <div class="col-12">
                    <select id="sexo" name="sexo"
                            class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['sexo']) ? 'is-invalid' : '' ?>">
                        <option value="" disabled hidden <?= isset($_SESSION['cadastrar']['sexo']) ? '' : 'selected' ?>>Selecione</option>
                        <option value="M" <?= isset($_SESSION['cadastrar']['sexo']) && $_SESSION['cadastrar']['sexo'] == "M" ? 'selected' : ''?>>Masculino</option>
                        <option value="F" <?= isset($_SESSION['cadastrar']['sexo']) && $_SESSION['cadastrar']['sexo'] == "F" ? 'selected' : ''?>>Feminino</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row col-9 mb-4">
            <div class="col-10">
                <label class="fs-4" for="logradouro" class="col-sm-2 col-form-label">Logradouro</label>
                <div class="col-12">
                    <input  type="text" id="logradouro" name="logradouro"
                            value="<?= $_SESSION['cadastrar']['logradouro'] ?? '' ?>"
                            class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['logradouro']) ? 'is-invalid' : '' ?>" />
                    <?= isset($_SESSION['error']['logradouro']) ? '<div class="invalid-feedback">' . $_SESSION['error']['logradouro'] . '</div>' : '' ?>
                </div>
            </div>

            <div class="col-2">
                <label class="fs-4" for="numero" class="col-sm-2 col-form-label">Número</label>
                <div class="col-12">
                    <input  type="text" id="numero" name="numero"
                            value="<?= $_SESSION['cadastrar']['numero'] ?? '' ?>"
                            class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['numero']) ? 'is-invalid' : '' ?>" />
                    <?= isset($_SESSION['error']['numero']) ? '<div class="invalid-feedback">' . $_SESSION['error']['numero'] . '</div>' : '' ?>
                </div>
            </div>
        </div>

        <div class="row col-9 mb-4">
            <div class="col-6">
                <label class="fs-4" for="complemento" class="col-sm-2 col-form-label">Complemento</label>
                <div class="col-12">
                    <input  type="text" id="complemento" name="complemento"
                            value="<?= $_SESSION['cadastrar']['complemento'] ?? '' ?>"
                            class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['complemento']) ? 'is-invalid' : '' ?>" />
                    <?= isset($_SESSION['error']['complemento']) ? '<div class="invalid-feedback">' . $_SESSION['error']['complemento'] . '</div>' : '' ?>
                </div>
            </div>

            <div class="col-6">
                <label class="fs-4" for="bairro" class="col-sm-2 col-form-label">Bairro</label>
                <div class="col-12">
                    <input  type="text" id="bairro" name="bairro"
                            value="<?= $_SESSION['cadastrar']['bairro'] ?? '' ?>"
                            class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['bairro']) ? 'is-invalid' : '' ?>" />
                    <?= isset($_SESSION['error']['bairro']) ? '<div class="invalid-feedback">' . $_SESSION['error']['bairro'] . '</div>' : '' ?>
                </div>
            </div>
        </div>

        <div class="col-9 row mb-4">
            <div class="col-9">
                <label class="fs-4" class="col-2 col-form-label">Cidade</label>
                <input  type="text" id="cidade" name="cidade"
                        value="<?= $_SESSION['cadastrar']['cidade'] ?? '' ?>"
                        class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['cidade']) ? 'is-invalid' : '' ?>" />
                <?= isset($_SESSION['error']['cidade']) ? '<div class="invalid-feedback">' . $_SESSION['error']['cidade'] . '</div>' : '' ?>
            </div>
            <div class="col-3">
                <label class="fs-4" class="col-2 col-form-label">UF</label>
                <input  type="text" id="uf"  name="uf"
                        value="<?= $_SESSION['cadastrar']['uf'] ?? '' ?>"
                        maxlength="2"
                        class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['uf']) ? 'is-invalid' : '' ?>" />
            </div>
        </div>

        <div class="row col-9 mb-4">
            <label class="fs-4" for="email" class="col-sm-2 col-form-label">E-Mail</label>
            <div class="col-12">
                <input  type="email" id="email" name="email"
                        value="<?= $_SESSION['cadastrar']['email'] ?? '' ?>"
                        class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['email']) ? 'is-invalid' : '' ?>" />
                <?= isset($_SESSION['error']['email']) ? '<div class="invalid-feedback">' . $_SESSION['error']['email'] . '</div>' : '' ?>
            </div>
        </div>

        <div class="row col-9 mb-4">
            <div class="col-6 mb-4">
                <label class="fs-4" for="senha" class="col-sm-2 col-form-label">Senha</label>
                <div class="col-12">
                    <input  type="password" id="senha" name="senha" 
                            class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['senha']) ? 'is-invalid' : '' ?>" />
                    <?= isset($_SESSION['error']['senha']) ? '<div class="invalid-feedback">' . $_SESSION['error']['senha'] . '</div>' : '' ?>
                </div>
            </div>

            <div class="col-6 mb-4">
                <label class="fs-4" for="confirmacao_senha" class="col-sm-2 col-form-label">Confirme a senha</label>
                <div class="col-12">
                    <input  type="password" id="confirmacao_senha" name="confirmacao_senha" 
                            class="form-control form-control-lg input-custom-avocado <?= isset($_SESSION['error']['confirmacao_senha']) ? 'is-invalid' : '' ?>" />
                    <?= isset($_SESSION['error']['confirmacao_senha']) ? '<div class="invalid-feedback">' . $_SESSION['error']['confirmacao_senha'] . '</div>' : '' ?>
                </div>
            </div>
        </div>

        <div class="col-9 mt-5 text-center">
            <button type="submit" class="btn btn custom-shape btn-custom-brown me-5">Cadastrar</button>
            <a href="login.php" class="btn btn custom-shape btn-danger">Voltar</a>
        </div>
    </form>
</div>

<?php include('template/base/footer.php') ?>

<?php if(isset($_SESSION['cadastrar'])) unset($_SESSION['cadastrar']) ?>