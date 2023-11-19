<?php 

function formatTextFavoritos(array $favoritos) {

  $len = count($favoritos);

  if(!$len) {
    return "Ainda não há interesses adicionados.";
  }

  $text = '';

  foreach($favoritos as $index => $favorito) {
    if($index == $len - 1) { // último
      $text .= "{$favorito['nome']}.";
    } else if ($index == $len - 2) { // penúltimo
      $text .= "{$favorito['nome']} e ";
    } else {
      $text .= "{$favorito['nome']}, ";
    }
  }

  return $text;
}