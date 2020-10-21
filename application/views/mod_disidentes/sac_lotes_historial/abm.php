<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<br/><h4>Lote</h4>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"SECCION","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"SEPULTURA","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"FECHA_EMIS","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"NRO_RECIBO","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-8","name"=>"CONCEPTO","type"=>"text","class"=>"form-control text dbase"));
$html.="</div>";



$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
