<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_fallecidos extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function brow($values){
        try {
            $values["view"]="vw_sac_fallecidos";
            $values["order"]="sst ASC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>false,
                "offline"=>false,
            );
            $values["columns"]=array(
                //array("field"=>"ID","format"=>"code"),
                array("field"=>"sst","format"=>"code"),
                array("field"=>"NOMBRE","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("NOMBRE")),
            );
            return parent::brow($values);
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
                        'NRO_APERTURA' => $values["NRO_APERTURA"],
                        'NOMBRE' => $values["NOMBRE"],
                        'EDAD' => $values["EDAD"],
                        'ESTADOCIVI' => $values["ESTADOCIVI"],
                        'NACIONALID' => $values["NACIONALID"],
                        //{...more fields...}
                    );
                }
            } else {
                if($fields==null) {
                    $fields = array(
                        'SECCION' => $values["SECCION"],
                        'SEPULTURA' => $values["SEPULTURA"],
                        'TIPO' => $values["TIPO"],
                        'NRO_APERTURA' => $values["NRO_APERTURA"],
                        'NOMBRE' => $values["NOMBRE"],
                        'EDAD' => $values["EDAD"],
                        'ESTADOCIVI' => $values["ESTADOCIVI"],
                        'NACIONALID' => $values["NACIONALID"],
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
