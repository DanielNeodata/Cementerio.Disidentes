<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_MargenesRecibos extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function brow($values){
        try {
            log_message('error', 'cco-> pasando x brow de sac Sac_MargenesRecibos init!.');
            logGeneral($this,$values,__METHOD__);
            $values["view"]="MargenesRecibos";
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);

            $values["getters"]=array(
             "search"=>true,
             "googlesearch"=>true,
             "excel"=>true,
             "pdf"=>true,
           );

            $values["buttons"]=array(
                "new"=>false,
                "edit"=>true,
                "delete"=>false,
                "offline"=>false,
            );
            $values["columns"]=array(
                array("field"=>"ID","format"=>"text"),
                //array("field"=>"FECHA","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

			//$values["controls"]=array(
			//    "<label>".lang('p_FECHA')."</label><input type='number' id='browser_seccion' name='browser_seccion' class='form-control number'/>",
			//);

			//$values["filters"]=array(
			//    //array("name"=>"browser_search", "operator"=>"like","fields"=>array("TITULAR")),
			//    array("name"=>"browser_search", "operator"=>"like","fields"=>array("ID","FECHA")),
                
			//);
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }


    public function excel($values){
        try {
            log_message('error', 'cco-> pasando x excel de sac Sac_MargenesRecibos init!.');
            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}
            $values["view"]="MargenesRecibos";
            $values["delimiter"]=";";
            $values["pagesize"]=-1;
            //$values["order"]=" description ASC";
            $values["records"]=$this->get($values);

            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
				//array("field"=>"SECCION","format"=>"text"),
				//array("field"=>"SEPULTURA","format"=>"text"),
				//array("field"=>"TIPO","format"=>"text"),
				//array("field"=>"TITULAR","format"=>"text"),
				//array("field"=>"DIRECCION","format"=>"text"),
				//array("field"=>"LOCALIDAD","format"=>"text"),
				//array("field"=>"COD_POSTAL","format"=>"text"),
				//array("field"=>"TELEFONO","format"=>"text"),
				//array("field"=>"EMAIL","format"=>"text"),

            );

            log_message('error', 'cco-> pasando x excel de sac servicios end1!.');
            return parent::excel($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function pdf($values){
        try {
            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}
            $values["view"]="MargenesRecibos";
            $values["pagesize"]=-1;
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);
            $values["title"]="Servicios: Altas, Bajas, Consultas y Modificaciones";
            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
				//array("field"=>"SECCION","format"=>"text"),
				//array("field"=>"SEPULTURA","format"=>"text"),
				//array("field"=>"TIPO","format"=>"text"),
				//array("field"=>"TITULAR","format"=>"text"),
				//array("field"=>"DIRECCION","format"=>"text"),
				//array("field"=>"LOCALIDAD","format"=>"text"),
				//array("field"=>"COD_POSTAL","format"=>"text"),
				//array("field"=>"TELEFONO","format"=>"text"),
				//array("field"=>"EMAIL","format"=>"text"),
            );
            log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
            return parent::pdf($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    

    public function edit($values){
        try {
            log_message('error', 'cco-> pasando x edit de margenes!.');
            logGeneral($this,$values,__METHOD__);
            log_message("error", "EDIT get params values ".json_encode($values,JSON_PRETTY_PRINT));

            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;
            
            $values["view"]="MargenesRecibos";

            $values["where"]=("ID=".$values["id"]);
            log_message('error', 'cco-> pasando x edit de margenes ID!.'.$values["id"]);
            $values["records"]=$this->get($values);
            log_message("error", "RECORDS edit margenes recibos ".json_encode($values["records"],JSON_PRETTY_PRINT));
            
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de Sac_MargenesRecibos 123 !.');
        //log_message('error', 'cco-> pasando x save de sac precios! ANTES IF . $values["TITULAR"]');
        try {
            $values["view"]="MargenesRecibos";
            $values["table"]="MargenesRecibos";
            log_message("error", "save get params values ".json_encode($values,JSON_PRETTY_PRINT));
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){
                log_message('error', 'cco-> pasando x save de sac Sac_MargenesRecibos! Sin ID entonces CREO una FILA.');
                //log_message('error', 'cco-> pasando x save de sac precios! Sin ID entonces CREO una FILA. $values["TITULAR"]');
                if($fields==null) {
                    $fields = array(
                        'original_fecha_arriba' => $values["original_fecha_arriba"],
                        'original_fecha_izquierda'  => $values["original_fecha_izquierda"],
                        'original_numero_arriba'  => $values["original_numero_arriba"],
                        'original_numero_izquierda'  => $values["original_numero_izquierda"],
                        'original_pagador_arriba'  => $values["original_pagador_arriba"],
                        'original_pagador_izquierda'  => $values["original_pagador_izquierda"],
                        'original_concepto_arriba'  => $values["original_concepto_arriba"],
                        'original_concepto_izquierda'  => $values["original_concepto_izquierda"],
                        'original_importe_arriba'  => $values["original_importe_arriba"],
                        'original_importe_izquierda'  => $values["original_importe_izquierda"],
                        'original_importeLetras_arriba'  => $values["original_importeLetras_arriba"],
                        'original_importeLetras_izquierda'  => $values["original_importeLetras_izquierda"],
                        'original_importeDolares_arriba'  => $values["original_importeDolares_arriba"],
                        'original_importeDolares_izquierda'  => $values["original_importeDolares_izquierda"],
                        'duplicado_fecha_arriba'  => $values["duplicado_fecha_arriba"],
                        'duplicado_fecha_izquierda'  => $values["duplicado_fecha_izquierda"],
                        'duplicado_numero_arriba'  => $values["duplicado_numero_arriba"],
                        'duplicado_numero_izquierda'  => $values["duplicado_numero_izquierda"],
                        'duplicado_pagador_arriba'  => $values["duplicado_pagador_arriba"],
                        'duplicado_pagador_izquierda'  => $values["duplicado_pagador_izquierda"],
                        'duplicado_concepto_arriba'  => $values["duplicado_concepto_arriba"],
                        'duplicado_concepto_izquierda'  => $values["duplicado_concepto_izquierda"],
                        'duplicado_importe_arriba'  => $values["duplicado_importe_arriba"],
                        'duplicado_importe_izquierda'  => $values["duplicado_importe_izquierda"],
                        'duplicado_importeLetras_arriba'  => $values["duplicado_importeLetras_arriba"],
                        'duplicado_importeLetras_izquierda'  => $values["duplicado_importeLetras_izquierda"],
                        'duplicado_importeDolares_arriba'  => $values["duplicado_importeDolares_arriba"],
                        'duplicado_importeDolares_izquierda'  => $values["duplicado_importeDolares_izquierda"],
                        

                    );
                }
            } else {
                //log_message('error', 'cco-> pasando x save de sac precios: titulo-->".$//values["TITULO"]."<--!.');
                log_message("error", "RELATED precios".json_encode($values,JSON_PRETTY_PRINT));
                if($fields==null) {
                    $fields = array(
                        'original_fecha_arriba' => $values["original_fecha_arriba"],
                        'original_fecha_izquierda'  => $values["original_fecha_izquierda"],
                        'original_numero_arriba'  => $values["original_numero_arriba"],
                        'original_numero_izquierda'  => $values["original_numero_izquierda"],
                        'original_pagador_arriba'  => $values["original_pagador_arriba"],
                        'original_pagador_izquierda'  => $values["original_pagador_izquierda"],
                        'original_concepto_arriba'  => $values["original_concepto_arriba"],
                        'original_concepto_izquierda'  => $values["original_concepto_izquierda"],
                        'original_importe_arriba'  => $values["original_importe_arriba"],
                        'original_importe_izquierda'  => $values["original_importe_izquierda"],
                        'original_importeLetras_arriba'  => $values["original_importeLetras_arriba"],
                        'original_importeLetras_izquierda'  => $values["original_importeLetras_izquierda"],
                        'original_importeDolares_arriba'  => $values["original_importeDolares_arriba"],
                        'original_importeDolares_izquierda'  => $values["original_importeDolares_izquierda"],
                        'duplicado_fecha_arriba'  => $values["duplicado_fecha_arriba"],
                        'duplicado_fecha_izquierda'  => $values["duplicado_fecha_izquierda"],
                        'duplicado_numero_arriba'  => $values["duplicado_numero_arriba"],
                        'duplicado_numero_izquierda'  => $values["duplicado_numero_izquierda"],
                        'duplicado_pagador_arriba'  => $values["duplicado_pagador_arriba"],
                        'duplicado_pagador_izquierda'  => $values["duplicado_pagador_izquierda"],
                        'duplicado_concepto_arriba'  => $values["duplicado_concepto_arriba"],
                        'duplicado_concepto_izquierda'  => $values["duplicado_concepto_izquierda"],
                        'duplicado_importe_arriba'  => $values["duplicado_importe_arriba"],
                        'duplicado_importe_izquierda'  => $values["duplicado_importe_izquierda"],
                        'duplicado_importeLetras_arriba'  => $values["duplicado_importeLetras_arriba"],
                        'duplicado_importeLetras_izquierda'  => $values["duplicado_importeLetras_izquierda"],
                        'duplicado_importeDolares_arriba'  => $values["duplicado_importeDolares_arriba"],
                        'duplicado_importeDolares_izquierda'  => $values["duplicado_importeDolares_izquierda"],
                        
                    );
                }
            }
             $id7=$this->saveRecord($fields,$id,"MargenesRecibos");
             $data=array("ID"=>$id);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>$message,
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data,
                );
            //return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
