<?php
require './functions.php';
session_start();
ini_set("display_errors", "on");
$classFunction = new functions(); // Clase funciones
$idRequirement = $_REQUEST["IdRequerimiento"];
$responseDecoded;

$config = parse_ini_file('config.ini');
$page = (isset($_POST['page'])) ? intval($_POST['page']) : 0;
$rows = (isset($_POST['rows'])) ? intval($_POST['rows']) : 50;
$idRequirement = (isset($_REQUEST['IdRequerimiento']) && !is_null($_REQUEST['IdRequerimiento']) && !empty($_REQUEST['IdRequerimiento'])) ? $_REQUEST['IdRequerimiento'] : "null";
$idCompany = (isset($_REQUEST['IdEmpresa']) && !is_null($_REQUEST['IdEmpresa']) && !empty($_REQUEST['IdEmpresa'])) ? $_REQUEST['IdEmpresa'] : "null";
$idRadicatorUser = (isset($_REQUEST['IdUsuarioRadica']) && !is_null($_REQUEST['IdUsuarioRadica'])) ? $_REQUEST['IdUsuarioRadica'] : "null";
$idTypeRequirement = (isset($_REQUEST['IdTipoRequerimiento']) && !is_null($_REQUEST['IdTipoRequerimiento'])) ? $_REQUEST['IdTipoRequerimiento'] : "null";
$idApp = (isset($_REQUEST['IdAplicativo']) && !is_null($_REQUEST['IdAplicativo'])) ? $_REQUEST['IdAplicativo'] : "null";
$idModule = (isset($_REQUEST['IdModulo']) && !is_null($_REQUEST['IdModulo'])) ? $_REQUEST['IdModulo'] : "null";
$idPriority = (isset($_REQUEST['IdPrioridad']) && !is_null($_REQUEST['IdPrioridad'])) ? $_REQUEST['IdPrioridad'] : "null";
$idResponsable = (isset($_REQUEST['IdUsuarioResponsable']) && !is_null($_REQUEST['IdResponsable'])) ? $_REQUEST['IdResponsable'] : "null";

$offset;

if ($page == 1 || $page == 0) {
    $offset = 0;
} else {
    $offset = ($rows * $page) - $rows;
}
//ini_set("display_errors", "on");
$values = "{\r\n  \"offset\": " . intval($offset) . ","
        . "\r\n  \"rows\": " . intval($rows) . ","
        . "\r\n  \"IdRequerimiento\": $idRequirement,"
        . "\r\n  \"IdEmpresaRadica\": $idCompany,"
        . "\r\n  \"IdUsuarioRadica\": $idRadicatorUser,"
        . "\r\n  \"IdTipoRequerimiento\": $idTypeRequirement,"
        . "\r\n  \"IdAplicativo\": $idApp,"
        . "\r\n  \"IdModulo\":  $idModule,"
        . "\r\n  \"IdPrioridad\": $idPriority,"
        . "\r\n  \"IdResponsable\":$idResponsable\r\n}";




$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $config['server'] . "/api/SPRequerimientos/SPRequerimientosConsultar",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $values,
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: cde243ef-e4f4-dd9d-8a16-8ac7c9b39106"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $responseDecoded = json_decode($response, true);
}

//if (isset($_SESSION["id"])) {
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

    </head>
    <body>
        <div style="padding: 25px 25px 25px 25px; width: 100%; ">
            <h2 style="align-content: center">Orden de compra<img style="margin-left: 280px" src="../img/sies-logo.png"/></h2>
            <table style="width: 100%">
                <tr></tr>
                <tr style="border: 1px;">
                    <td style="width: 50%;"><label>Radicacion No.<?php
//                            echo $response;
//                            var_dump($responseDecoded);
                            echo $responseDecoded[0]["Ticket"]
                            ?></label></td>
                    <td style="width: 50%; text-align: right;"><label>Fecha:</label><?php
                        echo date_format(new DateTime(), "d-m-Y");
//                        echo $response;
                        ?>
                    </td>            
                </tr>

                <tr><td style="width: 100%;padding-bottom: 20px;padding-top: 10px;"><hr style="border: 1px solid #BDBDBD;"></td></tr>
                <tr style="border: 1px;">
                    <td style="width: 16%;padding-bottom: 20px;"><label style="width: 50%;"><b>Cliente:</b></label></td><td style="width: 15%;padding-bottom: 20px;"><?php echo $responseDecoded[0]["nEmpresaRadica"] ?></td>
                    <td style="width: 16%;padding-bottom: 20px;"><label><b>Solicitado por:</b></label></td><td style="width: 17%;padding-bottom: 20px;"><?php echo $responseDecoded[0]["nUsuarioRadica"] ?></td>            
                    <td style="width: 20%;padding-bottom: 20px;"><label><b>Fecha de radicado:</b></label></td><td style="width: 13%;padding-bottom: 20px;"><?php echo date_format(new DateTime($responseDecoded[0]["FechaRadicado"]), "d-m-Y") ?></td>            
                </tr>
                <tr style="border: 1px;">
                    <td style="width: 16%;padding-bottom: 20px;"><label><b>Tipo de Solicitud:</b></label></td><td style="width: 15%;padding-bottom: 20px;"><?php echo $responseDecoded[0]["nTipoRequerimiento"] ?></td>
                    <td style="width: 16%;padding-bottom: 20px;"><label><b>Prioridad:</b></label></td><td style="width: 17%;padding-bottom: 20px;"><?php echo $responseDecoded[0]["nPrioridad"] ?></td>            
                    <td style="width: 20%;padding-bottom: 20px;"><label><b>Fecha estimado entrega:</b></label></td><td style="width: 13%;padding-bottom: 20px;"><?php echo date_format(new DateTime($responseDecoded[0]["FechaEstCliente"]), "d-m-Y") ?></td>            
                </tr>
                <tr style="border: 1px;">                    
                    <td style="width: 16%;padding-bottom: 20px;"><b>Aplicativo:</b></td><td style="width: 15%;padding-bottom: 20px;"><?php echo $responseDecoded[0]["nAplicativo"] ?></td>
                    <td style="width: 16%;padding-bottom: 20px;"><b>Modulo:</b></td><td style="width: 17%;padding-bottom: 20px;"><?php echo $responseDecoded[0]["nModulo"] ?></td>
                    <td style="width: 20%;padding-bottom: 20px;"><b></b></td><td style="width: 13%;padding-bottom: 20px;"></td>
                </tr>                
                <tr><td style="width: 100%;padding-bottom: 20px;"><hr style="border: 1px solid #BDBDBD;"></td></tr>
                <tr style="border: 1px;">
                    <td style="width: 100%;"><b>REQUERIMIENTO</b></td>
                </tr>
                <tr style="border: 1px;">
                    <td style="width: 100%; border:1px solid #BDBDBD; height: 100px;"><?php echo $responseDecoded[0]["Requerimiento"] ?></td>
                </tr>
                <tr style="border: 1px;">                    
                    <td style="width: 100%; padding-top: 20px;"><b>OBJETIVO</b></td>
                </tr>                
                <tr style="border: 1px;">
                    <td style="width: 100%; border:1px solid #BDBDBD; height: 100px;"><?php echo $responseDecoded[0]["Objetivo"] ?></td>         
                </tr>
                <tr style="border: 1px; text-align: right;">                    
                    <td style="width: 50%; padding-top: 20px;"><b>Valor</b></td>
                    <td style="width: 50%; padding-top: 20px;"><?php echo number_format($responseDecoded[0]["Costo"], 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="width: 80%;"></td>
                    <td style="width: 20%;"><hr style="border: 1px black;"></td>
                </tr>
                <tr style="border: 1px; text-align: right;">                    
                    <td style="width: 50%; padding-top: 20px;"><b>Total</b></td>
                    <td style="width: 50%; padding-top: 20px;"><?php echo number_format($responseDecoded[0]["Costo"], 2, ',', '.') ?></td>
                </tr>
                <!--<tr><td style="width: 100%;padding-top: 100px"><hr style="border: 1px solid #BDBDBD;"></td></tr>-->
                <tr>
                    <td style="width: 15%; padding-top: 100px;"></td>
                    <td style="width: 65%; padding-top: 100px;">
                        <div style="width: 42%;"></div>
                        <?php if (isset($_SESSION["firma"]) && !empty($_SESSION["firma"])) { ?>
                            <img style="width: 30%" src="../img/<?php echo $_SESSION["firma"] ?>" alt=""/>
                        <?php } else { ?>
                            <div style="width: 30%;"></div>
                        <?php } ?>
                    </td>
                    <!--<td style="width: 20%;"></td>-->
                </tr>
                <tr>
                    <td style="width: 5%;"></td>
                    <td style="width: 40%;"><hr style="border: 1px #BDBDBD;"></td>
                    <td style="width: 55%;"></td>
                </tr>
                <tr style="border: 1px; ">
                    <td style="width: 5%;padding-top: 20px;"></td>
                    <td style="width: 40%;padding-top: 20px;"><?php echo $_SESSION["nameUser"] ?></td>
                    <td style="width: 55%;padding-top: 20px;"></td>
                </tr>
                <tr style="border: 1px; ">
                    <td style="width: 5%;padding-top: 20px;"></td>
                    <td style="width: 40%;padding-top: 20px;">C.C.: 1013660676</td>
                    <td style="width: 55%;padding-top: 20px;"></td>
                </tr>
            </table>            
        </div>
    </body>
</html>
<?php
//}?>