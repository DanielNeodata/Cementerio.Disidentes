<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

$html=buildHeaderAbmStd($parameters,$title);
$html.="<div class='body-abm d-flex border border-light p-2 rounded shadow-sm'>";
$html.="<form style='width:100%;' autocomplete='off'>";

$html.="<h3>ASOCIACION CEMENTERIO DISIDENTES DE LOMAS DE ZAMORA</h3>";
$html.="<h4>Emisión de Recibos</h4>";


$html.="<div class='row'>  <div class='col-12' style='padding-top:15px;'>";
$html.="<img src='./assets/img/print.jpg' style='height:35px;' id='printimg' name='printimg' onclick='showReport();'></img>";
$html.=" </div>  </div>";

/**************** test borrar *******************/

//$html.="<br/><h4>BOTON EXTRA DATA</h4>";
//$html.="<div class='form-row'>";
//$html.=getInput($parameters,array("col"=>"col-md-3","id"=>"TRAER","name"=>"TRAER","type"=>"button","class"=>"btn-external-link1"));
//$html.="</div>";


/****************** fin test borrar ***************/

$html.="<br/><hr/>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"FECHA_EMIS","type"=>"date","class"=>"form-control text dbase validate"));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"NRO_RECIBO","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"RESPONSABL","type"=>"text","class"=>"form-control text dbase validate"));
$html.="</div>";

$html.="<br/><hr/>";
$html.="<div id=form-detail>";
$html.="</div>";
$html.="<script>";
$html.="_FUNCTIONS.onGetReceiptDetail($(this));";


$html.="</script>";

$html.="<br/><hr/>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"PESOS","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"DOLARES","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"COTIZACION","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"CHEQUE","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"BANCO","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"TARJETA","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"TARJDATO","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";
$html.="<div class='form-row'>";
$html.=getInput($parameters,array("col"=>"col-md-3","name"=>"TRANSFERENCIA","type"=>"text","class"=>"form-control text dbase "));
$html.="</div>";

$html.="</form>";
$html.="</div>";
$html.=buildFooterAbmStd($parameters);
echo $html;
?>

<script>
    //alert("antes script abm js");


    $.getScript('./application/views/mod_disidentes/Sac_facturacion_recibos/abm.js', function () {
        //alert("Done script abm js 111111111111111111111111111");
    });

    $("#PESOS").blur(function () { adjustTotalzPlain(1); });
    $("#DOLARES").blur(function () { adjustTotalzPlain(0); });
    $("#COTIZACION").blur(function () { adjustTotalzPlain(0); });
    $("#CHEQUE").blur(function () { adjustTotalzPlain(0); });
    $("#TARJETA").blur(function () { adjustTotalzPlain(0); });
    $("#TRANSFERENCIA").blur(function () { adjustTotalzPlain(0); });
    

    //alert("antes script abm js");
</script>
