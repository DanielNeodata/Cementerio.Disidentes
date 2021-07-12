<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_lotes_historial extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function brow($values){
        try {
            log_message('error', 'cco-> pasando x brow de sac lotes init!.');
            logGeneral($this,$values,__METHOD__);
            $values["view"]="vw_SacLotesHistorial";
            $values["order"]="FECHA_EMIS DESC";
            $values["records"]=$this->get($values);

            $values["getters"]=array(
             "search"=>true,
             "googlesearch"=>false,
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
                //array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"FECHA_EMIS","format"=>"date"),
                array("field"=>"NRO_RECIBO","format"=>"text"),
                array("field"=>"CONCEPTO","format"=>"text"),
                
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

            $values["controls"]=array(
                "<label>".lang('p_SECCION')."</label><input type='text' id='browser_seccion' name='browser_seccion' class='form-control number'/>",
                "<label>".lang('p_SEPULTURA')."</label><input type='text' id='browser_sepultura' name='browser_sepultura' class='form-control number'/>",
                "<label>".lang('p_TIPO')."</label><input type='text' id='browser_tipo' name='browser_tipo' class='form-control number'/>",
            );

            $values["filters"]=array(
                //array("name"=>"browser_search", "operator"=>"like","fields"=>array("TITULAR")),
                array("name"=>"browser_sepultura", "operator"=>"=","fields"=>array("SEPULTURA")),
                array("name"=>"browser_seccion", "operator"=>"=","fields"=>array("SECCION")),
                array("name"=>"browser_tipo", "operator"=>"like","fields"=>array("TIPO")),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }


    public function excel($values){
        try {
            log_message('error', 'cco-> pasando x excel de sac lotes init!.');
            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}
            $values["view"]="vw_SacLotesHistorial";
            $values["delimiter"]=";";
            $values["pagesize"]=-1;
            //$values["order"]=" description ASC";
            $values["records"]=$this->get($values);

            $values["columns"]=array(
                
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"FECHA_EMIS","format"=>"date"),
                array("field"=>"NRO_RECIBO","format"=>"text"),
                array("field"=>"CONCEPTO","format"=>"text"),

            );

            log_message('error', 'cco-> pasando x excel de sac lotes end1!.');
            return parent::excel($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function pdf($values){
        try {
            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}
            $values["view"]="vw_SacLotesHistorial";
            $values["pagesize"]=-1;
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);
            $values["title"]="Lotes: Historial";
            $values["columns"]=array(
                //array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"FECHA_EMIS","format"=>"date"),
                array("field"=>"NRO_RECIBO","format"=>"text"),
                array("field"=>"CONCEPTO","format"=>"text"),
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
            log_message('error', 'cco-> pasando x edit de sac lotes!.');

            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;
            $values["readonly"]=true;
            $values["view"]="vw_SacLotesHistorial";

            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            //log_message("error", "RECORDS ".json_encode($values["records"],JSON_PRETTY_PRINT));
            
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    
    
}
