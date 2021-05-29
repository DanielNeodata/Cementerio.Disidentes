<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_fallecidos_listados extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function brow($values){
        try {
            $values["view"]="vw_SacFallecidos";
            $values["order"]="SECCION,NRO_APERTU";
            $values["records"]=$this->get($values);

            $values["getters"]=array(
             "search"=>true,
             "googlesearch"=>false,
             "excel"=>true,
             "pdf"=>true,
           );

            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>false,
                "offline"=>false,
            );
            $values["columns"]=array(
                //array("field"=>"ID","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"TIPO","format"=>"text"),
                array("field"=>"NRO_APERTU","format"=>"text"),
                array("field"=>"NOMBRE","format"=>"text"),
                array("field"=>"FECHA","format"=>"date"),
                
                
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

             $values["controls"]=array(
                "<label>".lang('p_SECCION_DESDE')."</label><input type='number' id='browser_seccion_desde' name='browser_seccion' class='form-control number'/>",
                "<label>".lang('p_SECCION_HASTA')."</label><input type='number' id='browser_seccion_hasta' name='browser_sepultura' class='form-control number'/>",
                
            );

            $values["filters"]=array(
                array("name"=>"browser_seccion_desde", "operator"=>">=","fields"=>array("SECCION")),
                array("name"=>"browser_seccion_hasta", "operator"=>"<=","fields"=>array("SECCION")),
                
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
            $values["view"]="vw_SacFallecidos";
            $values["delimiter"]=";";
            $values["pagesize"]=-1;
            $values["order"]="SECCION,NRO_APERTU";
            //$values["order"]=" description ASC";
            $values["records"]=$this->get($values);

            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"TIPO","format"=>"text"),
                array("field"=>"NRO_APERTU","format"=>"text"),
                array("field"=>"NOMBRE","format"=>"text"),
                array("field"=>"FECHA","format"=>"date"),


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
            $values["view"]="vw_SacFallecidos";
            $values["pagesize"]=-1;
            $values["order"]="SECCION,NRO_APERTU";
            $values["records"]=$this->get($values);
            $values["title"]="Fallecidos: Altas, Bajas, Consultas y Modificaciones";
            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"TIPO","format"=>"text"),
                array("field"=>"NRO_APERTU","format"=>"text"),
                array("field"=>"NOMBRE","format"=>"text"),
                array("field"=>"FECHA","format"=>"date"),

            );
            log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
            return parent::pdf($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function consultas_especiales($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));
            $html=$this->load->view($values["interface"],$data,true);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function listados($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));
            $html=$this->load->view($values["interface"],$data,true);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function edit($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");

            $values["view"]="vw_SacFallecidos";

            $values["page"]=1;
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        try {
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){
                if($fields==null) {
                    $fields = array(
                        'SECCION' => $values["SECCION"],
                        'SEPULTURA' => $values["SEPULTURA"],
                        'TIPO' => $values["TIPO"],
                        'NRO_APERTU' => $values["NRO_APERTU"],
                        'NOMBRE' => $values["NOMBRE"],
                        'EDAD' => $values["EDAD"],
                        'FECHA' => $values["FECHA"],
                        'NACIONALID' => $values["NACIONALID"],
                        'ESTADOCIVI' => $values["ESTADOCIVI"],
                        'CAUSADECES' => $values["CAUSADECES"],
                        'PARTIDA' => $values["PARTIDA"],
                        'HORA' => $values["HORA"],
                        'DNI' => $values["DNI"],
                        'EMPR_FUNEB' => $values["EMPR_FUNEB"],

                    );
                }
            } else {
                if($fields==null) {
                    $fields = array(
                        'SECCION' => $values["SECCION"],
                        'SEPULTURA' => $values["SEPULTURA"],
                        'TIPO' => $values["TIPO"],
                        'NRO_APERTU' => $values["NRO_APERTU"],
                        'NOMBRE' => $values["NOMBRE"],
                        'EDAD' => $values["EDAD"],
                        'FECHA' => $values["FECHA"],
                        'NACIONALID' => $values["NACIONALID"],
                        'ESTADOCIVI' => $values["ESTADOCIVI"],
                        'CAUSADECES' => $values["CAUSADECES"],
                        'PARTIDA' => $values["PARTIDA"],
                        'HORA' => $values["HORA"],
                        'DNI' => $values["DNI"],
                        'EMPR_FUNEB' => $values["EMPR_FUNEB"],
                        //{...more fields...}
                    );
                }
            }
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
