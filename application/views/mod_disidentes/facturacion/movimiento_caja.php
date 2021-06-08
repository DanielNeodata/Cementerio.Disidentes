<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    $.getScript('./application/views/mod_disidentes/facturacion/movimiento_caja.js', function() {
    });
</script>
<div class="container-full marco p-1">
    <div class="row mx-0 shadow rounded" style="background-color:whitesmoke;">
        <div class="col-12 pt-1 m-0">
            <h1 class="m-0 p-0" style="font-weight:bold;color:rgb(0, 71, 186);">Movimientos de caja entre fechas</h1>
        </div>
    </div>
    <div id="FILTER-CONTAINER" class="row m-2 p-2">

        <div class="browser_controls" style="padding-right:5px;display:inline;">
            <label class="search-trigger">Desde</label>
            <input type="date" id="TB-aDesde" name="TB-aDesde" class="form-control text" value="<?php echo date('Y-m-d') ?>"/>
        </div>

        <div class="browser_controls" style="padding-right:5px;display:inline;">
            <label class="search-trigger">Hasta</label>
            <input type="date" id="TB-aHasta" name="TB-aHasta" class="form-control text" value="<?php echo date('Y-m-d') ?>"/>
        </div>


    </div>
    <br />
    <br />
    <div id="REPORT-CONTAINER" class="row m-2 p-2">
        
    </div>

    <hr/>
    
    <hr/>
    <div class="row">
        <div class="col-12" style="padding-top:15px;">
            <a href="#" class="btnAction btnAccept btn btn-success btn-raised pull-right" onclick="showTable();"><?php echo lang('b_accept');?></a>
        </div>
    </div>
</div>
</div>

