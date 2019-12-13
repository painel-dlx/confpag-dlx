start transaction;
alter table confpag.gateway_pagamento rename to confpag.GatewayPagamento;
alter table confpag.gateway_pagamento_configuracao rename to confpag.GatewayPagamentoConfiguracao;
rollback;
-- commit;