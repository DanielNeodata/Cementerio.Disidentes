<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_facturacion_recibos extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    

    public function GetEstadisticasGenerales($values){
	    try {
	        log_message('error', 'cco-> pasando x GetEstadisticasGenerales de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetEstadisticasGenerales de rubos VIEW es:->'.$values["view"]."<-");

            if ($values["RECALCULA"]=="S")
            {
                log_message('error', 'cco-> pasando x GetEstadisticasGenerales RECALCULA SI');
                //$query = $this->db->query("select * from SAC_Enca");
                //$error = $this->db->_error_number().': '.$this->db->_error_message();
                $recno1 = $this->execAdHocAsArray("sp_GenerarEstadisticasLotes");
                log_message('error', 'cco-> pasando x GetEstadisticasGenerales exec: '.$recno1[0]["RunStatus"]);
            }

            $sql="";

            if ($values["DETALLADO"]=="S")
            {
               $sql = " select t.[BIMESTRE],t.[CANTIDAD],t.[IMPORTE],t.[PORCENT1],t.[PORCENT2],l.SECCION,l.SEPULTURA,l.TITULAR,l.IMPORTE as IMPORTEDETALLE ";
               $sql = $sql.= "from [SAC_EstaTemp] t left join SAC_EstaLote l on (t.BIMESTRE=l.BIMESTRE) where t.BIMESTRE<=".$values["HASTA"]." and t.BIMESTRE>=".$values["DESDE"]." ORDER BY BIMESTRE";
            }
            else
            {
               $sql = " select t.[BIMESTRE],t.[CANTIDAD],t.[IMPORTE],t.[PORCENT1],t.[PORCENT2] ";
               $sql = $sql.= "from [SAC_EstaTemp] t  where t.BIMESTRE<=".$values["HASTA"]." and t.BIMESTRE>=".$values["DESDE"]." ORDER BY BIMESTRE";
            }

            /*cuenta totoales...*/
            $recno = $this->execAdHocAsArray("select ISNULL(count(SECCION),0) as RECTOT from SAC_Lotes");
            $totsecc = $recno[0]["RECTOT"];

            $recno = $this->execAdHocAsArray("select ISNULL(count(BIMESTRE),0) as RECTOT from SAC_EstaLote");
            $totbim = $recno[0]["RECTOT"];


            log_message('error', 'tot secc: '.$totsecc.' tot bim '.$totbim);

            log_message('error', 'cco-> pasando x GetEstadisticasGenerales de rubos VIEW es:->'.$sql."<-");

            $estadistica = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetEstadisticasGenerales de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "totsecc"=>$totsecc,
                "totbim"=>$totbim,
                "estadistica"=>$estadistica,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetArrendamientosXFecha($values){
	    try {
	        log_message('error', 'cco-> pasando x GetArrendamientosXFecha de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetArrendamientosXFecha de rubos VIEW es:->'.$values["view"]."<-");

            
            $sql = "  SELECT M.*,Convert(nvarchar(10), M.FECHA_EMIS, 103) as FECHA_EMIS_SPA, E.RESPONSABL FROM SAC_Movimientos As M INNER JOIN SAC_Enca As E ON M.NRO_RECIBO=E.NRO_RECIBO ";
            $sql = $sql." WHERE M.OPERACION = 'AL' And ";
	        $sql = $sql." M.FECHA_EMIS BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}";
                //M.FECHA_EMIS BETWEEN {d '" + FECHA_DESDE.ToString("yyyy-MM-dd") + "'} AND {d '" + FECHA_HASTA.ToString("yyyy-MM-dd") + "'}

            //$sql = $sql." FROM [CON_Rubros] As R1 WHERE (R1.NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."') ORDER BY R1.NUMERO";

            log_message('error', 'cco-> pasando x GetArrendamientosXFecha de rubos VIEW es:->'.$sql."<-");

            $arrendamientos = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetArrendamientosXFecha de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "arrendamientos"=>$arrendamientos,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetRenocacionesXFecha($values){
	    try {
	        log_message('error', 'cco-> pasando x GetRenocacionesXFecha de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetRenocacionesXFecha de rubos VIEW es:->'.$values["view"]."<-");

            
            $sql = "  SELECT M.*,Convert(nvarchar(10), M.FECHA_EMIS, 103) as FECHA_EMIS_SPA, E.RESPONSABL FROM SAC_Movimientos As M INNER JOIN SAC_Enca As E ON M.NRO_RECIBO=E.NRO_RECIBO ";
            $sql = $sql." WHERE M.OPERACION = 'RN' And ";
	        $sql = $sql." M.FECHA_EMIS BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}";
                //M.FECHA_EMIS BETWEEN {d '" + FECHA_DESDE.ToString("yyyy-MM-dd") + "'} AND {d '" + FECHA_HASTA.ToString("yyyy-MM-dd") + "'}

            //$sql = $sql." FROM [CON_Rubros] As R1 WHERE (R1.NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."') ORDER BY R1.NUMERO";

            log_message('error', 'cco-> pasando x GetRenocacionesXFecha de rubos VIEW es:->'.$sql."<-");

            $renovaciones = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetRenocacionesXFecha de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "renovaciones"=>$renovaciones,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function ReciptSearchLote($values){
	    try {
	        log_message('error', 'cco-> pasando x ReciptSearchLote de recibos init!.');
	        logGeneral($this,$values,__METHOD__);
	        log_message('error', 'cco-> pasando x ReciptSearchLote de recibos desp log general.');
	        if (isset($values["view"])){$this->view=$values["view"];}
	        log_message('error', 'cco-> pasando x ReciptSearchLote de recibos VIEW es:->'.$values["view"]."<-");
            log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));

	        $values["view"]="vw_SacLotes";
	        $values["order"]=$values["Orden"]." ASC";
	        //$values["page"]=-1;
	        $values["pagesize"]=-1;

            $filtro="";

            if ($values["Seccion"]!="" && $values["Seccion"]>=0)
            {
                $filtro = " ltrim(rtrim(SECCION)) LIKE '".$values["Seccion"]."'";
            }

            if ($values["Sepultura"]!="" && $values["Sepultura"]>=0)
            {
                if ($filtro!="")
                {
                    $filtro = $filtro." and ltrim(rtrim(SEPULTURA)) LIKE '".$values["Sepultura"]."'";
                } else {
                    $filtro = " ltrim(rtrim(SEPULTURA)) LIKE '".$values["Sepultura"]."'";
                }
            }

            if ($values["Titular"]!="" && $values["Titular"]>=0)
            {
                if ($filtro!="")
                {
                    $filtro = $filtro." and TITULAR LIKE '%".$values["Titular"]."%'";
                } else {
                    $filtro = " TITULAR LIKE '%".$values["Titular"]."%'";
                }
            }

            if ($values["Responsable"]!="" && $values["Responsable"]>=0)
            {
                if ($filtro!="")
                {
                    $filtro = $filtro." and RESPONSABL LIKE '%".$values["Responsable"]."%'";
                } else {
                    $filtro = " RESPONSABL LIKE '%".$values["Responsable"]."%'";
                }
            }

            $values["where"]=$filtro;


	        log_message('error', 'cco-> pasando x getReciptDetail de  recibos ver where->'.$filtro."<-");

            //$conceptos = $this->execAdHocAsArray("select * from SAC_Operaciones order by ID");

            

	        $data=$this->get($values);
	        log_message('error', 'cco-> pasando x getReciptDetail de  recibos entre getrecords y return array! Cantidad filas:'.$data["totalrecords"]."<-------");
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                //"conceptos"=>$conceptos,
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

    public function ReciptSearchLoteFallecidos($values){
	    try {
	        log_message('error', 'cco-> pasando x ReciptSearchLoteFallecidos de recibos init!.');
	        logGeneral($this,$values,__METHOD__);
	        //log_message('error', 'cco-> pasando x ReciptSearchLoteFallecidos de recibos desp log general.');
	        if (isset($values["view"])){$this->view=$values["view"];}
	        //log_message('error', 'cco-> pasando x ReciptSearchLoteFallecidos de recibos VIEW es:->'.$values["view"]."<-");
            //log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));

	        $values["view"]="vw_SacFallecidos";
	        $values["order"]=$values["Orden"]." ASC";
	        //$values["page"]=-1;
	        $values["pagesize"]=-1;

            $filtro="";

            if ($values["Seccion"]!="" && $values["Seccion"]>=0)
            {
                $filtro = " ltrim(rtrim(SECCION)) LIKE '".$values["Seccion"]."'";
            }

            if ($values["Sepultura"]!="" && $values["Sepultura"]>=0)
            {
                if ($filtro!="")
                {
                    $filtro = $filtro." and ltrim(rtrim(SEPULTURA)) LIKE '".$values["Sepultura"]."'";
                } else {
                    $filtro = " ltrim(rtrim(SEPULTURA)) LIKE '".$values["Sepultura"]."'";
                }
            }

            if ($values["Nombre"]!="" && $values["Nombre"]>=0)
            {
                if ($filtro!="")
                {
                    $filtro = $filtro." and NOMBRE LIKE '%".$values["Nombre"]."%'";
                } else {
                    $filtro = " NOMBRE LIKE '%".$values["Nombre"]."%'";
                }
            }


            $values["where"]=$filtro;


	        log_message('error', 'cco-> pasando x ReciptSearchLoteFallecidos de  recibos ver where->'.$filtro."<-");

            //$conceptos = $this->execAdHocAsArray("select * from SAC_Operaciones order by ID");

            

	        $data=$this->get($values);
	        log_message('error', 'cco-> pasando x ReciptSearchLoteFallecidos de  recibos entre getrecords y return array! Cantidad filas:'.$data["totalrecords"]."<-------");
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                //"conceptos"=>$conceptos,
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

	public function getReciptDetail($values){
	    try {
	        log_message('error', 'cco-> pasando x getReciptDetail de recibos init!.');
	        logGeneral($this,$values,__METHOD__);
	        log_message('error', 'cco-> pasando x getReciptDetail de recibos desp log general.');
	        if (isset($values["view"])){$this->view=$values["view"];}
	        log_message('error', 'cco-> pasando x getReciptDetail de recibos VIEW es:->'.$values["view"]."<-");

	        $values["view"]="SAC_Movimientos";
	        $values["order"]="1 ASC";
	        //$values["page"]=-1;
	        $values["pagesize"]=-1;
            if ($values["txtNroRecibo"]=="" || $values["txtNroRecibo"]==0)
            {
	            $values["where"]="NRO_RECIBO = -1";
            }
            else
            {
                $values["where"]="NRO_RECIBO = ".$values["txtNroRecibo"];
            }


	        log_message('error', 'cco-> pasando x getReciptDetail de  recibos ver vars->'.$values["txtNroRecibo"]."<-");

            $conceptos = $this->execAdHocAsArray("select * from SAC_Operaciones union all select 5,'TEI','Traslado Interno' order by Id");
            $precios = $this->execAdHocAsArray("select * from SAC_Servicio");
            
            $cotizacion = $this->execAdHocAsArray("select COTIZACION, ID from SAC_Cotizaciones group by COTIZACION, ID having ID=MAX(ID)");

            log_message("error", "ARRAY CONCEPTOS ".json_encode($conceptos,JSON_PRETTY_PRINT));

	        $data=$this->get($values);
	        log_message('error', 'cco-> pasando x getReciptDetail de  recibos entre getrecords y return array! Cantidad filas:'.$data["totalrecords"]."<-------");
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "conceptos"=>$conceptos,
                "cotizacion"=>$cotizacion,
                "precios"=>$precios,
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


    	public function getRecipt($values){
	    try {
	        log_message('error', 'cco-> pasando x getRecipt de recibos init!.');
	        logGeneral($this,$values,__METHOD__);
	        log_message('error', 'cco-> pasando x getRecipt de recibos desp log general.');
	        
            log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));

            if (isset($values["view"])){$this->view=$values["view"];}
	        
            log_message('error', 'cco-> pasando x getRecipt de recibos VIEW es:->'.$values["view"]."<-");

	        $values["view"]="vw_SacRecibos";
	        $values["order"]="1 ASC";
	        //$values["page"]=-1;
	        $values["pagesize"]=-1;
            if ($values["NRORECIBO"]=="" || $values["NRORECIBO"]==0)
            {
	            $values["where"]="NRO_RECIBO = -1";
            }
            else
            {
                $values["where"]="NRO_RECIBO = ".$values["NRORECIBO"];
            }


	        log_message('error', 'cco-> pasando x getRecipt de  recibos ver vars->'.$values["NRORECIBO"]."<-");

            $movimientos = $this->execAdHocAsArray("select * from SAC_Movimientos where NRO_RECIBO=".$values["NRORECIBO"]);

            //log_message("error", "ARRAY CONCEPTOS ".json_encode($conceptos,JSON_PRETTY_PRINT));

	        $data=$this->get($values);

	        log_message('error', 'cco-> pasando x getRecipt de  recibos entre getrecords y return array! Cantidad filas:'.$data["totalrecords"]."<-------");
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "movimientos"=>$movimientos,
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

    public function delete($values){
        try {
            log_message('error', 'cco-> pasando x delete fr recibos!.');
			try
			{
                log_message('error', 'cco-> borrando detalle recibo->'.$values["id"]);
				//foreach ($values as $key => $child) {
				//    log_message('error', 'cco-> borrando detalle recibo valores en: '.$key." <--> ".$child." <-");
				//    //if (is_array($child)) {
				//    //  $newArray =& array_flatten($child, $preserve_keys, $newArray);
				//    //} elseif ($preserve_keys + is_string($key) > 1) {
				//    //  $newArray[$key] = $child;
				//    //} else {
				//    //  $newArray[] = $child;
				//    //}
				//}
                $values["view"]="vw_SacRecibos";
                $values["where"]=("id=".$values["id"]);
                $info=$this->get($values);
                $val=$info["data"][0]["NRO_RECIBO"];
                log_message('error', 'cco-> borrando detalle recibo valores en NRO_RECIBO->'.$val);                         
                    

                log_message("error", "ARRAY ".json_encode($values,JSON_PRETTY_PRINT));


				$this->db->where('NRO_RECIBO', $val);
				$this->db->delete('SAC_Movimientos');

				$this->db->where('NRO_RECIBO', $val);
				$this->db->delete('SAC_Enca');
			}
			catch(Exception $ee){
			    return logError($ee,__METHOD__ );
			    throw $del;
			}   

            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>lang('msg_delete'),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null
                );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function brow($values){
        try {
            log_message('error', 'cco-> pasando x brow de sac lotes init!.');
            logGeneral($this,$values,__METHOD__);
            $values["view"]="vw_SacRecibos";
            $values["order"]="1 DESC";
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
                //array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"FECHA_EMIS","format"=>"date"),
                array("field"=>"NRO_RECIBO","format"=>"text"),
                array("field"=>"RESPONSABL","format"=>"text"),
                
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

            $values["controls"]=array(
                "<label>".lang('p_NRO_RECIBO')."</label><input type='number' id='browser_nro_recibo' name='browser_nro_recibo' class='form-control number'/>",
                
            );

            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("RESPONSABL")),
                array("name"=>"browser_nro_recibo", "operator"=>"=","fields"=>array("NRO_RECIBO")),
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
            $values["view"]="vw_SacRecibos";
            $values["delimiter"]=";";
            $values["pagesize"]=-1;
            //$values["order"]=" description ASC";
            $values["records"]=$this->get($values);

            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"FECHA_EMIS","format"=>"date"),
                array("field"=>"NRO_RECIBO","format"=>"text"),
                array("field"=>"RESPONSABL","format"=>"text"),

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
            $values["view"]="vw_SacRecibos";
            $values["pagesize"]=-1;
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);
            $values["title"]="Lotes: Altas, Bajas, Consultas y Modificaciones";
            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
                array("field"=>"FECHA_EMIS","format"=>"date"),
                array("field"=>"NRO_RECIBO","format"=>"text"),
                array("field"=>"RESPONSABL","format"=>"text"),
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
            log_message('error', 'cco-> pasando x edit de RECIBOS!.');
            log_message("error", "Values ARRAY edit recibos: ".json_encode($values,JSON_PRETTY_PRINT));
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;

            //si el recibo NO es cero, no dejo modificar!!!! la edición del recibo es readonly solo para ver            
            if ($values["id"]>0)
            {
                $values["readonly"]=true;
            }
            else
            {
                $values["accept-class-name"]="btn-abm-accept-receipt";
            }


            $values["view"]="vw_SacRecibos";
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
            $values["controls"]=array(
                "id_forma_pago"=>getCombo($parameters_id_forma_pago,$this),
            );
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de RECIBOS!.');
        log_message("error", "ARRAY ".json_encode($values,JSON_PRETTY_PRINT));
        log_message("error", "count: ".$values["OPER-COUNTER"]);
        log_message("error", "tot: ".$values["TOTAL-1"]);

        $values["view"]="SAC_Enca";

		try {
		    if (!isset($values["id"])){$values["id"]=0;}
		    $id=(int)$values["id"];

            $recno = $this->execAdHocAsArray("select ISNULL(MAX(NRO_RECIBO)+1,1) as RECNO from SAC_Enca");
            $recibo = $recno[0]["RECNO"];
            log_message("error", "recno: ".$recibo);
            
            $counter = $values["OPER-COUNTER"];
            $ultSecc="";
            $ultSep="";
            
            log_message("error", "ID v0: ".$id);
		    if($id==0){
		        if($fields==null) {
		            $fields = array(
		                'FECHA_EMIS' => $values["FECHA_EMIS"],
		                'RESPONSABL' => $values["RESPONSABL"],
		                'PESOS' => $values["PESOS"],
		                'DOLARES' => $values["DOLARES"],
		                'COTIZACION' => $values["COTIZACION"],
		                'CHEQUE' => $values["CHEQUE"],
		                'BANCO' => $values["BANCO"],
		                'TARJETA' => $values["TARJETA"],
		                'TARJDATO' => $values["TARJDATO"],
                        'RENGLONES' => $counter,
		                'TRANSFERENCIA' => $values["TRANSFERENCIA"],
		                'NRO_RECIBO' => $recibo,
		            );
		        }
		    }
            $id=$this->saveRecord($fields,$id,"Sac_Enca");
            $reciboId = $id;
            log_message("error", "tot: ".$values["TOTAL-1"]);
            log_message("error", "ID: ".$id);
            

            for ($i = 1; $i <= $counter; $i++) {
                log_message("error", "inside for i=".$i);
                //(NRO_RECIBO, FECHA_EMIS, OPERACION, SECCION, SEPULTURA, CONCEPTO, IMPORTE
                $oper = $values["detail-op-".$i];
                $secc = $values["detail-secc-".$i];
                $sep = $values["detail-sep-".$i];
                $imp = $values["detail-imp-".$i];
                $con = $values["detail-con-".$i];

                log_message("error", "inside for secc: ".$secc." sep: ".$sep." oper: ".$oper." imp: ".$imp." con: ".$con);

                if ($secc!="" && $sep!="")
                {
                    $ultSep = trim($sep);
                    $ultSecc= trim($secc);
                    /*para los pago a cuenta guardo el ultimo par de seccion y sepultura para poner el nro del recibo en el lote*/
                    log_message("error", "inside for set ultimo para pago a cuenta secc: ".$ultSecc." sep: ".$ultSep);
                    
                }

                if ($oper=="PC")
                {
                    /*si es pc le pongo los datos del lote asociado si es que hay alguno....*/
                    $sep = $ultSep;
                    $secc=$ultSecc;
                }

                $fields1=null;
                if($fields1==null) {
		            $fields1 = array(
		                'FECHA_EMIS' => $values["FECHA_EMIS"],
		                'NRO_RECIBO' => $recibo,
		                'OPERACION' => $oper,
		                'SECCION' => $secc,
		                'SEPULTURA' => $sep,
		                'CONCEPTO' => $con,
		                'IMPORTE' => $imp,
		            );
		        }
                $id2=0;
                $id2=$this->saveRecord($fields1,$id2,"Sac_Movimientos");
                log_message("error", "ID2: ".$id2);

                if (($oper=="IN") || ($oper=="TE"))
                {
                    $nom = $values["detail-nom-".$i];
                    $tipo = $values["detail-tipo-".$i];
                    $aper = $values["detail-aper-".$i];
                    $edad = $values["detail-edad-".$i];
                    $estadoCivil = $values["detail-ec-".$i];
                    $nacionalidad = $values["detail-nac-".$i];
                    $causa = $values["detail-causa-".$i];
                    $partida = $values["detail-partida-".$i];
                    $fecd = $values["detail-fecd-".$i];
                    $hora = $values["detail-hora-".$i];
                    $dni = $values["detail-dni-".$i];
                    $empresa = $values["detail-empresa-".$i];

                    $fields2=null;
                    if($fields2==null) {
		                $fields2 = array(
                        //SECCION, SEPULTURA, TIPO, NRO_APERTU, NOMBRE, EDAD, ESTADOCIVI, NACIONALID, CAUSADECES, PARTIDA, FECHA, HORA, EMPR_FUNEB)
		                    'SECCION' => $secc,
		                    'SEPULTURA' => $sep,
		                    'TIPO' => $tipo,
		                    'NRO_APERTU' => $aper,
		                    'NOMBRE' => $nom,
		                    'EDAD' => $edad,
		                    'ESTADOCIVI' => $estadoCivil,
                            'NACIONALID' => $nacionalidad,
                            'CAUSADECES' => $causa,
                            'PARTIDA' => $partida,
                            'FECHA' => $fecd,
                            'HORA' => $hora,
                            'DNI' => $dni,
                            'EMPR_FUNEB' => $empresa,
		                );
		            }
                    $id3=0;
                    $id3=$this->saveRecord($fields2,$id3,"SAC_Fallecidos");
                    log_message("error", "ID3: ".$id3);

                }
                else if ($oper="AL")
                {
                    $loteid = $values["detail-lote-".$i];
                    $titDireccion = $values["detail-titDireccion-".$i];
                    $titular = $values["detail-titular-".$i];
                    $titLocalidad = $values["detail-titLocalidad-".$i];
                    $titCP = $values["detail-titCP-".$i];
                    $titTel = $values["detail-titTel-".$i];
                    $titMail = $values["detail-titMail-".$i];
                    $responsable = $values["detail-responsable-".$i];
                    $resDireccion = $values["detail-resDireccion-".$i];
                    $resLocalidad = $values["detail-resLocalidad-".$i];
                    $resCP = $values["detail-resCP-".$i];
                    $resTel = $values["detail-resTel-".$i];
                    $resMail = $values["detail-resMail-".$i];
                    $nroTitulo = $values["detail-nroTitulo-".$i];
                    $precio = $values["detail-precio-".$i];
                    $ultbim = $values["detail-ultbim-".$i];
                    $deuda = $values["detail-deuda-".$i];
                    $titulo = $values["detail-titulo-".$i];
                    $reglamento = $values["detail-reglamento-".$i];
                    $duracion = $values["detail-duracion-".$i];
                    $tipo1 = $values["detail-tipo-".$i];

                    $fieldsal=null;
                    if($fieldsal==null) {
		                $fieldsal = array(
                        //SECCION, SEPULTURA, TIPO, NRO_APERTU, NOMBRE, EDAD, ESTADOCIVI, NACIONALID, CAUSADECES, PARTIDA, FECHA, HORA, EMPR_FUNEB)
		                    'TIPO' => $tipo1,
		                    'TITULAR' => $titular,
		                    'DIRECCION' => $titDireccion,
		                    'COD_POSTAL' => $titCP,
		                    'LOCALIDAD' => $titLocalidad,
		                    'TELEFONO' => $titTel,
		                    'EMAIL' => $titMail,
                            'RESPONSABL' => $responsable,
                            'RES_DIRECC' => $resDireccion,
                            'RES_CODPOS' => $resCP,
                            'RES_LOCALI' => $resLocalidad,
                            'RES_TELEFO' => $resTel,
                            'RES_EMAIL' => $resMail,
                            'NROTITULO' => $nroTitulo,
                            'FECHACOMPR' => $values["FECHA_EMIS"],
                            'PRECICOMPR' => $precio,
                            'ANOSARREND' => $duracion,
                            'ULT_RENOVA' => $values["FECHA_EMIS"],
                            'ANOSRENOVA' => $duracion,
                            'ULTBIMPAGO' => $ultbim,
                            'DEUDA' => $deuda,
                            'TITULO' => $titulo,
                            'REGLAMENTO' => $reglamento,
                            'ESTADO_OCUPACION' => "ARREN",
		                );
		            }
                    $idal=0;
                    $idal=$this->saveRecord($fieldsal,$loteid,"SAC_Lotes");
                    log_message("error", "ID AL: ".$idal);

                    /*
                    if (!_in.class_database.Execute(ref _transaction, _local_database,
                                            "UPDATE SAC_Lotes SET " +
                                            "TIPO="        + StringOrNull(Session["cboArrTip"]) + ", " +
                                            "TITULAR="     + StringOrNull(Session["txtArrTit"]) + ", " +
                                            "DIRECCION="   + StringOrNull(Session["txtArrDiT"]) + ", " +
                                            "COD_POSTAL="  + StringOrNull(Session["txtArrCpT"]) + ", " +
                                            "LOCALIDAD="   + StringOrNull(Session["txtArrLoT"]) + ", " +
                                            "TELEFONO="    + StringOrNull(Session["txtArrTeT"]) + ", " +
                                            "EMAIL="       + StringOrNull(Session["txtArrEmT"]) + ", " +
                                            "RESPONSABL="  + StringOrNull(Session["txtArrRes"]) + ", " +
                                            "RES_DIRECC="  + StringOrNull(Session["txtArrDiR"]) + ", " +
                                            "RES_CODPOS="  + StringOrNull(Session["txtArrCpR"]) + ", " +
                                            "RES_LOCALI="  + StringOrNull(Session["txtArrLoR"]) + ", " +
                                            "RES_TELEFO="  + StringOrNull(Session["txtArrTeR"]) + ", " +
                                            "RES_EMAIL="   + StringOrNull(Session["txtArrEmR"]) + ", " +
                                            "NROTITULO="   + StringOrNull(Session["txtArrNro"]) + ", " +
                                            "FECHACOMPR="  + DateOrNull(Page.Request.Form["FECHA_EMIS"]) + ", " +
                                            "PRECICOMPR="  + DecimalOrNull(row[7]) + ", " +
                                            "ANOSARREND="  + IntOrNull(row[6]) + ", " +
                                            "ULT_RENOVA="  + DateOrNull(Page.Request.Form["FECHA_EMIS"]) + ", " +
                                            "ANOSRENOVA="  + IntOrNull(row[6]) + ", " +
                                            "ULTBIMPAGO="  + DateOrNull(Session["wdcArrUbp"]) + ", " +
                                            "DEUDA="       + DecimalOrNull(Session["txtArrDeu"]) + ", " +
                                            "TITULO="      + StringOrNull(Session["rblArrTlo"]) + "," +
                                            "REGLAMENTO="  + StringOrNull(Session["rblArrReg"]) + " " +
                                            "WHERE (SECCION='"   + row[1] + "') AND " +
                                                  "(SEPULTURA='" + row[2] + "');",
                    */
                }
                else if ($oper=="TI" && strpos($con, "Translado Interno")>=0)
                {
                        $loteid = $values["detail-lote-".$i];
                        $secc2 = $values["detail-secc2-".$i];
                        $sep2 = $values["detail-sep2-".$i];
                        $aper2 = $values["detail-aper-".$i];
                        // Guardar nueva info de lote en fallecido
                        //$qry = "UPDATE SAC_Fallecidos SET SECCION='".$secc2."', SEPULTURA='".$sep2."', NRO_APERTU=".$aper." WHERE (ID=".$loteid.");"
                        $fields3=null;
                        if($fields3==null) {
		                    $fields3 = array(
                            //SECCION, SEPULTURA, TIPO, NRO_APERTU, NOMBRE, EDAD, ESTADOCIVI, NACIONALID, CAUSADECES, PARTIDA, FECHA, HORA, EMPR_FUNEB)
		                        'SECCION' => $secc2,
		                        'SEPULTURA' => $sep2,
		                        'NRO_APERTU' => $aper2,
		                    );
		                }
                    
                        $id4=$this->saveRecord($fields3,$loteid,"SAC_Fallecidos");
                        log_message("error", "ID4: ".$id4);                 
                }                               
                else if ($oper=="CO")
                {
                
                        // Guardar nueva info de lote en fallecido
                        //$qry = "UPDATE SAC_Fallecidos SET SECCION='".$secc2."', SEPULTURA='".$sep2."', NRO_APERTU=".$aper." WHERE (ID=".$loteid.");"
                        $ultbim = $values["detail-ultbim-".$i];
                        $loteid = $values["detail-lote-".$i];
                        $fields3=null;
                        if($fields3==null) {
		                    $fields3 = array(
                            
		                        'ULTBIMPAGO' => $ultbim,
		                    );
		                }
                    
                        $id4=$this->saveRecord($fields3,$loteid,"SAC_Lotes");
                        log_message("error", "ID5: ".$id4);                 
                }
                else if ($oper=="RN")
                {
                        /*ver de poner en null si la fecha ult renova es vacia*/											
                        $duracion = $values["detail-duracion-".$i];
                        $vto = $values["detail-vto-".$i];

                        if ($vto=="undefined"){$vto=null;}

                        $ultren = $values["detail-ultren-".$i];

                        if ($ultren=="undefined"){$ultren=null;}

                        $loteid = $values["detail-lote-".$i];
                        $fields3=null;
                        if($fields3==null) {
		                    $fields3 = array(
                            
		                        'ULT_RENOVA' => $ultren,
                                'ANOSRENOVA' => $duracion,
                                'VENCIMIENTO' => $vto,
		                    );
		                }
                    
                        $id4=$this->saveRecord($fields3,$loteid,"SAC_Lotes");
                        log_message("error", "ID5: ".$id4);        
                }
                else if ($oper=="PC")
                {
                     $imppc = $values["detail-imp-".$i];
                     $acuenta=$recibo;
                     if ($imppc<0){$acuenta=0;}

                     $lotereg = $this->execAdHocAsArray("select ID from SAC_Lotes where SECCION = '".$ultSecc."' and SEPULTURA='".$ultSep."'");
                     $lotepc = $lotereg[0]["ID"];
                     log_message("error", "Lote para actualizar PC: ".$lotepc); 
                     log_message("error", "qry: select ID from SAC_Lotes where SECCION = '".$ultSecc."' and SEPULTURA='".$ultSep."'"); 

                     $fields6=null;
                        if($fields6==null) {
		                    $fields6 = array(
                            
		                        'ACUENTA' => $acuenta,
		                    );
		                }
                    
                        $id7=$this->saveRecord($fields6,$lotepc,"SAC_Lotes");
                        log_message("error", "ID7: ".$id7);                 
                }
                else if ($oper="RD")
                {
                    $loteid = $values["detail-lote-".$i];
                     $fields6=null;
                        if($fields6==null) {
		                    $fields6 = array(
                            
		                        'TIPO' => 'UR',
                                'NRO_APERTU' => '0',
		                    );
		                }
                    
                        $id7=$this->saveRecord($fields6,$loteid,"SAC_Fallecidos");
                        log_message("error", "ID7: ".$id7);              
                }
            }

            $data=array("id"=>$id);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>$message,
                "recibo"=>$recibo,
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
