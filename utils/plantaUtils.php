<?php

function getTiposPlanta() {
  return fetchAll('SELECT * from tipos ORDER BY nome asc');
}

function getEspeciesPlanta() {
  return fetchAll('SELECT * from especies ORDER BY nome asc');
}
