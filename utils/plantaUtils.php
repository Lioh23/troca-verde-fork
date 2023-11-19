<?php

function getTiposPlanta() {
  return fetchAll('SELECT * from tipos ORDER BY nome asc');
}

function getEspeciesPlanta() {
  return fetchAll('SELECT * from especies ORDER BY nome asc');
}

function getDadosPlanta($id) {
  return fetch("SELECT
    case
      when donated_at is not null then concat('Doado em ', date_format(donated_at, '%d/%m/%Y'))
      when disabled_at is not null then 'Indisponível'
      else 'Disponível'
    end status,
    p.tipo_id,
    t.nome tipo,
    e.nome especie,
    p.especie_id,
    p.descricao,
    p.foto,
    date_format(created_at, '%d/%m/%Y %H:%i:%s') dt_publicacao
  from
    plantas p
    inner join tipos t on t.id = p.tipo_id
    inner join especies e on e.id = p.especie_id
  where
    p.id = :id", ['id' => $id]);
}