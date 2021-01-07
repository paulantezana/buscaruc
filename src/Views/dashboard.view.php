<div class="MainContainer">
    <div class="SnGrid col-gap row-gap m-grid-4">
        <div class="m-col-3">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="card-title">Descarga y preparación</div>
                    <ol>
                        <li class="mb-5">
                            <div class="mb-2">Descargar el padrón reducido desde la SUNAT.  El archivo suele pesar como 400MB aproximadamente.</div>
                            <div class="SnGrid col-gap row-gap m-grid-2 l-grid-3 mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="enabledAgent">
                                    <label class="custom-control-label" for="enabledAgent">CURLOPT_USERAGENT</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="enabledVerifyHost">
                                    <label class="custom-control-label" for="enabledVerifyHost">CURLOPT_SSL_VERIFYHOST</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="enabledVerfyPer" checked>
                                    <label class="custom-control-label" for="enabledVerfyPer">CURLOPT_SSL_VERIFYPEER</label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary jsAensusAction" onclick="censusDowloand(this)"><i class="fas fa-download mr-2"></i>Iniciar descarga</button>
                        </li>
                        <li class="mb-5">
                            <div class="SnMb-2">Una ves que la descarga haya finalizado descomprima el archivo zip.</div>
                            <button type="button" class="btn btn-primary jsAensusAction" onclick="censusUnZip(this)"><i class="far fa-file-archive mr-2"></i>Descomprimir</button>
                        </li>
                        <li class="mb-5">
                            <div class="mb-2">Para aligerar el procesamiento de inserción a la base de datos divida el archivo en múltiples partes.</div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="enabledIsSql">
                                <label class="custom-control-label" for="enabledIsSql">Crear sql</label>
                            </div>
                            <button type="button" class="btn btn-primary jsAensusAction" onclick="censusPrepare(this)"><i class="fas fa-columns mr-2"></i>Dividir archivo</button>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body" id="censusFilesWrapperContainer">
                    <div class="mb-3">
                        <div class="mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="enabledFirstTime" checked>
                                <label class="custom-control-label" for="enabledFirstTime">Por RUC</label>
                            </div>
                        </div>
                        <div class="btn btn-success" onclick="censusSetAllData()">Guardar Todo</div>
                        <div class="btn btn-primary" onclick="censusClear()">Limpiar archivos</div>
                        <div class="btn btn-primary" onclick="censusTruncate()">Limpiar DB</div>
                    </div>
                    <div id="censusFilesWrapper"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body" id="censusHistoryWrapperContainer">
                <div id="scandirWrapper"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="btn btn-light" onclick="censusSetDataByFile()">Procesar</div>
            </div>
        </div>
    </div>
</div>

<script src="<?= URL_PATH ?>/assets/script/dashboard.js"></script>