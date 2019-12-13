drop table if exists confpag.GatewayPagamento;
create table confpag.GatewayPagamento (
    gateway_pagamento_id int not null primary key auto_increment,
    nome varchar(100) not null,
    usuario_id int not null references dlx.Usuario (usuario_id),
    servico varchar(255) not null,
    ativo bool not null default 0,
    deletado bool not null default 0
) engine = innodb;

drop table if exists confpag.GatewayPagamentoConfiguracao;
create table confpag.GatewayPagamentoConfiguracao (
    gateway_pagamento_id int not null references GatewayPagamento(gateway_pagamento_id) on delete cascade,
    ambiente varchar(10) not null,
    usuario varchar(100) not null,
    senha varchar(100) not null,
    primary key(gateway_pagamento_id, ambiente)
) engine = innodb;

insert into confpag.GatewayPagamento (nome, servico) values ('e.Rede', 'Erede\\Application\\Pagamento\\Services\\GatewayErede');

insert into dlx.PermissaoUsuario (alias, descricao) values ('GERENCIAR_GATEWAYS_PAGAMENTO', 'Gerenciar gateways de pagamento');
set @permissao_usuario_id = last_insert_id();

insert into dlx.PermissaoUsuario_x_GrupoUsuario
    select grupo_usuario_id, @permissao_usuario_id from dlx.GrupoUsuario where alias = 'ADMIN';

insert into dlx.Menu (nome) values ('Pagamento');
set @menu_id = last_insert_id();

insert into dlx.MenuItem (menu_id, nome, link) values (@menu_id, 'Gateways', '/painel-dlx/pagamento/gateways');
set @menu_item_id =  15;-- last_insert_id();

insert into dlx.MenuItem_x_PermissaoUsuario values (@menu_item_id, @permissao_usuario_id);
