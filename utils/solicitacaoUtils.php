<?php 

function getSolicitacoesUsuario() {
  return fetchAll("SELECT -- solicitações feitas
    s.id solicitacao_id,
    concat('Você solicitou ', e.nome, ' de ', proprietario.nome) descricao,
    case
      when s.canceled_at is not null then 'Cancelada'
      when s.propriet_accepted_at is null and s.solic_accepted_at is null and s.canceled_at is null then 'Em andamento'
      when s.propriet_accepted_at is not null and s.solic_accepted_at is null and s.canceled_at is null then 'Aguardando Solicitante'
      when s.propriet_accepted_at is null and s.solic_accepted_at is not null and s.canceled_at is null then 'Aguardando Proprietário'
      else 'Finalizada'
    end status,
    p.foto,
    date_format(s.created_at, '%d/%m/%Y') dt_solicitacao 
  from
    solicitacoes s
    inner join plantas p on p.id = s.planta_id
    inner join usuarios proprietario on proprietario.id = p.usuario_id
    inner join especies e on p.especie_id = e.id
  where
    s.solicitante_id = :id
    
  union

  SELECT -- solicitações recebidas
    s.id solicitacao_id,
    concat(solicitante.nome, ' solicitou ', e.nome) descricao,
    case
      when s.canceled_at is not null then 'Cancelada'
      when s.propriet_accepted_at is null and s.solic_accepted_at is null and s.canceled_at is null then 'Em andamento'
      when s.propriet_accepted_at is not null and s.solic_accepted_at is null and s.canceled_at is null then 'Aguardando Solicitante'
      when s.propriet_accepted_at is null and s.solic_accepted_at is not null and s.canceled_at is null then 'Aguardando Proprietário'
      else 'Finalizada'
    end status,
    p.foto,
    date_format(s.created_at, '%d/%m/%Y') dt_solicitacao
  from
    solicitacoes s
    inner join plantas p on p.id = s.planta_id
    inner join usuarios solicitante on solicitante.id = s.solicitante_id
    inner join especies e on p.especie_id = e.id
  where
    p.usuario_id = :id", ['id' => $_SESSION['id']]);
}

function getSolicitacao($solicitacao_id) {
  return fetch("SELECT
    s.id solicitacao_id,
    s.planta_id proprietario_planta_id,
    s.solicitante_planta_id,
    concat('Solicitação de ', solic.nome, ' por ', e.nome, ' de ', prop.nome) titulo,
    prop.nome proprietario,
    prop.id proprietario_id,
    solic.nome solicitante,
    solic.id solicitante_id,
    date_format(s.created_at, '%d/%m/%Y') dt_publicacao,
    case
      when s.canceled_at is not null then 'Cancelada'
      when s.solicitante_planta_id is not null and s.propriet_accepted_at is not null and solic_accepted_at is null then 'Aguardando aceite do solicitante'
      when s.solicitante_planta_id is null and s.propriet_accepted_at is null then 'Aguardando Aceite do Proprietário'
      else 'Finalizada'
    end status,
    case
      when s.canceled_at is not null then 0
      when s.solicitante_planta_id is not null and s.propriet_accepted_at is not null and solic_accepted_at is null then 1
      when s.solicitante_planta_id is null and s.propriet_accepted_at is null then 1
      else 0
    end can_edit,
    date_format(s.canceled_at, '%d/%m/%Y') dt_cancelamento,
    us_canc.nome cancelado_por,
    scm.nome motivo_cancelamento
  from
    solicitacoes s
    inner join usuarios solic on solic.id = s.solicitante_id
    inner join plantas p on p.id = s.planta_id
    inner join especies e on e.id = p.especie_id
    inner join usuarios prop on prop.id = p.usuario_id
    left join usuarios us_canc on us_canc.id = s.canceled_by 
    left join solicitacao_cancelamento_motivos scm on scm.id = s.cancelamento_motivo_id
  where
    s.id = :solicitacao_id", ['solicitacao_id' => $solicitacao_id]);
}

function getSolicitacaoMensagens($solicitacao_id) {
  return fetchAll("SELECT
    sm.id,
    case 
      when s.solicitante_id = sm.usuario_id then 'solicitante'
      else 'proprietario'
    end remetente,
    sm.mensagem,
    u.nome usuario,
    u.sexo usuario_sexo,
    date_format(sm.created_at, '%d/%m/%Y %H:%i') dt_envio 
  from
    solicitacao_mensagens sm
    inner join solicitacoes s on s.id = sm.solicitacao_id 
    inner join usuarios u on u.id = sm.usuario_id
  where
    sm.solicitacao_id = :solicitacao_id
  ORDER BY
    sm.id", ['solicitacao_id' => $solicitacao_id]);
}