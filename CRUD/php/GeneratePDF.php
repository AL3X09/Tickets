<!DOCTYPE hmlt>
<html>
    <head></head>
</html>
<?php
/**
 * HTML2PDF Library - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2016 Laurent MINGUET
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
// get the HTML
ob_start();
//    include(dirname(__FILE__).'/res/exemple00.php');
include('./purchaseOrder.php');
$content = ob_get_clean();

// convert in PDF   
//    require_once(dirname(__FILE__).'/../html2pdf.class.php');
require_once('../html2pdf/html2pdf.class.php');
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
//      $html2pdf->setModeDebug();
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    ob_get_clean();
    $html2pdf->Output('OrdenCompra.pdf');
    ob_end_flush();
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
