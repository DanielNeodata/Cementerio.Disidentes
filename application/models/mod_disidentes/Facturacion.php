<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Facturacion extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }


    public function ProcesarLotesParaRecibotarjetas($values){
	    try {
	        log_message('error', 'cco-> pasando x ProcesarLotesParaRecibotarjetas de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

            log_message("error", "FORM VALUES values ".json_encode($values,JSON_PRETTY_PRINT));

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x ProcesarLotesParaRecibotarjetas de rubos VIEW es:->'.$values["view"]."<-");

            log_message("error", "registros: ".$values["REG"]);
             
            $counter = $values["REG"];
            $anio = $values["ANIO"];
            $mes = $values["MES"];

             for ($i = 0; $i < $counter; $i++) {
              

                $id = $values["ID_".$i];
                $val =  $values["VAL_".$i];

                log_message('error', 'cco-> pasando x ProcesarLotesParaRecibotarjetas antes insertar id:->'.$id.'<- val->'.$val.'<- anio->'.$anio.'<- mes->'.$mes.'<- i->'.$i);

                $sql = "BEGIN TRANSACTION;EXEC dbo.sp_EXEC_Tarjeta_by_Lote ".$id.", ".$anio.",".$mes.",".$val.";COMMIT TRANSACTION;";
                
                log_message('error', 'cco-> pasando x ProcesarLotesParaRecibotarjetas SQL:->'.$sql);

                $preview = $this->execAdHocAsArray($sql);
                
                log_message('error', 'cco-> pasando x ProcesarLotesParaRecibotarjetas despues insertar id:->'.$id.'<- val->'.$val.'<- anio->'.$anio.'<- mes->'.$mes.'<- Preview->'.$preview);

             }


            //log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x ProcesarLotesParaRecibotarjetas de  rubos entre finalziadno! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    } catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}


     public function GetLotesParaRecibotarjetas($values){
	    try {
	        log_message('error', 'cco-> pasando x GetLotesParaRecibotarjetas de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetLotesParaRecibotarjetas de rubos VIEW es:->'.$values["view"]."<-");


            $sql="";

            $sql = "SELECT lt.* FROM dbo.vw_lotes_para_tarjetas as lt WHERE tarjeta='".$values["TARJETA"]."' AND id not in (SELECT clt.id_lote FROM dbo.control_lotes_tarjetas as clt WHERE clt.anio='".$values["ANIO"]."' AND clt.mes='".$values["MES"]."' AND clt.id_lote=lt.id) ORDER BY titular DESC";


            log_message('error', 'cco-> pasando x GetLotesParaRecibotarjetas de rubos VIEW es:->'.$sql."<-");

           $preview = $this->execAdHocAsArray($sql);


            //log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetLotesParaRecibotarjetas de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "preview"=>$preview,
                "emails"=>$emails,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    /*****************************************************************/

    public function GetNotificacionConservaciones($values){
	    try {
			logGeneral($this,$values,__METHOD__);
	        if (isset($values["view"])){$this->view=$values["view"];}
            if ($values["RECALCULA"]=="S")
            {
                //$query = $this->db->query("select * from SAC_Enca");
                //$error = $this->db->_error_number().': '.$this->db->_error_message();
                $recno1 = $this->execAdHocAsArray("sp_GenerarEstadisticasLotes");
            }
            $sql = "SELECT TOP ".$values["CANTIDAD_CARTAS"]." el.BIMESTRE,el.SECCION,el.SEPULTURA,el.TITULAR,el.ULTBIMPAGO,el.DIRECCION,el.COD_POSTAL,el.LOCALIDAD,el.EMAIL,el.RESPONSABL,el.ENVIADO,el.EMAIL_SEC,el.EMAIL_RES,el.EMAIL_RES_SEC,";

			//Calcular considerando TODOS los sac_movimientos!
			//$sql.=" (el.IMPORTE-(SELECT ISNULL(sum(m.importe),0) FROM SAC_Movimientos as m WHERE seccion=el.SECCION AND sepultura=el.SEPULTURA AND operacion='PC')) as IMPORTE ";

			//Calcular considerando los sac_movimientos del ultimo recibo!
			$sql.="  (el.importe - convert(int,ISNULL(sm.IMPORTE,0))) as IMPORTE ";
			$sql.="  FROM [SAC_EstaLote] as el ";

			//Calcular considerando los sac_movimientos del ultimo recibo!
			$sql.="  LEFT JOIN SAC_Lotes l ON (l.seccion=el.SECCION AND l.sepultura=el.SEPULTURA) ";
  			$sql.="  LEFT JOIN SAC_Movimientos sm ON (l.ACUENTA=sm.NRO_RECIBO AND sm.OPERACION='PC' AND sm.IMPORTE>0) ";

            $sql.="  WHERE (el.BIMESTRE BETWEEN ".$values["DESDE"]." AND ".$values["HASTA"].")";
            if ($values["MODO"]=="S") {$sql.=" AND (isnull(el.email,'')='') ";}
            if ($values["MODO"]=="C"){$sql.=" AND (isnull(el.email,'')!='') ";}
            $sql.=" ORDER BY el.BIMESTRE;";

            log_message('error', 'cco-> pasando x GetNotificacionConservaciones de rubos VIEW es:->'.$sql."<-");

            $notificaciones = $this->execAdHocAsArray($sql);
            $emails="";
            $recno2 = $this->execAdHocAsArray("cleanEmailsTable");
            /*dependiendo las opciones generlo los mails a ser enviados en la tabla*/

            log_message('error', 'cco-> pasando x GetNotificacionConservaciones antes de if para mails');
			log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));

            if ($values["MODO"]=="C" && ($values["DESTINO"]=="C" || $values["DESTINO"]=="X" || $values["DESTINO"]=="Z")) {
                /*generar los mails*/
                 $sql = " SELECT * FROM ModelosNotificaciones where ID=".$values["IDMODELO"];
                 $modelosNotificaciones = $this->execAdHocAsArray($sql);
                 $subject=$modelosNotificaciones[0]["ModeloNotificacionTitulo"];
                 $remitente=$modelosNotificaciones[0]["remitente"];
                 $nombreRemitente=$modelosNotificaciones[0]["NombreRemitente"];
                 foreach($notificaciones as $r){

						log_message("error", "RELATED ".json_encode($r["TOTAL"],JSON_PRETTY_PRINT));

				        $importe=$r["IMPORTE"];
						//log_message("error", "RELATED ".json_encode($r,JSON_PRETTY_PRINT));
				        //$sql="SELECT sum(importe) as saldo FROM SAC_Movimientos where seccion='".$r["SECCION"]."' and sepultura=".$r["SEPULTURA"]." and operacion='PC'";
					    //$acuenta = $this->execAdHocAsArray($sql);
						//$importe=(float)$importe-(float)$acuenta["saldo"];
						//log_message("error", "RELATED ".json_encode($acuenta,JSON_PRETTY_PRINT));


                        $body=$modelosNotificaciones[0]["ModeloNotificacionHtml"];
                        $tit = str_replace("'"," ",$r["TITULAR"]);
                        $tit = str_replace(";"," ",$tit);
                        $body = str_replace("[TITULAR]",str_replace("'"," ",str_replace(";"," ",(str_replace(","," ",$r["TITULAR"])))),$body);
                        $body = str_replace("[DIRECCION]",str_replace("'"," ",str_replace(";"," ",(str_replace(","," ",$r["DIRECCION"])))),$body);
                        $body = str_replace("[LOCALIDAD]",str_replace(";"," ",(str_replace(","," ",$r["LOCALIDAD"]))),$body);
                        $body = str_replace("[COD_POSTAL]",str_replace(";"," ",(str_replace(","," ",$r["COD_POSTAL"]))),$body);
                        $body = str_replace("[SECCION]",str_replace(";"," ",(str_replace(","," ",$r["SECCION"]))),$body);
                        $body = str_replace("[SEPULTURA]",str_replace(";"," ",(str_replace(","," ",$r["SEPULTURA"]))),$body);
                        $vence =  Date("d-m-Y", strtotime($r["ULTBIMPAGO"]));
                        $hoy=date('t-m-Y');
                        //vencimiento
                        $body = str_replace("[VENCIMIENTO]",str_replace(";"," ",(str_replace(","," ",$vence))),$body);
                        //importe
                        $body = str_replace("[IMPORTE]",$importe,$body);
                        //hoy
                        $body = str_replace("[HOY]",str_replace(";"," ",(str_replace(","," ",$hoy))),$body);
                        $destinatario = "";
                        $destinatario_sec = "";
                        $destinatario2 = "";
                        $destinatario2sec = "";
                        if ($values["QUIEN"]=="T" || $values["QUIEN"] == "I"){
                            $destinatario = $r["EMAIL"];
                            $destinatario_sec = $r["EMAIL_SEC"];
                            log_message('error', 'cco-> pasando x GetNotificacionConservaciones EN FOREACH destinatario: '.$destinatario.' sec '.$destinatario_sec);
                            if ($destinatario!="")
                            {
                                $sp = "EXEC sp_emails '".$remitente."','".$destinatario."','".$subject."','".$body."','".$tit."','".$nombreRemitente."'";
                                $recnon = $this->execAdHocAsArray($sp);
                                log_message('error', 'cco-> pasando x GetNotificacionConservaciones DESPUES EXEC SP EMAIL');
                            }

                            if ($destinatario_sec!="" && $destinatario_sec != $destinatario)
                            {
                                log_message('error', 'cco-> pasando x GetNotificacionConservaciones EN SEC MAIL EN FOREACH dest !=vacio');

                                $sp = "EXEC sp_emails '".$remitente."','".$destinatario_sec."','".$subject."','".$body."','".$tit."','".$nombreRemitente."'";
                                $recnon = $this->execAdHocAsArray($sp);

                                log_message('error', 'cco-> pasando x GetNotificacionConservaciones  SEC MAIL DESPUES EXEC SP EMAIL');
                            }
                        }

                        if ($values["QUIEN"]=="T" || $values["QUIEN"] == "R")
                        {
                            $destinatario2 = $r["EMAIL_RES"];
                            $destinatario2sec = $r["EMAIL_RES_SEC"];
                            $tit = str_replace("'"," ",$r["RESPONSABL"]);
                            $tit = str_replace(";"," ",$tit);
                            log_message('error', 'cco-> pasando x GetNotificacionConservaciones EN FOREACH destinatario: '.$destinatario.' sec '.$destinatario_sec);
                            if ($destinatario2!="" && $destinatario2 != $destinatario && $destinatario2 != $destinatario_sec)
                            {
                                log_message('error', 'cco-> pasando x GetNotificacionConservaciones EN FOREACH dest !=vacio');
                                $sp = "EXEC sp_emails '".$remitente."','".$destinatario2."','".$subject."','".$body."','".$tit."','".$nombreRemitente."'";
                                $recnon = $this->execAdHocAsArray($sp);
                                log_message('error', 'cco-> pasando x GetNotificacionConservaciones DESPUES EXEC SP EMAIL');
                            }

                            if ($destinatario2sec!="" && $destinatario2sec != $destinatario2  && $destinatario2sec != $destinatario && $destinatario2sec != $destinatario_sec )
                            {
                                log_message('error', 'cco-> pasando x GetNotificacionConservaciones EN SEC MAIL EN FOREACH dest !=vacio');
                                $sp = "EXEC sp_emails '".$remitente."','".$destinatario2sec."','".$subject."','".$body."','".$tit."','".$nombreRemitente."'";
                                $recnon = $this->execAdHocAsArray($sp);
                                log_message('error', 'cco-> pasando x GetNotificacionConservaciones  SEC MAIL DESPUES EXEC SP EMAIL');
                            }
                        }
                 }
                 $emails = $this->execAdHocAsArray("select count(*) as cantidad from  emails");
            }
            //log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetNotificacionConservaciones de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "notificaciones"=>$notificaciones,
                "emails"=>$emails,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetNotificacionRenovaciones($values){
	    try {
			log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
	        logGeneral($this,$values,__METHOD__);
	        if (isset($values["view"])){$this->view=$values["view"];}
            $sql="";
            if    (
					($values["MODO"]=="S" || $values["MODO"]=="T" || $values["MODO"]=="C") 
					&& 
                    ($values["DESTINO"]=="I" || $values["DESTINO"]=="P" || $values["DESTINO"]=="Z")      
                  ) {
                if ($values["DESTINO"] == "Z"){
                       $sql= "SELECT * " ;
                       $sql = $sql." FROM [SAC_Lotes] " ;
                       $sql = $sql." WHERE DEUDA <= 0 and VENCIMIENTO BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}";
                }
                else {
                       $sql= "SELECT * ";
                       $sql = $sql." FROM [SAC_Lotes] " ;
                       $sql = $sql." WHERE VENCIMIENTO  BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}";
                }
            }

            if ($values["DESTINO"]=="C")
            {
                    $sql= "SELECT * " ;
                        $sql = $sql."FROM [SAC_Lotes] " ;
                        $sql = $sql."WHERE isnull(email,'')='' AND VENCIMIENTO BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}";
            }
            if ($values["DESTINO"]=="X")
            {
                    $sql="SELECT * " ;
                         $sql = $sql."FROM [SAC_Lotes] " ;
                         $sql = $sql."WHERE VENCIMIENTO BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}";
            }
			log_message("error", "RELATED ".json_encode($sql,JSON_PRETTY_PRINT));

            $notificaciones = $this->execAdHocAsArray($sql);
            $emails="";
            $recno2 = $this->execAdHocAsArray("cleanEmailsTable");
            /*dependiendo las opciones generlo los mails a ser enviados en la tabla*/
            
			if (($values["MODO"]=="C" || $values["MODO"]=="T") && ($values["DESTINO"]=="Z" || $values["DESTINO"]=="X")) {
                 /*generar los mails*/
                 $sql = " SELECT * FROM ModelosNotificaciones where ID=".$values["IDMODELO"];
                 $modelosNotificaciones = $this->execAdHocAsArray($sql);
                 $subject=$modelosNotificaciones[0]["ModeloNotificacionTitulo"];
                 $remitente=$modelosNotificaciones[0]["remitente"];
                 $nombreRemitente=$modelosNotificaciones[0]["NombreRemitente"];
                 foreach($notificaciones as $r){
                        $body=$modelosNotificaciones[0]["ModeloNotificacionHtml"];
                        $body = str_replace("[ANOSRENOVA]",str_replace(";"," ",(str_replace(","," ",$r["ANOSRENOVA"]))),$body);
                        $body = str_replace("[NROTITULO]",str_replace(";"," ",(str_replace(","," ",$r["NROTITULO"]))),$body);
                        $body = str_replace("[TITULAR]",str_replace(";"," ",(str_replace(","," ",$r["TITULAR"]))),$body);
                        $body = str_replace("[DIRECCION]",str_replace(";"," ",(str_replace(","," ",$r["DIRECCION"]))),$body);
                        $body = str_replace("[LOCALIDAD]",str_replace(";"," ",(str_replace(","," ",$r["LOCALIDAD"]))),$body);
                        $body = str_replace("[COD_POSTAL]",str_replace(";"," ",(str_replace(","," ",$r["COD_POSTAL"]))),$body);
                        $body = str_replace("[SECCION]",str_replace(";"," ",(str_replace(","," ",$r["SECCION"]))),$body);
                        $body = str_replace("[SEPULTURA]",str_replace(";"," ",(str_replace(","," ",$r["SEPULTURA"]))),$body);
                        $vence =  Date("d-m-Y", strtotime($r["VENCIMIENTO"]));
                        $hoy=date('t-m-Y');

                        //vencimiento
                        $body = str_replace("[VENCIMIENTO]",str_replace(";"," ",(str_replace(","," ",$vence))),$body);
                        //importe
                        $body = str_replace("[IMPORTE]",$r["IMPORTE"],$body);
                        //hoy
                        $body = str_replace("[HOY]",str_replace(";"," ",(str_replace(","," ",$hoy))),$body);
                        $tit = str_replace("'"," ",$r["TITULAR"]);
                        $tit = str_replace(";"," ",$tit);
                        $destinatario = "";
                        $destinatario2 = "";
                        $destinatariosec = "";
                        $destinatario2sec = "";

                        if ($values["QUIEN"]=="T" || $values["QUIEN"] == "I") {
                            $destinatario = $r["EMAIL"];
                            $destinatariosec = $r["EMAIL_SEC"];
                            if ($destinatario!=""){
                                $sp = "EXEC sp_emails '".$remitente."','".$destinatario."','".$subject."','".$body."','".$tit."','".$nombreRemitente."'";
                                $recnon = $this->execAdHocAsArray($sp);
                            }
                            if ($destinatariosec!="" && $destinatariosec!=$destinatario){
                                $sp = "EXEC sp_emails '".$remitente."','".$destinatariosec."','".$subject."','".$body."','".$tit."','".$nombreRemitente."'";
                                $recnon = $this->execAdHocAsArray($sp);
                            }
                        }
                        if ($values["QUIEN"]=="T" || $values["QUIEN"] == "R") {
                            $destinatario2 = $r["RES_EMAIL"];
                            $destinatario2sec = $r["RES_EMAIL_SEC"];
                            $res = str_replace("'"," ",$r["RESPONSABL"]);
                            $res = str_replace(";"," ",$res);
                            if ($destinatario2 !="" && $destinatario2 != $destinatario && $destinatario2 != $destinatariosec){
                                $sp = "EXEC sp_emails '".$remitente."','".$destinatario2."','".$subject."','".$body."','".$res."','".$nombreRemitente."'";
                                $recnon = $this->execAdHocAsArray($sp);
                            }    
                            if ($destinatario2sec!=""  && $destinatario2sec!=$destinatario2 && $destinatario2sec!=$destinatario && $destinatario2sec!=$destinatariosec){
                                $sp = "EXEC sp_emails '".$remitente."','".$destinatario2sec."','".$subject."','".$body."','".$res."','".$nombreRemitente."'";
                                $recnon = $this->execAdHocAsArray($sp);
                            }    
                        }
                 }
                 $emails = $this->execAdHocAsArray("select count(*) as cantidad from  emails");
            }
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "notificaciones"=>$notificaciones,
                "emails"=>$emails,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function recibos($values){
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
    public function notificacion_conservaciones($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            $sql = " SELECT ID,ModeloNotificacionNombre FROM ModelosNotificaciones union select 0,'Elija un Modelo de Notificación' ";

            log_message('error', 'cco-> pasando x notificacion_conservaciones de rubos VIEW es:->'.$sql."<-");
            $modelosNotificaciones = $this->execAdHocAsArray($sql);

            $data["modelosNotificaciones"] = $modelosNotificaciones;
            
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
    public function notificacion_renovaciones($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            $sql = " SELECT ID,ModeloNotificacionNombre FROM ModelosNotificaciones union select 0,'Elija un Modelo de Notificación' ";

            log_message('error', 'cco-> pasando x notificacion_conservaciones de rubos VIEW es:->'.$sql."<-");
            $modelosNotificaciones = $this->execAdHocAsArray($sql);

            $data["modelosNotificaciones"] = $modelosNotificaciones;


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
    public function lista_de_precios($values){
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
    public function renovaciones_por_fecha($values){
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
    public function movimiento_caja($values){
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
    public function arrendamientos_por_fecha($values){
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
    public function estadisticas_generales($values){
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
    public function operaciones_tarjetas_credito($values){
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
}
