<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Con_cuentas extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function brow($values){
        try {
            $values["order"]="NUMERO ASC";
            $values["records"]=$this->get($values);
            $values["buttons"]=array(
                "new"=>true,
                "edit"=>true,
                "delete"=>false,
                "offline"=>false,
            );

            $values["getters"]=array(
             "search"=>true,
             "googlesearch"=>true,
             "excel"=>true,
             "pdf"=>true,
           );

            $values["columns"]=array(
                //array("field"=>"ID","format"=>"code"),
                array("field"=>"NUMERO","format"=>"number"),
                array("field"=>"NOMBRE","format"=>"text"),
                array("field"=>"TIPOAJUSTE","format"=>"type"),
                array("field"=>"SALDONOMIN","format"=>"number"),
                array("field"=>"SALDOAJUST","format"=>"number"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );
            $values["filters"]=array(
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("NUMERO","NOMBRE")),
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    
    
    public function excel($values){
        try {
            log_message('error', 'cco-> pasando x excel de sac cuentas init!.');
            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}
            $values["view"]="CON_Cuentas";
            $values["delimiter"]=";";
            $values["pagesize"]=-1;
            $values["order"]=" NUMERO ASC";
            $values["records"]=$this->get($values);

            $values["columns"]=array(
               array("field"=>"ID","format"=>"code"),
               array("field"=>"NUMERO","format"=>"text"),
               array("field"=>"NOMBRE","format"=>"text"),

            );

            log_message('error', 'cco-> pasando x excel de sac cuentas end1!.');
            return parent::excel($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function pdf($values){
        try {
            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}
            $values["view"]="CON_Cuentas";
            $values["pagesize"]=-1;
            $values["order"]=" NUMERO ASC";
            $values["records"]=$this->get($values);
            
            $values["title"]="Cuentas: Altas, Bajas, Consultas y Modificaciones";
            $values["columns"]=array(
                //array("field"=>"ID","format"=>"code"),
                array("field"=>"NUMERO","format"=>"text"),
                array("field"=>"NOMBRE","format"=>"text"),
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
            log_message('error', 'cco-> pasando x edit de rubros!.');

            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;
            
            $values["view"]="CON_Cuentas";

            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            //log_message("error", "RECORDS ".json_encode($values["records"],JSON_PRETTY_PRINT));
            
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de RUBROS!.');
        log_message('error', 'cco-> pasando x save de RUBROS! ANTES IF');
        try {
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){

                if($fields==null) {
                    $fields = array(
                        'NUMERO' => $values["NUMERO"],
                        'NOMBRE' => $values["NOMBRE"],
                        'TIPOAJUSTE' => $values["TIPOAJUSTE"],

                        //'TITULAR' => $values["TITULAR"],

                        //{...more fields...}

                    );
                }
            } else {
                //log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
                if($fields==null) {
                    $fields = array(
                        'NUMERO' => $values["NUMERO"],
                        'NOMBRE' => $values["NOMBRE"],
                        'TIPOAJUSTE' => $values["TIPOAJUSTE"],
                    );
                }
            }
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function GetPlanDeCuentasHistoricoByFilter($values){
	    try {
	        log_message('error', 'cco-> pasando x GetPlanDeCuentasHistoricoByFilter de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetPlanDeCuentasHistoricoByFilter de rubos VIEW es:->'.$values["view"]."<-");
            //log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));

	        $values["view"]="CON_Configuracion_Historico";
            $values["where"]=("id=".$values["ID"]);
            $info=$this->get($values);

            $val=$info["data"][0]["INICIO"];
            $fecha = explode(" ", $val);

            log_message('error', 'cco-> pasando x GetPlanDeCuentasHistoricoByFilter de rubos VALOR FCHA INICIO es:->'.$val."<-");
            log_message('error', 'cco-> pasando x GetPlanDeCuentasHistoricoByFilter de rubos VALOR FCHA INICIO es:->'.$fecha[0]."<-");

            $sql = "SELECT NUMERO, NOMBRE, SALDONOMIN, SALDOAJUST, isnull(qryTA,'') as qryTA, ";
            $sql = $sql." REPLICATE('&nbsp;', ( ";
            $sql = $sql." SELECT Count(NRO) * 2";
            $sql = $sql." FROM ((SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Rubros_Historico]  WHERE NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."' AND DESDE={d '".$fecha[0]."'}) UNION ";
            $sql = $sql." (SELECT NUMERO As NRO, NOMBRE As NOM FROM [CON_Cuentas_Historico] WHERE NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."' AND DESDE={d '".$fecha[0]."'})) As S ";
            $sql = $sql." WHERE Left(NUMERO,Len(S.NRO))=S.NRO AND S.NRO<>NUMERO ";
            $sql = $sql." )) As qryIndent ";
            $sql = $sql." FROM ((SELECT NUMERO, NOMBRE, NULL As SALDONOMIN, NULL As SALDOAJUST, NULL As qryTA FROM [CON_Rubros_Historico]  WHERE NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."' AND DESDE={d '".$fecha[0]."'}) UNION ";
            $sql = $sql." (SELECT NUMERO, NOMBRE, SALDONOMIN, SALDOAJUST, CASE WHEN TIPOAJUSTE='A' THEN 'Automático' ELSE (CASE WHEN TIPOAJUSTE='D' THEN 'Directo' ELSE 'Sin Ajuste' END) END As qryTA FROM [CON_Cuentas_Historico] WHERE NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."' AND DESDE={d '".$fecha[0]."'})) As U1 ";
            $sql = $sql." WHERE (U1.NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."') ";
            $sql = $sql." ORDER BY U1.NUMERO";




            log_message('error', 'cco-> pasando x GetPlanDeCuentasHistoricoByFilter de rubos VIEW es:->'.$sql."<-");

            $cuentas = $this->execAdHocAsArray($sql);

            //log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetPlanDeCuentasHistoricoByFilter de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "cuentas"=>$cuentas,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetCuentasHistoricoByFilter($values){
	    try {
	        log_message('error', 'cco-> pasando x GetRubrosByFilter de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetCuentasHistoricoByFilter de rubos VIEW es:->'.$values["view"]."<-");
            //log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));

	        $values["view"]="CON_Configuracion_Historico";
            $values["where"]=("id=".$values["ID"]);
            $info=$this->get($values);

            $val=$info["data"][0]["INICIO"];
            $fecha = explode(" ", $val);

            log_message('error', 'cco-> pasando x GetRubrosHistoricosByFilter de rubos VALOR FCHA INICIO es:->'.$val."<-");
            log_message('error', 'cco-> pasando x GetRubrosHistoricosByFilter de rubos VALOR FCHA INICIO es:->'.$fecha[0]."<-");

            $sql = "SELECT NUMERO, NOMBRE, SALDONOMIN, SALDOAJUST, CASE WHEN TIPOAJUSTE='A' THEN 'Automático' ELSE (CASE WHEN TIPOAJUSTE='D' THEN 'Directo' ELSE 'Sin Ajuste' END) END As qryTA " ;
            $sql = $sql." FROM [CON_Cuentas_Historico] " ;
            $sql = $sql." WHERE (NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."') " ;
            $sql = $sql." AND (DESDE={d '".$fecha[0]."'}) " ;
            $sql = $sql." ORDER BY NUMERO";


            log_message('error', 'cco-> pasando x GetCuentasByFilter de rubos VIEW es:->'.$sql."<-");

            $cuentas = $this->execAdHocAsArray($sql);

            //log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetRubrosByFilter de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "cuentas"=>$cuentas,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetCuentasByFilter($values){
	    try {
	        log_message('error', 'cco-> pasando x GetRubrosByFilter de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetRubrosByFilter de rubos VIEW es:->'.$values["view"]."<-");
            //log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));

	        $values["view"]="vw_SacLotes";
	        $values["pagesize"]=-1;
            $values["where"]=" ID = ".$values["ID"];

	        //$data=$this->get($values);

            $sql = "SELECT NUMERO, NOMBRE, SALDONOMIN, SALDOAJUST, CASE WHEN TIPOAJUSTE='A' THEN 'Automático' ELSE (CASE WHEN TIPOAJUSTE='D' THEN 'Directo' ELSE 'Sin Ajuste' END) END As qryTA ";
            $sql = $sql." FROM [CON_Cuentas] WHERE (NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."') ORDER BY NUMERO";

            log_message('error', 'cco-> pasando x GetCuentasByFilter de rubos VIEW es:->'.$sql."<-");

            $cuentas = $this->execAdHocAsArray($sql);

            //log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetRubrosByFilter de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "cuentas"=>$cuentas,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
	        return logError($e,__METHOD__ );
	    }
	}

    public function GetPlanCuentasByFilter($values){
	    try {
	        log_message('error', 'cco-> pasando x GetPlanCuentasByFilter de rubos init!.');
	        logGeneral($this,$values,__METHOD__);

	        if (isset($values["view"])){$this->view=$values["view"];}

	        log_message('error', 'cco-> pasando x GetPlanCuentasByFilter de rubos VIEW es:->'.$values["view"]."<-");
            //log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));

	        $values["view"]="vw_SacLotes";
	        $values["pagesize"]=-1;
            $values["where"]=" ID = ".$values["ID"];

	        //$data=$this->get($values);

            $sql = "select NUMERO,NOMBRE,SALDONOMIN,SALDOAJUST,TipoAjuste,IndentHtml ";
            $sql = $sql." FROM [vw_SacCuentas] WHERE (NUMERO BETWEEN '".$values["DESDE"]."' AND '".$values["HASTA"]."') ORDER BY NUMERO";

            log_message('error', 'cco-> pasando x GetPlanCuentasByFilter de rubos VIEW es:->'.$sql."<-");

            $cuentas = $this->execAdHocAsArray($sql);

            //log_message("error", "ARRAY values ".json_encode($data,JSON_PRETTY_PRINT));

	        log_message('error', 'cco-> pasando x GetPlanCuentasByFilter de  rubos entre getrecords y return array! ');
	        return array(
	            "code"=>"2000",
	            "status"=>"OK",
	            "message"=>"Records",
                "cuentas"=>$cuentas,
	            "table"=>$this->table,
	            "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT)
	        );
	    }
	    catch(Exception $e) {
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
    public function plan_de_cuentas($values){
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
