<?php

function getDadosUsuario() {
  return fetch("SELECT id, nome, descricao, email, sexo, logradouro, numero, complemento, bairro, cidade, uf, created_at 
    FROM  usuarios u 
    WHERE u.id = :id", [':id' => $_SESSION['id']]);
}


function getUsuarioPlantas() {
  return fetchall("SELECT 
      p.id,
      case when donated_at is not null or disabled_at is not null then 0 else 1 end status,
      case
        when donated_at is not null then concat('Doado em ', date_format(p.donated_at, '%d/%m/%Y'))
        when disabled_at is not null then concat('Indisponível desde ', date_format(p.disabled_at, '%d/%m/%Y'))
        else 'Disponível'
	  end status_text,
      e.nome especie,
      t.nome tipo,
      p.descricao,
      p.foto  
  from plantas p
      inner join usuarios u on u.id = p.usuario_id
      inner join especies e on e.id = p.especie_id 
      inner join tipos t on t.id = p.tipo_id
  where
      u.id = :id
  order by status desc, id desc", [':id' => $_SESSION['id']]);
}


function getUsuarioFavoritos() {
  return fetchAll("SELECT 
      nome
  FROM favoritos f
      inner join especies e on e.id = f.especie_id
  WHERE
      f.usuario_id = :id
  order by e.nome", [':id' => $_SESSION['id']]);
}


function getCheckFavoritosUsuario() {
  return fetchAll("SELECT 
      e.id, nome especie, if(f.id is not null, 1, 0) checked
  FROM especies e 
      left join favoritos f on f.especie_id = e.id and f.usuario_id = :id
  order by e.nome", [':id' => $_SESSION['id']]);
}