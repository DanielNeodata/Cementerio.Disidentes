<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<h4>Lote</h4>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"SECCION","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"SEPULTURA","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"TIPO","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";
$html.="<h4>Fallecido</h4>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-12","name"=>"NRO_APERTURA","type"=>"number","class"=>"form-control number dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-12","name"=>"NOMBRE","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-2","name"=>"EDAD","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-4","name"=>"ESTADOCIVI","type"=>"text","class"=>"form-control text dbase validate"));
$html.=getInput($parameters,array("col"=>"col-md-6","name"=>"NACIONALID","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
