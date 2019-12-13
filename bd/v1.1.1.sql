-- Vincular ao gateway de pagamento a um usuário
alter table confpag.GatewayPagamento add usuario_id int not null references dlx.Usuario (usuario_id) after nome;