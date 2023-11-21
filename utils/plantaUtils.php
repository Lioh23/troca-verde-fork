<?php

function getTiposPlanta() {
  return fetchAll('SELECT * from tipos ORDER BY nome asc');
}

function getEspeciesPlanta() {
  return fetchAll('SELECT * from especies ORDER BY nome asc');
}

function getDadosPlanta($id) {
  return fetch("SELECT
    p.id,
    case when donated_at is not null or disabled_at is not null then 0 else 1 end status,
    case
      when donated_at is not null then concat('Doado em ', date_format(p.donated_at, '%d/%m/%Y'))
      when disabled_at is not null then concat('Indisponível desde ', date_format(p.disabled_at, '%d/%m/%Y'))
      else 'Disponível'
	  end status_text,
    p.tipo_id,
    t.nome tipo,
    e.nome especie,
    p.especie_id,
    p.descricao,
    p.foto,
    u.id proprietario_id,
    u.nome proprietario,
    u.sexo proprietario_sexo,
    u.cidade,
    u.uf,
    date_format(p.created_at, '%d/%m/%Y %H:%i:%s') dt_publicacao
  from
    plantas p
    inner join tipos t on t.id = p.tipo_id
    inner join especies e on e.id = p.especie_id
    inner join usuarios u on u.id = p.usuario_id
  where
    p.id = :id", ['id' => $id]);
}

function getPlantasDisponiveis( $reqEspecie = '', $page = 1, $perPage = 2) {
  $offset = ($page - 1) * $perPage;

  $especie = '%' . str_replace(' ', '%', $reqEspecie) . '%';

  $plantas = fetchAll("SELECT
    p.id,
    e.nome especie,
    p.foto,
    concat(u.cidade, ' - ', u.uf) localizacao,
    case when donated_at is not null or disabled_at is not null then 0 else 1 end status,
    (select count(*) from favoritos fav where fav.especie_id = e.id) is_favorite,
    p.created_at dt_publicacao
  from
    plantas p
    inner join especies e on e.id = p.especie_id
    inner join usuarios u on u.id = p.usuario_id
  where
    p.usuario_id <> :usuario_id
    and e.nome like :especie
    and not exists (
      select 1 from solicitacoes sol where sol.planta_id = p.id
    )
  having
    status = 1
  order by
    is_favorite desc, dt_publicacao desc
  limit
    {$perPage}
  offset
    {$offset}", ['usuario_id' => $_SESSION['id'], 'especie' => $especie]);


  $total = fetch("SELECT
    count(*) total
  from
    plantas p
    inner join especies e on e.id = p.especie_id
    inner join usuarios u on u.id = p.usuario_id
  where
    p.usuario_id <> :usuario_id
    and p.donated_at is null
    and p.disabled_at is null
    and e.nome like :especie", ['usuario_id' => $_SESSION['id'], 'especie' => $especie]);

  $total = (int) $total['total'];

  $pages = ceil($total / $perPage);

  global $appUrl;

  return [
    'data'  => $plantas,
    'pages' => $pages,
    'total' => $total,
    'next'  => $page < $pages ? $appUrl . '/listaPlantas.php?page=' . ($page + 1) . '&especie=' . $reqEspecie : '',
    'prev'  => $page > 1      ? $appUrl . '/listaPlantas.php?page=' . ($page - 1) . '&especie=' . $reqEspecie : ''
  ];
}