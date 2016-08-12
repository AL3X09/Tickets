<?php

$json = '[
  {
      "Id": 1,
      "Nombre": "años"
  },
  {
      "Id": 2,
      "Nombre": "Meses"
  },
  {
      "Id": 3,
      "Nombre": "dias"
  },
  {
      "Id": 4,
      "Nombre": "horas"
  },
  {
      "Id": 5,
      "Nombre": "minutos"
  },
  {
      "Id": 6,
      "Nombre": "segundos"
  }
  ]';

$result = json_decode ($json);
echo json_encode($result);