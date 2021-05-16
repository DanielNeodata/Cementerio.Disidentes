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
	        log_message('error', 'cco-> pasando x GetNotificacionConservaciones de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetNotificacionConservaciones de rubos VIEW es:->'.$values["view"]."<-");

            if ($values["RECALCULA"]=="S")
            {
                log_message('error', 'cco-> pasando x GetNotificacionConservaciones RECALCULA SI');
                //$query = $this->db->query("select * from SAC_Enca");
                //$error = $this->db->_error_number().': '.$this->db->_error_message();
                $recno1 = $this->execAdHocAsArray("sp_GenerarEstadisticasLotes");
                log_message('error', 'cco-> pasando x GetNotificacionConservaciones exec: '.$recno1[0]["RunStatus"]);
            }

            $sql="";

            $sql = "SELECT TOP ".$values["CANTIDAD_CARTAS"]." * FROM [SAC_EstaLote] ";
            $sql = $sql." WHERE (BIMESTRE BETWEEN ".$values["DESDE"]." And ".$values["HASTA"].")";
            if ($values["MODO"]=="S") {
                
                    $sql = $sql." AND (isnull(email,'')='') ";
            }
            if ($values["MODO"]=="C"){
                    $sql = $sql." AND (isnull(email,'')!='') ";
            }
            $sql = $sql." ORDER BY BIMESTRE;";

            log_message('error', 'cco-> pasando x GetNotificacionConservaciones de rubos VIEW es:->'.$sql."<-");

            $notificaciones = $this->execAdHocAsArray($sql);
            $emails="";
            $recno2 = $this->execAdHocAsArray("cleanEmailsTable");
            /*dependiendo las opciones generlo los mails a ser enviados en la tabla*/

            log_message('error', 'cco-> pasando x GetNotificacionConservaciones antes de if para mails');
            if ($values["MODO"]=="C" && ($values["DESTINO"]=="C" || $values["DESTINO"]=="X" || $values["DESTINO"]=="Z"))
            {
                log_message('error', 'cco-> pasando x GetNotificacionConservaciones EN if para mails');
                /*generar los mails*/
                 $sql = " SELECT * FROM ModelosNotificaciones where ID=".$values["IDMODELO"];
                 $modelosNotificaciones = $this->execAdHocAsArray($sql);

                 log_message('error', 'cco-> pasando x GetNotificacionConservaciones MODELOS OBTRENIDOS: '.$sql);


                 
                 $subject=$modelosNotificaciones[0]["ModeloNotificacionTitulo"];
                 $remitente=$modelosNotificaciones[0]["remitente"];

                 log_message('error', 'cco-> pasando x GetNotificacionConservaciones ModeloTitulo: '.$subject);

                 foreach($notificaciones as $r){
                        
                        $destinatario = $r["EMAIL"];
                        log_message('error', 'cco-> pasando x GetNotificacionConservaciones EN FOREACH destinatario: '.$destinatario);
                        
                        if ($destinatario!="")
                        {
                            log_message('error', 'cco-> pasando x GetNotificacionConservaciones EN FOREACH dest !=vacio');

                            $body=$modelosNotificaciones[0]["ModeloNotificacionHtml"];

                            $body = str_replace("[TITULAR]",str_replace("'"," ",str_replace(";"," ",(str_replace(","," ",$r["TITULAR"])))),$body);
                            $body = str_replace("[DIRECCION]",str_replace("'"," ",str_replace(";"," ",(str_replace(","," ",$r["DIRECCION"])))),$body);
                            $body = str_replace("[LOCALIDAD]",str_replace(";"," ",(str_replace(","," ",$r["LOCALIDAD"]))),$body);
                            $body = str_replace("[COD_POSTAL]",str_replace(";"," ",(str_replace(","," ",$r["COD_POSTAL"]))),$body);
                            $body = str_replace("[SECCION]",str_replace(";"," ",(str_replace(","," ",$r["SECCION"]))),$body);
                            $body = str_replace("[SEPULTURA]",str_replace(";"," ",(str_replace(","," ",$r["SEPULTURA"]))),$body);

                            $vence =  Date("d-m-Y", strtotime($r["ULTBIMPAGO"]));
                            
                            $hoy=date('d-m-Y');

                            //vencimiento
                            $body = str_replace("[VENCIMIENTO]",str_replace(";"," ",(str_replace(","," ",$vence))),$body);
                            //importe
                            $body = str_replace("[IMPORTE]",$r["IMPORTE"],$body);
                            //hoy

                            log_message('error', 'cco-> pasando x GetNotificacionConservaciones FECHA: '.$r["ULTBIMPAGO"]."->".$vence);

                            $body = str_replace("[HOY]",str_replace(";"," ",(str_replace(","," ",$hoy))),$body);

                            log_message('error', 'cco-> pasando x GetNotificacionConservaciones FECHA: '.$vence." - ".$hoy." - -".$r["IMPORTE"]);

                            $sp = "EXEC sp_emails '".$remitente."','".$destinatario."','".$subject."','".$body."'";
                            $recnon = $this->execAdHocAsArray($sp);

                            log_message('error', 'cco-> pasando x GetNotificacionConservaciones DESPUES EXEC SP EMAIL');
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
	        log_message('error', 'cco-> pasando x GetNotificacionRenovaciones de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetNotificacionRenovaciones de rubos VIEW es:->'.$values["view"]."<-");


            $sql="";

            if    (
					($values["MODO"]=="S" || $values["MODO"]=="T" || $values["MODO"]=="C") 
					&& 
                    ($values["DESTINO"]=="I" || $values["DESTINO"]=="P" || $values["DESTINO"]=="Z")      
                  )
            {
                /*******************************************************************/

                log_message('error', 'cco-> pasando x GetNotificacionRenovaciones de rubos DESDE es:->'.$values["DESDE"]."<- hasta: ".$values["HASTA"]);
                if ($values["DESTINO"] == "Z")
                {
                
                       $sql= "SELECT VENCIMIENTO, SECCION, SEPULTURA, TITULAR,ISNULL(EMAIL,'') as EMAIL, ISNULL(RES_EMAIL,'') as RES_EMAIL , DIRECCION, LOCALIDAD, COD_POSTAL, ANOSRENOVA, NROTITULO " ;
                       $sql = $sql." FROM [SAC_Lotes] " ;
                       $sql = $sql." WHERE DEUDA <= 0 and VENCIMIENTO BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}";
                }
                else
                {
                
                       $sql= "SELECT VENCIMIENTO, SECCION, SEPULTURA, TITULAR, ISNULL(EMAIL,'') as EMAIL, ISNULL(RES_EMAIL,'') as RES_EMAIL, DIRECCION, LOCALIDAD, COD_POSTAL, ANOSRENOVA, NROTITULO ";
                       $sql = $sql." FROM [SAC_Lotes] " ;
                       $sql = $sql." WHERE VENCIMIENTO  BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}";
                }

                /*********************************************************************/
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


            log_message('error', 'cco-> pasando x GetNotificacionRenovaciones de rubos VIEW es:->'.$sql."<-");

            $notificaciones = $this->execAdHocAsArray($sql);
            $emails="";
            $recno2 = $this->execAdHocAsArray("cleanEmailsTable");
            /*dependiendo las opciones generlo los mails a ser enviados en la tabla*/

            log_message('error', 'cco-> pasando x GetNotificacionRenovaciones antes de if para mails');

            if ($values["MODO"]=="C" && $values["DESTINO"]=="Z")
            {
                log_message('error', 'cco-> pasando x GetNotificacionRenovaciones EN if para mails');
                /*generar los mails*/
                 $sql = " SELECT * FROM ModelosNotificaciones where ID=".$values["IDMODELO"];
                 $modelosNotificaciones = $this->execAdHocAsArray($sql);

                 log_message('error', 'cco-> pasando x GetNotificacionRenovaciones MODELOS OBTRENIDOS: '.$sql);

                 $subject=$modelosNotificaciones[0]["ModeloNotificacionTitulo"];
                 $remitente=$modelosNotificaciones[0]["remitente"];
                 

                 log_message('error', 'cco-> pasando x GetNotificacionRenovaciones ModeloTitulo: '.$subject);

                 foreach($notificaciones as $r){
                        
                 
                        $body=$modelosNotificaciones[0]["ModeloNotificacionHtml"];
                        
       
                        log_message('error', 'cco-> pasando x GetNotificacionRenovaciones EN FOREACH dest !=vacio');

                        $body = str_replace("[ANOSRENOVA]",str_replace(";"," ",(str_replace(","," ",$r["ANOSRENOVA"]))),$body);
                        $body = str_replace("[NROTITULO]",str_replace(";"," ",(str_replace(","," ",$r["NROTITULO"]))),$body);

                        $body = str_replace("[TITULAR]",str_replace(";"," ",(str_replace(","," ",$r["TITULAR"]))),$body);
                        $body = str_replace("[DIRECCION]",str_replace(";"," ",(str_replace(","," ",$r["DIRECCION"]))),$body);
                        $body = str_replace("[LOCALIDAD]",str_replace(";"," ",(str_replace(","," ",$r["LOCALIDAD"]))),$body);
                        $body = str_replace("[COD_POSTAL]",str_replace(";"," ",(str_replace(","," ",$r["COD_POSTAL"]))),$body);
                        $body = str_replace("[SECCION]",str_replace(";"," ",(str_replace(","," ",$r["SECCION"]))),$body);
                        $body = str_replace("[SEPULTURA]",str_replace(";"," ",(str_replace(","," ",$r["SEPULTURA"]))),$body);

                        $vence =  Date("d-m-Y", strtotime($r["VENCIMIENTO"]));
                            
                        $hoy=date('d-m-Y');

                        //vencimiento
                        $body = str_replace("[VENCIMIENTO]",str_replace(";"," ",(str_replace(","," ",$vence))),$body);
                        //importe
                        $body = str_replace("[IMPORTE]",$r["IMPORTE"],$body);
                        //hoy

                        log_message('error', 'cco-> pasando x GetNotificacionRenovaciones FECHA: '.$r["ULTBIMPAGO"]."->".$vence);

                        $body = str_replace("[HOY]",str_replace(";"," ",(str_replace(","," ",$hoy))),$body);

                        log_message('error', 'cco-> pasando x GetNotificacionRenovaciones FECHA: '.$vence." - ".$hoy." - -".$r["IMPORTE"]);

                        $destinatario = $r["EMAIL"];
                        $destinatario2 = $r["RES_EMAIL"];

                        log_message('error', 'cco-> pasando x GetNotificacionRenovaciones EN FOREACH destinatario: '.$destinatario." dest 2: ".$destinatario2 );

                        if ($destinatario!="")
                        {
                            $sp = "EXEC sp_emails '".$remitente."','".$destinatario."','".$subject."','".$body."'";
                            $recnon = $this->execAdHocAsArray($sp);
                        }
                        
                        if ($destinatario2!="")
                        {
                            $sp = "EXEC sp_emails '".$remitente."','".$destinatario2."','".$subject."','".$body."'";
                            $recnon = $this->execAdHocAsArray($sp);
                        }    

                        

                        log_message('error', 'cco-> pasando x GetNotificacionRenovaciones DESPUES EXEC SP EMAIL');
                        
                 }
                 $emails = $this->execAdHocAsArray("select count(*) as cantidad from  emails");
            }


            //log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetNotificacionRenovaciones de  rubos entre getrecords y return array! ');
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
