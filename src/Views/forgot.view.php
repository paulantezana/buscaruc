<div class="MainContainer">
    <?php require_once __DIR__ . '/partials/alertMessage.php' ?>
    <p>Ingresa tu correo electrónico para buscar tu cuenta</p>
    <form action="" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" class="form-control" placeholder="Correo electrónico" name="email" aria-label="Correo electrónico" aria-describedby="registerEmail" required>
        </div>

        <button type="submit" class="btn btn-block btn-primary mb-3" name="commit">Buscar</button>
        <a href="<?= URL_PATH ?>/page/login" class="btn btn-block">Login</a>
    </form>
</div>