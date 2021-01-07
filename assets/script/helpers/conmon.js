const APP = {
    path: "",
};

const codeMessage = {
    200: "El servidor devolvió con éxito los datos solicitados. ",
    201: "Datos nuevos o modificados son exitosos. ",
    202: "Una solicitud ha ingresado a la cola de fondo (tarea asíncrona). ",
    204: "Eliminar datos con éxito. ",
    400: "La solicitud se envió con un error. El servidor no realizó ninguna operación para crear o modificar datos. ",
    401: "El usuario no tiene permiso (token, nombre de usuario, contraseña es incorrecta). ",
    403: "El usuario está autorizado, pero el acceso está prohibido. ",
    404: "La solicitud se realizó a un registro que no existe y el servidor no funcionó. ",
    406: "El formato de la solicitud no está disponible. ",
    410: "El recurso solicitado se elimina permanentemente y no se obtendrá de nuevo. ",
    422: "Al crear un objeto, se produjo un error de validación. ",
    500: "El servidor tiene un error, por favor revise el servidor. ",
    502: "Error de puerta de enlace. ",
    503: "El servicio no está disponible, el servidor está temporalmente sobrecargado o mantenido. ",
    504: "La puerta de enlace agotó el tiempo. ",
};

class RequestApi {
    static setHeaders(options) {
        if (!(options.body instanceof FormData)) {
            options.headers = {
                Accept: "application/json",
                "Content-Type": "application/json; charset=utf-8",
                ...options.headers,
            };
            options.body = JSON.stringify(options.body);
        } else {
            options.headers = {
                Accept: "application/json",
                ...options.headers,
            };
        }
        return options;
    }

    static checkStatus(response) {
        if (response.status >= 200 && response.status < 300) {
            return response;
        }
        const errortext = codeMessage[response.status] || response.statusText;
        SnMessage.error({
            content: `Error de solicitud ${response.status}: ${response.url} ${errortext}`,
        });
        let error = new Error(errortext);
        error.name = response.status;
        error.response = response;
        throw error;
    }

    static fetch(path, options = {}) {
        NProgress.start();
        const newOptions = RequestApi.setHeaders(options);

        return fetch(APP.path + path, newOptions)
            .then(RequestApi.checkStatus)
            .then((response) => {
              return response.json();
            })
            .catch(e => {
                console.warn(e,'FETCH_ERROR');
                return e;
            })
            .finally(e => {
                NProgress.done();
            });
    }
}

const GenerateUniqueId = (length = 6) => {
    let timestamp = + new Date;

    let _getRandomInt = function (min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };

    let ts = timestamp.toString();
    let parts = ts.split("").reverse();
    let id = "";
    for (let i = 0; i < length; ++i) {
        let index = _getRandomInt(0, parts.length - 1);
        id += parts[index];
    }
    return id;
};

(() => {
    let SnFreezeGScope = document.createElement('div');
    SnFreezeGScope.classList.add('SnFreeze-wrapper');

    let SnFreeze = {
        unFreeze(selector){
            let parentSelector = document.querySelector(selector) || document;
            let element = parentSelector.querySelector('.SnFreeze-wrapper');
            if (element) {
                element.classList.add('is-unfreezing');
                setTimeout(() => {
                    if (element) {
                        element.classList.remove('is-unfreezing');
                        if(element.parentElement != null || element.parentElement != undefined){
                            element.parentElement.removeChild(element);
                        }
                    }
                }, 250);
            }
        },
        freeze(options = {}){
            let parent = document.querySelector(options.selector) || document.body;
            SnFreezeGScope.setAttribute('data-text', options.text || 'Cargando...');
            if (document.querySelector(options.selector)) {
                SnFreezeGScope.style.position = 'absolute';
                parent.style.position = 'relative';
            }
            parent.appendChild(SnFreezeGScope);
        }
    };

    window.SnFreeze = SnFreeze;
})();

$(document).ready(function() {
    $(document).on('show.bs.modal', '.modal', function () {
        let zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    if(toastr){
        toastr.options = {
            "closeButton": true,
        };
    }
});


Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});


function showModalConfirm({
    title = 'Confirmación',
    content = '¿Esta seguro que desea continuar?',
    prontTitle = '',
    okType = 'primary',
    cancelType = '',
    cancelText = 'Cancelar',
    okText = 'Continuar',
    onOk = () => { },
    onCancel = () => { }
}){
    let prontHtml = '';

    if(prontTitle != ''){
        prontHtml = `
            <div class="form-group">
                <label for="confirmModalProntTitle">${prontTitle} : </label>
                <input type="text" class="form-control" id="confirmModalProntTitle" required>
            </div>`;
    }

    // switch (type) {
    //     case 'info':
    //         break;
    //     case 'success':
    //         break;
    //     case 'error':
    //         break;
    //     case 'warning':
    //         break;
    //     default:
    //         break;
    // }

    let modalConfirm = `
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">${title}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <div><i class="fas fa-question-circle mr-4 text-warning" style="font-size: 42px"></i></div>
                    <div class="flex-fill">
                        ${content}
                        ${prontHtml}
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="button" class="btn btn-${cancelType}" data-dismiss="modal">${cancelText}</button>
                    <button type="button" class="btn btn-${okType}" id="modalConfirmOnOk">${okText}</button>
                </div>
            </div>
        </div>
    </div>`;

    $(document).find("body").append(modalConfirm);
    $('#confirmModal').modal('show');

    $('#modalConfirmOnOk').on('click',function(){
        let confirmModalProntValue = '';
        if(prontTitle != ''){
            confirmModalProntValue = $('#confirmModalProntTitle').val();
        }
        $('#confirmModal').modal('hide');
        $('#confirmModal').remove();
        onOk(confirmModalProntValue);
    });

    $('#confirmModal').on('hidden.bs.modal', function (e) {
        $('#confirmModal').remove();
        onCancel();
    });

    $('#confirmModal').on('hide.bs.modal', function (e) {
        $('#confirmModal').remove();
        onCancel();
    });
}

const TableToExcel = (
    tableHtml,
    sheetName = "Sheet 1",
    fileName = "report"
) => {
    const template =
        '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>';
    const base64 = function (s) {
        return window.btoa(unescape(encodeURIComponent(s)));
    };
    const format = function (s, c) {
        return s.replace(/{(\w+)}/g, function (m, p) {
            return c[p];
        });
    };
    const s2ab = (s) => {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xff;
        return buf;
    };

    const ctx = { worksheet: sheetName, table: tableHtml };

    const blob = new Blob([s2ab(atob(base64(format(template, ctx))))], {
        type: "",
    });

    let link = document.createElement("a"); //console.log(nombreArchivo);
    link.download = fileName + ".xls";

    link.href = URL.createObjectURL(blob);
    link.click();
};