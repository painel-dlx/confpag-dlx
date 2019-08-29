drop table dlx_gateway_pagamento;
create table dlx_gateway_pagamento (
    gateway_pagamento_id int not null primary key auto_increment,
    nome varchar(100) not null,
    servico varchar(255) not null,
    ativo bool not null default 0,
    deletado bool not null default 0
) engine=innodb;

drop table dlx_gateway_pagamento_configuracao;
create table dlx_gateway_pagamento_configuracao (
    gateway_pagamento_id int not null references dlx_gateway_pagamento(gateway_pagamento_id) on delete cascade,
    ambiente varchar(10) not null,
    usuario varchar(100) not null,
    senha varchar(100) not null,
    primary key(gateway_pagamento_id, ambiente)
) engine=innodb;

insert into dlx_gateway_pagamento (nome, servico) values ('e.Rede', 'Erede\\Application\\Pagamento\\Services\\GatewayErede')