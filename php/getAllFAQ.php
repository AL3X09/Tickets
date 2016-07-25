<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8016",
  CURLOPT_URL => "http://server:8016/api/FAQ/FAQConsultarTodo",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "postman-token: d9306417-a030-ff86-8f10-7ffce37dd464"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
    echo $response;
}
//////////// TODO ////////////
    /* se desactiva recordar hacer una api que consulte los campo relacionados
    //envio respuesta a un array 
    $array = json_decode($response, true);
    //valido si no un array
    if (!is_array($array)) {
    var_dump($array);
    }
    //si es un array se trabaja  
    else {
    $result = array();      // variable donde se re asigna array
    $row;                   //variable donde con la que se trabaja el array 
    foreach ($array as $key => $value) {
      $idAplicativo = $value["IdAplicativo"];
      $idModulo = $value["IdModulo"];
        //re asigno valores
        $row = array(
            "IdFAQ" => $value["IdFAQ"],
            "IdAplicativo" => $value["IdAplicativo"],
            "IdModulo" => $value["IdModulo"],
            "FechaInicioTarea" => substr($value["FechaInicioTarea"],0,10), // con substr controlo las cadenas a mostar
            "FechaFinEstimadoTarea" => substr($value["FechaFinEstimadoTarea"],0,10),
            "FechaFinTarea" => substr($value["FechaFinTarea"],0,10),
        );
        array_push($result, $row); //agrego valores de row en result 
    }
    echo $idAplicativo;
    echo "<br>";
    echo $idModulo;

       //var_dump($result);
   //echo json_encode($result, true); //envio jason a vista para trabajarlo
  }
}