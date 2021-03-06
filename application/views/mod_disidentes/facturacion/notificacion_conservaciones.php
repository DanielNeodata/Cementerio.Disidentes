<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
    $.getScript('./application/views/mod_disidentes/facturacion/notificacion_conservaciones.js', function() {

});
</script>

<div class="container-full marco p-1">
    <div class="row mx-0 shadow rounded" style="background-color:whitesmoke;">
        <div class="col-md-8 pt-1 m-0">
            <h1 class="m-0 p-0" style="font-weight:bold;color:rgb(0, 71, 186);"><?php echo $title;?></h1>
        </div>
    </div>
    <br />
    <br />
    <div class="form-row">    

        <div class="col-md-3" style="padding-right:5px;display:inline;">
            <label class="search-trigger" style="font-weight:bold;">Desde bimestres adelantados</label>
            <input type="text" id="TB-DESDE" name="TB-DESDE" class="form-control text" value="2"/>
        </div>
        <br />
    </div>
    <div class="form-row">
        <div class="col-md-3" style="padding-right:5px;display:inline;">
            <label class="search-trigger" style="font-weight:bold;">Hasta bimestres adelantados</label>
            <input type="text" id="TB-HASTA" name="TB-HASTA" class="form-control text" value="999" />
        </div>

        <br/>
    </div>
    <div class="form-row">

        <div class="browser_controls" style="padding-right:5px;display:inline;">
            <label class="search-trigger" style="font-weight:bold;">La carta debe decir hasta que fecha</label>
            <input type="date" id="TB-FECHA" name="TB-FECHA" class="form-control text" value="<?php echo date('Y-m-d', strtotime('-1 month')) ?>"/>
        </div>

    </div>
    <div class="form-row">

        <div class="col-md-3" style="padding-right:5px;display:inline;">
            <label class="search-trigger" style="font-weight:bold;">¿Cuántas cartas?</label>
            <input type="text" id="TB-CANTIDAD_CARTAS" name="TB-CANTIDAD_CARTAS" class="form-control text" value="99999"/>
        </div>

    </div>
    <div class="form-row">

        <div class="col-md-8">
            <label for="LBL-Destino" style="font-weight:bold;">Destino</label>
            &nbsp;&nbsp;
            <label for="DESTINO_I"> Impresora </label>
            <input id="DESTINO_I" type="radio" name="DESTINO" value="I">
            &nbsp;&nbsp;
            <label for="DESTINO_P">Pantalla</label>
            <input id="DESTINO_P" type="radio" name="DESTINO" value="P" >
            &nbsp;&nbsp;
            <label for="DESTINO_C">Combinar Correspondencia</label>
            <input id="DESTINO_C" type="radio" name="DESTINO" value="C" checked>
            &nbsp;&nbsp;
            <label for="DESTINO_X">Combinar Correspondencia - TODOS</label>
            <input id="DESTINO_X" type="radio" name="DESTINO" value="X" >
            &nbsp;&nbsp;
            <label for="DESTINO_Z">Combinar Correspondencia - SIN DEUDA</label>
            <input id="DESTINO_Z" type="radio" name="DESTINO" value="Z" >
        </div>
        
    </div>
    <div class="form-row">

        <div class="col-md-3">
            <label for="Reclacula" style="font-weight:bold;">Recalcula los valores</label>
            <input data-type="checkbox" checked="" autocomplete="nope" checkboxtype="SN" value="N" class="form-control text dbase " type="checkbox" name="recalcula" id="recalcula" >
        </div>
    
    </div>
    <div class="form-row">    
        

        <div class="col-md-8">
            <label for="LBL-MODO" style="font-weight:bold;">Modo</label>
            &nbsp;&nbsp;
            <span id="LBLR-Modo"> Imprimir todos </span>
            <input id="MODO_T" type="radio" name="MODO" value="T" checked>
            &nbsp;&nbsp;
            <span id="LBLR-Modo">Sin emails</span>
            <input id="MODO_S" type="radio" name="MODO" value="S" >
            &nbsp;&nbsp;
            <span id="LBLR-Modo">Solo envía por email</span>
            <input id="MODO_C" type="radio" name="MODO" value="C" >
       </div>
      
    </div>  

    <div class="form-row">    

        <div class="col-md-8">
            <label for="LBL-QUIEN" style="font-weight:bold;">A quien Notificar</label>
            &nbsp;&nbsp;
            <span id="LBLR-QUIEN"> Enviar a todos </span>
            <input id="QUIEN_T" type="radio" name="QUIEN" value="T" >
            &nbsp;&nbsp;
            <span id="QUIEN-QUIEN">Titulares</span>
            <input id="MODO_T" type="radio" name="QUIEN" value="I" checked>
            &nbsp;&nbsp;
            <span id="QUIEN-QUIEN">Responsables</span>
            <input id="MODO_R" type="radio" name="QUIEN" value="R" >
       </div>
      
    </div>  

    <br/>
     <br/>
     <br/>
    <div class="form-row">   

    <div class="browser_controls" style="padding-right:5px;display:inline;">
            <label class="search-trigger" style="font-weight:bold;">Modelos de Notificaciones</label><br />

            <select id="id_modelo" class="id_modelo form-control dbase">
        <?php 
         
             $html="";
             if(is_array($modelosNotificaciones)) {
                foreach ($modelosNotificaciones as $record){
                    $id=$record["ID"];
                    $html.= "<option value='".$record["ID"]."'>".$record["ModeloNotificacionNombre"]."</option>";
                }
             }
            echo $html;
        ?>
            </select>
        </div>
   </div> 

    <div class="form-row">    

        <div class="col-md-3" style="padding-right:5px;display:inline;">
            <label class="search-trigger" style="font-weight:bold;">Separador de listas (; o ,)</label>
            <input type="text" id="TB-SEPARADOR" name="TB-SEPARADOR" class="form-control text" value=","/>
        </div>
        <br />
    </div>

    <script>

        $("#MODO_C").on("click", function () {
            //alert("Modo c");
		$("#DESTINO_I").hide();
        $("#DESTINO_P").hide();
        $("#DESTINO_C").hide();
        $("label[for='" + $("#DESTINO_I").attr("id") + "']").hide();
        $("label[for='" + $("#DESTINO_P").attr("id") + "']").hide();
        $("label[for='" + $("#DESTINO_C").attr("id") + "']").hide();
        $("#DESTINO_X").click();
    });
        $("#MODO_T").on("click", function () {
        //alert("Modo t");
		$("#DESTINO_I").show();
        $("#DESTINO_P").show();
        $("#DESTINO_C").show();
        $("label[for='" + $("#DESTINO_I").attr("id") + "']").show();
        $("label[for='" + $("#DESTINO_P").attr("id") + "']").show();
        $("label[for='" + $("#DESTINO_C").attr("id") + "']").show();
    });
        $("#MODO_S").on("click", function () {
        //alert("Modo S");
		$("#DESTINO_I").show();
        $("#DESTINO_P").show();
        $("#DESTINO_C").show();
        $("label[for='" + $("#DESTINO_I").attr("id") + "']").show();
        $("label[for='" + $("#DESTINO_P").attr("id") + "']").show();
        $("label[for='" + $("#DESTINO_C").attr("id") + "']").show();
    });
</script>

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
