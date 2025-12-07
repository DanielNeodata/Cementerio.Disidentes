<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);

$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";


$html.="<br/><h4>Notificación</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"ModeloNotificacionNombre","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"ModeloNotificacionTitulo","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"remitente","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"NombreRemitente","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";
$html.="<br/>";

$html.="<br/>";
$html.="<div class='form-row'>";
$html.=getTextAreaHtmlEditor($parameters,array("col"=>"col-md-8","name"=>"ModeloNotificacionHtml","type"=>"textarea","class"=>"html form-control text dbase","rows"=>"20","cols"=>"200","free"=>"style='width: 900px; height: 200px; display: block;'"));
$html.="</div>";

$html.="<br/><h6> Las variables a ser reemplazadas por datos del sistema son: [TITULAR],[DIRECCION],[LOCALIDAD],[COD_POSTAL],[SECCION],[SEPULTURA],[VENCIMIENTO],[IMPORTE] y [HOY] </H6><br/>";
$html.="<h7> Por ejemplo, Estimado [TITULAR] de la sepultura [SEPULTURA] en la sección [SECCION].....</H7>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
