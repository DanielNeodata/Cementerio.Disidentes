<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
    $.getScript('./application/views/mod_disidentes/facturacion/estadisticas_generales.js', function() {

});
</script>

<div class="container-full marco p-1">
    <div class="row mx-0 shadow rounded" style="background-color:whitesmoke;">
        <div class="col-12 pt-1 m-0">
            <h1 class="m-0 p-0" style="font-weight:bold;color:rgb(0, 71, 186);"><?php echo $title;?></h1>
        </div>
    </div>
    <div id="FILTER-CONTAINER" class="row m-2 p-2">
        
        <div class="col-md-3">
            <label for="Reclacula">Recalcula los valores</label>
            <input data-type="checkbox" checked="" autocomplete="nope" checkboxtype="SN" value="N" class="form-control text dbase " type="checkbox" name="recalcula" id="recalcula" >
        </div>
        <br />
        <div class="col-md-3">
            <label for="Detallado">Detallado</label>
            <input data-type="checkbox" checked="" autocomplete="nope" checkboxtype="SN" value="N" class="form-control text dbase " type="checkbox" name="detallado" id="detallado" >
        </div>

        <br />
        
        <div class="col-md-3" style="padding-right:5px;display:inline;">
            <label class="search-trigger">Desde bimestres adelantados</label>
            <input type="text" id="TB-aDesde" name="TB-aDesde" class="form-control text" value="-999"/>
        </div>
        <br />
        <div class="col-md-3" style="padding-right:5px;display:inline;">
            <label class="search-trigger">Hasta bimestres adelantados</label>
            <input type="text" id="TB-aHasta" name="TB-aHasta" class="form-control text" value="999"/>
        </div>

        <br/>


    </div>
    <br />
    <br />
    <div id="REPORT-CONTAINER" class="row m-2 p-2">
        
    </div>

    <hr/>
    
    <hr/>
    <div class="row">
        <div class="col-12" style="padding-top:15px;">
            <a href="#" class="btnAction btnAccept btn btn-success btn-raised pull-right" onclick="showReport();"><?php echo lang('b_accept');?></a>
        </div>
    </div>
</div>


