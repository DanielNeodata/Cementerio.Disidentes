<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";



$html.="<br/><h2>Original (medidas en mm)</h2>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_fecha_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_fecha_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_numero_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_numero_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_pagador_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_pagador_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_concepto_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_concepto_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_importe_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_importe_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_importeLetras_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_importeLetras_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_importeDolares_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"original_importeDolares_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<hr>";

$html.="<br/><h2>Duplicado  (medidas en mm)</h2>";


$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_fecha_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_fecha_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_numero_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_numero_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_pagador_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_pagador_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_concepto_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_concepto_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_importe_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_importe_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_importeLetras_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_importeLetras_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_importeDolares_arriba","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"duplicado_importeDolares_izquierda","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
