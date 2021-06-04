<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_lotes extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    
    public function GetLote($values){
	    try {
	        log_message('error', 'cco-> pasando x GetLote de lotes init!.');
	        logGeneral($this,$values,__METHOD__);
	        log_message('error', 'cco-> pasando x GetLote de lotes desp log general.');
	        if (isset($values["view"])){$this->view=$values["view"];}
	        log_message('error', 'cco-> pasando x GetLote de lotes VIEW es:->'.$values["view"]."<-");
            //log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));

	        $values["view"]="vw_SacLotes";
	        //$values["order"]=$values["Orden"]." ASC";
	        //$values["page"]=-1;
	        $values["pagesize"]=-1;

            

            $values["where"]=" ID = ".$values["ID"];


	        log_message('error', 'cco-> pasando x GetLote de  lotes ver where->'.$filtro."<-");

            //$conceptos = $this->execAdHocAsArray("select * from SAC_Operaciones order by ID");
           

	        $data=$this->get($values);

            $precios = $this->execAdHocAsArray("select * from SAC_Servicio");

            log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

            $sec = $data["data"][0]["SECCION"];
            $sep = $data["data"][0]["SEPULTURA"];

            $recnoac = $data["data"][0]["ACUENTA"];
            if ($recnoac>0)
            {
                $qryac = "SELECT *,CONVERT(char(10),FECHA_EMIS,103) As qryFec, IsNull(str(importe,10,0), 0)*-1 As qryTot FROM SAC_Movimientos WHERE (NRO_RECIBO=".trim($recnoac)." and OPERACION='PC' and IMPORTE>0);";

            }
            else
            {
                $qryac = "SELECT * FROM SAC_Movimientos WHERE 1=2";
            }
            $acuenta = $this->execAdHocAsArray($qryac);

            log_message('error', 'cco-> pasando x GetLote de  lotes ver sep->'.$sep."<- ->".$sec."<-");

            $qryF = "SELECT ID FROM SAC_Fallecidos WHERE (SECCION='".$sec."') And (SEPULTURA='".$sep."');";
            log_message('error', 'cco-> pasando x GetLote de  lotes ver where->'.$qryF."<-");

            $fallecidos = $this->execAdHocAsArray($qryF);
            

                                
	        log_message('error', 'cco-> pasando x GetLote de  lotes entre getrecords y return array! Cantidad filas:'.$data["totalrecords"]."<-------");
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                //"conceptos"=>$conceptos,
                "precios"=>$precios,
                "fallecidos"=>$fallecidos,
                "acuenta" =>$acuenta,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
	            "data"=>$data["data"],
	            "totalrecords"=>$data["totalrecords"],
	            "totalpages"=>$data["totalpages"],
	            "page"=>$data["page"]
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function getCustom($values){
        try {
            log_message('error', 'cco-> pasando x getCustom de sac lotes init!.');
            logGeneral($this,$values,__METHOD__);
            log_message('error', 'cco-> pasando x getCustom de sac lotes desp log general.');
            if (isset($values["view"])){$this->view=$values["view"];}
            $values["page"]=-1;
            $values["pagesize"]=-1;
            $values["order"]="1 ASC";
            $values["where"]="id>0";

            log_message('error', 'cco-> pasando x getCustom de sac lotes ver vars.'.$values["txtResponsable"]."_--------------_".$values["txtSeputura"]);

            //$values["txtOrden"];
            //$values["txtSepultura"];

            $data=$this->get($values);
            log_message('error', 'cco-> pasando x getCustom de sac lotes entre getrecords y return array! Cantidad filas:'.$data["totalrecords"]."<-------");
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>"Records",
                "table"=>$this->table,
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data["data"],
                "totalrecords"=>$data["totalrecords"],
                "totalpages"=>$data["totalpages"],
                "page"=>$data["page"]
            );
        }
        catch(Exception $e) {
            return logError($e,__METHOD__ );
        }
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
                //array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"TIPO","format"=>"text"),
                array("field"=>"TITULAR","format"=>"text"),
                array("field"=>"DIRECCION","format"=>"text"),
                array("field"=>"LOCALIDAD","format"=>"text"),
                array("field"=>"COD_POSTAL","format"=>"text"),
                array("field"=>"TELEFONO","format"=>"text"),
                array("field"=>"EMAIL","format"=>"text"),
                //array("field"=>"ESTADO_OCUPACION","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

            $values["controls"]=array(
                "<label>".lang('p_SECCION')."</label><input type='text' id='browser_seccion' name='browser_seccion' class='form-control number'/>",
                "<label>".lang('p_SEPULTURA')."</label><input type='text' id='browser_sepultura' name='browser_sepultura' class='form-control number'/>",
                "<label>".lang('p_EMAIL')."</label><input type='text' id='browser_email' name='browser_email' class='form-control text'/>",
                "<label>".lang('p_TITULAR')."</label><input type='text' id='browser_titular' name='browser_titular' class='form-control text'/>",
                "<label>".lang('p_RESPONSABL')."</label><input type='text' id='browser_responsable' name='browser_responsable' class='form-control text'/>",
                "<label>".lang('p_RES_LOCALI')."</label><input type='text' id='browser_reslocalidad' name='browser_reslocalidad' class='form-control text'/>",
                //"<label>".lang('p_ESTADO_OCUPACION')."</label><input type='text' id='browser_estado_ocupacion' name='browser_estado_ocupacion' class='form-control text'/>",
                "<label>".lang('p_TIPO')."</label><input type='text' id='browser_tipo' name='browser_tipo' class='form-control number'/>",
                "<label>".lang('p_ESTADO_OCUPACION')."</label>".comboEstadosOcupacion($this),
            );

            $values["filters"]=array(
                //array("name"=>"browser_search", "operator"=>"like","fields"=>array("TITULAR")),
                array("name"=>"browser_sepultura", "operator"=>"=","fields"=>array("SEPULTURA")),
                array("name"=>"browser_seccion", "operator"=>"=","fields"=>array("SECCION")),
                array("name"=>"browser_email", "operator"=>"like","fields"=>array("EMAIL")),
                array("name"=>"browser_titular", "operator"=>"like","fields"=>array("TITULAR")),
                array("name"=>"browser_responsable", "operator"=>"like","fields"=>array("RESPONSABL")),
                array("name"=>"browser_reslocalidad", "operator"=>"like","fields"=>array("RES_LOCALI")),
                //array("name"=>"browser_estado_ocupacion", "operator"=>"like","fields"=>array("ESTADO_OCUPACION")),
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("TITULAR","RESPONSABL","EMAIL","SECCION","SEPULTURA","ESTADO_OCUPACION")),
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
                array("field"=>"LOCALIDAD","format"=>"text"),
                array("field"=>"COD_POSTAL","format"=>"text"),
                array("field"=>"TELEFONO","format"=>"text"),
                array("field"=>"EMAIL","format"=>"text"),

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
            $values["title"]="Lotes: Altas, Bajas, Consultas y Modificaciones";
            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"SECCION","format"=>"text"),
                array("field"=>"SEPULTURA","format"=>"text"),
                array("field"=>"TIPO","format"=>"text"),
                array("field"=>"TITULAR","format"=>"text"),
                array("field"=>"DIRECCION","format"=>"text"),
                array("field"=>"LOCALIDAD","format"=>"text"),
                array("field"=>"COD_POSTAL","format"=>"text"),
                array("field"=>"TELEFONO","format"=>"text"),
                array("field"=>"EMAIL","format"=>"text"),
            );
            log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
            return parent::pdf($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function historial($values){
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
            log_message('error', 'cco-> pasando x edit de sac lotes!.');

            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;
            
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
                        'EMAIL_SEC' => $values["EMAIL_SEC"],

                        'RESPONSABL' => $values["RESPONSABL"],
                        'RES_DIRECC' => $values["RES_DIRECC"],
                        'RES_CODPOS' => $values["RES_CODPOS"],
                        'RES_LOCALI' => $values["RES_LOCALI"],
                        'RES_TELEFO' => $values["RES_TELEFO"],
                        'RES_EMAIL' => $values["RES_EMAIL"],
                        'RES_EMAIL_SEC' => $values["RES_EMAIL_SEC"],

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
                log_message('error', 'cco-> pasando x save de sac lotes: titulo-->'.$values["estado_ocupacion"].'<--!.');
                log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
                if($fields==null) {
                    $fields = array(
                        'SECCION' => $values["SECCION"],
                        'SEPULTURA' => $values["SEPULTURA"],
                        'SECTOR' => $values["SECTOR"],
                        'TIPO' => $values["TIPO"],
                        
                        'ESTADO_OCUPACION' => $values["estado_ocupacion"],

                        'id_forma_pago' => secureEmptyNull($values,"id_forma_pago"),
                        'numero_tarjeta' => $values["numero_tarjeta"],

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
