<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_lotes_listados extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function brow($values){
        try {
            log_message('error', 'cco-> pasando x brow de sac lotes init!.');
            logGeneral($this,$values,__METHOD__);
            $values["view"]="vw_SacLotes";
            $values["order"]="ssst ASC";
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
                array("field"=>"TIPO","format"=>"text"),
                array("field"=>"TITULAR","format"=>"text"),
                array("field"=>"DIRECCION","format"=>"text"),
                array("field"=>"NROTITULO","format"=>"text"),
                array("field"=>"FECHACOMPR","format"=>"date"),
                array("field"=>"PRECICOMPR","format"=>"text"),
                array("field"=>"VENCIMIENTO","format"=>"date"),
                array("field"=>"ULTBIMPAGO","format"=>"date"),
                //array("field"=>"","format"=>null),
                //array("field"=>"","format"=>null),
            );

            $values["controls"]=array(
                "<label>".lang('p_SECCION')."</label><input type='number' id='browser_seccion' name='browser_seccion' class='form-control text'/>",
                "<label>".lang('p_SEPULTURA')."</label><input type='number' id='browser_sepultura' name='browser_sepultura' class='form-control text'/>",
                "<label>".lang('p_TIPO')."</label><input type='text' id='browser_tipo' name='browser_tipo' class='form-control text'/>",
               //"<label>".lang('p_ESTADO_OCUPACION')."</label><input type='text' id='browser_estado_ocupacion' name='browser_estado_ocupacion' class='form-control text'/>",
               "<label>".lang('p_ESTADO_OCUPACION')."</label>".comboEstadosOcupacion($this),
            );

            $values["filters"]=array(
                //array("name"=>"browser_search", "operator"=>"like","fields"=>array("TITULAR")),
                array("name"=>"browser_sepultura", "operator"=>"like","fields"=>array("SEPULTURA")),
                array("name"=>"browser_seccion", "operator"=>"like","fields"=>array("SECCION")),
                array("name"=>"browser_tipo", "operator"=>"like","fields"=>array("TIPO")),
                array("name"=>"browser_id_estados_ocupacion", "operator"=>"=","fields"=>array("ESTADO_OCUPACION")),
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
            $values["view"]="vw_SacLotes";
            $values["delimiter"]=";";
            $values["pagesize"]=-1;
            //$values["order"]=" description ASC";
            $values["records"]=$this->get($values);

            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"TIPO","format"=>"text"),
                array("field"=>"TITULAR","format"=>"text"),
                array("field"=>"DIRECCION","format"=>"text"),
                array("field"=>"NROTITULO","format"=>"text"),
                array("field"=>"FECHACOMPR","format"=>"date"),
                array("field"=>"PRECICOMPR","format"=>"text"),
                array("field"=>"VENCIMIENTO","format"=>"date"),
                array("field"=>"ULTBIMPAGO","format"=>"date"),


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
            $values["view"]="vw_SacLotes";
            $values["pagesize"]=-1;
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);
            $values["title"]="Listado de Arrendatarios de Lotes";
            $values["columns"]=array(
                array("field"=>"ID","format"=>"text"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"TIPO","format"=>"text"),
                array("field"=>"TITULAR","format"=>"text"),
                array("field"=>"DIRECCION","format"=>"text"),
                array("field"=>"NROTITULO","format"=>"text"),
                array("field"=>"FECHACOMPR","format"=>"date"),
                array("field"=>"PRECICOMPR","format"=>"text"),
                array("field"=>"VENCIMIENTO","format"=>"date"),
                array("field"=>"ULTBIMPAGO","format"=>"date"),
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
            log_message('error', 'cco-> pasando x edit de sac lotes LISTADOS!.');

            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;
            $values["readonly"]=true;
            $values["view"]="vw_SacLotes";

            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            //log_message("error", "RECORDS ".json_encode($values["records"],JSON_PRETTY_PRINT));
            $parameters_id_forma_pago=array(
                "model"=>(MOD_DISIDENTES."/Tipo_forma_pago"),
                "table"=>"tipo_forma_pago",
                "name"=>"id_forma_pago",
                "class"=>"form-control dbase",
                "empty"=>true,
                "id_actual"=>secureComboPosition($values["records"],"id_forma_pago"),
                "id_field"=>"id",
                "description_field"=>"descripcion",
                "get"=>array("order"=>"descripcion ASC","pagesize"=>-1),
            );
            $parameters_id_estados=array(
                "model"=>(MOD_DISIDENTES."/Estados_Ocupacion"),
                "table"=>"estados_ocupacion",
                "name"=>"estado_ocupacion",
                "class"=>"form-control dbase",
                "empty"=>false,
                "id_actual"=>secureComboPosition($values["records"],"ESTADO_OCUPACION"),
                "id_field"=>"id",
                "description_field"=>"descripcion",
                "get"=>array("order"=>"descripcion ASC","pagesize"=>-1),
            );
            $values["controls"]=array(
                "id_forma_pago"=>getCombo($parameters_id_forma_pago,$this),
                "estado_ocupacion"=>getCombo($parameters_id_estados,$this),
            );
            
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de sac lotes!.');
        log_message('error', 'cco-> pasando x save de sac lotes! ANTES IF . $values["TITULAR"]');
        try {
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){
                log_message('error', 'cco-> pasando x save de sac lotes! Sin ID entonces CREO una FILA.');
                log_message('error', 'cco-> pasando x save de sac lotes! Sin ID entonces CREO una FILA. $values["TITULAR"]');
                if($fields==null) {
                    $fields = array(
                        'SECCION' => $values["SECCION"],
                        'SEPULTURA' => $values["SEPULTURA"],
                        'SECTOR' => $values["SECTOR"],
                        'TIPO' => $values["TIPO"],
                        'id_forma_pago' => secureEmptyNull($values,"id_forma_pago"),
                        'numero_tarjeta' => $values["numero_tarjeta"],
                        'ESTADO_OCUPACION' => $values["estado_ocupacion"],
                        'TITULAR' => $values["TITULAR"],
                        'DIRECCION' => $values["DIRECCION"],
                        'COD_POSTAL' => $values["COD_POSTAL"],
                        'LOCALIDAD' => $values["LOCALIDAD"],
                        'TELEFONO' => $values["TELEFONO"],
                        'EMAIL' => $values["EMAIL"],
                        'RES_EMAIL_SEC' => $values["RES_EMAIL_SEC"],
                        'EMAIL_SEC' => $values["EMAIL_SEC"],
                        'RESPONSABL' => $values["RESPONSABL"],
                        'RES_DIRECC' => $values["RES_DIRECC"],
                        'RES_CODPOS' => $values["RES_CODPOS"],
                        'RES_LOCALI' => $values["RES_LOCALI"],
                        'RES_TELEFO' => $values["RES_TELEFO"],
                        'RES_EMAIL' => $values["RES_EMAIL"],

                        'NROTITULO' => $values["NROTITULO"],
                        'FECHACOMPR' => $values["FECHACOMPR"],
                        'PRECICOMPR' => $values["PRECICOMPR"],
                        'ANOSARREND' => $values["ANOSARREND"],
                        'VENCIMIENTO' => $values["VENCIMIENTO"],
                        'ULT_RENOVA' => $values["ULT_RENOVA"],
                        'ANOSRENOVA' => $values["ANOSRENOVA"],

                        'ULTBIMPAGO' => $values["ULTBIMPAGO"],
                        'DEUDA' => $values["DEUDA"],
                        'TITULO' => $values["TITULO"],
                        'REGLAMENTO' => $values["REGLAMENTO"],

                        'COMENTARIO' => $values["COMENTARIO"],
                        'NSER' => $values["NSER"],
                        'OBS' => $values["OBS"],
                        'ACUENTA' => $values["ACUENTA"],
                        'CARTARENOV' => $values["CARTARENOV"],
                        'CARTACONSE' => $values["CARTACONSE"],
                        'BIMVENCIDO' => $values["BIMVENCIDO"],
                        'RENVENCIDA' => $values["RENVENCIDA"],
                        //'TITULAR' => $values["TITULAR"],

                        //{...more fields...}

                    );
                }
            } else {
                log_message('error', 'cco-> pasando x save de sac lotes: titulo-->".$values["TITULO"]."<--!.');
                log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
                if($fields==null) {
                    $fields = array(
                        'SECCION' => $values["SECCION"],
                        'SEPULTURA' => $values["SEPULTURA"],
                        'SECTOR' => $values["SECTOR"],
                        'TIPO' => $values["TIPO"],

                        'id_forma_pago' => secureEmptyNull($values,"id_forma_pago"),
                        'numero_tarjeta' => $values["numero_tarjeta"],
                        'ESTADO_OCUPACION' => $values["estado_ocupacion"],
                        'TITULAR' => $values["TITULAR"],
                        'DIRECCION' => $values["DIRECCION"],
                        'COD_POSTAL' => $values["COD_POSTAL"],
                        'LOCALIDAD' => $values["LOCALIDAD"],
                        'TELEFONO' => $values["TELEFONO"],
                        'EMAIL' => $values["EMAIL"],
                        'RES_EMAIL_SEC' => $values["RES_EMAIL_SEC"],
                        'EMAIL_SEC' => $values["EMAIL_SEC"],
                        'RESPONSABL' => $values["RESPONSABL"],
                        'RES_DIRECC' => $values["RES_DIRECC"],
                        'RES_CODPOS' => $values["RES_CODPOS"],
                        'RES_LOCALI' => $values["RES_LOCALI"],
                        'RES_TELEFO' => $values["RES_TELEFO"],
                        'RES_EMAIL' => $values["RES_EMAIL"],

                        'NROTITULO' => $values["NROTITULO"],
                        'FECHACOMPR' => $values["FECHACOMPR"],
                        'PRECICOMPR' => $values["PRECICOMPR"],
                        'ANOSARREND' => $values["ANOSARREND"],
                        'VENCIMIENTO' => $values["VENCIMIENTO"],
                        'ULT_RENOVA' => $values["ULT_RENOVA"],
                        'ANOSRENOVA' => $values["ANOSRENOVA"],

                        'ULTBIMPAGO' => $values["ULTBIMPAGO"],
                        'DEUDA' => $values["DEUDA"],
                        'TITULO' => $values["TITULO"],
                        'REGLAMENTO' => $values["REGLAMENTO"],

                        'COMENTARIO' => $values["COMENTARIO"],
                        'NSER' => $values["NSER"],
                        'OBS' => $values["OBS"],
                        'ACUENTA' => $values["ACUENTA"],
                        'CARTARENOV' => $values["CARTARENOV"],
                        'CARTACONSE' => $values["CARTACONSE"],
                        'BIMVENCIDO' => $values["BIMVENCIDO"],
                        'RENVENCIDA' => $values["RENVENCIDA"],
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
