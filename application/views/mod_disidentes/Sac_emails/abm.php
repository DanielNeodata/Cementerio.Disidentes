<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);

$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";


$html.="<br/><h4>Notificación</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"remite","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"destinatario","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"subject","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";
$html.="<br/>";

$html.="<br/>";
$html.="<div class='form-row'>";
$html.=getTextAreaHtmlEditor($parameters,array("col"=>"col-md-8","name"=>"body","type"=>"textarea","class"=>"html form-control text dbase","rows"=>"20","cols"=>"200","free"=>"style='width: 900px; height: 200px; display: block;'"));
$html.="</div>";



$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
