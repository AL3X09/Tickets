<?php
 /*------envio fecha inicio a la tarea -----*/
            
            getIdtarea($idRequirement, $config, $startDevelopmentDate,$idUser,$ipUser,$idStatus);

            /*------fin envio fecha inicio de la tarea-------*/
            
            /*------doy fin a la tarea -----*/
                    getIdtarea($idRequirement, $config, $startDevelopmentDate,$idUser,$ipUser,$idStatus);
                /*------finilizo inicio de la tarea-------*/
/*
*creo una funcion que consume la api de linea de tiempo y envio el id del requerimineto 
*para traer los datos relacionados a una trea especifica
*/
 function getIdtarea($idRequirement, $config,$startDevelopmentDate,$idUser,$ipUser,$idStatus)
            {
                //print_r($config);
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_PORT => "8016",
                CURLOPT_URL => $config["server"] . "/api/LineaTiempo/LineaTiempoConsultarFiltros",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\r\n  \"IdRequerimiento\": $idRequirement,\r\n}",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: 236f03fe-c8e4-f6f9-a7cc-2ad13ef33ab8"
                ),
                ));

                $responseLT = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                echo "cURL Error #:" . $err;
                } else {
                //echo $response;
                $LineTime = array(); //array que va a contener los emails de los usuarios
                $arrayL = json_decode($responseLT, true);
                foreach ($arrayL as $key => $value) {
                        if ($value["IdTarea"]!=null) {
                            $IdTarea = $value["IdTarea"];
                        }
                                                
                    }
                    getDatostarea($IdTarea, $config,$startDevelopmentDate,$idUser,$ipUser,$idStatus);
                }
            }
/*fin funcion getidtarea*/

/*
*creo una funcion que consume la api de tareas y envio el id de la tarea 
*para traer los datos relacionados a una trea especifica
*/
 function getDatostarea($IdTarea,$config,$startDevelopmentDate,$idUser,$ipUser,$idStatus)
            {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_PORT => "8016",
                CURLOPT_URL => $config["server"] . "/api/Tareas/TareasConsultarFiltrosExcel",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\r\n  \"IdTarea\": $IdTarea,\r\n}",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: f853372e-c78d-0ed5-3b2f-952c029204b9"
                ),
                ));

                $responseTR = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                echo "cURL Error funccion getdatostarea #:" . $err;
                } else {
                //echo $response;
                //$DatosTarea = array(); //array que va a contener los emails de los usuarios
                $arrayT = json_decode($responseTR, true);
                //array_push($DatosTarea,$arrayT);
                //print_r($arrayT);
                    if ($idStatus==7) {
                        startTarea($arrayT, $config, $startDevelopmentDate,$idUser,$ipUser);
                    }else if ($idStatus==6) {
                        endTarea($arrayT, $config,$idUser,$ipUser);
                    }
                //return $DatosTarea;
                }
            }
/*fin funcion getDatostarea*/

/*
*creo una funcion con la api de tareas para iniciar la tarea 
*/
 function startTarea($arrayT, $config, $startDevelopmentDate,$idUser,$ipUser)
            {
                //reasigno valores del array obtenido y para enviarlo por el json
                foreach ($arrayT as $key => $value) {
                            $idHomework = $value["IdTarea"];
                            $nameHomework= $value["Nombre"];
                            $idResponsableTarea= $value["IdResponsableTarea"];   
                            $dateStartHomework= $startDevelopmentDate;
                            $FechaFinEstimadoTarea= $value["FechaFinEstimadoTarea"]; 
                    }

               $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_PORT => "8016",
                CURLOPT_URL => $config['server'] . "/api/Tareas/TareasActualizar",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\r\n  \"IdTarea\": $idHomework,\r\n  \"Nombre\": \"$nameHomework\",\r\n  \"IdResponsableTarea\": $idResponsableTarea,\r\n  \"FechaInicioTarea\": \"$dateStartHomework\",\r\n  \"FechaFinEstimadoTarea\": \"$FechaFinEstimadoTarea\",\r\n  \"FechaFinTarea\": null,\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: cbb87fcf-3afe-662c-6044-dab108438ec9"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error startTarea #:" . $err;
            } else {
                //echo $response;
                //echo "Tarea iniciada";
                //$result = (is_numeric($response)) ? "Tarea iniciada" : "Ha ocurrido un error, por favor intente nuevamente. $response";
                //echo json_encode($result);
            }
        }
/*fin funcion startTarea*/

/*
*creo una funcion con la api de tareas para finalizar la tarea 
*/
 function endTarea($arrayT, $config,$idUser,$ipUser)
            {
                $dateEndtHomework = date("Y-m-d");
                //reasigno valores del array obtenido y para enviarlo por el json
                foreach ($arrayT as $key => $value) {
                            $idHomework = $value["IdTarea"];
                            $nameHomework= $value["Nombre"];
                            $idResponsableTarea= $value["IdResponsableTarea"];   
                            $dateStartHomework= $value["FechaInicioTarea"];
                            $FechaFinEstimadoTarea= $value["FechaFinEstimadoTarea"]; 
                    }

               $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_PORT => "8016",
                CURLOPT_URL => $config['server'] . "/api/Tareas/TareasActualizar",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\r\n  \"IdTarea\": $idHomework,\r\n  \"Nombre\": \"$nameHomework\",\r\n  \"IdResponsableTarea\": $idResponsableTarea,\r\n  \"FechaInicioTarea\": \"$dateStartHomework\",\r\n  \"FechaFinEstimadoTarea\": \"$FechaFinEstimadoTarea\",\r\n  \"FechaFinTarea\": \"$dateEndtHomework\",\r\n  \"Usuario\": $idUser,\r\n  \"DirIp\": \"$ipUser\"\r\n}",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: cbb87fcf-3afe-662c-6044-dab108438ec9"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error startTarea #:" . $err;
            } else {
                //echo $response;
                //echo "Tarea iniciada";
                //$result = (is_numeric($response)) ? "Tarea iniciada" : "Ha ocurrido un error, por favor intente nuevamente. $response";
                //echo json_encode($result);
            }
        }
/*fin funcion endTarea*/