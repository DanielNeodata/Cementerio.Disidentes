<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";


$html.="<br/><h2>Arrendamiento de Lotes</h2>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARR_DISIDE","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARR_NODISI","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<hr>";

$html.="<br/><h4>Sector Parque Paraisos</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARDI99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPARND99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<hr>";
$html.="<br/><h4>Sector Parque Pinos</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINDI99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRPINND99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<hr>";
$html.="<br/><h4>Sector Parque Eucaliptus</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCDI99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARREUCND99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<hr>";
$html.="<br/><h4>Sector Monumento Antiguo</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTDI99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRANTND99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";



$html.="<hr>";
$html.="<br/><h4>Sector Monumento Británico</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIDI15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIND15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIDI15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIND15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIDI50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIND50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIDI99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRBRIND99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<hr>";
$html.="<br/><h4>Sector Monumento Museo</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND15","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND15N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND50N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND99N","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND15U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND50U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSDI99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"ARRMUSND99U","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<hr>";

$html.="<br/><h2>Consevaciones de Lotes</h2>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"CON_ADULTO","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"CON_NIN_UR","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<hr>";

$html.="<br/><h2>Inhumaciones</h2>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"INH_ADULTO","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"INH_NINOS","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"INH_URNAS","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<hr>";

$html.="<br/><h2>Inhumaciones</h2>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"REN_ND_10","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"REN_ND_5","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"REN_DI_10","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"REN_DI_5","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"REN_NI_10","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"REN_NI_5","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"REN_UR_10","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"REN_UR_5","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<hr>";

$html.="<br/><h2>Reducciones</h2>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RED_1","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RED_2","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RED_3","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";




$html.="<hr>";

$html.="<br/><h2>Varios</h2>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"JARDINERIA","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"TRANSLADOS","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"USOCAPILLA","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"TITULO","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"PLACAS_CENICEROS","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"LIBRO","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"CENIZAS1","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"CENIZAS2","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"CENIZAS3","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"CENIZAS4","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


/*************************************************************************/
$html.="<br/><h2>RENOVACION DE SEPULTURAS</h2>";


$html.="<br/><h4>Sector Parque Paraisos</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENPARDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENPARND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENPARDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENPARND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<br/><h4>Sector Parque Pinos</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENPINDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENPINND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENPINDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENPINND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<br/><h4>Sector Parque Aucaliptus</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENEUCDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENEUCND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENEUCDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENEUCND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<br/><h4>Sector Monumento Antiguo</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENANTDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENANTND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENANTDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENANTND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";

$html.="<br/><h4>Sector Monumento Británico</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENBRIDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENBRIND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENBRIDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENBRIND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";


$html.="<br/><h4>Sector Monumento Museo</h4>";

$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENMUSDI50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENMUSND50","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENMUSDI99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RENMUSND99","type"=>"number","class"=>"form-control text dbase "));
$html.="</div>";



$html.="<br/><h2>ZONAS DEL CEMENTERIO</h2>";


$html.="<br/><h4>Ingresar las secciones separadas por un espacio</h4>";

$html.="<div class='form-row'>";
$html.=getTextArea($parameters,array("col"=>"col-md-8","name"=>"PARQUE","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getTextArea($parameters,array("col"=>"col-md-8","name"=>"MUSEO","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getTextArea($parameters,array("col"=>"col-md-8","name"=>"RESERVA","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getTextArea($parameters,array("col"=>"col-md-8","name"=>"ANTIGUA","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";


$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>
