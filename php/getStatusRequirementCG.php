<?php
$config = parse_ini_file('../config/config.ini');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => $config['server'],
    CURLOPT_URL => $config['server'] . "/api/Estados/EstadosConsultarTodo",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: db232231-ce17-3046-08ba-29ed9b664268"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
//    echo $response;
    $array = json_decode($response, true);
    $result = array();
    $row = array();
    foreach ($array as $key => $value) {
        if ($value['IdEstado']==3 || $value['IdEstado']==1 || $value['IdEstado']==4 ) {
        $row = array(
            "field" => $value["Nombre"],
            "title" => $value["Nombre"],
            
        );
        array_push($result, $row);
    }
    }

    $nombreUsuario= array(              //vector para el head para capturar el monbre del usuario
        'field' => 'nUsuario',
        "title" => 'Nombre',
       
         );
    $epecialidadUsuario= array(         //vector para el head para capturar la especialidad del usuario
        'field' => 'nEspecialidad',
        "title" => 'Especialidad',
       
         );               
   // var_dump($result);
     array_unshift($result,$epecialidadUsuario);    //agrego al inicio array especialidad
     array_unshift($result,$nombreUsuario);         //agrego al inicio array usuario

    echo json_encode(array($result), true);
}