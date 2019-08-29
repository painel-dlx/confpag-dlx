/* global abrirPopupExterno, $ */

/**
 * Abrir popup para atualizar informações do ambiente
 * @param {string} ambiente
 * @param {int} gateway_pagamento_id
 */
function popupConfigAmbiente(ambiente, gateway_pagamento_id) {
    let params = {
        gateway: gateway_pagamento_id,
        'pg-mestra': 'conteudo-master'
    };

    abrirPopupExterno(
        $('#popup-config-ambiente'),
        '/painel-dlx/pagamento/gateways/ambiente/' + ambiente,
        params,
        function () {
            $('#form-config-ambiente').formAjax({
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