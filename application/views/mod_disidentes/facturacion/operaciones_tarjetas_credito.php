<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>




<div class="container-full marco p-1">
    <div class="row mx-0 shadow rounded" style="background-color:whitesmoke;">
        <div class="col-12 pt-1 m-0">
            <h1 class="m-0 p-0" style="font-weight:bold;color:rgb(0, 71, 186);"><?php echo $title;?></h1>
        </div>
    </div>
    <br/><br/>
    <div class="form-row">
        <h4>Seleccione que tareas realizar, vinculadas a los lotes marcados para procesar tarjetas de crédito.<br/>
        Ingrese año y mes de la consulta o proceso a realizar.</h4>
    </div>

    <div id="selectAnio" class="form-row">
    </div>

  
    <br />
    <br />
    <div id="REPORT-CONTAINER" class="row m-2 p-2">
        
    </div>

    
</div>

<script>
    $.getScript('./application/views/mod_disidentes/facturacion/operaciones_tarjetas_credito.js', function() {
    getYears();
});
</script>
