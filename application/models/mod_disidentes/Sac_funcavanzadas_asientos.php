<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_funcavanzadas_asientos extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }



	public function getAsientoDetail($values){
	    try {
	        log_message('error', 'cco-> pasando x getAsientoDetail de recibos init!.');
	        logGeneral($this,$values,__METHOD__);
	        log_message('error', 'cco-> pasando x getAsientoDetail de recibos desp log general.');
	        if (isset($values["view"])){$this->view=$values["view"];}
	        log_message('error', 'cco-> pasando x getAsientoDetail de recibos VIEW es:->'.$values["view"]."<-");

            $numasiento = $values["txtNro"];

	        log_message('error', 'cco-> pasando x getAsientoDetail de  recibos ver vars->'.$values["txtNro"]."<-");

            $detalle = $this->execAdHocAsArray("SELECT R.RENGLON,R.COMENTARIO,R.ID,CASE when IMPORTE>0 then 'D' else 'H' end as DH,R.CUENTA, C.NOMBRE, R.TIPCOM, R.NUMCOM, R.IMPORTE, R.COMENTARIO FROM CON_Renglones As R INNER JOIN CON_Cuentas As C ON R.CUENTA=C.NUMERO INNER JOIN CON_Encabezados E on R.idEncabezado=E.ID WHERE E.NUMERO='".$numasiento."' ORDER BY R.RENGLON;");

            $cuentas = $this->execAdHocAsArray("SELECT NUMERO, NUMERO + ' - ' + NOMBRE As qryDEN FROM [CON_Cuentas] ORDER BY NUMERO");

            $debehaber = $this->execAdHocAsArray("(SELECT 1 As COD, 'Debe'  As DEN) UNION (SELECT 2 As COD, 'Haber' As DEN)");

            log_message("error", "ARRAY CONCEPTOS ".json_encode($detalle,JSON_PRETTY_PRINT));

            	        
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "detalle"=>$detalle,
                "debehaber"=>$debehaber,
                "cuentas"=>$cuentas,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}


    	
    public function delete($values){
		try {
		    log_message('error', 'cco-> pasando x delete fr asientos!.');
		    try
		    {
		        log_message('error', 'cco-> borrando detalle asientos->'.$values["id"]);
		       

                $recno1 = $this->execAdHocAsArray("sp_deleteAsiento ".$values["id"]);

				
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
            log_message('error', 'cco-> pasando x brow de sac asientos init!.');
            logGeneral($this,$values,__METHOD__);
            $values["view"]="vw_ConEncabezados";
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
                array("field"=>"NUMERO_ENCABEZADO","format"=>"text"),
                array("field"=>"FECHA","format"=>"date"),
                array("field"=>"RENGLONES","format"=>"text"),
                array("field"=>"COMENTARIO","format"=>"text"),

                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

            $values["controls"]=array(
                "<label>".lang('p_NUMERO_ENCABEZADO')."</label><input type='text' id='browser_numero_encabezado' name='browser_numero_encabezado' class='form-control text'/>",
                "<label>".lang('p_FECHA')."</label><input type='date' id='browser_fecha' name='browser_fecha' class='form-control date'/>",

            );

            $values["filters"]=array(
                array("name"=>"browser_fecha", "operator"=>"=","fields"=>array("FECHA")),
                array("name"=>"browser_numero_encabezado", "operator"=>"like","fields"=>array("NUMERO_ENCABEZADO")),
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("NUMERO_ENCABEZADO","COMENTARIO","FECHA")),

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
                array("field"=>"NUMERO_ENCABEZADO","format"=>"text"),
                array("field"=>"FECHA","format"=>"date"),
                array("field"=>"COMENTARIO","format"=>"text"),

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
            $values["title"]="Asientos: Altas, Bajas, Consultas y Modificaciones";
            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
               array("field"=>"NUMERO_ENCABEZADO","format"=>"text"),
                array("field"=>"FECHA","format"=>"date"),
                array("field"=>"COMENTARIO","format"=>"text"),
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
            log_message('error', 'cco-> pasando x edit de RECIBOS!.');
            log_message("error", "Values ARRAY edit recibos: ".json_encode($values,JSON_PRETTY_PRINT));
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;

            //si el recibo NO es cero, no dejo modificar!!!! la edición del recibo es readonly solo para ver
			//if ($values["id"]>0)
			//{
			//    $values["readonly"]=true;
			//}
			//else
			//{
			//    $values["accept-class-name"]="btn-abm-accept-receipt";
			//}


            $values["view"]="vw_ConEncabezados";
            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);

            //log_message("error", "RECORDS ".json_encode($values["records"],JSON_PRETTY_PRINT));
			//$parameters_id_forma_pago=array(
			//    "model"=>(MOD_DISIDENTES."/Tipo_forma_pago"),
			//    "table"=>"tipo_forma_pago",
			//    "name"=>"id_forma_pago",
			//    "class"=>"form-control dbase",
			//    "empty"=>true,
			//    "id_actual"=>secureComboPosition($values["records"],"id_forma_pago"),
			//    "id_field"=>"id",
			//    "description_field"=>"descripcion",
			//    "get"=>array("order"=>"descripcion ASC","pagesize"=>-1),
			//);
			//$values["controls"]=array(
			//    "id_forma_pago"=>getCombo($parameters_id_forma_pago,$this),
			//);
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de ASIENTOS!.');
        log_message("error", "ARRAY ".json_encode($values,JSON_PRETTY_PRINT));
        log_message("error", "count: ".$values["OPER-COUNTER"]);
        log_message("error", "tot: ".$values["TOTAL-1"]);

        $values["view"]="CON_ENCABEZADOS";

		try {
		    if (!isset($values["id"])){$values["id"]=0;}
		    $id=(int)$values["id"];


            log_message("error", "recno asiento: ".$asiento);

            $counter = $values["OPER-COUNTER"];

            log_message("error", "ID v0: ".$id);
		    if($id==0){
				$recno = $this->execAdHocAsArray("SELECT ISNULL(Max(convert(int,SUBSTRING(numero,3,LEN(numero)))),0)+1 As RECNO FROM CON_ENCABEZADOS  WHERE NUMERO like 'CE%'");
				$asiento = $recno[0]["RECNO"];
				$asiento = "CE".$asiento;

		        if($fields==null) {
		            $fields = array(
		                'FECHA' => $values["FECHA"],
		                'RENGLONES' => $values["OPER-COUNTER"],
		                'COMENTARIO' => $values["COMENTARIO"],
		                'XTRUDEADO' => "M",
		                'NUMERO' => $asiento,
		            );
		        }
		    
                $id=$this->saveRecord($fields,$id,"CON_ENCABEZADOS");
                $asientoId = $id;
            }
            else
            {
                log_message("error", "EN EDIT DE ASIENTO NO ES NEW ES SAVE EDIT: counter.>".$counter);

                $asiento = $values["NUMERO_ENCABEZADO"];
                $asientoId = $id;
                //borro lo que esta
                $recno1 = $this->execAdHocAsArray("sp_deleteAsientoRenglon ".$values["id"]);

                if($fields==null) {
		            $fields = array(
		                'FECHA' => $values["FECHA"],
		                'RENGLONES' => $values["OPER-COUNTER"],
		                'COMENTARIO' => $values["COMENTARIO"],
		                'XTRUDEADO' => "M",
		                'NUMERO' => $asiento,
		            );
		        }

                parent::save($values,$fields);

            }

             log_message("error", "tot: ".$values["TOTAL-1"]);
             log_message("error", "ID: ".$id);


			for ($i = 1; $i <= $counter; $i++) {
			    log_message("error", "inside for i=".$i);
			    //(ASIENTO, idEncabezado,renglon,fecha,ccuenta, tipcom,numcom,importe,comenario,ajuste
			    $cuenta = $values["detail-cuenta-".$i];
			    $tipcom = $values["detail-tipcom-".$i];
			    $numcom = $values["detail-numcom-".$i];
			    $imp = $values["detail-importe-".$i];
				$come = $values["detail-comentario-".$i];

			//    log_message("error", "inside for secc: ".$secc." sep: ".$sep." oper: ".$oper." imp: ".$imp." con: ".$con);

			    $fields1=null;
			    if($fields1==null) {
			        $fields1 = array(
			            'FECHA' => $values["FECHA"],
			            'idEncabezado' => $asientoId,
			            'ASIENTO' => $asiento,
			            'RENGLON' => $i,
			            'CUENTA' => $cuenta,
			            'TIPCOM' => $tipcom,
                        'NUMCOM' => $numcom,
			            'IMPORTE' => $imp,
                        'COMENTARIO' => $come,
			        );
			    }
			    $id2=0;
			    $id2=$this->saveRecord($fields1,$id2,"CON_Renglones");
			    log_message("error", "ID2: ".$id2);

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
