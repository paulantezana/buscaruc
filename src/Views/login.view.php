<div class="MainContainer">
    <?php require_once __DIR__ . '/partials/alertMessage.php' ?>
    <form action="" method="post">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="email"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Correo" name="email" aria-label="Correo" aria-describedby="username" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="password"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" placeholder="Contraseña" name="password" aria-label="Contraseña" aria-describedby="password" required>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block" name="commit" value="Acceder">
        </div>
        
        <p style="text-align: center">
            <span>¿No tienes una cuenta? <a href="<?= URL_PATH ?>/page/register"> Registrate ahora</a></span>
            <a href="<?= URL_PATH ?>/page/forgot"> ¿Olvido su contraseña?</a>
        </p>
    </form>
</div>