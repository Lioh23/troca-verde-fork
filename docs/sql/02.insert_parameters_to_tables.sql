-- populando a tabela de espécies de plantas
insert into especies (nome) values ('Samambaia');
insert into especies (nome) values ('Cacto');
insert into especies (nome) values ('Suculenta');
insert into especies (nome) values ('Orquídea');
insert into especies (nome) values ('Violeta');
insert into especies (nome) values ('Espada de São Jorge');
insert into especies (nome) values ('Girassol');
insert into especies (nome) values ('Crisântemo');
insert into especies (nome) values ('Rosa');
insert into especies (nome) values ('Margarida');
insert into especies (nome) values ('Azaléia');
insert into especies (nome) values ('Jasmim');
insert into especies (nome) values ('Palmeira');
insert into especies (nome) values ('Árvore da Felicidade');
insert into especies (nome) values ('Begônia');
insert into especies (nome) values ('Pata de Elefante');
insert into especies (nome) values ('Salgueiro');
insert into especies (nome) values ('Mangueira');


-- populando a tabela de tipos de plantas
insert into tipos (nome) values ('Planta de Terra');
insert into tipos (nome) values ('Planta para vaso');


-- populando motivos de cancelamento
insert into solicitacao_cancelamento_motivos (nome) values ('Cancelado pelo solicitante');
insert into solicitacao_cancelamento_motivos (nome) values ('Cancelado pelo dono da planta');
insert into solicitacao_cancelamento_motivos (nome) values ('Uma planta desta solicitação está indisponível por troca com outro usuário');
