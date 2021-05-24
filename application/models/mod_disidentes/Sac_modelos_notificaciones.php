<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_modelos_notificaciones extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    

    public function brow($values){
        try {
            log_message('error', 'cco-> pasando x brow de sac modelos notifiaciones init!.');
            logGeneral($this,$values,__METHOD__);
            $values["view"]="ModelosNotificaciones";
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);

            $values["getters"]=array(
             "search"=>true,
             "googlesearch"=>true,
             "excel"=>true,
             "pdf"=>true,
           );

            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>true,
                "offline"=>false,
            );
            $values["columns"]=array(
                //array("field"=>"Id","format"=>"text"),

                array("field"=>"ModeloNotificacionNombre","format"=>"text"),
                array("field"=>"ModeloNotificacionTitulo","format"=>"text"),
                array("field"=>"remitente","format"=>"text"),
                array("field"=>"NombreRemitente","format"=>"text"),
                
                //array("field"=>"ESTADO_OCUPACION","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );


            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }


    public function edit($values){
        try {
            log_message('error', 'cco-> pasando x edit de sac modelos notifiaciones!.');
            log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;

            $values["view"]="ModelosNotificaciones";

            $values["where"]=("Id=".$values["id"]);
            $values["records"]=$this->get($values);
            
            log_message('error', 'cco-> pasando x edit de modelos notifiaciones!.'.$values["where"]);

            log_message("error", "RECORDS ".json_encode($values["records"],JSON_PRETTY_PRINT));
            
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de modelos notificacion!.');
        log_message('error', 'cco-> pasando x save de modelos notificacion! ANTES IF');
        $values["view"]="ModelosNotificaciones";
        try {
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){
                log_message('error', 'cco-> pasando x save de modelos notificacion! Sin ID entonces CREO una FILA.');
                log_message('error', 'cco-> pasando x save de modelos notificacion! Sin ID entonces CREO una FILA.');

                if($fields==null) {
                    $fields = array(
                        'ModeloNotificacionNombre' => $values["ModeloNotificacionNombre"],
                        'ModeloNotificacionTitulo' => $values["ModeloNotificacionTitulo"],
                        'ModeloNotificacionHtml' => $values["ModeloNotificacionHtml"],
                        'remitente' => $values["remitente"],
                        'NombreRemitente' => $values["NombreRemitente"],


                    );
                }
            } else {
                log_message('error', 'cco-> pasando x save de sac modelos notificacion');
                log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
                if($fields==null) {
                    $fields = array(
                        'ModeloNotificacionNombre' => $values["ModeloNotificacionNombre"],
                        'ModeloNotificacionTitulo' => $values["ModeloNotificacionTitulo"],
                        'ModeloNotificacionHtml' => $values["ModeloNotificacionHtml"],
                        'remitente' => $values["remitente"],
                        'NombreRemitente' => $values["NombreRemitente"],

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
