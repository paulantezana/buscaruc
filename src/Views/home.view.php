<div class="MainContainer">
    <h1><?= APP_NAME ?></h1>
    <p>Consulta RUC de la SUNAT usando cualquier lenguaje de programación</p>
    <div class="card" id="queryRuc">
        <div class="card-body">
            <div class="form-group">
                <label for="ruc">Prueba ingresando un RUC</label>
                <input type="text" class="form-control" required id="ruc" name="ruc" placeholder="Nombre de usuario">
            </div>
            <input type="hidden" name="googleKey" id="googleKey">
            <p>Consulta RUC se actualiza DIARIAMENTE con la información que optenemos desde el PADRÓN REDUCIDO que publica la SUNAT todos los días.</p>
            <button type="submit" class="btn block btn-primary" disabled id="queryRucSubmitBtn" onclick="queryRucSubmit()" name="commit">Consultar</button>
        </div>
    </div>
    <div id="queryRucResult" class="pt-3 pb-3"></div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=<?= GOOGLE_RE_KEY ?>"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('<?= GOOGLE_RE_KEY ?>', {
            action: 'submit'
        }).then(function(token) {
            document.getElementById('googleKey').value = token;
            document.getElementById('queryRucSubmitBtn').removeAttribute('disabled');
        });
    });
</script>
<script src="<?= URL_PATH ?>/assets/script/home.js"></script>