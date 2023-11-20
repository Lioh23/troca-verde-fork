#flow Página de edição de planta @editarPlanta {cm:2023-11-19} {c}
  Visualização {cm:2023-11-18}
    Deve ser possível visualizar o "status da planta" {cm:2023-11-18}
    Deve ser possível visualizar a imagem da planta {cm:2023-11-18}
    Deve ser possível visualizar o tipo da planta {cm:2023-11-18}
    Deve ser possível visualizar a espécie da planta {cm:2023-11-18}
    Deve ser possível visualizar a descrição da planta {cm:2023-11-18}
    Deve ser possível visualizar a data de publicação da planta {cm:2023-11-18}
  Edição {cm:2023-11-19}
    Deve ser possível editar a imagem da planta {cm:2023-11-19}
    Deve ser possível editar o status da planta {cm:2023-11-19}
    Deve ser possível editar a descrição da planta {cm:2023-11-19}
  Regras {cm:2023-11-19}
    Não deve ser possível editar o tipo de planta {cm:2023-11-19}
    Não deve ser possível editar a espécie da planta {cm:2023-11-19}
    Não deve ser possível editar o status da planta quando este for "Indisponível ou "Doado" {cm:2023-11-19}
    Quando a planta estiver "indisponível" a página a ser aberta deverá ser a de "visualização" {cm:2023-11-19}

#flow Página de visualização de planta
  visualização #doing
    Deve ser possível visualizar o proprietário da planta {cm:2023-11-20}
    Deve ser possível visualizar o status da planta {cm:2023-11-20}
    Deve ser possível visualizar a imagem da planta {cm:2023-11-20}
    Deve ser possível visualizar o tipo da planta {cm:2023-11-20}
    Deve ser possível visualizar a espécie da planta {cm:2023-11-20}
    Deve ser possível visualizar a descrição dada à planta {cm:2023-11-20}
  Ações
    Deve ser possível abrir uma solicitação para a planta
  Regras
    Não deve ser possível abrir uma solicitação para a planta quando a planta estiver indisponível ou doada {cm:2023-11-20}
    Não deve ser possível abrir uma solicitação para a planta quando a planta já pertencer ao usuário {cm:2023-11-20}