<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Funciones_avanzadas extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

     public function GetBalance($values){
	     try {
	        log_message('error', 'cco-> pasando x GetBalance de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetBalance de rubos VIEW es:->'.$values["view"]."<-");

            

            $sql="";


            $sql = "   sp_Balance '".$values["FDESDE"]."','".$values["FHASTA"]."','".$values["CDESDE"]."','".$values["CHASTA"]."','".$values["PREFIJO"]."'";

            log_message('error', 'cco-> pasando x GetBalance de rubos VIEW es:->'.$sql."<-");

            $estadistica = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($estadistica,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetBalance de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "estadistica"=>$estadistica,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetBalanceHistorico($values){
	     try {
	        log_message('error', 'cco-> pasando x GetBalanceHistorico de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetBalanceHistorico de rubos VIEW es:->'.$values["view"]."<-");

            

            $sql="";


            $sql = "   sp_BalanceHistorico '".$values["FDESDE"]."','".$values["FHASTA"]."','".$values["CDESDE"]."','".$values["CHASTA"]."','".$values["PREFIJO"]."',".$values["IDE"]."";

            log_message('error', 'cco-> pasando x GetBalanceHistorico de rubos VIEW es:->'.$sql."<-");

            $estadistica = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($estadistica,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetBalanceHistorico de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "estadistica"=>$estadistica,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetLibroDiario($values){
	    try {
	        log_message('error', 'cco-> pasando x GetLibroDiario de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetLibroDiario de rubos VIEW es:->'.$values["view"]."<-");

            

            $sql="";


            $sql = " select e.NUMERO, e.FECHA, e.COMENTARIO, ";
	        $sql = $sql.= "    r.ASIENTO, Left(r.ASIENTO,2) As qryTC, Right(r.ASIENTO,5) As qryNUM, r.CUENTA, c.NOMBRE as NOMBRE_CUENTA, CASE WHEN IMPORTE>0 THEN IMPORTE ELSE NULL END As qryDeb, CASE WHEN IMPORTE<=0 THEN -IMPORTE ELSE NULL END As qryCre ";
            $sql = $sql.= " from CON_Encabezados e inner join CON_Renglones r on (e.ID=r.idEncabezado ) inner join CON_Cuentas As C ON (c.NUMERO = r.CUENTA)";
            $sql = $sql.= " where  ";
            $sql = $sql.= " (e.FECHA BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}) ";
            $sql = $sql.= " and (e.NUMERO like '".$values["PREFIJO"]."%')";
            $sql = $sql.= " order by e.FECHA,qryNUM,r.RENGLON ";

            

            log_message('error', 'cco-> pasando x GetLibroDiario de rubos VIEW es:->'.$sql."<-");

            $estadistica = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetLibroDiario de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "estadistica"=>$estadistica,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetLibroDiarioHistorico($values){
	    try {
	        log_message('error', 'cco-> pasando x GetLibroDiarioHistorico de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetLibroDiarioHistorico de rubos VIEW es:->'.$values["view"]."<-");

            

            $sql="";

             $sql = " select e.NUMERO, e.FECHA, e.COMENTARIO,";
	         $sql = $sql.= "    r.ASIENTO, Left(r.ASIENTO,2) As qryTC, Right(r.ASIENTO,5) As qryNUM, r.CUENTA, c.NOMBRE as NOMBRE_CUENTA, CASE WHEN IMPORTE>0 THEN IMPORTE ELSE NULL END As qryDeb, CASE WHEN IMPORTE<=0 THEN -IMPORTE ELSE NULL END As qryCre ";
             $sql = $sql.= " from CON_Encabezados_Historico e inner join CON_Renglones_Historico r on (e.NUMERO=r.ASIENTO ) inner join CON_Cuentas_Historico As C ON (c.NUMERO = r.CUENTA)  inner join CON_Configuracion_Historico cfg on (cfg.INICIO=C.DESDE)";
             $sql = $sql.= " where  ";
             $sql = $sql.= " (e.FECHA BETWEEN {d '".$values["DESDE"]."'} AND {d '".$values["HASTA"]."'}) ";
			 $sql = $sql.= " and cfg.ID=".$values["IDE"]."";
			 $sql = $sql.= " and e.DESDE=C.DESDE";
			 $sql = $sql.= " and r.DESDE=C.DESDE";
             $sql = $sql.= " and (e.NUMERO like '".$values["PREFIJO"]."%')";
             $sql = $sql.= " order by e.FECHA,qryNUM,r.RENGLON ";


            log_message('error', 'cco-> pasando x GetLibroDiarioHistorico de rubos VIEW es:->'.$sql."<-");

            $estadistica = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetLibroDiarioHistorico de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "estadistica"=>$estadistica,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}


    public function GetLibroMayor($values){
	    try {
	        log_message('error', 'cco-> pasando x GetLibroMayor de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetLibroMayor de rubos VIEW es:->'.$values["view"]."<-");

            

            $sql="";


            $sql = "   sp_LibroMayor '".$values["FDESDE"]."','".$values["FHASTA"]."','".$values["CDESDE"]."','".$values["CHASTA"]."','".$values["PREFIJO"]."'";

            log_message('error', 'cco-> pasando x GetLibroMayor de rubos VIEW es:->'.$sql."<-");

            $estadistica = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($estadistica,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetLibroMayor de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "estadistica"=>$estadistica,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}


    public function GetLibroMayorHistorico($values){
	    try {
	        log_message('error', 'cco-> pasando x GetLibroMayorHistorico de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetLibroMayorHistorico de rubos VIEW es:->'.$values["view"]."<-");

            

            $sql="";


            $sql = "   sp_LibroMayorHistorico '".$values["FDESDE"]."','".$values["FHASTA"]."','".$values["CDESDE"]."','".$values["CHASTA"]."','".$values["PREFIJO"]."',".$values["IDE"];

            log_message('error', 'cco-> pasando x GetLibroMayorHistorico de rubos VIEW es:->'.$sql."<-");

            $estadistica = $this->execAdHocAsArray($sql);

            log_message("error", "ARRAY values ".json_encode($estadistica,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetLibroMayorHistorico de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "estadistica"=>$estadistica,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function ajuste_inflacion($values){
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
    public function transferencia_resultados($values){
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
    public function cierre_apertura($values){
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
    public function revertir_asientos_automaticos($values){
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
    public function remuneracion($values){
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
    
    public function diario($values){
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
    public function mayor($values){
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
    public function balance($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            log_message('error', 'cco-> pasando x balance de rubos VIEW es:->'.$values["interface"]."<-");

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
