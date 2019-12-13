/* global abrirPopupExterno, $, msgUsuario */

/**
 * Mostrar
 * @param gateway_pagamento_id
 */
function popupVincularUsuario(gateway_pagamento_id) {
    abrirPopupExterno(
        $('#popup-vincular-usuario'),
        '/painel-dlx/pagamento/gateways/vincular-usuario',
        { gateway: gateway_pagamento_id, 'pg-mestra': 'conteudo-master' },
        function () {
            $('#form-vincular-usuario').formAjax({
                func_depois: function (json, form, xhr) {
                    if (json.retorno === 'sucesso') {
                        msgUsuario.adicionar(json.mensagem, json.retorno, xhr.id);
                        window.location.reload();
                        return;
                    }

                    msgUsuario.mostrar(json.mensagem, json.retorno, xhr.id);
                }
            });
        }
    );
}