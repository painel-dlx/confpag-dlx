/* global $, msgUsuario */

/**
 * Abrir um popup modal
 * @param $container
 * @param url
 * @param dados
 * @param callback
 */
function abrirPopupExterno($container, url, dados, callback) {
    $.get(
        url,
        dados,
        function (html, status, xhr) {
            $container.html(html).show();

            if (xhr.id && msgUsuario) {
                msgUsuario.fechar(xhr.id);
            }

            $(window).on('keyup.__poupModal', function (evt) {
                let kc = evt.keycode || evt.which;

                if (kc === 27) {
                    fecharPopupExterno($container);
                }
            });

            if (typeof callback === 'function') {
                callback.apply();
            }
        },
        'html'
    );
}