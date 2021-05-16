<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_emails extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }



    public function brow($values){
        try {
            log_message('error', 'cco-> pasando x brow de sac emails init!.');
            logGeneral($this,$values,__METHOD__);
            $values["view"]="emails";
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
                "delete"=>true,
                "offline"=>false,
            );
            $values["columns"]=array(
                //array("field"=>"Id","format"=>"text"),

                array("field"=>"remite","format"=>"text"),
                array("field"=>"destinatario","format"=>"text"),
                array("field"=>"subject","format"=>"text"),
                array("field"=>"fecha_envio","format"=>"text"),
                array("field"=>"body","format"=>"text"),
                //array("field"=>"ESTADO_OCUPACION","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

            
            $values["controls"]=array(
                "<label>".lang('p_destinatario')."</label><input type='text' id='browser_destinatiario' name='browser_destinatiario' class='form-control text'/>",
                "<label>".lang('p_body')."</label><input type='text' id='browser_body' name='browser_body' class='form-control text'/>",
                //"<label>".lang('p_ESTADO_OCUPACION')."</label><input type='text' id='browser_estado_ocupacion' name='browser_estado_ocupacion' class='form-control text'/>",

            );

            $values["filters"]=array(
                //array("name"=>"browser_search", "operator"=>"like","fields"=>array("TITULAR")),
                array("name"=>"browser_destinatiario", "operator"=>"like","fields"=>array("destinatiario")),
                array("name"=>"browser_body", "operator"=>"like","fields"=>array("body")),

            );

            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }


    public function edit($values){
        try {
            log_message('error', 'cco-> pasando x edit de sac emails!.');
            log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;

            $values["view"]="emails";

            $values["where"]=("Id=".$values["id"]);
            $values["records"]=$this->get($values);

            log_message('error', 'cco-> pasando x edit de emails!.'.$values["where"]);

            log_message("error", "RECORDS ".json_encode($values["records"],JSON_PRETTY_PRINT));

            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de memails!.');
        log_message('error', 'cco-> pasando x save de emails! ANTES IF');
        $values["view"]="emails";
        try {
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){
                log_message('error', 'cco-> pasando x save de emails! Sin ID entonces CREO una FILA.');
                log_message('error', 'cco-> pasando x save de emails! Sin ID entonces CREO una FILA.');

                if($fields==null) {
                    $fields = array(
                        'remite' => $values["remite"],
                        'destinatario' => $values["destinatario"],
                        'subject' => $values["subject"],
                        'body' => $values["body"],

                    );
                }
            } else {
                log_message('error', 'cco-> pasando x save de sac modelos notificacion');
                log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
                if($fields==null) {
                    $fields = array(
                        'remite' => $values["remite"],
                        'destinatario' => $values["destinatario"],
                        'subject' => $values["subject"],
                        'body' => $values["body"],

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
