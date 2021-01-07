<div class="MainContainer">
    <?php require_once __DIR__ . '/partials/alertMessage.php' ?>
    <form action="" method="post">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" class="form-control" placeholder="Correo electrónico" name="register[email]" aria-label="Correo electrónico" aria-describedby="registerEmail" required>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Usuario" name="register[userName]" aria-label="Usuario" aria-describedby="userName" required>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Nombre completo" name="register[fullName]" aria-label="Nombre completo" aria-describedby="fullName" required>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" placeholder="Contraseña" name="register[password]" aria-label="Contraseña" aria-describedby="password">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" placeholder="Confirmar Contraseña" name="register[passwordConfirm] " aria-label="Confirmar Contraseña" aria-describedby="password" required>
        </div>

        <input type="submit" value="Registrarse" name="commit" class="btn btn-primary btn-block mb-3">
        <a href="<?= URL_PATH ?>/page/login" class="btn btn-block">Login</a>
    </form>
</div>