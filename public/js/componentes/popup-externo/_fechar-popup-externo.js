/* global $ */

/**
 * Fechar um poup modal
 * @param $container
 */
function fecharPopupExterno($container) {
    $container.fadeOut('fast', function () {
        $container.html('');
        $(window).off('.__poupModal');
    });
}